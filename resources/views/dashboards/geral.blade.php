@extends('main')


@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include Date Range Picker -->

<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
    .page-title-box .page-title {
        font-size: 18px;
        margin: 0;
        line-height: 35px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: inherit;
        padding-top: 20px;
    }

    .subtitle {
        margin-top: 1px;
        margin-bottom: 1rem;
        font-family: sans-serif;
        color: rgb(65, 143, 244);
    }

    .strong {
        font-size: 18px;
        font-weight: 700;

    }

    .danger {
        color: red;
    }
</style>
@endsection

@section('main_content')
<!-- Start Content-->
<div class="container-fluid" id="dashboard">

    @include('layouts.alert-msg')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">

                        <div class="input-group">

                            <input class="form-control btn btn-primary" type="text" name="daterange"
                                id="datapicker_dash"
                                value="{{ app('request')->input('data_inicio') }} - {{ app('request')->input('data_fim') }}" />
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="mdi mdi-calendar-range font-13"></i>
                            </span>
                        </div>

                        <a href="{{ route('home', ['data_inicio' => \Carbon\Carbon::now()->format('d/m/Y'), 'data_fim' => \Carbon\Carbon::now()->format('d/m/Y')]) }}"
                            type="button" style="margin-left: 10px;" class="btn btn-success">HOJE</a>
                    </form>
                </div>
                @if ( !((app('request')->input('data_inicio') == \Carbon\Carbon::now()->format('d/m/Y') ) &
                (app('request')->input('data_fim') == \Carbon\Carbon::now()->format('d/m/Y') ))
                )
                <h4 class="page-title">Dashboard - Geral</h4>

                @if ( isset($output['producao']) && ($output['producao']))
                <p class="subtitle">Produção: <span class="strong">{{ $output['producao']['name'] }}</span> - Inicio:
                    <span class="strong">{{
                        $output['producao']['start_date'] }} </span>Fim: <span class="strong">{{
                        $output['producao']['end_date'] }}</span>

                    @if (!$output['producao']['dentro'])
                    <span class="badge bg-danger">*Dia de Hoje está fora do intervalo da Produção!</span>
                    @endif

                </p>


                @endif


                @else

                <h4 class="page-title" style="color: rgb(89, 0, 184)">Dashboard - Geral - HOJE</h1>
                    @endif
            </div>
        </div>
    </div>

    <!-- end page title -->

    <div class="row">

        @include('dashboards.views.card', [
        'card_name' => 'Negócios Ativos',
        'card_value' => $stats['leads_ativos'],
        'card_porc' => '1%',
        'card_icon' =>'fa-briefcase'
        ])

        @include('dashboards.views.card', [
        'card_name' => 'Vendas em Aprovação',
        'card_href' => route('negocios.aprovacoes'),
        'card_value' => "R$ " . number_format($stats['potencial_venda'], 2, ',', '.'),
        'card_porc' => '4%',
        'card_icon' =>'fa-chart-line'
        ])

        @include('dashboards.views.card', [
        'card_name' => 'Vendas em Conclusão',
        'card_href' => route('vendas.lista', ['data_inicio' => app('request')->input('data_inicio'), 'data_fim'
        =>app('request')->input('data_fim')]),
        'card_value' => "R$ " . number_format($stats['rascunho_totais'], 2, ',', '.'),
        'card_porc' => '4%',
        'card_icon' =>'fa-shopping-cart'
        ])

        @include('dashboards.views.card', [
        'card_name' => 'Total Vendido',
        'card_href' => route('vendas.lista', ['data_inicio' => app('request')->input('data_inicio'), 'data_fim'
        =>app('request')->input('data_fim')]),
        'card_value' => "R$ " . number_format($stats['total_vendido'], 2, ',', '.'),
        'card_porc' => '3%',
        'card_icon' =>'fa-dollar-sign'
        ])




        {{-- @include('dashboards.views.card', [
        'card_name' => 'Leads Sem Dono',
        'card_value' => $output['lead_novos'],
        'card_porc' => '5%',
        'card_href' => route('pipeline_index', [
        'id' => 1,
        'proprietario' => \Auth::user()->id,
        'view' => 'list',
        'proprietario' => '-1',
        'status' => 'ativo',
        ]),
        ]) --}}


        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['oportunidades'])." Oportunidades",
        'name' => 'Oportunidades',
        'plots' => [$output['vendedores'], $output['oportunidades']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['agendamentos'])." Agendamentos",
        'name' => 'Agendamentos',
        'plots' => [$output['vendedores'], $output['agendamentos']],
        ])



        @if ( app('request')->input('data_inicio') == app('request')->input('data_fim') )

        <?php  
                $vendedores_hoje = $output['vendedores'];
                $vendedores_amanha = $output['vendedores'];
                $agendados_hoje = $output['agendados_hoje'];
                $agendados_amanha = $output['agendados_amanha'];
      
                array_multisort($agendados_hoje,SORT_DESC,$vendedores_hoje);
                array_multisort($agendados_amanha,SORT_DESC,$vendedores_amanha);
               
           
            ?>


        @include('dashboards.views.bar_plot', [
        'title' => array_sum($agendados_hoje).' Agendamentos Para Hoje: '.app('request')->input('data_inicio'),
        'name' => 'Agendamentos Para Hoje',
        'plots' => [$vendedores_hoje, $agendados_hoje],
        'horizontal' => true
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($agendados_amanha).' Agendamentos Para Amanhã: '.\Carbon\Carbon::createFromFormat('d/m/Y',
        app('request')->input('data_inicio'))->addDay()->format('d/m/Y'),
        'name' => 'Agendamentos Para Amanha',
        'plots' => [$vendedores_amanha, $agendados_amanha],
        'horizontal' => true
        ])

        @else

        {{-- Gráficos de Hoje e Amanhã só são mostrados se o botão de hoje não tiver sido pressionado --}}
        <?php  

            $vendedores_medio = $output['vendedores'];
            $agendados_medio = $output['agendados_medio'];

            $vendedores_reuniao = $output['vendedores'];
            $reunioes_medio = $output['reunioes_medio'];

            array_multisort($agendados_medio,SORT_DESC,$vendedores_medio);
            array_multisort($reunioes_medio,SORT_DESC,$vendedores_reuniao);

            $inicio = \Carbon\Carbon::createFromFormat('d/m/Y', app('request')->input('data_inicio'));
            $fim = \Carbon\Carbon::createFromFormat('d/m/Y', app('request')->input('data_fim'));

            $dias_uteis = $inicio->diffInWeekdays($fim);
        
        ?>

        @include('dashboards.views.bar_plot', [
        'title' => 'Agendamentos Médio nos últimos '.$dias_uteis.' dias úteis',
        'name' => 'Agendamentos Medio Por dia',
        'plots' => [$vendedores_medio, $agendados_medio],
        'horizontal' => true,
        ])



        @include('dashboards.views.bar_plot', [
        'title' => 'Reunião Média nos últimos '.$dias_uteis.' dias úteis',
        'name' => 'Reuniao Medio Por dia',
        'plots' => [$vendedores_reuniao, $reunioes_medio],
        'horizontal' => true,
        ])


        @endif

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['reunioes'])." Reuniões",
        'name' => 'Reuniões',
        'plots' => [$output['vendedores'], $output['reunioes']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['propostas'])." Propostas",
        'name' => 'Propostas',
        'plots' => [$output['vendedores'], $output['propostas']],
        ])

        @include('dashboards.views.bar_plot', [
        'title' => array_sum($output['aprovacoes'])." Aprovações",
        'name' => 'Aprovações',
        'plots' => [$output['vendedores'], $output['aprovacoes']],
        ])

        @include('dashboards.views.bar_plot_zerofree', [
        'title' => "Vendas ("."R$ " . number_format(array_sum($output['vendas']), 2, ',', '.').")",
        'name' => 'Vendas Totais',
        'plots' => [$output['vendedores'], $output['vendas']],
        'filterzero' => config("grafico_exibir_zerados")
        ])



        @if (Auth::user()->hasAnyRole(['admin']))
        @include('dashboards.views.bar_plot_zerofree', [
        'title' => "Vendas Modo Ajuda ("."R$ " . number_format(array_sum($output['vendas_2']), 2, ',', '.').")",
        'name' => 'Vendas Modo Ajuda',
        'plots' => [$output['vendedores'], $output['vendas_2']],
        'filterzero' => config("grafico_exibir_zerados")
        ])

        @include('dashboards.views.bar_plot_zerofree', [
        'title' => "Vendas Telemarketing ("."R$ " . number_format(array_sum($output['vendas_telemarketing']), 2, ',',
        '.').")",
        'name' => 'Vendas Telemarketing',
        'plots' => [$output['vendedores'], $output['vendas_telemarketing']],
        'filterzero' => config("grafico_exibir_zerados")
        ])

        @endif




        @include('dashboards.views.donuts', [
        'name' => 'Vendas Porcentagem',
        'plots' => [$output['vendedores'], $output['vendas']],
        ])


        @include('dashboards.views.stacked', [
        'name' => 'Conversão de Agendamentos',
        'plots' => [$output['vendedores'], $output['agendamentos_faltou'],$output['agendamentos_realizado']],
        'symbol' => "%"
        ])


        @include('dashboards.views.bar_comp_plot', [
        'name' => 'Reuniões x Faltas',
        'plots' => [$output['vendedores'], $output['agendamentos_faltou'],$output['agendamentos_realizado']],
        'symbol' => "%"
        ])


        @include('dashboards.views.donuts', [
        'title' => array_sum($output['agendamentos_realizado'])." Reuniões Concretizadas",
        'name' => 'Reuniões Concretizadas',
        'plots' => [$output['vendedores'], $output['agendamentos_realizado']],
        ])



        @include('dashboards.views.funnel', ['name' => 'Funil', 'plots' => $output['stats']])



    </div>

</div> <!-- container -->
@endsection

@section('specific_scripts')
<script>
    $(document).ready(function() {


            $('#datapicker_dash').daterangepicker({
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                },
                function(start, end, label) {
                    //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                    window.location.href = "{{ url('crm?') }}" + "data_inicio=" + start.format('DD/MM/YYYY') +
                        "&" + "data_fim=" + end.format('DD/MM/YYYY') + "&custom_date=true";

                });


        });
</script>
@endsection