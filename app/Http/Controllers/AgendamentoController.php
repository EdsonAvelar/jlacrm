<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {

        return "Agendamento View";
    }

    public function add(Request $request)
    {
        $input = $request->all();

        return back()->with('status', 'Agendamento realizado com sucesso');
    }
}
