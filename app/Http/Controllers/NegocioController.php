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

use App\Models\Atividade;
use App\Models\Equipe;

use App\Enums\UserStatus;
use App\Enums\NegocioTipo;


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
        $imported = 0;
        $negocios_rejeitados = 0;

        for ($row = 2; $row <= $totalRows; $row++) {
            $nome = $sheet->getCell("A{$row}")->getValue();
            $telefone = $sheet->getCell("B{$row}")->getValue();
            $email = $sheet->getCell("C{$row}")->getValue();
            $campanha = $sheet->getCell("D{$row}")->getValue();
            $fonte = $sheet->getCell("E{$row}")->getValue();
            $create_time = Carbon::now()->format('Y-m-d');

            
            $lead = Lead::where(['telefone'=>$telefone,'nome' => $nome ] )->first();

            if ( !empty($lead) ){
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }

            $negimp = NegocioImportado::where(['telefone'=>$telefone])->first();

            if ( !empty($negimp) ){
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }

            $negocio = new NegocioImportado();
            $negocio->nome = $nome;
            $negocio->telefone = $telefone;
            $negocio->email = $email;
            $negocio->campanha =  $campanha;
            $negocio->fonte = $fonte;
            $negocio->data_conversao = $create_time;

            try {
                $negocio->save();
            }catch(QueryException  $e){
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }

            

            $imported = $imported + 1;

            //pula o cabeçalho
            // if ($row > 1) {
            //     $import_data[] = [
            //         "nome" => $nome,
            //         "telefone" => $telefone,
            //         "email" => $email,
            //         "campanha" => $campanha,
            //         "fonte" => $fonte,
            //         "data_conversao" => $create_time
            //     ];
            // }
        }

        if ($imported > 0){
            return back()->with('status', $imported.' negocios importados com sucesso. '.$negocios_rejeitados.' rejeitados por duplicidade');
        }else {
            if ($negocios_rejeitados > 0){
                return back()->withErrors('Todos foram rejeitados por duplicidade');
            }else {
                return back()->withErrors('Erro ao ler o csv. Cheque se estava no formato correto');
            }
        }



        /*
        if (sizeof($import_data) > 0) {
            try {

                DB::table('negocio_importados')->insert($import_data);
            } catch (\Illuminate\Database\QueryException  $ex) {
                //não faz literalmente nada
            }

        }

        return back()->with('status','upload realizado com sucesso');
        */
    }

    public function check_authorization($request){

        $id = $request->query('id');
        $negocio = Negocio::find($id);
        $proprietario_id = $negocio->user_id;


        $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

        $proprietario = User::find($proprietario_id);
        $equipe_proprietario = NULL;

        $equipe_exists = 1;
        if ( !empty($proprietario)){
            $equipe_proprietario = $proprietario->equipe()->first();
        }else{
            $proprietario = NULL;

            if ( $proprietario_id == -2){
                $equipe_exists = -1;
                $equipe_proprietario = -1;
            }
            
        }

        $auth_user_id = \Auth::user()->id;
        

        if ($auth_user_id != $proprietario_id) {
            if (!(\Auth::user()->hasRole('admin'))) {

                if ($equipe_proprietario == NULL) {
                    return abort(401);
                } else if (!\Auth::user()->hasRole('gerenciar_equipe')) {
                    return abort(401);
                } else if ($equipe_exists > 0 and $equipe->id != $equipe_proprietario->id) {
                    return abort(401);
                }
            }else{
                $equipe_exists = 1;
            }
        }

    }

    public function check_if_active(){

        if ( \Auth::user()->status == UserStatus::inativo){

            \Auth::logout();
            return route('login');
        }
    }

    public function negocio_edit(Request $request) {


        $this->check_if_active();      
        $this->check_authorization($request);      

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
        $negocios_criados = 0;
        $negocios_rejeitados = 0;
        foreach ($neg_importados as $neg) {

            $lead = Lead::where(['telefone'=>$neg->telefone,'nome' =>$neg->nome ] )->first();

            if ( !empty($lead) ){

                NegocioImportado::where('id',$neg->id)->delete();
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }


            $lead = new Lead();
            $lead->nome = $neg->nome;
            $lead->telefone = $neg->telefone;
            $lead->email = $neg->email;
            $lead->fonte = $neg->fonte;
            
            $lead->data_conversao = $neg->data_conversao;
            $lead->save();

            $deal_input = array();
            $deal_input['titulo'] = "Negócio com ".$neg->nome;
            $deal_input['valor'] = 0;
            $deal_input['funil_id'] = $input['funil_id'];
            $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];
            $deal_input['tipo'] = $neg->campanha;
            $deal_input['lead_id'] = $lead->id;
            $deal_input['user_id'] = $input['novo_proprietario_id'];

            $negocio = Negocio::create($deal_input);

            NegocioImportado::where('id',$neg->id)->delete();
            $negocios_criados = $negocios_criados + 1;

            Atividade::add_atividade(\Auth::user()->id, "Cliente do ".$lead->fonte." de ".$neg->campanha." importado via arquivo", $negocio->id );

            $user = User::find($input['novo_proprietario_id']);
            
            
            Atividade::add_atividade(\Auth::user()->id, "Cliente atribui a ".$user->name." por ".\Auth::user()->name, $negocio->id );
        }

        if ($negocios_criados > 0 ){
            return back()->with('status',  $negocios_criados." negocios atribuidos com sucesso.\n".$negocios_rejeitados." negocios rejeitados por duplicidade.");
        }else {
            if ($negocios_rejeitados> 0){
                return back()->withErrors($negocios_rejeitados. " rejeitado por duplicidade");
            }
            return back()->withErrors("Erro desconhecido");
        }

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
  

        if ($request->has('reduzido')){

            //$subs = array("R","$",".");
            //$valor_reduzido = floatval( str_replace($subs,"",$input['con-parcelas']))*70/100;
            
            //$con_parcelas = "R$ ".number_format($valor_reduzido,2);
            $input['reduzido'] = 's';
        }else{
            $input['reduzido'] = 'n';
        }

        $con_entrada = $input['con-entrada'];
        $embutidas = intval( $input['parcelas_embutidas']);
        if ( $embutidas > 0 ){
            
            
            $subs = array("R","$",".");
            $valor_entrada = floatval( str_replace($subs,"",$input['con-entrada']));

            //$valor_parcela = floatval( str_replace($subs,"",$input['con-parcelas'])) * $embutidas;

            if($input['reduzido'] == 's'){
                $valor_parcela = (floatval( str_replace($subs,"",$input['con-parcelas'])) * $embutidas )/0.7;
            }else {
                $valor_parcela = floatval( str_replace($subs,"",$input['con-parcelas'])) * $embutidas ;
            }


            $con_entrada = "R$ ".number_format($valor_entrada+ $valor_parcela,2, ',', '.');        
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
        $proposta['data_proposta'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

        $proposta['user_id'] = \Auth::user()->id;
        $proposta['negocio_id'] = $input['negocio_id'];

        
        $proposta->save();

        $proposta_id = $proposta->id;
        Atividade::add_atividade(\Auth::user()->id, "Nova proposta criada id: ".$proposta->id, $input['negocio_id'] );
        
        return view('negocios.proposta', compact('tipo','con_entrada','proposta_id'));
    }

    public function view_proposta($id){

        $proposta = Proposta::find($id);


        //$con_parcelas =  $proposta['con-parcelas'];
        $subs = array("R","$",".");
        $valor_entrada = floatval( str_replace($subs,"",$proposta['con-entrada']));
        $valor_parcela = floatval( str_replace($subs,"",$proposta['con-parcelas']));
        $credito = floatval( str_replace($subs,"",$proposta['credito']));
        $prazo = intval( $proposta['con-prazo']);
        
        $vtotal = ($prazo * $valor_parcela) + $valor_entrada;
        $proposta['con-juros-pagos'] = $valor_parcela = "R$ ".number_format($vtotal - $credito,2, ',', '.'); 

        
        
        // if ( $proposta['con-reduzido'] == 's'){

        //     $subs = array("R","$",".");
        //     $valor_reduzido = floatval( str_replace($subs,"",$proposta['con-parcelas']))*70/100;
            
        //     $con_parcelas = "R$ ".number_format($valor_reduzido,2);
        //     $proposta['reduzido'] = 's';
        // }else{
        //     $proposta['reduzido'] = 'n';
        // }

        $con_entrada = $proposta['con-entrada'];
        $embutidas = intval( $proposta['parcelas_embutidas']);
        if ( $embutidas > 0 ){
            
            
            $subs = array("R","$",".");
            $valor_entrada = floatval( str_replace($subs,"",$proposta['con-entrada']));

            if($proposta['con-reduzido'] == 's'){
                $valor_parcela = (floatval( str_replace($subs,"",$proposta['con-parcelas'])) * $embutidas )/0.7;
            }else {
                $valor_parcela = floatval( str_replace($subs,"",$proposta['con-parcelas'])) * $embutidas ;
            }

            

            $con_entrada = "R$ ".number_format($valor_entrada+ $valor_parcela,2, ',', '.');
        
        }



        return view('negocios.proposta_id', compact('proposta', 'con_entrada'));
    }
    

    
    public function drag_update(Request $res)
    {

        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_origem = $input['info'][1];
        $id_destino = $input['info'][2];

        Atividade::add_atividade(\Auth::user()->id, "Cliente movido para ".EtapaFunil::find($id_destino)->nome, $id_negocio);

        if ($id_destino > 0){
            Negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
        }else {
            Negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
        }
    }

    public function add_reuniao(Request $res)
    {
        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_destino = $input['info'][2];
        
        $agendamento = Agendamento::where('negocio_id',$id_negocio)->first();
        
        if ( $agendamento){
             
            $query = [
                ['agendamento_id', '=', $agendamento->id ],
            ];

            $reuniao = Reuniao::where($query)->first();

            if (!$reuniao){
                $reuniao = new Reuniao();
                $reuniao->agendamento_id = $agendamento->id;
                $reuniao->user_id = \Auth::user()->id;
                $reuniao->data_reuniao = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
                $reuniao->save(); 
                Atividade::add_atividade(\Auth::user()->id, "Cliente participou da Reunião", $id_negocio );

                if ($id_destino > 0){
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
                }else {
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
                }

                return "Cliente participou da Reunião";
            }else {

                if ($id_destino > 0){
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
                }else {
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
                }

                return "Reunião já aconteceu anteriormente";
            }      
        }

        return "Agendamento não foi encontrado";
    }

    public function add_aprovacao(Request $res){
        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_destino = $input['info'][2];
        
        $negocio = Negocio::find($id_negocio);

        if ( $negocio ){

            $query = [
                ['negocio_id', '=', $negocio->id],
                ['user_id', '=', \Auth::user()->id],

            ];

            $aprovacao = Aprovacao::where($query)->first();
            if (!$aprovacao) {

                $aprovacao = new Aprovacao();
                $aprovacao->data_aprovacao = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
                $aprovacao->negocio_id =  $negocio->id;
                $aprovacao->user_id = \Auth::user()->id;
    
                $aprovacao->save();
    
                Atividade::add_atividade(\Auth::user()->id, "Cliente Aprovado", $id_negocio);
            }
           
            if ($id_destino > 0){
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> $id_destino]);
            }else {
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id'=> NULL]);
            }
        }
    }

    public function negocio_update(Request $res)
    {
        $input = $res->input();
        
        $id_negocio = $input['id_negocio'];
        $neg = Negocio::find($id_negocio);

        $neg_fields = array();
        $neg_fields['valor'] = str_replace('.','',$input['valor'] ) ;//$input['valor'];
        $neg_fields['titulo'] = $input['titulo'];
        $neg_fields['grupo'] = $input['grupo'];
        $neg_fields['cota'] = $input['cota'];
        $neg_fields['data_assembleia'] = $input['data_assembleia'];
        $neg_fields['contrato'] = $input['contrato'];

        Negocio::where('id',$id_negocio)->update($neg_fields);

        $lead_fields = array();
        $lead_fields['nome'] = $input['nome'];
        $lead_fields['email'] = $input['email'];
        $lead_fields['telefone'] = $input['telefone'];
        $lead_fields['whatsapp'] = $input['whatsapp'];
        $lead_fields['endereco'] = $input['endereco'];
        $lead_fields['complemento'] = $input['complemento'];
        $lead_fields['cep'] = $input['cep'];

        Lead::where( 'id', $neg->lead->id)->update($lead_fields);

        Atividade::add_atividade(\Auth::user()->id, "Atualização de campos", $id_negocio );

        return back()->with('status','Negócio atualizado com sucesso!');
    }

    
}