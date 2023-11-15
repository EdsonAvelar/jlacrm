<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<style type="text/css">
    .pad {
        margin-top: 20%;
    }

    .mascote-img {
        padding-right: 50px;
        width: 250px;
        height: 250px%;
        padding-top: 50px;

    }

    .logo-multi {
        /*padding-top: 100px;*/

        width: 30%;
        /*height: 30%;*/
    }

    .back-img {
        position: absolute;
        width: 100%;
        height: 100%;
        /*float: center;*/
        z-index: -5;
    }

    p {
        font-family: "Times New Roman", Times, serif;
        font-size: 100%;
        /*text-align: "justify";*/
    }




    svg:not(:root) {
        height: 100% !important;
    }

    li.separador {
        width: 300px;
        /* coloque aqui a largura da linha */
        border-top: 1px solid #000;
        list-style-type: none;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }

    .container {
        width: 100%;
        height: 100%;
    }




    hr.proposta {
        /*margin-top: 50px;*/
        size: 10px;
        border-color: #C69316;
        border-width: 5px 0;
    }

    hr.titulo {
        -moz-border-bottom-colors: none;
        -moz-border-image: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #C69316;
        border-style: solid none;
        border-width: 5px 0;
        margin: 16px 0;
    }
</style>

<?php

function convert($frase)
{
    $padrao = ['.', ',', 'R$', ' '];
    $subs = [''];

    if (str_contains($frase, ',')) {
        //echo "conntem";
        $s = explode(',', $frase);
        #echo $s[0];
        return str_replace($padrao, $subs, $s[0]);
    } else {
        return str_replace($padrao, $subs, $frase);
    }
}

?>

<img align="center" class="back-img" src="{{ url('') }}/images/empresa/proposta/fundo_proposta.png"></img>

<div class="container">
    <div class="row pad">
        <div class="col-md-12">

            <img align="right" class="mascote-img"
                src="{{ url('') }}/images/empresa/proposta/{{ strtolower($simulacao->tipo) }}.png"></img>

            <h2 style="text-align: left"> PROPOSTA DE CRÉDITO </h2>
            <hr class='titulo'>

            <h4>Consultor Financeiro: <span style="font-weight: bold;">
                    {{ $simulacao->user->name }}</span>
            </h4>
            <h4>Cliente: <span style="font-weight: bold;">
                    {{ $simulacao->negocio->lead->nome }}</span>
            </h4>
            <h4>CPF: <span style="font-weight: bold;">
                    <?php
                    
                    if (!empty($simulacao->negocio->lead->cpf)) {
                        echo $simulacao->negocio->lead->cpf;
                    }
                    
                    ?></span>
            </h4>
            <h4>Protocolo: <span style="font-weight: bold;">
                    <?php echo date('Y') . '/' . $simulacao->id; ?></span>
            </h4>

            <h4>Tipo do Bem: <span style="font-weight: bold;">
                    <?php echo ucfirst($simulacao->tipo); ?></span>
            </h4>

            @if ($simulacao->tipo != 'IMOVEL')
                <h4>Fabricante/Modelo: <span style="font-weight: bold;">
                        <?php echo $_POST['modelo'] . ' - Ano: ' . $_POST['ano']; ?></span>
                </h4>
            @endif


            <h4>Data da Criação: <span style="font-weight: bold;">
                    <?php echo \Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y - H:m'); ?></span>
            </h4>
            <h4>Validade da Proposta: <span style="font-weight: bold;">
                    <?php echo date('d/m/Y', strtotime('+3 days')); ?></span>
            </h4>



            <?php $propostas = 0;
            
            ?>


            @if ($simulacao->financiamentos)


                @foreach ($simulacao->financiamentos as $financiamento)
                    <hr class="proposta">
                    <?php $propostas = $propostas + 1; ?>
                    <h3 style="text-align: center">PROPOSTA {{ $propostas }}:
                        {{ $financiamento['fin-titulo'] }} </h3>
                    <table width="100%">
                        <tr>
                            <td align="left">

                                <h4>Modalidade de Crédito: FINANCIAMENTO BANCÁRIO</h4>
                                <h4>Empresa: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-empresa'] }}</span>
                                </h4>
                                <h4>Valor do Bem: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-credito'] }}</span>
                                </h4>
                                <h4>Entrada: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-entrada'] }}</span>
                                </h4>
                                <h4>Parcela: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-parcelas'] }}</span>
                                </h4>
                                <h4>Prazo: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-prazo'] }} Meses ( <?php echo round($financiamento['fin-prazo'] / 12); ?> Anos ) </span>
                                </h4>


                            </td>
                            <td align="left">
                                @if ($simulacao->tipo == 'IMOVEL')
                                    <h4>Despesas Cartoriais/ITBI: <span
                                            style="font-weight: bold;">{{ $financiamento['cartorio'] }} </span></h4>
                                    <h4>Tarifa de avaliação, reavaliação: <span style="font-weight: bold;">R$
                                            2.400,00</span> </h4>
                                @endif

                                <h4>Renda líquida mínima exigida: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-rendaexigida'] }} </span>
                                </h4>

                                <h4>Total de Juros: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-juros-pagos'] }}</span>
                                </h4>

                                <h4>Valor Final do Bem: <span style="font-weight: bold;">
                                        {{ $financiamento['fin-val-pago-total'] }}</span>
                                </h4>

                                <h4>Sistema de Amortização: <span style="font-weight: bold;">
                                        <?php echo strtoupper($financiamento['fin-amortizacao']); ?></span>
                                </h4>
                            </td>
                        </tr>
                    </table>
                @endforeach
            @endif

            @if ($simulacao->consorcios)

                @foreach ($simulacao->consorcios as $consorcio)
                    <hr class="proposta">
                    <?php $propostas = $propostas + 1; ?>
                    <h3 style="text-align: center">PROPOSTA {{ $propostas }}:
                        {{ $consorcio['con-titulo'] }} </h3>

                    <table width="100%">
                        <tr>
                            <td align="left">

                                <h4>Modalidade de Crédito: CARTA DE CRÉDITO</h4>
                                <h4>Empresa: <span style="font-weight: bold;">
                                        {{ $consorcio['con-empresa'] }}</span></span>
                                </h4>

                                <h4>Valor do Bem: <span style="font-weight: bold;">
                                        {{ $consorcio['con-credito'] }}</span>
                                </h4>

                                <h4>Adesão: <span style="font-weight: bold;">
                                        {{ $consorcio['con-entrada'] }}</span>
                                </h4>
                                <h4>Parcela: <span style="font-weight: bold;">
                                        {{ $consorcio['con-parcela-cheia'] }}</span>
                                </h4>
                                <h4>*Parcela Reduzida: <span style="font-weight: bold;">
                                        {{ $consorcio['con-parcela-reduzida'] }}</span>
                                </h4>
                                <h4>Prazo: <span style="font-weight: bold;">
                                        {{ $consorcio['con-prazo'] }} Meses ( <?php echo round($consorcio['con-prazo'] / 12); ?> Anos ) </span>
                                </h4>
                            </td>
                            <td align="left">

                                @if ($consorcio['con-lance'])
                                    <h3> *Lance: <span style="font-weight: bold;">
                                            {{ $consorcio['con-lance'] }}
                                        </span>
                                    </h3>
                                    <br><br>
                                @else
                                @endif


                                @if ($simulacao->tipo == 'IMOVEL')
                                    <h4>Despesas Cartoriais: <span style="font-weight: bold;">até 10% do Crédito
                                    </h4>
                                @endif
                                <h4> Renda Mínima Exigida: <span style="font-weight: bold;">
                                        {{ $consorcio['con-rendaexigida'] }} </span>
                                </h4>
                                <h4>Total de Taxas: <span style="font-weight: bold;">
                                        {{ $consorcio['con-juros-pagos'] }}</span>
                                </h4>
                                <h4>Valor Final do Bem: <span style="font-weight: bold;">
                                        {{ $consorcio['con-valor-pago'] }}</span>
                                </h4>

                            </td>

                        </tr>
                    </table>
                @endforeach
            @endif

            {{--            
            <h3>PROPOSTA 1:</h3>

           

            <hr class="proposta">
            <h3>PROPOSTA 2:</h3>

            <table width="100%">
                <tr>
                    <td align="left">

                        <h4>Modalidade de Crédito: CARTA DE CRÉDITO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                <?php echo $_POST['con-administradora']; ?></span></span>
                        </h4>

                        <h4>Valor do Bem: <span style="font-weight: bold;">
                                <?php echo $_POST['con-credito']; ?></span>
                        </h4>

                        <h4>Entrada: <span style="font-weight: bold;">
                                {{ $con_entrada }}</span>
                        </h4>
                        <h4>Parcela: <span style="font-weight: bold;">
                                {{ $_POST['con-parcelas'] }}</span>
                        </h4>
                        <h4>Prazo: <span style="font-weight: bold;">
                                <?php echo $_POST['con-prazo']; ?> Meses ( <?php echo round($_POST['con-prazo'] / 12); ?> Anos ) </span>
                        </h4>

                    </td>
                    <td align="left">
                       
                        <?php if ($_POST['tipo'] == "IMOVEL") {
			        ?>
                        <h4>Despesas Cartoriais: <span style="font-weight: bold;">até 10% do Crédito</h4>
                        <?php
			    
			    }?>

                        <h4> Renda Mínima Exigida: <span style="font-weight: bold;">
                                <?php echo $_POST['con-rendaexigida']; ?> </span>
                        </h4>

                        <h4>Total de Taxas: <span style="font-weight: bold;">
                                <?php echo $_POST['con-juros-pagos']; ?></span>
                        </h4>
                        <h4>Valor Final do Bem: <span style="font-weight: bold;">
                                <?php echo $_POST['con-valor-pago']; ?></span>
                        </h4>

                    </td>

                </tr>
            </table> --}}


            <p>* Sujeito à aprovação de crédito.<br>
                ** Esta proposta é uma simulação, não gerando qualquer espécie de obrigação entre as partes.
            </p>
        </div>
    </div>
</div>
