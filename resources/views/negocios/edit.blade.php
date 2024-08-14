@extends('main')
<?php

use App\Enums\UserStatus;
use App\Models\User;
use App\Enums\NegocioTipo;
use App\Enums\DificuldadeTipo;
use App\Enums\SimNao;
use App\Enums\Planejamento;
use App\Enums\Produtos;
use App\Enums\EstadoCivil;
use App\Enums\ComprovacaoRenda;
use App\Enums\LevantamentoStatus;
?>

@section('main_content')
<div class="container-fluid">
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
                                        <img src="{{ url('') }}/images/users/avatars/user-padrao.png" alt=""
                                            class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white">{{ $negocio->titulo }}</h4>
                                        <p class="font-13 text-white-50"> {{ $negocio->tipo }}</p>

                                        @if ($levantamento->status)


                                        @if($levantamento->status == "APROVADO")
                                        <span class="badge bg-success float-begin">APROVADO</span>
                                        @elseif ($levantamento->status == "REJEITADO")
                                        <span class="badge bg-danger float-begin">REJEITADO</span>
                                        @else
                                        <span class="badge bg-warning float-begin">EM APROVAÇÂO</span>

                                        @endif

                                        @endif



                                        <ul class="mb-0 list-inline text-light">
                                            <li class="list-inline-item me-3">
                                                <h5 class="mb-1 font-19">R$ {{ $negocio->valor }}</h5>
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
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        @if ($negocio->user)
                                        <i class="mdi mdi-face">{{ $negocio->user->name }}</i><span></span>
                                        @else
                                        <i class="mdi mdi-face">Não Atribuido</i><span></span>
                                        @endif
                                    </button>

                                    <div class="dropdown-menu">
                                        @foreach (User::all() as $user)
                                        @if ($user->status == UserStatus::ativo)
                                        <a class="dropdown-item"
                                            href="{{ route('atribui_one', ['negocio_id' => $negocio->id, 'novo_proprietario_id' => $user->id]) }}">{{
                                            $user->name }}</a>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="btn-group mt-sm-0 mt-3 text-sm-end">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-apps"></i><span></span>
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('negocios.simulacao', ['negocio_id' => $negocio->id]) }}">Simulacao</a>

                                        <a class="dropdown-item"
                                            href="{{ route('simulacao.index', ['negocio_id' => $negocio->id]) }}">Simulacao
                                            Multi</a>

                                        <a class="dropdown-item"
                                            href="{{ route('pipeline_index', ['id' => 1, 'proprietario' => \Auth::user()->id, 'status' => 'ativo']) }}">Pipeline</a>
                                        <hr>
                                        <a class="dropdown-item"
                                            href="{{ route('negocio_fechamento', ['id' => $negocio->id]) }}">Fechamento</a>
                                    </div>



                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div>
            <!--end profile/ card -->
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
                        <p class="text-muted mb-2 font-13"><strong>Nome :</strong> <span class="ms-2">{{
                                $negocio->lead->nome }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Telefone :</strong><span class="ms-2">{{
                                $negocio->lead->telefone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>WhatsApp :</strong> <span class="ms-2 ">{{
                                $negocio->lead->whatsapp }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{
                                $negocio->lead->email }}</span></p>

                        <p class="text-muted mb-1 font-13"><strong>Endereço :</strong> <span class="ms-2">{{
                                $negocio->lead->endereco }}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Complemento :</strong> <span class="ms-2">{{
                                $negocio->lead->complemento }}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Cep :</strong> <span class="ms-2">{{
                                $negocio->lead->cep }}</span></p>
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

                        <p class="text-muted mb-2 font-13"><strong>Grupo:</strong> <span class="ms-2">
                                {{ $negocio->grupo }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Cotas :</strong><span class="ms-2">{{ $negocio->cotas
                                }}</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Assembleia:</strong><span class="ms-2">{{
                                $negocio->assembleia }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Crédito :</strong><span class="ms-2">{{
                                $negocio->valor }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Contrato :</strong><span class="ms-2">{{
                                $negocio->contrato }}</span>
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
                            <a href="#observacoes" data-bs-toggle="tab" aria-expanded="true"
                                class="nav-link rounded-0 active ">
                                Observações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#levantamento" data-bs-toggle="tab" aria-expanded="true"
                                class="nav-link rounded-0 ">
                                Levantamento
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#atividades" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link rounded-0 ">
                                Atividades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#propostas" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Propostas
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#administrativo" data-bs-toggle="tab" aria-expanded="false"
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

                        <div class="tab-pane" id="levantamento">
                            <form id="negocio_levantamento" method="POST" action="{{ route('negocio_levantamento') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                class="mdi mdi-office-building me-1"></i> Ao Telefone </h5>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="firstname" class="form-label">Qual Bem ?</label>
                                        <select class="form-select form-control-light" id="tipo_credito"
                                            name="tipo_credito">
                                            <option value="">Selecione um valor</option>
                                            @foreach (NegocioTipo::all() as $neg)
                                            <option value={{ $neg }} @if ($negocio->tipo == $neg) {{
                                                'selected="selected"' }} @endif>
                                                {{ $neg }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="firstname" class="form-label">Grande Dificuldade?</label>
                                        <select class="form-select form-control-light" id="dificuldade"
                                            name="dificuldade">

                                            @foreach (DificuldadeTipo::all() as $neg)
                                            <option value={{ $neg }} @if ($levantamento->dificuldade == $neg) {{
                                                'selected="selected"' }} @endif>
                                                {{ $neg }}</option>
                                            @endforeach


                                        </select>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Região de Interesse</label>
                                            <input type="text" class="form-control" name="regiao" value={{
                                                $levantamento->regiao }}>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Valor do Bem Desejado</label>
                                            <input type="text" class="form-control money" name="valor"
                                                value="{{ $negocio->valor }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">É Urgente ?</label>
                                            <select class="form-select form-control-light" id="planejamento"
                                                name="planejamento">
                                                <option value="">Selecione um valor</option>
                                                @foreach (Planejamento::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->planejamento == $neg) {{
                                                    'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Parcela Máx Acessível</label>
                                            <input type="text" class="form-control money" name="parcela_max" value={{
                                                $levantamento->parcela_max }}>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Possui Valor de
                                                Entrada</label>
                                            <input type="text" class="form-control money" name="entrada_max" value={{
                                                $levantamento->entrada_max }}>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Desfazer de Algum Bem?</label>
                                            <input type="text" class="form-control" name="desfazer_bem" value={{
                                                $levantamento->desfazer_bem }}>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Se Mora de Alguel,
                                                Valor?</label>
                                            <input type="text" class="form-control money" name="aluguel" value={{
                                                $levantamento->aluguel }}>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Decisores</label>
                                            <input type="text" class="form-control" name="decisores" value={{
                                                $levantamento->decisores }}>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                class="mdi mdi-office-building me-1"></i> Presencial </h5>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Valor do FGTS</label>
                                            <input type="text" class="form-control money" name="valor_fgts" value={{
                                                $levantamento->valor_fgts }}>
                                        </div>
                                    </div>


                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Vai Compor Renda?</label>
                                            <select class="form-select form-control-light" id="compor_renda"
                                                name="compor_renda">
                                                <option value="">Selecione um valor</option>
                                                @foreach (SimNao::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->compor_renda == $neg) {{
                                                    'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">FINANCIAMENTO,EMPRESTIMO OU
                                                ACORDO</label>
                                            <select class="form-select form-control-light" id="financiamento"
                                                name="financiamento">
                                                <option value="">Selecione um valor</option>
                                                @foreach (Produtos::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->financiamento == $neg) {{
                                                    'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">POSSUI FILHO?</label>
                                            <select class="form-select form-control-light" id="filhos" name="filhos">
                                                <option value="">Selecione um valor</option>
                                                @foreach (SimNao::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->filhos == $neg) {{
                                                    'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Status Civil</label>
                                            <select class="form-select form-control-light" id="status_civil"
                                                name="status_civil">
                                                @foreach (EstadoCivil::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->status_civil == $neg) {{
                                                    'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">TEM CASA PRÓPRIA?</label>
                                            <select class="form-select form-control-light" id="casa_propria"
                                                name="casa_propria">
                                                @foreach (SimNao::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->casa_propria == $neg) {{
                                                    'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Valor Total da Renda
                                                Comprovada</label>
                                            <input type="text" class="form-control money" name="renda_total"
                                                value="{{ $levantamento->renda_total }}">

                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">
                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Como comprovar a renda?</label>


                                            <select class="form-select form-control-light" id="renda_comprovacao"
                                                name="renda_comprovacao">
                                                @foreach (SimNao::all() as $neg)
                                                <option value={{ $neg }} @if ($levantamento->renda_comprovacao == $neg)
                                                    {{ 'selected="selected"' }} @endif>
                                                    {{ $neg }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-3" id="imovel">

                                        <div class="col-md-12">
                                            <label for="firstname" class="form-label">Possui Alguma Restrição?</label>
                                            <input type="text" class="form-control" name="restricao"
                                                value="{{ $levantamento->restricao }}">
                                        </div>
                                    </div>


                                </div> <!-- end row -->

                                <input name="id_negocio" value="{{ app('request')->id }}" hidden>

                                <div class="col-md-12">
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                            class="mdi mdi-office-building me-1"></i> STATUS CLIENTE </h5>
                                </div>



                                <div class="row">
                                    <div class="col-md-3">
                                        {{-- <button id="btn_aprovar_cliente" type="submit"
                                            class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Aprovar
                                            Cliente</button>


                                        <input hidden id="aprovar_cliente" name="aprovar_cliente" value="0" /> --}}



                                        <div class="btn-group mt-2">
                                            <select class="form-select primary" name="aprovar_cliente">

                                                @foreach (LevantamentoStatus::all() as $res)
                                                @if ($levantamento->status == $res)
                                                <option value="{{ $res }}" selected>{{ $res }}
                                                </option>
                                                @else
                                                <option value="{{ $res }}">{{ $res }}
                                                </option>
                                                @endif
                                                @endforeach


                                            </select>
                                        </div>





                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">

                                    </div>
                                </div>

                                <div class="col-md-12">

                                    <button type="submit" class="btn btn-success mt-2 w-100"><i
                                            class="mdi mdi-content-save"></i> Salvar</button>

                                </div>





                                <input hidden name="negocio_id" value="{{ $negocio->id }}" />
                                <input hidden name="user_id" value="{{ \Auth::user()->id }}" />
                            </form>
                        </div>


                        <div class="tab-pane show active" id="observacoes">

                            <!-- comment box -->
                            <div class="border rounded mt-2 mb-3">
                                <form action="{{ route('inserir_comentario') }}" class="comment-area-box" method="POST">
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
                                        <button type="submit" class="btn btn-sm btn-dark waves-effect">Salvar</button>
                                    </div>
                                </form>
                            </div> <!-- end .border-->
                            <!-- end comment box -->


                            @foreach ($negocio->comentarios->sortDesc() as $negcom)
                            <div class="border border-light rounded p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle"
                                        src="{{ url('') }}/images/users/avatars/{{ $negcom->user->avatar }}"
                                        alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">{{ $negcom->user->name }}</h5>
                                        <p class="text-muted"><small>{{ $negcom->created_at }}</small></p>
                                    </div>
                                </div>
                                <p>{{ $negcom->comentario }}</p>

                            </div>
                            @endforeach
                        </div>

                        <div class="tab-pane" id="atividades">
                            @if (isset($negocio->atividades))
                            <div class="timeline-alt pb-0">
                                @foreach ($negocio->atividades->sortByDesc('id') as $atividade)
                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">

                                        <h5 class="mt-0 mb-0">author: {{ $atividade->user->name }}</h5>

                                        <p class="font-14">{{ $atividade->descricao }} <br><span class="ms-0 font-12">{{
                                                $atividade->data_atividade }}</span>
                                        </p>

                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <h5 class="text-uppercase">
                                <i class="mdi mdi-briefcase me-1"></i>Nenhuma Atividade
                            </h5>
                            @endif
                            <!-- end timeline -->
                        </div> <!-- end tab-pane -->

                        <?php $nenhum = true; ?>

                        <div class="tab-pane" id="propostas">

                            @if (isset($negocio->simulacoes))
                            <div class="timeline-alt pb-0">
                                @foreach ($negocio->simulacoes->sortByDesc('id') as $proposta)
                                <?php $nenhum = false; ?>
                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">

                                        <h5 class="mt-0 mb-0">Proposta (Versão 2): ID {{ $proposta->id }}
                                        </h5>
                                        <p class="font-14">
                                            <a href="{{ url('') }}/simulacao/proposta?id={{ $proposta->id }}"
                                                target='_blank'>Simulação de {{ $proposta->tipo }} de
                                                @foreach ($proposta->consorcios as $con)
                                                {{ $con['con-credito'] }}
                                                @endforeach
                                            </a>
                                            <br><span class="ms-0 font-12">Data de Criação:
                                                {{ $proposta->created_at }}</span>
                                        </p>

                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif


                            @if (isset($negocio->propostas))
                            <div class="timeline-alt pb-0">

                                @foreach ($negocio->propostas->sortByDesc('id') as $proposta)
                                <?php $nenhum = false; ?>
                                <div class="timeline-item">
                                    <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-0">Proposta (Versão 1): ID {{ $proposta->id }}:
                                        </h5>
                                        <p class="font-14">
                                            <a href="{{ url('') }}/negocios/proposta/{{ $proposta->id }}"
                                                target='_blank'>Simulação de {{ $proposta->tipo }}</a>

                                            <br><span class="ms-0 font-12">Data de Criação:
                                                {{ $proposta->created_at }}</span>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif



                            @if ($nenhum == true)
                            <h5 class="text-uppercase"><i class="mdi mdi-briefcase me-1"></i>Nenhuma Atividade
                            </h5>
                            @endif
                            <!-- end timeline -->
                        </div> <!-- end tab-pane -->

                        <div class="tab-pane" id="administrativo">
                            <form method="POST" action="{{ route('negocio_update') }}">
                                @csrf
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                    Informações Pessoais</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="firstname"
                                                value="{{ $negocio->lead->nome }}" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $negocio->lead->email }}">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Telefone</label>
                                            <input class="form-control" id="useremail"
                                                value="{{ $negocio->lead->telefone }}" name="telefone">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label fclass="form-label">WhatsApp</label>
                                            <input class="form-control" id="userpassword"
                                                value="{{ $negocio->lead->whatsapp }}" name="whatsapp">

                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Endereço</label>
                                            <input class="form-control" id="useremail"
                                                value="{{ $negocio->lead->endereco }}" name="endereco">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label fclass="form-label">Complemento</label>
                                            <input class="form-control" id="userpassword"
                                                value="{{ $negocio->lead->complemento }}" name="complemento">

                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label fclass="form-label">CEP</label>
                                            <input class="form-control" id="userpassword"
                                                value="{{ $negocio->lead->cep }}" name="cep">

                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->



                                <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                        class="mdi mdi-office-building me-1"></i> Negócio</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="companyname" class="form-label">Titulo</label>
                                            <input type="text" class="form-control" id="companyname"
                                                value="{{ $negocio->titulo }}" name="titulo">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cwebsite" class="form-label">Valor do Crédito</label>
                                            <input type="text" class="form-control" id="cwebsite"
                                                value="{{ $negocio->valor }}" name="valor" data-mask-reverse="true"
                                                data-mask="000.000.000.000.000,00">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->



                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i>
                                    Cliente
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-fb" class="form-label">Grupo</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $negocio->grupo }}"
                                                    name="grupo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-tw" class="form-label">Cota(s)</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" value="{{ $negocio->cota }}"
                                                    name="cota">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-fb" class="form-label">Data Assembleia</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control"
                                                    value="{{ $negocio->data_assembleia }}" name="data_assembleia">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-tw" class="form-label">Contrato(s)</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" value="{{ $negocio->contrato }}"
                                                    name="contrato">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <input name="id_negocio" value="{{ app('request')->id }}" hidden>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i> Salvar</button>
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


@section('specific_scripts')
<script>
    $(document).ready(function() {

    var hash = window.location.hash;

    var sessionAba = "{{ session('aba') }}";
    
    // Prioriza a aba da sessão, caso exista
    if (sessionAba) {
    hash = sessionAba;
    }

    if (hash) {
        $('.nav-pills a[href="' + hash + '"]').tab('show');
    }
    
    // Atualiza o fragmento da URL quando uma aba é selecionada
    $('.nav-pills a').on('shown.bs.tab', function(e) {
        window.location.hash = e.target.hash;
    });


    $('#btn_aprovar_cliente').on('click', function() {
        $('#aprovar_cliente').attr('value', '1');
        
        console.log( $('#aprovar_cliente').attr('value') );
        //$('#negocio_levantamento').submit();
        });
    });


</script>
@endsection