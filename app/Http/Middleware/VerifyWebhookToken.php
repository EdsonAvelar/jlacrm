<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyWebhookToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if ($token !== '123') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
