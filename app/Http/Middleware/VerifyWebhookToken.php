<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyWebhookToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $token_webhook = config('token_webhook');

        if ($token !== $token_webhook) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
