<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\User;
use App\Enums\UserStatus;
use Carbon\Carbon;
use App\Models\Fechamento;
use Validator;
class RankingController extends Controller
{

    public function home()
    {
        return view('dashboards.ranking');
    }

    public function ranking_premiacoes(Request $request)
    {

        $input = $request->all();

        $rules = array(
            'image' => 'required|mimes:png|max:2048',
        );

        $error_msg = [
            'image.required' => 'Imagem é Obrigatório',
            'image.max' => 'Limite Máximo do Arquivo 2mb',
            'image.mimes' => 'extensões válidas (png)'
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $pasta_imagem = $input['pasta_imagem'];
        $imagem_name = $input['imagem_name'];


        $destino = public_path('images') . "/ranking/user/" . $pasta_imagem . "";

        $request->image->move($destino, $imagem_name);


        return back()->with("status", "Imagem salva com sucesso");
    }


    public function colaboradores()
    {

        $output = array();
        $output['colaboradores'] = array();

        $data_inicio = config('data_inicio');
        $data_fim = config('data_fim');

        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

        $cargos = Cargo::where(['nome' => 'Vendedor'])->orWhere(['nome' => 'Coordenador'])->pluck('id');
        $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo])->get();


        $total = 0;
        foreach ($users as $vendedor) {
            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['primeiro_vendedor_id', '=', $vendedor->id],
                ['status', '=', 'FECHADA']
            ];

            $vendas_totais = Fechamento::where($query)->sum('valor');

            $avatar = url("") . "/images/users/avatars/user-padrao.png";
            if (
                $vendedor->avatar
            ) {
                $avatar = url('') . '/images/users/user_' . $vendedor->id . '/' . $vendedor->avatar;
            }

            $user_info = [
                "name" => $vendedor->name,
                "total" => $vendas_totais,
                'meta' => 1500000,
                'percentual' => ($vendas_totais / 1500000) * 100,
                "avatar" => $avatar,
            ];

            if ($vendedor->equipe) {
                $user_info["equipe_name"] = $vendedor->equipe->descricao;
                $user_info["equipe_logo"] = url('') . '/images/equipes/' . $vendedor->equipe->id . '/' . $vendedor->equipe->logo;
            }

            $total = $total + $vendas_totais;

            array_push($output['colaboradores'], $user_info);
        }

        $output['total_vendas'] = $total;

        usort($output['colaboradores'], function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });


        return response()->json($output);
    }
}
