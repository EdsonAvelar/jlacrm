<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index(Request $request) {

        
        $mode = $request->query('hub_mode');
        $challenger = $request->query('hub_challenge');
        $verify_token = $request->query('hub_verify_token');

        if ($verify_token ==  "da39a3ee5e6b4b0d3255bfef95601890afd80709"){
            if ($mode == "subscribe"){
                return $challenger; 
            }else {
                return "mode validation failed";
            }
        }else {
            return "token validation failed";
        }

       
       
    }
}
