<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Equipe;
use App\Models\Role;
use Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index(){

        return view('index');
    }
    

    public function login(Request  $req){

        $submit = $req['submit'];

        if ($submit == "submit") {
            
            $req->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            if(Auth::attempt($req->only('email','password'))){

                if (Auth::User()->status == UserStatus::ativo){
                    return redirect('/crm');
                }else {
                    return redirect('/login')->withError('Usuário está inativo');
                }
               
            }else{
                return redirect('/login')->withError('Email ou senha incorreto');
            }

        }
        return view('login');
    }

    public function changePassword()
    {
    return view('users.change-password');
    }

    public function updatePassword(Request $request)
{
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Login ou senha inválidas!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Senha Atualizada com sucesso!");
}
 
    public function logout(){
        Session::flush();
        Auth::logout();
        
        return redirect('/login');
    }


    public function profile(Request $request){

        $id = $request->query('id');

        $user = User::find($id);

        $equipes = Equipe::all();

        $roles = Role::all();

        if ( Auth::user()->id == $id or Auth::user()->hasAnyRole(['gerente','gerenciar_funcionarios']) ){
            return view('users.profile', compact('user','equipes','roles'));
        }else {
            return abort(401);
        }
    }

    public function add_permissao(Request $request){

        $input = $request->all();

        $user = User::find( $input['user_id']);

        $role = Role::find($input['role_id']);

        if ( is_null( $role ) ){
            return back()->withErrors("Permissão não selecionada");
        }

        if ( $user->hasRole($role->name) ){
            return back()->withErrors("Usuário já possui essa permissão");
        }

        $user->roles()->attach($role);       
        return back()->with("status", "Permissao adicionada com sucesso");
    }


    public function del_permissao(Request $request){

        $input = $request->all();

        $user = User::find( $input['user_id']);

        $role = Role::find($input['delete_id']);

        $user->roles()->detach($role);

        return back()->with("status", "Permissao removida com sucesso");
    }


    public function avatar_edit(Request $request){
        
        $input = $request->all();

        $rules = array(
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        );

        $error_msg = [
            'image.required' => 'Imagem é Obrigatório',
            'image.max' => 'Limite Máximo do Arquivo 3mb',
            'image.mimes' => 'extensões válidas (jpg,png,jpeg,gif,svg)'
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find( $input['user_id']);

        $imageName = 'avatar.'.$request->image->extension();  

        $request->image->move(public_path('images')."/users/user_".$user->id."", $imageName);


        $user->avatar = $imageName;
        $user->save();
        return back()->with("status", "Imagem salva com sucesso");
    }
}
