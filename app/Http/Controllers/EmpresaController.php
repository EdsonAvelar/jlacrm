<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Equipe;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function empresa_profile(Request $request)
    {

        $id = $request->query('id');

        $user = User::find($id);

        $equipes = Equipe::all();

        $roles = Role::all();

        $empresa__ = Empresa::all();
        $empresa =  array();
        foreach (Empresa::all() as $empresa__) {
           $empresa[$empresa__->settings] =$empresa__->value;
        }


        if ( Auth::user()->id == $id or Auth::user()->hasAnyRole(['gerente','gerenciar_funcionarios']) ){
            return view('empresa.profile', compact('user','equipes','roles','empresa'));
        }else {
            return abort(401);
        }
        
    }

    public function save(Request $request){

        $inputs = $request->except('_token');

        $settings = array();

        foreach ($inputs as $key => $value) {
           
           if ( !empty($value)){

            $empresa = Empresa::where('settings',$key )->first();

            // Make sure you've got the Page model
            if( $empresa) {
                $empresa->value = $value;
                $empresa->save();
            }else {
                $empresa =  new Empresa();
                $empresa->settings = $key;
                $empresa->value = $value;
                $empresa->save();
            }
           }

        }
        return back()->with('status','Informações Atualizadas com Sucesso');
    }
}
