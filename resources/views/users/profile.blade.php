<?php use App\Enums\UserStatus; ?>

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
    </style>
@endsection

@section('main_content')

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{ url('') }}/images/users/user_{{ $user->id }}/{{ $user->avatar }}"
                            class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" onclick="myfunction()">

                        <p><a href="#" data-bs-toggle="modal" data-bs-target="#edit-profile-img"
                                class="text-muted font-14">Editar Imagem</a></p>
                        <h4 class="mb-0 mt-2">{{ $user->name }}</h4>
                        <p class="text-muted font-14">{{ $user->cargo->nome }}</p>


                        <div class="text-start mt-3">
                            <p class="text-muted mb-2 font-13"><strong>Nome :</strong> <span
                                    class="ms-2">{{ $user->name }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>Telefone :</strong><span
                                    class="ms-2">{{ $user->telefone }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>WhatsApp :</strong><span
                                    class="ms-2">{{ $user->telefone }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                    class="ms-2 ">{{ $user->email }}</span></p>
                            <p class="text-muted mb-1 font-13"><strong>Endereço :</strong> <span
                                    class="ms-2">{{ $user->endereço }}</span></p>
                        </div>

                        <ul class="social-list list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                        class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                        class="mdi mdi-instagram"></i></a>
                            </li>
                        </ul>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->

                <!-- Messages-->

            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    Editar Informações
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#marketing" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                    Marketing
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    Atividades
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="marketing">

                                <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                    INFORMAÇÕES DE MARKETING</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="firstname"
                                                value="{{ $user->slug }}" name="slug">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="firstname"
                                                value="{{ $user->slug }}" name="slug">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome</label>
                                            <a href="{{ route('consultor', ['slug' => $user->slug]) }}">
                                                {{ $user->name }}</a>
                                        </div>
                                    </div>
                                </div>


                            </div> <!-- end tab-pane -->
                            <!-- end about me section content -->

                            <div class="tab-pane" id="timeline">

                                <!-- comment box -->
                                <div class="border rounded mt-2 mb-3">
                                    <form action="#" class="comment-area-box">
                                        <textarea rows="3" class="form-control border-0 resize-none" placeholder="Write something...."></textarea>
                                        <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                        class="mdi mdi-account-circle"></i></a>
                                                <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                        class="mdi mdi-map-marker"></i></a>
                                                <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                        class="mdi mdi-camera"></i></a>
                                                <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                        class="mdi mdi-emoticon-outline"></i></a>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-dark waves-effect">Post</button>
                                        </div>
                                    </form>
                                </div> <!-- end .border-->
                                <!-- end comment box -->

                                <!-- Story Box-->
                                <div class="border border-light rounded p-2 mb-3">
                                    <div class="d-flex">
                                        <img class="me-2 rounded-circle" src="assets/images/users/avatar-3.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div>
                                            <h5 class="m-0">Jeremy Tomlinson</h5>
                                            <p class="text-muted"><small>about 2 minuts ago</small></p>
                                        </div>
                                    </div>
                                    <p>Story based around the idea of time lapse, animation to post soon!</p>

                                    <img src="assets/images/small/small-1.jpg" alt="post-img" class="rounded me-1"
                                        height="60">
                                    <img src="assets/images/small/small-2.jpg" alt="post-img" class="rounded me-1"
                                        height="60">
                                    <img src="assets/images/small/small-3.jpg" alt="post-img" class="rounded"
                                        height="60">

                                    <div class="mt-2">
                                        <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                class="mdi mdi-reply"></i> Reply</a>
                                        <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                class="mdi mdi-heart-outline"></i> Like</a>
                                        <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                class="mdi mdi-share-variant"></i> Share</a>
                                    </div>
                                </div>

                                <!-- Story Box-->
                                <div class="border border-light rounded p-2 mb-3">
                                    <div class="d-flex">
                                        <img class="me-2 rounded-circle" src="assets/images/users/avatar-4.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div>
                                            <h5 class="m-0">Thelma Fridley</h5>
                                            <p class="text-muted"><small>about 1 hour ago</small></p>
                                        </div>
                                    </div>
                                    <div class="font-16 text-center fst-italic text-dark">
                                        <i class="mdi mdi-format-quote-open font-20"></i> Cras sit amet nibh libero, in
                                        gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras
                                        purus odio, vestibulum in vulputate at, tempus viverra turpis. Duis
                                        sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper
                                        porta. Mauris massa.
                                    </div>

                                    <div class="mx-n2 p-2 mt-3 bg-light">
                                        <div class="d-flex">
                                            <img class="me-2 rounded-circle" src="assets/images/users/avatar-3.jpg"
                                                alt="Generic placeholder image" height="32">
                                            <div>
                                                <h5 class="mt-0">Jeremy Tomlinson <small class="text-muted">3 hours
                                                        ago</small></h5>
                                                Nice work, makes me think of The Money Pit.

                                                <br>
                                                <a href="javascript: void(0);"
                                                    class="text-muted font-13 d-inline-block mt-2"><i
                                                        class="mdi mdi-reply"></i> Reply</a>

                                                <div class="d-flex mt-3">
                                                    <a class="pe-2" href="#">
                                                        <img src="assets/images/users/avatar-4.jpg" class="rounded-circle"
                                                            alt="Generic placeholder image" height="32">
                                                    </a>
                                                    <div>
                                                        <h5 class="mt-0">Thelma Fridley <small class="text-muted">5
                                                                hours ago</small></h5>
                                                        i'm in the middle of a timelapse animation myself! (Very different
                                                        though.) Awesome stuff.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex mt-2">
                                            <a class="pe-2" href="#">
                                                <img src="assets/images/users/avatar-1.jpg" class="rounded-circle"
                                                    alt="Generic placeholder image" height="32">
                                            </a>
                                            <div class="w-100">
                                                <input type="text" id="simpleinput"
                                                    class="form-control border-0 form-control-sm"
                                                    placeholder="Add comment">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <a href="javascript: void(0);" class="btn btn-sm btn-link text-danger"><i
                                                class="mdi mdi-heart"></i> Like (28)</a>
                                        <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                class="mdi mdi-share-variant"></i> Share</a>
                                    </div>
                                </div>

                                <!-- Story Box-->
                                <div class="border border-light p-2 mb-3">
                                    <div class="d-flex">
                                        <img class="me-2 rounded-circle" src="assets/images/users/avatar-6.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div>
                                            <h5 class="m-0">Martin Williamson</h5>
                                            <p class="text-muted"><small>15 hours ago</small></p>
                                        </div>
                                    </div>
                                    <p>The parallax is a little odd but O.o that house build is awesome!!</p>

                                    <iframe src='../../video/87993762.html' height='300'
                                        class="img-fluid border-0"></iframe>
                                </div>

                                <div class="text-center">
                                    <a href="javascript:void(0);" class="text-danger"><i
                                            class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                                </div>
                            </div>

                            <div class="tab-pane  show active" id="settings">
                                <form method="POST" action="{{ route('user_edit') }}">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                        Informações Profisionais</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstname" class="form-label">Nome</label>
                                                <input type="text" class="form-control" id="firstname"
                                                    value="{{ $user->name }}" name="nome">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Telefone (WhatsApp) <span
                                                        class="text-muted">*DDD e números sem simbolos</span></label>
                                                <input type="number" class="form-control" id="telefone"
                                                    value="{{ $user->telefone }}" name="telefone">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lastname" class="form-label">E-mail</label>
                                                <input type="text" class="form-control" id="lastname" name="email"
                                                    value="{{ $user->email }}" disabled>
                                            </div>
                                        </div> <!-- end col -->

                                        @if (\Auth::user()->hasRole('admin'))
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" value="">
                                                </div>
                                            </div> <!-- end col -->
                                        @endif

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="task-title" class="form-label">Cargo</label>
                                                <select class="form-select form-control-light" name="cargo_id">
                                                    @foreach (\App\Models\Cargo::all() as $cargo)
                                                        @if ($cargo->id == $user->cargo->id)
                                                            <option value="{{ $cargo->id }}" selected>
                                                                {{ $cargo->nome }}</option>
                                                        @else
                                                            <option value="{{ $cargo->id }}">{{ $cargo->nome }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="task-priority" class="form-label">Data Contratação</label>
                                                <input type="text" class="form-control form-control-light"
                                                    id="data_contratacao" data-single-date-picker="true"
                                                    name="data_contratacao" value="{{ $user->data_contratacao }}">
                                            </div>
                                        </div>
                                    </div>



                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                        Informações Comerciais</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="task-title" class="form-label">Equipe</label>

                                                @if ($user->equipe)
                                                    <input type="text" class="form-control" id="equipe"
                                                        name="email" value="{{ $user->equipe->nome }}" disabled>
                                                @else
                                                    <input type="text" class="form-control" id="equipe"
                                                        name="email" value="Sem Equipe" disabled>
                                                @endif

                                            </div>
                                        </div>
                                        @if (\Auth::user()->hasRole('admin'))
                                            <div class="col-md-6">

                                                <label for="task-title" class="form-label">Permissões


                                                    <a class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#permissaoModal" role="button"> + </a>

                                                </label>
                                                <br>
                                                @if ($user->roles())
                                                    @foreach ($user->roles as $role)
                                                        <a href="#" class="confirm-delete"
                                                            data-id="{{ $role->id }}"
                                                            data-name="{{ $role->name }}"><span
                                                                class="badge badge-info-lighten">{{ $role->name }}</span>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>

                                        @endif
                                    </div>


                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                        Informações de Marketing</h5>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label for="task-title" class="form-label">Página Concluido</label>
                                            <div class="mb-3">
                                                <a
                                                    href="{{ url('') }}/obrigado?consultor={{ $user->telefone }}">{{ url('') }}/obrigado?consultor={{ $user->telefone }}</a>
                                            </div>
                                            <label for="task-title" class="form-label">Landinpage Cadastro</label>
                                            <div class="mb-3">
                                                <a
                                                    href="{{ url('') }}/landingpages?page=fb_cadastro_02&proprietario={{ $user->email }}">{{ url('') }}/landingpages?page=fb_cadastro_02&proprietario={{ $user->email }}</a>
                                            </div>
                                        </div>
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

                                                <input class="toggle-event" type="checkbox" <?php echo $ischecked; ?>
                                                    data-user_id="{{ $user->id }}" data-toggle="toggle"
                                                    data-on="Ativo" data-off="Inativo" data-onstyle="success"
                                                    data-offstyle="danger">
                                            </div>
                                        </div>
                                    @endif
                                    <input name="user_id" value="{{ app('request')->id }}" hidden>
                                </form>
                            </div>
                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row-->


    </div> <!-- container -->


    <div class="modal fade" id="revogarPermissao" tabindex="-1" aria-labelledby="permissaoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="p-2" action="{{ route('del_permissao') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p> Deseja Remover a permisão abaixo?</p>

                        <span class="badge badge-danger-lighten" id="nome_permissao"></span>
                    </div>
                    <div class="modal-footer">

                        <input type="submit" class="btn btn-success mt-2" value="Confirmar">
                        <input type='text' hidden="true" id='yes_no' name='delete_id'>
                        <input type='text' hidden="true" name='user_id' value="{{ app('request')->id }}">
                        <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Fechar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="permissaoModal" tabindex="-1" aria-labelledby="permissaoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form class="p-2" action="{{ route('add_permissao') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="permissaoModalLabel">Adicionar Permissões</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <h6 class="mt-2">Permissões</h6>
                        <div class="mb-1 nowrap w-100">
                            <select class="form-select form-control-light" id="task-priority" name="role_id">
                                <option selected="true">Selecione uma permissão</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <input type="text" name="user_id" hidden value="{{ app('request')->id }}">

                        <input type="submit" class="btn btn-success mt-2" value="Enviar">
                        <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">

                    </div>

                </form>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="edit-profile-img" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Foto de Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form class="p-2" action="{{ url('users/edit/avatar') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-12">
                                            <label for="task-title" class="form-label">Faça o Upload da Sua Imagem<span
                                                    class="text-danger">
                                                    *</label>
                                            <input type="file" name="image" id="inputImage"
                                                class="form-control @error('image') is-invalid @enderror">
                                            <input name="user_id" hidden value={{ app('request')->id }}>
                                            <br>
                                            <img id="myImg" class="rounded-circle avatar-lg img-thumbnail"
                                                src="#">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


@endsection

@section('specific_scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




        $('.toggle-event').change(function($this) {

            var user_id = $(this).data('user_id');
            console.log($(this).prop('checked') + " user " + user_id);

            info = [];
            info[0] = $(this).prop('checked');
            info[1] = user_id;

            $.ajax({
                url: "{{ url('funcionarios/ativar_desativar') }}",
                type: 'post',
                data: {
                    info: info
                },
                Type: 'json',
                success: function(res) {
                    console.log("Funcionario atualizada com sucesso: ")
                    showAlert({
                        message: res,
                        class: "success"
                    });
                },
                error: function(res) {
                    console.log(res);
                    showAlert({
                        message: res,
                        class: "danger"
                    });
                },
            });

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
    </script>
@endsection
