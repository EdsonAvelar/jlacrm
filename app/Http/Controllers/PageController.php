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
    public function landingpages(Request $request)
    {
        $input = $request->all();

        $pagina = $input['page'];

        if ($pagina == null){
            return abort(404);
        }else {
            return view('cadastro.'.$pagina);

        }

    }


    public function cadastrar(Request $request){

        $consultor = config('whatsapp');
        $input = $request->all();     

        $deal_input = array();
        $primeiro_nome = explode(" ",  $input['nome'])[0];

        $deal_input['titulo'] = $primeiro_nome."-".$input['tipo_credito']."-".$input['valor_credito'];
        $deal_input['valor'] = 0;         
        $deal_input['funil_id'] = $input['funil_id'];
        $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];
        $deal_input['tipo'] = $input['tipo_credito'];
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
        $lead->data_conversao = Carbon::now('America/Sao_Paulo')->format('d/m/Y');;

        $lead->save();

        // associando lead ao negócio
        $deal_input['lead_id'] = $lead->id;
        
        $proprietario = $input['proprietario'];
        $user = null;
        if(!empty($proprietario))
        {
            $user = User::where('email',$proprietario)->first();

            if (!empty($user)) {
                $deal_input['user_id'] = $user->id;
                $consultor = $user->telefone;
            }
            
        }

        $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        
        //criando o negócio
        $negocio = Negocio::create($deal_input);

        $neg_com= new NegocioComentario();
        $neg_com->comentario = "ValorCredito:".$input['valor_credito']."\nEntrada:".$input['entrada'];
        $neg_com->negocio_id = $negocio->id;
        $neg_com->user_id = User::find(1)->id;
        
        

        $neg_com->save();

        $texto = "Lead Cadastrado pelo Site. Campanha: ".$input['campanha']." \nFonte:".$input['fonte'].'\WhatsApp: '.$consultor;

        if (!empty($user)){
            $texto = $texto."\nProprietario: ".$user->email;
        }
        
        Atividade::add_atividade(User::find(1)->id, $texto, $negocio->id);

        return redirect( route('obrigado' , array('consultor' => $consultor )));
    }

    public function obrigado(Request $request){

        $consultor = $request->query('consultor');
        return view('cadastro.concluido_01', compact('consultor'));
    }
}
