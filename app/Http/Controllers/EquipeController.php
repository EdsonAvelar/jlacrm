<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class EquipeController extends Controller
{
    public function index()
    {

        $equipes = Equipe::all();
        $semequipes = (new User())->vendedores_sem_equipes();

        $users = (new User())->vendedores();

        return view('equipes.index', compact('equipes', 'semequipes', 'users'));
    }


    public function equipe_get(Request $request)
    {

        $id = $request->query('id');
        $equipe = Equipe::find($id);

        $lider = $equipe->lider_id;

        $user = User::find($equipe->lider_id);

        return [$equipe->id, $equipe->nome, $user->name, $equipe->descricao, $equipe->logo];
    }

    public function change_image(Request $request)
    {
        $input = $request->all();


        $equipe = Equipe::find($input['editar_equipe_id']);
        if ($request->hasFile('image')) {
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
            );

            $error_msg = [
                'image.max' => 'Limite Máximo do Arquivo 3mb',
                'image.mimes' => 'extensões válidas (jpg,png,jpeg,gif,svg)'
            ];

            $validator = Validator::make($input, $rules, $error_msg);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $imageName = "logo." . $request->image->extension();
            $request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);
            $equipe->logo = $imageName;
        }


        $equipe->save();

        return back()->with("status", "Equipe Editada com sucesso");
    }


    public function change_equipe(Request $request)
    {

        $input = $request->all();


        $equipe = Equipe::find($input['editar_equipe_id']);
        if ($request->has('lider_id')) {

            if ($input['lider_id'] != '') {

                $antigolider = User::find($equipe->lider_id);
                User::where('id', $antigolider->id)->update(['equipe_id' => NULL]);

                $novolider = User::find($input['lider_id']);
                $equipe->lider_id = $novolider->id;

                User::where('id', $novolider->id)->update(['equipe_id' => $equipe->id]);
            }
        }

        $nome_equipe = $input['edit_nome_equipe'];
        $equipe->descricao = $nome_equipe;


        $nome_equipe = strtolower(trim(preg_replace("/[^A-Za-z0-9]/", '_', $nome_equipe)));
        $equipe->nome = $nome_equipe;

        if ($request->hasFile('image')) {
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
            );

            $error_msg = [
                'image.max' => 'Limite Máximo do Arquivo 3mb',
                'image.mimes' => 'extensões válidas (jpg,png,jpeg,gif,svg)'
            ];

            $validator = Validator::make($input, $rules, $error_msg);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $imageName = "logo." . $request->image->extension();
            $request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);
            $equipe->logo = $imageName;
        }


        $equipe->save();

        return back()->with("status", "Equipe Editada com sucesso");
    }

    public function create(Request $request)
    {

        $input = $request->all();

        $rules = array(
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        );

        $error_msg = [
            'image.required' => 'Imagem é Obrigatório',
            'image.max' => 'Limite Máximo do Arquivo 3mb',
            'image.mimes' => 'extensões válidas (jpg,jpeg,png,jpeg,gif,svg)'
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $equipe = new Equipe();
        $nome_equipe = $input['nome_equipe'];

        $equipe->descricao = $nome_equipe;

        $nome_equipe = strtolower(trim(preg_replace("/[^A-Za-z0-9]/", '_', $nome_equipe)));

        $equipe->nome = $nome_equipe;

        $equipe->lider_id = $input['lider_id'];

        $imageName = "logo." . $request->image->extension();


        $equipe->logo = $imageName;
        $equipe->save();

        $request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);

        User::where('id', $input['lider_id'])->update(['equipe_id' => $equipe->id]);

        return back()->with("status", "Equipe Criada com sucesso");
    }

    public function excluir(Request $res)
    {
        $input = $res->input();
        $equipe = Equipe::find($input['excluir_equipe_id']);

        $exists_int = false;
        foreach ($equipe->integrantes()->get() as $integrante) {
            if ($integrante->id != $equipe->lider_id) {
                $exists_int = true;
                break;
            }
        }

        if ($exists_int) {
            return back()->withErrors("Retire os Integrantes antes de deletar uma equipe");
        }

        User::where('id', $equipe->lider_id)->update(['equipe_id' => NULL]);
        $equipe->delete();

        return back()->with("status", "Equipe Excluida com sucesso");
    }
    public function drag_update(Request $res)
    {

        $input = $res->input();
        $id_funcionario = $input['info'][0];
        $id_origem = $input['info'][1];
        $id_destino = $input['info'][2];

        $funcionario = User::find($id_funcionario);

        if ($id_destino > 0) {
            $funcionario::where('id', $id_funcionario)->update(['equipe_id' => $id_destino]);
        } else {
            $funcionario::where('id', $id_funcionario)->update(['equipe_id' => NULL]);
        }

    }
}
