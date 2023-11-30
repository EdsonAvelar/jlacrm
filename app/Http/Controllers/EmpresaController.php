<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Equipe;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
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
    
    public function empresa_config(Request $request){


        $input = $request->except('_token');

        $config_name = $input['info'][0];
        $config_value = $input['info'][1];
           

        $empresa = Empresa::where('settings', $config_name )->first();

        // Make sure you've got the Page model
        if( $empresa) {
            $empresa->value =$config_value;
            $empresa->save();
        }else {
            $empresa =  new Empresa();
            $empresa->settings = $config_name;
            $empresa->value = $config_value;
            $empresa->save();
        }
        
        return "Configuração atualizada com sucesso";
      

    }

    public function empresa_images(Request $request){
        
        $input = $request->all();

        $rules = array(
            'image' => 'required|mimes:png,ico|max:2048',
        );

        $error_msg = [
            'image.required' => 'Imagem é Obrigatório',
            'image.max' => 'Limite Máximo do Arquivo 2mb',
            'image.mimes' => 'extensões válidas (png,ico)'
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }



        $pasta_imagem = $input['pasta_imagem'];
        $imagem_name = $input['imagem_name'];


        $destino = public_path('images')."/empresa/".$pasta_imagem."";

        $request->image->move($destino, $imagem_name);


        return back()->with("status", "Imagem salva com sucesso");
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
