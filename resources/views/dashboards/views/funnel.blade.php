<div class="col-lg-6 col-xl-6 col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">{{$name}}</h5>
                <div class="col-12">
                    <div class="text-end">
                        
                        <div id='myDiv'><!-- Plotly chart will be drawn inside this DIV --></div>

                    </div>
                </div>

                
            </div> <!-- end row-->

        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end col -->

<script src='https://cdn.plot.ly/plotly-2.24.1.min.js'></script>

<script>

//https://plotly.com/javascript/funnel-charts/
var gd = document.getElementById('myDiv');
var data = [{
    type: 'funnel', 
    y: ["Oportunidades", "Agendamentos", "Reuniões", "Propostas", "Aprovações", "Vendas"], 
    x: <?php echo json_encode( $plots['funil']) ?>, 
    textposition: "inside", textinfo: "value+percent initial",
    hoverinfo: 'x+percent previous+percent initial+percent total',
    marker: {color: ["241023", "6B0504", "A3320B", "D5E68D", "47A025"]}
}];

var layout = {margin: {l: 150}, funnelmode: "stack", showlegend: 'True'}

Plotly.newPlot('myDiv', data, layout);

</script>