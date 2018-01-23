<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;


use App\Parametros;
use App\Pais;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        foreach (Parametros::all() as $key => $value) {
            eval(" \$this->$value->atributo = $value->valor ;");

            View::share($value->atributo, $value->valor);

            $monedas = Pais::where('cambio_actual', '>', 0)->orderBy('moneda')->pluck('moneda', 'moneda');
            $version = "version=".HelperController::getLastMixUpdate();
        }
        
        $this->timezone = config('timezone');

        View::share('monedas', $monedas);
        View::share('version', $version);
        View::share('meta_og_title', 'Mybooktravel');
        View::share('meta_og_description', 'Alquileres vacacionales casas, departamentos, cabañas | Chile, Viña del Mar, Concon, La Serena, Pucon');
        View::share('meta_og_image', asset('img/logo_mbt.png'));
        View::share('meta_og_type', 'website');

        View::share('lang', 'es_CL.UTF-8');




        // echo $this->PorcentajePublicacion;die;
    }
}
