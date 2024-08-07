@extends('main')
<?php
use App\Models\EtapaFunil;
use App\Models\User;
use Carbon\Carbon;
$protocolo_dia = 0;
$protocolo_hora = 0;

?>
@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('') }}/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    .divtext {
        border: ridge 2px;
        padding: 5px;
        width: 20em;
        min-height: 5em;
        overflow: auto;
    }


    #spinner-div {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 2;
    }

    .text-primary {
        color: #13a2e3 !important;
    }

    .spinner-border2 {
        display: inline-block;
        width: 10rem;
        height: 10rem;
        vertical-align: 100%;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: .75s linear infinite spinner-border;
        animation: .75s linear infinite spinner-border;
        text-align: center;
        margin: 20%;
    }

    .tasks.tasks:not(:last-child) {
        margin-right: 0rem;
    }

    .ui-timepicker-wrapper .ui-timepicker-list li {
        width: 100px;
    }

    .task {
        width: 1rem;
    }
</style>

<style>
    .nolink {

        text-decoration: none;
        color: black;
    }

    .card-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 0rem 0.6rem !important;
    }

    /* .border1 {
                    border: 0px solid #d0d0d0;
                }

                .border1:hover {
                    border: 3px solid rgb(78, 0, 146);
                } */
</style>
@endsection

@section('main_content')


<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row ">
        <div class="col-12">
            <div class="page-title-box" style="margin-top: -33px;">
                <div class="page-title-right">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            @if (app('request')->view_card == 'compact')
                            <a class="nav-link dropdown-toggle arrow-none"
                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'status' => app('request')->status]) }}"
                                role="button">
                                <i class="dripicons-expand noti-icon"></i>
                            </a>
                            @else
                            <a class="nav-link dropdown-toggle arrow-none"
                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'view_card' => 'compact', 'status' => app('request')->status]) }}"
                                role="button">
                                <i class="dripicons-contract noti-icon"></i>
                            </a>
                            @endif
                        </li>
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            <a class="nav-link dropdown-toggle arrow-none"
                                href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'view' => 'list']) }}"
                                role="button">
                                <i class="dripicons-menu noti-icon"></i>
                            </a>
                        </li>
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">

                                @if (!is_null($proprietario))
                                {{ $proprietario->name }}
                                @elseif (app('request')->status == 'inativo')
                                Inativos
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
                                    href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => $proprietario_id, 'view_card' => app('request')->view_card, 'status' => 'ativo']) }}">{{
                                    $value }}</a>
                                @endforeach

                                @if (Auth::user()->hasAnyRole(['admin']))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" target="_self"
                                    href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-1', 'view_card' => app('request')->view_card]) }}">Não
                                    Atribuido</a>

                                <a class="dropdown-item" target="_self"
                                    href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-2', 'view_card' => app('request')->view_card, 'status' => 'inativo']) }}">Inativos</a>
                                @endif

                                @if (Auth::user()->hasAnyRole(['gerenciar_equipe']))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" target="_self"
                                    href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => '-2', 'view_card' => app('request')->view_card, 'status' => 'ativo']) }}">Todos</a>
                                @endif

                            </div>
                            @endif
                        </li>
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            {{-- <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Pipeline
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @foreach ($funils as $funil_id => $value)
                                <a class="dropdown-item" href="{{ route('pipeline_index', ['id' => $funil_id]) }}">{{
                                    $value }}</a>
                                @endforeach
                            </div>
                            --}}
                        </li>

                    </ul>

                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-experiment noti-icon"></i>

                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                        </span>Filtros
                                    </h5>
                                </div>

                                <div style="max-height: 200px;" data-simplebar="">
                                    <!-- item-->
                                    <a href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'view_card' => app('request')->view_card, 'status' => 'ativo']) }}"
                                        class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <!--i class="dripicons-thumbs-up noti-icon"></i-->
                                        </div>
                                        <p class="notify-details">Negócios Ativos
                                        </p>
                                    </a>

                                    <a href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'view_card' => app('request')->view_card, 'status' => 'vendido']) }}"
                                        class="dropdown-item notify-item">
                                        <div class="notify-icon bg-success">
                                            <!--i class="dripicons-thumbs-up noti-icon"></i-->
                                        </div>
                                        <p class="notify-details">Negócios Vendidos
                                        </p>
                                    </a>

                                    <a href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'view_card' => app('request')->view_card, 'status' => 'perdido']) }}"
                                        class="dropdown-item notify-item">
                                        <div class="notify-icon bg-danger">
                                            <!--i class="dripicons-thumbs-up noti-icon"></i-->
                                        </div>
                                        <p class="notify-details">Negócios Peridos
                                        </p>
                                    </a>

                                    <a href="{{ route('pipeline_index', ['id' => $curr_funil_id, 'proprietario' => app('request')->proprietario, 'view_card' => app('request')->view_card]) }}"
                                        class="dropdown-item notify-item">
                                        <div class="notify-icon bg-secondary">
                                            <!--i class="dripicons-thumbs-up noti-icon"></i-->
                                        </div>
                                        <p class="notify-details">Todos Negócios
                                        </p>
                                    </a>

                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    + Filtros
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <h4 class="page-title" style="line-height: 110px">Negócios
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add-negocio-model"
                        class="btn btn-success btn-sm ms-3">+ Add</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add-negocio-massive"
                        class="btn btn-info btn-sm ms-3">++Add</a>

                </h4>
            </div>
        </div>

    </div>
    <!-- end page title -->

    <div class="row container-drag" id="container" data-containers='["<?php echo implode('","', $etapa_funils); ?>"]'>
        <div class="col-12">
            <div class="board">

                @foreach ($etapa_funils as $key => $value)
                @if (isset($negocios))
                <?php
                            $valor_vendido_total = 0;
                            $count = 0;
                            foreach ($negocios->where('etapa_funil_id', $key) as $negocio) {
                                $valor_vendido_total = $valor_vendido_total + (float) $negocio->valor;
                                $count = $count + 1;
                            }
                            ?>
                @endif
                <div class="tasks">

                    @if (isset($negocios))
                    <h5 class="mt-0 task-header">{{ $value }} ({{ $count }})<small> <br>R$
                            {{ number_format($valor_vendido_total, 2, ',', '.') }}</small></h5>
                    @endif
                    <div id="{{ $value }}" class="task-list-items" data="{{ $key }}" data-etapa="{{ $value }}"
                        agendamento="{{ EtapaFunil::where('id', $key)->first()->is_agendamento }}">

                        @if (isset($negocios))
                        @foreach ($negocios->where('etapa_funil_id', $key) as $negocio)
                        <?php $date = \Carbon\Carbon::parse($negocio->updated_at);
                                        $last_update = $date->diffInDays(\Carbon\Carbon::now('America/Sao_Paulo')); 
                                    

                                    if (EtapaFunil::where('id', $key)->first()->nome == "FECHAMENTO"){
                                        $fechamento_visible = '';
                                    }else {
                                         $fechamento_visible = 'none';
                                    }  

                                    if (EtapaFunil::where('id', $key)->first()->nome == "REUNIAO"){
                                        $proposta_visible = '';
                                    }else {
                                        $proposta_visible = 'none';
                                    }
                                        
                                        ?>



                        @include('templates.crm_card', [
                        'titulo' => $negocio->titulo,
                        'negocio_id' => $negocio->id,
                        'valor' => $negocio->valor,
                        'tipo' => $negocio->tipo,
                        'leadname' => $negocio->lead->nome,
                        'last_update' => $last_update,
                        'telefone' => $negocio->lead->telefone,
                        'whatsapp' => $negocio->lead->whatsapp,
                        'fechamento' => "{{ $fechamento_visible }}",
                        'proposta' => "{{$proposta_visible}}"
                        ])
                        @endforeach
                        @endif
                        <!-- Task Item End -->
                    </div>
                </div>
                @endforeach

            </div> <!-- end .board-->
        </div> <!-- end col -->
    </div>

</div> <!-- container -->


<div class="rightbar-overlay"></div>
<!-- /End-bar -->

<!--  Add new task modal -->
@include('templates.add_negocio')

<!-- Modal -->
<div class="modal top fade" id="add-negocio-massive" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <form style="margin: 0; padding: 0; background-color: #dbcdc3;display: contents;height: 100%;"
                action="{{ url('negocios/massive/add') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adição de Negócio em Massa</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-2">
                            <label for="email" class="form-label"><strong>TIPO DE CRÉDITO:</strong></label>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="IMOVEL"
                                        checked>
                                    <label class="form-check-label">IMOVEL</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="CARRO">
                                    <label class="form-check-label">CARRO</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="MOTO">
                                    <label class="form-check-label">MOTO</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="TERRENO">
                                    <label class="form-check-label">TERRENO</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="MAQUINARIO">
                                    <label class="form-check-label">MAQUINARIO</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="CAMINHAO">
                                    <label class="form-check-label">CAMINHAO</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_credito" value="SERVICO">
                                    <label class="form-check-label">SERVICO</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <textarea style="width:  100% !important; height: 100%;font-size: 16px;" name="negocios"
                                rows=20></textarea>
                        </div>



                    </div>

                </div>

                <input name="etapa_funil_id" value="1" hidden>
                <input name="funil_id" value="1" hidden>
                <input name="proprietario_id" id="negocio_id_perdido" hidden value="{{ app('request')->proprietario }}">


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>



        </div>
    </div>
</div>

<div class="modal fade task-modal-content" id="negocio-ganho" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="NewTaskModalLabel">Venda: </h5>
                <h3 id="venda_titulo"></h3>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{ url('vendas/nova') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Nome Cliente<span
                                                class="text-danger">
                                                *</label>
                                        <input type="text" class="form-control form-control-light" id="cliente_nome"
                                            name="cliente_nome" placeholder="Digite o titulo do negócio" required
                                            value="" maxlength="30">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Tipo de Crédito</label>
                                        <select class="form-select form-control-light" id="tipo_credito"
                                            name="tipo_credito">

                                            <option selected>IMOVEL</option>
                                            <option>CARRO</option>
                                            <option>MOTO</option>
                                            <option>CAMINHAO</option>
                                            <option>MAQUINARIO</option>
                                            <option>TERRENO</option>
                                            <option>SERVICO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Valor Crédito</label>
                                        <input type="text" class="form-control form-control-light" id="valor_credito_md"
                                            placeholder="Valor do Crédito" name="valor">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-priority" class="form-label">Data do Fechamento</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="data_fechamento"
                                            value="<?php echo date('d/m/Y'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Painel Esquedo -->
                        <div class="col-md-6" style="border-left: 1px solid rgb(228 230 233);">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Primeiro Vendedor</label>
                                        <select class="form-select form-control-light" id="vendedor_principal"
                                            name="vendedor_principal">
                                            <option selected value="{{ Auth::user()->id }}">{{ Auth::user()->name }}
                                            </option>
                                            @foreach (\Auth::user()->get() as $user)
                                            @if ($user->id != Auth::user()->id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Segundo Vendedor</label>
                                        <select class="form-select form-control-light" id="vendedor_secundario"
                                            name="vendedor_secundario">
                                            <option selected value="null">Selecione</option>
                                            @foreach (\Auth::user()->get() as $user)
                                            @if ($user->id != Auth::user()->id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-12">
                                            <label for="task-title" class="form-label">Parcelas Embutidas</label>
                                            <select class="form-select form-control-light" id="tipo_credito"
                                                name="parcelas_embutidas">

                                                <option selected value="0">Nenhuma</option>
                                                <option value="1">1 Parcela</option>
                                                <option value="2">2 Parcelas</option>
                                                <option value="3">3 Parcelas</option>
                                                <option value="4">4 Parcelas</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-12">
                                            <label for="task-priority" class="form-label">Data da Primeira
                                                Assembleia</label>
                                            <input type="text" class="form-control form-control-light pfechamento"
                                                data-single-date-picker="true" name="data_primeira_assembleia"
                                                value="<?php echo date('d/m/Y'); ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">É VENDA!</button>

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>

                        <input type="text" id="cliente_id" name="cliente_id" hidden>
                        <input type="text" id="negocio_id" name="negocio_id" hidden>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade task-modal-content" id="negocio-perdeu" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <h2 class="modal-title" class="center" id="venda_titulo">Perdeu o Cliente</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{ route('vendas.perdida') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-12">

                            <label for="task-title" class="form-label">Motivo da Perda</label>
                            <select class="form-select form-control-light" name="motivo_perda">
                                @foreach ($motivos as $motivo)
                                <option value="{{ $motivo->id }}">{{ $motivo->motivo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                    <input name="negocio_id" id="negocio_perdido_confirmacao" hidden value="">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('templates.add_agendamento', [])
@include('templates.add_protocolo', [])



<div class="modal fade task-modal-content" id="agendamento-confirmar" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="center" id="venda_titulo">Confirmar Reunião</h5>
                <h2 id="agendamento_confirmar_nome">Cliente</h2>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{ route('agendamento.add') }}" method="POST" id="confirmar_reuniao">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-6">
                            <label>Reunião Confirmado para o Agendamento</label>
                            <h4 id="agendamento_confirmar_reuniao"></h4>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>

                    </div>
                    <hr>

                    <input name="proprietario_id" id="negocio_id_perdido" hidden
                        value="{{ app('request')->proprietario }}">
                    <input name="negocio_id" id="negocio_id_reu" hidden value="">
                    <input name="data_agendamento" id="data_agendamento" hidden value="{{ date('d/m/Y') }}">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div id="spinner-div" class="pt-5">
    <div class="spinner-border2 text-primary" role="status">
    </div>
</div>



@endsection

@section('specific_scripts')
<!-- bundle -->
<script src="{{ url('') }}/js/vendor/dragula.min.js"></script>
<!-- demo js -->
<script src="{{ url('') }}/js/ui/component.dragula.js"></script>
<script src="{{ url('') }}/js/jquery.mask.js"></script>
<script src="{{ url('') }}/js/jquery.timepicker.min.js"></script>



<script>
    var cont = [];
        var arr = Array($('.container-drag').data('containers'))[0];
        arr.forEach(function(n) {
            cont.push(document.querySelector('#' + n))
        });

        function set_columns_height() {
            var max_height = 0
            $('.task-list-items').each(function() {
                if ($(this).height() > max_height) {
                    max_height = $(this).height();
                }
            });

            $('.task-list-items').each(function() {
                $(this).css({
                    'min-height': max_height
                });
            });
        }

        /** Quando a página for carregada, ajusta o tamanho máximo da div principal para aparecer o scroll */
        document.addEventListener("DOMContentLoaded", function() {
            var height__ = parseInt(document.documentElement.clientHeight) - 100;
           
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                $('.board').css({
                    "max-height": height__ + 5
                })
            } else {
                $('.board').css({
                    "max-height": height__
                })
            }

            set_columns_height();

        });

        /** Quando o tamanho da página é reajustado, muda o tamanho máximo da div para aparecer o scroll */
        window.addEventListener('resize', function(event) {
            var height__ = parseInt(document.documentElement.clientHeight) - 210;
           

            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                $('.board').css({
                    "max-height": height__ + 100
                })
            } else {
                $('.board').css({
                    "max-height": height__
                })
            }
            set_columns_height();
        }, true);

        // Variáveis para armazenar o estado original
        var originalParent, originalNextSibling, currentEl;

        var dragek = dragula(cont, {
            revertOnSpill: true
        });

        var scrollable = true;
        var listener = function(e) {
            if (!scrollable) {
                e.preventDefault();
            }
        }

        document.addEventListener('touchmove', listener, {
            passive: false
        });

        dragek.on('drag', function(el, source) {
        

            originalParent = el.parentNode;
            originalNextSibling = el.nextSibling;
            scrollable = false;
        });

        dragek.on('dragend', function(el, source) {
            scrollable = true;
        });

        var modal_agendamento = $("#agendamento-add");
        $(window).click(function(event) {
            if ($(event.target).is(modal_agendamento)) {
            modal_agendamento.hide();

            originalParent.insertBefore(currentEl, originalNextSibling);
            //drake.cancel(true);
        }
        });



        $('#agendamento_para').submit(function(e) {

            $("#spinner-div").show();
            $('#agendamento-add').modal('hide');

            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#confirmar_agendamento').prop("disabled", false);

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    showAlert({
                        message: "reunião de agendada com sucesso",
                        class: "success"
                    });
                    $.ajax({
                        url: "{{ url('negocios/drag_update') }}",
                        type: 'post',
                        data: {
                            info: info
                        },
                        Type: 'json',
                        success: function(res) {
                            //showAlert({message: "reunião de "+res+" agendada com sucesso", class:"success"});
                        },
                        error: function(res) {
                            showAlert({
                                message: "Erro ao salvar card em agendamento: " +
                                    res,
                                class: "danger"
                            });
                            $("#spinner-div").hide();
                        },
                        complete: function(res) {
                            $("#spinner-div").hide();

                            if (document.getElementById('check_protocolo').checked) {
                                ptcl_dia.textContent = data[0] + ' (' + data[2] + ')';
                                ptcl_hora.textContent = data[1];
                                ptcl_cliente.textContent = data[3][0].toUpperCase() + data[
                                    3].substring(1);

                                $('#agendamento-protocolo').modal('show');
                            }

                        }
                    });
                },
                error: function(res) {
                    
                    showAlert({
                        message: " Erro no agendamento (" + res + ")",
                        class: "danger"
                    });
                    $("#spinner-div").hide();
                },
            });
        });

        dragek.on('drop', function(el, target, source, sibling) {

           

            scrollable = true;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#spinner-div").on('');
            info = [];
            info[0] = el.getAttribute('id');
            info[1] = source.getAttribute('data');
            info[2] = target.getAttribute('data');



            if (target.getAttribute('data-etapa') == "REUNIAO_AGENDADA") {


                currentEl = el;
                $('#negocio_id_agen').val(info[0]);
                $('#agendamento-add').modal('show');
                $('#database').attr('data-el', info[0]);
                $('#database').attr('data-source', info[1]);
                $('#database').attr('data-target', info[2]);


            } else if (target.getAttribute('data-etapa') == "REUNIAO") {

                if (source.getAttribute('data-etapa') == "REUNIAO_AGENDADA") {
                    $("#spinner-div").show();
                    $.ajax({
                        url: "{{ url('negocios/add_reuniao') }}",
                        type: 'post',
                        data: {
                            info: info
                        },
                        Type: 'json',
                        success: function(res) {
                            showAlert({
                                message: res,
                                class: "success"
                            });
                          
                          
                        },
                        error: function(res) {
                            showAlert({
                                message: "erro ao agendar reunião:" + res,
                                class: "danger"
                            });
                        },
                        complete: function() {
                            $("#spinner-div").hide(); //Request is complete so hide spinner

                        }
                    });
                } else {
                    showAlert({
                        message: 'O negócio precisa estar em REUNIAO_AGENDADA antes de REUNIAO',
                        class: "danger"
                    });
                    dragek.cancel(true);
                }

            } else if (target.getAttribute('data-etapa') == "APROVACAO") {

                if (source.getAttribute('data-etapa') == "REUNIAO") {
                    $("#spinner-div").show();
                    $.ajax({
                        url: "{{ url('negocios/add_aprovacao') }}",
                        type: 'post',
                        data: {
                            info: info
                        },
                        Type: 'json',
                        success: function(res) {
                            showAlert({
                                message: res + " aprovação realizada com sucesso",
                                class: "success"
                            });
                        },
                        error: function(res) {
                            showAlert({
                                message: "erro ao aprovar cliente:" + res,
                                class: "danger"
                            });
                        },
                        complete: function() {
                            $("#spinner-div").hide(); //Request is complete so hide spinner
                        }
                    });
                } else {
                    showAlert({
                        message: 'O negócio precisa estar em REUNIÃO antes de APROVACAO',
                        class: "danger"
                    });
                    dragek.cancel(true);
                }

            } else if (target.getAttribute('data-etapa') == "FECHAMENTO") {

                $.ajax({
                    url: "{{ url('negocios/drag_update') }}",
                    type: 'post',
                    data: {
                    info: info
                    },
                    Type: 'json',
                    success: function(res) {},
                    complete: function() {
                    
                    }
                });

                window.location.href = "{{ url('negocios/fechamento?id=') }}"+info[0];

                
            
            } else {

                $.ajax({
                    url: "{{ url('negocios/drag_update') }}",
                    type: 'post',
                    data: {
                        info: info
                    },
                    Type: 'json',
                    success: function(res) {},
                    complete: function() {

                    }
                });
            }

            set_columns_height();

        });

        $('.pfechamento').datepicker({
            orientation: 'top',
            todayHighlight: true,
            format: "dd/mm/yyyy",
            defaultDate: +7
        });


        $('.agendamento').datepicker({
            orientation: 'top',
            todayHighlight: true,
            format: "dd/mm/yyyy",
            timeFormat: "HH:mm:ss",
            defaultDate: +1
        });


        $('.perdeu_button').on('click', function() {
            var id = $(this).data('id');
  
            $.ajax({
                url: "{{ url('negocios/get?id=') }}" + id,
                type: "GET",
                dataType: "json",
                success: function(response) {


                    
                    document.getElementById("negocio_perdido_confirmacao").value = id;//response[0]['id'];

                    $('#negocio-perdeu').modal('show'); 

                }
            });
        });

        $('.ganhou_button').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: "{{ url('negocios/get?id=') }}" + id,
                type: "GET",
                dataType: "json",
                success: function(response) {

                    document.getElementById("cliente_id").value = response[1]['id'];
                    document.getElementById("negocio_id").value = response[0]['id'];

                    document.getElementById("cliente_nome").value = response[1]['nome'];
                    document.getElementById("cliente_nome").value = response[1]['nome'];
                    document.getElementById("valor_credito_md").value = response[0]['valor'];

                    //$("#valor_credito_md").unmask().mask("000.000.000.000.000,00");
                    $("#valor_credito_md").val(response[0]['valor']).trigger("input");
                    $('#valor_credito_md').mask('000.000.000.000.000,00', {
                        reverse: true
                    });


                    var x = document.getElementById("tipo_credito").getElementsByTagName('option');
                    var i;
                    for (i = 0; i < x.length; i++) {

                        if (x[i].value == response[0]['tipo']) {
                            x[i].selected = 'selected';
                            break;
                        }
                    }

                    $('#negocio-ganho').modal('show');
                }
            });
        });
</script>
@endsection