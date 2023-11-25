<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index(Request $request) {

        
        $mode = $request->query('hub_mode');
        $challenger = $request->query('hub_challenge');
        $verify_token = $request->query('hub_verify_token');

        $data = [ 
            "hub.mode" => $mode,
            "hub.challenge" => $challenger,
            "hub.verify_token" => "da39a3ee5e6b4b0d3255bfef95601890afd80709"
        ];
            
        return $challenger; 
    }
}
