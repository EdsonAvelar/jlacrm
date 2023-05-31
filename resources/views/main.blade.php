

<!DOCTYPE html>
<html lang="en">

<head>


    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T8M2RFC');</script>
    <!-- End Google Tag Manager -->

    

    <meta charset="utf-8">
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('')}}/images/favicon.ico">

    <!-- third party css -->
    <link href="{{url('')}}/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{url('')}}/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="{{url('')}}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{url('')}}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    @yield('headers')
</head>

<?php 
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$style = '';
    if ((strpos($url,'pipeline') !== false) && (app('request')->view != 'list')) {
        $style = 'style="overflow-y: hidden;"';
    }
?>
<body class="loading" <?php echo $style;?>
    
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T8M2RFC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div hidden="true" name="{{ url('/') }}" id="public_path"></div>
    
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">
        <a class="button-menu-mobile open-left">
                            <i class="mdi mdi-menu"></i>
    </a>

        <a class="logo text-center logo-light open-left">
            <span class="logo-lg">
                <img src="{{url('')}}/images/empresa/{{env('APP_SHORT_NAME')}}/logos/empresa_logo_transparente.png" alt="" height="32">
            </span>
            <span class="logo-sm">
                <img src="{{url('')}}/images/empresa/{{env('APP_SHORT_NAME')}}/logos/empresa_logo_transparente.png" alt="" height="32">
            </span>
        </a>

        <a class="logo text-center logo-dark open-left">
            <span class="logo-lg">
                <img src="{{url('')}}/images/empresa/{{env('APP_SHORT_NAME')}}/logos/empresa_logo_transparente.png" alt="" height="32">
            </span>
            <span class="logo-sm">
                <img src="{{url('')}}/images/empresa/{{env('APP_SHORT_NAME')}}/logos/empresa_logo_circular.png" alt="" height="32">
            </span>
        </a>
            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">
                 


                    <li class="side-nav-item">
                        <?php 
                            $data_inicio = "20/".Carbon\Carbon::now('America/Sao_Paulo')->subMonth()->format('m/Y');
                            $data_fim = Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y');
                        ?>

                        <a data-bs-toggle="collapse" href="#dashboard" aria-expanded="false"
                            aria-controls="dashboard" class="side-nav-link">
                            <i class="uil-store"></i>
                            <span> Dashboards </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="dashboard">
                            <ul class="side-nav-second-level">
                                
                                <li>
                                    <a href="{{route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim))}}">Geral</a>
                                </li>
                                <li>
                                    <a href="{{route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim))}}">Equipes</a>
                                </li>
                            </ul>
                        </div>
                    </li>



                    

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#crm" aria-expanded="false"
                            aria-controls="crm" class="side-nav-link">
                            <i class="uil-store"></i>
                            <span> Negócios </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="crm">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id,'status'=> 'ativo','view_card'=>'compact') )}}">Pipeline</a>
                                </li>
                                <li>
                                    <a href="{{route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id, 'view' => 'list','status'=> 'ativo' ) )}}">Lista</a>
                                </li>
                                
                                <li>
                                    <a href="{{route('agendamento.calendario', array('proprietario' =>  \Auth::user()->id ) )}}">Calendário</a>
                                </li>

                                @if (Auth::user()->hasAnyRole( ['importar_leads']) )
                                <li>
                                    <a href="{{route('importar.negocios.index')}}">Importar</a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </li>

                   
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#funcionarios" aria-expanded="false"
                            aria-controls="funcionarios" class="side-nav-link">
                            <i class="uil-user-circle"></i>
                            <span> Administrativo </span>
                            <span class="menu-arrow"></span>
                        </a>
                        
                        
                        <div class="collapse" id="funcionarios">
                            <ul class="side-nav-second-level">

                                @if (Auth::user()->hasAnyRole( ['gerenciar_funcionarios']) )
                                    <li>
                                        <a href="{{route('users.funcionarios')}}">Funcionários</a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasAnyRole( ['gerenciar_vendas']) )
                                    <li>
                                        <?php 
                                            $data_inicio = "20/".Carbon\Carbon::now('America/Sao_Paulo')->subMonth()->format('m/Y');
                                            $data_fim = Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y');
                                        ?>
                                        <a href="{{route('vendas.lista', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim))}}">Vendas Realizadas</a>
                                    </li> 
                                @endif

                                @if (Auth::user()->hasAnyRole( ['gerenciar_funcionarios']) )
                                    <li>
                                        <a href="{{route('equipes.index')}}">Equipes</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                      

                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#perfil" aria-expanded="false"
                            aria-controls="perfil" class="side-nav-link">
                            <i class="uil-bright"></i>
                            <span> Configurações </span>
                            <span class="menu-arrow"></span>
                        </a>
                        
                        <div class="collapse" id="perfil">
                            <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{route('users_profile', array('id'=> \Auth::user()->id) )}}">Minha Conta</a>
                                    </li>
                                    <li>
                                        <a href="{{route('change-password')}}">Mudar de Senha</a>
                                    </li>
                                    <hr>
                                    <li>
                                        <a href="{{url('/logout')}}">Logout</a>
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
                     <div class="help-box text-white text-center"  style="padding: 7px;">
                        <img src="{{url('')}}/images/banners/proibido.png" style="width:100%">
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
            <div class="content">
                <!-- Topbar Start -->
                
                <div class="navbar-custom">
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
                                            <img src="{{url('')}}/images/users/avatar-2.jpg"
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
                                            <img src="{{url('')}}/images/users/avatar-4.jpg"
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
                                    <img src="{{url('')}}/images/users/user_{{\Auth::user()->id}}/{{\Auth::user()->avatar}}" alt="user-image"
                                        class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">{{\Auth::user()->name}}</span>
                                    <span class="account-position">{{\Auth::user()->cargo()->first()->nome}}</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bem Vindo !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{route('users_profile', array('id'=> \Auth::user()->id) )}}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>Minha Conta</span>
                                </a>
                                <a href="{{route('change-password')}}" class="dropdown-item notify-item">
                                    <i class="mdi textbox-password me-1"></i>
                                    <span>Mudar Senha</span>
                                </a>
                                <hr>
                          
                                <!-- item-->
                                <a href="{{url('/logout')}}" class="dropdown-item notify-item">
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

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>document.write(new Date().getFullYear())</script> © {{env('APP_NAME')}}
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
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->



    <!-- bundle -->
    <script src="{{url('')}}/js/vendor.min.js"></script>
    <script src="{{url('')}}/js/app.min.js"></script>

    <!-- third party js -->
    <script src="{{url('')}}/js/vendor/apexcharts.min.js"></script>
    <script src="{{url('')}}/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{url('')}}/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- end demo js-->
    

    <script type="text/javascript">
			window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);


        $("form").submit(function() {
            $(":submit", this).attr("disabled", "disabled");
        });

        $("#fullscreen")

        function entrarFullScreen(){
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) { 
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
            
        function sairFullScreen(){
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }

        $( document ).ready(function() {
	var modoTv = false;

        $("#btnModoTV").click(function(){
            if(modoTv == false){
                $("#cabecalho").hide();
                $("#menuEsquerda").hide();
                $("#menuCentral").hide(); //esconde para remodular as classes
                $("#menuCentral").removeClass("col-md-8 col-md-offset-1");
                $("#menuCentral").addClass("col-md-12");
                $("#menuCentral").fadeIn(1500); //reaparece com estilo ^_~
                //$("#btnModoTV").html("Desativar Modo TV");
                modoTv = true;
                
                entrarFullScreen();
                
            }else{
                $("#cabecalho").show();
                $("#menuEsquerda").show();
                $("#menuCentral").hide();
                $("#menuCentral").removeClass("col-md-12");
                $("#menuCentral").addClass("col-md-8 col-md-offset-1");
                $("#menuCentral").show();
                //$("#btnModoTV").html("Ativar Modo TV");
                modoTv = false;
                
                sairFullScreen();
                
            }
        });
    });


    function showAlert(obj){
        var html = '<div class="alert alert-' + obj.class + ' alert-dismissible" role="alert">'+
            '   <strong>' + obj.message + '</strong>'+
            '   </div>';
        $('#alert').append(html);
        window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);
    }


	</script>


   
    
    @yield('specific_scripts')
    
 

</body>

</html>