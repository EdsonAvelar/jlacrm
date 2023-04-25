<div class="col-lg-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">

                    @if (isset($card_href))
                        <a href="{{$card_href}}">{{$card_name}}</a> 
                    @else
                        {{$card_name}}
                    @endif
                    
                    </h5>
                    <h3 class="my-2 py-1">{{$card_value}}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> {{$card_porc}}</span>
                    </p>
                </div>
                <div class="col-6">
                    <div class="text-end">
                        <div id="booked-revenue-chart" data-colors="#0acf97"></div>
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end col -->