<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\User;
use App\Enums\UserStatus;
use Carbon\Carbon;
use App\Models\Fechamento;
use App\Models\Agendamento;
use App\Models\Equipe;

use Validator;
class RankingController extends Controller
{

    public function vendas_ajuda()
    {


        return view('dashboards.ranking.vendas_ajuda');
    }

    public function telemarketing_vendas()
    {
        return view('dashboards.ranking.vendas_telemarketing');
    }

    public function vendas()
    {


        return view('dashboards.ranking.vendas');
    }

    public function agendamentos()
    {
        return view('dashboards.ranking.agendamentos');

    }

    public function ranking_vendas_equipe()
    {

        return view('dashboards.ranking.equipe_vendas');
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

    public function equipes_vendas()
    {

        $data_inicio = config('data_inicio');
        $data_fim = config('data_fim');

        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');


        $output = array();
        $output['equipes'] = array();

        $equipes = Equipe::all();

        foreach ($equipes as $equipe) {
            //array_push($output['equipes'], $equipe->descricao);

            $ids = $equipe->integrantes()->pluck('id')->toArray();

            // #########
            // Fechamento
            // #########
            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']

            ];
            $vendas_totais = (float) Fechamento::where($query)->whereIn('primeiro_vendedor_id', $ids)->sum('valor');

            $valor = (float) config("racing_vendas_equipe");

            if (!$valor) {
                $valor = 3000000;
            }

            $user = User::find($equipe->lider_id);

            $user_info = [
                'equipe_name' => $equipe->descricao,
                'equipe_logo' => url('') . '/images/equipes/' . $equipe->id . '/' . $equipe->logo,
                'lider_name' => $user->name,
                'lider_avatar' => asset($user->avatar),
                'meta' => $valor,
                "total" => $vendas_totais,
                'percentual' => ($vendas_totais / $valor) * 100,

            ];


            array_push($output['equipes'], $user_info);

        }


        usort($output['equipes'], function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });


        return response()->json($output);

    }

    public function colaboradores_vendas()
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

            $avatar = asset("images/sistema/user-padrao.png");
            if (
                $vendedor->avatar
            ) {
                $avatar = $vendedor->avatar;
            }
            $valor = (float) config("racing_vendas_max");

            if (!$valor) {
                $valor = 1000000;
            }

            $user_info = [
                "name" => $vendedor->name,
                "total" => $vendas_totais,
                'meta' => $valor,
                'percentual' => ($vendas_totais / $valor) * 100,
                "avatar" => asset($avatar),
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


    public function colaboradores_vendas_ajuda()
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
                ['segundo_vendedor_id', '=', $vendedor->id],
                ['status', '=', 'FECHADA']
            ];

            $vendas_totais = Fechamento::where($query)->sum('valor');

            $avatar = asset("images/sistema/user-padrao.png");
            if (
                $vendedor->avatar
            ) {
                $avatar = $vendedor->avatar;
            }
            $valor = (float) config("racing_vendas_max");

            if (!$valor) {
                $valor = 1000000;
            }

            $user_info = [
                "name" => $vendedor->name,
                "total" => $vendas_totais,
                'meta' => $valor,
                'percentual' => ($vendas_totais / $valor) * 100,
                "avatar" => asset($avatar),
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

    public function colaboradores_vendas_telemarketing()
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
                ['terceiro_vendedor_id', '=', $vendedor->id],
                ['status', '=', 'FECHADA']
            ];

            $vendas_totais = Fechamento::where($query)->sum('valor');

            $avatar = asset("images/sistema/user-padrao.png");
            if (
                $vendedor->avatar
            ) {
                $avatar = $vendedor->avatar;
            }
            $valor = (float) config("racing_vendas_max");

            if (!$valor) {
                $valor = 1000000;
            }

            $user_info = [
                "name" => $vendedor->name,
                "total" => $vendas_totais,
                'meta' => $valor,
                'percentual' => ($vendas_totais / $valor) * 100,
                "avatar" => asset($avatar),
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
    public function colaboradores_agendamentos()
    {

        $output = array();
        $output['colaboradores'] = array();

        $today = Carbon::now()->format('Y-m-d');

        $cargos = Cargo::where(['nome' => 'Vendedor'])->orWhere(['nome' => 'Coordenador'])->pluck('id');
        $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo])->get();

        $total = 0;
        foreach ($users as $vendedor) {
            $query = [
                ['data_agendamento', '=', $today],
                ['user_id', '=', $vendedor->id],
            ];

            $vendas_totais = Agendamento::where($query)->count();

            $avatar = asset("images/sistema/user-padrao.png");
            if (
                $vendedor->avatar
            ) {
                $avatar = $vendedor->avatar;
            }

            $meta_agen = (int) config("racing_agendamento_max");

            if (!$meta_agen) {
                $meta_agen = 15;
            }

            $user_info = [
                "name" => $vendedor->name,
                "total" => $vendas_totais,
                'meta' => $meta_agen,
                'percentual' => ($vendas_totais / $meta_agen) * 100,
                "avatar" => asset($avatar),
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
