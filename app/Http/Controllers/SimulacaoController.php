<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\EtapaFunil;
use App\Models\Lead;
use App\Models\Proposta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\Simulacao;
use App\Models\SimulacaoConsorcio;
use App\Models\SimulacaoFinanciamento;

class SimulacaoController extends Controller
{
    public function simulacao(Request $request){
       
        $negocio_id = $request->query('negocio_id');
        $negocio = Negocio::where('id',$negocio_id)->first();


           
        $etapa = EtapaFunil::find($negocio->etapa_funil_id)->nome;


        if ($etapa == "REUNIAO"){

            return view('negocios.simulacao2',compact('negocio'));
        }else {
            return back()->withErrors("Cliente precisa estar na etapa REUNIAO para gerar propostas");
        }

        

        
    }

    public function criar_proposta(Request $request){

        $input = $request->all();      
        
        //Negocio associado a simulacao
        $simulacao = new Simulacao();
        $simulacao['tipo'] = $input['tipo'];
        $simulacao['data_proposta'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        $simulacao['negocio_id'] = $input['negocio_id'];
        $simulacao['user_id'] = \Auth::user()->id;

        // Salvar CPF
        $neg = Negocio::find($input['negocio_id']);
        $lead = Lead::find($neg->lead->id );
        $lead->cpf = $input['cpf'];
        $lead->save();


        $simulacao->save();

        if ($request->has('fin-empresa')) {
            
            $fin_len = count( $input['fin-empresa']);
            for ($i=0; $i < $fin_len; $i++) { 
                
                $sim_tipo = new SimulacaoFinanciamento();
                
                $sim_tipo['fin-titulo'] = $input['fin-titulo'][ $i ];
                $sim_tipo['fin-empresa'] = $input['fin-empresa'][ $i ];
                $sim_tipo['fin-credito'] = $input['fin-credito'][ $i ];
                $sim_tipo['fin-entrada'] = $input['fin-entrada'][ $i ];
                $sim_tipo['fin-parcelas'] = $input['fin-parcelas'][ $i ];
                $sim_tipo['fin-prazo'] = $input['fin-prazo'][ $i ];
                $sim_tipo['fin-rendaexigida'] = $input['fin-rendaexigida'][ $i ];
                $sim_tipo['fin-cartorio'] = $input['fin-cartorio'][ $i ];
                $sim_tipo['fin-juros-pagos'] = $input['fin-juros-pagos'][ $i ];
                $sim_tipo['fin-val-pago-total'] = $input['fin-val-pago-total'][ $i ];
       
                $sim_tipo['fin-amortizacao'] = $input['fin-amortizacao'][ $i ];
               
             
                $sim_tipo->simulacao_id = $simulacao->id;
                $sim_tipo->save();
            }
        }

        if ($request->has('con-empresa')) {
            
            $con_len = count( $input['con-empresa']);

            for ($i=0; $i < $con_len; $i++) { 
                
                $sim_tipo = new SimulacaoConsorcio();

                $sim_tipo['con-titulo'] = $input['con-titulo'][ $i ];
                $sim_tipo['con-empresa'] = $input['con-empresa'][ $i ];
                $sim_tipo['con-credito'] = $input['con-credito'][ $i ];
                $sim_tipo['con-adesao'] = $input['con-adesao'][ $i ];
                $sim_tipo['con-entrada'] = $input['con-entrada'][ $i ];
                $sim_tipo['con-parcela-cheia'] = $input['con-parcela-cheia'][ $i ];
                $sim_tipo['con-parcela-reduzida'] = $input['con-parcela-reduzida'][ $i ];
                $sim_tipo['con-prazo'] = $input['con-prazo'][ $i ];
                $sim_tipo['con-lance'] = $input['con-lance'][ $i ];
                $sim_tipo['con-rendaexigida'] = $input['con-rendaexigida'][ $i ];
                $sim_tipo['con-valor-pago'] = $input['con-valor-pago'][ $i ];
                $sim_tipo['con-parcelas_embutidas'] = $input['con-parcelas_embutidas'][ $i ];
                $sim_tipo['con-juros-pagos'] = $input['con-juros-pagos'][ $i ];

                // Calculando o valor total a ser pago  
                // $subs = array("R","$",".");
                // $valor_entrada = floatval( str_replace($subs,"",$sim_tipo['con-entrada']));
                // $valor_parcela = floatval( str_replace($subs,"",$sim_tipo['con-parcela-cheia']));
                // $credito = floatval( str_replace($subs,"",$sim_tipo['con-credito']));
                // $prazo = intval( $sim_tipo['con-prazo']);
                
                // $vtotal = ($prazo * $valor_parcela) + $valor_entrada;
                
                // $sim_tipo['con-juros-pagos'] = $valor_parcela = "R$ ".number_format($vtotal - $credito,2, ',', '.'); 
                
                $sim_tipo->simulacao_id = $simulacao->id;
                $sim_tipo->save();
            }

        }

      
        /*


  
        if ($request->has('reduzido')){

            $input['reduzido'] = 's';
        }else{
            $input['reduzido'] = 'n';
        }

        $con_entrada = $input['con-entrada'];

        $proposta = new Proposta();
        $proposta['tipo'] = $input['tipo'];
        $proposta['banco'] = $input['banco'];
        $proposta['credito'] = $input['credito'];
        $proposta['fin-entrada'] = $input['fin-entrada'];
        $proposta['fin-parcelas'] = $input['fin-parcelas'];
        $proposta['fin-prazo'] = $input['fin-prazo'];
        $proposta['fin-rendaexigida'] = $input['fin-rendaexigida'];
        $proposta['cartorio'] = $input['cartorio'];
        $proposta['fin-juros-pagos'] = $input['fin-juros-pagos'];
        $proposta['val-pago-total'] = $input['val-pago-total'];


        $proposta['con-entrada'] = $input['con-entrada'];
        $proposta['con-parcelas'] = $input['con-parcelas'];
        $proposta['con-prazo'] = $input['con-prazo'];
        $proposta['con-rendaexigida'] = $input['con-rendaexigida'];
        $proposta['con-valor-pago'] = $input['con-valor-pago'];
        $proposta['reduzido'] = $input['reduzido'];
        $proposta['parcelas_embutidas'] = $input['parcelas_embutidas'];
        $proposta['data_proposta'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

        $proposta['user_id'] = \Auth::user()->id;
        $proposta['negocio_id'] = $input['negocio_id'];

        $neg = Negocio::find($input['negocio_id']);
        $lead = Lead::find($neg->lead->id );
        $lead->cpf = $input['cpf'];
        $lead->save();

        $proposta['con-credito'] = $input['con-credito'];
        $proposta['con-adesao'] = $input['con-adesao'];
        $proposta['con-juros-pagos'] = $input['con-juros-pagos'];
        $proposta['modelo'] = $input['modelo']; 
        $proposta['ano'] = $input['ano'];

        $proposta['con-administradora'] = strtoupper( $input['con-administradora'] );

        $amortizacao = 'sac';
        if ($request->filled('amortizacao')) {
            $amortizacao = 'sac';
            $proposta['amortizacao'] = 'sac';
            $input['amortizacao'] = 'sac';
        }else {
            $amortizacao = 'price';
            $proposta['amortizacao'] = 'price';
            $input['amortizacao'] = 'price';
        }
       

        $proposta->save();

        

        $proposta_id = $proposta->id;
        Atividade::add_atividade(\Auth::user()->id, "Nova proposta criada id: ".$proposta->id, $input['negocio_id'] );

        */
        
        Atividade::add_atividade(\Auth::user()->id, "Nova proposta criada id: ".$simulacao->id, $input['negocio_id'] );


        return view('simulacoes.multi_proposta', compact('simulacao'));
    }


    public function ver_proposta(Request $request){

        $id = $request->query('id');
        $simulacao = Simulacao::find($id);

        return view('simulacoes.multi_proposta', compact('simulacao'));
    }
}
