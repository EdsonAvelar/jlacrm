<?php

namespace App\Http\Controllers;

use App\Models\EtapaFunil;
use Illuminate\Http\Request;
use Validator;

use App\Models\NegocioImportado;
use App\Models\Negocio;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use App\Models\Proposta;
use App\Models\Reuniao;
use App\Models\Agendamento;
use App\Models\Aprovacao;

use Carbon\Carbon;
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

    public function simulacao(Request $request){
       
        $negocio_id = $request->query('negocio_id');
        $negocio = Negocio::where('id',$negocio_id)->first();
        
        $etapa = EtapaFunil::find($negocio->etapa_funil_id)->nome;

        //$negocio->etapa_funil_id'

        if ($etapa == "REUNIAO"){
            return view('negocios.simulacao',compact('negocio'));
        }else {
            return back()->withErrors("Cliente precisa estar na etapa REUNIAO para gerar propostas");
        }
        
    }

    public function criar_proposta(Request $request){

        $input = $request->all();
        
        $tipo = $input["tipo"];
        $con_parcelas =  $input['con-parcelas'];

        if ($request->has('reduzido')){

            $subs = array("R","$",".");
            $valor_reduzido = floatval( str_replace($subs,"",$input['con-parcelas']))*70/100;
            
            $con_parcelas = "R$ ".number_format($valor_reduzido,2);
            $input['reduzido'] = 's';
        }else{
            $input['reduzido'] = 'n';
        }

        $con_entrada = $input['con-entrada'];
        $embutidas = intval( $input['parcelas_embutidas']);
        if ( $embutidas > 0 ){
            
            
            $subs = array("R","$",".");
            $valor_entrada = floatval( str_replace($subs,"",$input['con-entrada']));

            $valor_parcela = floatval( str_replace($subs,"",$input['con-parcelas'])) * $embutidas;

            $con_entrada = "R$ ".number_format($valor_entrada+ $valor_parcela,2);
        
        }

        
        $proposta = new Proposta();
        $proposta['tipo'] = $input['tipo'];
        $proposta['banco'] = $input['banco'];
        $proposta['credito'] = $input['credito'];
        $proposta['fin-entrada'] = $input['fin-entrada'];
        $proposta['fin-parcelas'] = $input['fin-parcelas'];
        $proposta['fin-prazo'] = $input['fin-prazo'];
        $proposta['fin-rendaexigida'] = $input['fin-rendaexigida'];
        $proposta['cartorio'] = $input['cartorio'];
        $proposta['fin-juros-pagos'] = $input['fin-juros-pagos'];
        $proposta['val-pago-total'] = $input['val-pago-total'];
        $proposta['con-entrada'] = $input['con-entrada'];
        $proposta['con-parcelas'] = $input['con-parcelas'];
        $proposta['con-prazo'] = $input['con-prazo'];
        $proposta['con-rendaexigida'] = $input['con-rendaexigida'];
        $proposta['con-valor-pago'] = $input['con-valor-pago'];
        $proposta['reduzido'] = $input['reduzido'];
        $proposta['parcelas_embutidas'] = $input['parcelas_embutidas'];
        $proposta['data_proposta'] = Carbon::now()->format('Y-m-d H:i:s');


        $proposta['user_id'] = \Auth::user()->id;
        $proposta['negocio_id'] = $input['negocio_id'];

        $proposta->save();
        
        return view('negocios.proposta', compact('tipo','con_parcelas','con_entrada'));
    }

    
    public function drag_update(Request $res)
    {

        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_origem = $input['info'][1];
        $id_destino = $input['info'][2];

        $negocio = Negocio::find($id_negocio);

        if ($id_destino > 0){
            $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
        }else {
            $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
        }

    }

    public function add_reuniao(Request $res)
    {
        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_destino = $input['info'][2];
        
        $agendamento = Agendamento::where('negocio_id',$id_negocio)->first();
        
        if ( $agendamento){

            $reuniao = new Reuniao();
            $reuniao->agendamento_id = $agendamento->id;
            $reuniao->user_id = \Auth::user()->id;
            $reuniao->data_reuniao = Carbon::now()->format('Y-m-d H:i:s');
            $reuniao->save(); 

            $negocio = Negocio::find($id_negocio);
            if ($id_destino > 0){
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
            }else {
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
            }

        }
        
    }

    public function add_aprovacao(Request $res){
        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_destino = $input['info'][2];
        
        $negocio = Negocio::find($id_negocio);

        if ( $negocio ){
            $aprovacao = new Aprovacao();
            $aprovacao->data_aprovacao = Carbon::now()->format('Y-m-d H:i:s');
            $aprovacao->negocio_id =  $negocio->id;
            $aprovacao->user_id = \Auth::user()->id;

            $aprovacao->save();

            if ($id_destino > 0){
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
            }else {
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
            }
        }
    }
}