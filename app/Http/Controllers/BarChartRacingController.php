<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserStatus;
use Carbon\Carbon;
use App\Models\Fechamento;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Agendamento;

class BarChartRacingController extends Controller
{

    public function vendas()
    {
        return view('dashboards.views.bar_racing_vendas');
    }

    public function agendamentos()
    {
        return view('dashboards.views.bar_racing_agendamentos');
    }
    public function index2(Request $request)
    {

        $output = array();

        $data_inicio = config('data_inicio');
        $data_fim = config('data_fim');


        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        if (is_null($data_inicio) and is_null($data_fim)) {

            $dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
            if ($dia <= 20) {
                $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
            } else {
                $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
            }

            $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }

        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

        $cargos = Cargo::where(['nome' => 'Vendedor'])->orWhere(['nome' => 'Coordenador'])->pluck('id');
        $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo])->get();

        // $metricas = [
        //     'vendedores',
        //     'vendas',
        // ];

        // foreach ($metricas as $metrica) {
        //     $output[$metrica] = array();
        // }


        foreach ($users as $vendedor) {
            #array_push($output['vendedores'], $vendedor->name);

            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['primeiro_vendedor_id', '=', $vendedor->id]
            ];

            $vendas_totais = Fechamento::where($query)->sum('valor');

            $user_info = [
                "name" => $vendedor->name,
                "sales" => $vendas_totais,
                "image" => "https://placehold.co/600x400.png"

            ];

            array_push($output, $user_info);
        }


        return view('dashboards.views.barChartRacing', compact('output'));
    }


    public function vendas_get(Request $request)
    {
        $output = array();


        $data_inicio = config('data_inicio');
        $data_fim = config('data_fim');


        // $data_inicio = $request->query('data_inicio');
        // $data_fim = $request->query('data_fim');

        // if (is_null($data_inicio) and is_null($data_fim)) {

        //     $dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
        //     if ($dia <= 20) {
        //         $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
        //     } else {
        //         $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
        //     }

        //     $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
        //     return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        // }

        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

        $cargos = Cargo::where(['nome' => 'Vendedor'])->orWhere(['nome' => 'Coordenador'])->pluck('id');
        $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo])->get();


        foreach ($users as $vendedor) {
            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['primeiro_vendedor_id', '=', $vendedor->id]
            ];

            $vendas_totais = Fechamento::where($query)->sum('valor');

            $user_info = [
                "name" => $vendedor->name,
                "sales" => $vendas_totais,
                "image" => url('') . '/images/users/user_' . $vendedor->id . '/' . $vendedor->avatar

            ];

            array_push($output, $user_info);
        }

        return $output;
    }


    public function agendamentos_get(Request $request)
    {
        $output = array();


        $data_inicio = config('data_inicio');
        $data_fim = config('data_fim');


        // $data_inicio = $request->query('data_inicio');
        // $data_fim = $request->query('data_fim');

        // if (is_null($data_inicio) and is_null($data_fim)) {

        //     $dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
        //     if ($dia <= 20) {
        //         $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
        //     } else {
        //         $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
        //     }

        //     $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
        //     return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        // }

        #$from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        $cargos = Cargo::where(['nome' => 'Vendedor'])->orWhere(['nome' => 'Coordenador'])->pluck('id');
        $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo])->get();


        foreach ($users as $vendedor) {

            $query = [
                ['data_agendamento', '=', $today],
                ['user_id', '=', $vendedor->id],
            ];

            $count = Agendamento::where($query)->count();

            $user_info = [
                "name" => $vendedor->name,
                "sales" => $count,
                "image" => url('') . '/images/users/user_' . $vendedor->id . '/' . $vendedor->avatar

            ];

            array_push($output, $user_info);
        }

        return $output;
    }
}
