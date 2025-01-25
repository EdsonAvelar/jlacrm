<?php
use Carbon\Carbon;

$user = Auth::user();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="facebook-domain-verification" content="2v42l4jph9cgfkrorr6gejjod4bqx6" />

    <title>{{ config('nome') }}</title>


    <meta name="viewport" content="width=device-width, initial-scale=1.33">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('') }}/images/empresa/logos/favicon.ico">

    <!-- third party css -->
    <link href="{{ url('') }}/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/vue-dragula@1.3.1/styles/dragula.min.css" />


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
        integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="{{ url('') }}/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('') }}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ url('') }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    @yield('headers')


    <style>
        ::-webkit-scrollbar {
            background-color: #f5f5f501;
            cursor: grab;
            border-radius: 10px;
            width: 7px;
            height: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #454444;
            border-radius: 10px;
        }

        .notificacao_venda {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 2em;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            background: url('{{ asset("images/gifs/confetti.gif") }}') no-repeat center center;
            background-size: cover;
            border: 2px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .card-vendedor {
            position: relative;
            width: 600px;
            border: 10px solid #d8eff3;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            text-align: center;
            padding: 20px;
            color: #d51414;
            background-color: #eeffff;
            font-family: sans-serif;
            box-shadow: 0 8px 14px rgba(0, 0, 0, 0.2);
        }

        .card-vendedor img {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 9px solid #d8eff3;
            ;
            object-fit: cover;
        }

        .card-vendedor .texto-cima {
            font-weight: bold;
            font-size: 1.5em;
        }

        .card-vendedor .texto-cima2 {
            font-weight: bold;
            font-size: 0.8em;
            color: #281111b5;
        }

        .card-vendedor .texto-baixo {
            font-weight: bold;
            font-size: 1.2em;
        }

        .loggo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
            position: absolute;
        }

        .loggo.empresa {
            top: -130px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 150px;
            z-index: -100;
            border: 9px solid #c4ecff;
        }

        .loggo.equipe {
            bottom: 10px;
            right: 10px;
            width: 90px;
            height: 90px;
        }

        a {
            color: rgb(45, 109, 249);
            text-decoration: none;
        }

        /* Estilo para links ao passar o mouse */
        a:hover {
            color: black;
            background-color: #6aa0d660;
            /* Cor levemente esverdeada */
            display: inline-block;
        }

        .dropdown-menu-end {
            max-height: 300px !important;
            overflow-y: scroll !important;
        }


        .leftside-menu {

            box-shadow: 2px 1px 12px 0px #61767b;
        }

        .navbar-custom {
            box-shadow: 0px 6px 7px 0px #cccccc38;
        }
    </style>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$style = '';
$style_pipe="";
if (strpos($url, 'pipeline') !== false && app('request')->view != 'list') {
    $style = 'style="overflow-y: hidden;"';
    $style_pipe='style="display:none"';
}
?>

<body class="loading" <?php echo $style; ?>
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false,
    "leftSidebarCondensed":false,"leftSidebarScrollable":false,"darkMode":false,
    "showRightSidebarOnStart": true}' data-leftbar-compact-mode="scrollable">

    <!-- Player de música HTML5 -->
    <audio id="musicPlayer">
        <source src="{{ asset('music/aplausos.mp3') }}" type="audio/mpeg">
    </audio>

    <div hidden="true" name="{{ url('/') }}" id="public_path"></div>

    <div id="notification" class="notificacao_venda" style="display: none;">
        <div class="card-vendedor">
            <img id="imagem_empresa" class="loggo empresa" src="" alt="Logo da Empresa">
            <div class="texto-cima">É VENDA</div>
            <div class="texto-cima2"><span id="venda_valor"></span></div>
            <div class="texto-cima2"><span id="nome_cliente"></span></div>
            <img id="imagem_vendedor" src="" alt="Foto do Vendedor">
            <div class="texto-baixo">
                <div>-= PARABÉNS =-</div>
                <div><span id="nome_vendedor"></span></div>
                <div><span id="nome_equipe"></span></div>
            </div>
            <img id="imagem_equipe" class="loggo equipe" src="" alt="Logo da Equipe">
        </div>
    </div>

    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu ">
            <a class="button-menu-mobile open-left">
                <i class="mdi mdi-menu"></i>
            </a>

            <a class="logo_consensed logo text-center logo-light open-left">
                <span class="logo-lg">
                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png" class="open-left" alt=""
                        height="32">
                </span>
                <span class="logo-sm">
                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_circular.png" alt="" height="32">
                </span>
            </a>

            <a class="logo_consensed logo text-center logo-dark open-left">
                <span class="logo-lg">
                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png" alt="" height="32">
                </span>
                <span class="logo-sm">
                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_circular.png" alt="" height="32">
                </span>
            </a>
            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-item">
                        <?php
                        
                        $dia = intval(
                            Carbon::now('America/Sao_Paulo')
                                ->subMonth()
                                ->format('d'),
                        );
                        if ($dia <= 20) {
                            $data_inicio =
                                '20/' .
                                Carbon::now('America/Sao_Paulo')
                                    ->subMonth()
                                    ->format('m/Y');
                        } else {
                            $data_inicio = '20/' . Carbon::now('America/Sao_Paulo')->format('m/Y');
                        }
                        
                        $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
                        
                        if (config('data_inicio') & config('data_fim')) {
                            $data_inicio = config('data_inicio');
                            $data_fim = config('data_fim');
                        }
                        ?>

                        <a data-bs-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="dashboard"
                            class="side-nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span> Dashboards </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="dashboard">
                            <ul class="side-nav-second-level">

                                <li>
                                    <a
                                        href="{{ route('home', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Geral</a>
                                </li>

                                @if ($user->hasRole('admin'))
                                <li>
                                    <a
                                        href="{{ route('dashboard_equipes', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Equipes</a>
                                </li>
                                <li>
                                    <a
                                        href="{{ route('dashboard_semanas', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Semanal</a>
                                </li>

                                <li>
                                    <a href="{{ route('dashboard_producao') }}">Produções</a>
                                </li>



                                @endif
                            </ul>
                        </div>
                    </li>

                    @if ($user->hasAnyRole(['admin']))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#ranking" aria-expanded="false" aria-controls="crm"
                            class="side-nav-link">
                            <i class="fas fa-trophy"></i>
                            <span> Rankings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="ranking">
                            <ul class="side-nav-second-level">

                                <li>
                                    <a href="{{ route('dashboard_bar_race_vendas') }}">Corrida de Vendas</a>
                                </li>

                                <li>
                                    <a href="{{ route('dashboard_bar_race_agendamentos') }}">Corrida de Agendamentos</a>
                                </li>

                                <li>
                                    <a href="{{ route('ranking.vendas') }}">Ranking de Vendas</a>
                                </li>
                                <li>
                                    <a href="{{ route('ranking.vendas.ajuda') }}">Ranking Modo Ajuda</a>
                                </li>
                                <li>
                                    <a href="{{ route('ranking.vendas.telemarketing') }}">Ranking Telemarketing</a>
                                </li>
                                <li>
                                    <a href="{{ route('ranking.agendamentos') }}">Ranking de Agendamentos</a>
                                </li>
                                <li>
                                    <a href="{{ route('ranking.vendas.equipe') }}">Ranking Equipes</a>
                                </li>

                            </ul>
                        </div>
                    </li>


                    @endif

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#crm" aria-expanded="false" aria-controls="crm"
                            class="side-nav-link">
                            <i class="fas fa-briefcase"></i>
                            <span> Negócios </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="crm">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a
                                        href="{{ route('pipeline_index', ['id' => 1, 'proprietario' => $user->id, 'status' => 'ativo', 'view_card' => 'compact']) }}">Pipeline</a>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('pipeline_index', ['id' => 1, 'proprietario' => $user->id, 'view' => 'list2', 'status' => 'ativo']) }}">Lista
                                        <span class="badge bg-success">new</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="{{ route('pipeline_index', ['id' => 1, 'proprietario' => $user->id, 'view' => 'list', 'status' => 'ativo']) }}">Lista
                                        (Antiga)</a>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('agendamento.calendario', ['proprietario' => $user->id]) }}">Calendário</a>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('agendamento.lista', ['proprietario' => $user->id, 'data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Agendamentos</a>
                                </li>

                                @if ($user->hasAnyRole(['admin']) ||
                                $user->hasAnyRole(['gerenciar_equipe']))

                                <li>
                                    <a href="{{ route('negocios.aprovacoes') }}">Produção</a>
                                </li>
                                @endif

                                @if ($user->hasAnyRole(['importar_leads']))
                                <li>
                                    <a href="{{ route('importar.negocios.index') }}">Importar</a>
                                </li>
                                @endif

                                <li>
                                    <a href="{{ route('simulacao.calculadora') }}">Simulador</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    @if ($user->hasAnyRole(['admin']))

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#funcionarios" aria-expanded="false"
                            aria-controls="funcionarios" class="side-nav-link">
                            <i class="fas fa-folder"></i>
                            <span> Administrativo </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="collapse" id="funcionarios">
                            <ul class="side-nav-second-level">

                                <li>
                                    <a href="{{ route('productions.index') }}">Produções</a>
                                </li>


                                @if (\Auth::user()->hasRole('gerenciar_bordero') )
                                <li>
                                    <a href="{{ route('productions.bordero') }}">Bordero</a>
                                </li>
                                @endif



                                <li>
                                    <a href="{{ route('users.funcionarios') }}">Funcionários</a>
                                </li>



                                <li>
                                    <a
                                        href="{{ route('vendas.lista', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Vendas
                                        Realizadas</a>
                                </li>



                                <li>
                                    <a href="{{ route('equipes.index') }}">Equipes</a>
                                </li>

                            </ul>
                        </div>

                    </li>
                    @endif


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#perfil" aria-expanded="false" aria-controls="perfil"
                            class="side-nav-link">
                            <i class="fas fa-cog"></i>
                            <span> Configurações </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="collapse" id="perfil">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('users_profile', ['id' => $user->id]) }}">Minha
                                        Conta</a>
                                </li>

                                @if ($user->hasRole('admin'))
                                <li>
                                    <a href="{{ route('empresa_profile', ['id' => $user->id]) }}">Empresa</a>
                                </li>
                                @endif

                                <li>
                                    <a href="{{ route('change-password') }}">Mudar de Senha</a>
                                </li>
                                <hr>
                                <li>
                                    <a href="{{ url('/logout') }}">Logout</a>
                                </li>

                            </ul>
                        </div>


                    </li>
                    {{--
                    <li class="side-nav-item">

                        <a class="side-nav-link" id="btnModoTV">
                            <i class="uil-home-alt"></i>
                            <span> Modo TV </span>
                        </a>
                    </li> --}}


                    <!-- Help Box -->
                    <div class="help-box text-white text-center" style="padding: 7px;">
                        <img src="{{ url('') }}/images/empresa/outros/banner.png" style="width:100%">
                    </div>
                    <!-- end Help Box -->
                    <!-- End Sidebar -->

            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content" id="content">
                <!-- Topbar Start -->

                <div class="navbar-custom" <?php echo $style_pipe; ?>>
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>


                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="noti-icon-badge"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="javascript: void(0);" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>

                                <div style="max-height: 230px;overflow: scroll;" data-simplebar="">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Novo Lead
                                            <small class="text-muted">1 min atrás</small>
                                        </p>
                                    </a>


                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li>



                        {{-- <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li> --}}

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ asset( $user->avatar) }}" alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">{{ $user->name }}</span>
                                    <span class="account-position">{{ $user->cargo->nome }}</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bem vindo !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('users_profile', ['id' => $user->id]) }}"
                                    class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>Minha Conta</span>
                                </a>

                                <!-- item-->
                                {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Configurações</span>
                                </a> --}}

                                @if ($user->hasRole('admin'))

                                <a href="{{ route('empresa_profile', ['id' => $user->id]) }}"
                                    class="dropdown-item notify-item">
                                    <i class="mdi mdi-cog-outline me-1"></i>
                                    <span>Configurações</span>
                                </a>

                                @endif

                                <!-- item-->
                                <a href="{{ route('change-password') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Mudar Senha</span>
                                </a>

                                {{--
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lifebuoy me-1"></i>
                                    <span>Support</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lock-outline me-1"></i>
                                    <span>Lock Screen</span>
                                </a> --}}

                                <!-- item-->
                                <a href="{{ url('/logout') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>

                </div>



                <!-- end Topbar -->
                @include('layouts.alert-msg')
                <div id="alert"></div>
                @yield('main_content')

            </div>
            <!-- content -->

            {{--
            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script></script> © {{ config('nome') }}
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">Sobre</a>
                                <a href="javascript: void(0);">Suporte</a>
                                <a href="javascript: void(0);">Contato</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer> --}}

        </div>
    </div>
    <!-- END wrapper -->


    <!-- Right Sidebar -->


    <div class="rightbar-overlay"></div>

    <!-- bundle -->
    <script src="{{ url('') }}/js/vendor.min.js"></script>
    <script src="{{ url('') }}/js/app.min.js"></script>

    <!-- third party js -->
    {{-- <script src="{{ url('') }}/js/vendor/apexcharts.min.js"></script> --}}
    <script src="{{ url('') }}/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ url('') }}/js/vendor/jquery-jvectormap-world-mill-en.js"></script>



    <!-- third party js ends -->

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- end demo js-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4000);


        $("form").submit(function() {
            $(":submit", this).attr("disabled", "disabled");
        });

        var modoTv = false;

        function entrarFullScreen() {

            $("#cabecalho").show();
            $("#menuEsquerda").show();
            $("#menuCentral").hide();
            $("#menuCentral").removeClass("col-md-12");
            $("#menuCentral").addClass("col-md-8 col-md-offset-1");
            $("#menuCentral").show();

            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !
                document.msFullscreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            }
        }

        function sairFullScreen() {

            $("#cabecalho").hide();
            $("#menuEsquerda").hide();
            $("#menuCentral").hide(); //esconde para remodular as classes
            $("#menuCentral").removeClass("col-md-8 col-md-offset-1");
            $("#menuCentral").addClass("col-md-12");
            $("#menuCentral").fadeIn(1500); //reaparece com estilo ^_~

            // if (document.exitFullscreen) {
            //     document.exitFullscreen();
            // } else if (document.msExitFullscreen) {
            //     document.msExitFullscreen();
            // } else if (document.mozCancelFullScreen) {
            //     document.mozCancelFullScreen();
            // } else if (document.webkitExitFullscreen) {
            //     document.webkitExitFullscreen();
            // }
        }

        $(document).ready(function() {
            $("#btnModoTV").click(function() {
                if (modoTv == false) {
                    modoTv = true;
                    entrarFullScreen();

                } else {
                    modoTv = false;
                    sairFullScreen();
                }
            });
        });

        $(document).ready(function() {
            setInterval(function() {
                if (modoTv == true) {
                    //cache_clear()
                }
            }, 3000);
        });

        function cache_clear() {

            console.log(location.href + "#dashboard");
            $("#dashboard").load(location.href + "#dashboard");

        }

        function showAlert(obj) {

            if (obj.class == "success") {
                toastr.success(obj.message);
            } else if (obj.class == "danger") {
                toastr.error(obj.message);
            } else if (obj.class == "warning") {
                toastr.warning(obj.message);
            } else {
                toastr.info(obj.message);
            }


        }

        function nFormatter(num, digits) {
            const lookup = [{
                    value: 1,
                    symbol: ""
                },
                {
                    value: 1e3,
                    symbol: "K"
                },
                {
                    value: 1e6,
                    symbol: "M"
                },
                {
                    value: 1e9,
                    symbol: "G"
                },
                {
                    value: 1e12,
                    symbol: "T"
                },
                {
                    value: 1e15,
                    symbol: "P"
                },
                {
                    value: 1e18,
                    symbol: "E"
                }
            ];
            num = num.split(',')[0]
            num = num.replaceAll('.', '')

            const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            var item = lookup.slice().reverse().find(function(item) {
                return num >= item.value;
            });
            return item ? (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";
        }


        $('.money').mask('000.000.000.000.000,00', {
            reverse: true
        });


        

        function save_config(config_info, config_value, alert=true) {

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

                if (alert){
                console.log(res)
                    showAlert({
                    message: res,
                    class: "success"
                    });
                }
                   
                },
                error: function(res) {

                if (alert){
                    console.log(res)
                    showAlert({
                        message: res,
                        class: "danger"
                    });

                }
                   
                },
            });
        }
    </script>

    @yield('specific_scripts')

</body>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }



    // $('.logo_consensed').on('click', function() { 



    //     if ($("body").attr("data-leftbar-compact-mode") == "condensed") {

    //         $("body").attr("data-leftbar-compact-mode", "not_condensed");
    //         save_config("menu_condensed_"+"{{$user->id}}", 'not_condensed', true)
    //     } else {
    //         $("body").attr("data-leftbar-compact-mode", "condensed");
    //         save_config("menu_condensed_"+"{{$user->id}}", "condensed", true)
    //     }

        

    // });

</script>

<script>
    function showNotification() {
        const notification = document.getElementById('notification');
        notification.style.display = 'flex'; // Mostrar a notificação
        setTimeout(() => {
            notification.style.display = 'none'; // Ocultar a notificação após 5 segundos
            }, 20000);
        }     

    // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;
    
        var pusher = new Pusher('ae35a6a0e6cd96def27f', {
          cluster: 'sa1'
        });
    
        var channel = pusher.subscribe( "{{ config('broadcast_canal') }}" );
        console.log('pusher'+channel);
        channel.bind('nova-venda', function(data) {
            console.log( JSON.stringify(data));

            var nome_cliente = data.data.cliente.split(' ');
            var sobrenome = ''
            
            if (nome_cliente.length > 1){
            sobrenome = nome_cliente[ nome_cliente.length - 1]
            }

            document.getElementById('venda_valor').innerText = "Crédito: " +nFormatter( data.data.credito, 2);
            document.getElementById('nome_cliente').innerText = "Cliente: " + nome_cliente[0] +' '+sobrenome;
            document.getElementById('nome_vendedor').innerText = data.data.vendedor;
            document.getElementById('nome_equipe').innerText = data.data.equipe_nome ? "Equipe: "+data.data.equipe_nome : '';
           
            document.getElementById('imagem_vendedor').src = data.data.avatar ;

            if (data.data.equipe_logo){
                $("#imagem_equipe").show()
                document.getElementById('imagem_equipe').src = data.data.equipe_logo ;
            }else {
                $("#imagem_equipe").hide()
            }
           
            document.getElementById('imagem_empresa').src = data.data.empresa ;
            
            showAlert({
                class: 'info',
                message: "A Venda Será Notificada em Instantes!"
            })
            
            setTimeout(function() {
                showNotification();
                var aplausos = "{{ config('broadcast_audio') }}"
                
                if (aplausos == "true"){
                
                var musicPlayer = document.getElementById('musicPlayer');
                musicPlayer.play();
                
                setTimeout(function() {
                musicPlayer.pause();
                musicPlayer.currentTime = 0; // Retorna a música ao início
                }, 20000);
                }
           
           }, 10000);


        });
</script>



@if (Session::has('status'))
<script>
    showAlert({
            class: 'success',
            message: "{{ session('status') }}"
        })
</script>
@endif

@if (Session::has('status_error'))
<script>
    showAlert({
            class: 'danger',
            message: "{{ session('status_error') }}"
        })
</script>


<script>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    @if (session('status'))
        toastr.success("{{ session('status') }}");
    @endif

    @if (session('status_error'))
        toastr.error("{{ session('status_error') }}");
    @endif
</script>

@endif


</html>