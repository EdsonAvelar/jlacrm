@extends('main')

@section('headers')

@endsection

@section('main_content')

<!-- Start Content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">
                    <ul class="list-unstyled topbar-menu float-end mb-0">

                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" role="button">
                                <i class="dripicons-view-apps noti-icon"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <h4 class="page-title">Mudar Senha
                    
                </h4>
            </div>
        </div>
        @include('layouts.alert-msg')

    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="{{ route('update-password') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="oldPasswordInput" class="form-label">Senha Antiga</label>
                            <input name="old_password" type="password"
                                class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                placeholder="Senha Antiga">
                            @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPasswordInput" class="form-label">Senha Nova</label>
                            <input name="new_password" type="password"
                                class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                placeholder="Senha Nova">
                            @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPasswordInput" class="form-label">Confirma nova senha</label>
                            <input name="new_password_confirmation" type="password" class="form-control"
                                id="confirmNewPasswordInput" placeholder="Confirma nova senha">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success">Salvar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div> <!-- container -->

@endsection

@section('specific_scripts')

@endsection