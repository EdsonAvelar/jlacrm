@extends('main')



@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">


<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="{{ url('') }}/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        /* max-width: 1200px;
        margin: auto; */
        background-color: #fff;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    thead tr:nth-child(1) th {
        background-color: #333;
    }

    thead tr:nth-child(2) th {
        background-color: #666;
        color: #fff;
    }

    thead tr:nth-child(3) th {
        background-color: #4CAF50;
        color: #fff;
    }

    td:nth-child(2),
    td:nth-child(5) {
        background-color: #e7f7e7;
    }

    td:nth-child(3),
    td:nth-child(6) {
        color: green;
        font-weight: bold;
    }

    td[colspan="3"] {
        text-align: center;
        font-weight: bold;
        background-color: #333;
        color: white;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    tfoot th,
    tfoot td {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }

    .warning {
        background-color: #c6c905 !important;
        color: rgb(79, 78, 78) !important;
    }
</style>
@endsection
@section('main_content')


<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                        </li>
                    </ul>
                </div>
                <h4 class="page-title">Vendas Plantadas</h4>
            </div>
        </div>

        {{-- <div class="col-sm-2">
            <input class="form-control btn btn-primary" type="text" name="daterange"
                value="{{ app('request')->input('data_inicio') }} - {{ app('request')->input('data_fim') }}" />
        </div> --}}

    </div>

    <form id="target" action="{{ url('negocios/changemassive') }}" method="POST">
        @csrf
        <div class="row" id="printarea">
            <div class="col-12">
                <div class="card">
                    <div class="card-body left">

                        {{-- <div class="row">
                            <div class="col-md-4" style="padding: 0px;">
                                <table id="" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3">EQUIPE CORINGAS</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">CLIENTES FECHADOS</th>
                                        </tr>
                                        <tr>
                                            <th>CONSULTOR</th>
                                            <th>CLIENTE</th>
                                            <th>CRÉDITO</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Gabriel</td>
                                            <td>José</td>
                                            <td>R$ 350.000,00</td>

                                        </tr>
                                        <tr>
                                            <td>LARISSA</td>
                                            <td>Rafael</td>
                                            <td>R$ 353.441,97</td>

                                        </tr>

                                        <tr>
                                            <th colspan="2">TOTAL FECHADO</th>
                                            <td colspan="1">R$ 1.806.883,94</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8" style="padding: 0px;">


                                <table id="" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background-color: white;border: 0px;">*</th>
                                        </tr>

                                        <tr>
                                            <th colspan="3">CLIENTES PLANTADOS</th>
                                            <th rowspan="2">OBSERVAÇÃO</th>
                                        </tr>

                                        <tr>

                                            <th class="warning">CONSULTOR</th>
                                            <th class="warning">CLIENTE</th>
                                            <th class="warning">CRÉDITO</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>Lari</td>
                                            <td>Vera</td>
                                            <td>R$ 250.000,00</td>
                                            <td>CLIENTE ESTÁ PENSANDO EM VOLTAR ATÉ SÁBADO DIA 27/07</td>
                                        </tr>
                                        <tr>

                                            <td>Gabriel</td>
                                            <td>Rafaelli</td>
                                            <td>R$ 353.441,97</td>
                                            <td>CLIENTE JÁ FOI NA DUBAI E FICOU DE RETORNAR DEPOIS DE VER OPÇÕES
                                            </td>
                                        </tr>
                                        <tr>

                                            <td>Gabriel</td>
                                            <td>Rafaelli</td>
                                            <td>R$ 353.441,97</td>
                                            <td>CLIENTE JÁ FOI NA DUBAI E FICOU DE RETORNAR DEPOIS DE VER OPÇÕES
                                            </td>
                                        </tr>

                                        <tr>
                                            <th colspan="2" class="warning">TOTAL PLANTADO</th>
                                            <td colspan="1">R$ 1.806.883,94</td>

                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div> --}}

                        @foreach ( $dados as $name => $equipes)

                        @foreach ( $equipes['aprovados'] as $fechados)



                        <div class="row">
                            <div class="col-md-4" style="padding: 0px;">
                                <table id="" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3">EQUIPE {{ strtoupper($name) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">CLIENTES FECHADOS</th>
                                        </tr>
                                        <tr>
                                            <th>CONSULTOR</th>
                                            <th>CLIENTE</th>
                                            <th>CRÉDITO</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total_fechados = 0;
                                        ?>
                                        @foreach ( $equipes['fechados'] as $fechados)

                                        <tr>
                                            <td>{{$fechados['vendedor']}}</td>
                                            <td>{{$fechados['cliente']}}</td>
                                            <td>R$ {{ number_format( (float)$fechados['credito'], 2, ',', '.') }}</td>
                                            <?php 
                                                $total_fechados = $total_fechados + (float)$fechados['credito'];
                                            ?>

                                        </tr>

                                        @endforeach


                                        <tr>
                                            <th colspan="2">TOTAL FECHADO</th>
                                            <td colspan="1">R$ {{ number_format($total_fechados, 2, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8" style="padding: 0px;">


                                <table id="" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background-color: white;border: 0px;">*</th>
                                        </tr>

                                        <tr>
                                            <th colspan="3">CLIENTES PLANTADOS</th>
                                            <th rowspan="2">OBSERVAÇÃO</th>
                                        </tr>

                                        <tr>

                                            <th class="warning">CONSULTOR</th>
                                            <th class="warning">CLIENTE</th>
                                            <th class="warning">CRÉDITO</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                                                            $total_aprovados = 0;
                                                                            ?>
                                        @foreach ( $equipes['aprovados'] as $aprovados)

                                        <tr>
                                            <td>{{$aprovados['vendedor']}}</td>
                                            <td>{{$aprovados['cliente']}}</td>
                                            <td>R$ {{ number_format( $aprovados['credito'], 2, ',', '.') }} </td>

                                            <td>Comentario</td>
                                            <?php $total_aprovados = $total_aprovados + (float)$aprovados['credito'];?>

                                        </tr>

                                        @endforeach




                                        <tr>
                                            <th colspan="2" class="warning">TOTAL PLANTADO</th>
                                            <td colspan="1">R$ {{ number_format($total_aprovados, 2, ',', '.') }}</td>

                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>

                        @endforeach




                        <br><br><br>
                        @endforeach



                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->

                <!-- end col-->
            </div>
            <!-- end row -->

        </div>

        <!-- Modal -->


        <input type="text" name="id" hidden value="1">
        <input type="text" name="modo" id="modo" hidden value="">
        <input type="text" name="funil_id" id="funil_id" hidden value="1">
        <input type="text" name="curr_funil_id" id="curr_funil_id" hidden value="1">
    </form>


</div>

@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script src="{{ url('') }}/js/jquery.timepicker.min.js"></script>


<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {

          
            let example = $('#example').DataTable({
                pageLength: 100
            });

            let selectall = false;





        });
</script>


<script>
    $(document).ready(function() {

        

            $('.timedatapicker').timepicker({
                'timeFormat': 'H:i'
            });
            $('.timedatapicker').timepicker('setTime', new Date());

            $('.agendamento').datepicker({
                orientation: 'top',
                todayHighlight: true,
                format: "dd/mm/yyyy",
                timeFormat: "HH:mm:ss",
                defaultDate: +1
            });
  

        });



        $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            },
            function(start, end, label) {

                var param = getUrlParameter('agendado');

                //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                window.location.href = "{{ url('agendamento/lista?') }}" + "data_inicio=" + start.format(
                        'DD/MM/YYYY') +
                    "&" + "data_fim=" + end.format('DD/MM/YYYY') + "&agendado=" + param;

            });


  
</script>


@endsection