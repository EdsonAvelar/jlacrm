@extends('main')
@section('dynamic_page')

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Leads</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Form row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Informações de Contato</h4>
                    <p class="text-muted font-14">
                        Campos com asterisco são obrigatórios
                    </p>
                    <hr><br>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="form-row-preview">
                            <form action="" method="POST">
                                @csrf

                                <div class="row g-2">
                                    <div class="mb-3 col-md-4">
                                        <label for="inputNome4" class="form-label">Nome Completo<span
                                                class="text-danger">*</span></label>
                                        <input type="nome" class="form-control" id="inputNome4" placeholder="Nome"
                                            name="nome" required value="{{old('nome')}}">
                                        @error('name')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputTelefone4" class="form-label">Telefone<span
                                                class="text-danger">*</span></label>
                                        <input type="telefone" class="form-control" id="inputTelefone4"
                                            placeholder="Telefone" required="" name="telefone"
                                            value="{{old('telefone')}}">
                                        @error('telefone')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="example-email" class="form-label">Email</label>
                                        <input type="email" id="example-email" name="email" class="form-control"
                                            placeholder="Email" value="{{old('email')}}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="inputAddress" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="inputAddress" name="endereco"
                                        placeholder="1234 Main St" value="{{old('endereco')}}">
                                </div>

                                <div class="mb-3">
                                    <label for="inputAddress2" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="inputAddress2"
                                        placeholder="Apartment, studio, or floor" name="complemento"
                                        value="{{old('complemento')}}">
                                </div>

                                <div class="row g-2">
                                    <div class="mb-3 col-md-6">
                                        <label for="inputCity" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="inputCity" name="cidade"
                                            value="{{old('cidade')}}">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputState" class="form-label">Estado</label>
                                        <select id="inputState" class="form-select">
                                            <option>Escolha</option>
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="inputZip" class="form-label">CEP</label>
                                        <input type="text" class="form-control" id="inputZip" name="cep"
                                            value="{{old('cep')}}">
                                    </div>
                                </div>

                                <h4 class="header-title">Informações do Negócio</h4>
                                <hr>
                                <div class="row g-2">
                                    <div class="mb-3 col-md-12">
                                        <label for="inputTitle4" class="form-label">Titulo <span
                                                class="text-danger">*</span></label>
                                        <input type="titulo" class="form-control" id="inputTitle4"
                                            placeholder="Ex. Imóvel 200k Zona Oeste" name="titulo"
                                            value="{{old('titulo')}}" required>
                                        @error('titulo')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="mb-3 col-md-4">
                                        <label for="inputState" class="form-label">Fonte</label>
                                        <select id="inputState" class="form-select" name="fonte">
                                            <option>Escolha</option>
                                            <option>Facebook</option>
                                            <option>Instagram</option>
                                            <option>google</option>
                                            <option>Captação Própria</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="inputState" class="form-label">Funil</label>
                                        <select id="inputState" class="form-select" name="funil">
                                            <option>Escolha</option>
                                            <option>Vendas</option>
                                            <option>Posvenda</option>
                                            <option>Administrativo</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="inputState" class="form-label">Etapa do Funil</label>
                                        <select id="inputState" class="form-select" name="etapa">
                                            <option>Oportunidade</option>
                                            <option>PrimeiroContato</option>
                                            <option>Agendou Visita</option>
                                        </select>
                                    </div>
                                </div>




                                <button type="submit" class="btn btn-primary" name="submit">Adicionar Lead</button>
                            </form>
                        </div> <!-- end preview-->

                    </div> <!-- end tab-content-->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>
@endsection