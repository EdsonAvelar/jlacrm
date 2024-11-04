@extends('main')

<?php 

use Carbon\Carbon;




?>
@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
    input[type=checkbox] {
        -ms-transform: scale(1.3);
        -moz-transform: scale(1.3);
        -webkit-transform: scale(1.3);
        -o-transform: scale(1.3);
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

    .badge {
        padding: 0.5em 0.4em !important;
    }

    #btn_deletar {
        margin: 10px 0px 10px 0px;
        width: 150px;
    }

    .is_active {
        background: aquamarine;
    }
</style>
@endsection

@section('main_content')

@csrf
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
                <h4 class="page-title">Gerenciamento de Produções</h4>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Botão para abrir o modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductionModal">
                Adicionar Produção
            </button>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            @if (isset($productions) && !$productions->isEmpty() )
            <div class="card">
                <div class="card-body left">
                    <h2 class="text-success title">Produções</h2>
                    <table id="example3" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data de Início</th>
                                <th>Data de Término</th>
                                <th>Ativa</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productions as $production)

                            @endforeach

   


                            @foreach ($productions as $production)
                            <tr>
                                <td>{{ $production->name }}</td>
                                <td>{{ $production->start_date}}
                                </td>
                                <td>{{ $production->end_date }}</td>
                                <td>{{ $production->is_active ? 'Sim' : 'Não' }}</td>
                                <td>
                                    <!-- Botão "Editar" sem o `data-bs-toggle` e `data-bs-target` -->
                                    <button type="button" class="btn btn-sm btn-primary edit-btn"
                                        data-id="{{ $production->id }}" data-name="{{ $production->name }}"
                                        data-start_date="{{ $production->start_date }}"
                                        data-end_date="{{ $production->end_date }}"
                                        data-is_active="{{ $production->is_active }}">Editar</button>

                                    <form action="{{ route('productions.destroy', $production->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                    {{-- {{ $productions->links() }} --}}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para adicionar/editar produção -->
<div class="modal fade" id="addProductionModal" tabindex="-1" aria-labelledby="addProductionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductionModalLabel">Adicionar Nova Produção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productionForm" method="POST">
                @csrf
                <input type="hidden" id="production_id" name="production_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome da Produção</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Data de Início</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Data de Término</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Ativa</label>
                        <input type="checkbox" id="is_active" name="is_active" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('specific_scripts')
<script src="{{ url('') }}/js/vendor/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {
       let table = $('#example3').DataTable({
        pageLength: 100,
        order: [[3, 'asc']],
        scrollX: true
        
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Seleciona o modal
        const modalElement = new bootstrap.Modal(document.getElementById('addProductionModal'), {
            keyboard: false
        });
        const modalTitle = document.getElementById('addProductionModalLabel');
        const productionForm = document.getElementById('productionForm');
        
        // Reseta o modal ao abrir para adicionar nova produção
        document.querySelector('button[data-bs-target="#addProductionModal"]').addEventListener('click', function() {
            modalTitle.textContent = 'Adicionar Nova Produção';
            productionForm.action = "{{ route('productions.store') }}";
            productionForm.reset();
            document.getElementById('production_id').value = '';
            document.getElementById('is_active').checked = false;
        });

        // Preenche o modal ao clicar em "Editar"
        document.querySelectorAll('.edit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Preencher as informações no modal
                const productionId = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const startDate = this.getAttribute('data-start_date');
                const endDate = this.getAttribute('data-end_date');
                const isActive = this.getAttribute('data-is_active') == '1';

                // Preenche os campos do formulário
                modalTitle.textContent = 'Editar Produção';
                document.getElementById('production_id').value = productionId;
                document.getElementById('name').value = name;
                document.getElementById('start_date').value = startDate;
                document.getElementById('end_date').value = endDate;
                document.getElementById('is_active').checked = isActive;

                // Altera a ação do formulário para a edição (PUT)
                productionForm.action = "{{ route('productions.store') }}";
                productionForm.method = 'POST';
                if (!document.querySelector('input[name="_method"]')) {
                    productionForm.innerHTML += '@method("PUT")';
                }

                // Agora abre o modal
                modalElement.show();
            });
        });
    });
</script>

@endsection