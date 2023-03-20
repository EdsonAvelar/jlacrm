@extends('main')


@section('main_content')

<div class="container-fluid">

    @include('layouts.alert-msg')
    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-secondary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="{{url('')}}/images/users/avatars/user-padrao.png" alt=""
                                            class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white">{{$negocio->titulo}}</h4>
                                        <p class="font-13 text-white-50"> {{$negocio->tipo}}</p>
                                        <ul class="mb-0 list-inline text-light">
                                            <li class="list-inline-item me-3">
                                                <h5 class="mb-1 font-19">R$ {{$negocio->valor}}</h5>
                                                <p class="mb-0 font-19 text-white-50">Valor do Crédito</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                <div class="btn-group mt-sm-0 mt-3 text-sm-end">
                                    <button type="button" class="btn btn-secondary" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-face">{{$negocio->user->email}}</i><span></span>
                                    </button>
                                   
                                </div>
                                <button type="button" class="btn btn-success"><i class="mdi mdi-thumb-up"></i>
                                    <span>Ganhou</span> </button>
                                <button type="button" class="btn btn-danger"><i class="mdi mdi-thumb-down"></i>
                                    <span>Perdeu</span> </button>

                                <div class="btn-group mt-sm-0 mt-3 text-sm-end">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-apps"></i><span></span>
                                    </button>
                                    <div class="dropdown-menu">
 
                                        <a class="dropdown-item" href="{{route('negocios.simulacao', array('negocio_id' => $negocio->id) )}}">Simulacao</a>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-start mt-3">
                        <h4 class="page-title text-uppercase">Pessoa</h4>
                        <p class="text-muted font-13 mb-3">
                            Informações sobre o Contato
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Nome :</strong> <span
                                class="ms-2">{{$negocio->lead->nome}}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Telefone :</strong><span
                                class="ms-2">{{$negocio->lead->telefone}}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>WhatsApp :</strong> <span
                                class="ms-2 ">{{$negocio->lead->whatsapp}}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                class="ms-2 ">{{$negocio->lead->email}}</span></p>

                        <p class="text-muted mb-1 font-13"><strong>Endereço :</strong> <span
                                class="ms-2">{{$negocio->lead->endereco}}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Complemento :</strong> <span
                                class="ms-2">{{$negocio->lead->complemento}}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Cep :</strong> <span
                                class="ms-2">{{$negocio->lead->cep}}</span></p>
                    </div>


                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Messages-->
            <div class="card">
                <div class="card-body">

                    <div class="text-start mt-3">
                        <h4 class="page-title text-uppercase">Negócio</h4>
                        <p class="text-muted font-13 mb-3">
                            Informações sobre o Negócio
                        </p>

                        <p class="text-muted mb-2 font-13"><strong>Idade do Negócio:</strong> <span class="ms-2">Inativo
                                por x dias</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Criado em :</strong><span class="ms-2">(123)
                                11/11/11</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Funil Atual :</strong><span
                                class="ms-2">VENDAS</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Etapa do Funil :</strong><span
                                class="ms-2">OPORTUNIDADE</span></p>

                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

            <!-- Messages-->
            <div class="card">
                <div class="card-body">

                    <div class="text-start mt-3">
                        <h4 class="page-title text-uppercase">Cliente</h4>
                        <p class="text-muted font-13 mb-3">
                            Se ja é cliente
                        </p>

                        <p class="text-muted mb-2 font-13"><strong>Grupo:</strong> <span class="ms-2"> 1231</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Cotas :</strong><span class="ms-2">1234/4034</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Assembleia:</strong><span class="ms-2">
                                11/11/11</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Crédito :</strong><span class="ms-2">120 k</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Contrato :</strong><span class="ms-2">12434</span>
                        </p>

                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#atividades" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Atividades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#observacoes" data-bs-toggle="tab" aria-expanded="true"
                                class="nav-link rounded-0 active">
                                Observações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#administrativo" data-bs-toggle="tab_inativa" aria-expanded="false"
                                class="nav-link rounded-0">
                                Adminstrativo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#administrativo" data-bs-toggle="tab_inativa" aria-expanded="false"
                                class="nav-link rounded-0">
                                Pós-venda
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="atividades">

                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                Ultimas Atividades</h5>

                            <div class="timeline-alt pb-0">

                            @foreach($negocio->propostas as $proposta) 
                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-1">Proposta: {{$proposta->tipo}} - {{$proposta->credito}}</h5>
                                        <p class="font-14">{{$proposta->user->name}} <span class="ms-2 font-12"> em {{$proposta->data_proposta}}</span></p>
                                        <p class="text-muted mt-2 mb-0 pb-3">Foi simulador uma Entrada de <strong>{{$proposta['con-entrada']}}</strong>  
                                        com parcelas de <strong>{{$proposta['con-parcelas']}} 
                                        @if ($proposta['reduzido'] =='s')
                                            com redução
                                        @else
                                            sem redução
                                        @endif
                                        </strong>
                                        e com <strong>{{$proposta['parcelas_embutidas']}}</strong> parcela(s) embutida(s)

                                        
                                    </p>
                                    </div>
                                </div>

                            @endforeach
                            </div>
                            <!-- end timeline -->


                        </div> <!-- end tab-pane -->
                        <!-- end about me section content -->

                        <div class="tab-pane show active" id="observacoes">

                            <!-- comment box -->
                            <div class="border rounded mt-2 mb-3">
                                <form action="{{route('inserir_comentario')}}" class="comment-area-box" method="POST">
                                    @csrf
                                    <textarea rows="3" class="form-control border-0 resize-none"
                                        placeholder="Escreva uma observação...." name="comentario"></textarea>
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
                                        <input hidden name="negocio_id" value="{{ $negocio->id }}" />
                                        <input hidden name="user_id" value="{{ \Auth::user()->id }}" />
                                        <button type="submit" class="btn btn-sm btn-dark waves-effect">Inserir</button>
                                    </div>
                                </form>
                            </div> <!-- end .border-->
                            <!-- end comment box -->


                            @foreach ($negocio->comentarios->sortDesc() as $negcom)

                            <div class="border border-light rounded p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle"
                                        src="{{url('')}}/images/users/avatars/{{$negcom->user->avatar}}"
                                        alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">{{$negcom->user->name}}</h5>
                                        <p class="text-muted"><small>{{$negcom->created_at}}</small></p>
                                    </div>
                                </div>
                                <p>{{$negcom->comentario}}</p>

                            </div>
                            @endforeach

                        </div>
                        <!-- end timeline content-->

                        <div class="tab-pane" id="administrativo">
                            <form>
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal
                                    Info</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstname"
                                                placeholder="Enter first name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastname"
                                                placeholder="Enter last name">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="userbio" class="form-label">Bio</label>
                                            <textarea class="form-control" id="userbio" rows="4"
                                                placeholder="Write something..."></textarea>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="useremail"
                                                placeholder="Enter email">
                                            <span class="form-text text-muted"><small>If you want to change email please
                                                    <a href="javascript: void(0);">click</a> here.</small></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="userpassword"
                                                placeholder="Enter password">
                                            <span class="form-text text-muted"><small>If you want to change password
                                                    please <a href="javascript: void(0);">click</a> here.</small></span>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                        class="mdi mdi-office-building me-1"></i> Company Info</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="companyname" class="form-label">Company Name</label>
                                            <input type="text" class="form-control" id="companyname"
                                                placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cwebsite" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="cwebsite"
                                                placeholder="Enter website url">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Social
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-fb" class="form-label">Facebook</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                                <input type="text" class="form-control" id="social-fb"
                                                    placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-tw" class="form-label">Twitter</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                                                <input type="text" class="form-control" id="social-tw"
                                                    placeholder="Username">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-insta" class="form-label">Instagram</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                                <input type="text" class="form-control" id="social-insta"
                                                    placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-lin" class="form-label">Linkedin</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                                <input type="text" class="form-control" id="social-lin"
                                                    placeholder="Url">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-sky" class="form-label">Skype</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-skype"></i></span>
                                                <input type="text" class="form-control" id="social-sky"
                                                    placeholder="@username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-gh" class="form-label">Github</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-github"></i></span>
                                                <input type="text" class="form-control" id="social-gh"
                                                    placeholder="Username">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div>
<!-- container -->

@endsection