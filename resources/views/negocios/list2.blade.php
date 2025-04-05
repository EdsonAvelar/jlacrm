@extends('main')


@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">


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

    .visible {
        visibility: visible;
    }

    .invisible {
        visibility: hidden;
    }

    .scroll {
        border: 1px solid #ccc;
        width: 200px;
        height: 200px;
        overflow-y: scroll;
    }

    .filter-dropdown {
        position: absolute;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 10px;
        z-index: 1000;
        display: none;
        width: 220px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-dropdown input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .filter-dropdown button {
        width: 100%;
        padding: 8px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 5px;
    }

    #filter-btn {
        background-color: #28a745;
        color: white;
    }

    #clear-filter-btn {
        background-color: #dc3545;
        color: white;
    }

    .filter-applied {
        color: #28a745;
        /* Verde, ou qualquer cor de sua escolha */
    }

    .filter-icon {
        margin-left: 8px;
        /* Espaçamento entre o nome da coluna e o ícone */
        cursor: pointer;
        /* Cursor de mão para indicar que o ícone é clicável */
        float: inline-end;
    }

    th.select-checkbox-header {
        min-width: 100px;
        /* Ajuste este valor conforme necessário */
        white-space: nowrap;
        /* Evita que o texto da coluna quebre em várias linhas */
    }

    th.short {
        width: 10px;
        /* Ajuste este valor conforme necessário */
        text-align: left;
        /* Centraliza o conteúdo */
    }

    .pagination .page-item .page-link {
        color: #007bff;
        /* Cor personalizada */
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .sort-icon {
        cursor: pointer;
        margin-left: 5px;
        color: #007bff;
        /* Ajuste a cor conforme o tema */
    }

    .container-fluid {
        overflow-y: auto;
        /* Adiciona rolagem vertical quando o conteúdo exceder a altura */
        height: 100vh;
        /* Define altura total da viewport */
    }

    .content-page {
        padding: 0px 12px 0px 0px;
    }
</style>
@endsection

@section('main_content')

<form id="target" action="{{ url('negocios/changemassive') }}" method="POST">

    @csrf
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="card text-left">
            <div class="card-body">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <div class="dropdown">
                                    <li class="dropdown notification-list d-none d-sm-inline-block">
                                        <button type="button" class="btn btn-light dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            @if (!is_null($proprietario))
                                            {{ $proprietario->name }}
                                            @elseif (app('request')->status == 'inativo')
                                            Inativos
                                            @elseif (app('request')->status == 'perdido')
                                            Perdidos
                                            @elseif (app('request')->status == 'parado' )
                                            Negócios Parados
                                            @elseif (app('request')->proprietario == -2)
                                            Todos
                                            @else
                                            Não Atribuidos
                                            @endif

                                        </button>

                                        @if (isset($proprietarios))
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @foreach ($proprietarios as $proprietario_id => $value)
                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => $proprietario_id, 'view' => 'list2', 'status' => 'ativo']) }}">{{
                                                $value }}</a>
                                            @endforeach

                                            @if (Auth::user()->hasAnyRole(['admin']))
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-1', 'view' => 'list2', 'status' => 'ativo']) }}">Não
                                                Atribuido</a>

                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-2', 'view' => 'list2', 'status' => 'inativo']) }}">Inativos</a>
                                            @endif

                                            @if (Auth::user()->hasAnyRole(['gerenciar_equipe']))
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => -2, 'view' => 'list2', 'status' => 'perdido']) }}">Perdidos</a>

                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-2', 'view' => 'list2', 'status' => 'ativo']) }}">Ativos</a>

                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-2', 'view' => 'list2', 'status' => 'parado']) }}">
                                                Negócios Parados ({{config('negocio_parado')}} dias)
                                            </a>
                                            <hr>
                                            <a class="dropdown-item" target="_self"
                                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-2', 'view' => 'list2']) }}">Todos</a>
                                            @endif

                                        </div>
                                        @endif



                                    </li>
                                    {{-- <button type="button" class="btn btn-light dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Funils
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach ($funils as $id => $value)
                                        <a class="dropdown-item"
                                            href="{{ route('pipeline_index', ['pipeline_id' => $id, 'view' => 'list']) }}">{{
                                            $value }}</a>
                                        @endforeach
                                    </div> --}}
                                </div>
                            </div>
                            <h4 class="page-title">
                            
                            @include('partials.mobile-sidebar', ['title' => 'Negócios'])

                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-negocio-model" id="add_button"
                                    class="btn btn-info btn-sm ms-3">+ Add</a>

                                <a type="button" class="btn btn-success btn-sm ms-3 checkbox_sensitive"
                                    id="atribuir_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Atribuir</a>

                                <a type="button" class="btn btn-secondary btn-sm ms-3 checkbox_sensitive"
                                    id="distribuir_btn" data-bs-toggle="modal" data-bs-target="#distribuirModal">
                                    Distribuir</a>

                                <a type="button" class="btn btn-warning btn-sm ms-3 checkbox_sensitive"
                                    id="redistribuir_btn" data-bs-toggle="modal" data-bs-target="#redistribuirModal">
                                    Redistribuir</a>

                                @if (Auth::user()->hasRole('admin'))
                                <a type="button" class="btn btn-warning btn-sm ms-3 checkbox_sensitive"
                                    id="desativar_btn" data-bs-toggle="modal" data-bs-target="#desativarModal">
                                    Desativar</a>


                                <a type="button" class="btn btn-success btn-sm ms-3 checkbox_sensitive" id="ativar_btn"
                                    data-bs-toggle="modal" data-bs-target="#ativarModal">
                                    Ativar</a>
                                @endif

                                @if (Auth::user()->hasRole('admin'))
                                <a type="button" class="btn btn-danger btn-sm ms-3 checkbox_sensitive" id="deletar_btn"
                                    data-bs-toggle="modal" data-bs-target="#deletarModal">
                                    Deletar</a>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">

                    <table id="example3" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="short">
                                    <input type="checkbox" id="selectall" class="select-checkbox">
                                </th>
                                <th class="select-checkbox-header">Título <i class="fas fa-filter filter-icon"
                                        data-column="negocios.titulo"></i></th>
                                <th class="select-checkbox-header">Cliente <i class="fas fa-filter filter-icon"
                                        data-column="leads.nome"></i></th>
                                <th class="select-checkbox-header">Telefone <i class="fas fa-filter filter-icon"
                                        data-column="leads.telefone"></i></th>
                                <th class="select-checkbox-header">Valor <i class="fas fa-filter filter-icon"
                                        data-column="negocios.valor"></i></th>
                                <th class="select-checkbox-header">Etapa <i class="fas fa-filter filter-icon"
                                        data-column="etapa_funils.nome"></i></th>
                                <th class="select-checkbox-header">Proprietário <i class="fas fa-filter filter-icon"
                                        data-column="users.name"></i></th>
                                <th class="select-checkbox-header">Origem <i class="fas fa-filter filter-icon"
                                        data-column="negocios.origem"></i></th>
                                <th class="select-checkbox-header">Status <i class="fas fa-filter filter-icon"
                                        data-column="negocios.status"></i></th>
                                <th class="select-checkbox-header">Criado em <i class="fas fa-filter filter-icon"
                                        data-column="negocios.data_criacao" data-type="daterange"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atribuir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <h5 class="mt-2">Proprietário</h5>
                    @if (app('request')->status == 'perdido')
                    <span class="text-danger">*ao atribuir um lead desativado ele é automaticamente reativado no
                        destino</span>
                    @endif

                    <div class="mb-1 nowrap w-100">
                        <select class="form-select form-control-light" id="task-priority" name="novo_proprietario_id">
                            <option value="-1" selected="true">SEM PROPRIETÁRIO</option>
                            @foreach ($users as $user_id => $name)
                            <option value="{{ $user_id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5 class="mt-2">Etapa do Funil</h5>
                    <div class="mb-1 nowrap w-100">
                        <select class="form-select form-control-light" id="task-priority" name="etapa_funil_id">

                            @foreach ($etapa_funils as $etapa_funil_id => $funil_name)
                            <option value="{{ $etapa_funil_id }}">{{ $funil_name }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <div class="modal-footer ">
                    <input type="text" name="id" hidden value="{{ app('request')->id }}">
                    <input type="submit" class="btn btn-success mt-2" id="atribuir_enviar" value="Enviar">
                    <input type="button" class="btn btn-danger mt-2 atribuir" data-bs-dismiss="modal" value="Cancelar">
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="desativarModal" tabindex="-1" aria-labelledby="desativarModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desativar Negócios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-12">
                            <h3>Deseja mesmo <span class="bg-danger text-white">Desativar</span> os Negócios
                                Selecionados?</h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="distribuir-div">
                    <input type="text" name="id" hidden value="{{ app('request')->id }}">
                    <input type="submit" class="btn btn-success mt-2" value="SIM">
                    <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                        value="Cancelar">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletarModal" tabindex="-1" aria-labelledby="deletarModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar Negócios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-12">
                            <h4>Deletar um negócio apaga <span class="bg-danger text-white">TODOS</span> os rastros do
                                negócio, incluindo agendamento, aprovações, propostas etc
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
                    <input type="text" name="id" hidden value="{{ app('request')->id }}">
                    <input type="submit" class="btn btn-success mt-2" value="SIM">
                    <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                        value="Cancelar">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ativarModal" tabindex="-1" aria-labelledby="ativarModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ativar Negócios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-12">
                            <h3>Deseja mesmo <span class="bg-success text-white">Ativar</span> os Negócios
                                Selecionados?</h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="distribuir-div">
                    <input type="text" name="id" hidden value="{{ app('request')->id }}">
                    <input type="submit" class="btn btn-success mt-2" value="SIM">
                    <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                        value="Cancelar">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="distribuirModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Distribuir Negócios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">

                            <h3 id="selected_qnt" class="child"></h3>

                        </div>
                        <div class="col-4">
                            <img src="{{ url('') }}/images/sistema/distribuicao.png" width="200px">
                        </div>
                        <div class="col-4 scroll">


                            @foreach ($users as $user_id => $name)
                            <input type="checkbox" name="usuarios[]" value="{{ $user_id }}" class="select-user" /> {{
                            $name }}<br>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="distribuir-div">
                    <input type="text" name="id" hidden value="{{ app('request')->id }}">
                    <input type="submit" class="btn btn-success mt-2" value="Enviar">
                    <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                        value="Cancelar">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="redistribuirModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ReDistribuir Negócios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">

                            <h3 id="selected_qnt" class="child"></h3>

                        </div>
                        <div class="col-4">
                            <img src="{{ url('') }}/images/sistema/redistribuicao.png" width="200px">
                        </div>
                        <div class="col-4 scroll">


                            @foreach ($users as $user_id => $name)
                            <input type="checkbox" name="usuarios[]" value="{{ $user_id }}" class="select-user" /> {{
                            $name }}<br>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="distribuir-div">
                    <input type="text" name="id" hidden value="{{ app('request')->id }}">
                    <input type="submit" class="btn btn-success mt-2" value="Enviar">
                    <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                        value="Cancelar">
                </div>
            </div>
        </div>
    </div>

    <input type="text" name="modo" id="modo" hidden value="">
</form>

@include('templates.add_negocio')


@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
    $(document).ready(function() {
            $("#atribuir_btn").on("click", function() {
                document.getElementById('modo').value = 'atribuir';
            });
            $("#distribuir_btn").on("click", function() {
                document.getElementById('modo').value = 'distribuir';
            });
            $("#redistribuir_btn").on("click", function() {
            document.getElementById('modo').value = 'redistribuir';
            });
            $("#desativar_btn").on("click", function() {
                document.getElementById('modo').value = 'desativar';
            });

            $("#deletar_btn").on("click", function() {
            document.getElementById('modo').value = 'deletar';
            });


            $("#ativar_btn").on("click", function() {
                document.getElementById('modo').value = 'ativar';
            });
            $('.checkbox_sensitive').hide();
            // let example = $('#example').DataTable({
            //     pageLength: 100
            // });


            $('#example3').on('draw.dt', function () {
        
            
            // Bind para os checkboxes
            $('input.select-checkbox').off('click').on('click', function () {
            // console.log("Checkbox clicado! ID:", $(this).val());
            handleTableClick();
            });
            });


            let selectall = false;

            function handleTableClick() {
                const urlParams = new URLSearchParams(window.location.search);
                const status = urlParams.get('status');

                numberNotChecked = $('input:checkbox:checked').length;
                //console.log("Checked:" + $('input:checkbox:checked').length);
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
                    
                    $('#deletar_btn').show();
                    $('#atribuir_btn').show();
                    $('#redistribuir_btn').show();
                }

                if (numberNotChecked == 0) {
                    $('#ativar_btn').hide();
                    $('.checkbox_sensitive').hide();
                }
            }

        


            $(document).on("click", "#selectall", function() {

                // console.log("click all row")

                if ($("input:checkbox").prop("checked")) {
                    $("input:checkbox[class='select-checkbox']").prop("checked", true);
                    selectall = true

                } else {
                    $("input:checkbox[class='select-checkbox']").prop("checked", false);
                    selectall = false

                }

                handleTableClick();
            })

            $(document).on("change", "#chkBSA", function() {
                handleTableClick()
            });

            $("input:checkbox[class='select-checkbox']").on("click", function() {});

            $('#valor_credito').mask('R$ 000.000.000.000.000,00', {
                reverse: true
            });
            $('.telefone').mask('(00) 00000-0000');

        });



$(document).ready(function() {
   
    var filter_content = {};

    let table = $('#example3').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('pipeline_list', ['id' => $curr_funil_id, 'view' => 'list']) }}",
            data: function (d) {
                d.filters = filter_content; // Envia os filtros para o backend
                d.status = "{{ request('status') }}"; // Filtro de status
                d.proprietario = "{{ request('proprietario') }}"; // Filtro de proprietário
             
            }
        },
        language: {
        processing: '<i class="fas fa-spinner fa-spin"></i> Carregando...' // Substitui a palavra "Processing"
        },
        columns: [
            { data: 'select', orderable: false, searchable: false },
            { data: 'titulo', name: 'negocios.titulo', orderable: false , searchable: true},
            { data: 'cliente_nome', name: 'leads.nome', orderable: false, searchable: true},
            { data: 'telefone', name: 'leads.telefone', orderable: false },
            { data: 'valor', name: 'negocios.valor', orderable: false },
            { data: 'etapa', name: 'etapa_funils.nome', orderable: false },
            { data: 'proprietario', name: 'users.name', orderable: false },
            { data: 'origem', name: 'negocios.origem', orderable: false },
            { data: 'status', name: 'negocios.status', orderable: false },
            { data: 'data_criacao', name: 'negocios.data_criacao',orderable: true },
            
        ],
        dom: "lrtip", // Remove o campo de busca global
        pageLength: 25,
        order: [[9, 'desc']], // Ordenação pela data de criação
    
    });

       

   

    // Criar a estrutura do dropdown de filtro
   $('body').append(
    `<div class="filter-dropdown">
       
        <input type="text" id="filter-input" placeholder="Digite para filtrar">
       
        <button id="filter-btn">Filtrar</button>
        <button id="clear-filter-btn">Limpar Filtro</button>

        <p style="color:#aaa">Use hífen para exclusão. <br>Ex. -banana</p>
       
    </div>`
    );

    let $filterDropdown = $('.filter-dropdown');
   

    // Aplicar o filtro ao clicar no botão de filtrar
    $('#filter-btn').on('click', function () {
        let column = $filterDropdown.data('column'); // Nome da coluna a ser filtrada
        let value = $('#filter-input').val(); // Valor do filtro
        let $icon = $filterDropdown.data('icon');

        filter_content[column] = value; // Armazena o valor do filtro

        table.ajax.reload(null, false);

        // Alterar a cor do ícone se o filtro for aplicado
        if (value) {
            $icon.addClass('filter-applied');
        } else {
            $icon.removeClass('filter-applied');
        }

        $filterDropdown.hide();
    });

    // Limpar o filtro ao clicar no botão de limpar filtro
    $('#clear-filter-btn').on('click', function () {
        let column = $filterDropdown.data('column'); // Nome da coluna a ser filtrada
        let $icon = $filterDropdown.data('icon');

        filter_content[column] = ''; // Remove o valor do filtro


        delete filter_content[column];


        table.ajax.reload(null, false);

        // Remover a cor do ícone
        $icon.removeClass('filter-applied');

        $filterDropdown.hide();
    });

$('body').append(
`<div id="daterange-dropdown" style="display: none; position: absolute; z-index: 1000;">
    <input type="text" id="daterange-filter" class="form-control" placeholder="Selecione um intervalo de datas">
</div>`
);

    
    // Inicializando o Daterangepicker
    let $daterangePicker = $('#daterange-filter');

    $daterangePicker.daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Limpar',
            applyLabel: 'Aplicar',
            format: 'DD/MM/YYYY',
        }
    });

    


    // Limpar filtro do Daterangepicker
    $daterangePicker.on('cancel.daterangepicker', function () {
        let column = $daterangePicker.data('column');
        delete filter_content[column]; // Remove o filtro da coluna
        table.ajax.reload(); // Recarrega os dados da tabela
        //$daterangePicker.hide();
    });



    // Quando o ícone de filtro é clicado
    // Mostrar o daterange-picker ao clicar no filtro "Criado em"
    $('.filter-icon').on('click', function (e) {
        let column = $(this).data('column');
        let filterType = $(this).data('type') || 'text'; // Determina se é texto ou intervalo de datas
        let position = $(this).offset();

        $filterDropdown.data('column', column);
        $filterDropdown.data('icon', $(this));


        // console.log(column, filterType);
        
        if (filterType === 'daterange') {
            // Mostra o daterange-picker para "Criado em"
            $('#daterange-dropdown').css({
            top: position.top + 30 + 'px',
            left: position.left - 80 + 'px',
            }).show();
            
            $('#daterange-dropdown').data('column', column);

            $daterangePicker.trigger('click');;
        } else {
            // Mostra o dropdown normal
            $("#filter-input").val(filter_content[column] || '');
            $filterDropdown.data('column', column);
            $filterDropdown.css({
                top: position.top + 30 + 'px',
                left: position.left - 80 + 'px',
            }).show();
        }
    });


    // Aplicar o filtro do daterange-picker
    $daterangePicker.on('apply.daterangepicker', function (ev, picker) {
        let column = $daterangePicker.data('column');
        let startDate = picker.startDate.format('YYYY-MM-DD');
        let endDate = picker.endDate.format('YYYY-MM-DD');

        column = 'negocios.data_criacao';

        // console.log('daterange-filte', column, startDate, endDate)
        
       

        // Atualiza o filtro para essa coluna
        filter_content[column] = { start: startDate, end: endDate };

        // Atualiza a tabela
        table.ajax.reload();

        let $icon = $filterDropdown.data('icon');
        $icon.addClass('filter-applied');

        // $daterangePicker.hide();

        $('#daterange-dropdown').hide()  

    });


    $daterangePicker.on('cancel.daterangepicker', function (ev, picker) {
        let column = $daterangePicker.data('column');

        column = 'negocios.data_criacao';

        let $icon = $filterDropdown.data('icon');
        $icon.removeClass('filter-applied');
        

        // Remove o filtro dessa coluna
        delete filter_content[column];

        // Atualiza a tabela
        table.ajax.reload();

        //$daterangePicker.hide();

        $('#daterange-dropdown').hide()
    
    });



    // Fechar o dropdown se clicar fora dele
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.filter-icon, .filter-dropdown').length) {
            $filterDropdown.hide();
           // $daterangePicker.hide();
            
        }
    });
});

</script>
@endsection