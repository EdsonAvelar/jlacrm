<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    public function index(Request $req)
    {
        $users = User::all();
        #$inative_users = User::where('status', UserStatus::inativo)->get();

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

    
    public function user_edit(Request $request){
        $input = $request->all();

        $user = User::find($input['user_id'])->update(['cargo_id'=>$input['cargo_id']]);
       

        return back()->with("status", "Usuário Atualizado com sucesso!");
    }
    
    public function ativar_desativar(Request $request)
    {

        $input = $request->except('_token');

        $status = $input['info'][0];
        $user_id = $input['info'][1];
        
        $user = User::find($user_id);

        if ($status == "false"){
            $res = $user->update(['status'=> UserStatus::inativo]);
            return "Status de ".$user->name." desativado com sucesso: id=".$res;
        }else {

            $res = $user->update(['status'=> UserStatus::ativo, 'password' =>  Hash::make('jla2021') ]);
            return "".$user->name." foi ativado com sucesso: id=".$res;
        }
    }
}
