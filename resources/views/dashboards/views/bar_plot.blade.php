<div class="col-lg-6 col-xl-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">{{$name}}</h5>
                        <div class="col-12">
                            <div class="text-end">
                                
                                <div id="chart_{{$name}}">
                                </div>

                            </div>
                        </div>

                      
                    </div> <!-- end row-->

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

<script>


    var options = {
        chart: {
            type: 'bar'
        },
        series: [{
            name: '{{$name}}',
            data: <?php echo json_encode( $plots[1]) ?> ,
            
        }],
        xaxis: {
            categories: <?php echo json_encode($plots[0]) ?>
        },
        plotOptions: {
            bar: {
            distributed: true
            }
        }  
    }

    var chart1 = new ApexCharts(document.querySelector("#chart_{{$name}}"), options);
    chart1.render();

</script>

