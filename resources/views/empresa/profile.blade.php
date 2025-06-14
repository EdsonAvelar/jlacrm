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

    .text-example {
        font-size: 16px;
        background-color: #00aeff09;
        padding: 10px;
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

    .card {
        border: none;
        -webkit-box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        margin-bottom: 24px;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 200px;
        height: auto;
    }

    .protocol_result {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        -webkit-box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        padding: 10px;
    }
</style>
@endsection

@section('main_content')
<!-- Start Content-->
<div class="container-fluid">

    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#artes" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link rounded-0 active">
                                Artes do Site
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
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
                        <div class="tab-pane show active" id="artes">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Circular 512px x 512px (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('logos','/empresa_logo_circular.png')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_circular.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="rounded-circle avatar-lg img-thumbnail"
                                                        alt="Logo Circular">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>


                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Horizontal 512px x 256px (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#"
                                                    onclick="image_save('logos','/empresa_logo_transparente.png','retangular')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="Logo Horizontal">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Horizontal 1280px x 128px (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#"
                                                    onclick="image_save('logos','/empresa_logo_horizontal.png','retangular')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_horizontal.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="Logo Horizontal">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Favicon 48px x 48px (ICO) </h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('logos','/favicon.ico')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/favicon.ico"
                                                        class="rounded-circle avatar-lg img-thumbnail" alt="Logo Icone">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Marga D'Agua - 1000px x 1000px (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('logos','/marcadagua.png')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/marcadagua.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="Marca D'Agua">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Ranking - 1280 x 720 (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#"
                                                    onclick="image_save('logos','/empresa_ranking.png','retangular')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/empresa_ranking.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="Logo Empresa Ranking">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Fera de Vendas - Ranking - 350 x 90 (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#"
                                                    onclick="image_save('logos','/empresa_ranking_fera.png','retangular','350','90')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/empresa_ranking_fera.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="Logo Empresa Ranking">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Logo Fera Gold de Vendas - Ranking - 350 x 90 (PNG) </h5>
                                        <div class="card-body">

                                            <p><a href="#"
                                                    onclick="image_save('logos','/empresa_ranking_feragold.png','retangular','350','90')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/logos/empresa_ranking_feragold.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="Logo Ranking Fera Gold">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>



                                <h5 class="mb-3 text-uppercase text-white bg-info p-2"><i
                                        class="mdi mdi-office-building me-1"></i> PROPOSTA
                                </h5>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Fundo Folha de Proposta (2048px x 3500px</h5>
                                        <div class="card-body">

                                            <p><a href="#"
                                                    onclick="image_save('proposta','/fundo_proposta.png','livre','2048','3500')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/proposta/fundo_proposta.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>


                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Icone - Imovel (500x400)</h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('proposta','/imovel.png')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/proposta/imovel.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>


                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Icone - Caminhão (500x400)</h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('proposta','/caminhao.png')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/proposta/caminhao.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Icone - Maquinario (500x400)</h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('proposta','/maquinario.png')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/proposta/maquinario.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Icone - Veiculo (500x400)</h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('proposta','/carro.png')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/proposta/carro.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <h5 class="mb-3 text-uppercase text-white bg-info p-2"><i
                                        class="mdi mdi-office-building me-1"></i> OUTROS
                                </h5>
                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Login - Background</h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('outros','/background.png','livre')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/outros/background.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <h5>Banner - 366px x 512px</h5>
                                        <div class="card-body">

                                            <p><a href="#" onclick="image_save('outros','/banner.png','livre')"
                                                    class="text-muted font-14">
                                                    <img src="{{ url('') }}/images/empresa/outros/banner.png?{{ \Carbon\Carbon::now()->timestamp }}"
                                                        class="avatar-lx img-thumbnail" alt="profile-image">
                                                </a></p>

                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div>

                            </div>


                        </div>



                        <div class="tab-pane show" id="settings">
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
                                INTEGRAÇÃO LEADS COM CRM</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">
                                            É possivel conectar o CRM para cadastros de leads automaticamente através de
                                            WEBHOOK.

                                            Para realizar a conexão você precisa de
                                            um token SHA1 Hash Válido. <a href="http://www.sha1-online.com/">Clique
                                                aqui para gerar</a></label>
                                        <label>Copie e Cole o Token Abaixo</label>
                                        <input class="form-control" type="text" name="token_webhook" id="token_webhook"
                                            value="{{config('token_webhook')}}" />




                                    </div>
                                    <div class="mb-3">
                                        <h5 class="text-uppercase">Conexão via CURL</h5>
                                        É possível conectar diretamente via CURL usando o comando abaixo
                                        <p class="text-example">

                                            curl -X POST {{url('')}}/api/webhook/newlead
                                            -H "Authorization: Bearer {{config('token_webhook')}}" -d
                                            '{"nome":"Nome Cliente","telefone":"1123456789",
                                            "email":"client@com.br","campanha":"FaceAds-Cadastro-Imovel","fonte":"FACEBOOK","tipo_do_bem":"IMOVEL","proprietario_id":"-1"}'
                                        </p>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <h5 class="text-uppercase">Conexão via MAKE</h5>
                                        É possível conectar qualquer plataforma via make (<a
                                            href="https://www.make.com/">https://www.make.com/</a>)
                                        <pre class="text-example">
Crie um Eevento do Tipo Facebook lead Ads, 
configura o webhook da conta do facebook
e da sua página, depois selecione o formulario e salve.

Após isso, adicione outro modulo

Tipo de Trigger: <b>HTTP</b>

Actions: <b>Make a Request</b>

PRECHA AS INFORMAÇÕES ABAIXO

<b>URL: </b>
{{url('')}}/api/webhook/newlead

<b>Method: </b>
POST

<b>Header:</b>
Name: Authorization
Value: Bearer {{config('token_webhook')}}

Name: Content-Type
Value: application/json

<b>Body Type: </b>
Raw

<b>Content type: </b>
JSON (Application/json)

Mude o que está em asterisco pelo campo do formulario do 
facebook:
<b>Request content</b>
{
    "nome": "*campo nome*",
    "telefone": "*campo telefone*",
    "email": "*email* ",
    "campanha": " *camapanha* ",
    "fonte": " *platforma* ",
    "tipo_do_bem": "IMOVEL",
    "proprietario_id": "-1"
}
</pre>

                                        </p>
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    Teste
                                </div>

                            </div>



                        </div> <!-- end tab-pane -->


                        <div class="tab-pane" id="config">
                            <div class="row">

                                {{-- COLUNA DA ESQUERDA --}}
                                <div class="col-md-6">

                                    {{-- <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                        CONFIGURAÇÕES DE CRM</h5>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-12">
                                                <label for="lastname" class="form-label">Produção</label>
                                                <input class="form-control btn btn-primary" type="text" name="daterange"
                                                    id="datapicker_config" value="
                                                @if (config('data_inicio')) {{ config('data_inicio') }} - {{ config('data_fim') }} @endif
                                                " />
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-12">




                                            <div class="mb-3">
                                                <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                                    GRÁFICOS E CARDS</h5>
                                                <div class="row">

                                                    <div class="col-md-4">

                                                        <label for="inputEmail3" class="col-form-label">Cards Coloridos
                                                            <span class="mdi mdi-information"></span>
                                                        </label> </span>

                                                        <input class="toggle-event" type="checkbox" <?php if
                                                            (array_key_exists('card_colorido', $empresa)) { if
                                                            ($empresa['card_colorido']=='true' ) { echo 'checked' ; } }
                                                            ?>
                                                        data-config_info="card_colorido" data-toggle="toggle"
                                                        data-on="colorido"
                                                        data-off="sem cor" data-onstyle="success"
                                                        data-offstyle="danger">

                                                    </div>
                                                    <div class="col-md-4">

                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="inputEmail3" class="col-form-label">Gráficos Cor
                                                                Aleatória
                                                                <span class="mdi mdi-information"></span>
                                                            </label> </span>

                                                        <input class="toggle-event" type="checkbox" <?php if
                                                            (array_key_exists('grafico_cor_aleatoria', $empresa)) { if
                                                            ($empresa['grafico_cor_aleatoria']=='true' ) {
                                                            echo 'checked' ; } } ?>
                                                        data-config_info="grafico_cor_aleatoria" data-toggle="toggle"
                                                        data-on="aleatoria" data-off="cor fixa" data-onstyle="success"
                                                        data-offstyle="danger">

                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="inputEmail3" class="col-form-label">Exibir
                                                                Vendedores Zerados
                                                                <span class="mdi mdi-information"></span>
                                                            </label> </span>

                                                        <input class="toggle-event" type="checkbox" <?php if
                                                            (array_key_exists('grafico_exibir_zerados', $empresa)) { if
                                                            ($empresa['grafico_exibir_zerados']=='true' ) {
                                                            echo 'checked' ; } } ?>
                                                        data-config_info="grafico_exibir_zerados" data-toggle="toggle"
                                                        data-on="Exibir Zerados" data-off="Não Exibir Zerados"
                                                        data-onstyle="success"
                                                        data-offstyle="danger">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                                    NOTIFICAÇÃO DE NOVA VENDA</h5>
                                                <div class="row">

                                                    <div class="col-md-4">

                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="lastname"
                                                                class="form-label">Ligar/Desligar</label>
                                                            </label> </span>


                                                        <input class="toggle-event" type="checkbox" <?php if
                                                            (array_key_exists('broadcast_fechamento', $empresa)) { if
                                                            ($empresa['broadcast_fechamento']=='true' ) { echo 'checked'
                                                            ; } } ?>
                                                        data-config_info="broadcast_fechamento"
                                                        data-toggle="toggle"
                                                        data-on="Notificação Ligada" data-off="Notificação
                                                        Desligada"
                                                        data-onstyle="success"
                                                        data-offstyle="danger">

                                                    </div>
                                                    <div class="col-md-4">

                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="lastname" class="form-label">Som de
                                                                Aplauso</label>
                                                            </label> </span>


                                                        <input class="toggle-event" type="checkbox" <?php if
                                                            (array_key_exists('broadcast_audio', $empresa)) { if
                                                            ($empresa['broadcast_audio']=='true' ) { echo 'checked' ; }
                                                            } ?>
                                                        data-config_info="broadcast_audio"
                                                        data-toggle="toggle"
                                                        data-on="Aplauso ligado" data-off="Aplauso
                                                        desligado"
                                                        data-onstyle="success"
                                                        data-offstyle="danger">

                                                    </div>
                                                    <div class="col-md-4">

                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="lastname" class="form-label">Nome do
                                                                Canal</label>
                                                            </label> </span>
                                                        <input class="form-control" type="text" name="broadcast_canal"
                                                            id="broadcast_canal"
                                                            value="{{config('broadcast_canal')}}" />
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mb-3">
                                                <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                                    CONFIGURAÇÃO LISTAS DE NEGÓCIOS</h5>
                                                <div class="row">

                                                    <div class="col-md-4">

                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="inputEmail3" class="col-form-label">Permitir
                                                                Deletar
                                                                Negócio
                                                                <span class="mdi mdi-information"></span>
                                                            </label> </span>

                                                        <input class="toggle-event" type="checkbox" <?php if
                                                            (array_key_exists('permitir_deletar_negocio', $empresa)) {
                                                            if ($empresa['permitir_deletar_negocio']=='true' ) {
                                                            echo 'checked' ; } } ?>
                                                        data-config_info="permitir_deletar_negocio" data-toggle="toggle"
                                                        data-on="deleção ligado" data-off="deleção desligado"
                                                        data-onstyle="success"
                                                        data-offstyle="danger">

                                                    </div>
                                                    <div class="col-md-4">

                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="">
                                                            <label for="lastname" class="form-label">Negócio Parado
                                                                (dias)</label>
                                                            </label> </span>
                                                        <input class="form-control" type="number" name="negocio_parado"
                                                            id="negocio_parado" value="{{config('negocio_parado')}}" />

                                                    </div>
                                                    <div class="col-md-4">


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- COLUNA DA ESQUERDA --}}

                                    <div class="row">
                                        <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                            PERSONALIZAÇÃO DO PROTOCOLO DE AGENDAMENTO</h5>
                                        <div class="col-md-6">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Inicio</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_inicio"
                                                id="protocolo_agendamento_inicio"
                                                value="{{config('protocolo_agendamento_inicio')}}"
                                                placeholder="Parabéns " />
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Após Nome</label>
                                                </label> </span>
                                            <input class="form-control" type="text"
                                                name="protocolo_agendamento_pos_inicio"
                                                id="protocolo_agendamento_pos_inicio"
                                                value="{{config('protocolo_agendamento_pos_inicio')}}"
                                                placeholder=",esse é o primeiro passo para realização do seu sonho" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Titulo Agendamento</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_titulo"
                                                id="protocolo_agendamento_titulo"
                                                value="{{config('protocolo_agendamento_titulo')}}"
                                                placeholder="-= Reunião Agendada =-" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Final</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_final"
                                                id="protocolo_agendamento_final"
                                                value="{{config('protocolo_agendamento_final')}}"
                                                placeholder="🏡🚗🏍✅ Estacionamento Gratuito" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Nome Empresa</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_empresa"
                                                id="protocolo_agendamento_empresa"
                                                value="{{config('protocolo_agendamento_empresa')}}" placeholder="" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Endereço</label>
                                                </label> </span>
                                            <input class="form-control" type="text"
                                                name="protocolo_agendamento_endereco"
                                                id="protocolo_agendamento_endereco"
                                                value="{{config('protocolo_agendamento_endereco')}}" placeholder="" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Site</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_site"
                                                id="protocolo_agendamento_site"
                                                value="{{config('protocolo_agendamento_site')}}" placeholder="" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">CNPJ</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_cnpj"
                                                id="protocolo_agendamento_cnpj"
                                                value="{{config('protocolo_agendamento_cnpj')}}" placeholder="" />

                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Saudação Final</label>
                                                </label> </span>
                                            <input class="form-control" type="text" name="protocolo_agendamento_xau"
                                                id="protocolo_agendamento_xau"
                                                value="{{config('protocolo_agendamento_xau')}}"
                                                placeholder="Aguardo você✅" />

                                        </div>

                                        <div class="col-md-6">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="lastname" class="form-label">Protocolo de
                                                    Agendamento</label>
                                                </label> </span>
                                            <div class="protocol_result">
                                                <p id="txt_protocolo" rows="22" cols="50">
                                                    <span
                                                        id="span_protocolo_agendamento_inicio">{{config('protocolo_agendamento_inicio')}}</span><span
                                                        id="ptcl_cliente">*NOME_DO_CLIENTE*
                                                    </span><span
                                                        id="span_protocolo_agendamento_pos_inicio">{{config('protocolo_agendamento_pos_inicio')}}</span><br><br>
                                                    <span
                                                        id="span_protocolo_agendamento_titulo">{{config('protocolo_agendamento_titulo')}}</span><br>
                                                    Protocolo:
                                                    *{{ random_int(999, 999999) }}/{{
                                                    Carbon\Carbon::now('America/Sao_Paulo')->format('Y') }}*
                                                    <br>
                                                    📅<span> </span>Data: *<span id="ptcl_dia"></span>*<br>
                                                    ⏰<span> </span>Hora: *<span id="ptcl_hora"></span>* <br>
                                                    <br>
                                                    _*Documentos necessários:*_<br>
                                                    ➡RG<br>
                                                    ➡CPF<br>
                                                    ➡Comprovante de Residência Atual<br>
                                                    <br>
                                                    _*Endereço:*_<br>
                                                    <span
                                                        id="span_protocolo_agendamento_endereco">{{config('protocolo_agendamento_endereco')}}</span><br>
                                                    <span id="span_protocolo_agendamento_site">{{
                                                        config('protocolo_agendamento_site')}}</span><br>

                                                    <br>
                                                    _*Na Recepção procurar por:*_ <br>
                                                    {{\Auth::user()->name}}<br>
                                                    <span id="span_protocolo_agendamento_final">{{
                                                        config('protocolo_agendamento_final')}}</span><br>
                                                    <br>
                                                    <span id="span_protocolo_agendamento_empresa">{{
                                                        config('protocolo_agendamento_empresa')}}</span><br>
                                                    <span id="span_protocolo_agendamento_cnpj">{{
                                                        config('protocolo_agendamento_cnpj')}}</span><br>
                                                    <br>
                                                    <span
                                                        id="span_protocolo_agendamento_xau">{{config('protocolo_agendamento_xau')}}</span>
                                                    <br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>



                                {{-- COLUNA DA DIREITA --}}
                                <div class="col-md-6">


                                    <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                        CONFIGURAÇÕES CORRIDA</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-12">
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                    title="">
                                                    <label for="lastname" class="form-label">Meta Fera de Vendas
                                                        (Vendedor)</label> </span>
                                                <input class="form-control" type="number" name="racing_vendas_max"
                                                    id="racing_vendas_max" value="{{config('racing_vendas_max')}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-12">
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                    title="">
                                                    <label for="lastname" class="form-label">Meta Fera Gold ( Vendedor
                                                        )</label>
                                                    </label> </span>
                                                <input class="form-control" type="number" name="racing_vendas_gold_max"
                                                    id="racing_vendas_gold_max"
                                                    value="{{config('racing_vendas_gold_max')}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-12">
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                    title="">
                                                    <label for="lastname" class="form-label">Meta de Vendas por
                                                        Equipe</label>
                                                    </label> </span>
                                                <input class="form-control" type="number" name="racing_vendas_equipe"
                                                    id="racing_vendas_equipe"
                                                    value="{{config('racing_vendas_equipe')}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="inputEmail3" class="col-form-label">Ordenar
                                                    Participantes
                                                    Vendas
                                                    <span class="mdi mdi-information"></span>
                                                </label> </span>

                                            <input class="toggle-event" type="checkbox" <?php if
                                                (array_key_exists('vendas_ordenar', $empresa)) { if
                                                ($empresa['vendas_ordenar']=='true' ) { echo 'checked' ; } } ?>
                                            data-config_info="vendas_ordenar" data-toggle="toggle"
                                            data-on="ordenado" data-off="não ordenado" data-onstyle="success"
                                            data-offstyle="danger">
                                        </div>





                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-12">
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                    title="">
                                                    <label for="lastname" class="form-label">Valor Máximo de
                                                        Agendamentos Diários</label>
                                                    </label> </span>


                                                <input class="form-control" type="number" name="racing_agendamento_max"
                                                    id="racing_agendamento_max"
                                                    value="{{config('racing_agendamento_max')}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="inputEmail3" class="col-form-label">Ordenar
                                                    Participantes
                                                    Agendamentos
                                                    <span class="mdi mdi-information"></span>
                                                </label> </span>

                                            <input class="toggle-event" type="checkbox" <?php if
                                                (array_key_exists('agendamento_ordenar', $empresa)) { if
                                                ($empresa['agendamento_ordenar']=='true' ) { echo 'checked' ; } } ?>
                                            data-config_info="agendamento_ordenar" data-toggle="toggle"
                                            data-on="ordenado" data-off="não ordenado" data-onstyle="success"
                                            data-offstyle="danger">
                                        </div>

                                        <div class="col-md-12">
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                                <label for="inputEmail3" class="col-form-label">Ranking Filiais
                                                    <span class="mdi mdi-information"></span>
                                                </label> </span>

                                            <input class="toggle-event" type="checkbox" <?php if
                                                (array_key_exists('ranking_filiais', $empresa)) { if
                                                ($empresa['ranking_filiais']=='true' ) { echo 'checked' ; } } ?>
                                            data-config_info="ranking_filiais" data-toggle="toggle"
                                            data-on="habilitado" data-off="desabilitado" data-onstyle="success"
                                            data-offstyle="danger">
                                        </div>

                                    </div>

                                    <h5 class="text-uppercase" style="
    padding-top: 30px;"><i class=" mdi mdi-briefcase me-1 pt-5"></i>
                                        MOTIVOS DE PERDA</h5>
                                    <div class="row">
                                        <div class="col-12">

                                            {{-- Botão para abrir modal de criação --}}
                                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                                data-bs-target="#modalAddMotivo">
                                                <i class="mdi mdi-plus"></i> Adicionar Motivo de Perda
                                            </button>

                                            {{-- Tabela de motivos --}}
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nome do Motivo</th>
                                                        <th width="100px">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($motivos as $motivo)
                                                    <tr>
                                                        <td>{{ $motivo->motivo }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('crm.motivos.delete', $motivo->id) }}"
                                                                method="POST" style="display:inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Deseja realmente remover este motivo?')">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>



                                {{-- TERCEIRA COLUNA VAZIA --}}
                            </div>

                        </div> <!-- end tab-pane -->
                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
</div> <!-- container -->



{{-- Modal de Adicionar Motivo --}}
<div class="modal fade" id="modalAddMotivo" tabindex="-1" aria-labelledby="modalAddMotivoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('crm.motivos.insert') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddMotivoLabel">Adicionar Motivo de Perda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_motivo" class="form-label">Nome do Motivo</label>
                        <input type="text" class="form-control" id="nome_motivo" name="motivo" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('templates.escolher_img', [
'action' => route('empresa_images'),
'titulo' => "Editar Arte",
'user_id' => app('request')->id,
])
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
    function image_save($folder, $imgname, $tipo_corte='quadrado2', $largura =300, $altura = 300) {

            $('#pasta_imagem').val($folder);
            $('#imagem_name').val($imgname);
            $('#tipo_corte').val($tipo_corte);
            $('#corte_altura').val($altura);
            $('#corte_largura').val($largura);
            $('#change_logo').modal('show');
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


            var ids = [
                'protocolo_agendamento_inicio',
                'protocolo_agendamento_pos_inicio',
                'protocolo_agendamento_titulo',
                'protocolo_agendamento_final',
                'protocolo_agendamento_empresa',
                'protocolo_agendamento_site',
                'protocolo_agendamento_cnpj',
                'protocolo_agendamento_xau',
                'protocolo_agendamento_endereco',
                
            ];

            ids.forEach(function(id) {
                var element = document.getElementById(id);
                var span = document.getElementById('span_' + id);
                if (element && span) {
                    element.addEventListener('blur', function(e) {
                    var value = e.target.value;
                    save_config(id, value);
                    span.innerHTML = value;
                });
                }
            });


            var ids_toggle = [
                'token_webhook',
                'racing_agendamento_max',
                'racing_vendas_max',
                'racing_vendas_gold_max',
                'permitir_deletar_negocio',
                'broadcast_canal',
                'negocio_parado',
                'racing_vendas_equipe',
                'broadcast_audio'           
            ];
            
            ids_toggle.forEach(function(id) {
                var element = document.getElementById(id);
                if (element) {
                    element.addEventListener('blur', function(e) {
                    var value = e.target.value;

                    save_config(id, value);
              
                    });
                }
            });

            
        });
</script>
@endsection