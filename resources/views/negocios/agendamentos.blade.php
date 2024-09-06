@extends('main')

<?php
use App\Models\User;
use App\Enums\UserStatus;

$users = User::where('status', UserStatus::ativo)->get();

?>

@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">


<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="{{ url('') }}/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3);
        /* IE */
        -moz-transform: scale(1.3);
        /* FF */
        -webkit-transform: scale(1.3);
        /* Safari and Chrome */
        -o-transform: scale(1.3);
        /* Opera */
        padding: 10px;
    }

    #info_label {
        padding: 10px;
        color: #000080;
    }

    .mdi-18px {
        font-size: 18px;
    }

    .mdi-24px {
        font-size: 24px;
    }

    .mdi-36px {
        font-size: 36px;
    }

    .mdi-48px {
        font-size: 48px;
    }

    i.icon-success {
        color: green;
    }

    i.icon-danger {
        color: red;
    }

    .ui-timepicker-wrapper .ui-timepicker-list li {
        width: 100px;
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
                <h4 class="page-title">Agendamentos</h4>
            </div>
        </div>

        <div class="col-sm-2">
            <input class="form-control btn btn-primary" type="text" name="daterange"
                value="{{ app('request')->input('data_inicio') }} - {{ app('request')->input('data_fim') }}" />

        </div>

        <div class="col-sm-6">
            <input class="toggle-event" type="checkbox" <?php if (app('request')->query('agendado') == 'para') {
            echo 'checked';
            }
            ?> data-config_info="card_colorido"
            data-toggle="toggle" data-on="Para" data-off="Em" data-onstyle="success" data-offstyle="danger">

            <a href="{{ route('agendamento.lista', [
                    'data_inicio' => \Carbon\Carbon::now()->format('d/m/Y'),
                    'data_fim' => \Carbon\Carbon::now()->format('d/m/Y'),
                    'agendado' => app('request')->query('agendado'),
                ]) }}" type="button" class="btn btn-success">HOJE</a>

            <a href="{{ route('agendamento.lista', ['data_inicio' => \Carbon\Carbon::now()->addDays(1)->format('d/m/Y'),'data_fim' => \Carbon\Carbon::now()->addDays(1)->format('d/m/Y'),'agendado' => app('request')->query('agendado')]) }}"
                type="button" class="btn btn-info">AMANHÃ</a>



        </div>

        <div class="col-sm-12">
            <div class="text-center mt-sm-1 mt-3 text-sm-end">
                <a type="button" class="btn btn-primary" onclick="PrintElement()" href="#" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="mdi mdi-printer"></i><span></span></a>
            </div>
        </div> <!-- end col-->

    </div>

    <form id="target" action="{{ url('negocios/changemassive') }}" method="POST">
        @csrf
        <div class="row" id="printarea">


            <div class="col-12">

                <div class="card">
                    <div class="mb-3">
                        <a class="btn btn-primary checkbox_sensitive" data-bs-toggle="modal" id="atribuir_btn"
                            data-bs-target="#exampleModal">Atribuir</a>

                        <a type="button" class="btn btn-secondary btn-sm ms-3 checkbox_sensitive" id="distribuir_btn"
                            data-bs-toggle="modal" data-bs-target="#distribuirModal">
                            Distribuir</a>

                    </div>

                    <div class="card-body left">



                        <label id="info_label"></label>

                        <table id="example" class="table table-striped" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hideshow">
                                        <input type="checkbox" id="selectall">
                                    </th>
                                    <th>Proprietario</th>
                                    <th>Cliente </th>
                                    <th>Telefone</th>
                                    <th>Tipo</th>
                                    <th>Agendado Para:</th>
                                    <th>Hora Agendamento</th>
                                    <th>Agendadado Em:</th>
                                    <th>Status</th>
                                    <th class="hideshow">Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (isset($agendamentos))
                                @foreach ($agendamentos as $agendamento)
                                <tr>
                                    <td class="hideshow"><input type="checkbox" name="negocios[]"
                                            value="{{ $agendamento->negocio->id }}" class="select-checkbox"></td>
                                    <td>

                                        @if ($agendamento->negocio->user)
                                        {{ $agendamento->negocio->user->name }}
                                        @else
                                        <span class="badge bg-secondary">SEM DONO</span>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{ route('negocio_edit', ['id' => $agendamento->negocio->id]) }}">
                                            {{ $agendamento->negocio->lead->nome }}</a>
                                    </td>
                                    <td>
                                        <a href="tel: {{ $agendamento->negocio->lead->telefone }}">
                                            {{ $agendamento->negocio->lead->telefone }}
                                        </a>

                                    </td>
                                    <td>

                                        {{ $agendamento->negocio->tipo }}


                                    </td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d',
                                        $agendamento->data_agendado)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $agendamento->hora }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d',
                                        $agendamento->data_agendamento)->format('d/m/Y') }}
                                    </td>

                                    @if ($agendamento->reuniao)
                                    <td><span class="badge bg-success">REUNIÃO REALIZADA</span></td>
                                    @else
                                    <?php
                                                
                                        $date = Carbon\Carbon::createFromFormat('Y-m-d', $agendamento->data_agendado);
                                        $now = \Carbon\Carbon::now('America/Sao_Paulo');
                                        $last_update = $date->diffInDays($now, false);
                                        
                                        if ($date->isToday()) {
                                            echo "<td><span class=\"badge bg-warning\">REUNIÃO HOJE" . '</a></span></td>';
                                        } elseif ($date->isTomorrow()) {
                                            echo "<td><span class=\"badge bg-primary\"> AMANHÃ </span></td>";
                                        } elseif ($last_update > 0) {
                                            echo "<td><span class=\"badge bg-danger\"> FALTOU </span></td>";
                                        } else {
                                            echo "<td><span class=\"badge bg-info\"> AGENDADO (" . abs($last_update - 1) . ' DIAS)</span></td>';
                                        }
                                        ?>
                                    @endif

                                    <td class="hideshow">
                                        <a href='#' class='btn btn-warning faltou'
                                            data-userid="{{ $agendamento->user->id }}"
                                            data-name='{{ $agendamento->negocio->lead->nome }}'
                                            data-id='{{ $agendamento->negocio->id }}'>REAGENDAR</a>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->

                <!-- end col-->
            </div>
            <!-- end row -->

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Atribuir <span id="atribui_n"></span> negócio(s)
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <h6 class="mt-2">Proprietário</h6>
                        <div class="mb-1 nowrap w-100">
                            <select class="form-select form-control-light" id="task-priority"
                                name="novo_proprietario_id">
                                <option selected="true">NOVO PROPRIETÁRIO</option>

                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="text" name="id" hidden value="1">
                        <input type="text" name="funil_id" hidden value="1">
                        <input type="text" name="etapa_funil_id" hidden value="1">
                        <input type="submit" class="btn btn-success mt-2" value="Enviar">
                        <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="distribuirModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Distribuir Negócios</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-4">

                                <h3 id="selected_qnt" class="child"></h3>

                            </div>
                            <div class="col-4">
                                <img src="{{ url('') }}/images/sistema/distribuicao.png" width="200px">
                            </div>
                            <div class="col-4 scroll">


                                @foreach ($users as $user)

                                <input type="checkbox" name="usuarios[]" value="{{ $user->id }}" class="select-user" />
                                {{
                                $user->name
                                }}<br>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="distribuir-div">
                        <input type="text" name="id" hidden value="1">
                        <input type="submit" class="btn btn-success mt-2" value="Enviar">
                        <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                            value="Cancelar">
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="desativarModal" tabindex="-1" aria-labelledby="desativarModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Desativar Negócios</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12">
                                <h3>Deseja mesmo <span class="bg-danger text-white">Desativar</span> <span
                                        id="desativar_n"></span> Negócios
                                    Selecionados?</h3>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="distribuir-div">
                        <input type="text" name="id" hidden value="1">
                        <input type="submit" class="btn btn-success mt-2" value="SIM">
                        <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                            value="Cancelar">
                    </div>
                </div>
            </div>
        </div>

        <input type="text" name="id" hidden value="1">
        <input type="text" name="modo" id="modo" hidden value="">
        <input type="text" name="funil_id" id="funil_id" hidden value="1">
        <input type="text" name="curr_funil_id" id="curr_funil_id" hidden value="1">
    </form>


    @include('templates.add_agendamento', [])

    @include('templates.add_protocolo', [])

</div>

@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script src="{{ url('') }}/js/jquery.timepicker.min.js"></script>


<script>
    $(document).ready(function() {

            $("#atribuir_btn").on("click", function() {
                document.getElementById('modo').value = 'atribuir';
            });

            $("#distribuir_btn").on("click", function() {
                document.getElementById('modo').value = 'distribuir';
            });

            $("#desativar_btn").on("click", function() {
                document.getElementById('modo').value = 'desativar';
            });

            $('.checkbox_sensitive').hide();


            let example = $('#example').DataTable({
                pageLength: 100,
                scrollX: true
            });

            let selectall = false;

            function handleTableClick() {

                numberNotChecked = $("input:checkbox[class='select-checkbox']:checked").length;
                console.log("Checked:" + numberNotChecked);
                if (selectall) {
                    selectall = false;
                }
                if (numberNotChecked < 1) {
                    $("#info_label").text("");
                    $('.checkbox_sensitive').hide();

                } else if (numberNotChecked < 2) {

                    $("#info_label").text(numberNotChecked + " Negócio Selecionado");
                    $('#selected_qnt').html(numberNotChecked + " <br>Negócio Selecionado");
                    $('.checkbox_sensitive').show();
                } else {
                    $("#info_label").text(numberNotChecked + " Negócios Selecionados");
                    $('#selected_qnt').html(numberNotChecked + " <br>Negócio Selecionados")
                    $('.checkbox_sensitive').show();
                }

                if (numberNotChecked == 0) {
                    $('.checkbox_sensitive').hide();
                }

                $("#atribui_n").html(numberNotChecked);
                $("#desativar_n").html(numberNotChecked);
            }


            $('#selectall').on("click", function() {

                if ($('#selectall').prop('checked')) {
                    $("input:checkbox[class='select-checkbox']").prop("checked", true);
                    selectall = true
                } else {
                    $("input:checkbox[class='select-checkbox']").prop("checked", false);
                    selectall = false
                }

                console.log( "select all clicked: "+selectall)

                handleTableClick();
            })

            $("input:checkbox[class='select-checkbox']").on("click", function() {

                console.log("teste")

                let numberNotChecked = $('input:checkbox:checked').length;
                if (selectall) {
                    numberNotChecked = numberNotChecked - 1;
                    selectall = false;
                }
                if (numberNotChecked < 1) {
                    $("#info_label").text("");
                } else if (numberNotChecked < 2) {
                    $("#info_label").text(numberNotChecked + " Negócio Selecionado");
                } else {
                    $("#info_label").text(numberNotChecked + " Negócios Selecionados");
                }

                handleTableClick();
            });

        });
</script>


<script>
    $(document).ready(function() {

            function copyProtocolo() {

                var text = document.getElementById('txt_protocolo').innerText;
                var elem = document.createElement("textarea");
                document.body.appendChild(elem);
                elem.value = text;
                elem.select();
                document.execCommand("copy");
                document.body.removeChild(elem);

                showAlert({
                    message: "protocolo copiado",
                    class: "success"
                });
                $('#agendamento-protocolo').modal('hide');
                
            }


            $('.timedatapicker').timepicker({
                'timeFormat': 'H:i'
            });
            $('.timedatapicker').timepicker('setTime', new Date());

            $('.agendamento').datepicker({
                orientation: 'top',
                todayHighlight: true,
                format: "dd/mm/yyyy",
                timeFormat: "HH:mm:ss",
                defaultDate: +1
            });




    

        });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            },
            function(start, end, label) {

                var param = getUrlParameter('agendado');

                //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                window.location.href = "{{ url('agendamento/lista?') }}" + "data_inicio=" + start.format(
                        'DD/MM/YYYY') +
                    "&" + "data_fim=" + end.format('DD/MM/YYYY') + "&agendado=" + param;

            });

        $('.toggle-event').change(function($this) {



            var start = getUrlParameter('data_inicio');
            var end = getUrlParameter('data_fim');

            var config_value = $(this).prop('checked');

            var param = 'em'
            if (config_value == true) {
                param = "para"
            }

            console.log(start, end, config_value, param)

            window.location.href = "{{ url('agendamento/lista?') }}" + "data_inicio=" + start +
                "&" + "data_fim=" + end + "&agendado=" + param;


        });

        function PrintElement() {

            //print();
            
            $('.hideshow').hide()

            var header_str = '<html><head><title>' + document.title  + '</title></head><body><h1 style="text-align: center;padding-top:10px">TABELA DE AGENDAMENTO</h1>';

            var footer_str = '</body></html>';
            var new_str = document.getElementById("printarea").innerHTML;
            var old_str = document.body.innerHTML;
            document.body.innerHTML = header_str + new_str + footer_str;

            window.print();
            document.body.innerHTML = old_str;

            $('.hideshow').show();

            return false;

        }

        var info = [];

        $(".faltou").on('click', function() {


            var id = $(this).data('id');
            var proprietario_id = $(this).data('userid');

            var name = $(this).data('name');

            $("#venda_titulo").html('Reagendamento de ' + name);

            $('#agendamento-add').modal('show');

            $('#negocio_id_agen').val(id);
            $('#proprietario_id').val(proprietario_id);

            console.log(id + " " + name);

            info[0] = id;
        })


        $('#agendamento_para').submit(function(e) {

            $("#spinner-div").show();
            $('#agendamento-add').modal('hide');

            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#confirmar_agendamento').prop("disabled", false);

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {

                    if (document.getElementById('check_protocolo').checked) {
                        ptcl_dia.textContent = data[0];
                        ptcl_hora.textContent = data[1];

                        $('#agendamento-protocolo').modal('show');
                    }
                },
                error: function(res) {
                    showAlert({
                        message: " Erro no agendamento",
                        class: "danger"
                    });
                    $("#spinner-div").hide();
                },
            });
        });
</script>


@endsection