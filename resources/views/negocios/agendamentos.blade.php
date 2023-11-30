@extends('main')

<?php
use App\Models\User;
?>

@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ url('') }}/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

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

        .badge>a {
            background-color: transparent;
            color: white;
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

            <div class="col-2">
                <label for="task-title" class="form-label">Produção</label>
                <input class="form-control btn btn-primary" type="text" name="daterange"
                    value="{{ app('request')->input('data_inicio') }} - {{ app('request')->input('data_fim') }}" />

            </div>

            <div class="col-sm-10">
                <div class="text-center mt-sm-0 mt-3 text-sm-end">

                    <div class="btn-group mt-sm-0 mt-3 text-sm-end">
                        <a type="button" class="btn btn-primary" onclick="PrintElement()" href="#"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-printer"></i><span></span></a>
                    </div>


                </div>
            </div> <!-- end col-->

        </div>

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body left">
                        <table id="example" class="table w-100 nowrap">
                            <thead>
                                <tr class="table-light">
                                    <th>Proprietario</th>
                                    <th>Cliente </th>
                                    <th>Telefone</th>
                                    <th>Data Agendado</th>
                                    <th>Hora Agendamento</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>

                                @if (isset($agendamentos))
                                    @foreach ($agendamentos as $agendamento)
                                        <tr>
                                            <td>{{ $agendamento->user->name }} </td>
                                            <td>
                                                <a href="{{ route('negocio_edit', ['id' => $agendamento->negocio->id]) }}">
                                                    {{ $agendamento->negocio->lead->nome }}</a>
                                            </td>
                                            <td>
                                                <a href="tel: {{ $agendamento->negocio->lead->telefone }}">
                                                    {{ $agendamento->negocio->lead->telefone }}
                                                </a>

                                            </td>
                                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $agendamento->data_agendado)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $agendamento->hora }}</td>

                                            @if ($agendamento->reuniao)
                                                <td><span class="badge bg-success">REUNIÃO REALIZADA</span></td>
                                            @else
                                                <?php
                                                
                                                $date = Carbon\Carbon::createFromFormat('Y-m-d', $agendamento->data_agendado);
                                                $now = \Carbon\Carbon::now('America/Sao_Paulo');
                                                $last_update = $date->diffInDays($now);
                                                
                                                if ($last_update == 0) {
                                                    echo "<td><span class=\"badge bg-warning\"> <a href='#' class='faltou' data-userid=" . $agendamento->negocio->user->id . ' data-name=' . $agendamento->negocio->lead->nome . ' data-id=' . $agendamento->negocio->id . '>REUNIÃO HOJE</a></span></td>';
                                                } else {
                                                    echo "<td><span class=\"badge bg-danger\"> <a href='#' class='faltou' data-userid=" . $agendamento->negocio->user->id . ' data-name=' . $agendamento->negocio->lead->nome . ' data-id=' . $agendamento->negocio->id . '>FALTOU</a></span></td>';
                                                }
                                                
                                                ?>
                                            @endif

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




            let example = $('#example').DataTable({
                scrollX: true,
                scrollY: true,
                pageLength: 100
            });




        });

        $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            },
            function(start, end, label) {
                //alert("A new date range was chosen: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                window.location.href = "{{ url('agendamento/lista?') }}" + "data_inicio=" + start.format(
                        'DD/MM/YYYY') +
                    "&" + "data_fim=" + end.format('DD/MM/YYYY');

            });

        function PrintElement() {

            print();
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

                    window.location.reload()
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


        // $("#confirmar_agendamento").on('click', function() {

        //     $("#spinner-div").show();
        //     $.ajax({
        //         url: "{{ url('negocios/add_reuniao') }}",
        //         type: 'post',
        //         data: {
        //             "negocio_id": info[0]
        //         },
        //         Type: 'json',
        //         success: function(res) {
        //             showAlert({
        //                 message: res,
        //                 class: "success"
        //             });
        //         },
        //         error: function(res) {
        //             showAlert({
        //                 message: "erro ao agendar reunião:" + res,
        //                 class: "danger"
        //             });
        //         },
        //         complete: function() {
        //             $("#spinner-div").hide(); //Request is complete so hide spinner

        //         }
        //     });
        // })
    </script>
@endsection
