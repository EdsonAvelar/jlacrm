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

        $cliente_nome = $input['cliente_nome'];
        
        $valor = str_replace('.','',$input['valor'] );

        $data_fechamento = Carbon::createFromFormat('d/m/Y',$input['data_fechamento'])->format('Y-m-d');
        $data_primeira_assembleia = Carbon::createFromFormat('d/m/Y',$input['data_primeira_assembleia'])->format('Y-m-d');

        #$vendedor_principal = $input['vendedor_principal'];
        #$vendedor_secundario = $input['vendedor_secundario'];
        $negocio_id = $input['negocio_id'];
        #$cliente_id = $input['cliente_id'];
        #$tipo_credito = $input['tipo_credito'];
        $parcelas_embutidas = $input['parcelas_embutidas'];

        #Lead::where('id',$cliente_id)->update(['nome'=>$cliente_nome]);
    
  

        $venda = new Fechamento();
        $venda->data_fechamento = $data_fechamento;
        $venda->data_primeira_assembleia = $data_primeira_assembleia;
        $venda->valor = $valor;
        $venda->parcelas_embutidas = $parcelas_embutidas;
        $venda->negocio_id = $negocio_id;
        #$venda->vendedor_principal_id = $vendedor_principal;
        $venda->status = VendaStatus::FECHADA;

        #if ($vendedor_secundario != "null"){
        #    $venda->vendedor_secundario_id = $vendedor_secundario;
        #}
       
        $venda->save();


        # Atualizar tipo de negociacao

        Negocio::where('id',$negocio_id)->update([
        'valor'=>$valor,
        #'tipo'=>$tipo_credito,
        'status'=> NegocioStatus::VENDIDO]);

        Atividade::add_atividade(\Auth::user()->id, "Cliente GANHO", $negocio_id);

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
