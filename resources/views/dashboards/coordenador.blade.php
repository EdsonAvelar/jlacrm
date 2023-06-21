@extends('main')


@section('headers')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Include Date Range Picker -->

<link href="{{url('')}}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
@endsection

@section('main_content')

<!-- Start Content-->
<div class="container-fluid">
    @include('layouts.alert-msg')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group"> 
                            <input class="form-control btn btn-primary" type="text" name="daterange" id="datapicker_dash" value="{{app('request')->input('data_inicio')}} - {{app('request')->input('data_fim')}}" />

                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="mdi mdi-calendar-range font-13"></i>
                            </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
        
    </div>

    <!-- end page title -->

    <div class="row">
       
        @include('dashboards.views.card',['card_name'=>'Negócios Ativos','card_value' => $stats['leads_ativos'], 'card_porc'=>'1%'] )

        @include('dashboards.views.card',['card_name'=>'Total Vendido','card_value' => "R$ ".number_format($stats['total_vendido'],2, ',', '.'), 'card_porc'=>'3%'] )

        @include('dashboards.views.card',['card_name'=>'Potencial de Venda','card_value' => "R$ ".number_format($stats['potencial_venda'],2, ',', '.'), 'card_porc'=>'4%'] )

        @include('dashboards.views.card',['card_name'=>'Leads Parados','card_value' => $output['lead_novos'], 'card_porc'=>'5%',
        'card_href' => route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id, 'view' => 'list','proprietario'=> '-1', 'status'=>'ativo' ) )
        ] ) 
        
        @include('dashboards.views.bar_plot',['name'=>'Agendamentos','plots'=> [ $output['vendedores'], $output['agendamentos']]])

        @include('dashboards.views.bar_plot',['name'=>'Reuniões','plots'=> [ $output['vendedores'], $output['reunioes']]])

        @include('dashboards.views.bar_plot',['name'=>'Propostas','plots'=> [ $output['vendedores'], $output['propostas']]])

        @include('dashboards.views.bar_plot',['name'=>'Aprovações','plots'=> [ $output['vendedores'], $output['aprovacoes']]])

        @include('dashboards.views.bar_plot',['name'=>'Vendas','plots'=> [ $output['vendedores'], $output['vendas']]])
        
    </div>  

</div> <!-- container -->


@endsection

@section('specific_scripts')

<script>

$(document).ready(function () {
    
  
    $('#datapicker_dash').daterangepicker(
        {
            locale: {
            format: 'DD-MM-YYYY'
            }
        }, 
        function(start, end, label) {
            //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
            window.location.href = "{{url('crm?')}}"+"data_inicio="+start.format('DD/MM/YYYY')+"&"+"data_fim="+end.format('DD/MM/YYYY');

    });

    
});

</script>

@endsection