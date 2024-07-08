@extends('main')

@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
</style>
@endsection
@section('main_content')


<!-- Start Content-->
<div class="container-fluid">


    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title m-t-0">Importação de Leads via Arquivo CSV ( separador= ';' )</h4>
                    <p class="text-muted font-14">
                        <strong>Passo 1: </strong>Coloque os leads no formado da planilha do link: <a
                            href="https://docs.google.com/spreadsheets/d/1xOgu3MoZhYFgwy3Zd0n_DPe1Hbc731ceNL5dY6DBzf0/edit?usp=sharing"
                            target="_blank">Template Planilha</a>.
                        <br><strong>Passo 2: </strong>Depois insira no campo de arquivo e faça o upload.
                        <br><strong>Passo 3: </strong>Distribui os leads que aparecerão na <a href="#importados">Tabela
                            de Negócios Importados</a>
                    </p>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="file-upload-preview">

                            <form action="{{ url('negocios/importar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="inputFile">File:</label>
                                    <input type="file" name="upload_file" id="inputFile"
                                        class="form-control @error('file') is-invalid @enderror">

                                    @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>

                            </form>

                            <!-- Preview -->
                            <div class="dropzone-previews mt-3" id="file-previews"></div>
                        </div> <!-- end preview-->

                        <div class="tab-pane" id="file-upload-code">
                            <p>Make sure to include following js files at end of <code>body element</code></p>
                        </div> <!-- end preview code-->
                    </div> <!-- end tab-content-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
    <!-- end row -->


    <form id="target" action="{{ url('negocios/importar/massivo') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-12">
                <div class="page-title-right"></div>
                <div class="card">
                    <div class="card-body left">
                        <h4 class="header-title m-t-0" id="importados">Negócios Importados</h4>
                        <div class="mb-3">
                            <a class="btn btn-primary checkbox_sensitive" data-bs-toggle="modal" id="atribuir_btn"
                                data-bs-target="#exampleModal">Atribuir</a>

                            <a type="button" class="btn btn-secondary btn-sm ms-3 checkbox_sensitive"
                                id="distribuir_btn" data-bs-toggle="modal" data-bs-target="#distribuirModal">
                                Distribuir</a>


                            <a type="button" class="btn btn-danger btn-sm ms-3 checkbox_sensitive" id="desativar_btn"
                                data-bs-toggle="modal" data-bs-target="#desativarModal">
                                Deletar</a>


                        </div>

                        <label id="info_label"></label>
                        <table id="example" class="table table-striped" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectall" class="select-checkbox">
                                    </th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Tipo do Bem</th>
                                    <th>Origem do Lead</th>
                                    <th>Data Conversao</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($negocios_importados))
                                @foreach ($negocios_importados as $data)
                                <tr>
                                    <td><input type="checkbox" name="negocios_importados[]" value="{{ $data->id }}"
                                            class="select-checkbox"></td>
                                    <td>{{ $data['nome'] }}</td>
                                    <td>{{ $data['telefone'] }}</td>
                                    <td>{{ $data['email'] }}</td>
                                    <td>{{ $data['campanha'] }}</td>
                                    <td>{{ $data['fonte'] }}</td>
                                    <td>{{ $data['data_conversao'] }}</td>

                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->


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

                                @foreach ($users as $user_id => $name)
                                <option value="{{ $user_id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <input type="text" name="id" hidden value="{{ app('request')->id }}">
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
                                <img src="{{ url('') }}/images/distribuicao.png" width="200px">
                            </div>
                            <div class="col-4 scroll">


                                @foreach ($users as $user_id => $name)
                                <input type="checkbox" name="usuarios[]" value="{{ $user_id }}" class="select-user" />
                                {{ $name }}<br>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="distribuir-div">
                        <input type="text" name="id" hidden value="{{ app('request')->id }}">
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
                        <input type="text" name="id" hidden value="{{ app('request')->id }}">
                        <input type="submit" class="btn btn-success mt-2" value="SIM">
                        <input type="button" class="btn btn-danger mt-2 distribuir" data-bs-dismiss="modal"
                            value="Cancelar">
                    </div>
                </div>
            </div>
        </div>

        <input type="text" name="modo" id="modo" hidden value="">
        <input type="text" name="funil_id" id="funil_id" hidden value="1">
        <input type="text" name="curr_funil_id" id="curr_funil_id" hidden value="1">
    </form>

</div>
<!-- container -->

@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
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
                pageLength: 100
            });

            let selectall = false;

            function handleTableClick() {
                const urlParams = new URLSearchParams(window.location.search);

                numberNotChecked = $('input:checkbox:checked').length;
                console.log("Checked:" + $('input:checkbox:checked').length);
                if (selectall) {
                    numberNotChecked = numberNotChecked - 1;
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
                if ($("input:checkbox").prop("checked")) {
                    $("input:checkbox[class='select-checkbox']").prop("checked", true);
                    selectall = true
                } else {
                    $("input:checkbox[class='select-checkbox']").prop("checked", false);
                    selectall = false
                }

                handleTableClick();
            })

            $("input:checkbox[class='select-checkbox']").on("click", function() {
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
@endsection