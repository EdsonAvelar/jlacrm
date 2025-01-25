<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Production;
use Carbon\Carbon;
use App\Models\Empresa;
use App\Models\User;
use App\Models\CommissionRule;
use App\Models\Fechamento;

class ProductionController extends Controller
{
    public function index(Request $request)
    {
        // Obtém as produções com paginação
        $productions = Production::orderBy('end_date', 'desc')  // Adiciona a ordenação por end_date de forma decrescente
            ->get();


        // Renderiza a view configuracoes.blade.php
        return view('administrativo.productions', [
            'productions' => $productions,
        ]);
    }

    public function saveRules(Request $request)
    {
        $rules = $request->input('rules');

        // $request->validate([
        //     'rules.*.first_seller_role' => 'nullable|string',
        //     'rules.*.second_seller_role' => 'nullable|string',
        //     'rules.*.third_seller_role' => 'nullable|string',
        //     'rules.*.commission_first' => 'required|numeric|min:0|max:1',
        //     'rules.*.commission_second' => 'nullable|numeric|min:0|max:1',
        //     'rules.*.commission_third' => 'nullable|numeric|min:0|max:1',
        // ]);

        foreach ($rules as $ruleData) {
            CommissionRule::updateOrCreate(
                [
                    'id' => $ruleData['id'] ?? null, // Atualiza se o ID existir
                ],
                [
                    'first_seller_role' => $ruleData['first_seller_role'],
                    'second_seller_role' => $ruleData['second_seller_role'],
                    'third_seller_role' => $ruleData['third_seller_role'],
                    'condition_type' => $ruleData['condition_type'],
                    'commission_first' => ($ruleData['commission_first']) / 100,
                    'commission_second' => ($ruleData['commission_second'] ?? 0) / 100,
                    'commission_third' => ($ruleData['commission_third'] ?? 0) / 100,
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Regras salvas com sucesso!']);
    }

    public function deleteRule($id)
    {
        // Tenta encontrar a regra no banco
        $rule = CommissionRule::findOrFail($id);

        // Exclui a regra
        $rule->delete();

        return response()->json(['success' => true, 'message' => 'Regra excluída com sucesso!']);
    }

    private function calculateCommission($venda, $rules)
    {
        $firstSellerCommission = 0.6 / 100;
        $secondSellerCommission = 0.3 / 100;
        $thirdSellerCommission = 0.1 / 100;

        foreach ($rules as $rule) {
            // Verifica se a regra corresponde à venda atual
            if ($rule->condition_type === 'Venda Solitária' && !$venda->segundo_vendedor_id && !$venda->terceiro_vendedor_id) {
                $firstSellerCommission = $rule->commission_first;
            } elseif ($rule->condition_type === 'Venda com Assistência' && $venda->segundo_vendedor_id && !$venda->terceiro_vendedor_id) {
                if (
                    ($rule->first_seller_role === $venda->primeiroVendedor->cargo || $rule->first_seller_role === null) &&
                    ($rule->second_seller_role === $venda->segundoVendedor->cargo || $rule->second_seller_role === null)
                ) {
                    $firstSellerCommission = $rule->commission_first;
                    $secondSellerCommission = $rule->commission_second;
                }
            } elseif ($rule->condition_type === 'Venda Tripla' && $venda->terceiro_vendedor_id) {
                if (
                    ($rule->first_seller_role === $venda->primeiroVendedor->cargo || $rule->first_seller_role === null) &&
                    ($rule->second_seller_role === $venda->segundoVendedor->cargo || $rule->second_seller_role === null) &&
                    ($rule->third_seller_role === $venda->terceiroVendedor->cargo || $rule->third_seller_role === null)
                ) {
                    $firstSellerCommission = $rule->commission_first;
                    $secondSellerCommission = $rule->commission_second;
                    $thirdSellerCommission = $rule->commission_third;
                }
            }
        }

        return [
            'first_seller_commission' => $firstSellerCommission,
            'second_seller_commission' => $secondSellerCommission,
            'third_seller_commission' => $thirdSellerCommission,
        ];
    }

    public function updatePercentagem(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'percentagem' => 'required|numeric|min:0|max:100',
            'participacao' => 'required|string', // Valida o tipo de participação
        ]);

        $venda = Fechamento::find($request->id);

        // Atualiza a comissão com base no tipo de participação
        switch ($request->participacao) {
            case "Vendedor Principal":
                $venda->comissao_1 = (float) $request->percentagem;
                break;
            case "Modo Ajuda":
                $venda->comissao_2 = (float) $request->percentagem;
                break;
            case "Telemarketing":
                $venda->comissao_3 = (float) $request->percentagem;
                break;
        }


        $venda->save();

        return response()->json(['message' => 'Porcentagem atualizada com sucesso!'], 200);
    }


    public function bordero(Request $request)
    {
        $data_inicio = config('data_inicio');
        $data_fim = config('data_fim');

        $vendas = null;
        if (!is_null($data_inicio) and !is_null($data_fim)) {
            $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

            $query = [
                ['data_fechamento', '>=', $from],
                ['data_fechamento', '<=', $to],
                ['status', '=', 'FECHADA']
            ];

            $vendas = Fechamento::where($query)->get();
        }

        $bordero = [];
        $rules = CommissionRule::all(); // Obtém as regras de comissão salvas

        $info = array();
        $info['credito_vendidos'] = 0;
        $info['cotas'] = 0;

        $prd = Production::where('is_active', true)->first();
        if ($prd) {
            $start_date = Carbon::createFromFormat('Y-m-d', $prd->start_date)->format('d/m/Y');
            $end_date = Carbon::createFromFormat('Y-m-d', $prd->end_date)->format('d/m/Y');
            $info['producao']['name'] = $prd->name;
            $info['producao']['start_date'] = $start_date;
            $info['producao']['end_date'] = $end_date;
            $hoje = Carbon::today();
            $inicio = Carbon::createFromFormat('Y-m-d', $prd->start_date)->startOfDay();
            $fim = Carbon::createFromFormat('Y-m-d', $prd->end_date)->startOfDay();
            if ($hoje >= $inicio && $hoje <= $fim) {
                // Se estiver dentro do intervalo, usamos 'hoje' como a data final
                $info['producao']['dentro'] = true;
            } else {
                // Caso contrário, mantemos 'fim' como estava originalmente
                $info['producao']['dentro'] = false;
            }
        }


        foreach ($vendas as $venda) {
            $commissions = $this->calculateCommission($venda, $rules);

            $info['credito_vendidos'] = $info['credito_vendidos'] + (float) $venda->valor;
            $info['cotas'] = $info['cotas'] + 1;
            // Comissão do primeiro vendedor
            $bordero[$venda->primeiro_vendedor_id][] = [
                'id' => $venda->id,
                'contrato' => $venda->numero_contrato,
                'participacao' => "Vendedor Principal",
                'cliente' => $venda->negocio->lead->nome,
                'cliente_id' => $venda->negocio->id,
                'credito' => $venda->valor,
                'percentagem' => ($venda->comissao_1),
                'comissao' => ((float) $venda->valor) * $venda->comissao_1 / 100,
                'data_fechamento' => Carbon::parse($venda['data_fechamento'])->format('d/m/Y'),
            ];

            // Comissão do segundo vendedor (se existir)
            if ($venda->segundo_vendedor_id) {
                $bordero[$venda->segundo_vendedor_id][] = [
                    'id' => $venda->id,
                    'contrato' => $venda->numero_contrato,
                    'participacao' => "Modo Ajuda",
                    'cliente' => $venda->negocio->lead->nome,
                    'cliente_id' => $venda->negocio->id,
                    'credito' => $venda->valor,
                    'percentagem' => ($venda->comissao_2),
                    'comissao' => ((float) $venda->valor) * $venda->comissao_2 / 100,
                    'data_fechamento' => Carbon::parse($venda['data_fechamento'])->format('d/m/Y'),
                ];
            }

            // Comissão do terceiro vendedor (se existir)
            if ($venda->terceiro_vendedor_id) {
                $bordero[$venda->terceiro_vendedor_id][] = [
                    'id' => $venda->id,
                    'contrato' => $venda->numero_contrato,
                    'participacao' => "Telemarketing",
                    'cliente' => $venda->negocio->lead->nome,
                    'cliente_id' => $venda->negocio->id,
                    'credito' => $venda->valor,
                    'percentagem' => ($venda->comissao_3),
                    'comissao' => ((float) $venda->valor) * $venda->comissao_3 / 100,
                    'data_fechamento' => Carbon::parse($venda['data_fechamento'])->format('d/m/Y'),
                ];
            }
        }

        return view('administrativo.bordero', compact('vendas', 'bordero', 'info', 'rules'));
    }



    public function create()
    {
        // Renderiza a view create.blade.php
        return view('productions.create');
    }

    private function save_config($config_name, $config_value)
    {
        $empresa = Empresa::where('settings', $config_name)->first();

        // Make sure you've got the Page model
        if ($empresa) {
            $empresa->value = $config_value;
            $empresa->save();
        } else {
            $empresa = new Empresa();
            $empresa->settings = $config_name;
            $empresa->value = $config_value;
            $empresa->save();
        }

    }

    public function store(Request $request)
    {
        // Valida os dados da produção
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        if ($request->is_active) {
            $validatedData['is_active'] = true;
            // Desativa todas as produções ativas antes de criar uma nova produção
            Production::where('is_active', true)->update(['is_active' => false]);

            $data_inicio = Carbon::createFromFormat('Y-m-d', $validatedData['start_date'])->format('d/m/Y');
            $data_fim = Carbon::createFromFormat('Y-m-d', $validatedData['end_date'])->format('d/m/Y');

            $this->save_config('data_inicio', $data_inicio);
            $this->save_config('data_fim', $data_fim);


        } else {
            $validatedData['is_active'] = false;
        }

        if ($request->production_id) {
            $production = Production::find($request->production_id);
            $production->update($validatedData);
        } else {
            // Se não, cria uma nova produção
            Production::create($validatedData);
        }

        // Redireciona para o index com uma mensagem de sucesso
        return redirect()->route('productions.index')->with('success', 'Produção criada com sucesso!');
    }

    public function edit($id)
    {
        // Busca a produção pelo ID
        $production = Production::findOrFail($id);

        // Renderiza a view edit.blade.php
        return view('productions.edit', [
            'production' => $production,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Valida os dados da produção
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'active' => 'required|boolean',
        ]);

        // Busca a produção pelo ID
        $production = Production::findOrFail($id);

        // Se a produção estiver marcada como ativa, desativa as outras produções
        if ($validated['is_active']) {
            Production::where('is_active', true)->where('id', '!=', $production->id)->update(['active' => false]);
        }

        // Atualiza a produção
        $production->update($validated);
        $production->save();

        // Redireciona para o index com uma mensagem de sucesso
        return redirect()->route('productions.index')->with('success', 'Produção atualizada com sucesso!');
    }

    public function destroy($id)
    {
        // Encontra a produção pelo ID e deleta
        $production = Production::findOrFail($id);
        $production->delete();

        // Após a deleção, busca a produção mais recente pela data de término (end_date)
        $latestProduction = Production::orderBy('end_date', 'desc')->first();

        // Se existir uma produção mais recente, marca-a como ativa
        if ($latestProduction) {
            $latestProduction->is_active = true;
            $latestProduction->save();
        }

        return redirect()->route('productions.index')->with('success', 'Produção deletada com sucesso!');
    }

    public function toggle($id)
    {
        // Alterna o status ativo da produção
        $production = Production::findOrFail($id);
        $production->active = !$production->active;
        $production->save();

        return response()->json(['success' => true, 'active' => $production->active]);
    }
}
