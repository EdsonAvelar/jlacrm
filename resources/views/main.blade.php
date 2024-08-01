<?php
use Carbon\Carbon;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">


    <meta name="facebook-domain-verification" content="2v42l4jph9cgfkrorr6gejjod4bqx6" />

    <title>{{ config('nome') }}</title>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('') }}/images/empresa/logos/favicon.ico">

    <!-- third party css -->
    <link href="{{ url('') }}/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{ url('') }}/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('') }}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ url('') }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/vue-dragula@1.3.1/styles/dragula.min.css" />


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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

            /* Oculto por padrão */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            /* Fundo semitransparente */
            color: white;
            font-size: 2em;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            background: url('{{ asset("images/gifs/confetti.gif")}}') no-repeat center center;
            background-size: cover;
        }

        .card-vendedor {
            width: 600px;
            height: 600px;
            border: 2px solid black;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            text-align: center;
            padding: 20px;
            color: #d51414;
            background-color: #f4ffef;
        }

        .card-vendedor img {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 2px solid black;
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
    </style>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$style = '';
if (strpos($url, 'pipeline') !== false && app('request')->view != 'list') {
    $style = 'style="overflow-y: hidden;"';
}
?>

<body class="loading" <?php echo $style; ?>
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false,
    "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <div hidden="true" name="{{ url('/') }}" id="public_path"></div>

    <div id="notification" class="notificacao_venda" style="display: none;">
        <div class="card-vendedor">
            <div class="texto-cima">É VENDA</div>
            <div class="texto-cima2"><span id="venda_valor"></span></div>
            <div class="texto-cima2"><span id="nome_cliente"></span></div>
            <img id="imagem_vendedor" src="" alt="Foto do Vendedor">

            <div class="texto-baixo">
                <div>-= PARABÉNS =-</div>
                <div><span id="nome_vendedor"></span></div>
                <div><span id="nome_equipe"></span></div>

            </div>
        </div>
    </div>


    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">
            <a class="button-menu-mobile open-left">
                <i class="mdi mdi-menu"></i>
            </a>

            <a class="logo_consensed logo text-center logo-light open-left">
                <span class="logo-lg">
                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png" alt="" height="32">
                </span>
                <span class="logo-sm">
                    <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png" alt="" height="32">
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
                            <i class="uil-store"></i>
                            <span> Dashboards </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="dashboard">
                            <ul class="side-nav-second-level">

                                <li>
                                    <a
                                        href="{{ route('home', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Geral</a>
                                </li>

                                @if (\Auth::user()->hasRole('admin'))
                                <li>
                                    <a
                                        href="{{ route('dashboard_equipes', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Equipes</a>
                                </li>
                                <li>
                                    <a
                                        href="{{ route('dashboard_semanas', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Semanas</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard_bar_race_vendas') }}">Corrida de Vendas</a>
                                </li>

                                <li>
                                    <a href="{{ route('dashboard_bar_race_agendamentos') }}">Corrida de Agendamentos</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#crm" aria-expanded="false" aria-controls="crm"
                            class="side-nav-link">
                            <i class="uil-store"></i>
                            <span> Negócios </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="crm">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a
                                        href="{{ route('pipeline_index', ['id' => 1, 'proprietario' => \Auth::user()->id, 'status' => 'ativo', 'view_card' => 'compact']) }}">Pipeline</a>
                                </li>
                                <li>
                                    <a
                                        href="{{ route('pipeline_index', ['id' => 1, 'proprietario' => \Auth::user()->id, 'view' => 'list', 'status' => 'ativo']) }}">Lista</a>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('agendamento.calendario', ['proprietario' => \Auth::user()->id]) }}">Calendário</a>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('agendamento.lista', ['proprietario' => \Auth::user()->id, 'data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Agendamentos</a>
                                </li>

                                @if (Auth::user()->hasAnyRole(['importar_leads']))
                                <li>
                                    <a href="{{ route('importar.negocios.index') }}">Importar</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                    @if (Auth::user()->hasAnyRole(['admin']))


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#funcionarios" aria-expanded="false"
                            aria-controls="funcionarios" class="side-nav-link">
                            <i class="uil-user-circle"></i>
                            <span> Administrativo </span>
                            <span class="menu-arrow"></span>
                        </a>


                        <div class="collapse" id="funcionarios">
                            <ul class="side-nav-second-level">

                                @if (Auth::user()->hasAnyRole(['gerenciar_funcionarios']))
                                <li>
                                    <a href="{{ route('users.funcionarios') }}">Funcionários</a>
                                </li>
                                @endif

                                @if (Auth::user()->hasAnyRole(['gerenciar_vendas']))
                                <li>

                                    <a
                                        href="{{ route('vendas.lista', ['data_inicio' => $data_inicio, 'data_fim' => $data_fim]) }}">Vendas
                                        Realizadas</a>
                                </li>
                                @endif

                                @if (Auth::user()->hasAnyRole(['gerenciar_funcionarios']))
                                <li>
                                    <a href="{{ route('equipes.index') }}">Equipes</a>
                                </li>
                                @endif
                            </ul>
                        </div>


                    </li>
                    @endif


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#perfil" aria-expanded="false" aria-controls="perfil"
                            class="side-nav-link">
                            <i class="uil-bright"></i>
                            <span> Configurações </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="collapse" id="perfil">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('users_profile', ['id' => \Auth::user()->id]) }}">Minha
                                        Conta</a>
                                </li>

                                @if (\Auth::user()->hasRole('admin'))
                                <li>
                                    <a href="{{ route('empresa_profile', ['id' => \Auth::user()->id]) }}">Empresa</a>
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

                    <li class="side-nav-item">

                        <a class="side-nav-link" id="btnModoTV">
                            <i class="uil-home-alt"></i>
                            <span> Modo TV </span>
                        </a>
                    </li>


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

                {{-- <div class="navbar-custom">
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

                                <div style="max-height: 230px;" data-simplebar="">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{ url('') }}/images/users/avatar-2.jpg"
                                                class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <p class="notify-details">Cristina Pride</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{ url('') }}/images/users/avatar-4.jpg"
                                                class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
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



                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ url('') }}/images/users/user_{{ \Auth::user()->id }}/{{ \Auth::user()->avatar }}"
                                        alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">{{ \Auth::user()->name }}</span>
                                    <span class="account-position">{{ \Auth::user()->cargo()->first()->nome }}</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bem Vindo !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('users_profile', ['id' => \Auth::user()->id]) }}"
                                    class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>Minha Conta</span>
                                </a>
                                <a href="{{ route('change-password') }}" class="dropdown-item notify-item">
                                    <i class="mdi textbox-password me-1"></i>
                                    <span>Mudar Senha</span>
                                </a>
                                <hr>

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
                </div> --}}



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

    <!-- bundle -->
    <script src="{{ url('') }}/js/vendor.min.js"></script>
    <script src="{{ url('') }}/js/app.min.js"></script>

    <!-- third party js -->
    <script src="{{ url('') }}/js/vendor/apexcharts.min.js"></script>
    <script src="{{ url('') }}/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ url('') }}/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- end demo js-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
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
        "preventDuplicates": false,
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

    $('.logo_consensed').on('click', function() {

        if ($("body").attr("data-leftbar-compact-mode")) {
            $("body").attr("data-leftbar-compact-mode", "not_condensed");
        } else {
            $("body").attr("data-leftbar-compact-mode", "condensed");
        }

    });

    
    // Função para simular uma nova venda (você pode remover isso quando integrar com Laravel)
    //setTimeout(showNotification, 2000);
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
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('ae35a6a0e6cd96def27f', {
          cluster: 'sa1'
        });
    
        var channel = pusher.subscribe( "{{ config('pusher_channel') }}" );
        console.log('pusher'+channel);
        channel.bind('my-event', function(data) {
            console.log( JSON.stringify(data));

            http://127.0.0.1:8000/images/equipes/1/logo.jpg

            document.getElementById('venda_valor').innerText = "Crédito: " +nFormatter( data.data.credito, 2);
            document.getElementById('nome_cliente').innerText = "Cliente: "+data.data.cliente;
            document.getElementById('nome_vendedor').innerText = data.data.vendedor;
            document.getElementById('nome_equipe').innerText = data.data.equipe_nome ? "Equipe: "+data.data.equipe_nome : '';
           
            document.getElementById('imagem_vendedor').src = "{{ url('') }}/images/users/user_"+data.data.id+"/"+data.data.avatar ;

            // var img_equipe = "{{ url('') }}/images/equipes/"+data.data.equipe_id+"/"+data.data.equipe_logo ;
 
            // console.log(img_equipe);
            // $('#notification').css('background', `url('${img_equipe}') no-repeat center center`);
            // $('#notificationr').css('background-size', 'cover');
   
            showNotification();

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
@endif

{{-- <div class="alert alert-success" role="alert">

    <strong>Success!</strong> {{ session('status') }}
</div> --}}


</html>