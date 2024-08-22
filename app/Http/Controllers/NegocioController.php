<?php

namespace App\Http\Controllers;

use App\Models\Funil;
use App\Models\EtapaFunil;
use App\Models\Fechamento;
use Illuminate\Http\Request;
use Validator;
use App\Models\NegocioImportado;
use App\Models\Negocio;
use App\Models\User;
use App\Models\Lead;
use App\Models\Proposta;
use App\Models\Reuniao;
use App\Models\Agendamento;
use App\Models\Aprovacao;
use App\Models\Atividade;
use App\Models\Equipe;
use App\Enums\UserStatus;
use App\Models\Levantamento;
use App\Events\NewSaleEvent;
use Auth;
use Carbon\Carbon;
use App\Enums\VendaStatus;
use App\Enums\NegocioStatus;

class NegocioController extends Controller
{
    public function importar_index()
    {
        $negocios_importados = NegocioImportado::all();

        $users = User::where('status', UserStatus::ativo)->pluck('name', 'id');

        #TODO Se um dia tiver mais de um funil
        $curr_funil_id = 1;#intval($request->query('id'));
        $pipeline = Funil::where('id', $curr_funil_id)->get();

        $etapa_funils = $pipeline->first()->etapa_funils()->pluck('nome', 'ordem')->toArray();
        ksort($etapa_funils);

        return view('negocios/importar', compact('negocios_importados', 'etapa_funils', 'users'));
    }

    public function negocio_levantamento(Request $request)
    {

        $input = $request->except('token');

        $negocio = Negocio::find($input['negocio_id']);

        $levantamento = Levantamento::where('negocio_id', $negocio->id)->first();

        if (empty($levantamento)) {
            $levantamento = new Levantamento();
        }

        $levantamento->dificuldade = $input['dificuldade'];
        $levantamento->regiao = $input['regiao'];
        $levantamento->planejamento = $input['planejamento'];
        $levantamento->parcela_max = $input['parcela_max'];
        $levantamento->entrada_max = $input['entrada_max'];
        $levantamento->desfazer_bem = $input['desfazer_bem'];
        $levantamento->aluguel = $input['aluguel'];
        $levantamento->decisores = $input['decisores'];
        $levantamento->valor_fgts = $input['valor_fgts'];
        $levantamento->compor_renda = $input['compor_renda'];
        $levantamento->financiamento = $input['financiamento'];
        $levantamento->filhos = $input['filhos'];
        $levantamento->status_civil = $input['status_civil'];
        $levantamento->casa_propria = $input['casa_propria'];
        $levantamento->renda_total = $input['renda_total'];
        $levantamento->renda_comprovacao = $input['renda_comprovacao'];
        $levantamento->restricao = $input['restricao'];
        $levantamento->negocio_id = $input['negocio_id'];


        $levantamento->status = $input['aprovar_cliente'];

        $levantamento->save();

        $negocio->tipo = $input['tipo_credito'];
        $negocio->valor = $input['valor'];
        $negocio->save();

        //return back()->with('status', 'Levantamento Salvo com sucesso');

        $aba = '#levantamento';

        // Redireciona de volta com a mensagem de status e a aba especificada
        return redirect()->back()->with('status', 'Levantamento Salvo com sucesso')->with('aba', $aba);

    }

    public function aprovacoes_update(Request $request)
    {
        $input = $request->input();
        $negocio_id = $input['id'];
        $field = $input['field'];
        $valor = $input['value'];

        if ($field == "aprovados") {
            $negocio = Negocio::find($negocio_id);
            $negocio->valor = $valor;
            $negocio->save();
        } else {

            $negocio = Negocio::find($negocio_id);

            $venda = Fechamento::find($negocio->fechamento_id);

            $venda->valor = $valor;
            $venda->save();
        }


        return ['Aprovações Atualizadas com Sucesso'];

    }
    public function aprovacoes(Request $request)
    {

        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        if (is_null($data_inicio) and is_null($data_fim)) {

            if (config('data_inicio') & config('data_fim')) {
                $data_inicio = config('data_inicio');
                $data_fim = config('data_fim');
            }

        }


        $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $data_fim)->format('Y-m-d');

        $query = [
            ['data_fechamento', '>=', $from],
            ['data_fechamento', '<=', $to],
            ['status', '=', 'FECHADA']
        ];


        if (Auth::user()->hasRole("admin")) {

            $vendas = Fechamento::where($query)->get();

        } else if (Auth::user()->hasRole("gerenciar_equipe")) {

            $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

            $ids = [];

            if ($equipe) {
                $ids = $equipe->integrantes()->pluck('id')->toArray();
            }

            array_push($ids, \Auth::user()->id);


            $vendas = Fechamento::whereIn('primeiro_vendedor_id', $ids)->where($query)->get();

        }

        $dados = [];
        $dados_equipe = [];


        foreach ($vendas as $venda) {
            $dados_item = [];

            $vendedor = User::find($venda->primeiro_vendedor_id);
            if ($vendedor->status != UserStatus::ativo) {
                continue;
            }

            $dados_item['vendedor'] = $vendedor->name;
            $dados_item['cliente'] = $venda->negocio->lead->nome;
            $dados_item['credito'] = $venda->valor;
            $dados_item['negocio_id'] = $venda->negocio->id;

            $equipe = "Sem Equipe";
            if ($vendedor->equipe) {
                $equipe = $vendedor->equipe->descricao;
                $dados_equipe[$equipe]['id'] = $vendedor->equipe->id;
                $dados_equipe[$equipe]['logo'] = $vendedor->equipe->logo;
            }

            if (!array_key_exists($equipe, $dados)) {
                $dados[$equipe]['fechados'] = [];
                $dados[$equipe]['aprovados'] = [];
            }

            array_push($dados[$equipe]['fechados'], $dados_item);
        }

        $query = [
            ['etapa_', '>=', $from],
            ['etapa_funil_id', '<=', $to],
        ];


        if (Auth::user()->hasRole("admin")) {

            $negocios = Negocio::where('etapa_funil_id', 5)->where('status', NegocioStatus::ATIVO)->get();

        } else if (Auth::user()->hasRole("gerenciar_equipe")) {

            $equipe = Equipe::where('lider_id', Auth::user()->id)->first();

            $ids = [];

            if ($equipe) {
                $ids = $equipe->integrantes()->pluck('id')->toArray();
            }

            array_push($ids, \Auth::user()->id);

            $negocios = Negocio::whereIn('user_id', $ids)->where('etapa_funil_id', 5)->where('status', NegocioStatus::ATIVO)->get();
        }


        foreach ($negocios as $negocio) {
            $dados_item = [];

            $vendedor = User::find($negocio->user_id);//($aprovacao->user_id);

            if ($vendedor->status != UserStatus::ativo) {
                continue;
            }

            $dados_item['vendedor'] = $vendedor->name;
            $dados_item['cliente'] = $negocio->lead->nome;
            $dados_item['credito'] = $negocio->valor;
            $dados_item['negocio_id'] = $negocio->id;

            $comentario = '';


            $levantamento = Levantamento::where('negocio_id', $negocio->id)->first();

            if ($levantamento) {

                if ($levantamento->status) {
                    $dados_item['status_levantamento'] = $levantamento->status;
                }


            }

            if ($negocio->comentarios) {

                if (!$negocio->comentarios->isEmpty()) {

                    $coment = $negocio->comentarios->sortDesc()->first();
                    if ($coment) {
                        $comentario = $coment->comentario;

                    }

                }


            }

            $dados_item['comentario'] = $comentario;


            $equipe = "Sem Equipe";
            if ($vendedor->equipe) {
                $equipe = $vendedor->equipe->descricao;
                $dados_equipe[$equipe]['id'] = $vendedor->equipe->id;
                $dados_equipe[$equipe]['logo'] = $vendedor->equipe->logo;

            }

            if (!array_key_exists($equipe, $dados)) {
                $dados[$equipe]['fechados'] = [];
                $dados[$equipe]['aprovados'] = [];
            }



            array_push($dados[$equipe]['aprovados'], $dados_item);
        }


        return view('negocios.aprovacoes', compact('dados', 'dados_equipe'));
    }

    private function removePatterns($string)
    {
        // Define os padrões a serem removidos
        $patterns = [
            '/^\+55/',  // Remove "+55" no início da string
            '/^p:\+55/', // Remove "p:+55" no início da string
            '/^p:55/',   // Remove "p:55" no início da string
            '/^55/'      // Remove "55" no início da string
        ];

        // Aplica os padrões na string
        foreach ($patterns as $pattern) {
            $string = preg_replace($pattern, '', $string);
        }

        return $string;
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
            $tipo_do_bem = $sheet->getCell("D{$row}")->getValue();
            $campanha = $sheet->getCell("E{$row}")->getValue();
            $fonte = $sheet->getCell("F{$row}")->getValue();

            $create_time = Carbon::now()->format('Y-m-d');


            #Remover padrões como 55,p:+55. p:55 e +55 da frent das strings
            $telefone = $this->removePatterns($telefone);



            $lead = Lead::where(['telefone' => $telefone, 'nome' => $nome])->first();

            if (!empty($lead)) {
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }

            $negimp = NegocioImportado::where(['telefone' => $telefone])->first();

            if (!empty($negimp)) {
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }

            $negocio = new NegocioImportado();
            $negocio->nome = $nome;
            $negocio->telefone = $telefone;
            $negocio->email = $email;
            $negocio->tipo_do_bem = $tipo_do_bem;
            $negocio->campanha = $campanha;
            $negocio->fonte = $fonte;
            $negocio->data_conversao = $create_time;

            $negocio->origem = "IMPORTACAO_PLANILHA";

            try {
                $negocio->save();
            } catch (QueryException $e) {
                $negocios_rejeitados = $negocios_rejeitados + 1;
                continue;
            }

            $imported = $imported + 1;
        }

        if ($imported > 0) {
            return back()->with('status', $imported . ' negocios importados com sucesso. ' . $negocios_rejeitados . ' rejeitados por duplicidade');
        } else {
            if ($negocios_rejeitados > 0) {
                return back()->with('status_error', 'Todos foram rejeitados por duplicidade');
            } else {
                return back()->with('status_error', 'Erro ao ler o csv. Cheque se estava no formato correto');
            }
        }
    }

    public function check_authorization($request, $action)
    {

        if ($action == "fechamento") {
            //Autorizado
            if (\Auth::user()->hasRole('gerenciar_vendas')) {
                return true;
            }
        }

        $id = $request->query('id');
        $negocio = Negocio::find($id);
        $proprietario_id = $negocio->user_id;

        $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

        $proprietario = User::find($proprietario_id);
        $equipe_proprietario = NULL;

        $equipe_exists = 1;
        if (!empty($proprietario)) {
            $equipe_proprietario = $proprietario->equipe()->first();
        } else {
            $proprietario = NULL;

            if ($proprietario_id == -2) {
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
            } else {
                $equipe_exists = 1;
            }
        }

    }

    public function check_if_active()
    {

        if (\Auth::user()->status == UserStatus::inativo) {

            \Auth::logout();
            return route('login');
        }
    }

    public function negocio_edit(Request $request)
    {


        $this->check_if_active();

        $this->check_authorization($request, 'edit');

        $id = $request->query('id');
        $negocio = Negocio::find($id);

        $levantamento = Levantamento::where('negocio_id', $negocio->id)->first();

        if (empty($levantamento)) {
            $levantamento = new Levantamento();
        }


        return view('negocios.edit', compact('negocio', 'levantamento'));
    }

    public function negocio_fechamento(Request $request)
    {



        $this->check_if_active();
        $this->check_authorization($request, 'fechamento');

        $id = $request->query('id');
        $negocio = Negocio::find($id);

        $conjuge = null;
        if ($negocio->lead->conjuge_id) {
            $conjuge = Lead::find($negocio->lead->conjuge_id);
        } else {

            $conjuge = new Lead();
            $conjuge->nome = "";
            $conjuge->telefone = "";
            $conjuge->save();
        }

        $id = $conjuge->conjuge_id;

        if ($negocio->fechamento_id) {
            $fechamento = Fechamento::find($negocio->fechamento_id);
        } else {
            $fechamento = new Fechamento();
            $fechamento->data_fechamento = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
            $fechamento->valor = $negocio->valor;

            $fechamento->status = VendaStatus::RASCUNHO;

            $negocio->conjuge_id = $conjuge->id;
        }


        return view('negocios.fechamento', compact('negocio', 'fechamento'));
    }

    public function negocio_get(Request $request)
    {

        $id = $request->query('id');
        $negocio = Negocio::where('id', $id)->get();

        $lead = Negocio::where('id', $id)->first()->lead()->get();

        return [$negocio[0], $lead[0]];
    }




    public function import_massivo(Request $request)
    {

        $input = request()->all();

        $curr_funil_id = intval($input['curr_funil_id']);
        $pipeline = Funil::where('id', $curr_funil_id)->get();

        $etapa_funils = [];

        if (array_key_exists('etapa_funil_id', $input)) {
            $etapa_funil_id = $input['etapa_funil_id'];
            $etapa_funils = [0, $etapa_funil_id];
        } else {
            $etapa_funils = $pipeline->first()->etapa_funils()->pluck('ordem', 'id')->toArray();
            ksort($etapa_funils);
        }


        if ($input['modo'] == "atribuir") {
            return $this->import_atribuir($request);

        } elseif ($input['modo'] == "distribuir") {

            $usuarios = $input['usuarios'];
            $user_count = count($usuarios);
            $negocio_count = count($input['negocios_importados']);

            $neg_importados = NegocioImportado::whereIn('id', $input['negocios_importados'])->get();

            $import_data = array();
            $negocios_criados = 0;
            $negocios_rejeitados = 0;

            $user_count_dist = 0;

            foreach ($neg_importados as $neg) {

                // $negocio->user_id = $usuarios[$user_count_dist];
                // $negocio->etapa_funil_id = $etapa_funils[1];
                // $negocio->save();


                $lead = Lead::where(['telefone' => $neg->telefone, 'nome' => $neg->nome])->first();

                if (!empty($lead)) {

                    NegocioImportado::where('id', $neg->id)->delete();
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
                $deal_input['titulo'] = "Negócio com " . $neg->nome;
                $deal_input['valor'] = 0;
                $deal_input['funil_id'] = $input['funil_id'];
                $deal_input['etapa_funil_id'] = $etapa_funils[1];
                $deal_input['tipo'] = $neg->tipo_do_bem;
                $deal_input['lead_id'] = $lead->id;
                $deal_input['user_id'] = $usuarios[$user_count_dist];

                $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

                $deal_input['origem'] = $neg->origem;


                $negocio = Negocio::create($deal_input);

                NegocioImportado::where('id', $neg->id)->delete();
                $negocios_criados = $negocios_criados + 1;

                Atividade::add_atividade(\Auth::user()->id, "Cliente do " . $lead->fonte . " de " . $neg->tipo_do_bem . " importado via arquivo", $negocio->id);

                $user = User::find($deal_input['user_id']);


                Atividade::add_atividade(\Auth::user()->id, "Cliente atribui a " . $user->name . " por " . \Auth::user()->name, $negocio->id);

                if ($user_count_dist + 1 == $user_count) {
                    $user_count_dist = 0;
                } else {
                    $user_count_dist = $user_count_dist + 1;
                }

            }
            return back()->with('status', "Distribuidos " . $negocio_count . " negócios para " . $user_count . " usuários.");

        } elseif ($input['modo'] == "desativar") {

            $negocios = $input['negocios_importados'];
            $negocios = NegocioImportado::whereIn('id', $negocios)->get();
            $user_count_dist = 0;
            foreach ($negocios as $negocio) {
                $negocio->delete();

                $user_count_dist = $user_count_dist + 1;
            }
            return back()->with('status', "Deletados " . $user_count_dist . " negócios.");

        }

    }


    public function import_atribuir(Request $request)
    {

        $input = request()->all();
        $neg_importados = NegocioImportado::whereIn('id', $input['negocios_importados'])->get();

        $import_data = array();
        $negocios_criados = 0;
        $negocios_rejeitados = 0;

        foreach ($neg_importados as $neg) {

            $lead = Lead::where(['telefone' => $neg->telefone, 'nome' => $neg->nome])->first();

            if (!empty($lead)) {

                NegocioImportado::where('id', $neg->id)->delete();
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
            $deal_input['titulo'] = "Negócio com " . $neg->nome;
            $deal_input['valor'] = 0;
            $deal_input['funil_id'] = $input['funil_id'];
            $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];
            $deal_input['tipo'] = $neg->tipo_do_bem;
            $deal_input['lead_id'] = $lead->id;
            $deal_input['user_id'] = $input['novo_proprietario_id'];

            $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

            $deal_input['origem'] = $neg->origem;

            $negocio = Negocio::create($deal_input);

            NegocioImportado::where('id', $neg->id)->delete();
            $negocios_criados = $negocios_criados + 1;

            Atividade::add_atividade(\Auth::user()->id, "Cliente do " . $lead->fonte . " de " . $neg->tipo_do_bem . " importado via arquivo", $negocio->id);

            $user = User::find($input['novo_proprietario_id']);


            Atividade::add_atividade(\Auth::user()->id, "Cliente atribui a " . $user->name . " por " . \Auth::user()->name, $negocio->id);
        }

        if ($negocios_criados > 0) {
            return back()->with('status', $negocios_criados . " negocios atribuidos com sucesso.\n" . $negocios_rejeitados . " negocios rejeitados por duplicidade.");
        } else {
            if ($negocios_rejeitados > 0) {
                return back()->withErrors($negocios_rejeitados . " rejeitado por duplicidade");
            }
            return back()->withErrors("Erro desconhecido");
        }

    }

    public function simulacao(Request $request)
    {

        $negocio_id = $request->query('negocio_id');
        $negocio = Negocio::where('id', $negocio_id)->first();

        $etapa = EtapaFunil::find($negocio->etapa_funil_id)->nome;


        if ($etapa == "REUNIAO") {

            return view('negocios.simulacao', compact('negocio'));
        } else {
            return back()->withErrors("Cliente precisa estar na etapa REUNIAO para gerar propostas");
        }

    }
    public function criar_proposta(Request $request)
    {

        $input = $request->all();
        $tipo = $input["tipo"];

        if ($request->has('reduzido')) {

            $input['reduzido'] = 's';
        } else {
            $input['reduzido'] = 'n';
        }

        $con_entrada = $input['con-entrada'];

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

        $neg = Negocio::find($input['negocio_id']);
        $lead = Lead::find($neg->lead->id);
        $lead->cpf = $input['cpf'];
        $lead->save();

        //*** Faltando */
        $proposta['con-credito'] = $input['con-credito'];
        $proposta['con-adesao'] = $input['con-adesao'];
        $proposta['con-juros-pagos'] = $input['con-juros-pagos'];
        $proposta['modelo'] = $input['modelo'];
        $proposta['ano'] = $input['ano'];

        $proposta['con-administradora'] = strtoupper($input['con-administradora']);

        $amortizacao = 'sac';
        if ($request->filled('amortizacao')) {
            $amortizacao = 'sac';
            $proposta['amortizacao'] = 'sac';
            $input['amortizacao'] = 'sac';
        } else {
            $amortizacao = 'price';
            $proposta['amortizacao'] = 'price';
            $input['amortizacao'] = 'price';
        }


        $proposta->save();

        $proposta_id = $proposta->id;
        Atividade::add_atividade(\Auth::user()->id, "Nova proposta criada id: " . $proposta->id, $input['negocio_id']);

        return view('negocios.proposta', compact('tipo', 'con_entrada', 'proposta_id', 'amortizacao'));
    }

    public function view_proposta($id)
    {

        $proposta = Proposta::find($id);


        $subs = array("R", "$", ".");
        $valor_entrada = floatval(str_replace($subs, "", $proposta['con-entrada']));
        $valor_parcela = floatval(str_replace($subs, "", $proposta['con-parcelas']));
        $credito = floatval(str_replace($subs, "", $proposta['credito']));
        $prazo = intval($proposta['con-prazo']);

        $vtotal = ($prazo * $valor_parcela) + $valor_entrada;
        $proposta['con-juros-pagos'] = $valor_parcela = "R$ " . number_format($vtotal - $credito, 2, ',', '.');


        $con_entrada = $proposta['con-entrada'];

        return view('negocios.proposta_id', compact('proposta', 'con_entrada'));
    }



    public function drag_update(Request $res)
    {

        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_origem = $input['info'][1];
        $id_destino = $input['info'][2];

        Atividade::add_atividade(\Auth::user()->id, "Cliente movido para " . EtapaFunil::find($id_destino)->nome, $id_negocio);

        if ($id_destino > 0) {
            Negocio::where('id', $id_negocio)->update(['etapa_funil_id' => $id_destino]);
        } else {
            Negocio::where('id', $id_negocio)->update(['etapa_funil_id' => NULL]);
        }
    }

    public function add_reuniao(Request $res)
    {
        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_destino = $input['info'][2];

        $agendamento = Agendamento::where('negocio_id', $id_negocio)->first();

        $negocio = Negocio::find($id_negocio);
        $proprietario_id = $negocio->user_id;


        if ($agendamento) {

            $query = [
                ['agendamento_id', '=', $agendamento->id],
            ];

            $reuniao = Reuniao::where($query)->first();


            if (!$reuniao) {
                $reuniao = new Reuniao();
                $reuniao->agendamento_id = $agendamento->id;
                $reuniao->user_id = $proprietario_id; //\Auth::user()->id;
                $reuniao->data_reuniao = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
                $reuniao->save();
                Atividade::add_atividade(\Auth::user()->id, "Cliente participou da Reunião", $id_negocio);

                if ($id_destino > 0) {
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id' => $id_destino]);
                } else {
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id' => NULL]);
                }

                return "Cliente participou da Reunião";
            } else {

                if ($id_destino > 0) {
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id' => $id_destino]);
                } else {
                    Negocio::where('id', $id_negocio)->update(['etapa_funil_id' => NULL]);
                }

                return "Reunião já aconteceu anteriormente";
            }
        }

        return "Agendamento não foi encontrado";
    }

    public function add_aprovacao(Request $res)
    {
        $input = $res->input();
        $id_negocio = $input['info'][0];
        $id_destino = $input['info'][2];

        $negocio = Negocio::find($id_negocio);

        $proprietario_id = $negocio->user_id;

        if ($negocio) {

            $query = [
                ['negocio_id', '=', $negocio->id],
                ['user_id', '=', \Auth::user()->id],

            ];

            $aprovacao = Aprovacao::where($query)->first();
            if (!$aprovacao) {

                $aprovacao = new Aprovacao();
                $aprovacao->data_aprovacao = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
                $aprovacao->negocio_id = $negocio->id;
                $aprovacao->user_id = $proprietario_id;#\Auth::user()->id;

                $aprovacao->save();

                Atividade::add_atividade(\Auth::user()->id, "Cliente Aprovado", $id_negocio);
            }

            if ($id_destino > 0) {
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id' => $id_destino]);
            } else {
                $negocio::where('id', $id_negocio)->update(['etapa_funil_id' => NULL]);
            }
        }
    }

    public function negocio_update(Request $res)
    {
        $input = $res->input();

        $id_negocio = $input['id_negocio'];
        $neg = Negocio::find($id_negocio);

        $neg_fields = array();
        $neg_fields['valor'] = str_replace('.', '', $input['valor']);//$input['valor'];
        $neg_fields['titulo'] = $input['titulo'];
        $neg_fields['grupo'] = $input['grupo'];
        $neg_fields['cota'] = $input['cota'];
        $neg_fields['data_assembleia'] = $input['data_assembleia'];
        $neg_fields['contrato'] = $input['contrato'];

        Negocio::where('id', $id_negocio)->update($neg_fields);

        $lead_fields = array();
        $lead_fields['nome'] = $input['nome'];
        $lead_fields['email'] = $input['email'];
        $lead_fields['telefone'] = $input['telefone'];
        $lead_fields['whatsapp'] = $input['whatsapp'];
        $lead_fields['endereco'] = $input['endereco'];
        $lead_fields['complemento'] = $input['complemento'];
        $lead_fields['cep'] = $input['cep'];

        Lead::where('id', $neg->lead->id)->update($lead_fields);

        Atividade::add_atividade(\Auth::user()->id, "Atualização de campos", $id_negocio);

        return back()->with('status', 'Negócio atualizado com sucesso!');
    }


}