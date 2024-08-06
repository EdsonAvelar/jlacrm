@extends('main')

@section('headers')

<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="{{ url('') }}/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    /* body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    } */

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: #fff;

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


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body left">

                    @foreach ( $dados as $name => $equipes)
                    

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

                                            
                                            $maximo = max(count($equipes['fechados']), count( $equipes['aprovados'] ) );
                                           
                                            $rows = 0;

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

                                    <?php $rows = $rows + 1; ?>
                                    @endforeach

                                   

                                    @if ($rows < $maximo) @for ($i=0; $i < $maximo - $rows; $i++) <tr>
                                        <td><span></span></td>
                                        <td><span style="color: white">|</span></td>
                                        <td><span></span></td>
                                        </tr>

                                        @endfor

                                        @endif


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
                                            $maximo = max(count($equipes['fechados']), count( $equipes['aprovados'] ) );
                                            
                                            $rows = 0;
                                                                                ?>
                                    @foreach ( $equipes['aprovados'] as $aprovados)

                                    <tr>
                                        <td>{{$aprovados['vendedor']}}</td>
                                        <td>{{$aprovados['cliente']}}</td>
                                        <td>R$ {{ number_format( (float)$aprovados['credito'], 2, ',', '.') }} </td>

                                        <td>Comentario</td>
                                        <?php $total_aprovados = $total_aprovados + (float)$aprovados['credito'];?>
                                    </tr>

                                    <?php $rows = $rows + 1; ?>
                                    @endforeach


                                    @if ($rows < $maximo) @for ($i=0; $i < $maximo - $rows; $i++) <tr>
                                        <td><span></span></td>
                                        <td><span style="color: white">|</span></td>
                                        <td><span></span></td>
                                        </tr>

                                        @endfor

                                        @endif


                                        <tr>
                                            <th colspan="2" class="warning">TOTAL PLANTADO</th>
                                            <td colspan="1">R$ {{ number_format($total_aprovados, 2, ',', '.') }}</td>

                                            <td></td>
                                        </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>



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





</div>

@endsection