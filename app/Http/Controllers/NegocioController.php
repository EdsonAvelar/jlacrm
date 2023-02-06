<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\NegocioImportado;
use App\Models\Negocio;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class NegocioController extends Controller
{
    public function importar_index()
    {
        $negocios_importados = NegocioImportado::all();

        $users = User::all();

        return view('negocios/importar', compact('negocios_importados','users'));

       
    }

    public function importar_upload(Request $request)
    {

        $input = $request->all();
        $rules = array(
            'upload_file' => 'required|max:3000',
        );

        $error_msg = [
            'upload_file.required' => 'Arquivo Obrigatório',
            'upload_file.max' => 'Limite Máximo do Arquivo 3mb',
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $path = storage_path() . '/app/' . request()->file('upload_file')->store('tmp');
        $lines = array();

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $reader->setInputEncoding('UTF-8');
        $reader->setDelimiter(',');
        $reader->setEnclosure('');
        $reader->setSheetIndex(0);

        $spreadsheet = $reader->load($path);

        $sheet = $spreadsheet->getActiveSheet();

        $worksheetinfo = $reader->listWorksheetInfo($path);
        $totalRows = $worksheetinfo[0]['totalRows'];

        $import_data = array();
        for ($row = 1; $row <= $totalRows; $row++) {
            $nome = $sheet->getCell("M{$row}")->getValue();
            $telefone = $sheet->getCell("N{$row}")->getValue();
            $email = $sheet->getCell("O{$row}")->getValue();
            $campanha = $sheet->getCell("H{$row}")->getValue();
            $fonte = $sheet->getCell("L{$row}")->getValue();
            $create_time = $sheet->getCell("B{$row}")->getValue();

            //pula o cabeçalho
            if ($row > 1) {
                $import_data[] = [
                    "nome" => $nome,
                    "telefone" => $telefone,
                    "email" => $email,
                    "campanha" => $campanha,
                    "fonte" => $fonte,
                    "data_conversao" => $create_time
                ];
            }
        }

        if (sizeof($import_data) > 0) {
            try {

                DB::table('negocio_importados')->insert($import_data);
            } catch (\Illuminate\Database\QueryException  $ex) {
                //não faz literalmente nada
            }

        }

        return back()->with('status','upload realizado com sucesso');
    }


    public function negocio_edit(Request $request) {
        $id = $request->query('id');
        $negocio = Negocio::find($id);
        

         return view('negocios.edit', compact('negocio') );
    }

    public function negocio_get(Request $request) {

        $id = $request->query('id');
        $negocio = Negocio::where('id',$id)->get();

        $lead = Negocio::where('id',$id)->first()->lead()->get();


        return [$negocio[0], $lead[0]];
    }

    


    public function import_atribuir(Request $request)
    {

        $input = request()->all();

        
        $neg_importados = NegocioImportado::whereIn('id', $input['negocios_importados'] )->get();

        $import_data = array();
        foreach ($neg_importados as $neg) {
           
            $lead = new Lead();
            $lead->nome = $neg->nome;
            $lead->telefone = $neg->telefone;
            $lead->email = $neg->email;
            $lead->fonte = $neg->fonte;
            $lead->campanha = $neg->campanha;
            $lead->data_conversao = $neg->data_conversao;
             $lead->save();

            $deal_input = array();
            $deal_input['titulo'] = "Negócio com ".$neg->nome;
            $deal_input['valor'] = 0;
            $deal_input['funil_id'] = $input['funil_id'];
            $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];

            $deal_input['lead_id'] = $lead->id;
            $deal_input['user_id'] = $input['novo_proprietario_id'];

            Negocio::create($deal_input);
        }

        if (sizeof($import_data) > 0) {
            try {
                DB::table('negocios')->insert($import_data);
            } catch (\Illuminate\Database\QueryException  $ex) {
                //não faz literalmente nada
            }

        }

        return back()->with('status',  "Negocios atribuidos com sucesso");
    }
}