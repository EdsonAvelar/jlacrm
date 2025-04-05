@extends('main')

@section('headers')

<meta name="csrf-token" content="{{ csrf_token() }}">



<style>
    /* Estilo para o modal ocupar 80% da largura e altura da tela */
    #organogramModal .modal-dialog {
        max-width: 80%;
        /* Define a largura máxima como 80% da tela */
        max-height: 80%;
        /* Define a altura máxima como 80% da tela */
    }

    #organogramModal .modal-content {
        height: 100%;
        /* Garante que o conteúdo do modal ocupe toda a altura disponível */
    }

    #organogramModal .modal-body {
        overflow-y: auto;
        /* Adiciona rolagem caso o conteúdo ultrapasse a altura */
    }
</style>

<style>
    @media screen and (max-width: 767px) {
        #equipe_logo {
            display: block;
            width: 100px;
            height: 100px;
        }
    }

    .container_exp {

        overflow-y: scroll;
    }

    .content-page {

        padding: 70px 12px 0px 0px !important;

    }

    .w-100 {
        margin-left: 10px;
    }
</style>

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
                            <a class="nav-link dropdown-toggle arrow-none" href="#" role="button"
                                onclick="fetchOrganogramData()">
                                <i class="fas fa-project-diagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="row">

                    @include('partials.mobile-sidebar', ['title' => 'Gerenciamento de Equipes', 'class' => "fs-4
                    fw-semibold p-2"])
                </div>
              

                    <a href="#" data-bs-toggle="modal" data-bs-target="#criar_equipe"
                        class="btn btn-success btn-sm ms-3">Criar Equipe</a>
               
            </div>
        </div>

    </div>
    <!-- end page title -->

    <div class="row container_exp" id="container"
        data-containers='["semequipe","<?php echo implode('","', $equipes->pluck("nome")->toArray()); ?>"]'>
        <div class="col-md-3">
            <div class="row" style="padding-top: 20px;">
                <div class="col-md-12">
                    <div class="bg-dragula p-2 p-lg-4" style="background: rgb(217 217 217);">

                        <h5 class="mt-0">Sem Equipe</h5>
                        <div id="semequipe" class="py-2" data-id="-1">
                            @foreach ($semequipes as $user)
                            <div class="card mb-0 mt-2" id="{{ $user->id }}">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <img src="{{ asset($user->avatar) }}" alt="image"
                                            class="me-3 d-none d-sm-block avatar-sm rounded-circle">
                                        <div class="w-100 overflow-hidden">
                                            <h5 class="mb-1 mt-1">{{ $user->name }}</h5>
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
        </div>
        <div class="col-md-9">
            <div class="row" style="padding-top: 20px;">
                @foreach ($equipes as $equipe)
                <div class="col-md-4" style="padding-bottom: 20px;">
                    <div class="bg-dragula p-2 p-lg-4" style="background: rgb(206 231 239);">

                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle text-muted arrow-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">

                                <!-- item-->
                                <a href="#" class="dropdown-item editar_equipe" data-id="{{ $equipe->id }}"><i
                                        class="mdi mdi-pencil me-1"></i><span class="text-success">
                                        Editar</span></a>

                                <!-- item-->
                                <a href="#" class="dropdown-item excluir_equipe" data-id="{{ $equipe->id }}"
                                    data-name="{{ $equipe->nome }}" data-descricao="{{ $equipe->descricao }}"><i
                                        class="dripicons-trash"></i><span class="text-success"> Excluir</span></a>

                            </div>
                        </div>


                        <h5 class="mt-0">{{ $equipe->descricao }}</h5>
                        <div class="d-flex align-items-start">



                            <a href="#"
                                onclick='image_save("/images/equipes/{{ $equipe->id }}","{{ $equipe->logo }}","{{ $equipe->id }}")'
                                class="text-muted font-14">
                                <img id="equipe_logo"
                                    src="{{ url('') }}/images/equipes/{{ $equipe->id }}/{{ $equipe->logo }}?{{ \Carbon\Carbon::now()->timestamp }}"
                                    alt="user-image" class="rounded-circle" width="50" height="50">

                            </a>


                            <div class="w-100 overflow-hidden">
                                <p class="mb-0 mt-0"> Lider </p>
                                <h3 class="mb-0 mt-0">{{ $equipe->lider()->first()->name }}</h3>
                            </div>

                        </div>
                        <div id="{{ $equipe->nome }}" class="py-2" data={{ $equipe->id }}>

                            @foreach ($equipe->integrantes()->get() as $user)
                            @if ($equipe->lider()->first()->id != $user->id)
                            <div class="card mb-0 mt-1" id="{{ $user->id }}">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">



                                        <img src="{{ asset( $user->avatar) }}" alt="image"
                                            class="me-0 d-none d-sm-block avatar-sm rounded-circle">



                                        <div class="w-100 overflow-hidden">
                                            <h5 class="mb-1 mt-1">{{ $user->name }}</h5>
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

{{-- Form para Adicionar Equipe --}}
<form id="createForm" action="{{ url('equipes/create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="criar_equipe" tabindex="-1" aria-labelledby="criar_equipeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="criar_equipeLeaderLabel">Criar Equipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-12">
                            <label for="task-title" class="form-label">Nome da Equipe</label>
                            <input type="text" class="form-control form-control-light" name="nome_equipe"
                                placeholder="Digite o nome da Equipe" required>
                        </div>

                        <div class="col-md-12">
                            <label for="task-title" class="form-label">Lider da Equipe<span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control-light" id="task-priority" name="lider_id">
                                @foreach ($semequipes as $user)
                                @if ($user->hasRole('gerenciar_equipe'))
                                @if ($user->id == \Auth::user()->id)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Faça o Upload do Logo da Equipe</label>
                                <input type="file" name="image" id="CreateInputImage"
                                    class="form-control @error('image') is-invalid @enderror">
                                <br>
                                <img id="myImg" class="rounded-circle avatar-lg img-thumbnail" src="#">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success mt-2" value="Criar">
                    <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                </div>
            </div>
        </div>
    </div>

</form>

{{-- Form para Editar Equipe --}}
<form id="editForm" action="{{ url('equipes/change_equipe') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="modal fade" id="editarequipe_modal" tabindex="-1" aria-labelledby="configurarLeaderLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configurarLeaderLeaderLabel">Editar Equipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <!-- Painel Esquedo -->
                        <div class="col-md-12">
                            <label for="task-title" class="form-label">Nome da Equipe</label>
                            <input type="text" class="form-control form-control-light" id="edit_nome_equipe"
                                name="edit_nome_equipe" required>
                        </div>

                        {{-- <div class="col-md-12">
                            <label for="task-title" class="form-label">Lider</label>
                            <input type="text" class="form-control form-control-light" id="edit_nome_lider" readonly>
                        </div> --}}

                        <div class="col-md-12">
                            <label for="task-title" class="form-label">Lider da Equipe<span class="text-danger"></label>
                            <select class="form-select form-control-light" id="task-priority" name="lider_id">

                                <option id="edit_nome_lider" value="123">ABC</option>
                                @foreach ($semequipes as $user)
                                @if ($user->hasRole('gerenciar_equipe'))
                                @if ($user->id == \Auth::user()->id)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                                @endif
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-12">
                                <label for="task-title" class="form-label">Faça o Upload do Logo da Equipe</label>
                                <input type="file" name="image" id="EditInputImage"
                                    class="form-control @error('image') is-invalid @enderror">
                                <br>
                                <img id="edit_img_equipe" class="rounded-circle avatar-lg img-thumbnail" src="#">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <input type="text" id="editar_equipe_id" name="editar_equipe_id" hidden value="">
                    <input type="submit" class="btn btn-success mt-2" value="Atualizar">
                    <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                </div>
            </div>
        </div>
    </div>

</form>

{{-- Form para Deletar Equipe --}}
<form id="target" action="{{ url('equipes/excluir') }}" method="POST">
    @csrf

    <div class="modal fade" id="deletarEquipe" tabindex="-1" aria-labelledby="deletarEquipeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletarEquipeLabel">Deletar lider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mt-2">Tem Certeza que deseja apagar a equipe:</h6>
                    <h4 class="mt-3" id="nome_equipe"></h4>
                </div>
                <div class="modal-footer">
                    <input type="text" id="excluir_equipe_id" name="excluir_equipe_id" hidden value="">
                    <input type="submit" class="btn btn-success mt-2" value="Deletar">
                    <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                </div>
            </div>
        </div>
    </div>

</form>


<!-- Modal para o Organograma -->
<div class="modal fade" id="organogramModal" tabindex="-1" aria-labelledby="organogramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="organogramModalLabel">Organograma da Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="organogramContainer" style="max-width: 800px; height: 600px; margin: auto;"></div>
            </div>
        </div>
    </div>
</div>


@include('templates.escolher_img', [
'action' => url('equipes/change/image'),
'titulo' => "Editar Imagem da Equipe",
'user_id' => app('request')->id,
])


@endsection

@section('specific_scripts')

<script src="{{ url('') }}/js/vendor/dragula.min.js"></script>
<!-- demo js -->
<script src="{{ url('') }}/js/ui/component.dragula.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/apextree"></script>

<script>
    function fetchOrganogramData() {
        $.ajax({
            url: "{{ url('equipes/organograma') }}",  // endpoint que retorna o JSON do organograma
            type: 'GET',
            success: function(data) {
                $('#organogramModal').modal('show');
                initializeOrganogram(data);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao buscar o organograma:", error);
            }
        });
    }

    function initializeOrganogram(data) {

        // Remove o conteúdo existente antes de renderizar o novo gráfico
        const container = document.getElementById("organogramContainer");
        container.innerHTML = "";

        const options = {
            contentKey: 'data',
            width: 800,
            height: 600,
            nodeWidth: 150,
            nodeHeight: 100,
            fontColor: '#fff',
            borderColor: '#333',
            childrenSpacing: 50,
            siblingSpacing: 20,
            direction: 'top',
            enableExpandCollapse: true,
            nodeTemplate: (content) =>
                `<div style='display: flex; flex-direction: column; gap: 10px; justify-content: center; align-items: center; height: 100%;'>
                    <img style='width: 50px; height: 50px; border-radius: 50%;' src='${content.imageURL}' alt='' />
                    <div style="font-weight: bold; font-family: Arial; font-size: 14px">${content.name}</div>
                </div>`,
            canvasStyle: 'border: 1px solid black; background: #f6f6f6;width: 100%;',
            enableToolbar: true,
        };

        const tree = new ApexTree(container, options);
        tree.render(data);

        // Quando o modal é fechado, destrua o gráfico para evitar múltiplos renders
        $('#organogramModal').on('hidden.bs.modal', function () {
            container.innerHTML = "";
        });
    }
</script>



<script>
    function image_save($folder, $imgname,$editar_equipe_id) {

        console.log($folder, $imgname,$editar_equipe_id)

        $('#pasta_imagem').val($folder);
        $('#imagem_name').val($imgname);
        $('.editar_equipe_id').val($editar_equipe_id);
        $('#change_logo').modal('show');
    }

    
    var cont = [];
        var arr = Array($('.container_exp').data('containers'))[0];

        arr.forEach(function(n) {
            if (n != "") {
                cont.push(document.querySelector('#' + n))
            }

        });

        var drake = dragula(cont);

        drake.on('drop', function(el, target, source, sibling) {

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
                url: "{{ url('equipes/drag_update') }}",
                type: 'post',
                data: {
                    info: info
                },
                Type: 'json',
                success: function(res) {
                    console.log("Equipe atualizada com sucesso")
                }
            });
        });

        $('.editar_equipe').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('equipes/get?id=') }}" + id,
                type: 'get',
                Type: 'json',
                success: function(res) {
                    $('#editar_equipe_id').val(res[0]);
                    $('#edit_nome_equipe').val(res[3]);

                    $('#edit_nome_lider').val(res[5]);
                    $('#edit_nome_lider').html(res[2]);

                    $('#edit_img_equipe').attr('src', "{{ url('') }}" + "/images/equipes/" + res[
                            0] +
                        '/' +
                        res[4]);

                    $('#editarequipe_modal').modal('show');
                }
            });
        });

        $('.excluir_equipe').on('click', function() {

            var id = $(this).data('id');
            var name = $(this).data('name');
            var descricao = $(this).data('descricao');

            $('#excluir_equipe_id').val(id);
            $("#nome_equipe").html(descricao);
            $('#deletarEquipe').modal('show');
        });

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


        $("#EditInputImage").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = EditInputImageLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });

        function EditInputImageLoaded(e) {
            $('#edit_img_equipe').attr('src', e.target.result);
        };

        function change_max_height() {
            var height__ = parseInt(document.documentElement.clientHeight) - 100;
          

            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                $('.container_exp').css({
                    "max-height": height__ + 5
                })
            } else {
                $('.container_exp').css({
                    "max-height": height__
                })
            }

            //set_columns_height();
        }
        document.addEventListener("DOMContentLoaded", function() {


            change_max_height()
        });

        $(window).resize(function() {
            change_max_height()
            // if (screen.width == window.innerWidth) {
            //     alert("you are on normal page with 100% zoom");
            // } else if (screen.width > window.innerWidth) {
            //     alert("you have zoomed in the page i.e more than 100%");
            // } else {
            //     alert("you have zoomed out i.e less than 100%")
            // }
        });
</script>
@endsection