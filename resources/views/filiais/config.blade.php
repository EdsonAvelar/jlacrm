@extends('main')


@section('headers')

<!-- plugin js -->
<script src="assets/js/vendor/dropzone.min.js"></script>
<!-- init js -->
<script src="assets/js/ui/component.fileupload.js"></script>

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
                            <a class="nav-link dropdown-toggle arrow-none" href="#" role="button">
                                <i class="dripicons-view-apps noti-icon"></i>
                            </a>
                        </li>
                    </ul>
                </div>


                <h4 class="page-title">Filiais > Configurações
                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#add-new-task-modal"
                        class="btn btn-success btn-sm ms-3">Botao</a> --}}
                </h4>
            </div>
        </div>
        @include('layouts.alert-msg')

    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="page-title">Lista de Filiais</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filialModal"
                    onclick="openModal()">
                    + Cadastrar Filial
                </button>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="filiaisTable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>URL</th>
                                <th>Token</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filiais as $filial)
                            <tr id="filial-{{ $filial->id }}">
                                <td>{{ $filial->nome }}</td>
                                <td>{{ $filial->endereco }}</td>
                                <td>{{ $filial->telefone }}</td>
                                <td>{{ $filial->url }}</td>
                                <td>{{ $filial->token }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-filial" data-id="{{ $filial->id }}"
                                        data-nome="{{ $filial->nome }}" data-endereco="{{ $filial->endereco }}"
                                        data-telefone="{{ $filial->telefone }}" data-url="{{ $filial->url }}"
                                        data-token="{{ $filial->token }}" onclick="editFilial(this)">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-filial" data-id="{{ $filial->id }}">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Adição/Edição de Filial -->
    <div class="modal fade" id="filialModal" tabindex="-1" aria-labelledby="filialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filialModalLabel">Cadastrar Nova Filial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="filialForm">
                        <input type="hidden" id="filialId">
                        @csrf
                        <div class="mb-3">
                            <label for="nomeFilial" class="form-label">Nome da Filial</label>
                            <input type="text" class="form-control" id="nomeFilial" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="enderecoFilial" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="enderecoFilial" name="endereco">
                        </div>
                        <div class="mb-3">
                            <label for="telefoneFilial" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefoneFilial" name="telefone">
                        </div>
                        <div class="mb-3">
                            <label for="urlFilial" class="form-label">URL</label>
                            <input type="text" class="form-control" id="urlFilial" name="url" required>
                        </div>
                        <div class="mb-3">
                            <label for="tokenFilial" class="form-label">Token Customizado</label>
                            <input type="text" class="form-control" id="tokenFilial" name="token" required>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação para Deletar Filial -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir esta filial?
                    <input type="hidden" id="deleteFilialId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Excluir</button>
                </div>
            </div>
        </div>
    </div>

</div> <!-- container -->

@endsection

@section('specific_scripts')

<script>
    function openModal() {
        $('#filialForm')[0].reset();
        $('#filialId').val('');
        $('#filialModalLabel').text('Adicionar Nova Filial');
        $('#filialForm button[type="submit"]').prop('disabled', false);
    }

    function editFilial(button) {
        let id = $(button).data('id');
        $('#filialId').val(id);
        $('#nomeFilial').val($(button).data('nome'));
        $('#enderecoFilial').val($(button).data('endereco'));
        $('#telefoneFilial').val($(button).data('telefone'));
        $('#urlFilial').val($(button).data('url'));
        $('#tokenFilial').val($(button).data('token'));
        $('#filialModalLabel').text('Editar Filial');
        $('#filialModal').modal('show');
       
    }



    $(document).ready(function() {
        $('#filialForm').submit(function(e) {

            e.preventDefault();
            let formData = $(this).serialize();
            let id = $('#filialId').val();
            let url = id ? `/filiais/${id}` : "{{ route('filiais.store') }}";
            let type = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function(response) {
                   
                  
                        let filial = response;
                        let rowHtml = `
                            <tr id="filial-${filial.id}">
                                <td>${filial.nome}</td>
                                <td>${filial.endereco}</td>
                                <td>${filial.telefone}</td>
                                <td>${filial.url}</td>
                                <td>${filial.token}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-filial"
                                        data-id="${filial.id}"
                                        data-nome="${filial.nome}"
                                        data-endereco="${filial.endereco}"
                                        data-telefone="${filial.telefone}"
                                        data-url="${filial.url}"
                                        data-token="${filial.token}"
                                        onclick="editFilial(this)">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-filial" data-id="${filial.id}">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        `;

                        if (id) {
                            $('#filial-' + id).replaceWith(rowHtml);
                        } else {
                            $('#filiaisTable tbody').append(rowHtml);
                        }

                       

                        $('#filialModal').modal('hide');
                        

                        showAlert({
                        message: "Filial salva com sucesso!",
                        class: "success"
                        });
                    



                },
                error: function(xhr) {
                    showAlert({
                        message: "Erro:" + xhr.responseText,
                        class: "danger"
                    });

                    console.log('Error'+ xhr.responseText);
                    $('#filialModal').modal('hide');
                    
                }
            });
        });

        // Clique no botão de exclusão - Mostra o modal de confirmação
        $(document).on('click', '.delete-filial', function() {
            let id = $(this).data('id');
            $('#deleteFilialId').val(id);
            $('#confirmDeleteModal').modal('show');
        });

        // Confirmação da exclusão da filial
        $('#confirmDeleteBtn').click(function() {
            let id = $('#deleteFilialId').val();

            $.ajax({
                url: `/filiais/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                success: function(response) {
                    
                        $('#filial-' + id).remove();
                        $('#confirmDeleteModal').modal('hide');
                        showAlert({
                        message: "Filial id="+id+" Deletada com Sucesso",
                        class: "success"
                        });
                    
                },
                error: function(xhr) {
                  

                    showAlert({
                    message: "Erro:" + xhr.responseText,
                    class: "danger"
                    });
                }
            });
        });




    });
</script>


@endsection