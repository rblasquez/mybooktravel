<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerificarAdministrador
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()->tipo_usuario != 'A') {
			// Auth::logout();
            return redirect()->route('index');
        }
        return $next($request);
    }
}
