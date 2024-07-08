<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\Lead;

use App\Models\Atividade;
use Carbon\Carbon;

class WebhookController extends Controller
{

    public function create_lead($dados)
    {


        /*

        curl -X POST http://localhost:8000/api/webhook/newlead -H "Authorization: 58a9fc133aa878e7434459c59868dfc4" -d '{"nome":"test1","tipo_credito":"IMOVEL","telefone":"123","whatsapp":"123","id":"-1"}'

        */
        $deal_input = array();

        $deal_input['titulo'] = "Negócio " . $dados['nome'] . "-" . $dados['tipo_credito'];

        $deal_input['funil_id'] = 1;
        $deal_input['etapa_funil_id'] = 1;
        $deal_input['tipo'] = $dados['tipo_credito'];

        $lead = new Lead();
        $lead->nome = $dados['nome'];
        $lead->telefone = $dados['telefone'];
        $lead->whatsapp = $dados['whatsapp'];
        $lead->save();

        // associando lead ao negócio
        $deal_input['lead_id'] = $lead->id;


        $deal_input['user_id'] = (int) ($dados['id']);

        $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

        //criando o negócio
        $negocio = Negocio::create($deal_input);

        Atividade::add_atividade($deal_input['user_id'], "Cliente criado via webhook", $negocio->id);

        return "Negocio " . $dados['nome'] . " Criado com sucesso";
    }
    public function handle(Request $request)
    {

        $token = $request->header('Authorization');

        $token_webhook = config('token_webhook');

        if ($token_webhook) {

            if ($token !== $token_webhook) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $data = $request->json()->all();

            $this->create_lead($data);


            // Retorna uma resposta de sucesso
            return response()->json(['message' => $this->create_lead($data)]);
        } else {
            return response()->json(['message' => 'Sistema sem Token Cadastrado'], 500);
        }


    }


}
