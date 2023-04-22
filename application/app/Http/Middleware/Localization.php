<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
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
        // Verifica se o parâmetro de HTTP Accept-Language foi configurado pelo usuário
        // Caso não exista, o padrão será definido no arquivo config/app.php 
        if($request->hasHeader('Accept-Language')) {
            App::setLocale($request->header("Accept-Language"));
        }
        return $next($request);
    }
}
