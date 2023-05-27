@extends('main')

@section('headers')

<meta name="csrf-token" content="{{ csrf_token() }}">


<link href="{{url('')}}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
    input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  padding: 10px;
}

#info_label {
    padding: 10px;
    color: #000080;
}

.mdi-18px { font-size: 18px; }
.mdi-24px { font-size: 24px; }
.mdi-36px { font-size: 36px; }
.mdi-48px { font-size: 48px; }

i.icon-success {
    color: green;
}

i.icon-danger {
    color: red;
}
</style>

@endsection
@section('main_content')


<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list d-none d-sm-inline-block">
                        </li>
                    </ul>
                </div>
             
                <h4 class="page-title">Vendas Realizadas</h4>
             
                     </div>
        </div>

        <div class="col-2">
            <label for="task-title" class="form-label">Produção</label>
            <input class="form-control btn btn-primary" type="text" name="daterange" value="{{app('request')->input('data_inicio')}} - {{app('request')->input('data_fim')}}" />
      
        </div>

    </div>
   
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body left">
                    <table id="example" class="table w-100 nowrap" >
                        <thead>
                            <tr>
                                <th>Cliente </th>
                                <th>Vendedor Principal </th>
                                <th>Vendedor Secundário</th>
                                <th>Data Fechamento</th>
                                <th>Primeira Assembleia</th>
                                <th>Valor</th>
                                <th>Parcelas Embutidas</th>
                                <th>Lead ID</th>
                                
                               
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $valor_vendido_total = 0;
                        ?>
                        @if(isset($vendas))
                            @foreach ($vendas as $venda)
                            <tr>
                                <td>{{$venda->lead->nome}}</td>
                                <td>{{$venda->vendedor_principal->name}}</td>
                                <td>
                                @if ($venda->vendedor_secundario)
                                    {{$venda->vendedor_secundario->name}}
                                @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse( $venda['data_fechamento'])->format('d/m/Y') }}</td>
                                <td>{{\Carbon\Carbon::parse( $venda['data_primeira_assembleia'])->format('d/m/Y') }}</td>
                                <td>R$ {{ number_format( (float)$venda['valor'],2)}}</td>
                                <td>{{$venda['parcelas_embutidas']}}</td>
                                <td>{{$venda['lead_id']}}</td>
                                
                            </tr>

                            <?php 
                            $valor_vendido_total = $valor_vendido_total + (float)$venda['valor'];

                            ?>

                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <h3 class="text-success">Total Vendidos: R$ {{number_format($valor_vendido_total,2)}}</h3>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card-->
    
        <!-- end col-->
    </div>
    <!-- end row -->

</div>

<div class="row">
    <div class="col-12">
       
    </div>
</div>
</div>

@endsection

@section('specific_scripts')


<script src="{{url('')}}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{url('')}}/js/vendor/dataTables.bootstrap5.js"></script>
<script>

$(document).ready(function () {

    let example = $('#example').DataTable({
        scrollX: true,
        scrollY: true,
        pageLength: 100
    });

    let selectall = false;

    $('#selectall').on("click", function() {
        if ($("input:checkbox").prop("checked")) {
            $("input:checkbox[class='select-checkbox']").prop("checked", true);
            selectall = true
        } else {
            $("input:checkbox[class='select-checkbox']").prop("checked", false);
            selectall = false
        }
    })

    $("input:checkbox[class='select-checkbox']").on( "click", function() {
        let numberNotChecked = $('input:checkbox:checked').length;
        if (selectall) {
            numberNotChecked = numberNotChecked -1;
            selectall = false;
        }
        if (numberNotChecked < 1){
            $("#info_label").text("");
        }else if(numberNotChecked < 2){
            $("#info_label").text(numberNotChecked + " Negócio Selecionado");
        }else {
            $("#info_label").text(numberNotChecked + " Negócios Selecionados");
        }
    });

    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#data_contratacao').mask('00/00/0000');

    $('#data_contratacao').datepicker({
        orientation: 'top',
        todayHighlight: true,
        format: "dd/mm/yyyy",
        defaultDate: +7
    });

});



$('input[name="daterange"]').daterangepicker(
    {
        locale: {
        format: 'DD-MM-YYYY'
        }
    }, 
    function(start, end, label) {
        //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
        window.location.href = "{{url('vendas/index?')}}"+"data_inicio="+start.format('DD/MM/YYYY')+"&"+"data_fim="+end.format('DD/MM/YYYY');

    });




</script>


@endsection