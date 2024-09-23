@extends('main')

<?php
use App\Models\User;
use App\Enums\VendaStatus;
?>

@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">


<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3);
        /* IE */
        -moz-transform: scale(1.3);
        /* FF */
        -webkit-transform: scale(1.3);
        /* Safari and Chrome */
        -o-transform: scale(1.3);
        /* Opera */
        padding: 10px;
    }

    #info_label {
        padding: 10px;
        color: #000080;
    }

    .mdi-18px {
        font-size: 18px;
    }

    .mdi-24px {
        font-size: 24px;
    }

    .mdi-36px {
        font-size: 36px;
    }

    .mdi-48px {
        font-size: 48px;
    }

    i.icon-success {
        color: green;
    }

    i.icon-danger {
        color: red;
    }

    .badge {
        padding: 0.5em 0.4em !important;
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
                <h4 class="page-title">Gerenciamento de Vendas</h4>
            </div>
        </div>

        <div class="col-md-4">

            <input class="form-control btn btn-primary" type="text" name="daterange"
                value="{{ app('request')->input('data_inicio') }} - {{ app('request')->input('data_fim') }}" />

        </div>

    </div>

    <div class="row">

        <div class="col-12">


            @if (isset($vendas) && !$vendas->isEmpty() )
            <div class="card">
                <div class="card-body left">
                    <h2 class="text-success title">VENDAS FECHADAS</h2>

                    <table id="example" class="table w-100 nowrap">
                        <thead>
                            <tr class="table-light">
                                <th>Cliente </th>
                                <th>Contrato </th>
                                <th>Vendedor Principal </th>
                                <th>Vendedor Secundário</th>
                                <th>Data Fechamento</th>
                                <th>Primeira Assembleia</th>
                                <th>Valor</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                                        $vendas_fechadas = 0;
                                                     
                                                        ?>

                            @foreach ($vendas as $venda)

                            @if ($venda->negocio)
                            <tr>
                                <td><a href="{{ route('negocio_fechamento', ['id' => $venda->negocio->id]) }}">{{
                                        $venda->negocio->lead->nome }}</a>
                                </td>
                                <td><a href="">{{ $venda->numero_contrato }}</a>
                                </td>

                                <td>{{ User::find($venda->primeiro_vendedor_id)->name }}</td>
                                <td>
                                    @if ($venda->segundo_vendedor_id)
                                    {{ User::find($venda->segundo_vendedor_id)->name }}
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($venda['data_fechamento'])->format('d/m/Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($venda['data_primeira_assembleia'])->format('d/m/Y') }}
                                </td>
                                <td>R$ {{ number_format((float) $venda->valor, 2, ',', '.') }}</td>

                                <td>

                                    <?php
                                                                        
                                        $style = '';
                                        
                                        if ($venda->status == VendaStatus::FECHADA) {
                                            $style = 'primary';
                                            $vendas_fechadas = $vendas_fechadas + (float) $venda['valor'];
                                        } elseif ($venda->status == VendaStatus::CHECADA) {
                                            $style = 'success';
                                            $vendas_fechadas = $vendas_fechadas + (float) $venda['valor'];
                                        } 
                                        
                                    ?>
                                    <span class="badge bg-{{ $style }}">{{ $venda->status }} </span>
                                </td>
                            </tr>

                            @else
                            {{-- <h1>Lead Incosistente: </h1> {{$vendas->id}} --}}
                            {{-- {{ dd($venda) }} --}}
                            @endif

                            @endforeach

                        </tbody>
                    </table>
                    <h2 class="text-info">Total: R$ {{ number_format($vendas_fechadas, 2, ',', '.') }}</h2>
                </div>
            </div>
            @endif

            @if (isset($vendas_rascunho) && !$vendas_rascunho->isEmpty() )
            <div class="card">
                <div class="card-body left">
                    <h2 class="text-warning title">VENDAS NÃO CONCLUIDAS</h2>

                    <table id="example" class="table w-100 nowrap">
                        <thead>
                            <tr class="table-light">
                                <th>Cliente </th>
                                <th>Contrato </th>
                                <th>Vendedor Principal </th>
                                <th>Vendedor Secundário</th>
                                <th>Data Fechamento</th>
                                <th>Primeira Assembleia</th>
                                <th>Valor</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                                                               
                                $sum_vendas_rascunho = 0;?>

                            @foreach ($vendas_rascunho as $venda)

                            @if ($venda->negocio)

                            <tr>
                                <td><a href="{{ route('negocio_fechamento', ['id' => $venda->negocio->id]) }}">{{
                                        $venda->negocio->lead->nome }}</a>
                                </td>
                                <td><a href="">{{ $venda->numero_contrato }}</a>
                                </td>

                                <td>{{ User::find($venda->primeiro_vendedor_id)->name }}</td>
                                <td>
                                    @if ($venda->segundo_vendedor_id)
                                    {{ User::find($venda->segundo_vendedor_id)->name }}
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($venda['data_fechamento'])->format('d/m/Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($venda['data_primeira_assembleia'])->format('d/m/Y') }}
                                </td>
                                <td>R$ {{ number_format((float) $venda->valor, 2, ',', '.') }}</td>
                                <td>
                                    <?php                                                
                                       $style = 'warning';
                                       $sum_vendas_rascunho = $sum_vendas_rascunho + (float) $venda['valor'];
                                                                    ?>
                                    <span class="badge bg-{{ $style }}">{{ $venda->status }} </span>
                                </td>
                            </tr>

                            @else
                            {{-- <h1>Lead Incosistente: </h1> {{$vendas->id}}
                            {{ dd($venda) }} --}}
                            @endif
                            @endforeach

                        </tbody>
                    </table>
                    <h2 class="text-warning">Total: R$ {{ number_format($sum_vendas_rascunho, 2, ',', '.') }}
                    </h2>
                </div>
            </div>
            @endif


            @if (isset($vendas_canceladas) && !$vendas_canceladas->isEmpty() )
            <div class="card">
                <div class="card-body left">
                    <h2 class="text-danger title">VENDAS CANCELADAS</h2>

                    <table id="example" class="table w-100 nowrap">
                        <thead>
                            <tr class="table-light">
                                <th>Cliente </th>
                                <th>Contrato </th>
                                <th>Vendedor Principal </th>
                                <th>Vendedor Secundário</th>
                                <th>Data Fechamento</th>
                                <th>Primeira Assembleia</th>
                                <th>Valor</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                                                   
                                                                            $sum_vendas_canceladas = 0;
                                                                            ?>

                            @foreach ($vendas_canceladas as $venda)
                            @if ($venda->negocio)
                            <tr>
                                <td><a href="{{ route('negocio_fechamento', ['id' => $venda->negocio->id]) }}">{{
                                        $venda->negocio->lead->nome }}</a>
                                </td>
                                <td><a href="">{{ $venda->numero_contrato }}</a>
                                </td>

                                <td>{{ User::find($venda->primeiro_vendedor_id)->name }}</td>
                                <td>
                                    @if ($venda->segundo_vendedor_id)
                                    {{ User::find($venda->segundo_vendedor_id)->name }}
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($venda['data_fechamento'])->format('d/m/Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($venda['data_primeira_assembleia'])->format('d/m/Y') }}
                                </td>
                                <td>R$ {{ number_format((float) $venda->valor, 2, ',', '.') }}</td>

                                <td>

                                    <?php
                                                                                            
                                                            $style = '';
                                                            
                                                            if ($venda->status == VendaStatus::CANCELADA) {
                                                                $style = 'danger';
                                                                $sum_vendas_canceladas = $sum_vendas_canceladas + (float) $venda['valor'];
                                                            }
                                                            
                                                        ?>
                                    <span class="badge bg-{{ $style }}">{{ $venda->status }} </span>
                                </td>
                            </tr>
                            @else
                            {{-- <h1>Lead Incosistente: </h1> {{$vendas->id}} --}}

                            @endif
                            @endforeach

                        </tbody>
                    </table>
                    <h2 class="text-danger">Total: R$ {{ number_format($sum_vendas_canceladas, 2, ',', '.') }}
                    </h2>
                </div>
            </div>
            @endif

        </div>
        <!-- end card-->

        <!-- end col-->
    </div>
    <!-- end row -->

</div>

<div class="row">
    <div class="col-12">

    </div>
</div>
</div>
@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {





            let example = $('#example').DataTable({
                scrollX: true,
                scrollY: true,
                "columnDefs": [{
                    "width": "10%",
                    "targets": 0
                }],
                pageLength: 100

            });

            let selectall = false;

            $('#selectall').on("click", function() {
                if ($("input:checkbox").prop("checked")) {
                    $("input:checkbox[class='select-checkbox']").prop("checked", true);
                    selectall = true
                } else {
                    $("input:checkbox[class='select-checkbox']").prop("checked", false);
                    selectall = false
                }
            })

            $("input:checkbox[class='select-checkbox']").on("click", function() {
                let numberNotChecked = $('input:checkbox:checked').length;
                if (selectall) {
                    numberNotChecked = numberNotChecked - 1;
                    selectall = false;
                }
                if (numberNotChecked < 1) {
                    $("#info_label").text("");
                } else if (numberNotChecked < 2) {
                    $("#info_label").text(numberNotChecked + " Negócio Selecionado");
                } else {
                    $("#info_label").text(numberNotChecked + " Negócios Selecionados");
                }
            });

            $('#telefone').mask('(00) 00000-0000');
            $('#cpf').mask('000.000.000-00');
            $('#data_contratacao').mask('00/00/0000');

            $('#data_contratacao').datepicker({
                orientation: 'top',
                todayHighlight: true,
                format: "dd/mm/yyyy",
                defaultDate: +7
            });

        });



        $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            },
            function(start, end, label) {
                //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                window.location.href = "{{ url('vendas/index?') }}" + "data_inicio=" + start.format('DD/MM/YYYY') +
                    "&" + "data_fim=" + end.format('DD/MM/YYYY');

            });
</script>
@endsection