<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Enums\NegocioStatus;
use Carbon\Carbon;
use App\Models\Negocio;
use App\Models\Venda;

class DashboardController extends Controller
{
    
    public function dashboard(Request $request){
        
        $data_inicio = $request->query('data_inicio');
        $data_fim = $request->query('data_fim');

        if ( is_null($data_inicio) and is_null($data_fim) ){
            $data_inicio = "20/".(Carbon::now()->subMonth()->format('m/Y'));
            $data_fim = "20/".(Carbon::now()->format('m/Y'));
            return \Redirect::route('home', array('data_inicio' => $data_inicio, 'data_fim' => $data_fim));
        }

        if ( Auth::user()->hasRole('admin')){

            $stats = [];

          
            $from = Carbon::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y',$data_fim)->format('Y-m-d');

            $stats['total_vendido'] = Venda::whereBetween('data_fechamento', [$from, $to])->sum('valor');

            $stats['leads_ativos'] = Negocio::where('status',NegocioStatus::ATIVO)->count();

            $stats['potencial_venda'] = Negocio::where('status',NegocioStatus::ATIVO)->sum('valor');



            return view('dashboard', compact('stats'));
        }
        
    }

}
