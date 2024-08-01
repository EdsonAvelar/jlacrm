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
    public function simulacao(Request $request)
    {

        $negocio_id = $request->query('negocio_id');
        $negocio = Negocio::where('id', $negocio_id)->first();

        $etapa = EtapaFunil::find($negocio->etapa_funil_id)->nome;


        if ($etapa == "REUNIAO") {

            return view('negocios.simulacao2', compact('negocio'));
        } else {
            return back()->with('status_error', "Cliente precisa estar na etapa REUNIAO para gerar propostas");
        }

    }

    public function criar_proposta(Request $request)
    {

        $input = $request->all();

        //Negocio associado a simulacao
        $simulacao = new Simulacao();
        $simulacao['tipo'] = $input['tipo'];
        $simulacao['data_proposta'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        $simulacao['negocio_id'] = $input['negocio_id'];

        // Salvar CPF
        $neg = Negocio::find($input['negocio_id']);
        $lead = Lead::find($neg->lead->id);
        $lead->cpf = $input['cpf'];
        $lead->save();

        $simulacao['user_id'] = \Auth::user()->id;



        $simulacao->save();

        if ($request->has('fin-empresa')) {

            $fin_len = count($input['fin-empresa']);
            for ($i = 0; $i < $fin_len; $i++) {

                $sim_tipo = new SimulacaoFinanciamento();

                $sim_tipo['fin-titulo'] = $input['fin-titulo'][$i];
                $sim_tipo['fin-empresa'] = $input['fin-empresa'][$i];
                $sim_tipo['fin-credito'] = $input['fin-credito'][$i];
                $sim_tipo['fin-entrada'] = $input['fin-entrada'][$i];
                $sim_tipo['fin-parcelas'] = $input['fin-parcelas'][$i];
                $sim_tipo['fin-prazo'] = $input['fin-prazo'][$i];
                $sim_tipo['fin-rendaexigida'] = $input['fin-rendaexigida'][$i];
                $sim_tipo['fin-cartorio'] = $input['fin-cartorio'][$i];
                $sim_tipo['fin-juros-pagos'] = $input['fin-juros-pagos'][$i];
                $sim_tipo['fin-val-pago-total'] = $input['fin-val-pago-total'][$i];

                $sim_tipo['fin-amortizacao'] = $input['fin-amortizacao'][$i];


                $sim_tipo->simulacao_id = $simulacao->id;
                $sim_tipo->save();
            }
        }

        if ($request->has('con-empresa')) {

            $con_len = count($input['con-empresa']);

            for ($i = 0; $i < $con_len; $i++) {

                $sim_tipo = new SimulacaoConsorcio();

                $sim_tipo['con-titulo'] = $input['con-titulo'][$i];
                $sim_tipo['con-empresa'] = $input['con-empresa'][$i];
                $sim_tipo['con-credito'] = $input['con-credito'][$i];
                $sim_tipo['con-adesao'] = $input['con-adesao'][$i];
                $sim_tipo['con-entrada'] = $input['con-entrada'][$i];
                $sim_tipo['con-parcela-cheia'] = $input['con-parcela-cheia'][$i];
                $sim_tipo['con-parcela-reduzida'] = $input['con-parcela-reduzida'][$i];
                $sim_tipo['con-prazo'] = $input['con-prazo'][$i];
                $sim_tipo['con-lance'] = $input['con-lance'][$i];
                $sim_tipo['con-rendaexigida'] = $input['con-rendaexigida'][$i];
                $sim_tipo['con-valor-pago'] = $input['con-valor-pago'][$i];
                $sim_tipo['con-parcelas_embutidas'] = $input['con-parcelas_embutidas'][$i];
                $sim_tipo['con-juros-pagos'] = $input['con-juros-pagos'][$i];
                $sim_tipo->simulacao_id = $simulacao->id;
                $sim_tipo->save();
            }

        }


        Atividade::add_atividade(\Auth::user()->id, "Nova proposta criada id: " . $simulacao->id, $input['negocio_id']);

        return view('simulacoes.multi_proposta', compact('simulacao'));
    }


    public function ver_proposta(Request $request)
    {

        $id = $request->query('id');
        $simulacao = Simulacao::find($id);

        return view('simulacoes.multi_proposta', compact('simulacao'));
    }
}
