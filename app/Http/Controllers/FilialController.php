<?php
namespace App\Http\Controllers;

use App\Models\Filial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilialController extends Controller
{
    public function index()
    {
        return response()->json(Filial::all());
    }

    public function config()
    {

        $filiais = Filial::all();
        return view('filiais.config', compact('filiais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'url' => 'required|unique:filials',
            'token' => 'required|string',
            'endereco' => 'string|max:255',
            'cidade' => 'string|max:255',
            'estado' => 'string|max:255',
            'telefone' => 'nullable|string|max:20',
        ]);

        $filial = Filial::create($request->all());

        return response()->json($filial, 201);
    }

    public function show(Filial $filial)
    {
        return response()->json($filial);
    }

    public function update(Request $request, Filial $filial)
    {
        $request->validate([
            'nome' => 'string|max:255',
            'url' => 'url|unique:filiais,url,' . $filial->id,
            'token' => 'string',
            'endereco' => 'string|max:255',
            'cidade' => 'string|max:255',
            'estado' => 'string|max:255',
            'telefone' => 'nullable|string|max:20',
        ]);

        $filial->update($request->all());

        return response()->json($filial);
    }

    public function destroy($id)
    {


        $filial = Filial::find($id);

        if (!$filial) {
            return response()->json(['message' => 'Filial não encontrada'], 404);
        }



        $filial->delete();

        return response()->json(['message' => 'Filial removida com sucesso']);
    }

    /**
     * Método para fazer requisição REST na URL da filial
     */
    public function obterDadosFilial(Filial $filial)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $filial->token,
        ])->get($filial->url);

        return response()->json($response->json());
    }
}
