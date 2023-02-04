<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Enums\NegocioStatus;

use App\Models\Negocio;

class DashboardController extends Controller
{
    
    public function dashboard(Request $request){
        

        if ( Auth::user()->hasRole('admin')){

            
            $stats = [];

            $stats['leads_ativos'] = Negocio::where('status',NegocioStatus::ATIVO)->count();


            return view('dashboard', compact('stats'));
        }
        
    }

}
