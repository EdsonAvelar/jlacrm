<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Negocio;
use App\Models\Fechamento;
use App\Enums\VendaStatus;
use App\Enums\NegocioStatus;
use App\Models\Atividade;


class FechamentoController extends Controller
{
    public function index(Request $request)
    {
        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        $vendas = null;
        if ( !is_null($data_inicio) and !is_null($data_fim) ){
            $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y',$data_fim)->format('Y-m-d');

            $vendas = Fechamento::whereBetween('data_fechamento', [$from, $to])->get();
        }

        return view('vendas.index', compact('vendas'));
    }

    
    public function nova_venda(Request $request)
    {

        $input = $request->all();
        $valor = str_replace('.','',$input['valor'] );
        $negocio_id = $input['negocio_id'];
        $negocio = Negocio::find($negocio_id);

        if ($negocio->fechamento_id){
            $venda = Fechamento::find($negocio->fechamento_id);
        }else {
            $venda = new Fechamento();
        }
        
        $docs = ['data_fechamento','data_assembleia',
        'conj_data_nasc','data_nasc','data_exp'];
        foreach ($docs as $doc) {
            if ( $input[$doc] ){
                $input[$doc] = Carbon::createFromFormat('d/m/Y',$input[$doc])->format('Y-m-d');
            }   
        }

        $venda->valor = $valor;

        
        //DADOS DO PLANO CONTRATADO
        
        $venda['marca'] = $input['marca'];
        $venda['modelo'] = $input['modelo'];
        $venda['codigo_bem'] = $input['codigo_bem'];
        $venda['preco_bem'] = $input['preco_bem'];
        $venda['duracao_grupo'] = $input['duracao_grupo'];
        $venda['grupo'] = $input['grupo'];
        $venda['duracao_plano'] = $input['duracao_plano'];
        $venda['tipo_plano'] = $input['tipo_plano'];
        $venda['plano_leve'] = $input['plano_leve'];
        $venda['seguro_prestamista'] = $input['seguro_prestamista'];
        $venda['grupo_em_formacao'] = $input['grupo_em_formacao'];
        $venda['grupo_em_andamento'] = $input['grupo_em_andamento'];
        $venda['numero_assembleia_adesao'] = $input['numero_assembleia_adesao'];
        $venda['data_assembleia'] = $input['data_assembleia'];
        $venda['data_fechamento'] = $input['data_fechamento'];

        $venda['pagamento_incorporado'] = $input['pagamento_incorporado'];
        $venda['pagamento_ate_contemplacao'] = $input['pagamento_ate_contemplacao'];
        $venda['tabela'] = $input['tabela'];
        $venda['numero_contrato'] = $input['numero_contrato'];

        // FORMA DE PAGAMENTO INICIAL
        $venda['parcela'] = $input['parcela'];
        $venda['parcela_antecipada'] = $input['parcela_antecipada'];
        $venda['total_antecipado'] = $input['total_antecipado'];
        $venda['adesao'] = $input['adesao'];
        $venda['primeira_parcela'] = $input['primeira_parcela'];
        $venda['total_pago'] = $input['total_pago'];

        if ( in_array('forma_pagamento',$input)){
            $venda['forma_pagamento'] = $input['forma_pagamento'];
        }
        
         // CHECAGEM DO ADMINISTRATIVO
        $docs = ['doc_consorciado','doc_conjuge','comp_pagamento','comp_endereco',
        'comp_venda','self_declaracao','controle_qualidade','video','comentarios'];
        foreach ($docs as $doc) {
            if ( $request->has( $doc) ){
                $venda[$doc] = $input[$doc];
            }
        }

        $venda->primeiro_vendedor_id = $input['primeiro_vendedor_id'];
        $venda->segundo_vendedor_id = $input['segundo_vendedor_id'];
        $venda->terceiro_vendedor_id = $input['terceiro_vendedor_id'];

        $venda->save();

        if ($negocio->conjuge_id){
            $conjuge = Lead::find($negocio->conjuge_id);
        }else {
            $conjuge = new Lead();
        }

        if (!$input['conj_nome']){
            $input['conj_nome'] = "";
        }

        if (!$input['conf_telefone']){
            $input['conf_telefone'] = "";
        }
        
        $conjuge['nome'] = $input['conj_nome'];
        $conjuge['telefone'] = $input['conf_telefone'];
        $conjuge['data_nasc'] = $input['conj_data_nasc'];
        $conjuge['cpf'] = $input['conj_cpf'];
        $conjuge['rg'] = $input['conj_rg'];
        $conjuge['orgao_exp'] = $input['conj_orgao_exp'];
        $conjuge['data_exp'] = $input['conj_data_exp'];
        $conjuge['nacionalidade'] = $input['conj_nacionalidade'];
        $conjuge['naturalidade'] = $input['conj_naturalidade'];
        $conjuge['genero'] = $input['conj_genero'];
        $conjuge['formacao'] = $input['conj_formacao'];
        $conjuge['profissao'] = $input['conj_profissao'];
        $conjuge['renda_liquida'] = $input['conj_renda_liquida'];
        $conjuge->save();

        if ($negocio->lead_id){
            $lead = Lead::find($negocio->lead_id);
        }else {
            $lead = new Lead();
        }

        $lead['nome'] = $input['nome'];
        $lead['telefone'] = $input['telefone'];
        $lead['nome_pai'] = $input['nome_pai'];
        $lead['nome_mae'] = $input['nome_mae'];
        $lead['data_nasc'] = $input['data_nasc'];
        $lead['cpf'] = $input['cpf'];
        $lead['rg'] = $input['rg'];
        $lead['orgao_exp'] = $input['orgao_exp'];
        $lead['data_exp'] = $input['data_exp'];
        $lead['nacionalidade'] = $input['nacionalidade'];
        $lead['naturalidade'] = $input['naturalidade'];
        $lead['genero'] = $input['genero'];
        $lead['formacao'] = $input['formacao'];
        $lead['profissao'] = $input['profissao'];
        $lead['renda_liquida'] = $input['renda_liquida'];
        $lead->save();
        
        # Atualizar tipo de negociacao
        Negocio::where('id',$negocio_id)->update([
        'valor'=>$valor,
        'fechamento_id' => $venda->id,
        'conjuge_id' => $conjuge->id,
        'lead_id' => $lead->id,
        #'tipo'=>$tipo_credito,
        'status'=> NegocioStatus::VENDIDO]);

        Atividade::add_atividade(\Auth::user()->id, "Fechamento Concluido", $negocio_id);

        return back()->with('status', "Venda Cadastrada com sucesso");
    }

    public function venda_perdida(Request $request)
    {
        $input = $request->all();
        $negocio_id = $input['negocio_id'];
        Negocio::where('id',$negocio_id)->update(['status'=> NegocioStatus::PERDIDO]);

        Atividade::add_atividade(\Auth::user()->id, "Negócio PERDIDO", $negocio_id);

        return back()->with('status', "Negócio Perdido :( ");
    }
}
