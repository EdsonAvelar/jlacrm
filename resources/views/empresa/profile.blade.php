<?php use App\Enums\UserStatus;

//config(['app.nome' => 'Teste']);

?>

@extends('main')



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

    .toggle.btn {
        width: 100% !important;
        height: 0rem !important;
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

    .card-body {
        padding: 1.5rem 1.5rem;
    }
</style>
@endsection

@section('main_content')
<!-- Start Content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <h5 class="mb-3 text-uppercase text-white  bg-info p-2"><i class="mdi mdi-office-building me-1"></i> LOGOS
            </h5>
            <div class="row">
                <div class="card text-center">
                    <h5>Logo Circular 512px x 512px (PNG) </h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('logos','/empresa_logo_circular.png')"
                                class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/logos/empresa_logo_circular.png"
                                    class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>


            <div class="row">
                <div class="card text-center">
                    <h5>Logo Horizontal 512px x 256px (PNG) </h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('logos','/empresa_logo_transparente.png')"
                                class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

            <div class="row">
                <div class="card text-center">
                    <h5>Logo Horizontal 1280px x 128px (PNG) </h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('logos','/empresa_logo_horizontal.png')"
                                class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/logos/empresa_logo_horizontal.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

            <div class="row">
                <div class="card text-center">
                    <h5>Logo Favicon 48px x 48px (ICO) </h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('logos','/favicon.ico')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/logos/favicon.ico"
                                    class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>



            <h5 class="mb-3 text-uppercase text-white bg-info p-2"><i class="mdi mdi-office-building me-1"></i> PROPOSTA
            </h5>

            <div class="row">
                <div class="card text-center">
                    <h5>Fundo Folha de Proposta (2048px x 3500px</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('proposta','/fundo_proposta.png')"
                                class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/proposta/fundo_proposta.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>


            <div class="row">
                <div class="card text-center">
                    <h5>Icone - Imovel (500x400)</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('proposta','/imovel.png')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/proposta/imovel.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>


            <div class="row">
                <div class="card text-center">
                    <h5>Icone - Caminhão (500x400)</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('proposta','/caminhao.png')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/proposta/caminhao.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

            <div class="row">
                <div class="card text-center">
                    <h5>Icone - Maquinario (500x400)</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('proposta','/maquinario.png')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/proposta/maquinario.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

            <div class="row">
                <div class="card text-center">
                    <h5>Icone - Veiculo (500x400)</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('proposta','/carro.png')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/proposta/carro.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

            <h5 class="mb-3 text-uppercase text-white bg-info p-2"><i class="mdi mdi-office-building me-1"></i> OUTROS
            </h5>
            <div class="row">
                <div class="card text-center">
                    <h5>Login - Background</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('outros','/background.png')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/outros/background.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

            <div class="row">
                <div class="card text-center">
                    <h5>Banner - 366px x 512px</h5>
                    <div class="card-body">

                        <p><a href="#" onclick="image_save('outros','/banner.png')" class="text-muted font-14">
                                <img src="{{ url('') }}/images/empresa/outros/banner.png"
                                    class="avatar-lx img-thumbnail" alt="profile-image">
                            </a></p>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>

        </div> <!-- end col-->



        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link rounded-0 active">
                                Editar Informações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#config" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                Configurações CRM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#marketing" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                Marketing
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane  show active" id="settings">
                            <form method="POST" action="{{ route('empresa_save') }}">
                                @csrf
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                    Informações da Empresa</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome Completo da Empresa</label>
                                            <input type="text" class="form-control" id="firstname"
                                                value="{{ config('nome') }}" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome Abreviado (minusculo e sem
                                                espaço)</label>
                                            <input type="text" class="form-control" value="{{ env('APP_SHORT_NAME') }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Telefone Principal <span
                                                    class="text-muted">*DDD e números sem simbolos</span></label>
                                            <input type="number" class="form-control" id="telefone"
                                                value="{{ config('telefone') }}" name="telefone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">WhatsApp Principal <span
                                                    class="text-muted">*apenas numeros</span></label>
                                            <input type="number" class="form-control" id="telefone"
                                                value="{{ config('whatsapp') }}" name="whatsapp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Endereço</label>
                                            <input type="text" class="form-control" id="lastname" name="endereco"
                                                value="{{ config('endereco') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">CNPJ</label>
                                            <input type="text" class="form-control" id="lastname" name="cnpj"
                                                value="{{ config('cnpj') }}"">
                                            </div>
                                        </div>
                                        <div class=" col-md-6">
                                            <div class="mb-3">
                                                <label for="lastname" class="form-label">E-mail</label>

                                                <input type="text" class="form-control" id="lastname" name="email"
                                                    value="{{ config('email') }}"">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class=" col-md-6">
                                                <div class="mb-3">
                                                    <label for="lastname" class="form-label">Site</label>
                                                    <input type="text" class="form-control" id="site" name="site"
                                                        value="{{ config('site') }}">
                                                </div>
                                            </div> <!-- end col -->



                                        </div>

                                        @if (\Auth::user()->hasRole('admin'))
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-success mt-2"><i
                                                        class="mdi mdi-content-save"></i> Atualizar</button>
                                            </div>
                                            <div class="col-6 text-end">
                                                <?php
                                                $ischecked = '';
                                                if ($user->status == UserStatus::ativo) {
                                                    $ischecked = 'checked';
                                                }
                                                
                                                ?>

                                            </div>
                                        </div>
                                        @endif

                            </form>
                        </div>
                        <!-- end settings content-->
                        <div class="tab-pane" id="marketing">

                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                INFORMAÇÕES DE MARKETING</h5>

                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="firstname" class="form-label">Nome</label>

                                        <button onclick="myFacebookLogin()" class="btn btn-primary">
                                            Facebook</button>

                                    </div>
                                </div>

                            </div> --}}


                        </div> <!-- end tab-pane -->


                        <div class="tab-pane" id="config">

                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                CONFIGURAÇÕES DE CRM</h5>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Produção</label>
                                        <input class="form-control btn btn-primary" type="text" name="daterange"
                                            id="datapicker_config" value="
                                                @if (config('data_inicio')) {{ config('data_inicio') }} - {{ config('data_fim') }} @endif
                                                " />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="
verde - criado hoje
branco - dentro da janela de 2 dias
amarelo - de 3 a  5 dias parados
vermelho mais do que 5 dias parados
                                                ">
                                            <label for="inputEmail3" class="col-form-label">Cards Coloridos <span
                                                    class="mdi mdi-information"></span>
                                            </label> </span>

                                        <input class="toggle-event" type="checkbox" <?php if
                                            (array_key_exists('card_colorido', $empresa)) { if
                                            ($empresa['card_colorido']=='true' ) { echo 'checked' ; } } ?>
                                        data-config_info="card_colorido" data-toggle="toggle" data-on="colorido"
                                        data-off="sem cor" data-onstyle="success" data-offstyle="danger">
                                    </div>

                                    <div class="mb-3">
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                            <label for="inputEmail3" class="col-form-label">Gráficos Cor Aleatória
                                                <span class="mdi mdi-information"></span>
                                            </label> </span>

                                        <input class="toggle-event" type="checkbox" <?php if
                                            (array_key_exists('grafico_cor_aleatoria', $empresa)) { if
                                            ($empresa['grafico_cor_aleatoria']=='true' ) { echo 'checked' ; } } ?>
                                        data-config_info="grafico_cor_aleatoria" data-toggle="toggle"
                                        data-on="aleatoria" data-off="cor fixa" data-onstyle="success"
                                        data-offstyle="danger">
                                    </div>


                                </div>
                            </div>

                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                TOKEN WEBHOOK</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Insira um token SHA1 Hash</label>
                                        <label>
                                            <p>Exemplo de chamada: curl -X POST http://{{url('')}}/api/webhook/newlead
                                                -H "Authorization: {{config('token_webhook')}}" -d '{"nome":
                                                "test1", "tipo_credito":"IMOVEL", "telefone":"123",
                                                "whatsapp":"123","id":"1"}'</p>
                                        </label>

                                        <input class="form-control" type="text" name="token_webhook" id="token_webhook"
                                            value="{{config('token_webhook')}}" />
                                    </div>
                                </div>
                            </div>


                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                CONFIGURAÇÕES CORRIDA</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Valor Máximo de Vendas</label>
                                        <input class="form-control" type="number" name="racing_vendas_max"
                                            id="racing_vendas_max" value="{{config('racing_vendas_max')}}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Valor Máximo de Agendamentos Diários</label>
                                        <input class="form-control" type="number" name="racing_agendamento_max" id="racing_agendamento_max"
                                            value="{{config('racing_agendamento_max')}}" />
                                    </div>
                                </div>
                            </div>




                        </div> <!-- end tab-pane -->
                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
</div> <!-- container -->


<div class="modal fade" id="change_logo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Foto de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="p-2" action="{{ route('empresa_images') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Faça o Upload da Sua
                                            Imagem<span class="text-danger">
                                                *</label>
                                        <input type="file" name="image" id="inputImage"
                                            class="form-control @error('image') is-invalid @enderror">
                                        <input name="user_id" hidden value={{ app('request')->id }}>
                                        <br>
                                        <img id="myImg" class="rounded-circle avatar-lg img-thumbnail" src="#">
                                        <input name="pasta_imagem" id="pasta_imagem" hidden />
                                        <input name="imagem_name" id="imagem_name" hidden />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                            Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('specific_scripts')
<script>
    window.fbAsyncInit = function() {
            FB.init({
                appId: '1384940535738260',
                xfbml: true,
                version: 'v18.0'
            });
        };



        function myFacebookLogin() {
            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('Welcome!  Fetching your information.... ');
                    FB.api('/me', function(response) {
                        console.log('Good to see you, ' + response.name + '.');
                    });
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {
                scope: 'manage_pages'
            });
        }
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>


<script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function image_save($folder, $imgname) {

            $('#pasta_imagem').val($folder);
            $('#imagem_name').val($imgname);

            $('#change_logo').modal('show');
        }

        function save_config(config_info, config_value) {


            info = [];
            info[0] = config_info;
            info[1] = config_value;

            $.ajax({
                url: "{{ url('empresa/config') }}",
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
                    console.log(res);
                    showAlert({
                        message: res,
                        class: "danger"
                    });
                },
            });
        }






        $('.toggle-event').change(function($this) {

            var config_info = $(this).data('config_info');
            var config_value = $(this).prop('checked');

            save_config(config_info, config_value);

        });


        $('body').on('click', '.confirm-delete', function(e) {
            //MSK-000122		
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            document.getElementById('yes_no').value = id;

            $('#nome_permissao').text(name);
            $('#revogarPermissao').data('id1', id).modal('show'); //MSK-000123
        });

        /* The uploader form */
        $(function() {
            $(":file").change(function() {
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

        $(document).ready(function() {


            $('#datapicker_config').daterangepicker({
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                },
                function(start, end, label) {

                    save_config('data_inicio', start.format('DD/MM/YYYY'));
                    save_config('data_fim', end.format('DD/MM/YYYY'));

                });


                // Salvando Configurações de INPUT
                 document.getElementById('token_webhook').addEventListener('blur', function(e){ 
                     save_config('token_webhook', e.target.value)
                 });
                 
                 document.getElementById('racing_agendamento_max').addEventListener('blur', function(e){ 
                     save_config('racing_agendamento_max', e.target.value)
                 });


                document.getElementById('racing_vendas_max').addEventListener('blur', function(e){
                    save_config('racing_vendas_max', e.target.value)
                });
            
        });
</script>
@endsection