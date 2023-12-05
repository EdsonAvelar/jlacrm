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

<script>
    function generateColor(size_n) {

        var result = ['#4d3a96', '#4576b5', '#000000', '#FF4500', '#800000', '#FA8072', '#FF0000',
            '#008000', '#7FFF00', '#BDB76B', '#FFD700', '#00FFFF', '#2F4F4F', '#BC8F8F', '#FFDEAD', '#7B68EE',
            '#4B0082', '#8B008B', '#FFB6C1', '#DC143C',
            '#FAF0E6', '#FFDAB9', '#D8BFD8', '#B0E0E6', '#6A5ACD',
        ];



        if (document.getElementById('config').getAttribute('value') == 'true') {
            var result = [];
            for (let i = 0; i < size_n; i += 1) {

                result.push('#' + (Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0'))
            }
        }


        return result;
    }

    function formatter(num) {
        const digits = 2;
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


    var a = <?php echo json_encode($plots[1]); ?>;
    var labels = <?php echo json_encode($plots[0]); ?>;

    var options = {
        colors: generateColor(a.length),
        dataLabels: {
            enabled: true,
            style: {
                fontSize: "16px",
                fontFamily: "Helvetica, Arial, sans-serif",
                colors: ['#fff'],
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 3,
                    blur: 1,
                    color: '#000',
                    opacity: 0.1
                }
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                color: '#000',
                opacity: 0.7
            },
            formatter: function(val, opts) {

                val = parseFloat(val).toFixed(2);

                var texto = opts.w.globals.seriesNames[opts.seriesIndex] + " " +
                    " (" + formatter(opts.w.globals.series[opts.seriesIndex]) + '-' + val + "%)";

                var texto = opts.w.globals.seriesNames[opts.seriesIndex] + " " +
                    " (" + val + "%)";

                return texto;
            }
        },

        series: a,
        plotOptions: {
            pie: {
                expandOnClick: false
            }
        },
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
