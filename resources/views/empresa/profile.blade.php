<?php use App\Enums\UserStatus;


//config(['app.nome' => 'Teste']);

?>

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
<style>
    touch-action: none;
    /* Image Designing Propoerties */
    .thumb {
        height: 100px;
        width: 100px;
        border: 1px solid #000;
        margin: 10px 5px 0 0;
    }
</style>
@endsection

@section('main_content')

<!-- Start Content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{url('')}}/images/users/user_{{$user->id}}/{{$user->avatar}}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" onclick="myfunction()">
                    
                </div> <!-- end card-body -->
            </div> <!-- end card -->

        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    <li class="nav-item">
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                Editar Informações
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane  show active" id="settings">
                            <form method="POST" action="{{route('empresa_save')}}">
                                @csrf
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Informações da Empresa</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome Completo da Empresa</label>
                                            <input type="text" class="form-control" id="firstname" value="{{config('nome')}}" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome Abreviado (minusculo e sem espaço)</label>
                                            <input type="text" class="form-control" value="{{env('APP_SHORT_NAME')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Telefone Principal <span class="text-muted">*DDD e números sem simbolos</span></label>
                                            <input type="number" class="form-control" id="telefone" value="{{config('telefone')}}" name="telefone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">WhatsApp Principal <span class="text-muted">*apenas numeros</span></label>
                                            <input type="number" class="form-control" id="telefone" value="{{config('whatsapp')}}" name="whatsapp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Endereço</label>
                                            <input type="text" class="form-control" id="lastname" name="endereco" value="{{config('endereco')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">CNPJ</label>
                                            <input type="text" class="form-control" id="lastname" name="cnpj" value="{{config('cnpj')}}"">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">E-mail</label>
                                           
                                            <input type="text" class="form-control" id="lastname" name="email" value="{{config('email')}}"">
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Site</label>
                                            <input type="text" class="form-control" id="site" name="site" value="{{config('site')}}"">
                                        </div>
                                    </div> <!-- end col -->

                       

                                </div> 

                                @if (\Auth::user()->hasRole('admin'))

                                <div class="row">
                                    <div class="col-6">
                                    <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Atualizar</button>
                                    </div>
                                    <div class="col-6 text-end">
                                    <?php
                                        $ischecked = "";
                                        if ( $user->status == UserStatus::ativo ){
                                            $ischecked = "checked";
                                        }

                                        ?>

                                </div>
                                </div>
                             
                                @endif
                                
                            </form>
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
   

</div> <!-- container -->



@endsection

@section('specific_scripts')

<script type="text/javascript">

    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

 


    $('.toggle-event').change(function($this) {

        var user_id = $(this).data('user_id'); 
        console.log( $(this).prop('checked') + " user "+ user_id );

        info = [];
        info[0] = $(this).prop('checked');
        info[1] = user_id;

        $.ajax({
            url: "{{url('funcionarios/ativar_desativar')}}",
            type: 'post',
            data: { info: info },
            Type: 'json',
            success: function (res) {
                console.log("Funcionario atualizada com sucesso: " )
                showAlert({message: res, class:"success"});
            },
            error: function (res) {
                console.log(res);
                showAlert({message: res, class:"danger"});
            },
        });

    });


    $('body').on('click', '.confirm-delete', function (e){
        //MSK-000122		
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        document.getElementById('yes_no').value = id;

        $('#nome_permissao').text(name);
        $('#revogarPermissao').data('id1', id).modal('show');//MSK-000123
    });

    /* The uploader form */
    $(function () {
        $(":file").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function imageIsLoaded(e) {
        $('#myImg').attr('src', e.target.result);
    };


    $('#data_contratacao').datepicker({
        orientation: 'top',
        todayHighlight: true,
        format: "dd/mm/yyyy",
        defaultDate: +7
    });



</script>


@endsection