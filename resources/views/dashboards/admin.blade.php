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
        <div class="col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Negócios Ativos</h5>
                            <h3 class="my-2 py-1">{{$stats['leads_ativos']}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 3.27%</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="campaign-sent-chart" data-colors="#727cf5"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="New Leads">Total Vendido</h5>
                            <h3 class="my-2 py-1">R$ {{ number_format($stats['total_vendido'],2)}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 5.38%</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="new-leads-chart" data-colors="#0acf97"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Deals">Potencial de Venda</h5>
                            <h3 class="my-2 py-1">R$ {{ number_format($stats['potencial_venda'],2)}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                            </p>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">
                            <a href="{{route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id, 'view' => 'list','proprietario'=> '-1' ) )}}">Lead Novos</a> 
                        </h5>
                            <h3 class="my-2 py-1">{{$lead_novos}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 11.7%</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="booked-revenue-chart" data-colors="#0acf97"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">Agendamentos</h5>
                        <div class="col-12">
                            <div class="text-end">
                                
                                <div id="chart_agendamentos">
                                </div>

                            </div>
                        </div>

                      
                    </div> <!-- end row-->

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        
        <div class="col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">Reuniões</h5>
                        <div class="col-12">
                            <div class="text-end">
                                
                                <div id="chart_reunioes">
                                </div>

                            </div>
                        </div>

                      
                    </div> <!-- end row-->

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        
        <div class="col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">Aprovacaoes</h5>
                        <div class="col-12">
                            <div class="text-end">
                                
                                <div id="chart_aprovacoes">
                                </div>

                            </div>
                        </div>

                      
                    </div> <!-- end row-->

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->


    </div>

   

</div> <!-- container -->


@endsection

@section('specific_scripts')

<script>

$(document).ready(function () {

    var options = {
        chart: {
            type: 'bar'
        },
        series: [{
            name: 'agendamento',
            data: <?php echo json_encode($agendamentos) ?> ,
            
        }],
        xaxis: {
            categories: <?php echo json_encode($vendedores) ?>
        },
        plotOptions: {
            bar: {
            distributed: true
            }
        }  
    }

    var chart1 = new ApexCharts(document.querySelector("#chart_agendamentos"), options);
    chart1.render();

    var options = {
        chart: { type: 'bar'        },
        series: [{
            name: 'reunioes',
            data: <?php echo json_encode($reunioes) ?> ,
        }],
        xaxis: {categories: <?php echo json_encode($vendedores) ?>},
        plotOptions: {
            bar: {
            distributed: true
            }
        }  
    }

    var chart2 = new ApexCharts(document.querySelector("#chart_reunioes"), options);
    chart2.render();

    var options = {
        chart: { type: 'bar'        },
        series: [{
            name: 'aprovacoes',
            data: <?php echo json_encode($aprovacoes) ?> ,
        }],
        xaxis: {categories: <?php echo json_encode($vendedores) ?>},
        plotOptions: {
            bar: {
            distributed: true
            }
        }  
    }

    var chart3 = new ApexCharts(document.querySelector("#chart_aprovacoes"), options);
    chart3.render();







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