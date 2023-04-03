<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NegocioComentario;
use App\Models\Negocio;
use App\Models\Lead;
use App\Models\User;
use App\Models\Atividade;
use Validator;
use Carbon\Carbon;
class PageController extends Controller
{
    public function cadastro(Request $request)
    {
        return view('cadastro.fb_cadastro_01');
    }

    public function get_consultor(){
        $consultores = ['11993155854','11993620652','11993605637'];
        
        $consultor = $consultores[array_rand($consultores)];

        return $consultor;
    }

    public function cadastrar(Request $request){

        $consultor = $this->get_consultor();
        $input = $request->all();     

        $deal_input = array();
        $primeiro_nome = explode(" ",  $input['nome'])[0];

        $deal_input['titulo'] = $primeiro_nome."-".$input['tipo_credito']."-".$input['valor_credito'];
        $deal_input['valor'] = 0;         
        $deal_input['funil_id'] = $input['funil_id'];
        $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];

        $lead_input = array();
        $lead_input['nome'] = $input['nome'];
        $lead_input['telefone'] = $input['telefone'];
     
        //Validando leads
        $rules = [
            'nome' => 'required',
            'telefone' => 'required',
        ];
        
        $error_msg = [
            'nome.required' => 'Nome do Contato é obrigatório',
            'telefone.required' => 'Telefone do Contato é obrigatório',
        ];
        $validator = Validator::make($lead_input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validado, hora de criar o lead para associar ao negocio
        $lead = new Lead();
        $lead->nome = $lead_input['nome'];
        $lead->telefone = $lead_input['telefone'];

        $lead->campanha = $input['campanha'];
        $lead->fonte = $input['fonte'];
        $lead->data_conversao = Carbon::now()->format('d/m/Y');;

        $lead->save();

        // associando lead ao negócio
        $deal_input['lead_id'] = $lead->id;
    
        //criando o negócio
        $negocio = Negocio::create($deal_input);

        $neg_com= new NegocioComentario();
        $neg_com->comentario = "ValorCredito:".$input['valor_credito']."\nEntrada:".$input['entrada'];
        $neg_com->negocio_id = $negocio->id;
        $neg_com->user_id = User::find(1)->id;
        $neg_com->save();
        
        Atividade::add_atividade(User::find(1)->id, "Lead Cadastrado pelo Site. Campanha: ".$input['campanha']." \nFonte:".$input['fonte'].'\WhatsApp: '.$consultor  , $negocio->id);

        return view('cadastro.concluido_01', compact('consultor'));
    }

    public function concluido(){

        $consultor = $this->get_consultor();
        return view('cadastro.concluido_01', compact('consultor'));
    }
}
