<div class="col-lg-6 col-xl-6 col-md-12" id="grafico_{{ strtolower($name) }}">
    <div class="card">
        <a href="#" onclick="fullscreen('{{ $name }}')">
            <div class="card-body">
                <div class="row align-items-center">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="{{ $name }}">{{ $name }}
                    </h5>
                    <div class="col-12">
                        <div class="text-end">

                            <div id="chart_{{ $name }}">
                            </div>

                        </div>
                    </div>
                </div> <!-- end row-->

            </div> <!-- end card-body -->
        </a>
    </div> <!-- end card -->
</div> <!-- end col -->

<script>
    var options = {
        chart: {
            toolbar: {
                show: false,
                offsetX: 0,
                offsetY: 0,
                tools: {
     
                },
    
            },
            type: 'bar'
        },
        series: [{
            name: '{{ $name }}',
            data: <?php echo json_encode($plots[1]); ?>,

        }],
        xaxis: {
            categories: <?php echo json_encode($plots[0]); ?>
        },
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 10,
                dataLabels: {
                    position: 'center', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(num) {
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
            },
            offsetY: 0,
            style: {
                fontSize: '24px',
                colors: ["#304758"]
            }
        },
    }

    var chart1 = new ApexCharts(document.querySelector("#chart_{{ $name }}"), options);
    chart1.render();


    function fullscreen($this) {

        var nome = 'grafico_' + $this.toLowerCase();

        $("#" + nome).attr('class', "col-lg-12 col-xl-12 col-md-12");

    }
</script>
