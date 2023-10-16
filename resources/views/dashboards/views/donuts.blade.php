<style>
    .modal-content {
        width: auto;
    }

    .apexcharts-legend-series {
        align-self: flex-start;
    }
</style>

<?php
$name = strtolower($name);
?>

<div class="col-lg-6 col-xl-6 col-md-12" id="grafico_{{ $name }}">
    <div class="card">
        <div class="card-body">

            <div class="row align-items-center">
                <a href="#" onclick="showmodal('{{ $name }}')" id="click_{{ $name }}">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="{{ $name }}">{{ $name }}
                    </h5>

                    <div class="col-12">
                        <div class="text-end">

                            <div id="chart_{{ $name }}">
                            </div>

                        </div>
                    </div>
                </a>
            </div> <!-- end row-->

        </div> <!-- end card-body -->

    </div> <!-- end card -->
</div> <!-- end col -->

<div class="modal fade bd-example-modal-lg" id="modal_{{ $name }}" tabindex="-1" role="dialog"
    aria-labelledby="modal_{{ $name }}" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $name }}</h5>

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

<script>
    function formatter(num) {
        const digits = 0;
        const lookup = [{
                value: 1,
                symbol: ""
            },
            {
                value: 1e3,
                symbol: "K"
            },
            {
                value: 1e6,
                symbol: "M"
            },
            {
                value: 1e9,
                symbol: "G"
            },
            {
                value: 1e12,
                symbol: "T"
            },
            {
                value: 1e15,
                symbol: "P"
            },
            {
                value: 1e18,
                symbol: "E"
            }
        ];



        const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
        var item = lookup.slice().reverse().find(function(item) {
            return num >= item.value;
        });
        return item ? (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";


        return nFormatter(val, 0);
    }


    var options = {


        chart: {

            type: 'donut',
        },
        series: [{
            name: '{{ $name }}',
            data: <?php echo json_encode($plots[1]); ?>,

        }],


    }

    var a = <?php echo json_encode($plots[1]); ?>;
    var labels = <?php echo json_encode($plots[0]); ?>;

    var options = {
        series: a,
        chart: {
            type: 'donut',
        },
        labels: labels,
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom'
                }
            }
        }],
        tooltip: {
            enabled: true,

            y: {
                formatter: function(value, series) {
                    return formatter(value);
                }
            }
        },

        legend: {
            horizontalAlign: 'right',
            formatter: function(val, opts) {
                return val + " - " + formatter(opts.w.globals.series[opts.seriesIndex]);
            }
        },

    };

    try {
        var chart_option = chart_option || [];
    } catch (error) {
        var chart_option = [];
    }

    chart_option["{{ $name }}"] = options;
    console.log(chart_option)

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
