

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
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

    @yield('headers')

</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":true, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->


    <div hidden="true" name="{{ url('/') }}" id="public_path"></div>
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{url('')}}/images/logos/jla_simbolo_transparente.png" alt="" height="32">
                </span>
                <span class="logo-sm">
                    <img src="{{url('')}}/images/logos/jla_circular.png" alt="" height="32">
                </span>
            </a>

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{url('')}}/images/logos/jla_simbolo_transparente.png" alt="" height="32">
                </span>
                <span class="logo-sm">
                    <img src="{{url('')}}/images/logos/jla_circular.png" alt="" height="32">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">
                    <li class="side-nav-item">
                        <a href="{{route('home')}}" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span> Dashboard</span>
                        </a>
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
                                    <a href="{{route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id,'status'=> 'ativo') )}}">Pipeline</a>
                                </li>
                                <li>
                                    <a href="{{route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id, 'view' => 'list','status'=> 'ativo' ) )}}">Lista</a>
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
                            <i class="uil-store"></i>
                            <span> Admininstrativo </span>
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
                                            $data_inicio = "20/".Carbon\Carbon::now()->subMonth()->format('m/Y');
                                            $data_fim = "20/".Carbon\Carbon::now()->format('m/Y');
                                        ?>

                                        <a href="{{route('vendas.lista', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim))}}">Vendas Realizadas</a>
                                    </li> 
                                @endif

                                @if (Auth::user()->hasAnyRole( ['gerenciar_equipe']) )
                                    <li>
                                        <a href="{{route('equipes.index')}}">Equipes</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                      

                    </li>
                    

            </div>
            <!-- Sidebar -left -->

 
            <!-- Sidebar -left -->

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
                @yield('main_content')

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>document.write(new Date().getFullYear())</script> © JLA - Soluções Financeiras
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

    <!-- demo app -->
    <script src="{{url('')}}/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->


    <script type="text/javascript">
			window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 4000);
	</script>
    
    @yield('specific_scripts')

</body>

</html>