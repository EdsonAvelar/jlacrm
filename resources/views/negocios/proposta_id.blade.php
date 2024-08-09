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


            @if ($proposta->tipo == 'IMOVEL')
            <img align="right" class="mascote-img" src="{{ url('') }}/images/empresa/proposta/imovel.png"></img>
            @elseif ($proposta->tipo == 'veículo')
            <img align="right" class="mascote-img" src="{{ url('') }}/images/empresa/proposta/veiculo.png"></img>
            @elseif ($proposta->tipo == 'maquinário')
            <img align="right" class="mascote-img" src="{{ url('') }}/images/empresa/proposta/maquinario.png"></img>
            @elseif ($proposta->tipo == 'caminhão')
            <img align="right" class="mascote-img" src="{{ url('') }}/images/empresa/proposta/caminhao.png"></img>
            @endif

            <h3>CRÉDITO SOLICITADO: <span style="font-weight: bold;">
                    {{ $proposta->credito }}</span>
            </h3>

            <hr class='titulo'>

            <h4>Consultor Financeiro: <span style="font-weight: bold;">
                    {{ $proposta->user->name }}</span>
            </h4>
            <h4>Cliente: <span style="font-weight: bold;">
                    {{ $proposta->negocio->lead->nome }}</span>

            </h4>
            <h4>CPF: <span style="font-weight: bold;">
                    <?php
                    
                    if ($proposta->negocio->lead->cpf) {
                        echo $proposta->negocio->lead->cpf;
                    } else {
                        echo 'xxx.xxx.xxx-xx';
                    }
                    
                    ?>
                </span>
            </h4>

            <h4>Protocolo: <span style="font-weight: bold;">
                    {{ $proposta->created_at->format('Y') }}
                    <?php echo '/' . $proposta->id; ?>
                </span>
            </h4>

            <h4>Tipo do Bem: <span style="font-weight: bold;">
                    <?php echo ucfirst($proposta->tipo); ?>
                </span>
            </h4>

            <?php if ($proposta->tipo != "imóvel") {
				?>

            <h4>Fabricante/Modelo: <span style="font-weight: bold;">
                    <?php echo $proposta->modelo . ' - Ano: ' . $proposta->ano; ?>
                </span>
            </h4>

            <?php
				   
				}    
				use Carbon\Carbon;
				?>
            <h4>Data da Criação: <span style="font-weight: bold;">
                    {{ $proposta->created_at->format('d/m/Y - H:m') }}</span>
            </h4>
            <h4>Validade da Proposta: <span style="font-weight: bold;">
                    <?php echo date('d/m/Y'); ?>
                </span>
            </h4>


            <hr class="proposta">

            <h3>PROPOSTA 1:</h3>

            <table width="100%">
                <tr>
                    <td align="left">
                        <!-- ESQUERDA -->

                        <?php if (isset($_POST['apenasconsorcio']) and $_POST['apenasconsorcio'] == "1") { ?>
                        <h4>Modalidade de Crédito: CARTA DE CRÉDITO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                Multimarcas</span>
                        </h4>
                        <?php } else { ?>
                        <h4>Modalidade de Crédito: FINANCIAMENTO BANCÁRIO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                {{ $proposta->banco }}</span>
                        </h4>

                        <?php } ?>

                        <h4>Valor do Bem: <span style="font-weight: bold;">
                                {{ $proposta->credito }}</span>
                        </h4>
                        <h4>Entrada: <span style="font-weight: bold;">

                                {{ $proposta['fin-entrada'] }}
                            </span>
                        </h4>
                        <h4>Parcela: <span style="font-weight: bold;">
                                {{ $proposta['fin-parcelas'] }}

                            </span>
                        </h4>
                        <h4>Prazo: <span style="font-weight: bold;">
                                {{ $proposta['fin-prazo'] }} Meses ( {{ intval($proposta['fin-prazo'] / 12) }} Anos )
                            </span>
                        </h4>


                    </td>
                    <td align="left">
                        <!-- DIREITA -->

                        <?php 
						
						 if ($proposta->tipo == "IMOVEL") {
			        ?>
                        <h4>Despesas Cartoriais/ITBI: <span style="font-weight: bold;">
                                <?php echo $proposta->cartorio; ?>
                            </span></h4>
                        <h4>Tarifa de avaliação, reavaliação: <span style="font-weight: bold;">R$ 3.400,00</span> </h4>
                        <?php
					}
				
					?>


                        <h4>Renda líquida mínima exigida: <span style="font-weight: bold;">
                                {{ $proposta['fin-rendaexigida'] }} </span>
                        </h4>


                        <?php if (isset($_POST['apenasconsorcio']) and $_POST['apenasconsorcio'] == "1") { ?>
                        <h4>Total de Taxas: <span style="font-weight: bold;">
                                {{ $proposta['fin-juros-pagos'] }}</span>
                        </h4>
                        <?php } else { ?>
                        <h4>Total de Juros: <span style="font-weight: bold;">
                                {{ $proposta['fin-juros-pagos'] }} </span>
                        </h4>

                        <?php } ?>

                        <h4>Valor Final do Bem: <span style="font-weight: bold;">
                                {{ $proposta['val-pago-total'] }}
                            </span>
                        </h4>
                        <h4>Sistema de Amortização: <span style="font-weight: bold;">
                                <?php echo strtoupper($proposta['amortizacao']); ?>
                            </span>
                        </h4>

                    </td>

                </tr>
            </table>


            <hr class="proposta">


            <h3>PROPOSTA 2:</h3>

            <table width="100%">
                <tr>
                    <td align="left">

                        <h4>Modalidade de Crédito: CARTA DE CRÉDITO</h4>
                        <h4>Simulação: <span style="font-weight: bold;">
                                {{ $proposta['con-administradora'] }}</span>
                        </h4>

                        <h4>Valor do Bem: <span style="font-weight: bold;">

                                {{ $proposta['credito'] }}
                            </span>
                        </h4>

                        <h4>Entrada: <span style="font-weight: bold;">
                                {{ $con_entrada }}</span>
                        </h4>
                        <h4>Parcela: <span style="font-weight: bold;">
                                {{ $proposta['con-parcelas'] }}</span>
                        </h4>
                        <h4>Prazo: <span style="font-weight: bold;">
                                {{ $proposta['con-prazo'] }} Meses ( {{ intval($proposta['con-prazo'] / 12) }} Anos )
                            </span>
                        </h4>

                    </td>
                    <td align="left">
                        <!-- DIREITA -->
                        <?php if ($proposta['tipo'] == "IMOVEL") {
			        ?>
                        <h4>Despesas Cartoriais: <span style="font-weight: bold;">até 10% do Crédito</h4>
                        <?php
			    
			    }?>

                        <h4> Renda Mínima Exigida: <span style="font-weight: bold;">
                                {{ $proposta['con-rendaexigida'] }} </span>
                        </h4>

                        <h4>Total de Taxas: <span style="font-weight: bold;">
                                {{ $proposta['con-juros-pagos'] }} </span>
                        </h4>

                        <h4>Valor Final do Bem: <span style="font-weight: bold;">
                                {{ $proposta['con-valor-pago'] }}</span>
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