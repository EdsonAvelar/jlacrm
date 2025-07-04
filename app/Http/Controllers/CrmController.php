<?php

namespace App\Http\Controllers;

use App\Models\Funil;
use App\Models\Levantamento;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Negocio;
use App\Models\EtapaFunil;
use App\Models\User;
use App\Models\Equipe;
use App\Models\MotivoPerda;


use App\Enums\UserStatus;
use App\Enums\NegocioStatus;
use \App\Models\NegocioComentario;
use Auth;
use Validator;
use Carbon\Carbon;

use App\Models\Atividade;
use App\Models\Agendamento;
use App\Models\Reuniao;
use App\Models\Proposta;
use App\Models\Simulacao;
use App\Models\Perda;
use App\Models\Fechamento;
use App\Models\Auditoria;
use App\Models\Aprovacao;

use Yajra\DataTables\Facades\DataTables;

#use App\Models\Lead;

class CrmController extends Controller
{
    public function add_lead(Request $request)
    {

        $submit = $request['submit'];

        if ($submit == "submit") {

            $request->validate([
                'nome' => 'required',
                'telefone' => 'required|min:10',
                'titulo' => 'required'
            ]);

            $lead = new Lead();
            $lead->nome = $request['nome'];
            $lead->telefone = $request['telefone'];
            $lead->titulo = $request['titulo'];

        }
        return view('leads/add_lead');
    }

    public function exportCsv(Request $request)
    {
        $ids = $request->query('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return redirect()->back()->with('error', 'Nenhum negócio selecionado para exportar.');
        }

        $negocios = Negocio::query()
            ->whereIn('negocios.id', $ids)
            ->leftJoin('etapa_funils', 'negocios.etapa_funil_id', '=', 'etapa_funils.id')
            ->leftJoin('leads', 'negocios.lead_id', '=', 'leads.id')
            ->leftJoin('users', 'negocios.user_id', '=', 'users.id')
            ->leftJoin('perdas', 'negocios.id', '=', 'perdas.negocio_id')
            ->leftJoin('motivo_perdas', 'perdas.motivo_perdas_id', '=', 'motivo_perdas.id')
            ->select([
                'negocios.id',
                'negocios.titulo',
                'leads.nome as cliente',
                'leads.telefone as telefone',
                'negocios.valor',
                'etapa_funils.nome as etapa',
                'users.name as proprietario',
                'negocios.origem',
                'negocios.status',
                'motivo_perdas.motivo as motivo_perda',
                'negocios.data_criacao',
            ])->get();

        $columns = [
            'ID',
            'Título',
            'Cliente',
            'Telefone',
            'Valor',
            'Etapa',
            'Proprietário',
            'Origem',
            'Status',
            'Motivo de Perda',
            'Criado em'
        ];

        $callback = function () use ($negocios, $columns) {
            $handle = fopen('php://output', 'w');
            // cabeçalho
            fputcsv($handle, $columns);
            foreach ($negocios as $n) {
                fputcsv($handle, [
                    $n->id,
                    $n->titulo,
                    $n->cliente,
                    $n->telefone,
                    $n->valor,
                    $n->etapa,
                    $n->proprietario,
                    $n->origem,
                    $n->status,
                    $n->motivo_perda,
                    Carbon::parse($n->data_criacao)->format('d/m/Y'),
                ]);
            }
            fclose($handle);
        };

        $response = response()->stream($callback, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"negocios.csv\"",
        ]);

        return $response;
    }

    public function check_if_active()
    {

        if (\Auth::user()->status == UserStatus::inativo) {

            Auth::logout();
            return redirect(route('login'));
        }
    }

    public function pipeline_index(Request $request)
    {
        $this->check_if_active();

        $curr_funil_id = intval($request->query('id'));
        $proprietario_id = intval($request->query('proprietario'));
        $perPage = intval($request->query('perPage', 10));


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

        $auth_user_id = Auth::user()->id;
        /**
         * Valida se é um usuário autorizado a ter essa visao
         */
        if ($auth_user_id != $proprietario_id) {
            if (!(Auth::user()->hasRole('admin'))) {

                if ($equipe_proprietario == NULL) {
                    return abort(401);
                } else if (!Auth::user()->hasRole('gerenciar_equipe')) {
                    return abort(401);
                } else if ($equipe_exists > 0 and $equipe->id != $equipe_proprietario->id) {
                    return abort(401);
                }
            } else {
                $equipe_exists = 1;
            }
        }

        $view = $request->query('view');

        $pipeline = Funil::where('id', $curr_funil_id)->get();
        $funils = Funil::all()->pluck('nome', 'id');

        $query = array();
        $ids = null;
        if ($proprietario_id == null) {
            $query = [
                ['funil_id', '=', $curr_funil_id],
                ['user_id', '=', \Auth::user()->id],
            ];
        } elseif ($proprietario_id == -1) {
            $query = [
                ['user_id', '=', NULL]
            ];
        } elseif ($proprietario_id == -2) {

            // Coordenador de equipe querendo ver todos os leads dos seus vendedores

            if ($equipe_exists == -1) {
                $ids = $equipe->integrantes()->pluck('id')->toArray();

                $query = [
                    ['funil_id', '=', $curr_funil_id],

                ];
            } else {
                // Admin querendo ver todos os leads dos seus vendedores
                $query = [
                    ['id', '>', 0]
                ];
            }

        } else {
            $query = [
                ['funil_id', '=', $curr_funil_id],
                ['user_id', '=', $proprietario_id],
            ];
        }

        $status = $request->query('status');

        if ($status) {

            $status_arr = ['status', '=', strtoupper($status)];
            array_push($query, $status_arr);
        }

        if ($proprietario_id == -2 && $equipe_exists == -1) {
            $negocios = Negocio::whereIn('user_id', $ids)->where($query)->orderBy('created_at', 'desc');
        } else {
            $negocios = Negocio::where($query)->orderBy('created_at', 'desc');
        }



        if ($view == 'list2') {
            $negocios = $negocios->paginate($perPage);
        } else {
            $negocios = $negocios->orderBy('created_at', 'desc')->get();
        }



        $etapa_funils = $pipeline->first()->etapa_funils()->pluck('nome', 'ordem')->toArray();
        ksort($etapa_funils);

        $users = User::where('status', UserStatus::ativo)->pluck('name', 'id');


        $proprietarios = NULL;
        if (Auth::user()->hasRole('admin')) {

            $proprietarios = User::where('status', UserStatus::ativo)->pluck('name', 'id');

        } else if (Auth::user()->hasRole('gerenciar_equipe') && $equipe) {
            $proprietarios = User::where(['equipe_id' => $equipe->id, 'status' => UserStatus::ativo])->pluck('name', 'id');
        }

        $motivos = MotivoPerda::all();


        if ($view == 'list') {

            if (!$negocios->first()) {
                return view('negocios/list', compact('funils', 'etapa_funils', 'curr_funil_id', 'users', 'proprietarios', 'proprietario', 'motivos'));
            }

            return view('negocios/list', compact('funils', 'etapa_funils', 'negocios', 'curr_funil_id', 'users', 'proprietarios', 'proprietario', 'motivos'));
        } elseif ($view == 'list2') {

            if (!$negocios->first()) {
                return view('negocios/list2', compact('funils', 'etapa_funils', 'curr_funil_id', 'users', 'proprietarios', 'proprietario', 'motivos'));
            }

            return view('negocios/list2', compact('funils', 'etapa_funils', 'negocios', 'curr_funil_id', 'users', 'proprietarios', 'proprietario', 'motivos'));
        } else {

            if (!$negocios->first()) {
                return view('negocios/pipeline', compact('funils', 'etapa_funils', 'curr_funil_id', 'users', 'proprietarios', 'proprietario', 'motivos'));
            }
            return view('negocios/pipeline', compact('funils', 'etapa_funils', 'negocios', 'curr_funil_id', 'users', 'proprietarios', 'proprietario', 'motivos'));
        }
    }

    // 2) INSERT: recebe o nome do motivo e adiciona na tabela
    public function insertMotivoPerda(Request $request)
    {
        $request->validate([
            'motivo' => 'required|string|max:255'
        ]);

        MotivoPerda::create([
            'motivo' => $request->motivo
        ]);

        return redirect()->back()->with('success', 'Motivo de perda adicionado.');
    }

    // 3) DELETE: deleta o motivo pelo ID
    public function deleteMotivoPerda($id)
    {
        MotivoPerda::destroy($id);

        return redirect()->back()->with('success', 'Motivo de perda removido.');
    }


    public function pipeline_list(Request $request)
    {
        $query = Negocio::query()
            ->join('etapa_funils', 'negocios.etapa_funil_id', '=', 'etapa_funils.id')
            ->join('leads', 'negocios.lead_id', '=', 'leads.id')
            ->leftJoin('users', 'negocios.user_id', '=', 'users.id')
            ->leftJoin('perdas', 'negocios.id', '=', 'perdas.negocio_id')
            ->leftJoin('motivo_perdas', 'perdas.motivo_perdas_id', '=', 'motivo_perdas.id')
            ->select([
                'negocios.*',
                'etapa_funils.nome as etapa_nome',
                'leads.nome as cliente_nome',
                'leads.telefone as cliente_telefone',
                'users.name as proprietario_nome',
                'motivo_perdas.motivo as motivo_perda',
            ])
            ->where('negocios.funil_id', $request->query('id'));

        if ($filters = $request->input('filters')) {
            foreach ($filters as $column => $value) {
                if (!empty($value)) {

                    if ($column === 'perdas.motivo_perdas_id') {
                        $query->where('perdas.motivo_perdas_id', $value);
                        continue;
                    }

                    // Verifica se é um filtro de intervalo de datas
                    if (is_array($value) && isset($value['start'], $value['end'])) {

                        $start = $value['start'];//Carbon::createFromFormat('Y-m-d', $value['start'])->startOfDay();
                        $end = $value['end'];//Carbon::createFromFormat('Y-m-d', $value['end'])->endOfDay();

                        switch ($column) {
                            case 'negocios.data_criacao':
                                $query->whereBetween('negocios.data_criacao', [$start, $end]);

                                break;
                            default:
                                $query->whereBetween($column, [$start, $end]);
                                break;
                        }
                    } else {


                        if (str_starts_with($value, '-')) {
                            // Remove o "-" do início para usar o restante como valor
                            $value = substr($value, 1);

                            switch ($column) {
                                case 'leads.nome':
                                    $query->where('leads.nome', 'not like', '%' . $value . '%');
                                    break;
                                case 'leads.telefone':
                                    $query->where('leads.telefone', 'not like', '%' . $value . '%');
                                    break;
                                case 'users.name':
                                    $query->where('users.name', 'not like', '%' . $value . '%');
                                    break;
                                case 'etapa_funils.nome':
                                    $query->where('etapa_funils.nome', 'not like', '%' . $value . '%');
                                    break;
                                default:
                                    $query->where($column, 'not like', '%' . $value . '%');
                                    break;
                            }
                        } else {
                            // Filtro normal com LIKE
                            switch ($column) {
                                case 'leads.nome':
                                    $query->where('leads.nome', 'like', '%' . $value . '%');
                                    break;
                                case 'leads.telefone':
                                    $query->where('leads.telefone', 'like', '%' . $value . '%');
                                    break;
                                case 'users.name':
                                    $query->where('users.name', 'like', '%' . $value . '%');
                                    break;
                                case 'etapa_funils.nome':
                                    $query->where('etapa_funils.nome', 'like', '%' . $value . '%');
                                    break;
                                default:
                                    $query->where($column, 'like', '%' . $value . '%');
                                    break;
                            }
                        }


                    }
                }
            }
        }


        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $columns = $request->input('columns');
            $columnIndex = $order['column'];
            $columnName = $columns[$columnIndex]['data'];
            $direction = $order['dir'];

            if ($columnName && in_array($columnName, ['titulo', 'cliente_nome', 'valor', 'etapa', 'proprietario', 'status', 'data_criacao'])) {
                $query->orderBy($columnName, $direction);
            }
        }

        // Filtro por status
        // if ($status = $request->query('status')) {
        //     $query->where('negocios.status', strtoupper($status));
        // }

        // Verificar se o filtro "negócios parados" foi solicitado

        if ($request->query('status') === 'parado') {
            $dias_parados = config('negocio_parado') ?? 3;
            $query->whereRaw('DATEDIFF(NOW(), negocios.updated_at) > ?', [$dias_parados])
                ->where('negocios.status', '!=', 'VENDIDO');
        } else {

            if ($status = $request->query('status')) {
                $query->where('negocios.status', strtoupper($status));
            }
        }

        // Filtro por proprietário
        if ($proprietario_id = $request->query('proprietario')) {
            if ($proprietario_id === '-1') {
                $query->whereNull('negocios.user_id');
            } elseif ($proprietario_id === '-2') {

                if (Auth::user()->hasRole('admin')) {

                    #$query->where('negocios.user_id', $proprietario_id);

                } elseif (Auth::user()->hasRole('gerenciar_equipe')) {

                    $equipe = Equipe::where('lider_id', \Auth::user()->id)->first();

                    $ids = [];

                    if ($equipe) {
                        $ids = $equipe->integrantes()->pluck('id')->toArray();
                    }

                    array_push($ids, \Auth::user()->id);

                    $query->whereIn('negocios.user_id', $ids);

                }


            } else {
                $query->where('negocios.user_id', $proprietario_id);
            }
        }

        return DataTables::of($query)
            ->addColumn('select', function ($negocio) {
                return '<input type="checkbox" class="select-checkbox" name="negocios[]" value="' . $negocio->id . '">';
            })
            ->addColumn('titulo', function ($negocio) {
                $link = route('negocio_edit', ['id' => $negocio->id]);
                return '<a href="' . $link . '" class="text-primary">' . htmlspecialchars($negocio->titulo) . '</a>';
            })
            ->addColumn('etapa', function ($negocio) {
                return $negocio->etapa_nome ?? 'N/A';
            })
            ->addColumn('cliente', function ($negocio) {
                return $negocio->cliente_nome ?? 'N/A';
            })
            ->addColumn('telefone', function ($negocio) {
                return '<a href="tel:' . ($negocio->cliente_telefone ?? '') . '">' . ($negocio->cliente_telefone ?? 'N/A') . '</a>';
            })
            ->addColumn('proprietario', function ($negocio) {
                return $negocio->proprietario_nome ?? 'Não Atribuído';
            })
            ->addColumn('motivo_perda', fn($n) =>
                $n->motivo_perda ? e($n->motivo_perda) : 'Sem motivo')
            ->editColumn('status', function ($negocio) {
                $statusBadge = match (strtoupper($negocio->status)) {
                    'ATIVO' => '<span class="badge bg-info">ATIVO</span>',
                    'PERDIDO' => '<span class="badge bg-danger">PERDIDO</span>',
                    'VENDIDO' => '<span class="badge bg-success">VENDIDO</span>',
                    default => '<span class="badge bg-warning">' . $negocio->status . '</span>',
                };
                return $statusBadge;
            })
            ->editColumn('data_criacao', function ($negocio) {
                //return Carbon::createFromFormat('Y-m-d', $negocio->data_criacao)->format('d/m/Y');
                return Carbon::parse($negocio->data_criacao)->format('d/m/Y');

            })
            ->rawColumns(['select', 'titulo', 'telefone', 'status'])
            ->make(true);
    }

    public function add_negocio_massiva(Request $request)
    {
        $input = $request->all();
        $deal_input = array();
        $text = trim($input['negocios']);
        $textAr = explode("\n", $text);
        $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

        $counts = 0;

        if ($textAr) {
            foreach ($textAr as $linha) {

                $neg = explode(',', $linha);

                if (count($neg) == 2) {

                    if (!is_numeric($neg[1])) {
                        continue;
                    }

                } elseif (count($neg) == 3) {



                    $neg[2] = trim(str_replace('.', '', $neg[2]));
                    $deal_input['valor'] = $neg[2];

                    $neg[1] = trim(str_replace('(', '', $neg[1]));
                    $neg[1] = trim(str_replace(')', '', $neg[1]));
                    $neg[1] = trim(str_replace('-', '', $neg[1]));

                    if (!is_numeric($neg[1]) or !is_numeric($neg[2])) {
                        continue;
                    }


                } else {
                    // Pula este 
                    continue;
                }

                $nome_a = explode(' ', $neg[0]);
                $nome = $neg[0];
                if (count($nome_a) > 2) {
                    $nome = $nome_a[0];
                }

                $deal_input['titulo'] = "Negócio " . $nome . "-" . $input['tipo_credito'];

                $deal_input['funil_id'] = $input['funil_id'];
                $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];
                $deal_input['tipo'] = $input['tipo_credito'];

                $lead_input = array();
                $lead_input['nome'] = $neg[0];
                $lead_input['telefone'] = $neg[1];
                $lead_input['whatsapp'] = $neg[1];

                $lead = new Lead();
                $lead->nome = $lead_input['nome'];
                $lead->telefone = $lead_input['telefone'];
                $lead->whatsapp = $lead_input['whatsapp'];
                $lead->save();

                // associando lead ao negócio
                $deal_input['lead_id'] = $lead->id;

                if ($input['proprietario_id'] && $input['proprietario_id'] > 0) {
                    $deal_input['user_id'] = User::find($input['proprietario_id'])->id;
                } else {
                    $deal_input['user_id'] = \Auth::user()->id;
                }

                $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

                $deal_input['origem'] = "MANUAL";

                //criando o negócio
                $negocio = Negocio::create($deal_input);

                Atividade::add_atividade(\Auth::user()->id, "Cliente criado manualmente por " . \Auth::user()->name, $negocio->id);

                $counts = $counts + 1;
            }

        }


        return back()->with('status', $counts . " Negócios Criados com Sucesso");
    }

    public function add_negocio(Request $request)
    {

        $input = $request->all();

        $deal_input = array();
        $deal_input['titulo'] = $input['titulo'];
        $deal_input['valor'] = str_replace('.', '', $input['valor']); //trim($input['valor'], ".");
        #$deal_input['fechamento'] = $input['fechamento'];
        $deal_input['funil_id'] = $input['funil_id'];
        $deal_input['etapa_funil_id'] = $input['etapa_funil_id'];
        $deal_input['tipo'] = $input['tipo_credito'];

        $lead_input = array();
        $lead_input['nome'] = $input['nome_lead'];
        $lead_input['telefone'] = $input['tel_lead'];
        $lead_input['whatsapp'] = $input['whats_lead'];


        //Validando leads
        $rules = [
            'nome' => 'required',
            'telefone' => 'required',
        ];

        $error_msg = [
            'nome.required' => 'Nome do Contato é obrigatório',
            'telefone.required' => 'Telefone do Contato é obrigatório',
        ];
        $validator = Validator::make($lead_input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        //Validando Negocios
        $rules = [
            'titulo' => 'required',
        ];
        $error_msg = [
            'titulo.required' => 'Titulo é obrigatório',
        ];
        $validator = Validator::make($deal_input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validado, hora de criar o lead para associar ao negocio
        $lead = new Lead();
        $lead->nome = $lead_input['nome'];
        $lead->telefone = $lead_input['telefone'];
        $lead->whatsapp = $lead_input['whatsapp'];
        $lead->save();

        // associando lead ao negócio
        $deal_input['lead_id'] = $lead->id;

        if ($input['proprietario_id'] && $input['proprietario_id'] > 0) {
            $deal_input['user_id'] = User::find($input['proprietario_id'])->id;
        } else {
            $deal_input['user_id'] = \Auth::user()->id;
        }

        $deal_input['origem'] = "MANUAL";

        $deal_input['data_criacao'] = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        //criando o negócio
        $negocio = Negocio::create($deal_input);

        Atividade::add_atividade(\Auth::user()->id, "Cliente criado manualmente por " . \Auth::user()->name, $negocio->id);

        return back()->with('status', "Negócio " . $deal_input['titulo'] . " Criado com Sucesso");
    }



    public function drag_update(Request $request)
    {
        $negocio_id = $request['info'][0];
        $target_etapa_id = $request['info'][2];

        $etapa = EtapaFunil::find($target_etapa_id);
        $etapa_id = $etapa->id;

        $negocio = Negocio::find($negocio_id);
        $negocio->etapa_funil_id = $etapa_id;

        $negocio->save();

        Atividade::add_atividade(Auth::user()->id, "Negócio foi motivo para " . $etapa->nome, $negocio_id);

        $name = $negocio->lead->nome;

        return [$name];
    }

    public function inserir_comentario(Request $request)
    {

        $input = $request->all();

        //Validando Negocios
        $rules = [
            'comentario' => 'required',
        ];
        $error_msg = [
            'comentario.required' => 'Não é possível salvar comentário vazio',
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $comentario = new NegocioComentario();
        $comentario->comentario = $input['comentario'];
        $comentario->user_id = $input['user_id'];
        $comentario->negocio_id = $input['negocio_id'];
        $comentario->save();

        return back()->with('status', "Comentário adicionado com successo");
    }

    public function atribui_one(Request $request)
    {

        $input = $request->all();
        $negocio_id = $input['negocio_id'];
        $novo_proprietario = User::find($input['novo_proprietario_id']);

        Negocio::where('id', $negocio_id)->update(['user_id' => $novo_proprietario->id]);
        Atividade::add_atividade(\Auth::user()->id, "Cliente Atribuido a " . $novo_proprietario->name, $negocio_id);

        return back()->with('status', "Negócio transferidos para " . $novo_proprietario->name);
    }


    public function reativar(Request $request)
    {

        $input = $request->all();

        $negocio_id = $input['negocio_id'];

        Negocio::where('id', $negocio_id)->update(['status' => NegocioStatus::ATIVO]);

        Atividade::add_atividade(Auth::user()->id, "Negocio Reativado ", $negocio_id);

        return back()->with('status', "Negócio ativado com sucesso ");
    }

    public function massive_change(Request $request)
    {


        $input = $request->all();

        $curr_funil_id = intval($input['id']);
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

            $negocios = $input['negocios'];
            $novo_proprietario_id = $input['novo_proprietario_id'];

            $negocios = Negocio::whereIn('id', $negocios)->get();

            $novo_proprietario = NULL;

            $nome_destino = "Não Atribuido";
            if ($novo_proprietario_id != "-1") {
                $proprietario = User::find($novo_proprietario_id);
                $novo_proprietario = $proprietario->id;
                $nome_destino = $proprietario->name;
            }

            $count = 0;
            foreach ($negocios as $negocio) {
                $negocio->user_id = $novo_proprietario;
                $negocio->etapa_funil_id = $etapa_funils[1];

                $negocio->status = NegocioStatus::ATIVO;

                $negocio->save();
                $count = $count + 1;


                if ($novo_proprietario) {

                    Atividade::add_atividade(\Auth::user()->id, "Cliente Atribuido a " . User::find($novo_proprietario)->name, $negocio->id);
                } else {
                    Atividade::add_atividade(\Auth::user()->id, "Cliente colocado como não atribuido", $negocio->id);
                }

            }

            return back()->with('status', "Enviados " . $count . " negócios transferidos para " . $nome_destino);

        } elseif ($input['modo'] == "distribuir") {

            $usuarios = $input['usuarios'];
            $user_count = count($usuarios);
            $negocio_count = count($input['negocios']);

            $negocios = $input['negocios'];
            $negocios = Negocio::whereIn('id', $negocios)->get();

            $user_count_dist = 0;

            foreach ($negocios as $negocio) {

                $negocio->user_id = $usuarios[$user_count_dist];
                $negocio->etapa_funil_id = $etapa_funils[1];
                $negocio->save();

                Atividade::add_atividade(\Auth::user()->id, "Cliente Distribuido para " . User::find($negocio->user_id)->name, $negocio->id);

                if ($user_count_dist + 1 == $user_count) {
                    $user_count_dist = 0;
                } else {
                    $user_count_dist = $user_count_dist + 1;
                }
            }
            return back()->with('status', "Distribuidos " . $negocio_count . " negócios para " . $user_count . " usuários.");

        } elseif ($input['modo'] == "redistribuir") {

            $usuarios = $input['usuarios'];
            $user_count = count($usuarios);
            $negocio_count = count($input['negocios']);

            $negocios = $input['negocios'];
            $negocios = Negocio::whereIn('id', $negocios)->get();

            $user_count_dist = 0;

            if ($user_count == 0) {
                return back()->with('error', "Nenhum usuário disponível para redistribuição.");
            }


            foreach ($negocios as $negocio) {

                $maxAttempts = $user_count; // Número máximo de tentativas para encontrar um usuário válido
                $attempts = 0;


                while ($negocio->user_id == $usuarios[$user_count_dist]) {
                    $user_count_dist = ($user_count_dist + 1) % $user_count; // Próximo usuário
                    $attempts++;

                    if ($attempts >= $maxAttempts) {
                        // Não encontrou um usuário válido, pule este negócio
                        continue 2; // Sai do `while` e passa para o próximo negócio no `foreach`
                    }
                }

                $negocio->user_id = $usuarios[$user_count_dist];
                $negocio->etapa_funil_id = $etapa_funils[1];

                $nome_a = explode(' ', $negocio->lead->nome);
                $nome = $negocio->lead->nome;
                if (count($nome_a) > 2) {
                    $nome = $nome_a[0];
                }


                $negocio->titulo = "Negócio " . $nome . " - " . $negocio->tipo;
                $negocio->created_at = now();
                $negocio->data_criacao = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
                $negocio->updated_at = now();
                $negocio->status = NegocioStatus::ATIVO;
                $negocio->save();

                Atividade::add_atividade(\Auth::user()->id, "Cliente Redistribuido para " . User::find($negocio->user_id)->name, $negocio->id);

                // Avança para o próximo usuário na lista
                $user_count_dist = ($user_count_dist + 1) % $user_count;
            }
            return back()->with('status', "Distribuidos " . $negocio_count . " negócios para " . $user_count . " usuários.");

        } elseif ($input['modo'] == "desativar") {
            $negocios = $input['negocios'];
            $negocios = Negocio::whereIn('id', $negocios)->get();
            $user_count_dist = 0;
            foreach ($negocios as $negocio) {
                $negocio->status = NegocioStatus::INATIVO;
                #$negocio->user_id = NULL;
                $negocio->save();

                Atividade::add_atividade(\Auth::user()->id, "Negocio Desativado", $negocio->id);
                $user_count_dist = $user_count_dist + 1;
            }
            return back()->with('status', "Foram desativados " . $user_count_dist . " negócios.");

        } elseif ($input['modo'] == "ativar") {
            $negocios = $input['negocios'];
            $negocios = Negocio::whereIn('id', $negocios)->get();
            $user_count_dist = 0;
            foreach ($negocios as $negocio) {
                $negocio->status = NegocioStatus::ATIVO;
                #$negocio->user_id = NULL;
                $negocio->save();

                Atividade::add_atividade(\Auth::user()->id, "Negocio Ativado", $negocio->id);
                $user_count_dist = $user_count_dist + 1;
            }
            return back()->with('status', "Ativados " . $user_count_dist . " negócios.");


        } elseif ($input['modo'] == "deletar") {

            if (config("permitir_deletar_negocio") == "true") {

                if ($input['deletar_challenger'] != 'DELETAR') {
                    return back()->with('status_error', "Palavra DELETAR Escrita incorretamente");
                }

                $negocios = $input['negocios'];
                $negocios = Negocio::whereIn('id', $negocios)->get();
                $user_count_dist = 0;
                foreach ($negocios as $negocio) {
                    $negocio_id = $negocio->id;

                    #TODO remover reunião também
                    Atividade::where('negocio_id', $negocio_id)->delete(); #ok
                    $negocio->agendamentos()->each(function ($agendamento) {
                        if ($agendamento->reuniao) {
                            $agendamento->reuniao->delete();
                        }
                        $agendamento->delete();
                    });

                    $negocio->propostas()->each(function ($proposta) {
                        $proposta->delete();
                    });

                    $negocio->aprovacoes()->each(function ($aprovacao) {
                        $aprovacao->delete();
                    });

                    $lead = $negocio->lead;

                    Levantamento::where('negocio_id', $negocio_id)->delete();
                    NegocioComentario::where('negocio_id', $negocio_id)->delete();
                    Perda::where('negocio_id', $negocio_id)->delete();

                    Simulacao::where('negocio_id', $negocio_id)->each(function ($simulacao) {

                        $simulacao->financiamentos->each(function ($simulacao) {
                            $simulacao->delete();
                        });

                        $simulacao->consorcios->each(function ($simulacao) {
                            $simulacao->delete();
                        });


                        $simulacao->delete();
                    });

                    $fechamento = $negocio->fechamento();

                    $negocio->delete();

                    if ($fechamento) {
                        $fechamento->delete();
                    }


                    $lead->delete();



                    $user_count_dist = $user_count_dist + 1;
                }
                return back()->with('status', "Foram Deletados " . $user_count_dist . " negócios.");

            } else {
                return back()->with('status_error', "Não é permitido deletar negócios, contate o adminstrador");
            }



        } else {
            return back()->with('status_error', "modo de distribuição invalido: " . $input['modo']);
        }
    }
}