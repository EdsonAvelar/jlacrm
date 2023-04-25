@extends('main')


@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="{{url('')}}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
    input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  padding: 10px;
}

#info_label{
    padding: 10px;
    color: #000080;
}

.visible {
  visibility: visible;
}
.invisible {
  visibility: hidden;
}

.scroll { border:1px solid #ccc; width:200px; height: 200px; overflow-y: scroll;}


</style>



@endsection

@section('main_content')

<form id="target" action="{{url('negocios/changemassive')}}" method="POST">

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
                                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        
                                        @if( !is_null( $proprietario))
                                            {{$proprietario->name}}
                                        @elseif (app('request')->status == 'inativo')
                                            Inativos
                                        @elseif ( app('request')->proprietario == -2)
                                            Todos
                                        @else
                                            Não Atribuidos
                                        @endif

                                    </button>

                                    @if (isset($proprietarios))
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach ($proprietarios as $proprietario_id => $value)
                                        <a class="dropdown-item" target="_self"
                                            href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  $proprietario_id, 'view' => 'list','status' => 'ativo') )}}">{{$value}}</a>
                                        @endforeach

                                            @if (Auth::user()->hasAnyRole( ['admin']) )
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" target="_self"
                                                href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  '-1', 'view' => 'list', 'status' => 'ativo'  ) )}}">Não Atribuido</a>
                                            <a class="dropdown-item" target="_self"
                                                href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  '-2','view' => 'list', 'status' => 'inativo' ) )}}">Inativos</a>
                                            
                                                @endif
                                        
                                            @if (Auth::user()->hasAnyRole( ['gerenciar_equipe']) )
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" target="_self"
                                                    href="{{route('pipeline_index', array('id' => $curr_funil_id, 'proprietario' =>  '-2', 'view' => 'list', 'status' => 'ativo'  ) )}}">Todos</a>
                                            @endif
                                        
                                    </div>
                                    @endif
                                    
                               

                                    </li>
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Funils
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach ($funils as $id => $value)
                                        <a class="dropdown-item"
                                            href="{{route('pipeline_index', array('pipeline_id' => $id , 'view' => 'list') )}}">{{$value}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <h4 class="page-title">Negócios
                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-new-task-modal" id="add_button"
                                    class="btn btn-info btn-sm ms-3">+ Add</a>

                                <a type="button" class="btn btn-secondary btn-sm ms-3 checkbox_sensitive" id="atribuir_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Atribuir</a>

                                <a type="button" class="btn btn-secondary btn-sm ms-3 checkbox_sensitive"  id="distribuir_btn" data-bs-toggle="modal" data-bs-target="#distribuirModal">
                                Distribuir</a>
                                
                                @if (Auth::user()->hasRole('admin'))
                                <a type="button" class="btn btn-danger btn-sm ms-3 checkbox_sensitive"  id="desativar_btn" data-bs-toggle="modal" data-bs-target="#desativarModal">
                                Desativar</a>
                                
                                <a type="button" class="btn btn-success btn-sm ms-3 checkbox_sensitive"  id="ativar_btn" data-bs-toggle="modal" data-bs-target="#ativarModal">
                                Ativar</a>

                                @endif

                            </h4>


                        </div>
                    </div>
                 

                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        
                        <label id="info_label"></label>
                        
                        <table id="example" class="table table-striped"  class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                    <input type="checkbox" id="selectall" class="select-checkbox">
                                    </th>
                                    <th>Titulo</th>
                                    <th>Pessoa de Contato</th>
                                    <th>Telefone</th>
                                    <th>Valor</th>
                                    <th>Etapa</th>
                                    <th>Proprietário</th>
                                    <th>Criado em</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($negocios))
                                @foreach ($negocios as $negocio)
                                <tr>
                                    <td><input type="checkbox" id="chkBSA" name="negocios[]" value="{{$negocio->id}}" class="select-checkbox"></td>
                                    <td><a href="{{ route('negocio_edit', array('id' => $negocio->id)) }}">{{
                                            $negocio->titulo }}</a></td>
                                    <td>{{$negocio->lead->nome }}</td>
                                    <td><a href="tel:{{$negocio->lead->telefone}}">{{$negocio->lead->telefone }}</a> </td>
                                    <td>{{ $negocio->valor }}</td>
                                    <td>{{ $negocio->etapa_funil->nome }}</td>
                                   
                                    <td>
                                        @if (is_null($negocio->user))
                                            Não Atribuido
                                        @else 
                                            {{ $negocio->user->name }}
                                        @endif
                                    
                                    </td>
                                    <td>{{ $negocio->created_at }}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div> <!-- container -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atribuir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h6 class="mt-2">Proprietário</h6>
                <div class="mb-1 nowrap w-100">
                    <select class="form-select form-control-light" id="task-priority" name="novo_proprietario_id">
                        <option value="-1" selected="true">SEM PROPRIETÁRIO</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer ">
                <input type="text" name="id" hidden value="{{app('request')->id}}">
                <input type="submit" class="btn btn-success mt-2" id="atribuir_enviar" value="Enviar">
                <input type="button" class="btn btn-danger mt-2 atribuir" data-bs-dismiss="modal" value="Cancelar">
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
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
                     <h3>Deseja mesmo <span class="bg-danger text-white">Desativar</span> os Negócios Selecionados?</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="distribuir-div">
                <input type="text" name="id" hidden value="{{app('request')->id}}">
                <input type="submit" class="btn btn-success mt-2" value="SIM">
                <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal" value="Cancelar">
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
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
                     <h3>Deseja mesmo <span class="bg-success text-white">Ativar</span> os Negócios Selecionados?</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="distribuir-div">
                <input type="text" name="id" hidden value="{{app('request')->id}}">
                <input type="submit" class="btn btn-success mt-2" value="SIM">
                <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal" value="Cancelar">
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
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
                        <img src="{{url('')}}/images/distribuicao.png" width="200px">
                    </div>
                    <div class="col-4 scroll">
                        @foreach ($users as $user)
                            <input type="checkbox" name="usuarios[]" value="{{$user->id}}" class="select-user"/> {{$user->name}}<br>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="modal-footer" id="distribuir-div">
                <input type="text" name="id" hidden value="{{app('request')->id}}">
                <input type="submit" class="btn btn-success mt-2" value="Enviar">
                <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal" value="Cancelar">
            </div>
        </div>
    </div>
</div>

<input type="text" name="modo"  id="modo" hidden value="">
</form>


<!--  Add new task modal -->
<div class="modal fade task-modal-content" id="add-new-task-modal" tabindex="-1" role="dialog"
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
                                        <label for="task-title" class="form-label">Título<span
                                                class="text-danger"> *</span></label>
                                        <input type="text" class="form-control form-control-light" id="task-title"
                                            name="titulo" placeholder="Digite o titulo do negócio" required
                                            value="Casa Pirituba 100k">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Tipo de Crédito</label>
                                        <select class="form-select form-control-light" id="task-priority">
                                            <option>Imóvel</option>
                                            <option>Veiculo Leve</option>
                                            <option>Veiculo Pesado</option>
                                            <option>Terreno</option>
                                            <option>Serviço</option>
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
                                        <input type="text" class="form-control form-control-light" id="pfechamento"
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
                                                class="text-danger"> *</span></label>
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


@endsection

@section('specific_scripts')

<script src="{{url('')}}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{url('')}}/js/vendor/dataTables.bootstrap5.js"></script>


<script>



    $(document).ready(function () {

        
        $("#atribuir_btn").on("click",function(){
            document.getElementById('modo').value = 'atribuir';
        });

        $("#distribuir_btn").on("click",function(){
            document.getElementById('modo').value = 'distribuir';
        });

        $("#desativar_btn").on("click",function(){
            document.getElementById('modo').value = 'desativar';
        });

        $("#ativar_btn").on("click",function(){
            document.getElementById('modo').value = 'ativar';
        });
          
        $('.checkbox_sensitive').hide();
        
            let example = $('#example').DataTable({
        });

        let selectall = false;

        function handleTableClick(){
            const urlParams = new URLSearchParams(window.location.search);
            const param_x = urlParams.get('status');
            
            numberNotChecked = $('input:checkbox:checked').length;
            console.log("Checked:"+$('input:checkbox:checked').length);
            if (selectall) {
                numberNotChecked = numberNotChecked -1;
                selectall = false;
            }
            if (numberNotChecked < 1){
                $("#info_label").text("");
                $('.checkbox_sensitive').hide();

            }else if(numberNotChecked < 2){            
                
                $("#info_label").text(numberNotChecked + " Negócio Selecionado");
                $('#selected_qnt').html(numberNotChecked + " <br>Negócio Selecionado");
                $('.checkbox_sensitive').show();
            }else {
                $("#info_label").text(numberNotChecked + " Negócios Selecionados");
                $('#selected_qnt').html(numberNotChecked + " <br>Negócio Selecionados")
                $('.checkbox_sensitive').show();
            }

            if (param_x == 'ativo'){
                $('.checkbox_sensitive').show();
                $('#ativar_btn').hide();

            }else{ 
                $('.checkbox_sensitive').hide();
                $('#ativar_btn').show();
                
            }

            if (numberNotChecked == 0){
                $('#ativar_btn').hide();
                $('.checkbox_sensitive').hide();
            }
        }

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


        $(document).on("change", "#chkBSA", function() {
            handleTableClick()
        });



        $("input:checkbox[class='select-checkbox']").on( "click", function() {

           
        });

        $('#valor_credito').mask('R$ 000.000.000.000.000,00', { reverse: true });
        $('.telefone').mask('(00) 00000-0000');

        $('#pfechamento').datepicker({
            orientation: 'top',
            todayHighlight: true,
            format: "dd/mm/yyyy",
            defaultDate: +7
        });

 

    });



</script>
@endsection