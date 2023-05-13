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

            $cal['className'] = "bg-success";

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

    public function calendario2(Request $request)
    {
        $proprietario_id = $request->query('proprietario');
        $proprietario = User::find($proprietario_id);

       
        $calendario = array();

        $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

        $proprietarios = NULL;
        if ( Auth::user()->hasRole('admin')){
            $proprietarios = User::all()->pluck('name', 'id');
        }else if (Auth::user()->hasRole('gerenciar_equipe')){
            $proprietarios = User::where('equipe_id', $equipe->id)->pluck('name', 'id');
        }else {
            $proprietarios = User::where('id',$proprietario_id)->pluck('name', 'id');
        }

        if ($proprietario_id == -2){

           
            $agen_prop = User::all()->pluck('name','id');
           
           
        }else {
            $agen_prop = User::where('id',$proprietario_id)->pluck('name', 'id');
        }
        
        $props = array_keys($agen_prop->toArray());
        $agendamentos = Agendamento::whereIn('user_id',$props)->get();
        
        foreach ($agendamentos as $agendamento) {
            
            $cal = array();
            $cal['title'] = "Reunião com ".$agendamento->negocio->lead->nome.' ('.$agendamento->negocio->titulo.')';
            $cal['start'] = $agendamento['data_agendamento']."T".$agendamento['hora'].":00";

            try {
                $end = Carbon::createFromFormat('H:i', $agendamento['hora'])->addMinutes(45)->format('H:i:s');
            }catch(Exception $e){
                $end = $cal['start'];
            }

            //$cal['url'] = $agendamento['data_agendamento']."T".$end;
            $cal['end'] = $agendamento['data_agendamento']."T".$end;
            $cal['className'] = "bg-success";

            array_push( $calendario, $cal );
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

        /*
        $agendamento = Agendamento::firstOrCreate(
            ['data_agendado' =>  $data_agendado],
            ['data_agendamento' => $data_agendamento],
            ['hora' => $hora],
            ['negocio_id' => $data_agendamento],
            ['user_id' => $proprietario_id],
        );*/

        
        $query = [
            ['negocio_id', '=', $negocio_id ],
            ['user_id', '=', $proprietario_id],
            ['data_agendado', '=', $data_agendado]
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

            return "Agendamento de realizado com sucesso";
        }else {

            
            $agendamento->data_agendado = $data_agendado;
            $agendamento->data_agendamento = $data_agendamento;
            $agendamento->hora = $hora;
            $agendamento->negocio_id = $negocio_id;
            $agendamento->user_id = $proprietario_id;
            $agendamento->save();

            return "Agendamento desse cliente já realizado";
        }

        /*
        $agendamento = new Agendamento();
        $agendamento->data_agendado = $data_agendado;
        $agendamento->data_agendamento = $data_agendamento;
        $agendamento->hora = $hora;
        $agendamento->negocio_id = $negocio_id;
        $agendamento->user_id = $proprietario_id;
        $agendamento->save();
        */

    }
}
