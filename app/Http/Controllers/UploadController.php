<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Upload;
use App\Models\Atividade;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // máximo 10MB (10240 kilobytes)
            'description' => 'nullable|string'
        ], [
            'file.max' => 'O arquivo é muito grande. O limite é de 10MB.'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $fileSize = $file->getSize(); // em bytes

        // Armazena o arquivo usando o disco 'protected'
        $path = $file->store('uploads', 'protected');

        $upload = new Upload();
        $upload->negocio_id = $request->input('negocio_id');
        $upload->file_name = $fileName;
        // aqui salvamos o path relativo dentro do disco protegido
        $upload->file_path = $path;
        $upload->extension = $extension;
        $upload->file_size = $fileSize;
        $upload->description = $request->input('description');
        $upload->save();


        Atividade::add_atividade(\Auth::user()->id, "Arquivo " . $upload->file_name . " ( " . $upload->description . ") " . "foi adicionado", $upload->negocio_id);


        return back()->with('success', 'Arquivo enviado com sucesso!')->with('aba', "#upload");

    }

    public function destroy($id)
    {
        $upload = Upload::findOrFail($id);

        // Deleta o arquivo no disco 'protected'
        Storage::disk('protected')->delete($upload->file_path);

        $upload->delete();

        Atividade::add_atividade(\Auth::user()->id, "Arquivo " . $upload->file_name . " ( " . $upload->description . ") " . "foi deletado", $upload->negocio_id);


        return back()->with('success', 'Arquivo deletado com sucesso!');
    }

    public function download($id)
    {
        $upload = Upload::findOrFail($id);


        // Aqui você pode adicionar lógica de autorização se desejar.
        return Storage::disk('protected')->download($upload->file_path, $upload->file_name);
    }

    public function preview($id)
    {
        $upload = Upload::findOrFail($id);
        // Obtém o caminho absoluto do arquivo no disco protegido
        $path = Storage::disk('protected')->path($upload->file_path);

        // Retorna o arquivo com os headers apropriados
        return response()->file($path);
    }
}