@extends('main')


@section('headers')



<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .task-list-items {
        -webkit-user-select: none;
        /* Safari */
        -ms-user-select: none;
        /* IE 10 and IE 11 */
        user-select: none;
        /* Standard syntax */
    }

    
</style>
@endsection

@section('main_content')


<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                    <li class="dropdown notification-list d-none d-sm-inline-block">

                        @if (app('request')->view_card == "compact")
                            <a class="nav-link dropdown-toggle arrow-none"
                                href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  app('request')->proprietario) )}}" role="button">
                                <i class="dripicons-view-apps noti-icon"></i>
                            </a>
                            @else 
                            <a class="nav-link dropdown-toggle arrow-none"
                                href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  app('request')->proprietario, 'view_card' => 'compact' ) )}}" role="button">
                                <i class="dripicons-view-apps noti-icon"></i>
                            </a>

                            @endif

                        </li>
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            <a class="nav-link dropdown-toggle arrow-none"
                                href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  app('request')->proprietario, 'view' => 'list' ) )}}" role="button">
                                <i class="dripicons-menu"></i>
                            </a>
                           
                        </li>
                        
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            
                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{\App\Models\User::find( app('request')->proprietario)->name}}
                            </button>

                            @if (isset($proprietarios))
                            <div class="dropdown-menu dropdown-menu-end">
           
                                @foreach ($proprietarios as $proprietario_id => $value)
                                <a class="dropdown-item" target="_self"
                                    href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  $proprietario_id ) )}}">{{$value}}</a>
                                @endforeach
                            </div>
                            @endif
                        </li>
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Pipeline
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @foreach ($funils as $funil_id => $value)
                                <a class="dropdown-item"
                                    href="{{route('pipeline_index', array('id' => $funil_id ) )}}">{{$value}}</a>
                                @endforeach
                            </div>
                        </li>

                    </ul>
                </div>


                <h4 class="page-title">Negócios
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add-negocio-model"
                        class="btn btn-success btn-sm ms-3">+ Add</a>
                </h4>
            </div>
        </div>

    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="board">
                <?php
                    $count=1;
                    $task_list = array(1=>"one",2=>"two",3=>"three",4=>"four",5=>"five",6=>"six",7=>"seven",8=>"eight",9=>"nine",10=>"ten");
                ?>
                @foreach ($etapa_funils as $key => $value)

                <div class="tasks">
                    <h5 class="mt-0 task-header">{{$value}}</h5>
                    <div id="<?php echo $task_list[$count];?>" class="task-list-items" data={{$key}}>

                        @if(isset($negocios))
                            @foreach ($negocios->where('etapa_funil_id',$key) as $negocio)

                            <?php $date=\Carbon\Carbon::parse($negocio->updated_at);
                                $last_update = $date->diffInDays(\Carbon\Carbon::now()) ?>

                            @include('templates.crm_card', ['titulo' => $negocio->titulo,
                            'negocio_id' => $negocio->id,
                            'valor' => $negocio->valor,
                            'tipo' => $negocio->tipo,
                            'leadname' => $negocio->lead->nome,
                            'last_update' => $last_update,
                            'created_at' => $negocio->created_at
                            ])
                            @endforeach
                        @endif
                        <!-- Task Item End -->
                    </div>
                </div>

                <?php $count = $count + 1;?>
                @endforeach

            </div> <!-- end .board-->
        </div> <!-- end col -->
    </div>

</div> <!-- container -->


<div class="rightbar-overlay"></div>
<!-- /End-bar -->

<!--  Add new task modal -->
<div class="modal fade task-modal-content" id="add-negocio-model" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="NewTaskModalLabel">Adicionar Negócio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{url('negocios/add')}}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Título<span class="text-danger">
                                                *</label>
                                        <input type="text" class="form-control form-control-light" id="task-title"
                                            name="titulo" placeholder="Digite o titulo do negócio" required
                                            value="Casa Pirituba 100k" maxlength="30">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Tipo de Crédito</label>
                                        <select class="form-select form-control-light" id="task-priority">
                                            <option selected>IMOVEL</option>
                                            <option>CARRO</option>
                                            <option>MOTO</option>
                                            <option>CAMINHAO</option>
                                            <option>TERRENO</option>
                                            <option>SERVICO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Valor Crédito</label>
                                        <input type="text" class="form-control form-control-light" id="valor_credito"
                                            placeholder="Valor do Crédito" name="valor">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Funil</label>
                                        <select class="form-select form-control-light" id="task-priority"
                                            name="funil_id">
                                            @foreach ($funils as $key => $value)
                                                @if ($key == 1)
                                                <option value="{{$key}}" selected="true">{{$value}}</option>

                                                @else
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Etapa Funil</label>
                                        <select class="form-select form-control-light" id="task-priority"
                                            name="etapa_funil_id">
                                            @foreach ($etapa_funils as $key => $value)
                                                @if ($key == 1)
                                                <option value="{{$key}}" selected="true">{{$value}}</option>

                                                @else
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-priority" class="form-label">Previsão de Fechamento</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="fechamento" value="<?php echo date("d/m/Y"); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Painel Esquedo -->
                        <div class="col-md-6" style="border-left: 1px solid rgb(228 230 233);">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Nome Contato<span
                                                class="text-danger"> *</label>
                                        <input type="text" class="form-control form-control-light" id="task-title"
                                            placeholder="Digite nome" required value="Adriano Teste" name="nome_lead">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Telefone<span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control form-control-light telefone"
                                            id="task-title" placeholder="Digite Telefone" required name="tel_lead">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">WhatsApp</label>
                                        <input type="text" class="form-control form-control-light telefone"
                                            id="task-title" placeholder="Digite Telefone" name="whats_lead">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">E-mail</label>
                                        <input type="text" class="form-control form-control-light" id="task-title"
                                            placeholder="Digite e-mail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade task-modal-content" id="negocio-ganho" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="NewTaskModalLabel">Fechar Venda: </h5>
                <h2 class="modal-title" class="center" id="venda_titulo">Titulo Venda</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{route('nova_venda')}}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Nome Completo do Cliente</label>
                                        <input type="text" class="form-control form-control-light" id="nome_cliente"
                                            name="cliente_nome" placeholder="Digite o nome completo do cliente" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Tipo de Crédito</label>
                                        <select class="form-select form-control-light" id="tipo_credito" name="tipo_credito">
                                            <option>IMOVEL</option>
                                            <option>CARRO</option>
                                            <option>MOTO</option>
                                            <option>CAMINHAO</option>
                                            <option>TERRENO</option>
                                            <option>SERVICO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Valor Crédito</label>
                                        <input type="text" class="form-control form-control-light" id="valor_credito_md"
                                            placeholder="Valor do Crédito" name="valor" required> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-priority" class="form-label">Data do Fechamento</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="data_fechamento" value="<?php echo date("d/m/Y"); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Painel Esquedo -->
                        <div class="col-md-6" style="border-left: 1px solid rgb(228 230 233);">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Vendedor Principal<span
                                                class="text-danger"></label>
                                        <select class="form-select form-control-light" id="task-priority"
                                            name="vendedor_principal">
                                            @foreach ($users as $user)
                                                @if ($user->id == \Auth::user()->id)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @else
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>

                            </div>

                            <div class="row">
                                <div class="mb-12">
                                        <label for="task-title" class="form-label">Vendedor Sedundario<span
                                                class="text-danger"></label>
                                        <select class="form-select form-control-light" id="task-priority"
                                            name="vendedor_secundario">
                                            <option selected="true" value="null">Selecione um vendedor</option>
                                            @foreach ($users as $user)
                                                @if ($user->id == \Auth::user()->id)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @else
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-12">
                                        <label for="task-title" class="form-label">Quantidade de Parcelas Embutidas<span
                                                class="text-danger"></label>
                                        <select class="form-select form-control-light" id="task-priority"
                                            name="parcelas_embutidas">
                                            <option value="0" selected="true">Parcelas Embutidas</option>
                                            <option value="1">1 Parcela</option>
                                            <option value="2">2 Parcelas</option>
                                            <option value="3">3 Parcelas</option>
                                            <option value="4">4 Parcelas</option>
                                        </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="task-priority" class="form-label">Data da Primeira Assembleia</label>
                                    <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="data_primeira_assembleia" value="<?php echo date("d/m/Y"); ?>" required>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Ganhar</button>
                    </div>

                    <input name="negocio_id" id="negocio_id" hidden value="">
                    <input name="cliente_id"  id="cliente_id"  hidden value="">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal"></div>

@endsection

@section('specific_scripts')
<!-- bundle -->
<script src="{{url('')}}/js/vendor/dragula.min.js"></script>
<!-- demo js -->
<script src="{{url('')}}/js/ui/component.dragula.js"></script>


<script src="{{url('')}}/js/jquery.mask.js"></script>

<script>


    document.addEventListener('touchmove', function () { e.preventDefault(); }, { passive: false });

    var dragek = dragula([
        document.querySelector('#one'),
        document.querySelector('#two'),
        document.querySelector('#three'),
        document.querySelector('#four'),
        document.querySelector('#five'),
        document.querySelector('#six'),
        document.querySelector('#seven'),
        document.querySelector('#eight'),
        document.querySelector('#nine'),
        document.querySelector('#ten')],
        { direction: 'horizontal' }

    );


    var scrollable = true;

    var listener = function (e) {
        if (!scrollable) {
            e.preventDefault();
        }
    }

    document.addEventListener('touchmove', listener, { passive: false });

    dragek.on('drag', function (el, source) {
        scrollable = false;
    });

    dragek.on('dragend', function (el, source) {
        scrollable = true;
    });



    dragek.on('drop', function (el, target, source, sibling) {
        scrollable = true;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        info = [];
        info[0] = el.getAttribute('id');
        info[1] = source.getAttribute('data');
        info[2] = target.getAttribute('data');
        
       
        $.ajax({
            url: "{{url('negocios/drag_update')}}",
            type: 'post',
            data: { info: info },
            Type: 'json',
            success: function (res) {
                console.log("Negocio Updated Sucessfully")
            }
        });
    });

    $('.ganhou_button').on('click', function () {
        var id = $(this).data('id'); 

 
        $.ajax({
        url: "{{url('negocios/get?id=')}}"+id,
        type: "GET",
        dataType: "json",
        success:function(response) {
         
            console.log( response[1]['nome']  );
            console.log( response[0]['valor']  );

            document.getElementById("cliente_id").value 	= response[1]['id'];
            document.getElementById("negocio_id").value 	= response[0]['id'];

            document.getElementById("nome_cliente").value 	= response[1]['nome'];
            document.getElementById("venda_titulo").textContent 	= response[0]['titulo'];


            var x = document.getElementById("tipo_credito").getElementsByTagName('option');
            var i;
            for (i = 0; i < x.length; i++) {
                console.log(response[0]['tipo']+'-'+x[i].value)

                if (x[i].value ==  response[0]['tipo']){
                    x[i].selected = 'selected';
                    break;
                }
            }

            $('#negocio-ganho').modal('show');
        }
    });

    });


    $('.pfechamento').datepicker({
        orientation: 'top',
        todayHighlight: true,
        format: "dd/mm/yyyy",
        defaultDate: +7
    });

    $('#valor_credito_md').mask('000.000.000.000.000,00', { reverse: true });
    $('#valor_credito').mask('000.000.000.000.000,00', { reverse: true });


  


</script>

@endsection