<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Auth;
use App\IpLigence;
use App\Pais;

class ValorMoneda
{
	public function handle($request, Closure $next, $guard = null)
	{
		if (!session()->has('moneda')) {
			/*
			$ip = $_SERVER['REMOTE_ADDR'];

			# o haz la prueba con una IP de Google
			# $ip = '74.125.224.72';

			# Contiene el texto como JSON que retorna geoplugin a partir de la IP
			# Puedes usar un método más sofisticado para hacer un llamado a geoplugin 
			# usando librerias como UNIREST etc
			$informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

			# Convertir el texto JSON en un array
			$dataSolicitud = json_decode(informacionSolicitud);

			# Ver contenido del array
			var_dump($dataArray);
			*/
			#$ip = isset($_SERVER['X-Real-IP']) ?? $_SERVER['REMOTE_ADDR'];
			
			$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
				
			if ($ip <> '::1') {
				$d = 0.0;
				$b = explode(".", $ip,4);
				for ($i = 0; $i < 4; $i++) {
					$d *= 256.0;
					$d += $b[$i];
				};
				
				$country_code = IpLigence::where('ip_from', '<=', $d)->where('ip_to', '>=', $d)->first()['country_code'];
				if ($country_code) {
					$moneda = Pais::where('iso2', $country_code)->first()['moneda'];
					HelperController::valorDolarMoneda($moneda);
				} elseif(Auth::guard($guard)->check() && Auth::user()->divisa) {
					HelperController::valorDolarMoneda(Auth::user()->divisa);	
				}else{
					HelperController::valorDolarMoneda('CLP');
				}
			}else{
				HelperController::valorDolarMoneda('CLP');
			}
			
		}
		return $next($request);
	}
}
