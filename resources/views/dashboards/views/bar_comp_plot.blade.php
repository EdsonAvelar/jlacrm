<style>
    .modal-content {
        width: auto;
    }

    .apexcharts-legend-series {
        align-self: flex-start;
    }
</style>

<?php
$fullname = $name;

$name = str_replace(' ', '_', $name);
$name = strtolower($name);

?>

<div class="col-lg-6 col-xl-6 col-md-12" id="grafico_{{ $name }}">
    <div class="card">
        <div class="card-body">

            <div class="row align-items-center">
                <a href="#" onclick="showmodal('{{ $name }}')" id="click_{{ $name }}">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="{{ $fullname }}">{{ $fullname }}
                    </h5>

                    <div class="col-12">
                        <div class="text-end">

                            <div id="chart_{{ $name }}">
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> <!-- end col -->

<div class="modal fade bd-example-modal-lg" id="modal_{{ $name }}" tabindex="-1" role="dialog"
    aria-labelledby="modal_{{ $name }}" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $fullname }}</h5>

                    </div>
                    <div class="modal-body">

                        <div id="modal_chart_{{ $name }}" style="margin: 0; padding: 0; height: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="config" value="{{ config('grafico_cor_aleatoria') }}" hidden></div>

<script>
    var faltaram = <?php echo json_encode($plots[1]); ?>;
    var vendedores = <?php echo json_encode($plots[0]); ?>;
    var concretizados =
    <?php echo json_encode($plots[2]); ?>;


    var options = {

        series: [
            {
            name: 'Clientes que Vieram',
            data: concretizados
            },
            {
            name: 'Clientes que Faltaram',
            data: faltaram
            }
        ],
        chart: {
            type: 'bar',

        },
        plotOptions: {
            bar: {
            horizontal: false,
            columnWidth: '55%',
       
            },
        },
        dataLabels: {
           enabled: true,
        style: {
        fontSize: "12px",
        fontFamily: "Helvetica, Arial, sans-serif",
        colors: ['#fff'],
        
        },
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            labels: {
                rotate: -30
            },
            categories: vendedores,
        },
        yaxis: {
            title: {
            text: 'Número de Clientes'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
            formatter: function (val) {
                return val + " clientes"
            }
            }
        },
        colors: [ '#00E396', '#ef2936'],
        legend: {
            position: 'bottom'
        }
    };

    try {
        var chart_option = chart_option || [];
    } catch (error) {
        var chart_option = [];
    }

    chart_option["{{ $name }}"] = options;

    var chart1 = new ApexCharts(document.querySelector("#chart_{{ $name }}"), options);
    chart1.render();


    function showmodal($name) {

        var chart1 = new ApexCharts(document.querySelector("#modal_chart_" + $name), chart_option[$name]);
        chart1.render();
        $("#modal_" + $name).modal('show');
    }


    function fullscreen($this) {

        var nome = 'grafico_' + $this.toLowerCase();
        $("#" + nome).attr('class', "col-lg-12 col-xl-12 col-md-12");

    }
</script>