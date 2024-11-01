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

    #btn_deletar {
        margin: 10px 0px 10px 0px;

        width: 150px;
    }
</style>
@endsection
@section('main_content')

<form id="target" action="{{ url('vendas/delete') }}" method="POST">
    @csrf
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
            <div class="col-3">
                @if (Auth::user()->hasRole('admin'))
                <a type="button" class="btn btn-danger btn-sm ms-3 checkbox_sensitive" id="btn_deletar"
                    data-bs-toggle="modal" data-bs-target="#deletarModal">
                    Deletar</a>

                @endif
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
                                    <th class="short">
                                        <input type="checkbox" id="selectall" class="select-checkbox">
                                    </th>
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
                                <?php $vendas_fechadas = 0; ?>

                                @foreach ($vendas as $venda)
                                <tr>

                                    <td><input type="checkbox" id="chkBSA" name="vendas_fechadas[]"
                                            value="{{ $venda->id }}" class="select-checkbox"></td>
                                    @if ($venda->negocio)

                                    <td><a href="{{ route('negocio_fechamento', ['id' => $venda->negocio->id]) }}">{{
                                            $venda->negocio->lead->nome }}</a>
                                    </td>
                                    @else
                                    <td>Erro: Fechamento sem Negocio [ {{ $venda->id }}]
                                    </td>

                                    @endif

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
                                        <span class="badge bg-{{ $style }} ">{{ $venda->status }} </span>
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                        <h2 class="text-success">Total: R$ {{ number_format($vendas_fechadas, 2, ',', '.') }}</h2>
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
                                    <th class="short">
                                        <input type="checkbox" id="selectall" class="select-checkbox">
                                    </th>
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



                                <tr>
                                    <td><input type="checkbox" id="chkBSA" name="vendas_fechadas[]"
                                            value="{{ $venda->id }}" class="select-checkbox"></td>
                                    @if ($venda->negocio)

                                    <td><a href="{{ route('negocio_fechamento', ['id' => $venda->negocio->id]) }}">{{
                                            $venda->negocio->lead->nome }}</a>
                                    </td>
                                    @else
                                    <td>Erro: Fechamento sem Negocio [ {{ $venda->id }}]
                                    </td>

                                    @endif
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
                                    <th class="short">
                                        <input type="checkbox" id="selectall" class="select-checkbox">
                                    </th>
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

                                <tr>
                                    <td><input type="checkbox" id="chkBSA" name="vendas_fechadas[]"
                                            value="{{ $venda->id }}" class="select-checkbox"></td>
                                    @if ($venda->negocio)

                                    <td><a href="{{ route('negocio_fechamento', ['id' =>$venda->negocio->id]) }}">{{
                                            $venda->negocio->lead->nome }}</a>
                                    </td>
                                    @else

                                    <td>Erro: Fechamento sem Negocio [ {{ $venda->id }}]
                                    </td>

                                    @endif
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

    <div class="modal fade" id="deletarModal" tabindex="-1" aria-labelledby="deletarModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar Fechamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-12">
                            <h4>Deletar um fechamento apaga <span class="bg-danger text-white">Apenas o
                                    Fechamento</span> não afeta o negócio associado a ele
                            </h4>
                            <h7 class="text-danger">*Essa operação não pode ser desfeita</h7>
                            <br>
                            <h3>Se desejar continuar escreva DELETAR abaixo</h3>
                            <br>

                            <input type="text" class="form-control form-control-light" name="deletar_challenger"
                                placeholder="DIGITE DELETAR">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="distribuir-div">
                    <input type="submit" class="btn btn-success mt-2" value="SIM">
                    <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                        value="Cancelar">
                </div>
            </div>
        </div>
    </div>
    <input type="text" name="modo" id="modo" hidden value="">
</form>
@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {

    $('.checkbox_sensitive').hide();

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


            let selectall = false;

            function handleTableClick() {
                const urlParams = new URLSearchParams(window.location.search);
                const status = urlParams.get('status');

                numberNotChecked = $('input:checkbox:checked').length;
                console.log("Checked:" + $('input:checkbox:checked').length);
                if (selectall) {
                    numberNotChecked = numberNotChecked - 1;
                    selectall = false;
                }
                if (numberNotChecked < 1) {
                    $("#info_label").text("");
                    $('.checkbox_sensitive').hide();

                } else if (numberNotChecked < 2) {

                    $("#info_label").text(numberNotChecked + " Negócio Selecionado");
                    $('#selected_qnt').html(numberNotChecked + " <br>Negócio Selecionado");
                    $('.checkbox_sensitive').show();
                } else {
                    $("#info_label").text(numberNotChecked + " Negócios Selecionados");
                    $('#selected_qnt').html(numberNotChecked + " <br>Negócio Selecionados")
                    $('.checkbox_sensitive').show();
                }

                if (status == 'ativo') {
                    $('.checkbox_sensitive').show();
                    $('#ativar_btn').hide();

                } else {
                    $('.checkbox_sensitive').hide();
                    $('#ativar_btn').show();
                    
                    $('#btn_deletar').show();
                    $('#atribuir_btn').show();
                }

                if (numberNotChecked == 0) {
                    $('#ativar_btn').hide();
                    $('.checkbox_sensitive').hide();
                }
            }

            $(document).on("change", "#chkBSA", function() {
            handleTableClick()
            });

            $(document).on("click", "#selectall", function() {
            
            if ($("input:checkbox").prop("checked")) {
            $("input:checkbox[class='select-checkbox']").prop("checked", true);
            selectall = true
            
            } else {
            $("input:checkbox[class='select-checkbox']").prop("checked", false);
            selectall = false
            
            }
            
            handleTableClick();
            })
</script>
@endsection