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
use App\Models\User;

use Exception;

class WebhookController extends Controller
{
    private function removePatterns($string)
    {
        // Define os padrões a serem removidos
        $patterns = [
            '/^\+55/',  // Remove "+55" no início da string
            '/^p:\+55/', // Remove "p:+55" no início da string
            '/^p:55/',   // Remove "p:55" no início da string
            '/^55/'      // Remove "55" no início da string
        ];

        // Aplica os padrões na string
        foreach ($patterns as $pattern) {
            $string = preg_replace($pattern, '', $string);
        }

        return $string;
    }

    public function create_negocio($dados)
    {

        $user = User::find($dados['proprietario_id']);

        $query = [
            ['telefone', '=', $dados['telefone']],
            ['nome', '=', $dados['nome']],
        ];

        $lead = Lead::where($query)->first();

        if ($user != null & $lead === null) {

            $telefone = $this->removePatterns($dados['telefone']);

            $lead = new Lead();
            $lead->nome = $dados['nome'];
            $lead->telefone = $telefone;
            $lead->email = $dados['email'];
            $lead->fonte = $dados['fonte'];

            $lead->data_conversao = Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i');
            $lead->save();

            $deal_input = array();
            $deal_input['titulo'] = "Negócio com " . $dados['nome'];
            $deal_input['valor'] = 0;
            $deal_input['funil_id'] = '1';
            $deal_input['etapa_funil_id'] = '1';
            $deal_input['tipo'] = $dados['tipo_do_bem'];
            $deal_input['lead_id'] = $lead->id;
            $deal_input['user_id'] = $dados['proprietario_id'];

            $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

            $deal_input['origem'] = 'WEBHOOK';

            $negocio = Negocio::create($deal_input);

            Atividade::add_atividade($user->id, "Cliente do " . $lead->fonte . " de " . $dados['tipo_do_bem'] . " importado via webhook", $negocio->id);

            Atividade::add_atividade($user->id, "Cliente atribui a " . $user->name . " por " . $user->name, $negocio->id);

            return "[Webhook] Negocio " . $dados['nome'] . " Criado com sucesso";

        } else {
            throw new Exception("Erro! Id so proprietario não existe ou está duplicado");

        }
    }

    public function create_lead($dados)
    {


        if (array_key_exists('proprietario_id', $dados)) {

            $proprietaio_id = (int) $dados['proprietario_id'];

            if ($proprietaio_id > 0) {
                return $this->create_negocio($dados);
            }
        }

        $negocio = new NegocioImportado();

        $telefone = $this->removePatterns($dados['telefone']);


        if (NegocioImportado::where('telefone', $telefone)->exists()) {

            #throw new Exception("Lead duplicado");
            return "[Webhook] Negocio " . $dados['nome'] ." (". $telefone ." )". " já existe no CRM";
        }


        //Obrigatorios
        $negocio->nome = $dados['nome'];
        $negocio->telefone = $telefone;
        $negocio->tipo_do_bem = $dados['tipo_do_bem']; //Campanha é o tipo do imovel

        //Opcionais
        $negocio->email = $dados['email'];
        $negocio->campanha = $dados['campanha']; //Campanha é o tipo do imovel
        $negocio->fonte = $dados['fonte'];
        $negocio->origem = "WEBHOOK";

        $negocio->data_conversao = Carbon::now('America/Sao_Paulo')->format('Y-m-d  H:i');
        try {
            $negocio->save();
            return "[Webhook] Negocio " . $dados['nome'] . " Importado com sucesso";
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
