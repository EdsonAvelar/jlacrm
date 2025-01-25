@extends('main')

@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
    /* Destaque para os totais */
    .total-highlight {
        font-weight: bold;
        font-size: 1.2em;
        background-color: #f8f9fa;
        /* Cinza claro */
        color: #212529;
        /* Texto escuro */
        text-align: center;
        border-radius: 0.25rem;
        /* Bordas arredondadas */
        padding: 0.5rem;
    }

    .total-highlight-success {
        background-color: #d4edda;
        /* Verde claro */
        color: #155724;
        /* Verde escuro */
    }

    .total-highlight-info {
        background-color: #cce5ff;
        /* Azul claro */
        color: #004085;
        /* Azul escuro */
    }

    .total-highlight-warning {
        background-color: #fff3cd;
        /* Amarelo claro */
        color: #856404;
        /* Amarelo escuro */
    }

    /* Estilo para o título */
    h4.p-1 {
        font-size: 1.8em;
        font-weight: bold;
        color: #34495e;
        /* Azul escuro */
        /* border-bottom: 2px solid #ccb22e; */
        /* Verde vibrante */
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
        /* Fonte moderna */
    }

    .vendedor-name {
        font-size: 1.5em;
        font-weight: bold;
        color: #0c8d26;
        /* Azul escuro */
        border-bottom: 2px solid #2ecc71;
        /* Verde vibrante */
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
        /* Fonte moderna */
    }

    .resumo {
        font-size: 1.5em;
        font-weight: bold;
        color: #0675a8;
        /* Azul escuro */
        border-bottom: 2px solid #2e58cc;
        /* Verde vibrante */
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Estilo para o subtítulo */
    p.subtitle {
        font-size: 1.1em;
        font-weight: 500;
        color: #7f8c8d;
        /* Cinza elegante */
        margin-bottom: 0.5rem;
        font-family: 'Roboto', sans-serif;
        /* Fonte complementar */
        background-color: #f9f9f9;
        /* Fundo leve */
        padding: 0.8rem;
        border-radius: 0.5rem;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Estilo para texto forte */
    p.subtitle .strong {
        font-weight: bold;
        color: #2c3e50;
        /* Azul mais escuro */
    }

    /* Estilo para o badge */
    p.subtitle .badge {
        font-size: 0.9em;
        padding: 0.4em 0.6em;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 0.25rem;
    }

    p.subtitle .badge.bg-danger {
        background-color: #e74c3c;
        /* Vermelho vibrante */
        color: #fff;
        /* Texto branco */
    }
</style>
@endsection

@section('main_content')
<div class="container">
    {{-- <ul class="nav nav-tabs" id="borderoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bordero-tab" data-bs-toggle="tab" data-bs-target="#bordero"
                type="button" role="tab" aria-controls="bordero" aria-selected="true">Borderô</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="add-rule-tab" data-bs-toggle="tab" data-bs-target="#add-rule" type="button"
                role="tab" aria-controls="add-rule" aria-selected="false">Regras de Comissionamento</button>
        </li>
    </ul> --}}
    <div class="tab-content" id="borderoTabContent">
        <!-- Aba de Borderô -->
        <div class="tab-pane fade show active" id="bordero" role="tabpanel" aria-labelledby="bordero-tab">
            <div class="mt-4">
                <h4 class="p-1">Gerenciamento de Borderô</h4>
                @if ( isset($info['producao']) && ($info['producao']))
                <p class="subtitle">Produção: <span class="strong">{{ $info['producao']['name'] }}</span> - Inicio:
                    <span class="strong">{{
                        $info['producao']['start_date'] }} </span>Fim: <span class="strong">{{
                        $info['producao']['end_date'] }}</span>

                    @if (!$info['producao']['dentro'])
                    <span class="badge bg-danger">*Dia de Hoje está fora do intervalo da Produção!</span>
                    @endif
                </p>


                @endif

                @if (isset($bordero))
                @foreach ($bordero as $vendedor => $bordero_vendedor)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="vendedor-name">{{ \App\Models\User::find($vendedor)->name }}</h5>
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Fechamento</th>
                                    <th>Contrato</th>
                                    <th>Cliente</th>
                                    <th>Participação</th>
                                    <th>Crédito</th>
                                    <th>Porcentagem</th>
                                    <th>Comissão</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $comissao_total = 0;
                                $credito_total = 0;
                                @endphp

                                @foreach ($bordero_vendedor as $venda)
                                <tr>
                                    <td>{{ $venda['data_fechamento'] }}</td>
                                    <td>{{ $venda['contrato'] }}</td>
                                    <td><a href="{{ route('negocio_fechamento', ['id' => $venda['cliente_id']]) }}">{{
                                            $venda['cliente'] }}

                                    </td>
                                    <td>{{ $venda['participacao'] }}</td>
                                    <td class="credito">R$ {{
                                        number_format(
                                        (float)$venda['credito'], 2, ',', '.') }}</td>
                                    {{-- <td>{{ $venda['percentagem'] }}</td> --}}
                                    <td class="editable " data-id="{{ $venda['id'] }}"
                                        data-participacao="{{ $venda['participacao'] }}" data-name="{{$vendedor}}"
                                        data-value="{{ $venda['percentagem'] }}">
                                        {{ $venda['percentagem'] }}%
                                    </td>

                                    <td class="value_{{ $vendedor }}_fechados">R$ {{ number_format($venda['comissao'],
                                        2, ',', '.') }}</td>


                                    @php

                                    $comissao_total += $venda['comissao'];
                                    $credito_total += (float)$venda['credito'];

                                    @endphp
                                </tr>


                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <b>Crédito</b>
                                    </td>
                                    <td class="total-highlight total-highlight-info">
                                        <b class="text-info">R$ {{ number_format($credito_total, 2, ',', '.') }}</b>
                                    </td>
                                    <td>
                                        <b>Comissão</b>
                                    </td>

                                    <td id="total_value_{{ $vendedor }}_fechados"
                                        class="comissoes_totais total-highlight total-highlight-success">R$ {{
                                        number_format($comissao_total, 2, ',', '.')
                                        }}</td>

                                </tr>

                            </tbody>
                        </table>
                        {{-- <h6 class="text-success">Total: R$ {{ number_format($vendas_fechadas, 2, ',', '.') }}</h6>
                        --}}
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="mb-3 resumo">Resumo Geral</h4>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>

                                <th>Número de Cotas</th>
                                <th>Valor Total de Créditos</th>
                                <th>Comissão Total Paga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="total-highlight total-highlight-warning">{{ $info['cotas'] }}</td>
                                <td id="total_creditos" class="total-highlight total-highlight-info">
                                    R$ {{ number_format($info['credito_vendidos'], 2, ',', '.') }}
                                </td>
                                <td id="comissao_total_paga" class="total-highlight total-highlight-success">
                                    R$ 0,00
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
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

    


    function formatString(input) {
        // Remove espaços do início e do final da string
        const trimmed = input.trim();
        
        // Substitui espaços por underlines
        const formatted = trimmed.replace(/ /g, '_');
        
        return formatted;
        }


      function formatCurrencyBRL(value) {
        return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
        }).format(value);
        }

        function currencyStringToFloat(currencyString) {
        // Remove o símbolo de moeda e espaços
        let numberString = currencyString.replace(/[^\d,.-]/g, '').replace(/\./g, '').replace(',', '.');
        
        // Converte a string para um número float
        return parseFloat(numberString);
        }

    
    // Função para atualizar o total de comissões
        function updateTotalComissao(className) {
            let total = 0;

            // Soma os valores de comissões de células com a classe específica
            $(`.${className}`).each(function () {
                const value = currencyStringToFloat($(this).text());
                console.log(value)
                if (!isNaN(value)) {
                    total += value;
                }
            });

            const totalFormatted = formatCurrencyBRL(total);

            // Atualiza a célula de Total em Comissão para o funcionário específico
            $(`#total_${className}`).text(`${totalFormatted}`);
        }

       function atualizarResumoGeral() {
           
          
            let totalComissao = 0;

            // Calcula o total de cotas, créditos e comissões
            $('table tbody tr').each(function () {
                // Soma apenas células com a classe "credito"
               

                // Soma apenas células com a classe "comissoes_totais"
                const comissaoCell = $(this).find('td.comissoes_totais');
                if (comissaoCell.length > 0) {
                    const comissao = currencyStringToFloat(comissaoCell.text());
                    if (!isNaN(comissao)) {
                        totalComissao += comissao;
                    }
                }
            });

            // Atualiza os valores na tabela de resumo geral
            $('#comissao_total_paga').text(formatCurrencyBRL(totalComissao));
        }

      

        $(document).ready(function () {

            atualizarResumoGeral();

            // Função para transformar o campo em input ao clicar
            $('.editable').on('click', function () {
                const $cell = $(this);
                const originalValue =$cell.text().replace('%', '').trim();
                const id = $cell.data('id'); // ID do registro
                const participacao = $cell.data('participacao'); // Tipo de participação
    
                // Evita múltiplos inputs no mesmo campo
                if ($cell.find('input').length > 0) return;
    
                // Cria o campo input
                const $input = $('<input>', {
                    type: 'number',
                    value: originalValue,
                    min: 0,
                    max: 100,
                    step: 0.01,
                    class: 'form-control',
                    blur: function () {
                        const newValue = parseFloat($input.val().replace(',', '.')).toFixed(2);


    
                        if (newValue !== originalValue) {
                            // Envia a alteração via AJAX
                            $.ajax({
                                url: '/bordero/update-porcentagem',
                                method: 'POST',
                                data: {
                                    id: id,
                                    percentagem: newValue,
                                    participacao: participacao,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {

                                    const name = $cell.data('name'); 
                                    // Atualiza o valor na célula de porcentagem
                                    $cell.data('value', newValue).text(`${newValue}%`);
    
                                    // Atualiza a célula de comissão

                                    
                                    // console.log("Credito Original: "+  )
                                    const credito = currencyStringToFloat( $cell.closest('tr').find('td:nth-child(5)').text() ) //parseFloat($cell.closest('tr').find('td:nth-child(5)').text().replace('R$', '').replace('.', '').replace(',', '.'));
                                    // console.log("credito: "+credito)
                                    
                                    const comissao = formatCurrencyBRL( (credito * newValue/100 ) );
                                    $cell.closest('tr').find('td:nth-child(7)').text(`${comissao}`);
    
                                    // Atualiza o total de comissões
                                    updateTotalComissao(`value_${name}_fechados`);

                                    // Atualiza o resumo geral
                                    atualizarResumoGeral();
    
                                    showAlert({
                                    message: "Porcentagem atualizada com sucesso!",
                                    class: "success"
                                    });
                                },
                                error: function (xhr) {
                                    // Reverte para o valor original em caso de erro
                                    $cell.text(`${originalValue}%`);
                                    let errorMessage = 'Erro ao atualizar a porcentagem. ';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage += `Detalhes: ${xhr.responseJSON.message}`;
                                    } else {
                                    errorMessage += 'Por favor, tente novamente.';
                                    }
                                    
                                    showAlert({
                                    message: errorMessage,
                                    class: "danger"
                                    });
                                }
                            });
                        } else {
                            // Reverte para o valor original se não houve alteração
                            $cell.text(`${originalValue}%`);
                        }
                    },
                    keyup: function (e) {
                        if (e.which === 13) { // Salva ao pressionar Enter
                            $(this).blur();
                        }
                    }
                });
    
                // Substitui o texto pelo input e foca nele
                $cell.empty().append($input);
                $input.focus();
            });
    
    
        });
   
</script>
@endsection