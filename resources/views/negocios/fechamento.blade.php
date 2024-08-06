@extends('main')
<?php

use App\Enums\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\SimNao;
use App\Enums\Tabela;

use App\Enums\VendaStatus;

function to_data($data)
{
    try {
        return Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y');
    } catch (Exception $e) {
        return '';
    }
}
?>
@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('main_content')
<style>
    /* .mb-3 {
        margin-bottom: 0.25rem !important;
    } */

    .mb-3 {
        display: flex;
        align-items: center;
        margin-bottom: 0.25rem !important;
    }

    .form-label {
        margin-right: 10px;
        min-width: 150px;
        /* Ajuste conforme necessário */
    }

    .form-control {
        flex: 1;
    }

    .header-section {
        margin-top: 30px;
        /* display: flex; */
        align-items: center;
        border-bottom: 2px solid #000;
        padding: 10px;
    }


    .empresa-logo img {
        max-width: 100px;
    }

    .header-content {
        flex: 4;
        text-align: center;
    }

    .header-content h1 {
        font-size: 16px;
        margin: 0;
    }

    .header-content p {
        margin: 5px 0;
    }

    .info-table {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
    }

    .info-table td {
        border: none;
        padding: 5px;
    }

    .info-table td input {
        border: none !important;

        width: 100%;
    }

    .signature-line {
        width: 100%;
        border-top: 1px solid black;
        margin-top: 20px;
    }

    #areaprint {
        background: white;
    }

    h5 {
        color: black;
        background-color: lightgrey;
        border-bottom: 2px solid #000;
    }

    @media print {



        input {
            border: none !important;
        }

        table,
        td {
            border: none !important;
        }

        .signature-line {
            width: 100%;
            border-top: 3px solid black;
            margin-top: 20px;
        }

        .empresa-logo img {
            max-width: 100px;
        }

        .hidden-print {
            display: none !important;
            background: black;
        }

        .no-print {
            display: none !important;
        }

    }
</style>
<div class="container-fluid">



    <div class="row" id="areaprint">

        <div class="header-section">
            <div class="row">
                <div class="col-md-2">
                    <div class="empresa-logo">
                        <img src="{{ url('') }}/images/empresa/logos/empresa_logo_transparente.png" alt="Logo">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="header-content">
                        <h1>FICHA CADASTRAL - QUALIFICAÇÃO DO CONSORCIADO</h1>
                        <p>{{ strtoupper(config('nome')) }} – {{ config('cnpj') }}</p>
                        <table class="info-table">
                            <tr>
                                <td>VENDEDOR(A):</td>

                                <td><input type="text" value="<?php 
                                if ($fechamento->primeiro_vendedor_id){
                                    echo App\Models\User::find($fechamento->primeiro_vendedor_id)->name;
                                }?>">


                                </td>
                                <td>DATA:</td>
                                <td><input type="text" value="<?php 
                                if ($fechamento->data_fechamento){
                                    echo to_data($fechamento->data_fechamento);
                                }?>"> </td>
                            </tr>
                            <tr>
                                <td>CONTRATO:</td>
                                <td><input type="text" value="<?php 
                                if ($fechamento->numero_contrato){
                                    echo ($fechamento->numero_contrato);
                                }?>"></td>
                                <td>GRUPO:</td>
                                <td><input type="text" value="<?php 
                                if ($fechamento->grupo){
                                    echo ($fechamento->grupo);
                                }?>"></td>
                                <td>COTA:</td>
                                <td><input type="text" value="<?php 
                                if ($fechamento->cota){
                                    echo ($fechamento->cota);
                                }?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-center mt-sm-0 mt-3 text-sm-end no-print">

                        <div class="btn-group mt-sm-0 mt-3 text-sm-end">
                            <a type="button" class="btn btn-primary" id="printButton" onclick="PrintElement()" href="#"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-printer"></i><span></span></a>
                        </div>

                        <div class="btn-group mt-sm-0 mt-3 text-sm-end">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-apps"></i><span></span>
                            </button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                    href="{{ route('negocio_edit', ['id' => $negocio->id]) }}">Editar
                                    Negócio</a>


                            </div>


                        </div>



                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="tab-pane" id="administrativo">
                        <form id="fechamento_vendas" method="POST" action="{{ route('vendas.fechamento') }}">
                            @csrf

                            <h5 class="mb-3 text-uppercase p-2"><i class="mdi mdi-office-building me-1"></i>
                                Informações Pessoais</h5>


                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">NOME COMPLETO</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->nome }}"
                                            name="nome">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">DATA DE NASCIMENTO</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true"
                                            value="{{ to_data($negocio->lead->data_nasc) }}" name="data_nasc">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">NOME DO PAI</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->nome_pai }}"
                                            name="nome_pai">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NOME DA MÃE</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->nome_mae }}"
                                            name="nome_mae">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CPF</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->cpf }}"
                                            name="cpf">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RG</label>
                                        <input type="text" class="form-control" name="rg"
                                            value="{{ $negocio->lead->rg }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ORGÃO EXPEDITOR</label>
                                        <input type="text" class="form-control" name="orgao_exp"
                                            value="{{ $negocio->lead->orgao_exp }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">DATA DE EXPEDIÇÃO</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true"
                                            value="{{ to_data($negocio->lead->data_exp) }}" name="data_exp">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NACIONALIDADE</label>
                                        <input type="text" class="form-control" name="nacionalidade"
                                            value="{{ $negocio->lead->nacionalidade }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ESTADO CIVIL</label>
                                        <input type="text" class="form-control" name="estado_civil"
                                            value="{{ $negocio->lead->estado_civil }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">GÊNERO</label>
                                        <input type="text" class="form-control" name="genero"
                                            value="{{ $negocio->lead->genero }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NATURALIDADE</label>
                                        <input type="text" class="form-control" name="naturalidade"
                                            value="{{ $negocio->lead->naturalidade }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">FORMAÇÃO</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->formacao }}"
                                            name="formacao">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">PROFISSÃO/CARGO</label>
                                        <input type="text" class="form-control" name="profissao"
                                            value="{{ $negocio->lead->profissao }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RENDA LIQUIDA MENSAL</label>
                                        <input type="text" class="form-control moeda" name="renda_liquida"
                                            value="{{ $negocio->lead->renda_liquida }}">
                                    </div>
                                </div>

                            </div>

                            <h5 class="mb-3 text-black text-uppercase p-2"><i class="mdi mdi-office-building me-1"></i>
                                INFORMAÇÕES PESSOAIS DO CÔNJUDE</h5>


                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">NOME COMPLETO</label>
                                        <input type="text" class="form-control" value="{{ $negocio->conjuge->nome }}"
                                            name="conj_nome">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">DATA DE NASCIMENTO</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="conj_data_nasc"
                                            value="{{ to_data($negocio->conjuge->data_nasc) }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CPF</label>
                                        <input type="text" class="form-control" value="{{ $negocio->conjuge->cpf }}"
                                            name="conj_cpf">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RG</label>
                                        <input type="text" class="form-control" name="conj_rg"
                                            value="{{ $negocio->conjuge->rg }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ORGÃO EXPEDITOR</label>
                                        <input type="text" class="form-control" name="conj_orgao_exp"
                                            value="{{ $negocio->conjuge->orgao_exp }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">DATA DE EXPEDIÇÃO</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" value="{{ $negocio->conjuge->data_exp }}"
                                            name="conj_data_exp">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NACIONALIDADE</label>
                                        <input type="text" class="form-control" name="conj_nacionalidade"
                                            value="{{ $negocio->conjuge->nacionalidade }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">GÊNERO</label>
                                        <input type="text" class="form-control" name="conj_genero"
                                            value="{{ $negocio->conjuge->genero }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">FORMAÇÃO</label>
                                        <input type="text" class="form-control"
                                            value="{{ $negocio->conjuge->formacao }}" name="conj_formacao">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">PROFISSÃO/CARGO</label>
                                        <input type="text" class="form-control" name="conj_profissao"
                                            value="{{ $negocio->conjuge->profissao }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NATURALIDADE</label>
                                        <input type="text" class="form-control" name="conj_naturalidade"
                                            value="{{ $negocio->conjuge->naturalidade }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RENDA LIQUIDA MENSAL</label>
                                        <input type="text" class="form-control money" name="conj_renda_liquida"
                                            value="{{ $negocio->conjuge->renda_liquida }}">
                                    </div>
                                </div>
                            </div>


                            <h5 class="mb-3 text-uppercase p-2"><i class="mdi mdi-office-building me-1"></i>
                                ENDEREÇO RESIDENCIAL</h5>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">CEP</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->cep }}"
                                            name="cep">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RUA/AV</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->endereco }}"
                                            name="endereco">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NÚMERO</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->numero }}"
                                            name="numero">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">BAIRRO</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->bairro }}"
                                            name="bairro">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">CIDADE</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->cidade }}"
                                            name="cidade">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ESTADO</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->estado }}"
                                            name="estado">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TELEFONE</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->telefone }}"
                                            name="telefone">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TELEFONE CôNJUDE </label>
                                        <input type="text" class="form-control"
                                            value="{{ $negocio->conjuge->telefone }}" name="conf_telefone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">EMAIL</label>
                                        <input type="text" class="form-control" value="{{ $negocio->lead->email }}"
                                            name="email">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 text-uppercase p-2"><i class="mdi mdi-office-building me-1"></i>
                                DADOS DO PLANO CONTRATADO</h5>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">GRUPO</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->grupo }}"
                                            name="grupo">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">COTA</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->cota }}"
                                            name="cota">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">ESPÉCIE</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->especie }}"
                                            name="especie">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">MARCA</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->marca }}"
                                            name="marca">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">MODELO</label>
                                        <input type="text" class="form-control" name="modelo"
                                            value="{{ $fechamento->modelo }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CÓDIGO DO BEM</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->codigo_bem }}"
                                            name="codigo_bem">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PREÇO DO BEM</label>
                                        <input type="text" class="form-control money"
                                            value="{{ $fechamento->preco_bem }}" name="preco_bem">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">DURAÇÃO DO GRUPO</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->duracao_grupo }}"
                                            name="duracao_grupo">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">DURAÇÃO DO PLANO</label>
                                        <input type="text" class="form-control" name="duracao_plano"
                                            value="{{ $fechamento->duracao_plano }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">TIPO DO PLANO</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->tipo_plano }}"
                                            name="tipo_plano">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PLANO LEVE (LIGHT)</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->plano_leve }}"
                                            name="plano_leve">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">SEGURO PRESTAMISTA</label>
                                        <input type="text" class="form-control" name="seguro_prestamista"
                                            value="{{ $fechamento->seguro_prestamista }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">GRUPO EM FORMAÇÃO</label>
                                        <select class="form-select" name="grupo_em_formacao">
                                            <option selected value="">Selecione</option>
                                            @foreach (SimNao::all() as $res)
                                            @if ($fechamento->grupo_em_formacao == $res)
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
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">GRUPO EM ANDAMENTO</label>
                                        <select class="form-select" name="grupo_em_andamento">
                                            <option selected value="">Selecione</option>
                                            @foreach (SimNao::all() as $res)
                                            @if ($fechamento->grupo_em_andamento == $res)
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
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Nº ASSEMBLÉIA DA ADESÃO</label>
                                        <input type="text" class="form-control" name="numero_assembleia_adesao"
                                            value="{{ $fechamento->numero_assembleia_adesao }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">DATA DA ASSEMBLÉIA</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="data_assembleia"
                                            value="{{ to_data($fechamento->data_assembleia) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">DATA DO FECHAMENTO</label>
                                        <input type="text" class="form-control form-control-light pfechamento"
                                            data-single-date-picker="true" name="data_fechamento"
                                            value="{{ to_data($fechamento->data_fechamento) }}">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PAGAMENTO INCORPORADO</label>
                                        <input type="text" class="form-control"
                                            value="{{ $fechamento->pagamento_incorporado }}"
                                            name="pagamento_incorporado">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PAGAMENTO ATÉ A
                                            CONTEMPLAÇÃO</label>
                                        <input type="text" class="form-control"
                                            value="{{ $fechamento->pagamento_ate_contemplacao }}"
                                            name="pagamento_ate_contemplacao">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TABELA</label>

                                        <select class="form-select" aria-label="Default select example" name="tabela">

                                            <option selected value="">Selecione</option>
                                            @foreach (Tabela::all() as $res)
                                            @if ($fechamento->tabela == $res)
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
                                <div class="col-md-4">
                                    <div class="mb-3">

                                        <label for="firstname" class="form-label">NUMERO DO CONTRATO</label>
                                        <input type="text" class="form-control" name="numero_contrato"
                                            value="{{ $fechamento->numero_contrato }}">

                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 text-uppercase p-2"><i class="mdi mdi-office-building me-1"></i>
                                FORMA DE PAGAMENTO INICIAL</h5>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">VALOR CRÉDITO</label>
                                        <input type="text" class="form-control moeda" value="{{ $fechamento->valor }}"
                                            name="valor">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PARCELA</label>
                                        <input type="text" class="form-control moeda" value="{{ $fechamento->parcela }}"
                                            name="parcela">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PARCELAS ANTECIPADAS</label>
                                        <input type="text" class="form-control"
                                            value="{{ $fechamento->parcela_antecipada }}" name="parcela_antecipada">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TOTAL ANTECIPADO</label>
                                        <input type="text" class="form-control money" name="total_antecipado"
                                            value="{{ $fechamento->total_antecipado }}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">ADESÃO</label>
                                        <input type="text" class="form-control moeda" value="{{ $fechamento->adesao }}"
                                            name="adesao">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PRIMEIRA PARCELA</label>
                                        <input type="text" class="form-control money"
                                            value="{{ $fechamento->primeira_parcela }}" name="primeira_parcela">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TOTAL PAGO EM GERAL</label>
                                        <input type="text" class="form-control money" name="total_pago"
                                            value="{{ $fechamento->total_pago }}">
                                    </div>
                                </div>
                            </div>

                            </br>

                            <div class="row no-print">
                                <label for="email" class="form-label"><strong>FORMA DE PAGAMENTO DO
                                        PLANO:</strong></label>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="forma_pagamento"
                                            id="forma_pagamento" value="dinheiro" checked>
                                        <label class="form-check-label" for="forma_pagamento">DINHEIRO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="forma_pagamento"
                                            id="forma_pagamento" value="debito" <?php if ($fechamento->forma_pagamento
                                        == 'debito') {
                                        echo 'checked';
                                        }

                                        ?>>
                                        <label class="form-check-label" for="forma_pagamento">CARTÃO DÉBITO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="forma_pagamento"
                                            id="forma_pagamento" value="credito" <?php if ($fechamento->forma_pagamento
                                        == 'credito') {
                                        echo 'checked';
                                        }

                                        ?>>
                                        <label class="form-check-label" for="forma_pagamento">CARTÃO CRÉDITO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="forma_pagamento"
                                            id="forma_pagamento" value="fgts" <?php if ($fechamento->forma_pagamento
                                        ==
                                        'debito') {
                                        echo 'fgts';
                                        }

                                        ?>>
                                        <label class="form-check-label" for="forma_pagamento">FGTS</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="forma_pagamento"
                                            id="forma_pagamento" value="boleto" <?php if ($fechamento->forma_pagamento
                                        == 'boleto') {
                                        echo 'checked';
                                        }

                                        ?>>
                                        <label class="form-check-label" for="forma_pagamento">BOLETO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="forma_pagamento"
                                            id="forma_pagamento" value="transferencia" <?php if
                                            ($fechamento->forma_pagamento == 'transferencia') {
                                        echo 'checked';
                                        }

                                        ?>>
                                        <label class="form-check-label" for="forma_pagamento">TRANSFERÊNCIA/PIX</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row no-print">
                                <label class="form-check-label" for="forma_pagamento">COMENTÁRIOS</label>
                                <div class="col-md-12">
                                    <textarea class="form-check-input" type="radio" name="comentarios" rows="20"
                                        cols="100"><textarea></textarea>
                                </div>
                            </div>
                            <div class="row no-print">
                                <h5 class="mb-3 text-uppercase text-white bg-success p-2"><i
                                        class="mdi mdi-office-building me-1"></i> INFORMAÇÕES DO COMERCIAL</h5>
                                <div class="col-md-4">
                                    <label for="task-title" class="form-label">Primeiro Vendedor</label>
                                    <select class="form-select form-control-light" id="vendedor_principal"
                                        name="primeiro_vendedor_id" required>
                                        <option selected value="">Selecione</option>
                                        @foreach (\Auth::user()->vendedores() as $user)
                                        @if ($user->id == $fechamento->primeiro_vendedor_id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}
                                        </option>
                                        @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="task-title" class="form-label">Segundo Vendedor</label>
                                    <select class="form-select form-control-light" id="vendedor_secundario"
                                        name="segundo_vendedor_id">
                                        <option selected value="">Selecione</option>
                                        @foreach (\Auth::user()->vendedores() as $user)
                                        @if ($user->id == $fechamento->segundo_vendedor_id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}
                                        </option>
                                        @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="task-title" class="form-label">Terceiro Vendedor</label>
                                    <select class="form-select form-control-light" id="vendedor_secundario"
                                        name="terceiro_vendedor_id">
                                        <option selected value="">Selecione</option>
                                        @foreach (\Auth::user()->vendedores() as $user)
                                        @if ($user->id == $fechamento->terceiro_vendedor_id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}
                                        </option>
                                        @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--
                            TODO isso será definido na aba de borderô
                            <div class="row no-print">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">COMISSÃO VENDEDOR 1</label>
                                        <input type="text" class="form-control" value="{{ $fechamento->comissao }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">COMISSÃO VENDEDOR 2</label>
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">COMISSÃO VENDEDOR 3</label>
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                            </div> --}}
                            </br>
                            <h5 class="mb-3 text-uppercase text-white bg-success p-2 no-print"><i
                                    class="mdi mdi-office-building me-1"></i>
                                CHECAGEM DO ADMINISTRATIVO</h5>

                            <div class="row hidden-print no-print">

                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="doc_consorciado" <?php if
                                            ($fechamento->doc_consorciado) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label"
                                            for="flexSwitchCheckDefault">DOCUMENTO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="doc_conjuge" <?php if
                                            ($fechamento->doc_conjuge) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label"
                                            for="flexSwitchCheckDefault">DOCUMENTO CÔNJUGUE</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="comp_pagamento" <?php if
                                            ($fechamento->comp_pagamento) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label"
                                            for="flexSwitchCheckDefault">COMPROVANTE PAGAMENTO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="comp_endereco" <?php if
                                            ($fechamento->comp_endereco) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label"
                                            for="flexSwitchCheckDefault">COMPROVANTE ENDEREÇO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="comp_venda" <?php if
                                            ($fechamento->comp_venda) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label"
                                            for="flexSwitchCheckDefault">COMPROVANTE VENDA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="self_declaracao" <?php if
                                            ($fechamento->self_declaracao) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">SELF
                                            DECLARAÇÃO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="controle_qualidade" <?php
                                            if ($fechamento->controle_qualidade) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">CONTROLE
                                            DE QUALIDADE</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="video" <?php if
                                            ($fechamento->video) {
                                        echo 'checked';
                                        } ?>>
                                        <label class="form-label form-check-label"
                                            for="flexSwitchCheckDefault">VIDEO</label>
                                    </div>
                                </div>
                                </br>
                            </div>
                            <input name="negocio_id" value="{{ app('request')->id }}" hidden>

                            <div class="text-center mt-sm-0 mt-3 text-sm-start no-print">
                                @if( config('broadcast_fechamento') == "true")
                                <button type="text" class="btn btn-danger mt-2" id="gerar_broadcast"><i
                                        class="mdi mdi-content-save"></i> Notificar Venda
                                </button>
                                @endif
                            </div>

                            <div class="text-end no-print">
                                <div class="btn-group mt-2">
                                    <select class="form-select primary" name="status">

                                        @foreach (VendaStatus::all() as $res)
                                        @if ($fechamento->status == $res)
                                        <option value="{{ $res }}" selected>{{ $res }}
                                        </option>
                                        @else
                                        <option value="{{ $res }}">{{ $res }}
                                        </option>
                                        @endif
                                        @endforeach


                                    </select>
                                </div>



                                <button type="text" class="btn btn-info mt-2" id="gerar_protocolo"><i
                                        class="mdi mdi-content-save"></i> Gerar Protocolo</button>



                                <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i>
                                    Salvar</button>
                            </div>
                        </form>
                    </div>

                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" style="text-align: center;">
                <div class="signature-line"></div>
                <h5>ASSINATURA DO CONSORCIADO</h5>
                <p>({{$negocio->lead->nome;}})</p>
            </div>
            <div class="col-md-4">
            </div>
        </div>


    </div>

    <!-- end row-->

</div>
<!-- container -->

<div class="modal fade task-modal-content" id="fechamento-protocolo" aria-labelledby="NewTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="center" id="venda_titulo">Protocolo de Fechamento</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-12" class="divtext">
                            <p id="txt_protocolo" rows="22" cols="50">_*SEJA BEM VINDO A {{ strtoupper(config('nome'))
                                }}*_<br>
                                Estimado Cliente {{ $negocio->lead->nome }}. Passando aqui para parabenizar você pela
                                *COTA DE CONSÓRCIO* que você aderiu!!
                                👏🎉🎊<br>
                                Informações do seu contrato de Consórcio: <br>
                                📄 Contrato: *{{ $fechamento->numero_contrato }}* <br>
                                👥Grupo: *{{ $fechamento->grupo }}<br>
                                👥Cota: *{{ $fechamento->cota }}* <br>
                                💰Crédito: *R$ {{ $fechamento->valor }}* <br>
                                ✅Adesão: *R$ {{ $fechamento->adesao }}* <br>
                                🟢Parcelas: *R$ {{ $fechamento->parcela }}* <br>
                                🧰Renda Declarada: *R$ {{ $negocio->lead->renda_liquida }}* <br>
                                <br>
                                Lembrando que no Consórcio não existe data de garantia de contemplação, você concorrerá
                                tanto por sorteio quanto por lance. Qualquer dúvida estarei a disposição!
                                <br><br>
                                Seja bem vindo a {{ config('nome') }}!!! 🥳🥳🥳☺️☺️☺️
                            </p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-end">
                    <button onclick="copyProtocolo()" class="btn btn-success">Copiar</button>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection


@section('specific_scripts')
<script>
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    function notificarFechamento(){

}
         function copyProtocolo() {

            console.log("Copy Protocolo");

            var text = document.getElementById('txt_protocolo').innerText;
            var elem = document.createElement("textarea");
            document.body.appendChild(elem);
            elem.value = text;
            elem.select();
            document.execCommand("copy");
            document.body.removeChild(elem);

            showAlert({
                message: "protocolo copiado",
                class: "success"
            });
            $('#agendamento-protocolo').modal('hide');
        }

        $('.pfechamento').datepicker({
            orientation: 'top',
            todayHighlight: true,
            format: "dd/mm/yyyy",
            defaultDate: +7
        });

        $(document).ready(function() {
            $('.moeda').mask('000.000.000.000.000,00', {
                reverse: true
            });
        });

        function atribuir($negocio_id, $user_id) {
            console.log("Atribuir " + $negocio_id + "para" + $user_id);
        }

        document.getElementById('gerar_protocolo').addEventListener('click',
            function(event) {
                $('#fechamento-protocolo').modal('show');
                event.preventDefault();
            });
        
        
        var gerar_broadcast = document.getElementById('gerar_broadcast');
        if (gerar_broadcast){
            gerar_broadcast.addEventListener('click',
            function(event) {
                
                event.preventDefault();
                
                info = [];
                info[0] = {{$negocio->id}};
                info[1] = {{$fechamento->primeiro_vendedor_id}};
                
                $.ajax({
                    url: "{{ url('vendas/notificacao') }}",
                    type: 'post',
                    data: {
                        info: info
                    },
                    Type: 'json',
                });
                
                
                });
        }
        

        
        function PrintElement() {

            //var printContents = document.getElementById('areaprint').innerHTML;
            //var originalContents = document.body.innerHTML;
           // var clientName = "{{$negocio->lead->nome;}}"
       
            
            
            
            print();
            //document.body.innerHTML = originalContents;
        }
</script>
@endsection