<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Hash;
use App\Models\Cargo;
use App\Models\Role;

class FuncionarioController extends Controller
{
    public function index(Request $req)
    {
        $users_ativo = User::where('status', UserStatus::ativo)->get();
        $users_inativo = User::where('status', UserStatus::inativo)->get();

        return view('users.funcionarios', compact('users_ativo', 'users_inativo'));
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
   
        
        $avatar = url("") . "/images/sistema/user-padrao.png";
        
        $input['avatar'] = $avatar;

        $input['password'] = \Hash::make($input['password']);
        $input['status'] = UserStatus::ativo;

        $user = User::create($input);

        $coordenador_id = Cargo::where(['nome' => 'Coordenador'])->first()->id;
        if ($coordenador_id == $input['cargo_id']) {

            $role = Role::where('name', 'gerenciar_equipe')->first();
            $user->roles()->attach($role);
        }

        return back()->with("status", "Funcionario adicionado com sucesso");
    }


    public function user_edit(Request $request)
    {
        $input = $request->all();

        $nome = $input['nome'];
        $password = $input['password'];
        $data_contratacao = $input['data_contratacao'];
        $telefone = $input['telefone'];
        $cargo_id = $input['cargo_id'];

        $user = User::find($input['user_id']);

        $coordenador_id = Cargo::where(['nome' => 'Coordenador'])->pluck('id');
        if ($coordenador_id == $cargo_id) {

            $role = Role::where('name', 'gerenciar_equipe')->first();
            $user->roles()->attach($role);
        }


        if ($password != "") {
            $user->password = Hash::make($password);
        }
        if ($cargo_id != "") {
            $user->cargo_id = $cargo_id;
        }

        if ($password != "") {
            $user->password = Hash::make($password);
        }

        if ($nome != "") {
            $user->name = $nome;
        }

        if ($data_contratacao != "") {
            $user->data_contratacao = $data_contratacao;
        }

        if ($telefone != "") {
            $user->telefone = $telefone;
        }

        $user->save();


        return back()->with("status", "Usuário Atualizado com sucesso!");
    }

    public function ativar_desativar(Request $request)
    {

        $input = $request->except('_token');

        $status = $input['info'][0];
        $user_id = $input['info'][1];

        $user = User::find($user_id);

        if ($status == "false") {
            $res = $user->update(['status' => UserStatus::inativo]);
            return "Status de " . $user->name . " desativado com sucesso: id=" . $res;
        } else {

            $res = $user->update(['status' => UserStatus::ativo, 'password' => Hash::make('mudarsenha')]);
            return "" . $user->name . " foi ativado com sucesso: id=" . $res;
        }
    }
}
