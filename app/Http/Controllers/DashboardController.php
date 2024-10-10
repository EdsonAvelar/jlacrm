<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Proposta;
use Auth;
use Illuminate\Http\Request;
use App\Enums\NegocioStatus;
use App\Enums\UserStatus;
use Carbon\Carbon;
use App\Models\Negocio;
use App\Models\Fechamento;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Reuniao;
use App\Models\Aprovacao;
use App\Models\Equipe;
use App\Models\Simulacao;
use H;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function nformat($num)
    {
        if ($num > 1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('K', 'M', 'B', 'T');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $num;
    }

    public function dashboard_equipes(Request $request)
    {

        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        if (is_null($data_inicio) and is_null($data_fim)) {

            if (config('data_inicio') & config('data_fim')) {
                $data_inicio = config('data_inicio');
                $data_fim = config('data_fim');
            } else {


                $dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
                if ($dia <= 20) {
                    $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
                } else {
                    $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
                }

                $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
            }
            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }


        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');


        $output = [];
        $output['oportunidades'] = [];
        $output['agendados_medio'] = [];
        $output['agendamentos'] = [];
        $output['agendados_hoje'] = [];
        $output['agendados_amanha'] = [];
        $output['reunioes'] = [];
        $output['reunioes_medio'] = [];
        $output['aprovacoes'] = [];
        $output['vendas'] = [];
        $output['propostas'] = [];

        $stats = [];

        $output['equipes'] = [];

        $equipes = Equipe::all();

        foreach ($equipes as $equipe) {
            array_push($output['equipes'], $equipe->descricao);

            // #########
            // Oportunidade
            // #########
            $ids = $equipe->integrantes()->pluck('id')->toArray();
            $query = [
                ['data_criacao', '>=', $from],
                ['data_criacao', '<=', $to]

            ];
            $sql = Negocio::where($query)->whereIn('user_id', $ids)->toSql();

            $count = Negocio::where($query)->whereIn('user_id', $ids)->count();
            array_push($output['oportunidades'], $count);

            // #########
            // Agendamentos
            // #########

            $query = [
                ['data_agendamento', '>=', $from],
                ['data_agendamento', '<=', $to],

            ];

            $count = Agendamento::where($query)->whereIn('user_id', $ids)->count();
            array_push($output['agendamentos'], $count);

            // #########
            // Agendamento Médio por Dia
            // #########

            $inicio = Carbon::createFromFormat('d/m/Y', $data_inicio);
            $fim = Carbon::createFromFormat('d/m/Y', $data_fim);

            $dias_uteis = $inicio->diffInWeekdays($fim);

            $media_agendamentos = $dias_uteis > 0 ? $count / $dias_uteis : 0; // Evita divisão por zero

            array_push($output['agendados_medio'], $media_agendamentos);




            // #########
            // Agendados para hoje
            // #########

            #$hoje = Carbon::now()->format('Y-m-d');
            $hoje = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
            $query = [
                ['data_agendado', '>=', $hoje],
                ['data_agendado', '<=', $hoje],

            ];

            $count = Agendamento::where($query)->whereIn('user_id', $ids)->count();
            array_push($output['agendados_hoje'], $count);


            // #########
            // Agendados para Amanhã
            // #########

            #$amanha = Carbon::now()->addDay()->format('Y-m-d');
            $amanha = Carbon::createFromFormat('d/m/Y', $data_inicio)->addDay()->format('Y-m-d');
            $query = [
                ['data_agendado', '>=', $amanha],
                ['data_agendado', '<=', $amanha],

            ];

            $count = Agendamento::where($query)->whereIn('user_id', $ids)->count();
            array_push($output['agendados_amanha'], $count);

            // #########
            // reunioes
            // #########

            $query = [
                ['data_reuniao', '>=', $from],
                ['data_reuniao', '<=', $to],

            ];

            $count = Reuniao::where($query)->whereIn('user_id', $ids)->count();
            array_push($output['reunioes'], $count);


            $inicio = Carbon::createFromFormat('d/m/Y', $data_inicio);
            $fim = Carbon::createFromFormat('d/m/Y', $data_fim);

            $dias_uteis = $inicio->diffInWeekdays($fim);

            $reunioes_medio = $dias_uteis > 0 ? $count / $dias_uteis : 0; // Evita divisão por zero

            array_push($output['reunioes_medio'], $reunioes_medio);


            // #########
            // Proposta
            // #########
            $query = [
                ['data_proposta', '>=', $from],
                ['data_proposta', '<=', $to],
            ];

            //$count = Proposta::where($query)->whereIn('user_id', $ids)->count();


            $count_proposta = Proposta::where($query)->whereIn('user_id', $ids)->count();
            $count_multiproposta = Simulacao::where($query)->whereIn('user_id', $ids)->count();

            $count = $count_proposta + $count_multiproposta;


            array_push($output['propostas'], $count);


            // #########
            // Aprovacao
            // #########
            $query = [
                ['data_aprovacao', '>=', $from],
                ['data_aprovacao', '<=', $to],

            ];

            $count = Aprovacao::where($query)->whereIn('user_id', $ids)->count();
            array_push($output['aprovacoes'], $count);

            // #########
            // Fechamento
            // #########
            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']

            ];
            $vendas_totais = Fechamento::where($query)->whereIn('primeiro_vendedor_id', $ids)->sum('valor');

            array_push($output['vendas'], $vendas_totais);

        }

        return view('dashboards.equipes', compact('output'));
    }

    public function dashboard_semanas(Request $request)
    {

        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        if (is_null($data_inicio) and is_null($data_fim)) {

            if (config('data_inicio') & config('data_fim')) {
                $data_inicio = config('data_inicio');
                $data_fim = config('data_fim');
            } else {


                $dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
                if ($dia <= 20) {
                    $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
                } else {
                    $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
                }

                $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
            }
            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }


        $from = Carbon::createFromFormat('d/m/Y', $data_inicio);
        $to = Carbon::createFromFormat('d/m/Y', $data_fim);


        $count_weeks = $from->diffInWeeks($to);


        $output = [];
        $output['oportunidades'] = [];
        $output['agendamentos'] = [];
        $output['reunioes'] = [];
        $output['aprovacoes'] = [];
        $output['vendas'] = [];
        $output['propostas'] = [];


        $output['weeks'] = [];

        $weeks = [];
        for ($i = 0; $i < $count_weeks; $i = $i + 1) {

            $startWeek = Carbon::now()->subWeek($i)->startOfWeek()->format('Y-m-d');
            $endWeek = Carbon::now()->subWeek($i)->endOfWeek()->format('Y-m-d');

            array_unshift($weeks, [$startWeek, $endWeek]);
        }


        foreach ($weeks as $week) {

            $from_label = Carbon::createFromFormat('Y-m-d', $week[0])->format('d/m');
            $to_label = Carbon::createFromFormat('Y-m-d', $week[1])->format('d/m');
            ;

            array_push($output['weeks'], $from_label . " - " . $to_label);

            $from = $week[0];
            $to = $week[1];
            // #########
            // Oportunidade
            // #########
            $query = [
                ['data_criacao', '>=', $from],
                ['data_criacao', '<=', $to]

            ];


            $count = Negocio::where($query)->count();
            array_push($output['oportunidades'], $count);


            // #########
            // Agendamento
            // #########
            $query = [
                ['data_agendamento', '>=', $week[0]],
                ['data_agendamento', '<=', $week[1]],

            ];

            $count = Agendamento::where($query)->count();
            array_push($output['agendamentos'], $count);

            // #########
            // reunioes
            // #########

            $query = [
                ['data_reuniao', '>=', $from],
                ['data_reuniao', '<=', $to],

            ];

            $count = Reuniao::where($query)->count();
            array_push($output['reunioes'], $count);




            // #########
            // Proposta
            // #########
            $query = [
                ['data_proposta', '>=', $from],
                ['data_proposta', '<=', $to],
            ];

            // $count = Proposta::where($query)->count();
            $count_proposta = Proposta::where($query)->count();
            $count_multiproposta = Simulacao::where($query)->count();

            $count = $count_proposta + $count_multiproposta;

            
            array_push($output['propostas'], $count);

            // #########
            // Aprovacao
            // #########
            $query = [
                ['data_aprovacao', '>=', $from],
                ['data_aprovacao', '<=', $to],

            ];

            $count = Aprovacao::where($query)->count();
            array_push($output['aprovacoes'], $count);

            // #########
            // Fechamento
            // #########
            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']

            ];
            $vendas_totais = Fechamento::where($query)->sum('valor');

            array_push($output['vendas'], $vendas_totais);

        }

        return view('dashboards.semanas', compact('output'));
    }

    public function dashboard(Request $request)
    {

        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');


        if (is_null($data_inicio) and is_null($data_fim)) {

            if (config('data_inicio') & config('data_fim')) {
                $data_inicio = config('data_inicio');
                $data_fim = config('data_fim');
            } else {
                $dia = intval(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d'));
                if ($dia <= 20) {
                    $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
                } else {
                    $data_inicio = "20/" . (Carbon::now('America/Sao_Paulo')->format('m/Y'));
                }

                $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');

            }

            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }


        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

        $query = [
            ['data_agendado', '>=', $from],
            ['data_agendado', '<=', $to],
        ];

        $agendamentos = Agendamento::where($query)->get();


        foreach ($agendamentos as $agendamento) {
            if ($agendamento->reuniao) {

                $agendamento['status'] = 'REUNIAO_REALIZADA';

            } else {

                $date = Carbon::createFromFormat('Y-m-d', $agendamento->data_agendado);
                $now = Carbon::now('America/Sao_Paulo');
                $last_update = $date->diffInDays($now, false);

                if ($date->isToday()) {
                    $agendamento['status'] = 'REUNIAO_HOJE';
                } elseif ($date->isTomorrow()) {
                    $agendamento['status'] = 'AMANHA';
                } elseif ($last_update > 0) {
                    $agendamento['status'] = 'FALTOU';
                } else {
                    $agendamento['status'] = 'AGENDADA';
                }
            }

            $agendamento->save();
        }


        if (Auth::user()->hasRole('admin')) {

            $output = array();

            $stats = [];


            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']
            ];

            $vendas_totais = Fechamento::where($query)->sum('valor');


            $stats['total_vendido'] = $vendas_totais;//Fechamento::whereBetween('data_fechamento', [$from, $to])->sum('valor');



            $stats['leads_ativos'] = Negocio::where('status', NegocioStatus::ATIVO)->count();

            $totalValor = DB::table('negocios')
                ->join('users', 'negocios.user_id', '=', 'users.id')
                ->where('negocios.etapa_funil_id', 5)
                ->where('negocios.status', NegocioStatus::ATIVO)
                ->where('users.status', UserStatus::ativo) // Certifique-se de que `UsuarioStatus::ATIVO` é o status ativo para o usuário
                ->sum('negocios.valor');

            $stats['potencial_venda'] = $totalValor;//Negocio::where('status', NegocioStatus::ATIVO)->sum('valor');

            $stats['sum_oportunidades'] = 0;
            $stats['sum_agendamentos'] = 0;

            $stats['sum_reunioes'] = 0;
            $stats['sum_aprovacoes'] = 0;
            $stats['sum_propostas'] = 0;
            $stats['sum_vendas'] = 0;

            $cargos = Cargo::where(['nome' => 'Vendedor'])->orWhere(['nome' => 'Coordenador'])->pluck('id');
            $users = User::whereIn('cargo_id', $cargos)->where(['status' => UserStatus::ativo])->get();

            $metricas = [
                'vendedores',
                'oportunidades',
                'agendamentos',
                'reunioes',
                'reunioes_medio',
                'aprovacoes',
                'vendas',
                'propostas',
                'agendamentos_faltou_perc',
                'agendamentos_faltou',
                'agendamentos_realizado',
                'agendados_hoje',
                'agendados_amanha',
                'agendados_medio'
            ];

            foreach ($metricas as $metrica) {
                $output[$metrica] = array();
            }

            foreach ($users as $vendedor) {
                array_push($output['vendedores'], $vendedor->name);

                $query = [
                    ['data_criacao', '>=', $from],
                    ['data_criacao', '<=', $to],
                    ['user_id', '=', $vendedor->id],
                    ['status', '=', 'ativo']
                ];

                $count = Negocio::where($query)->count();
                array_push($output['oportunidades'], $count);

                $stats['sum_oportunidades'] = $stats['sum_oportunidades'] + $count;


                $query = [
                    ['data_agendado', '>=', $from],
                    ['data_agendado', '<=', $to],
                    ['status', '=', 'FALTOU'],
                    ['user_id', '=', $vendedor->id]
                ];

                $count_faltou = Agendamento::where($query)->count();

                $query = [
                    ['data_agendado', '>=', $from],
                    ['data_agendado', '<=', $to],
                    ['status', '=', 'REUNIAO_REALIZADA'],
                    ['user_id', '=', $vendedor->id]
                ];

                $count_realizados = Agendamento::where($query)->count();

                if (($count_realizados + $count_faltou) > 0) {
                    array_push($output['agendamentos_faltou_perc'], ($count_faltou / ($count_realizados + $count_faltou)) * 100);
                } else {
                    array_push($output['agendamentos_faltou_perc'], 0);
                }


                array_push($output['agendamentos_faltou'], $count_faltou);
                array_push($output['agendamentos_realizado'], $count_realizados);


                $query = [
                    ['data_agendamento', '>=', $from],
                    ['data_agendamento', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Agendamento::where($query)->count();
                array_push($output['agendamentos'], $count);

                $inicio = Carbon::createFromFormat('d/m/Y', $data_inicio);
                $fim = Carbon::createFromFormat('d/m/Y', $data_fim);

                $dias_uteis = $inicio->diffInWeekdays($fim);

                $media_agendamentos = $dias_uteis > 0 ? $count / $dias_uteis : 0; // Evita divisão por zero

                array_push($output['agendados_medio'], $media_agendamentos);

                $stats['sum_agendamentos'] = $stats['sum_agendamentos'] + $count;


                // #########
                // Agendados para hoje
                // #########

                #$hoje = Carbon::now()->format('Y-m-d');
                $hoje = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
                $query = [
                    ['data_agendado', '=', $hoje],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Agendamento::where($query)->count();
                array_push($output['agendados_hoje'], $count);


                // #########
                // Agendados para Amanhã
                // #########

                #$amanha = Carbon::now()->addDay()->format('Y-m-d');
                $amanha = Carbon::createFromFormat('d/m/Y', $data_inicio)->addDay()->format('Y-m-d');

                $query = [
                    ['data_agendado', '=', $amanha],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Agendamento::where($query)->count();
                array_push($output['agendados_amanha'], $count);



                $query = [
                    ['data_reuniao', '>=', $from],
                    ['data_reuniao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];



                $count = Reuniao::where($query)->count();
                array_push($output['reunioes'], $count);
                $stats['sum_reunioes'] = $stats['sum_reunioes'] + $count;

                $inicio = Carbon::createFromFormat('d/m/Y', $data_inicio);
                $fim = Carbon::createFromFormat('d/m/Y', $data_fim);

                $dias_uteis = $inicio->diffInWeekdays($fim);

                $reunioes_medio = $dias_uteis > 0 ? $count / $dias_uteis : 0; // Evita divisão por zero

                array_push($output['reunioes_medio'], $reunioes_medio);




                $query = [
                    ['data_aprovacao', '>=', $from],
                    ['data_aprovacao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Aprovacao::where($query)->count();

                array_push($output['aprovacoes'], $count);
                $stats['sum_aprovacoes'] = $stats['sum_aprovacoes'] + $count;

                $query = [
                    ['data_fechamento', '>=', $from],
                    ['data_fechamento', '<=', $to],
                    ['primeiro_vendedor_id', '=', $vendedor->id],
                    ['status', '=', 'FECHADA']
                ];

                $vendas_totais = Fechamento::where($query)->sum('valor');

                array_push($output['vendas'], $vendas_totais);

                $count = Fechamento::where($query)->count();
                $stats['sum_vendas'] = $stats['sum_vendas'] + $count;

                $query = [
                    ['data_proposta', '>=', $from],
                    ['data_proposta', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                $count_proposta = Proposta::where($query)->count();
                $count_multiproposta = Simulacao::where($query)->count();

                $count = $count_proposta + $count_multiproposta;

                array_push($output['propostas'], $count);
                $stats['sum_propostas'] = $stats['sum_propostas'] + $count;
            }


            $stats['funil'] = [$stats['sum_oportunidades'], $stats['sum_agendamentos'], $stats['sum_reunioes'], $stats['sum_propostas'], $stats['sum_aprovacoes'], $stats['sum_vendas']];
            $lead_novos = Negocio::where(['user_id' => NULL, 'status' => 'ativo'])->count();

            $output['lead_novos'] = $lead_novos;
            $output['stats'] = $stats;

            return view('dashboards.geral', compact('stats', 'lead_novos', 'output'));
        } else if (Auth::user()->hasRole('gerenciar_equipe')) {

            $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

            $ids = [];

            if ($equipe) {
                $ids = $equipe->integrantes()->pluck('id')->toArray();
            }

            array_push($ids, \Auth::user()->id);

            $output = array();
            $stats = [];

            $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']
            ];


            $stats['total_vendido'] = Fechamento::whereIn('primeiro_vendedor_id', $ids)->where($query)->sum('valor');
            $stats['leads_ativos'] = Negocio::whereIn('user_id', $ids)->where('status', NegocioStatus::ATIVO)->count();
            $stats['potencial_venda'] = Negocio::whereIn('user_id', $ids)->where('status', NegocioStatus::ATIVO)->sum('valor');


            $stats['sum_oportunidades'] = 0;
            $stats['sum_agendamentos'] = 0;
            $stats['sum_reunioes'] = 0;
            $stats['sum_aprovacoes'] = 0;
            $stats['sum_propostas'] = 0;
            $stats['sum_vendas'] = 0;


            $users = User::whereIn('id', $ids)->where(['status' => UserStatus::ativo])->get();

            $output = array();
            $metricas = [
                'vendedores',
                'oportunidades',
                'agendamentos',
                'agendados_medio',
                'reunioes_medio',
                'reunioes',
                'aprovacoes',
                'vendas',
                'propostas',
                'agendamentos_faltou_perc',
                'agendamentos_faltou',
                'agendamentos_realizado',
                'agendados_hoje',
                'agendados_amanha'
            ];

            foreach ($metricas as $metrica) {
                $output[$metrica] = array();
            }

            foreach ($users as $vendedor) {

                array_push($output['vendedores'], $vendedor->name);

                $query = [
                    ['data_criacao', '>=', $from],
                    ['data_criacao', '<=', $to],
                    ['user_id', '=', $vendedor->id],
                    ['status', '=', 'ativo']
                ];

                $count = Negocio::where($query)->count();
                array_push($output['oportunidades'], $count);
                $stats['sum_oportunidades'] = $stats['sum_oportunidades'] + $count;



                $query = [
                    ['data_agendado', '>=', $from],
                    ['data_agendado', '<=', $to],
                    ['status', '=', 'FALTOU'],
                    ['user_id', '=', $vendedor->id]
                ];

                $count_faltou = Agendamento::where($query)->count();

                $query = [
                    ['data_agendado', '>=', $from],
                    ['data_agendado', '<=', $to],
                    ['status', '=', 'REUNIAO_REALIZADA'],
                    ['user_id', '=', $vendedor->id]
                ];

                $count_realizados = Agendamento::where($query)->count();

                if (($count_realizados + $count_faltou) > 0) {
                    array_push($output['agendamentos_faltou_perc'], ($count_faltou / ($count_realizados + $count_faltou)) * 100);
                } else {
                    array_push($output['agendamentos_faltou_perc'], 0);
                }


                array_push($output['agendamentos_faltou'], $count_faltou);
                array_push($output['agendamentos_realizado'], $count_realizados);


                $query = [
                    ['data_agendamento', '>=', $from],
                    ['data_agendamento', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Agendamento::where($query)->count();

                array_push($output['agendamentos'], $count);
                $stats['sum_agendamentos'] = $stats['sum_agendamentos'] + $count;

                // #########
                // Agendados para hoje
                // #########

                #$hoje = Carbon::now()->format('Y-m-d');
                $hoje = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
                $query = [
                    ['data_agendado', '=', $hoje],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Agendamento::where($query)->count();
                array_push($output['agendados_hoje'], $count);


                // #########
                // Agendados para Amanhã
                // #########

                #$amanha = Carbon::now()->addDay()->format('Y-m-d');
                $amanha = Carbon::createFromFormat('d/m/Y', $data_inicio)->addDay()->format('Y-m-d');

                $query = [
                    ['data_agendado', '=', $amanha],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Agendamento::where($query)->count();
                array_push($output['agendados_amanha'], $count);



                $query = [
                    ['data_reuniao', '>=', $from],
                    ['data_reuniao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];



                // #########
                // Agendamento Médio por Dia
                // #########

                $inicio = Carbon::createFromFormat('d/m/Y', $data_inicio);
                $fim = Carbon::createFromFormat('d/m/Y', $data_fim);

                $dias_uteis = $inicio->diffInWeekdays($fim);

                $agendados_medio = $dias_uteis > 0 ? $count / $dias_uteis : 0; // Evita divisão por zero

                array_push($output['agendados_medio'], $agendados_medio);


                $query = [
                    ['data_reuniao', '>=', $from],
                    ['data_reuniao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Reuniao::where($query)->count();
                array_push($output['reunioes'], $count);
                $stats['sum_reunioes'] = $stats['sum_reunioes'] + $count;

                // #########
                // Agendamento Médio por Dia
                // #########


                $reunioes_medio = $dias_uteis > 0 ? $count / $dias_uteis : 0; // Evita divisão por zero

                array_push($output['reunioes_medio'], $reunioes_medio);


                $query = [
                    ['data_aprovacao', '>=', $from],
                    ['data_aprovacao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                $count = Aprovacao::where($query)->count();
                $stats['sum_vendas'] = $stats['sum_vendas'] + $count;

                array_push($output['aprovacoes'], $count);
                $stats['sum_aprovacoes'] = $stats['sum_aprovacoes'] + $count;

                $query = [
                    ['data_fechamento', '>=', $from],
                    ['data_fechamento', '<=', $to],
                    ['primeiro_vendedor_id', '=', $vendedor->id],
                    ['status', '=', 'FECHADA']
                ];

                $vendas_totais = Fechamento::where($query)->sum('valor');

                array_push($output['vendas'], $vendas_totais);

                $query = [
                    ['data_proposta', '>=', $from],
                    ['data_proposta', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];

                //$__propostas = Proposta::where($query)->count();

                $count_proposta = Proposta::where($query)->count();
                $count_multiproposta = Simulacao::where($query)->count();

                $count = $count_proposta + $count_multiproposta;

                array_push($output['propostas'], $count);
                $stats['sum_propostas'] = $stats['sum_propostas'] + $count;

            }

            $lead_novos = Negocio::whereIn('user_id', $ids)->where(['etapa_funil_id' => 1, 'status' => 'ativo'])->count();


            $stats['funil'] = [$stats['sum_oportunidades'], $stats['sum_agendamentos'], $stats['sum_reunioes'], $stats['sum_propostas'], $stats['sum_aprovacoes'], $stats['sum_vendas']];


            $output['lead_novos'] = $lead_novos;
            $output['stats'] = $stats;

            return view('dashboards.geral', compact('stats', 'lead_novos', 'output'));
        } else {
            return redirect(route('pipeline_index', array('id' => 1, 'proprietario' => \Auth::user()->id, 'status' => 'ativo')));
        }
    }
}
