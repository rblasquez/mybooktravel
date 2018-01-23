<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerificarRegistro
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()->estatus == false) {
            return redirect()->route('verificar.email');
        }
        return $next($request);
    }
}
