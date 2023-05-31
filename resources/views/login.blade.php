<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Log In | {{env('APP_NAME')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('')}}/images/favicon.ico">

        <!-- App css -->
        <link href="{{url('')}}/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url('')}}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />

    </head>

    <body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-start">
                            <a href="index.html" class="logo-dark">
                                <span><img src="{{url('')}}/images/empresa/logos/empresa_logo_horizontal.png" alt="" height="25"></span>
                            </a>
                            <a href="index.html" class="logo-light">
                                <span><img src="{{url('')}}/images/logo.png" alt="" height="18"></span>
                            </a>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0">Entrar</h4>
                        <p class="text-muted mb-4"> Coloque seu e-mail e password para acessar sua conta.</p>

                        @if(session()->has('error'))
                        <div class="alert alert-danger">{{session()->get('error')}}</div>
                        @endif
                        <!-- form -->
                        <form action="" method="post">

                            @csrf
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Email</label>
                                <input class="form-control" type="email" id="emailaddress" name="email" required="" placeholder="Digite seu email">
                                
                                @error('email')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <a href="{{route('change-password')}}" class="text-muted float-end"><small>Esqueceu sua senha?</small></a>
                                <label for="password" class="form-label">Senha</label>
                                <input class="form-control" type="password" required="" id="password" name="password" placeholder="Digite sua senha">

                                @error('password')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                    <label class="form-check-label" for="checkbox-signin">Lembre-me</label>
                                </div>
                            </div>
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" name="submit" value="submit" type="submit"><i class="mdi mdi-login"></i> Entrar </button>
                            </div>
                            <!-- social-->
                            <div class="text-center mt-4">
                                <p class="text-muted font-16">Entrar com</p>
                                <ul class="social-list list-inline mt-3">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <!-- end form-->

            

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <h2 class="mb-3">Client Manager (Admin/Marketing/CRM)</h2>
                    <p class="lead"><i class="mdi mdi-format-quote-open"></i> Tudo que você precisa em um só lugar! . <i class="mdi mdi-format-quote-close"></i>
                    </p>
                    <p>
                        - Se não tiver coragem de morder, <strong>não rosne!</strong>
                    </p>
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="{{url('')}}/js/vendor.min.js"></script>
        <script src="{{url('')}}/js/app.min.js"></script>

    </body>

</html>