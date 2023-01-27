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



</style>

@endsection
@section('main_content')


<!-- Start Content-->
<div class="container-fluid">
@include('layouts.alert-msg')

<div class="row">
       
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title m-t-0">Dropzone File Upload</h4>
                    <p class="text-muted font-14">
                        DropzoneJS is an open source library that provides dragrop file uploads with image
                        previews.
                    </p>

                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#file-upload-preview" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link active">
                                Preview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#file-upload-code" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Code
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">
                        <div class="tab-pane show active" id="file-upload-preview">

                            <form action="{{ url('negocios/importar')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="inputFile">File:</label>
                                    <input 
                                        type="file" 
                                        name="upload_file" 
                                        id="inputFile"
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


<form id="target" action="{{url('negocios/importar/atribuir')}}" method="POST">
@csrf
    
    <div class="row">

        <div class="col-12">
        <div class="page-title-right"></div>
            <div class="card">
                <div class="card-body left">
                    <h4 class="header-title m-t-0">Negócios Importados</h4>
                        <div class="mb-3">
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Atribuir</a>
                                </div>
                  
                                <label id="info_label"></label>
                    <table id="example" class="table table-striped"  class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>
                                <input type="checkbox" id="selectall" class="select-checkbox">
                                </th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Campanha</th>
                                <th>Fonte</th>
                                <th>Data Conversao</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($negocios_importados))
                            @foreach ($negocios_importados as $data)
                            <tr>
                                <td><input type="checkbox" name="negocios_importados[]" value="{{$data->id}}" class="select-checkbox"></td>
                                <td>{{$data['nome']}}</td>
                                <td>{{$data['telefone']}}</td>
                                <td>{{$data['email']}}</td>
                                <td>{{$data['campanha']}}</td>
                                <td>{{$data['fonte']}}</td>
                                <td>{{$data['data_conversao']}}</td>
                        
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
                <h5 class="modal-title" id="exampleModalLabel">Atribuir em Massa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h6 class="mt-2">Proprietário</h6>
                <div class="mb-1 nowrap w-100">
                    <select class="form-select form-control-light" id="task-priority" name="novo_proprietario_id">
                        <option selected="true">NOVO PROPRIETÁRIO</option>

                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">

                <input type="text" name="id" hidden value="{{app('request')->id}}">
                <input type="text" name="funil_id" hidden value="1">
                <input type="text" name="etapa_funil_id" hidden value="1">




                <input type="submit" class="btn btn-success mt-2" value="Enviar">
                <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">

                </div>
         

            </div>
        </div>
    </div>

</form>

</div>
<!-- container -->






@endsection

@section('specific_scripts')


<script src="{{url('')}}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{url('')}}/js/vendor/dataTables.bootstrap5.js"></script>
<script>

$(document).ready(function () {

    let example = $('#example').DataTable({
        
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

});

</script>


@endsection