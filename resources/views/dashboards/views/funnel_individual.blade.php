<div class="col-lg-6 col-xl-6 col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">{{$name}}</h5>
                <div class="col-12">
                    <div class="text-end">
                        
                        <div id='funnel_individual'><!-- Plotly chart will be drawn inside this DIV --></div>

                    </div>
                </div>

                
            </div> <!-- end row-->

        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end col -->

<script src='https://cdn.plot.ly/plotly-2.24.1.min.js'></script>

<script>

//https://plotly.com/javascript/funnel-charts/
var gd = document.getElementById('funnel_individual');
var data = [
    {
        type: 'funnel', 
        y: ["Oportunidades", "Agendamentos", "Reuniões", "Propostas", "Aprovações", "Vendas"], 
        x: <?php echo json_encode( $plots['funil']) ?>, 
        textposition: "inside", textinfo: "value+percent initial",
        hoverinfo: 'x+percent previous+percent initial+percent total',
        marker: {color: ["5c4152","5c4152", "b4585d", "d97f76", "f7d0a9", "a1c0ae"]}
    }

];

var layout = {margin: {l: 150}, funnelmode: "stack", showlegend: 'True'}

Plotly.newPlot('funnel_individual', data, layout);

</script>