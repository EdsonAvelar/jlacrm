<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Equipe;
use App\Models\Fechamento;
use App\Models\User;
use Carbon\Carbon;

class ApiController extends Controller
{
    private function validateToken(Request $request)
    {
        $token = $request->bearerToken();

        $token_webhook = config('token_webhook');


        if (!$token_webhook) {
            return response()->json(['message' => 'Cannot find token on system'], 401);
        }


        if ($token !== $token_webhook) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return null;
    }

    public function getVendas(Request $request)
    {
        // Valida o token antes de processar a requisição
        $tokenValidation = $this->validateToken($request);
        if ($tokenValidation) {
            return $tokenValidation;
        }

        // Obtém os parâmetros da requisição
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $tipo_dados = $request->input('tipo_dados');

        if (!$data_inicio || !$data_fim || !$tipo_dados) {
            return response()->json(['message' => 'Parâmetros inválidos'], 400);
        }

        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

        $output = [];

        // Verifica o tipo de dados solicitado
        if (str_contains($tipo_dados, 'venda_equipe')) {
            $output['equipes'] = $this->getVendasPorEquipe($from, $to);
        }

        if (str_contains($tipo_dados, 'venda_vendedor')) {
            $output['vendedores'] = $this->getVendasPorVendedor($from, $to);
        }

        return response()->json($output);
    }

    private function getVendasPorEquipe($from, $to)
    {
        $equipes = Equipe::all();
        $output = [];

        foreach ($equipes as $equipe) {
            $ids = $equipe->integrantes()->pluck('id')->toArray();

            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']
            ];

            $vendas_totais = (float) Fechamento::where($query)->whereIn('primeiro_vendedor_id', $ids)->sum('valor');

            $valor_meta = (float) config('racing_vendas_equipe', 3000000);

            $user = User::find($equipe->lider_id);

            $equipe_info = [
                'equipe_name' => $equipe->descricao,
                'equipe_logo' => url('') . '/images/equipes/' . $equipe->id . '/' . $equipe->logo,
                'lider_name' => $user ? $user->name : 'N/A',
                'lider_avatar' => $user ? asset($user->avatar) : null,
                'meta' => $valor_meta,
                'total' => $vendas_totais,
                'percentual' => ($valor_meta > 0) ? ($vendas_totais / $valor_meta) * 100 : 0,
            ];

            $output[] = $equipe_info;
        }

        usort($output, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return $output;
    }

    private function getVendasPorVendedor($from, $to)
    {
        $vendedores = User::all();
        $output = [];

        foreach ($vendedores as $vendedor) {
            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA'],
                ['primeiro_vendedor_id', '=', $vendedor->id]
            ];

            $vendas_totais = (float) Fechamento::where($query)->sum('valor');

            $vendedor_info = [
                'vendedor_name' => $vendedor->name,
                'vendedor_avatar' => asset($vendedor->avatar),
                'total' => $vendas_totais,
            ];

            $output[] = $vendedor_info;
        }

        usort($output, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return $output;
    }
}
