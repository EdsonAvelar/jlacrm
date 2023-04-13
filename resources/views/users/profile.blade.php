@extends('main')


@section('headers')


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
                    <img src="{{url('')}}/images/users/user_{{$user->id}}/{{$user->avatar}}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" onclick="myfunction()">
                  
                    <p><a href="#" data-bs-toggle="modal" data-bs-target="#edit-profile-img" class="text-muted font-14" >Editar Imagem</a></p>
                    <h4 class="mb-0 mt-2">{{$user->name}}</h4>
                    <p class="text-muted font-14">{{$user->cargo->nome}}</p>


                    <div class="text-start mt-3">
                        <p class="text-muted mb-2 font-13"><strong>Nome :</strong> <span class="ms-2">{{$user->name}}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Telefone :</strong><span class="ms-2">{{$user->telefone}}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>WhatsApp :</strong><span class="ms-2">{{$user->telefone}}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{$user->email}}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Endereço :</strong> <span class="ms-2">{{$user->endereço}}</span></p>
                    </div>

                    <ul class="social-list list-inline mt-3 mb-0">
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-instagram"></i></a>
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
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                Editar Informações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                Sobre
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                Atividades
                            </a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="aboutme">

                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                Experience</h5>

                            <div class="timeline-alt pb-0">
                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-1">Lead designer / Developer</h5>
                                        <p class="font-14">websitename.com <span class="ms-2 font-12">Year: 2015 - 18</span></p>
                                        <p class="text-muted mt-2 mb-0 pb-3">Everyone realizes why a new common language
                                            would be desirable: one could refuse to pay expensive translators.
                                            To achieve this, it would be necessary to have uniform grammar,
                                            pronunciation and more common words.</p>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-1">Senior Graphic Designer</h5>
                                        <p class="font-14">Software Inc. <span class="ms-2 font-12">Year: 2012 - 15</span></p>
                                        <p class="text-muted mt-2 mb-0 pb-3">If several languages coalesce, the grammar
                                            of the resulting language is more simple and regular than that of
                                            the individual languages. The new common language will be more
                                            simple and regular than the existing European languages.</p>

                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-1">Graphic Designer</h5>
                                        <p class="font-14">Coderthemes Design LLP <span class="ms-2 font-12">Year: 2010 - 12</span></p>
                                        <p class="text-muted mt-2 mb-0 pb-2">The European languages are members of
                                            the same family. Their separate existence is a myth. For science
                                            music sport etc, Europe uses the same vocabulary. The languages
                                            only differ in their grammar their pronunciation.</p>
                                    </div>
                                </div>

                            </div>
                            <!-- end timeline -->        

                            <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant me-1"></i>
                                Projects</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Clients</th>
                                            <th>Project Name</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><img src="assets/images/users/avatar-2.jpg" alt="table-user" class="me-2 rounded-circle" height="24"> Halette Boivin</td>
                                            <td>App design and development</td>
                                            <td>01/01/2015</td>
                                            <td>10/15/2018</td>
                                            <td><span class="badge badge-info-lighten">Work in Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><img src="assets/images/users/avatar-3.jpg" alt="table-user" class="me-2 rounded-circle" height="24"> Durandana Jolicoeur</td>
                                            <td>Coffee detail page - Main Page</td>
                                            <td>21/07/2016</td>
                                            <td>12/05/2018</td>
                                            <td><span class="badge badge-danger-lighten">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><img src="assets/images/users/avatar-4.jpg" alt="table-user" class="me-2 rounded-circle" height="24"> Lucas Sabourin</td>
                                            <td>Poster illustation design</td>
                                            <td>18/03/2018</td>
                                            <td>28/09/2018</td>
                                            <td><span class="badge badge-success-lighten">Done</span></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><img src="assets/images/users/avatar-6.jpg" alt="table-user" class="me-2 rounded-circle" height="24"> Donatien Brunelle</td>
                                            <td>Drinking bottle graphics</td>
                                            <td>02/10/2017</td>
                                            <td>07/05/2018</td>
                                            <td><span class="badge badge-info-lighten">Work in Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><img src="assets/images/users/avatar-5.jpg" alt="table-user" class="me-2 rounded-circle" height="24"> Karel Auberjo</td>
                                            <td>Landing page design - Home</td>
                                            <td>17/01/2017</td>
                                            <td>25/05/2021</td>
                                            <td><span class="badge badge-warning-lighten">Coming soon</span></td>
                                        </tr>

                                    </tbody>
                                </table>
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
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-account-circle"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-map-marker"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-camera"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-emoticon-outline"></i></a>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-dark waves-effect">Post</button>
                                    </div>
                                </form>
                            </div> <!-- end .border-->
                            <!-- end comment box -->

                            <!-- Story Box-->
                            <div class="border border-light rounded p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle" src="assets/images/users/avatar-3.jpg" alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">Jeremy Tomlinson</h5>
                                        <p class="text-muted"><small>about 2 minuts ago</small></p>
                                    </div>
                                </div>
                                <p>Story based around the idea of time lapse, animation to post soon!</p>

                                <img src="assets/images/small/small-1.jpg" alt="post-img" class="rounded me-1" height="60">
                                <img src="assets/images/small/small-2.jpg" alt="post-img" class="rounded me-1" height="60">
                                <img src="assets/images/small/small-3.jpg" alt="post-img" class="rounded" height="60">

                                <div class="mt-2">
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-reply"></i> Reply</a>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-heart-outline"></i> Like</a>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-share-variant"></i> Share</a>
                                </div>
                            </div>

                            <!-- Story Box-->
                            <div class="border border-light rounded p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle" src="assets/images/users/avatar-4.jpg" alt="Generic placeholder image" height="32">
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
                                        <img class="me-2 rounded-circle" src="assets/images/users/avatar-3.jpg" alt="Generic placeholder image" height="32">
                                        <div>
                                            <h5 class="mt-0">Jeremy Tomlinson <small class="text-muted">3 hours ago</small></h5>
                                            Nice work, makes me think of The Money Pit.

                                            <br>
                                            <a href="javascript: void(0);" class="text-muted font-13 d-inline-block mt-2"><i class="mdi mdi-reply"></i> Reply</a>

                                            <div class="d-flex mt-3">
                                                <a class="pe-2" href="#">
                                                    <img src="assets/images/users/avatar-4.jpg" class="rounded-circle" alt="Generic placeholder image" height="32">
                                                </a>
                                                <div>
                                                    <h5 class="mt-0">Thelma Fridley <small class="text-muted">5 hours ago</small></h5>
                                                    i'm in the middle of a timelapse animation myself! (Very different though.) Awesome stuff.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-2">
                                        <a class="pe-2" href="#">
                                            <img src="assets/images/users/avatar-1.jpg" class="rounded-circle" alt="Generic placeholder image" height="32">
                                        </a>
                                        <div class="w-100">
                                            <input type="text" id="simpleinput" class="form-control border-0 form-control-sm" placeholder="Add comment">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-danger"><i class="mdi mdi-heart"></i> Like (28)</a>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-share-variant"></i> Share</a>
                                </div>
                            </div>

                            <!-- Story Box-->
                            <div class="border border-light p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle" src="assets/images/users/avatar-6.jpg" alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">Martin Williamson</h5>
                                        <p class="text-muted"><small>15 hours ago</small></p>
                                    </div>
                                </div>
                                <p>The parallax is a little odd but O.o that house build is awesome!!</p>

                                <iframe src='../../video/87993762.html' height='300' class="img-fluid border-0"></iframe>
                            </div>

                            <div class="text-center">
                                <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                            </div>
                        </div>

                        <div class="tab-pane  show active" id="settings">
                            <form method="POST" action="{{route('user_edit')}}">
                                @csrf
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Informações Profisionais</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="firstname" value="{{$user->name}}" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">E-mail</label>
                                            <input type="text" class="form-control" id="lastname" name="email" value="{{$user->email}}" disabled>
                                        </div>
                                    </div> <!-- end col -->
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                        <label for="task-title" class="form-label">Cargo</label>
                                        <select class="form-select form-control-light" name="cargo_id">
                                            @foreach (\App\Models\Cargo::all() as $cargo)
                                                @if ($cargo->id == $user->cargo->id )
                                                    <option value="{{$cargo->id}}" selected>{{$cargo->nome}}</option>
                                                @else
                                                    <option value="{{$cargo->id}}">{{$cargo->nome}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="task-priority" class="form-label">Data Contratação</label>
                                            <input type="text" class="form-control form-control-light" id="data_contratacao"
                                                data-single-date-picker="true" name="data_contratacao" value="{{$user->data_contratacao}}">
                                        </div>
                                    </div>
                                </div>
                                
                     

                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Informações Comerciais</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="task-title" class="form-label">Equipe</label>
                                            
                                            @if ($user->equipe)
                                                <input type="text" class="form-control" id="lastname" name="email" value="{{$user->equipe->nome}}" disabled>
                                            @else 
                                            <input type="text" class="form-control" id="lastname" name="email" value="Sem Equipe" disabled>
                                            @endif 
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                    <label for="task-title" class="form-label">Permissões 

                                    @if (\Auth::user()->hasRole('admin'))
                                        <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#permissaoModal" role="button"> + </a> 
                                    @endif
                                    </label>
                                    <br>
                                    @if ( $user->roles() )
                                        @foreach ($user->roles as $role)
                                        <a href="#" class="confirm-delete" data-id="{{$role->id}}" data-name="{{$role->name}}"><span class="badge badge-info-lighten">{{$role->name}}</span> </a>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                                
                                @if (\Auth::user()->hasRole('admin'))
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                </div>
                                @endif
                                <input name="user_id" value="{{app('request')->id}}" hidden >
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


<div class="modal fade" id="revogarPermissao" tabindex="-1" aria-labelledby="permissaoModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="p-2" action="{{route('del_permissao')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <p> Deseja Remover a permisão abaixo?</p>
                    
                    <span class="badge badge-danger-lighten" id="nome_permissao"></span>
                </div>
                <div class="modal-footer">

                    <input type="submit" class="btn btn-success mt-2" value="Confirmar">
                    <input type='text' hidden="true" id ='yes_no' name='delete_id'>
                    <input type='text' hidden="true" name='user_id' value="{{app('request')->id}}">
                    <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Fechar">
                </div>
            </form>
		</div>
	</div>
</div>

<div class="modal fade" id="permissaoModal" tabindex="-1" aria-labelledby="permissaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        <form class="p-2" action="{{route('add_permissao')}}" method="POST" >
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
                        <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">

                <input type="text" name="user_id" hidden value="{{app('request')->id}}">

                <input type="submit" class="btn btn-success mt-2" value="Enviar">
                <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">

                </div>

            </form>
            </div>
        </div>
    </div>



<!-- Modal -->
<div class="modal fade"  id="edit-profile-img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Foto de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <form class="p-2" action="{{url('users/edit/avatar')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Faça o Upload da Sua Imagem<span class="text-danger">
                                                *</label>
                                                <input type="file" name="image" id="inputImage"  class="form-control @error('image') is-invalid @enderror">
                                                <input name="user_id" hidden value={{app('request')->id}}>
                                            <br>
                                            <img id="myImg" class="rounded-circle avatar-lg img-thumbnail" src="#" >
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Salvar</button>
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

    $('body').on('click', '.confirm-delete', function (e){
        //MSK-000122		
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        document.getElementById('yes_no').value = id;

        $('#nome_permissao').text(name);
        $('#revogarPermissao').data('id1', id).modal('show');//MSK-000123
    });

    /* The uploader form */
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


    $('#data_contratacao').datepicker({
        orientation: 'top',
        todayHighlight: true,
        format: "dd/mm/yyyy",
        defaultDate: +7
    });



</script>


@endsection