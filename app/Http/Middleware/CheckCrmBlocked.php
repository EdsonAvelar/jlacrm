<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCrmBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifique se a aplicação está em modo bloqueado
        // if (config('crm.blocked')) {
        if (true) {
            // Redireciona para uma página de aviso
            return response()->view('crm_blocked');
        } else {

            // Se não estiver bloqueado, prossiga com a requisição
            return $next($request);
        }

    }
}
