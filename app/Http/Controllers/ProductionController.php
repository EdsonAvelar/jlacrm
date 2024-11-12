<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Production;
use Carbon\Carbon;
use App\Models\Empresa;
use App\Models\User;

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

        $comissao_principal = 0.6;
        $comissao_modo_ajuda = 0.3;

        $bordero = [];

        foreach ($vendas as $venda) {

            $vendedor = $venda->primeiro_vendedor_id;

            if (!array_key_exists($vendedor, $bordero)) {
                $bordero[$vendedor] = [];
            }

            $nova_venda['contrato'] = $venda->numero_contrato;
            $nova_venda['participacao'] = "Vendedor Principal";
            $nova_venda['cliente'] = $venda->negocio->lead->nome;
            $nova_venda['credito'] = $venda->valor;
            $nova_venda['percentagem'] = 0.3;
            $nova_venda['comissao'] = ((float) $venda->valor) * 0.3;
            $nova_venda['data_fechamento'] = Carbon::parse($venda['data_fechamento'])->format('d/m/Y');

            $bordero[$vendedor][] = $nova_venda;
        }


        foreach ($vendas as $venda) {

            $vendedor = $venda->segundo_vendedor_id;

            if ($vendedor == "") {
                continue;
            }

            if (!array_key_exists($vendedor, $bordero)) {
                $bordero[$vendedor] = [];
            }

            $nova_venda['contrato'] = $venda->numero_contrato;
            $nova_venda['participacao'] = "Vendedor Principal";
            $nova_venda['cliente'] = $venda->negocio->lead->nome;
            $nova_venda['credito'] = $venda->valor;
            $nova_venda['percentagem'] = 0.3;
            $nova_venda['comissao'] = ((float) $venda->valor) * 0.3;
            $nova_venda['data_fechamento'] = Carbon::parse($venda['data_fechamento'])->format('d/m/Y');

            $bordero[$vendedor][] = $nova_venda;
        }

        dd($bordero);
        return view('administrativo.bordero', compact('vendas', 'bordero'));
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
