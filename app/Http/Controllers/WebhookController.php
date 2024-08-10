<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\Lead;

use App\Models\Atividade;
use Carbon\Carbon;
use App\Models\NegocioImportado;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{

    public function create_lead($dados)
    {


        /*

        curl -X POST http://localhost:8000/api/webhook/newlead -H "Authorization: 2e6f9b0d5885b6010f9167787445617f553a735f" -d '{"nome":"test1","telefone":"123", "email":"eam.avelar","campanha":"Imovel Dor","fonte":"facebook","tipo_do_bem":"IMOVEL"}'

        */
        //$deal_input = array();



        $negocio = new NegocioImportado();


        if (NegocioImportado::where('telefone', $dados['telefone'])->exists()) {
            return "Lead duplicado";
        }

        //Obrigatorios
        $negocio->nome = $dados['nome'];
        $negocio->telefone = $dados['telefone'];
        $negocio->tipo_do_bem = $dados['tipo_do_bem']; //Campanha é o tipo do imovel

        //Opcionais
        $negocio->email = $dados['email'];
        $negocio->campanha = $dados['campanha']; //Campanha é o tipo do imovel
        $negocio->fonte = $dados['fonte'];

        $negocio->data_conversao = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        try {
            $negocio->save();
            return "Negocio " . $dados['nome'] . " Criado com sucesso";
        } catch (QueryException $e) {
            return "Erro ao importar Negocio: " . $e->getMessage();

        }



        // $deal_input['titulo'] = "Negócio " . $dados['nome'] . "-" . $dados['tipo_credito'];

        // $deal_input['funil_id'] = 1;
        // $deal_input['etapa_funil_id'] = 1;
        // $deal_input['tipo'] = $dados['tipo_credito'];

        // $lead = new Lead();
        // $lead->nome = $dados['nome'];
        // $lead->telefone = $dados['telefone'];
        // $lead->whatsapp = $dados['whatsapp'];
        // $lead->save();

        // // associando lead ao negócio
        // $deal_input['lead_id'] = $lead->id;


        // $deal_input['user_id'] = (int) ($dados['id']);

        // $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

        // //criando o negócio
        // $negocio = Negocio::create($deal_input);

        // Atividade::add_atividade($deal_input['user_id'], "Cliente criado via webhook", $negocio->id);

        //return "Negocio " . $dados['nome'] . " Criado com sucesso";
    }
    public function handle(Request $request)
    {

        $key = 'webhook-rate-limit';
        $rateLimit = 1; // Limite de 1 segundo

        if (Cache::has($key)) {
            return response()->json(['error' => 'Too many requests. Please wait.'], 429);
        }

        Cache::put($key, true, $rateLimit);

        $token = $request->bearerToken();

        $token_webhook = config('token_webhook');

        if ($token_webhook) {

            if ($token !== $token_webhook) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $data = $request->json()->all();

            $jsonString = json_encode($data);

            Log::info('Recebendo Webhook:. ' . $jsonString);



            $response = $this->create_lead($data);


            // Retorna uma resposta de sucesso
            return response()->json(['message' => $response]);
        } else {
            return response()->json(['message' => 'Sistema sem Token Cadastrado'], 500);
        }


    }


}
