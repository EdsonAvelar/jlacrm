<?php use App\Enums\UserStatus; 
use Illuminate\Support\Facades\Hash;?>
@extends('main')

@section('headers')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="{{url('')}}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
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

#info_label {
    padding: 10px;
    color: #000080;
}

.mdi-18px { font-size: 18px; }
.mdi-24px { font-size: 24px; }
.mdi-36px { font-size: 36px; }
.mdi-48px { font-size: 48px; }

i.icon-success {
    color: green;
}

i.icon-danger {
    color: red;
}
</style>

@endsection
@section('main_content')


<!-- Start Content-->
<div class="container-fluid">

    <div class="row">

        <div class="col-12">
        <div class="page-title-right"></div>
            <div class="card">
                <div class="card-body left">
                    <h4 class="header-title m-t-0">Funcionários Ativos</h4>
                        </h4>
                        <div class="mb-3">
                                    <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-new-task-modal">+ Adicionar</a>
                                </div>
                  
                                <label id="info_label"></label>
                    <table id="example" class="table w-100 nowrap" >
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Cargo</th>
                                <th>Permissioes</th>
                                <th>Telefone</th>
                                <th>Resetada?</th>
                                <th>Data Contratacao</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($users))
                            @foreach ($users as $user)
                            <tr>
                            <?php
                                $ischecked = "";
                                if ( $user->status == UserStatus::ativo ){
                                    $ischecked = "checked";
                                }

                                ?>
                                @if ($user->hasRole('admin'))
                                    <td></td> 
                                @else 
                                    <td><input class="toggle-event"  type="checkbox" <?php echo $ischecked; ?> data-user_id="{{$user->id}}" data-toggle="toggle" data-on="Ativo" data-off="Inativo" data-onstyle="success" data-offstyle="danger"></td>
                                @endif 
                                
                                <td>
                                    <img src="{{url('')}}/images/users/user_{{$user->id}}/{{$user->avatar}}" alt="user-img" class="avatar-xs rounded-circle me-1">
                                    <a href="{{route('users_profile', array('id'=> $user->id) )}}"> {{$user['name']}}</a></td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user->cargo->nome}}</td>
                                <td>
                                    @if ( $user->roles() )
                                        <?php $perms = 1 ?>
                                        @foreach ($user->roles as $role)
                                        <span class="badge badge-info-lighten">{{$role->name}}</span>

                                                @if ($perms > 2 )
                                                    <br>
                                                    <?php $perms = 0; ?>
                                                @endif
                                            <?php $perms = $perms + 1; ?>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{$user['telefone']}}</td>
                                <td>
                                
                                
                                @if ( Hash::check('jla2021', $user['password']))
                                    <span class="badge badge-danger-lighten">Não Resetada</span>
                                @else 
                                <span class="badge badge-success-lighten">OK</span>
                                @endif


                                </td>
                                <td>{{$user['data_contratacao']}}</td>
                               
                            </tr>

                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
    <!-- end row -->

    

</div>
<!--  Add new task modal -->
<div class="modal fade task-modal-content" id="add-new-task-modal" tabindex="-1" role="dialog"
    aria-labelledby="NewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="NewTaskModalLabel">Adicionar Funcionário</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="p-2" action="{{route('funcionarios.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-6">
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Nome<span
                                                class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-light" 
                                    name="name" required>
                            </div>
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Email<span
                                                class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-light" 
                                    name="email" required>
                            </div>
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Senha Provisoria<span
                                                class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-light"
                                    name="password" value="jla2021" required>
                            </div>
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Cargo</label>
                                <select class="form-select form-control-light" name="cargo_id">
                                    @foreach (\App\Models\Cargo::all() as $cargo)
                                    <option value="{{$cargo->id}}">{{$cargo->nome}}</option>
                                    @endforeach
                                </select>
                            
                            </div>
                            
                            <div class="mb-12">
                                <label for="task-priority" class="form-label">Data Contratação</label>
                                <input type="text" class="form-control form-control-light" id="data_contratacao"
                                    data-single-date-picker="true" name="data_contratacao" value="<?php echo date("d/m/Y"); ?>">
                            </div>
                        </div>
                        <!-- Painel Esquedo -->
                        <div class="col-md-6" style="border-left: 1px solid rgb(228 230 233);">                           
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Telefone</label>
                                <input type="text" class="form-control form-control-light" 
                                    placeholder="Digite nome"  name="telefone" id="telefone">
                            </div>
                            <div class="mb-12">
                                <label for="task-title" class="form-label">CPF</label>
                                <input type="text" class="form-control form-control-light" 
                                    placeholder="Digite nome" name="cpf" id="cpf">
                            </div>
                            <div class="mb-12">
                                <label for="task-title" class="form-label">RG</label>
                                <input type="text" class="form-control form-control-light" 
                                    placeholder="Digite nome" name="rg">
                            </div>
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Endereço</label>
                                <input type="text" class="form-control form-control-light" 
                                    placeholder="Digite nome" name="endereco">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <br>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('specific_scripts')

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="{{url('')}}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{url('')}}/js/vendor/dataTables.bootstrap5.js"></script>
<script>

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


$(document).ready(function () {

    let example = $('#example').DataTable({
        scrollX: true,
        scrollY: true,
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

    $("input:checkbox[class='select-checkbox']").on( "click", function() {
        let numberNotChecked = $('input:checkbox:checked').length;
        if (selectall) {
            numberNotChecked = numberNotChecked -1;
            selectall = false;
        }
        if (numberNotChecked < 1){
            $("#info_label").text("");
        }else if(numberNotChecked < 2){
            $("#info_label").text(numberNotChecked + " Negócio Selecionado");
        }else {
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


   
    $(function() {
        $('.toggle-event').change(function($this) {

            var user_id = $(this).data('user_id'); 
          //console.log( $(this).prop('checked') + " user "+ user_id );

            info = [];
            info[0] = $(this).prop('checked');
            info[1] = user_id;

            $.ajax({
                url: "{{url('funcionarios/ativar_desativar')}}",
                type: 'post',
                data: { info: info },
                Type: 'json',
                success: function (res) {
                    console.log("Funcionario atualizada com sucesso")
                }
            });

        })
    });
   
});

</script>


@endsection