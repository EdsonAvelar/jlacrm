<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserStatus;

class FuncionarioController extends Controller
{
    public function index(Request $req)
    {
        $users = User::where('status', 1)->get();

        return view('users.funcionarios', compact('users'));
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['avatar'] = 'user-padrao.png';
        $input['password'] = \Hash::make($input['password'] );
        $input['status'] = UserStatus::ativo;

        User::create($input);

        return back()->with("status","Funcionario adicionado com sucesso");
    }
}
