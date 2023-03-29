@extends('main')


@section('headers')

<meta name="csrf-token" content="{{ csrf_token() }}">

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

                <h4 class="page-title">Titulo
                    <a href="#" data-bs-toggle="modal" data-bs-target="#criar_equipe"
                        class="btn btn-success btn-sm ms-3">Criar Equipe</a>
                </h4>
            </div>
        </div>
      

    </div>
    <!-- end page title -->

    <div class="row container" id="container"  data-containers='["semequipe","<?php echo implode('","', $equipes->pluck('nome')->toArray()) ?>"]' >
    <div class="row">
        <div class="col-md-4">
            <div class="bg-dragula p-2 p-lg-4">

                <h5 class="mt-0">Sem Equipe</h5>
                <div id="semequipe" class="py-2" data=-1>
                    @foreach( $semequipes as $user )

                    <div class="card mb-0 mt-2" id="{{$user->id}}">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <img src="{{url('')}}/images/users/user_{{$user->id}}/{{$user->avatar}}" alt="image" class="me-3 d-none d-sm-block avatar-sm rounded-circle">
                                <div class="w-100 overflow-hidden">
                                    <h5 class="mb-1 mt-1">{{ $user->name}}</h5>
                                </div> <!-- end w-100 -->
                                <span class="dragula-handle"></span>
                            </div> <!-- end d-flex -->
                        </div> <!-- end card-body -->
                    </div> <!-- end col -->
                    @endforeach
                </div> <!-- end company-list-1-->
            </div> <!-- end div.bg-light-->
        </div> <!-- end col -->
</div>

    <div class="col-md-12">
    <div class="row">
    @foreach($equipes as $equipe)
    
        <div class="col-md-4" >
            <div class="bg-dragula p-2 p-lg-4">

            <div class="dropdown float-end">
                <a href="#" class="dropdown-toggle text-muted arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical font-18"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="#" class="dropdown-item mudar_coordenador" data-id=""><i class="mdi mdi-pencil me-1"></i><span
                            class="text-success"> Editar</span></a>

                      <!-- item-->
                      <a href="#" class="dropdown-item excluir_equipe" data-id="{{$equipe->id}}" data-name="{{$equipe->nome}}"><i class="dripicons-trash"></i><span
                            class="text-success"> Excluir</span></a>
         
                </div>
            </div>


                <h5 class="mt-0">{{$equipe->nome}}</h5>
                <div class="d-flex align-items-start">
                <img src="{{url('')}}/images/equipes/{{$equipe->nome}}/{{$equipe->logo}}" alt="user-image"
                                        class="rounded-circle" width="50">
                    <div class="w-100 overflow-hidden">
                        <p class="mb-0 mt-0" > Lider </p>
                        <h3 class="mb-1 mt-1">{{$equipe->lider()->first()->name}}</h3>
                    </div> 

                </div>
                <div id="{{$equipe->nome}}" class="py-2" data={{$equipe->id}}>

                    @foreach( $equipe->integrantes()->get() as $user )

                        @if ( $equipe->lider()->first()->id != $user->id)

                        <div class="card mb-0 mt-1" id="{{$user->id}}" style="height: 5rem;">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img src="{{url('')}}/images/users/user_{{$user->id}}/{{$user->avatar}}" alt="image" class="me-3 d-none d-sm-block avatar-sm rounded-circle">
                                    <div class="w-100 overflow-hidden">
                                        <h5 class="mb-1 mt-1">{{ $user->name}}</h5>
                                    </div> <!-- end w-100 -->
                                    <span class="dragula-handle"></span>
                                </div> <!-- end d-flex -->
                            </div> <!-- end card-body -->
                        </div> <!-- end col -->

                        @endif
                    @endforeach
                </div> <!-- end company-list-1-->
            </div> <!-- end div.bg-light-->
        </div> <!-- end col -->
    @endforeach
</div>
    </div>
    </div> <!-- end row --> 

</div> <!-- container -->

<form id="target" action="{{url('equipes/create')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="criar_equipe" tabindex="-1" aria-labelledby="criar_equipeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="criar_equipeLeaderLabel">Mudar de lider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-12">
                            <label for="task-title" class="form-label">Nome da Equipe</label>
                            <input type="text" class="form-control form-control-light" 
                                            name="nome_equipe" placeholder="Digite o nome da Equipe" required>
                        </div>

                        <div class="col-md-12">
                            <label for="task-title" class="form-label">Lider da Equipe<span
                                                class="text-danger"></label>
                                <select class="form-select form-control-light" id="task-priority"
                                    name="lider_id">
                                @foreach ($semequipes as $user)
                                    @if ($user->id == \Auth::user()->id)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @else
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>                        
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-12">
                            <label for="task-title" class="form-label">Faça o Upload do Logo da Equipe<span class="text-danger">
                                    *</label>
                                    <input type="file" name="image" id="inputImage"  class="form-control @error('image') is-invalid @enderror">
                                <br>
                                <img id="myImg" class="rounded-circle avatar-lg img-thumbnail" src="#" >
                        </div>
                    </div>

                </div>

                </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success mt-2" value="Enviar">
                        <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<form id="target" action="{{url('equipe/change_lead')}}" method="POST">
    @csrf

<div class="modal fade" id="configurarLeader" tabindex="-1" aria-labelledby="configurarLeaderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="configurarLeaderLabel">Mudar de lider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h6 class="mt-2">Lider</h6>
                <div class="mb-1 nowrap w-100">
                    <select class="form-select form-control-light" id="task-priority" name="novo_proprietario_id">
                        <option selected="true">NOVO LIDER</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="modal-footer">
                    <input type="text" name="id" hidden value="{{app('request')->id}}">
                    <input type="submit" class="btn btn-success mt-2" value="Enviar">
                    <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<form id="target" action="{{url('equipes/excluir')}}" method="POST">
    @csrf

    <div class="modal fade" id="deletarEquipe" tabindex="-1" aria-labelledby="deletarEquipeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarEquipeLabel">Mudar de lider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mt-2">Tem Certeza que deseja apagar a equipe:</h6>
                    <h4 class="mt-3" id="nome_equipe"></h4>
                </div>
                    <div class="modal-footer">
                        <input type="text" id="excluir_equipe_id" name="excluir_equipe_id" hidden value="">
                        <input type="submit" class="btn btn-success mt-2" value="Enviar">
                        <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                    </div>
                </div>
            </div>
    </div>
</div>
</form>


@endsection

@section('specific_scripts')
<!-- bundle -->
<script src="{{url('')}}/js/vendor/dragula.min.js"></script>
<!-- demo js -->
<script src="{{url('')}}/js/ui/component.dragula.js"></script>

<script>

var cont = [];
var arr = Array( $('.container').data('containers'))[0];
arr.forEach(function(n){
    cont.push(document.querySelector('#'+n))
});

var drake = dragula( cont );

drake.on('drop', function (el, target, source, sibling) {
      
    scrollable = true;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    info = [];
    info[0] = el.getAttribute('id');
    info[1] = source.getAttribute('data');
    info[2] = target.getAttribute('data');
    

    $.ajax({
        url: "{{url('equipes/drag_update')}}",
        type: 'post',
        data: { info: info },
        Type: 'json',
        success: function (res) {
            console.log("Equipe atualizada com sucesso")
        }
    });
});


$('.mudar_coordenador').on('click', function () {
    $('#configurarLeader').modal('show');
});


$('.excluir_equipe').on('click', function () {

    var id = $(this).data('id'); 
    var name = $(this).data('name'); 

    $('#excluir_equipe_id').val(id);

    $("#nome_equipe").html(name);

    $('#deletarEquipe').modal('show');
});


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

</script>

@endsection