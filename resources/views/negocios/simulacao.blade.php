<?php
use App\Enums\NegocioTipo;
use App\Models\User;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style>
        .fakedisabled {
            color: rgb(58, 57, 57);
            background-color: rgb(216, 216, 216);
            cursor: not-allowed;
        }

        .toggle.btn {
            width: 28rem !important;
            height: 4rem !important;
        }


        hr {
            border: 2px;
            color: black;
        }

        .input-auto {
            border-color: #66e9af;
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.3);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.3);
        }

        .jumb-auto {
            background-color: #66e9af
        }

        .jumb-manual {
            background-color: #66afe9
        }

        .content-auto {
            background-color: rgba(10, 122, 10, 0.1)
        }

        .content-manual {

            background-color: rgba(10, 10, 122, 0.1)
        }

        .select-items {
            position: absolute;
            background-color: #1eff9136;
            top: 100%;
            left: 0;
            right: 0;
            margin-left: 15px;
            margin-top: 3px;
            padding: 6px 0px 6px 0px;
            padding-left: 15px
        }
    </style>
</head>
</body>


<div id="jumb" class="jumbotron jumbotron-fluid jumb-auto">
    <div class="container">
        <h1 class="display-4">Criador de Propostas</h1>
        <p class="lead">Coloque os valores abaixo e clique em Gerar Proposta</p>
    </div>
</div>

<div class="container content-auto" id="content" style="padding:10px">

    <form id="form-criar" action="{{ route('negocios.criar_proposta') }}" method="post">
        @csrf

        <input type="text" hidden name="negocio_id" value="{{ $negocio->id }}">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Preenchimento</label>
            <div class="col-sm-5">
                <input type="checkbox" id="btAutoManual" name="btAutoManual" checked data-toggle="toggle"
                    data-on="Automático" data-off="Manual" data-onstyle="success" data-offstyle="light">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Consultor</label>
            <div class="col-sm-5">
                <input type="text" name="consultor" class="form-control" id="inputConsultor"
                    placeholder="Nome do Consultor" value="{{ User::find($negocio->user_id)->name }}" readonly>

            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Cliente</label>
            <div class="col-sm-5">
                <input type="text" name="cliente" class="form-control" id="inputCredito" placeholder="Nome do Cliente"
                    value="{{ $negocio->lead->nome }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <span class="text-danger"> *inserir parte do cpf do cliente traz mais credibilidade a simulação</span>
            <label for="inputEmail3" class="col-sm-2 col-form-label">CPF</label>
            <div class="col-sm-3">

                <input type="text" data-mask='000.000.000-00' name="cpf" class="form-control" id="cpf"
                    placeholder="CPF do Cliente" value="<?php
                    
                    if ($negocio->lead->cpf) {
                        echo $negocio->lead->cpf;
                    } else {
                        echo 'xxx.xxx.xxx-xx';
                    }
                    
                    ?>">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Tipo de Crédito</label>
            <div class="col-sm-5">
                {{-- <select class="form-select form-select-lg mb-3 select-items" name="tipo" id="tipoCredito"
                    aria-label=".form-select-lg example">
                    <option selected value="imóvel">Imóvel</option>
                    <option value="veículo">Veículo</option>
                    <option value="caminhão">Caminhão</option>
                    <option value="maquinário">Maquinário</option> --}}

                    <select class="form-select form-select-lg mb-3 select-items" name="tipo" id="tipoCredito">

                        @foreach (NegocioTipo::all() as $neg)
                        <option value={{ $neg }} @if ($negocio->tipo == $neg) {{ 'selected="selected"' }} @endif>
                            {{ $neg }}</option>
                        @endforeach

                    </select>


                </select>
            </div>
        </div>

        <div class="form-group row" id="veiculoModelo" style="display: none">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Fabricante/Modelo</label>
            <div class="col-sm-3">
                <input type="text" name="modelo" class="form-control" placeholder="Fabricante/Modelo">
            </div>
        </div>

        <div class="form-group row" id="veiculoAno" style="display: none">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Ano</label>
            <div class="col-sm-3">
                <input type="text" data-mask='yyyy' name="ano" class="form-control" placeholder="Ano do Veiculo">
            </div>
        </div>

        <hr>

        <input name="apenasconsorcio" id="apenasconsorcio" value="0" hidden>
        <br>
        <label for="formGroupExampleInput" class="financiamento">FINANCIAMENTO</label>
        <label for="formGroupExampleInput" class="consorcio" style="display:none">CONSÓRCIO 1</label>
        <br>

        <br>

        <div class="form-group row financiamento">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Amortização</label>
            <div class="col-sm-3">
                <input type="checkbox" id="sac_price" name="amortizacao" value="sac" data-toggle="toggle" data-on="SAC"
                    data-off="PRICE" data-onstyle="success" data-offstyle="warning" checked>
            </div>
        </div>

        <div class="form-group row ">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Banco</label>
            <div class="col-sm-3">
                <select class="form-select form-select-lg mb-3 select-items" id="selected_banco" name="banco"
                    aria-label=".form-select-lg example">
                    <option selected value="Bradesco">Bradesco</option>
                    <option value="Itau">Itau</option>
                    <option value="Santander">Santander</option>
                    <option value="Banco BV">Banco BV</option>
                    <option value="Caixa">Caixa</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Crédito</label>
            <div class="col-sm-3">
                <input value="R$ 200.000,00" data-mask='R$ #.##0,00' type="text" name="credito"
                    class="form-control input-auto" id="vCredito" placeholder="Crédito" required>
            </div>
        </div>

        <div class="form-group row financiamento">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Juros a.a</label>
            <div class="col-sm-3">
                <input value="12%" data-mask="0,0%" type="text" name="fin-entrada" class="form-control money input-auto"
                    id="finJuros" placeholder="Entrada" required>
            </div>
        </div>


        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Entrada</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="fin-entrada" class="form-control money input-auto"
                    id="vFinEntrada" placeholder="Entrada" required>
            </div>

        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Valor Parcelas</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="fin-parcelas" class="form-control input-auto"
                    id="vFinParcela" placeholder="Parcelas" required>
            </div>

        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Prazo</label>
            <div class="col-sm-3">
                <input value="360" type="number" name="fin-prazo" class="form-control input-auto" id="finPrazo"
                    placeholder="Prazo" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Renda Exigida</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="fin-rendaexigida" class="form-control"
                    id="vFinRendaExigida" placeholder="Valor" required>
            </div>
        </div>


        <div class="form-group row financiamento" id="itbiDiv">
            <label for="inputEmail3" class="col-sm-2 col-form-label">ITBI/RGI</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="cartorio" class="form-control" id="vITBI"
                    placeholder="Valor">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Juros</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="fin-juros-pagos" class="form-control fakedisabled"
                    id="vFinJuros" placeholder="Valor" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">ValorFinal</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="val-pago-total" class="form-control fakedisabled"
                    id="vFinTotal" placeholder="Valor" required>
            </div>
        </div>

        <hr>
        <br>
        <label for="formGroupExampleInput">CONSÓRCIO</label>
        <br>
        <br>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Administradora</label>
            <div class="col-sm-3">
                <input type="text" name="con-administradora" class="form-control" id="administradora"
                    placeholder="Nome da Administradora" value="MULTIMARCAS">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Crédito</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="con-credito" class="form-control" id="vConCredito"
                    placeholder="Valor" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Adesão</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="con-adesao" class="form-control" id="vConAdesao"
                    placeholder="Adesão" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Valor Parcela (Cheia)</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" class="form-control" id="vConParcela"
                    placeholder="Inserir Parcela Cheia (Sem Redução)" required>
            </div>

        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Entrada</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="con-entrada" class="form-control fakedisabled"
                    id="vConEntrada" placeholder="Entrada" required>
            </div>
            <div class="col-sm-3">
                <select class="form-select select-items" name="parcelas_embutidas" id="vConEmbutidas"
                    aria-label="Default select example">
                    <option selected value="0">Embutir Parcelas?</option>
                    <option value="0">Embutir 0</option>
                    <option value="1">Embutir 1</option>
                    <option value="2">Embutir 2</option>
                    <option value="3">Embutir 3</option>
                    <option value="4">Embutir 4</option>
                    <option value="5">Embutir 5</option>
                    <option value="6">Embutir 6</option>
                    <option value="7">Embutir 7</option>
                    <option value="8">Embutir 8</option>
                    <option value="9">Embutir 9</option>
                    <option value="10">Embutir 10</option>

                </select>
            </div>

        </div>

        <div class="form-group row">
            <span class="text-danger"> *inserir parcela cheia, marque aqui caso queira reduzir 30% na proposta
                final</span>

            <label for="inputEmail3" class="col-sm-2 col-form-label">Valor Reduzido</label>
            <div class="col-sm-3">

                <input data-mask='R$ #.##0,00' type="text" name="con-parcelas" class="form-control fakedisabled"
                    id="vConParcelaReduzida" placeholder="Valor da Parcela reduzida" value="" required>
            </div>
            <div class="col-sm-6">
                <div class="form-check">

                    <input type="checkbox" id="vConParcelaReduzidaCheck" name="reduzido" data-toggle="toggle"
                        data-on="Com Redução" data-off="Sem Redução" data-onstyle="success" data-offstyle="warning">

                    <label class="form-check-label">
                        Redução 30% ?
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Prazo</label>
            <div class="col-sm-3">
                <input type="number" name="con-prazo" class="form-control input-auto" id="vConPrazo" placeholder="Prazo"
                    required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Renda Exigida</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="con-rendaexigida" class="form-control fakedisabled"
                    id="vConRendaExigida" placeholder="Renda Exigida" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Taxas</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="con-juros-pagos" class="form-control fakedisabled"
                    id="vConJuros" placeholder="Valor" required>
            </div>

            <div class="col-sm-7">
                <div id="calcParcRed" hidden>
                    <label class="form-check-label">
                        Calcular Taxas e Valor Final com Parcela Reduzida ?
                    </label>
                    <div class="form-check">
                        <input type="checkbox" id="calculoReduzido" class="calculoReduzido" name="cal-reduzido"
                            data-toggle="toggle" data-on="Calculo com Parcela Reduzida"
                            data-off="Calculo com Parcela Cheia" data-onstyle="success" data-offstyle="warning" checked>
                    </div>
                </div>
            </div>


            <!--div class="col-sm-6" id="calcParcRed" hidden>
          <label class="form-check-label">
            Calcular Taxas e Valor Final com Parcela Reduzida ?
          </label>
          <div class="form-check">
            
            <input type="checkbox" id="calculoReduzido" name="cal-reduzido" checked data-toggle="toggle"
          data-on="Calculo com Parcela Cheia" data-off="Calculo com Parcela Reduzida" data-onstyle="success" data-offstyle="warning">

            
          </div>
          </div-->

        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">ValorFinal</label>
            <div class="col-sm-3">
                <input data-mask='R$ #.##0,00' type="text" name="con-valor-pago" class="form-control fakedisabled"
                    id="vConTotal" placeholder="Valor" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" id="gerar_proposta">Gerar Proposta</button>
            </div>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    var sistema_amortizacao = "sac";

    /** SCRIPT USADO PARA DESABILITAR UM INPUT */
    window.onload = function() {
        // var input = document.getElementById("vConParcelaReduzida");

        //   input.addEventListener("focus", function(event) {
        //     event.preventDefault();
        //     input.blur();
        //   });

    };

    function n_extc($frase, $delvirgula = false) {

        $frase = $frase.replaceAll('.', "")
        $frase = $frase.replaceAll('R$', "")
        $frase = $frase.replaceAll(' ', "")
        $frase = $frase.replaceAll(',', ".")

        return parseFloat($frase)
    }

    var automatic = true;


    $("#vCredito").focusout(function() {
        preencherValores('vCredito');
    })

    $("#finJuros").focusout(function() {
        preencherValores("finJuros");
    })

    $("#finPrazo").focusout(function() {
        preencherValores(false);
    })

    $("#vFinEntrada").focusout(function() {
        preencherValores('vFinEntrada');
    })

    $("#vFinParcela").focusout(function() {
        preencherValores("vFinParcela");
    })

    $("#vConPrazo").focusout(function() {
        preencherValoresConsorcio();
    })

    $("#vConCredito").focusout(function() {
        preencherValoresConsorcio();
    })

    $("#vConEntrada").focusout(function() {
        preencherValoresConsorcio();
    })

    $("#vConParcela").focusout(function() {
        preencherValoresConsorcio();
    })
    $("#vConAdesao").focusout(function() {
        preencherValoresConsorcio();
    })

    $("#vConEmbutidas").change(function() {
        preencherValoresConsorcio();
    });

    function preencherValoresConsorcio() {

        var vCredito = n_extc($("#vConCredito").val());

        let vConAdesao = n_extc($("#vConAdesao").val());
        let vConEmbutidas = n_extc($("#vConEmbutidas").val());

        let vConParcela = n_extc($("#vConParcela").val());
        let vPrazo = n_extc($("#vConPrazo").val());

        let vConParcelaReduzida = vConParcela;

        console.log('vConEmbutidas: ' + vConEmbutidas)

        let vConEntrada = 0;
        if (vConEmbutidas > 0) {
            vConEntrada = vConAdesao + vConParcela + (vConParcela * vConEmbutidas);
        } else {
            vConEntrada = vConAdesao + vConParcela;
        }

        if (document.getElementById('vConParcelaReduzidaCheck').checked) {
            vConParcelaReduzida = vConParcela * 0.7;
        }

        rendaExigida = parseFloat((vConParcela * 3));

        $('#vConRendaExigida').val(to_m(rendaExigida))

        let vTotal = (vPrazo * vConParcela) + vConEntrada
        let vJuros = vTotal - vCredito

        if (document.getElementById('calculoReduzido').checked) {
            vTotal = (vPrazo * vConParcelaReduzida) + vConEntrada
            vJuros = vTotal - vCredito
        }

        $('#vConCredito').val(to_m(vCredito));
        $('#vConAdesao').val(to_m(vConAdesao));
        $('#vConEntrada').val(to_m(vConEntrada));
        $('#vConParcela').val(to_m(vConParcela));
        $('#vConParcelaReduzida').val(to_m(vConParcelaReduzida));
        $('#vConJuros').val(to_m(vJuros))
        $('#vConTotal').val(to_m(vTotal))
    }

    function financiarSac($vFinanciado, $taxa, $prazo) {

        let $saldo_inicial = $vFinanciado
        let $amortizacao = $vFinanciado / $prazo
        let $valorJuros = $saldo_inicial * $taxa
        let $saldo_atualizado = $saldo_inicial + $valorJuros
        let $prestacao = $amortizacao + $valorJuros

        let $juros = $valorJuros;
        for (let a = 1; a < $prazo; a++) {
            //console.log($prestacao)

            $saldo_devedor = $saldo_atualizado - $prestacao
            $saldo_inicial = $saldo_devedor

            $valorJuros = $saldo_inicial * $taxa
            $saldo_atualizado = $saldo_inicial + $valorJuros
            $prestacao = $amortizacao + $valorJuros

            $juros += $valorJuros
        }

        return [$juros, $juros + $vFinanciado]
    }

    function financiarPrice($vFinanciado, $taxa, $prazo) {

        let $saldo_inicial = $vFinanciado
        let $amortizacao = $vFinanciado / $prazo
        let $valorJuros = $saldo_inicial * $taxa
        let $saldo_atualizado = $saldo_inicial + $valorJuros
        //let $prestacao = $amortizacao + $valorJuros

        let $prestacao = (($taxa * ($vFinanciado * ($taxa + 1) ** $prazo)) / (($taxa + 1) ** $prazo - 1));

        $juros_totais = ($prestacao * $prazo) - $vFinanciado;

        return [$juros_totais, $juros_totais + $vFinanciado, $prestacao]
    }


    function preencherValores($custom) {

        var vCredito = n_extc($("#vCredito").val());

        var taxa_entrada = 0.2;
        var selected_banco = $("#selected_banco :selected").text();
        if (selected_banco == "Bradesco") {
            taxa_entrada = 0.2;
        } else if (selected_banco == "Caixa") {
            taxa_entrada = 0.3;
        } else if (selected_banco == "Itau") {
            taxa_entrada = 0.1;
        }


        let vFinEntrada = 0
        if ($custom == "vCredito") {
            vFinEntrada = vCredito * taxa_entrada;
        } else {
            vFinEntrada = n_extc($("#vFinEntrada").val()); //vCredito * 0.1;
        }


        if (isNaN(vFinEntrada)) {
            vFinEntrada = 0;
        }


        if (globalThis.automatic === false) {
            vFinEntrada = n_extc($("#vFinEntrada").val()); //vCredito * 0.1;
        }

        var vFinanciado = vCredito - vFinEntrada;
        var finPrazo = n_extc($("#finPrazo").val())

        var vAmort = vFinanciado / finPrazo
        var taxa = parseFloat($("#finJuros").val().replace(',', '.')) / 12 / 100
        var vJuros = taxa * parseFloat(vFinanciado)

        var vParcela = 0;


        let financ = 0;
        if (sistema_amortizacao == "sac") {
            financ = financiarSac(vFinanciado, taxa, finPrazo);
            vParcela = vAmort + vJuros;

        } else {
            financ = financiarPrice(vFinanciado, taxa, finPrazo)
            vParcela = financ[2]
        }



        var itbi = vCredito / 2 * 0.1;

        var rendaExigida = 3.3 * vParcela
        rendaExigida = parseFloat(rendaExigida.toFixed(2));

        $('#vCredito').val(to_m(vCredito))

        if (globalThis.automatic === true) {
            $('#vFinEntrada').val(to_m(vFinEntrada))

            if ($custom != "vFinParcela") {
                $('#vFinParcela').val(to_m(vParcela))
            }


            $('#vFinRendaExigida').val(to_m(rendaExigida))
            $('#vITBI').val(to_m(itbi))
            $("#vConCredito").val($("#vCredito").val())


            $("#vFinJuros").val(to_m(financ[0]))
            $("#vFinTotal").val(to_m(financ[1] + vFinEntrada))

        } else {
            let vFinTotal = vParcela * finPrazo
            let vJuros = vFinTotal - vCredito

            $("#vFinJuros").val(to_m(vJuros))
            $("#vFinTotal").val(to_m(vFinTotal))
        }

    }

    $('#btAutoManual').change(function() {

        const nomes = ['vFinEntrada', 'finJuros', 'vCredito', 'vFinParcela', 'finPrazo', 'vConPrazo']

        if (this.checked) {
            globalThis.automatic = true;
            nomes.forEach(function(nome, i) {
                $('#' + nome).addClass('input-auto')
            });

            $('#jumb').removeClass('jumb-manual');
            $('#jumb').addClass('jumb-auto');
            $('#content').removeClass('content-manual');
            $('#content').addClass('content-auto');

        } else {
            globalThis.automatic = false;
            nomes.forEach(function(nome, i) {
                $('#' + nome).removeClass('input-auto')
            })

            $('#jumb').removeClass('jumb-auto')
            $('#jumb').addClass('jumb-manual')
            $('#content').removeClass('content-auto');
            $('#content').addClass('content-manual');
        }

    });

    $('#vConParcelaReduzidaCheck').change(function() {

        if (this.checked) {
            $('#calcParcRed').show()
            preencherValoresConsorcio()
        } else {
            preencherValoresConsorcio()
            $('#calcParcRed').hide()
        }

    });

    $('#sac_price').change(function() {

        if (this.checked) {
            sistema_amortizacao = "sac";
            preencherValores("vCredito");
            this.prop('value', 'sac');
        } else {
            sistema_amortizacao = "price";
            preencherValores("vCredito");
            this.prop('value', 'price');
        }

    });

    $('#selected_banco').change(function() {

        preencherValores('vCredito');

    });

    $('#calculoReduzido').change(function() {
        preencherValoresConsorcio()
    })


    $('#btFinConsorcio').change(function() {

        const nomes = ['financiamento']

        if (this.checked) {

            globalThis.automatic = true;
            nomes.forEach(function(nome, i) {
                //$('#' + nome).addClass('input-auto')
                $('.' + nome).css('display', 'block');
                $('.consorcio').css('display', 'none');
                $('#apenasconsorcio').val(0);

            });

        } else {
            globalThis.automatic = false;
            nomes.forEach(function(nome, i) {
                //$('#' + nome).removeClass('input-auto')

                $('.consorcio').css('display', 'block');
                $('.' + nome).css('display', 'none');

                $('#apenasconsorcio').val(1);
            })


        }

    });

    function to_m($valor) {

        //$valor = $valor.replaceAll(',','.')

        var valorfinal = jSuites.mask.run(parseFloat($valor.toFixed(2)), 'R$ #.##0,00');

        //console.log($valor,valorfinal)
        if (valorfinal.includes(',') === false) {
            valorfinal = valorfinal + ",00"
        } else {
            let posvirg = valorfinal.split(',')[1]
            if (posvirg.length === 1) {
                valorfinal = valorfinal + "0"
            }
            //console.log( 'valor: ', posvirg.length )
        }

        return valorfinal;
    }


    $('#tipoCredito').on('change', function() {

        if (this.value.toLowerCase() === "imovel") {

            //sistema_amortizacao = "sac";

            $('#itbiDiv').css('display', 'block');

            $('#veiculoModelo').css('display', 'none');
            $('#veiculoAno').css('display', 'none');
            $('#finJuros').val('12%');
            $('#finPrazo').val('360');

        } else {

            //sistema_amortizacao = "price";


            $('#veiculoModelo').css('display', 'block');
            $('#veiculoAno').css('display', 'block');
            $('#itbiDiv').css('display', 'none');

            $('#finJuros').val('29%');
            $('#finPrazo').val('60');

        }



        if (globalThis.automatic == true) {
            preencherValores("vCredito");
        }


    });
</script>

<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript"
    src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="https://jsuites.net/v4/jsuites.js"></script>

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


</body>

</html>