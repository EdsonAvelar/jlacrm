<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<style type="text/css">
    .pad {
        margin-top: 25%;
    }

    .mascote-img {
        padding-right: 50px;
        width: 250px;
        height: 15%;
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

            {{-- @if ($tipo == 'imóvel') --}}
            <img align="right" class="mascote-img"
                src="{{ url('') }}/images/empresa/proposta/{{ strtolower($tipo) }}.png"></img>
            {{-- @elseif ($tipo == "veículo")
					<img align="right" class="mascote-img" src="{{url('')}}/images/empresa/proposta/veiculo.png"></img>
				@elseif ($tipo == "maquinário")
					<img align="right" class="mascote-img" src="{{url('')}}/images/empresa/proposta/maquinario.png"></img>
				@elseif ($tipo == "caminhão")
					<img align="right" class="mascote-img" src="{{url('')}}/images/empresa/proposta/caminhao.png"></img>
				@endif --}}

            <h3>CRÉDITO SOLICITADO: <span style="font-weight: bold;">
                    <?php echo $_POST['credito']; ?></span>
            </h3>

            <hr class='titulo'>

            <h4>Consultor Financeiro: <span style="font-weight: bold;">
                    <?php echo $_POST['consultor']; ?></span>
            </h4>
            <h4>Cliente: <span style="font-weight: bold;">
                    <?php echo $_POST['cliente']; ?></span>
            </h4>
            <h4>CPF: <span style="font-weight: bold;">
                    <?php
                    
                    if (!empty($_POST['cpf'])) {
                        echo $_POST['cpf'];
                    }
                    
                    ?></span>
            </h4>
            <h4>Protocolo: <span style="font-weight: bold;">
                    <?php echo date('Y') . '/' . $proposta_id; ?></span>
            </h4>

            <h4>Tipo do Bem: <span style="font-weight: bold;">
                    <?php echo ucfirst($_POST['tipo']); ?></span>
            </h4>

            <?php if ($_POST['tipo'] != "imóvel") {
				?>

            <h4>Fabricante/Modelo: <span style="font-weight: bold;">
                    <?php echo $_POST['modelo'] . ' - Ano: ' . $_POST['ano']; ?></span>
            </h4>

            <?php
				    
				}    
				    
				?>
            <h4>Data da Criação: <span style="font-weight: bold;">
                    <?php echo \Carbon\Carbon::now('America/Sao_Paulo')->format('d/m/Y - H:m'); ?></span>
            </h4>
            <h4>Validade da Proposta: <span style="font-weight: bold;">
                    <?php echo date('d/m/Y', strtotime('+3 days')); ?></span>
            </h4>


            <hr class="proposta">

            <h3>PROPOSTA 1:</h3>


            <table width="100%">
                <tr>
                    <td align="left">
                        <!-- ESQUERDA -->

                        <?php if ($_POST['apenasconsorcio'] == "1") { ?>
                        <h4>Modalidade de Crédito: CARTA DE CRÉDITO - CONSÓRCIO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                Multimarcas</span>
                        </h4>
                        <?php } else { ?>
                        <h4>Modalidade de Crédito: FINANCIAMENTO BANCÁRIO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                <?php echo $_POST['banco']; ?></span>
                        </h4>

                        <?php } ?>



                        <h4>Valor do Bem: <span style="font-weight: bold;">
                                <?php echo $_POST['credito']; ?></span>
                        </h4>
                        <h4>Entrada: <span style="font-weight: bold;">
                                <?php echo $_POST['fin-entrada']; ?></span>
                        </h4>
                        <h4>Parcela: <span style="font-weight: bold;">
                                <?php echo $_POST['fin-parcelas']; ?></span>
                        </h4>
                        <h4>Prazo: <span style="font-weight: bold;">
                                <?php echo $_POST['fin-prazo']; ?> Meses ( <?php echo round($_POST['fin-prazo'] / 12); ?> Anos ) </span>
                        </h4>


                    </td>
                    <td align="left">
                        <!-- DIREITA -->

                        <?php if ($_POST['tipo'] == "imóvel") {
			        ?>

                        <?php if ($_POST['apenasconsorcio'] == "1") { ?>
                        <h4>Despesas Cartoriais: <span style="font-weight: bold;">até 10% do Crédito</h4>

                        <?php } else { ?>
                        <h4>Despesas Cartoriais/ITBI: <span style="font-weight: bold;"><?php echo $_POST['cartorio']; ?></span></h4>
                        <h4>Tarifa de avaliação, reavaliação: <span style="font-weight: bold;">R$ 3.400,00</span> </h4>

                        <?php } ?>



                        <?php
			    
			    }?>


                        <h4>Renda líquida mínima exigida: <span style="font-weight: bold;">
                                <?php echo $_POST['fin-rendaexigida']; ?> </span>
                        </h4>


                        <?php if ($_POST['apenasconsorcio'] == "1") { ?>
                        <h4>Total de Taxas: <span style="font-weight: bold;">
                                <?php echo $_POST['fin-juros-pagos']; ?></span>
                        </h4>
                        <?php } else { ?>
                        <h4>Total de Juros: <span style="font-weight: bold;">
                                <?php echo $_POST['fin-juros-pagos']; ?></span>
                        </h4>

                        <?php } ?>

                        <h4>Valor Final do Bem: <span style="font-weight: bold;">
                                <?php echo $_POST['val-pago-total']; ?></span>
                        </h4>

                        <h4>Sistema de Amortização: <span style="font-weight: bold;">
                                <?php echo strtoupper($amortizacao); ?></span>
                        </h4>


                    </td>

                </tr>
            </table>


            <hr class="proposta">


            <h3>PROPOSTA 2:</h3>

            <table width="100%">
                <tr>
                    <td align="left">
                        <!-- ESQUERDA -->


                        <h4>Modalidade de Crédito: CARTA DE CRÉDITO - CONSÓRCIO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                Multimarcas</span>
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
                        <!-- DIREITA -->
                        <?php if ($_POST['tipo'] == "imóvel") {
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
            </table>
            <!--?php echo "<img  align=\"right\" class=\"logo-multi\" src=\"/wp-content/uploads/2021/12/multimarcas_representanteautorizado.png\"></img>"; ?-->




            <p>** Sujeito à aprovação de crédito.<br>
                ** Esta proposta é uma simulação, não gerando qualquer espécie de obrigação entre as partes.
            </p>
        </div>

    </div>
</div>
