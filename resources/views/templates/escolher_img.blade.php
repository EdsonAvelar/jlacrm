<div class="modal fade" id="change_logo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$titulo}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="p-2" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-12">
                                        <label for="task-title" class="form-label">Faça o Upload da Sua
                                            Imagem<span class="text-danger">
                                                *</label>
                                        <input type="file" name="image" id="inputImage"
                                            class="form-control @error('image') is-invalid @enderror">
                                        <input name="user_id" hidden value={{ app('request')->id }}>
                                        <br>
                                        <img id="myImg" class="rounded-circle avatar-lg img-thumbnail" src="#">
                                        <input name="pasta_imagem" id="pasta_imagem" hidden />
                                        <input name="imagem_name" id="imagem_name" hidden />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                            Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>