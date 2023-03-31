<?php

namespace App\Http\Controllers;

use App\Models\Funil;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Negocio;
use App\Models\EtapaFunil;
use App\Models\User;
use App\Models\Equipe;
use App\Models\MotivoPerda;

use \App\Models\NegocioComentario;
use Auth;
use Validator;

use App\Models\Atividade;

class CrmController extends Controller
{
    public function add_lead(Request $request)
    {

        $submit = $request['submit'];

        if ($submit == "submit") {

            $request->validate([
                'nome' => 'required',
                'telefone' => 'required|min:10',
                'titulo' => 'required'
            ]);

            $lead = new Lead();
            $lead->nome = $request['nome'];
            $lead->telefone = $request['telefone'];
            $lead->titulo = $request['titulo'];

        }
        return view('leads/add_lead');
    }

    public function pipeline_index(Request $request )
    {

        $curr_funil_id = intval( $request->query('id')) ;
        $proprietario_id = intval( $request->query('proprietario'));


        $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

        $proprietario = User::find($proprietario_id);
        $equipe_proprietario = NULL;

        $equipe_exists = 1;
        if ( !empty($proprietario)){
            $equipe_proprietario = $proprietario->equipe()->first();
        }else{
            $proprietario = NULL;

            if ( $proprietario_id == -2){
                $equipe_exists = -1;
                $equipe_proprietario = -1;
            }
            
        }
        
        $auth_user_id = Auth::user()->id;
        /**
         * Valida se é um usuário autorizado a ter essa visao
         */
        if ($auth_user_id != $proprietario_id) {
            if (!(Auth::user()->hasRole('admin'))) {

                if ($equipe_proprietario == NULL) {
                    return abort(401);
                } else if (!Auth::user()->hasRole('gerenciar_equipe')) {
                    return abort(401);
                } else if ($equipe_exists > 0 and $equipe->id != $equipe_proprietario->id) {
                    return abort(401);
                }
            }else{
                $equipe_exists = 1;
            }
        }

        $view = $request->query('view');

        $pipeline = Funil::where('id', $curr_funil_id)->get();
        $funils = Funil::all()->pluck('nome', 'id');

        $query = array();
        $ids = null;
        if ($proprietario_id == null){
            $query = [
                ['funil_id', '=', $curr_funil_id],
                ['user_id', '=', \Auth::user()->id],
            ];
        }elseif($proprietario_id == -1){
           
                
                $query = [
                    ['user_id', '=', NULL]
                ];
            
            
        }elseif($proprietario_id == -2){

             // Coordenador de equipe querendo ver todos os leads dos seus vendedores
            
            if ($equipe_exists == -1) {
                $ids = $equipe->integrantes()->pluck('id')->toArray();

                $query = [
                    ['funil_id', '=', $curr_funil_id],
                   
                ];
            }else {
                // Admin querendo ver todos os leads dos seus vendedores
                $query = [
                    ['id', '>', 0]
                ];
            }
        
        } else {
            $query = [
                ['funil_id', '=', $curr_funil_id],
                ['user_id', '=', $proprietario_id],
            ];
        }

        $status = $request->query('status');
        
        if ( $status ){

            $status_arr = ['status', '=', strtoupper( $status)];
            array_push($query, $status_arr);
        }
        
        if ($proprietario_id == -2 and $equipe_exists == -1){
            $negocios = Negocio::whereIn('user_id', $ids)->get();
        }else {
            $negocios = Negocio::where($query)->get();
        }
        

        $etapa_funils = $pipeline->first()->etapa_funils()->pluck('nome', 'ordem')->toArray();
        ksort($etapa_funils);
        
        $users = User::all();


        $proprietarios = NULL;
        if ( Auth::user()->hasRole('admin')){
            $proprietarios = User::all()->pluck('name', 'id');
        }else if (Auth::user()->hasRole('gerenciar_equipe')){
            $proprietarios = User::where('equipe_id', $equipe->id)->pluck('name', 'id');
        }

        $motivos = MotivoPerda::all();



        if ($view == 'list') {

            if ( !$negocios->first()){
                return view('negocios/list', compact('funils', 'etapa_funils','curr_funil_id','users','proprietarios','proprietario','motivos'));
            }  
    
            return view('negocios/list', compact('funils', 'etapa_funils', 'negocios','curr_funil_id','users','proprietarios','proprietario','motivos'));
        }else {

            if ( !$negocios->first()){
                return view('negocios/pipeline', compact('funils', 'etapa_funils','curr_funil_id','users','proprietarios','proprietario','motivos'));
            }  
            return view('negocios/pipeline', compact('funils', 'etapa_funils', 'negocios','curr_funil_id','users','proprietarios','proprietario','motivos'));
        }
        
    }


    public function add_negocio(Request $request)
    {

        $input = $request->all();

        $deal_input = array();
        $deal_input['titulo'] = $input['titulo'];
        $deal_input['valor'] = $valor = str_replace('.','',$input['valor'] ) ; //trim($input['valor'], ".");
        $deal_input['fechamento'] = $input['fechamento'];
        $deal_input['funil_id'] = $input['funil_id'];
        $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];

        $lead_input = array();
        $lead_input['nome'] = $input['nome_lead'];
        $lead_input['telefone'] = $input['tel_lead'];
        $lead_input['whatsapp'] = $input['whats_lead'];


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

        //Validando Negocios
        $rules = [
            'titulo' => 'required',
        ];
        $error_msg = [
            'titulo.required' => 'Titulo é obrigatório',
        ];
        $validator = Validator::make($deal_input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validado, hora de criar o lead para associar ao negocio
        $lead = new Lead();
        $lead->nome = $lead_input['nome'];
        $lead->telefone = $lead_input['telefone'];
        $lead->whatsapp = $lead_input['whatsapp'];
        $lead->save();

        // associando lead ao negócio
        $deal_input['lead_id'] = $lead->id;

        $deal_input['user_id'] = \Auth::user()->id;

        //criando o negócio
        Negocio::create($deal_input);


        return back()->with('status', "Negócio " . $deal_input['titulo'] . " Criado com Sucesso");
    }

    

    public function drag_update(Request $request)
    {
        $negocio_id = $request['info'][0];
        $target_etapa_id = $request['info'][2];

        $etapa = EtapaFunil::find($target_etapa_id);
        $etapa_id = $etapa->id;

        $negocio = Negocio::find($negocio_id);
        $negocio->etapa_funil_id = $etapa_id;

        $negocio->save();

        Atividade::add_atividade(\Auth::user()->id, "Negócio foi motivo para ".$etapa->nome, $negocio_id );

        $name = $negocio->lead->nome;

        return [$name];
    }

    public function inserir_comentario(Request $request)
    {

        $input = $request->all();

        //Validando Negocios
        $rules = [
            'comentario' => 'required',
        ];
        $error_msg = [
            'comentario.required' => 'Não é possível salvar comentário vazio',
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $comentario = new NegocioComentario();
        $comentario->comentario = $input['comentario'];
        $comentario->user_id = $input['user_id'];
        $comentario->negocio_id = $input['negocio_id'];
        $comentario->save();

        return back()->with('status', "Comentário adicionado com successo");
    }


    public function massive_change(Request $request){


        $input = $request->all();

        $curr_funil_id = intval( $input['id']) ;
        $pipeline = Funil::where('id', $curr_funil_id)->get();

        $etapa_funils = $pipeline->first()->etapa_funils()->pluck('ordem', 'id')->toArray();
        ksort($etapa_funils);
        
        if ($input['modo'] == "atribuir"){

            

            $negocios = $input['negocios'];
            $novo_proprietario_id = $input['novo_proprietario_id'];

            $negocios = Negocio::whereIn('id', $negocios)->get();

            $novo_proprietario = NULL;

            $nome_destino = "Não Atribuido";
            if ($novo_proprietario_id != "-1"){
                $proprietario = User::find($novo_proprietario_id);
                $novo_proprietario = $proprietario->id;
                $nome_destino = $proprietario->name;
            }

            $count = 0;
            foreach ($negocios as $negocio) {
                $negocio->user_id = $novo_proprietario;
                $negocio->etapa_funil_id = $etapa_funils[1];
                $negocio->save();
                $count = $count + 1;
                
                if ($novo_proprietario){
                    
                    Atividade::add_atividade(\Auth::user()->id, "Cliente Atribuido a ".User::find($novo_proprietario)->name, $negocio->id);
                }else {
                    Atividade::add_atividade(\Auth::user()->id, "Cliente colocado como não atribuido", $negocio->id);
                }
                
            }

            

            return back()->with('status', "Enviados ".$count." negócios transferidos para ".$nome_destino);

        }elseif($input['modo'] == "distribuir"){

            $usuarios = $input['usuarios'];
            $user_count = count($usuarios);
            $negocio_count = count($input['negocios']);

            $negocios = $input['negocios'];
            $negocios = Negocio::whereIn('id', $negocios)->get();

            $user_count_dist = 0;

            foreach ($negocios as $negocio){

                $negocio->user_id = $usuarios[$user_count_dist];
                $negocio->etapa_funil_id = $etapa_funils[1];
                $negocio->save();

                Atividade::add_atividade(\Auth::user()->id, "Cliente Distribuido para ".User::find($negocio->user_id)->name, $negocio->id);

                //$negocio->save();
                if ($user_count_dist + 1 == $user_count){
                    $user_count_dist = 0;
                }else{
                    $user_count_dist = $user_count_dist + 1;
                }
            }
            return back()->with('status', "Distribuidos ".$negocio_count." negócios para ".$user_count." usuários.");
        }else {
            return back()->withErrors("modo de distribuição invalido: ".$input['modo']);
        }
    }
}