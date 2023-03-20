@extends('main')


@section('headers')

<!-- plugin js -->
<script src="assets/js/vendor/dropzone.min.js"></script>
<!-- init js -->
<script src="assets/js/ui/component.fileupload.js"></script>

@endsection

@section('main_content')


<!-- Start Content-->
<div class="container-fluid">
@include('layouts.alert-msg')

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


                <h4 class="page-title">Titulo
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add-new-task-modal"
                        class="btn btn-success btn-sm ms-3">Botao</a>
                </h4>
            </div>
        </div>
      

    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="board">
                Conteudo
            </div>
        </div>
    </div>

   

</div> <!-- container -->


@endsection

@section('specific_scripts')




@endsection