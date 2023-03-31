<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Agendamento;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {

        return "Agendamento View";
    }

    public function add(Request $request)
    {
        $input = $request->all();

        $data_agendado = Carbon::createFromFormat('d/m/Y',$input['data_agendado'])->format('Y-m-d');
        $data_agendamento = Carbon::createFromFormat('d/m/Y',$input['data_agendamento'])->format('Y-m-d');
        $hora = $input['hora_agendado'];


        $negocio_id = $input['negocio_id'];
        $proprietario_id = $input['proprietario_id'];

        
        $agendamento = new Agendamento();
        $agendamento->data_agendado = $data_agendado;
        $agendamento->data_agendamento = $data_agendamento;
        $agendamento->hora = $hora;
        $agendamento->negocio_id = $negocio_id;
        $agendamento->user_id = $proprietario_id;
        $agendamento->save();



        return back()->with('status', 'Agendamento de realizado com sucesso');
    }
}
