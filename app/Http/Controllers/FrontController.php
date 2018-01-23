<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\EmailPrueba;
use Illuminate\Support\Facades\Mail;

use App\Reserva;
use App\Propiedad;
use App\Pais;
use App\PropiedadUbicacion;
use App\Mail\CargarPropiedad; // jestrada 2017-11-06 prueba envio de email
use App\Http\Controllers\Administracion\CuponDescuentoController;

use Auth;
use Meta;
use DB;
use Carbon\Carbon;
use App\IpLigence;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FechasController;

class FrontController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        Meta::set('title', 'Mybooktravel');
        Meta::set('description', 'Alquileres vacacionales casas, departamentos, cabañas | Chile, Viña del Mar, Concon, La Serena, Pucon');
        $propiedades = Propiedad::join('propiedades_administracion', 'propiedades.id', '=', 'propiedades_administracion.propiedad_id')
        ->join('propiedades_imagenes', 'propiedades.id', '=', 'propiedades_imagenes.propiedad_id')
        ->distinct()
        ->select('propiedades.*')
        ->whereIn('propiedades.id', [150, 192, 180, 172])
        ->get();

        $lugares = collect(['serena' => [
                    'lugar' => 'La Serena',
                    'lat_min' => -29.953317192714483,
                    'lat_max' => -29.84454433631571,
                    'min_lng' => -71.31837255859386,
                    'max_lng' => -71.17005078125021,
                ],
                'vinia' => [
                    'lugar' => 'Viña del Mar',
                    'lat_min' => -33.058331446357684,
                    'lat_max' => -32.945329481700966,
                    'min_lng' => -71.58822424316406,
                    'max_lng' => -71.46942822265635,
                ],
                'concon' => [
                    'lugar' => 'Concón',
                    'lat_min' => -32.95180175810558,
                    'lat_max' => -32.91276672197713,
                    'min_lng' => -71.56213171386736,
                    'max_lng' => -71.49449078369162,
                ],
                'pucon' => [
                    'lugar' => 'Pucón',
                    'lat_min' => -39.29925317022208,
                    'lat_max' => -39.266709083560656,
                    'min_lng' => -71.99471838378906,
                    'max_lng' => -71.91746441650412,
                ],
                'maitencillo' => [
                    'lugar' => 'Maitencillo',
                    'lat_min' => -32.6976288923101,
                    'lat_max' => -32.56883348591596,
                    'min_lng' => -71.52642614746117,
                    'max_lng' => -71.36059490966773,
                ],
                'renaca' => [
                    'lugar' => 'Reñaca',
                    'lat_min' => -32.99817237882023,
                    'lat_max' => -32.94619381640774,
                    'min_lng' => -71.58273107910173,
                    'max_lng' => -71.50067059326148,
                ],
                'santiago' => [
                    'lugar' => 'Santiago',
                    'lat_min' => -33.678800654877755,
                    'lat_max' => -33.26541672999623,
                    'min_lng' => -70.93659765625006,
                    'max_lng' => -70.39208142089859,
                ],
                'coquimbo' => [
                    'lugar' => 'Coquimbo',
                    'lat_min' => -30.044300094321216,
                    'lat_max' => -29.92074968988513,
                    'min_lng' => -71.4035166015625,
                    'max_lng' => -71.23253552246103,
                ],
            ]);

        $consulta = '';
        $i = 0;
        foreach ($lugares as $key => $lugar) {
            if ($i > 0) {
                $consulta .= 'UNION ';
            }
            $consulta .= 'SELECT ';
            $consulta .= 'count(*) AS cantidad, ubicacion, min(valor) AS precio ';
            $consulta .= 'FROM (';
            $consulta .= 'SELECT ';
            $consulta .= "propiedades.id,'".$lugar['lugar']."'::text as ubicacion, public.cambio_moneda(propiedades_administracion.precio, propiedades_administracion.moneda, paises.cambio_actual, '".session('moneda')."', ".session('valor').") as valor ";
            $consulta .= 'FROM ';
            $consulta .= '"propiedades" ';
            $consulta .= 'INNER JOIN propiedades_ubicaciones ON propiedades.id = propiedades_ubicaciones.propiedad_id ';
            $consulta .= 'INNER JOIN propiedades_administracion ON propiedades_administracion.propiedad_id = propiedades.id ';
            $consulta .= 'INNER JOIN paises ON propiedades_administracion.moneda = paises.moneda ';
            $consulta .= 'WHERE ';
            $consulta .= '(propiedades_ubicaciones.latitud BETWEEN '.$lugar['lat_min'].' AND '.$lugar['lat_max'];
            $consulta .= ' AND EXISTS (SELECT * FROM "propiedades_imagenes" WHERE "propiedades"."id" = "propiedades_imagenes"."propiedad_id")';
            $consulta .= 'AND ';
            $consulta .= 'propiedades_ubicaciones.longitud BETWEEN '.$lugar['min_lng'].' AND '.$lugar['max_lng'].') ';
            $consulta .= 'GROUP BY propiedades.id, propiedades_administracion.precio, propiedades_administracion.moneda, paises.cambio_actual';
            $consulta .= ') AS '.$key.' ';
            $consulta .= 'GROUP BY ubicacion ';

            $i++;
        }

        return view('index', [
            'propiedades' => $propiedades,
            'propiedades_principales' => DB::select($consulta), #$propiedades_principales,
        ]);
    }

    public function propiedadesCercanas($pais, $lat, $lng)
    {
        $pais_data = ($pais) ? Pais::where('iso2', $pais)->first() : 'no hay pais' ;

        $distancia = 70;

        $box = getBoundaries($lat, $lng, $distancia);

        $propiedades = PropiedadUbicacion::whereBetween('propiedades_ubicaciones.latitud', [$box['min_lat'], $box['max_lat']])
        ->whereBetween('propiedades_ubicaciones.longitud', [$box['min_lng'], $box['max_lng']])
        ->whereRaw('(6371 * ACOS(COS(RADIANS('.$lat.') ) * COS(RADIANS(propiedades_ubicaciones.latitud)) * COS(RADIANS(propiedades_ubicaciones.longitud)  - RADIANS('.$lng.')) + SIN(RADIANS('.$lat.')) *  SIN(RADIANS(propiedades_ubicaciones.latitud)))) < '. $distancia)
        ->where('propiedades_ubicaciones.pais', $pais_data->iso2)
        ->limit(4)
        ->get();

        return view('propiedades.partials.cercanas', ['propiedades' => $propiedades]);
    }

    public function calcularNoches(Request $request, $id)
    {
        # return $request->all();
        $propiedad = Propiedad::find($id);
        $calculo = new HelperController;
        $calculo = $calculo->calcularNoches($request, $propiedad);

        return view('propiedades.partials.aside', ['propiedad' => $propiedad, 'valores' => $calculo, 'request' => $request]);
    }

    public function informacion($parametro)
    {
        return view('informacion.'.$parametro);
    }

    public function pruebasRosmar(Request $request)
    {
        $reserva = Reserva::find(13);
        Mail::to($reserva->usuario->email)->queue(new \App\Mail\Reservas\Huesped\EsperarConfirmacion($reserva));
        echo $reserva->usuario->email;
        echo '<br>';
        echo '<br>';
        die;


        return view('pruebas');
        $propiedad = Propiedad::find(192);
        $helper = new HelperController;
        return $helper->costoPropiedad($propiedad);
        return view('pruebas');
        # return $disco = Storage::disk('minio')->url('/');
        dd($_SERVER);
        echo $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        die;
        # $ip = '201.213.0.1';
        # echo '<br>';
        # $d = 0.0;
        # $b = explode(".", $ip,4);
        # for ($i = 0; $i < 4; $i++) {
        # $d *= 256.0;
        # $d += $b[$i];
        # };
        # echo '<br>';
        # echo '<br>';

        # $country_code = IpLigence::where('ip_from', '<=', $d)->where('ip_to', '>=', $d)->first();
        # if ($country_code) {
        # dd($country_code);
        # }

        # die;

        return $ip = $_SERVER['REMOTE_ADDR'];
        return view('pruebas');
        # Mail::to('reblasquez@gmail.com')
        # ->queue(new EmailPrueba());
        # die;
        $propiedad = Propiedad::find(84);
        return view('pruebas', ['propiedad' => $propiedad]);
    }

    public function pruebasJuan()
    {
        // echo "correo queue";
        // $propiedad = Propiedad::find(180);
        // Mail::to('juancarlosestradanieto@gmail.com')->queue(new CargarPropiedad($propiedad));

        //datos de la reserva
        $propiedad = Propiedad::find(129);
        $fecha_inicio_reserva = '22-12-2017';
        $fecha_fin_reserva = '29-12-2017';
        $codigoCupon = 'C3273C2CA60FD926060D';
        $moneda_reserva = 'CLP';
        $monto_reserva = 100000;//monto reserva en la moneda indicada

        $result = CuponDescuentoController::obtenerMontoDescuentoCupon($propiedad, $fecha_inicio_reserva, $fecha_fin_reserva, $codigoCupon, $moneda_reserva, $monto_reserva);

        //siempre retorna
        $valido = $result['valido'];//retorna booleano
        $mensaje = $result['mensaje'];//descripcion de la validez o invalidez del cupon
        $cupon = $result['cupon'];//si el cupon no existe retorna null
        $monto_descuento = $result['monto_descuento'];//si el cupon no existe o no es valido retorna 0

        echo "<pre>mensaje<br>";
        print_r($mensaje);
        echo "</pre>";

        echo "<pre>monto_descuento<br>";
        print_r($monto_descuento);
        echo "</pre>";

        echo "<br>".strtotime('01-12-1990');
        echo "<br>".strtotime('1990-12-01');
    }
}
