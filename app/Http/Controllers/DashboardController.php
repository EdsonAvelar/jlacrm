<?php

namespace App\Http\Controllers;
use App\Models\Agendamento;
use Auth;
use Illuminate\Http\Request;
use App\Enums\NegocioStatus;
use Carbon\Carbon;
use App\Models\Negocio;
use App\Models\Venda;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Reuniao;
use App\Models\Aprovacao;

class DashboardController extends Controller
{
    
    public function dashboard(Request $request){
        
        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        if ( is_null($data_inicio) and is_null($data_fim) ){
            $data_inicio = "20/".(Carbon::now('America/Sao_Paulo')->subMonth(1)->format('m/Y'));
            $data_fim = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }

        if ( Auth::user()->hasRole('admin')){

            $stats = [];

            $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y',$data_fim)->format('Y-m-d');

            $stats['total_vendido'] = Venda::whereBetween('data_fechamento', [$from, $to])->sum('valor');
            $stats['leads_ativos'] = Negocio::where('status',NegocioStatus::ATIVO)->count();
            $stats['potencial_venda'] = Negocio::where('status',NegocioStatus::ATIVO)->sum('valor');

           

            //Agendamento::where($query)
            $cargo = Cargo::where( 'nome','Vendedor')->orWhere('nome','Coordenador')->first();
            $users = User::where('cargo_id',$cargo->id)->get();

            $vendedores = array();
            $agendamentos = array();
            $reunioes = array();
            $aprovacoes = array();
            $vendas = array();

            foreach ($users as $vendedor){
                $query = [
                    ['data_agendado', '>=', $from ],
                    ['data_agendado', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];
                
                $count = Agendamento::where($query)->count();
                array_push($vendedores, $vendedor->name);
                array_push($agendamentos, $count);

                $query = [
                    ['data_reuniao', '>=', $from ],
                    ['data_reuniao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];
                
                $count = Reuniao::where($query)->count();
                array_push($reunioes, $count);

                
                $query = [
                    ['data_aprovacao', '>=', $from ],
                    ['data_aprovacao', '<=', $to],
                    ['user_id', '=', $vendedor->id]
                ];
                
                $count = Aprovacao::where($query)->count();
                array_push($aprovacoes, $count);

                $query = [
                    ['data_fechamento', '>=', $from ],
                    ['data_fechamento', '<=', $to],
                    ['vendedor_principal_id', '=', $vendedor->id]
                ];
                
                $vendas_totais = Venda::where($query)->sum('valor');
                array_push($vendas, $vendas_totais);
            }
                        
            $lead_novos = Negocio::where(['user_id' => NULL, 'status' => 'ativo' ])->count();
            return view('dashboards.admin', compact('stats','vendedores','agendamentos','lead_novos','reunioes','aprovacoes','vendas'));
        }else {

            return redirect( route('pipeline_index', array('id' => 1, 'proprietario' =>  \Auth::user()->id,'status'=> 'ativo') ) );
        }
        
    }

}
