<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Agendamento;
use App\Models\Atividade;
use App\Models\User;
use App\Models\Equipe;
use Auth;
use App\Enums\UserStatus;
class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        return view('negocios.calendario');
    }

    public function lista(Request $request)
    {
        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        

        $agendado = $request->query('agendado');

        if ( is_null($data_inicio) and is_null($data_fim) ){

            $dia = intval ( Carbon::now('America/Sao_Paulo')->subMonth(1)->format('d') );
            if ( $dia <= 20){
                $data_inicio = "20/".(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
            }else {
                $data_inicio = "20/".(Carbon::now('America/Sao_Paulo')->format('m/Y'));
            }
            
            $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }

    
        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y',$data_fim)->format('Y-m-d');
        

        $query = [];

        if (  $agendado ){
            if ( $agendado == "em"){
                $query = [
                    ['data_agendamento', '>=', $from ],
                    ['data_agendamento', '<=', $to],
                ];
            }else {
                $query = [
                    ['data_agendado', '>=', $from ],
                    ['data_agendado', '<=', $to],
                ];
            }
        }

       
        
        $agendamentos = Agendamento::where($query)->get();
        return view('negocios.agendamentos', compact('agendamentos'));
    }

    public function calendario(Request $request)
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

        if ( $proprietario_id == -2 and $equipe_exists == 1 ){
            $agendamentos = Agendamento::all();
        }else if ($proprietario_id == -2 and $equipe_exists == -1){
            $ids = $equipe->integrantes()->pluck('id')->toArray();
            $agendamentos = Agendamento::whereIn('user_id', $ids)->get();
        }else {
            $agendamentos = Agendamento::where('user_id',$proprietario_id)->get();
        }
        
        $calendario = array();
        foreach ($agendamentos as $agendamento) {
            
            $cal = array();
            $cal['title'] = "Reunião com ".$agendamento->negocio->lead->nome.' ('.$agendamento->negocio->titulo.')';
            $cal['start'] = $agendamento['data_agendado']."T".$agendamento['hora'].":00";
            
            if ( $proprietario_id == -2 ){
                $start = $cal['title'];
                $cal['title'] = "[".$agendamento->negocio->user->name."]".$start;
            }

            $cal['negocio'] = $agendamento->negocio->lead->nome;
            $now =  Carbon::now('America/Sao_Paulo')->format('Y-m-d');
            $agendado = $agendamento['data_agendado'];

            if ( $agendado < $now ){
                $cal['className'] = "bg-danger";
            }elseif ($now == $agendado){
                $cal['className'] = "bg-warning";
            }else {
                $cal['className'] = "bg-success";
            }
            
           
            $cal['href'] = route('negocio_edit', array('id' => $agendamento->negocio->id ) );

            array_push( $calendario, $cal );
        }

        $proprietarios = NULL;
        if ( Auth::user()->hasRole('admin')){
            $proprietarios = User::where('status',UserStatus::ativo)->pluck('name', 'id');
        }else if (Auth::user()->hasRole('gerenciar_equipe')){
            $proprietarios = User::where(['equipe_id'=> $equipe->id, 'status'=>UserStatus::ativo])->pluck('name', 'id');
        }

        return view('negocios.calendario', compact('calendario','proprietarios','proprietario'));
    }


    public function add(Request $request)
    {
        $input = $request->all();

        $data_agendado = Carbon::createFromFormat('d/m/Y',$input['data_agendado'])->format('Y-m-d');
        $data_agendamento = Carbon::now()->format('Y-m-d');
        $hora = $input['hora_agendado'];

        $negocio_id = $input['negocio_id'];
        $proprietario_id = $input['proprietario_id'];
        
        $query = [
            ['negocio_id', '=', $negocio_id ],
            ['user_id', '=', $proprietario_id],
        ];

        $agendamento = Agendamento::where($query)->first();

        if ( !$agendamento ){

            $agendamento = new Agendamento();
            $agendamento->data_agendado = $data_agendado;
            $agendamento->data_agendamento = $data_agendamento;
            $agendamento->hora = $hora;
            $agendamento->negocio_id = $negocio_id;
            $agendamento->user_id = $proprietario_id;
            $agendamento->save();

            Atividade::add_atividade(\Auth::user()->id, "Agendamento adicionado para ".$agendamento->data_agendamento, $negocio_id );

            
        }else {

            
            $agendamento->data_agendado = $data_agendado;
            $agendamento->data_agendamento = $data_agendamento;
            $agendamento->hora = $hora;
            $agendamento->negocio_id = $negocio_id;
            $agendamento->user_id = $proprietario_id;
            $agendamento->save();

            Atividade::add_atividade(\Auth::user()->id, "Reagendamento feito para ".$agendamento->data_agendamento, $negocio_id );
        }

        $weekMap = [
            0 => 'Domingo',
            1 => 'Segunda',
            2 => 'Terça',
            3 => 'Quarta',
            4 => 'Quinta',
            5 => 'Sexta',
            6 => 'Sábado',
        ];
        $dayOfTheWeek = Carbon::createFromFormat('d/m/Y',$input['data_agendado'])->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        
        return [ Carbon::createFromFormat('d/m/Y',$input['data_agendado'])->format('d/m/Y') , $hora,  $weekday, $agendamento->negocio->lead->nome];
    }
}
