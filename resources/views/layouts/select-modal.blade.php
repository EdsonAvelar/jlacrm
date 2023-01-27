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

                <input type="submit" class="btn btn-success mt-2" value="Enviar">
                <input type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" value="Cancelar">

                </div>
            </div>
        </div>
    </div>