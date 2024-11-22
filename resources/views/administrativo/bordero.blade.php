@extends('main')

@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
@endsection

@section('main_content')
<div class="container">
    <ul class="nav nav-tabs" id="borderoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bordero-tab" data-bs-toggle="tab" data-bs-target="#bordero"
                type="button" role="tab" aria-controls="bordero" aria-selected="true">Borderô</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="add-rule-tab" data-bs-toggle="tab" data-bs-target="#add-rule" type="button"
                role="tab" aria-controls="add-rule" aria-selected="false">Regras de Comissionamento</button>
        </li>
    </ul>
    <div class="tab-content" id="borderoTabContent">
        <!-- Aba de Borderô -->
        <div class="tab-pane fade show active" id="bordero" role="tabpanel" aria-labelledby="bordero-tab">
            <div class="mt-4">
                <h4 class="mb-3">Gerenciamento de Borderô</h4>
                @if (isset($bordero))
                @foreach ($bordero as $vendedor => $bordero_vendedor)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-success">{{ \App\Models\User::find($vendedor)->name }}</h5>
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Contrato</th>
                                    <th>Cliente</th>
                                    <th>Participação</th>
                                    <th>Crédito</th>
                                    <th>Porcentagem</th>
                                    <th>Comissão</th>
                                    <th>Data Fechamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $vendas_fechadas = 0; @endphp
                                @foreach ($bordero_vendedor as $venda)
                                <tr>
                                    <td>{{ $venda['contrato'] }}</td>
                                    <td>{{ $venda['cliente'] }}</td>
                                    <td>{{ $venda['participacao'] }}</td>
                                    <td>{{ $venda['credito'] }}</td>
                                    <td>{{ $venda['percentagem'] }}</td>
                                    <td>R$ {{ number_format($venda['comissao'], 2, ',', '.') }}</td>
                                    <td>{{ $venda['data_fechamento'] }}</td>
                                </tr>
                                @php $vendas_fechadas += $venda['comissao']; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <h6 class="text-success">Total: R$ {{ number_format($vendas_fechadas, 2, ',', '.') }}</h6>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <!-- Aba de Adição de Regras -->
        <div class="tab-pane fade" id="add-rule" role="tabpanel" aria-labelledby="add-rule-tab">
            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Adicionar Regra de Comissão</h4>
                    <form id="ruleForm" class="row g-3">
                        <div class="col-md-4">
                            <label for="sellerRole" class="form-label">Cargo do Primeiro Vendedor</label>
                            <select id="sellerRole" class="form-select">
                                <option value="">Qualquer Cargo</option>
                                <option value="vendedor">Vendedor</option>
                                <option value="telemarketing">Telemarketing</option>
                                <option value="coordenador">Coordenador</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="helperRole" class="form-label">Cargo do Segundo Vendedor</label>
                            <select id="helperRole" class="form-select">
                                <option value="">Nenhum (Venda Solitária)</option>
                                <option value="vendedor">Vendedor</option>
                                <option value="telemarketing">Telemarketing</option>
                                <option value="coordenador">Coordenador</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="thirdRole" class="form-label">Cargo do Terceiro Vendedor</label>
                            <select id="thirdRole" class="form-select">
                                <option value="">Nenhum (Venda Solitária ou Dupla)</option>
                                <option value="vendedor">Vendedor</option>
                                <option value="telemarketing">Telemarketing</option>
                                <option value="coordenador">Coordenador</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="commissionFirstSeller" class="form-label">Comissão para o Primeiro Vendedor
                                (%)</label>
                            <input type="number" class="form-control" id="commissionFirstSeller" step="0.001"
                                placeholder="0.6">
                        </div>
                        <div class="col-md-4" id="secondSellerCommissionContainer">
                            <label for="commissionSecondSeller" class="form-label">Comissão para o Segundo Vendedor
                                (%)</label>
                            <input type="number" class="form-control" id="commissionSecondSeller" step="0.001"
                                placeholder="0.3">
                        </div>
                        <div class="col-md-4" id="thirdSellerCommissionContainer">
                            <label for="commissionThirdSeller" class="form-label">Comissão para o Terceiro Vendedor
                                (%)</label>
                            <input type="number" class="form-control" id="commissionThirdSeller" step="0.001"
                                placeholder="0.2">
                        </div>

                        <div class="col-12">
                            <button type="button" id="addRule" class="btn btn-primary w-100 mt-3">Adicionar
                                Regra</button>
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover" id="rulesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Condições</th>
                                    <th>Comissão Primeiro Vendedor (%)</th>
                                    <th>Comissão Segundo Vendedor (%)</th>
                                    <th>Comissão Terceiro Vendedor (%)</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const initialRules = @json($rules);


    $(document).ready(function () {
        let rules = initialRules || [];

        renderRulesTable();

        $('#helperRole').on('change', function () {
            const helperRole = $(this).val();
            if (helperRole) {
                $('#secondSellerCommissionContainer').show();
            } else {
                $('#secondSellerCommissionContainer').hide();
                $('#commissionSecondSeller').val('');
            }
        }).trigger('change');

        $('#addRule').on('click', function () {
            const rule = {
                first_seller_role:  $('#sellerRole').val(),       // Corrigido para first_seller_role
                second_seller_role: $('#helperRole').val(),      // Corrigido para second_seller_role
                third_seller_role: $('#thirdRole').val(),

                condition_type: $('#helperRole').val() && $('#thirdRole').val()
                ? "Venda Tripla"
                : $('#helperRole').val()
                ? "Venda com Assistência"
                : "Venda Solitária",
                commission_first: $('#commissionFirstSeller').val(),
                commission_second: $('#commissionSecondSeller').val(),
                commission_third: $('#commissionThirdSeller').val(),
            };

            rules.push(rule);
            renderRulesTable();
            clearForm();
        });

        $('#thirdRole').on('change', function () {
            const thirdRole = $(this).val();
            if (thirdRole) {
                $('#thirdSellerCommissionContainer').show();
            } else {
                $('#thirdSellerCommissionContainer').hide();
                $('#commissionThirdSeller').val('');
            }
        }).trigger('change');

        // Função para renderizar a tabela de regras
        function renderRulesTable() {
            const tbody = $('#rulesTable tbody');
            tbody.empty();
            rules.forEach((rule, index) => {
                const conditions = `
                    Cargo Primeiro Vendedor: ${rule.first_seller_role || "Qualquer"}<br>
                    Cargo Segundo Vendedor: ${rule.second_seller_role || "Nenhum"}<br>
                    Cargo Terceiro Vendedor: ${rule.third_seller_role || "Nenhum"}<br>
                    Tipo de Venda: ${rule.condition_type}
                `;
                const row = `<tr>
                    <td>${conditions}</td>
                    <td>${rule.commission_first || 0}</td>
                    <td>${rule.commission_second || 0}</td>
                    <td>${rule.commission_third || 0}</td>
                    <td>
                        <button onclick="editRule(${index})" class="btn btn-sm btn-outline-secondary">Editar</button>
                        <button onclick="deleteRule(${index})" class="btn btn-sm btn-outline-danger">Excluir</button>
                    </td>
                </tr>`;
                tbody.append(row);
            });
        }


        // Função para limpar o formulário após adicionar uma regra
        function clearForm() {
            $('#ruleForm')[0].reset(); // Reseta os valores do formulário
            $('#secondSellerCommissionContainer').hide(); // Oculta o campo de comissão para o segundo vendedor
        }

        // Função para editar uma regra
        window.editRule = function (index) {
            const rule = rules[index];
            $('#sellerRole').val(rule.first_seller_role);
            $('#helperRole').val(rule.second_seller_role).trigger('change');
            $('#commissionFirstSeller').val(rule.commission_first);
            $('#commissionSecondSeller').val(rule.commission_second);
            rules.splice(index, 1);
            renderRulesTable();
        }

        // Função para excluir uma regra
        window.deleteRule = function (index) {
            if (confirm('Tem certeza que deseja excluir esta regra?')) {
                const ruleId = rules[index].id; // Pegue o ID da regra (se existir)

                // Caso a regra esteja salva no banco, envie uma requisição para excluir
                if (ruleId) {
                    $.ajax({
                        url: `/productions/rules/${ruleId}`, // Endpoint de exclusão
                        method: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function () {
                            rules.splice(index, 1); // Remove a regra localmente
                            renderRulesTable(); // Atualiza a tabela
                            alert('Regra excluída com sucesso!');
                        },
                        error: function () {
                            alert('Erro ao excluir a regra. Tente novamente.');
                        }
                    });
                } else {
                    // Caso não esteja no banco, remova apenas localmente
                    rules.splice(index, 1);
                    renderRulesTable();
                }
            }
        }

        // Enviar regras para o backend
        $('#addRule').on('click', function () {
            $.ajax({
                url: '{{ route("productions.saveRules") }}',
                method: 'POST',
                data: {
                    rules: rules,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert(response.message);
                    //rules = [];
                    renderRulesTable();
                },
                error: function () {
                    alert('Erro ao salvar as regras.');
                }
            });
        });
    });
</script>
@endsection