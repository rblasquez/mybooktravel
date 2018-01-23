<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Http\Controllers\Administracion\CuponDescuentoController;

use App\Propiedad;
use App\Pais;
use App\Parametros;
use App\User;
use App\PropiedadImagen;

use Auth;
use Carbon\Carbon;

class HelperController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function imagenABase64($ruta_relativa_al_public)
    {
        $path = $ruta_relativa_al_public;

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = \File::get($path);

        $base64 = "";
        if ($type == "svg") {
            $base64 = "data:image/svg+xml;base64,".base64_encode($data);
        } else {
            $base64 = "data:image/". $type .";base64,".base64_encode($data);
        }

        return $base64;
    }

    public static function verifyOverlapSqlIntervals($start_first, $end_first, $start_second, $end_second)
    {
        $conditions = "( $start_first BETWEEN $start_second AND $end_second )
		OR ( $end_first BETWEEN $start_second AND $end_second )
		OR ( $start_second BETWEEN $start_first AND $end_first )
		OR ( $end_second BETWEEN $start_first AND $end_first )";

        $case = "CASE WHEN ( $conditions ) THEN true ELSE false END";
        return $case;
    }

    public static function echoPre($variable)
    {
        echo "<pre>";
        print_r($variable);
        echo "</pre>";
    }

    public static function diferenciaFechas($fecha1, $fecha2, $formato)
    {
        $fecha1 = strtotime($fecha1);
        $fecha2 = strtotime($fecha2);
        $diferencia = $fecha2 - $fecha1;
        switch ($formato) {
            case 'minutes': $diferencia = $diferencia / 60 ;
            break;
            case 'hours': $diferencia = $diferencia / 60 / 60 ;
            break;
            case 'days': $diferencia = $diferencia / 60 / 60 / 24 ;
            break;
        }
        return  $diferencia;
    }

    public static function actualizarTasaCambioMoneda($key)
    {
        $interval = 120;

        $last_update = \DB::table('paises')
        ->select('fecha_cambio_actual')
        ->max('fecha_cambio_actual');
        $current_time = date('Y-m-d H:i:s');
        $t = ceil(HelperController::diferenciaFechas($last_update, $current_time, 'minutes'));
        echo "Han transcurrido $t minutos desde la ultima actualizacion \n";

        if ($t < $interval) {
            echo "Deben transcurrir al menos $interval minutos para poder actualizar \n";
        } else {
            $entorno = (isset($_SERVER['HTTPS'])) ? 'https' : 'http' ;

            // $app_key = '0f5e769f9a554767946243ce5ac56acd'; # Juan Mbt, Access restricted until 2017-09-25 (reason: too_many_requests)
            // $app_key = '5bd249cd14de44b99f40fb4ad57a106a'; # Rosmar
            // $app_key = 'f91cf2a3f0fc4c23baf22684a8ab224a'; # Juan
            $keys = [
                0 => '0f5e769f9a554767946243ce5ac56acd',# Juan Mbt,
                1 => '5bd249cd14de44b99f40fb4ad57a106a',# Rosmar
                2 => 'f91cf2a3f0fc4c23baf22684a8ab224a',# Juan
            ];

            $app_key = $keys[$key];

            $url = $entorno."://openexchangerates.org/api/latest.json?app_id=".$app_key;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data_json = curl_exec($ch);
            curl_close($ch);
            $data_array = json_decode($data_json, true);
            // HelperController::echoPre($data_array);

            $message = "";
            if (isset($data_array['error'])) {
                $next_key = $key+1;
                $message = "Api $key: ".$data_array['description'];
                $message.= "\n Intentando siguiente api: $next_key \n";
                echo $message;

                if (isset($keys[$next_key])) {
                    HelperController::actualizarTasaCambioMoneda($next_key);
                } else {
                    echo "no existe la key $next_key \n ";
                }
            } else {
                // echo "guardar";
                // HelperController::echoPre($data_array);
                if (isset($data_array['rates'])) {
                    foreach ($data_array['rates'] as $currency => $value) {
                        //
                        $pais = Pais::where('moneda', '=', $currency);
                        if ($pais->count() > 0) {
                            $updated = Pais::where('moneda', '=', $currency)
                            ->update([
                                'cambio_actual' => $value,
                                'fecha_cambio_actual' => date('Y-m-d H:i:s')
                            ]);

                            $message .= "Actualizados: ".$updated." paises. Moneda: ".$currency.". Valor: ".$value."\n";
                        }
                    }
                }
                echo $message;
            }
        }
    }

    public static function getUrlImg($user_id, $img, $size = null)
    {
        $ruta = 'alojamientos/usuario_'.$user_id.'/'.$img.'/'.($size ?? 'lg').'.jpg';
        $disco = Storage::disk('minio');

        if (!$disco->exists($ruta)) {
            $ruta = $img;
            if (!$ruta) {
                return asset('img/casa.jpg');
            }
        }

        return $disco->url($ruta);
        # return $disco->temporaryUrl($ruta, \Carbon\Carbon::now()->addMinutes(30));
        # return asset('storage/'.$ruta);
    }

    public static function valorDolarMoneda($moneda = 'CLP')
    {
        # se halla la moneda solicitada por el usuario
        $moneda_solicitada = Pais::where('moneda', '=', $moneda)->first();

        $session = [];
        if ($moneda_solicitada) {
            $solicitada = $moneda_solicitada;
            $valor = $solicitada->cambio_actual;
            # echo "el valor de la moneda solicitada es: ".$solicitada->cambio_actual;

            # se genera la lista de valores de monedas
            $monedas = Pais::select('moneda', 'cambio_actual')
            ->where('cambio_actual', '>', 0)->pluck('cambio_actual', 'moneda');

            if ($monedas->count() > 0) {
                $session =[
                    'moneda' 	=> $moneda,
                    'valor' 	=> $valor,
                    'monedas'	=> $monedas
                ];
            }
        }

        session($session);
    }

    public static function getRealSqlQuery($model)
    {
        $sql = $model->toSql();
        $bindings = $model->getBindings();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'".$binding."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public static function getLastMixUpdate()
    {
        $path = "last_mix_update.txt";
        $time = date('YmdHis');
        // echo $path;
        // echo $time;
        if (file_exists($path)) {
            $time = file_get_contents($path);
            // echo $time;
        }

        return $time;
    }

    public function calcularNoches($request, Propiedad $propiedad)
    {
        # return $request->all();
        $fecha = new FechasController;

        if ($request->fecha_ini && $request->fecha_fin) {
            $response   = collect();
            $fecha_ini	= $fecha->formato($request->fecha_ini);
            $fecha_fin	= $fecha->formato($request->fecha_fin);

            $noches     = $fecha->diasDiferencia($request->fecha_ini, $request->fecha_fin);

            $fecha_hora_entrada = $fecha->formatoFechaHora($request->fecha_ini, $propiedad->detalles->checkin)->format('c');
            $fecha_hora_salida = $fecha->formatoFechaHora($request->fecha_fin, $propiedad->detalles->checkout)->format('c');

            $propiedad  = Propiedad::ByPropiedad($propiedad->id)->ByDisponible($fecha_hora_entrada, $fecha_hora_salida)->first();

            if ($propiedad) {
                $desgloce_precios = Propiedad::obtenerPrecios($propiedad->id, $request->fecha_ini, $request->fecha_fin);

                $precio_promedio = $desgloce_precios->promedio * (($this->PorcentajePublicacion/100) + 1);
                $precio_base = ($precio_promedio * $noches);

                $tarifa_servicio = ($desgloce_precios->promedio * $noches) * (($this->PorcentajeReserva/100));
                $gastos_limpieza = $propiedad->administracion->aseo_unico;
                $total = $precio_base + $tarifa_servicio + $gastos_limpieza;

                # inicio cupon descuento
                if ($request->codigo_promocional) {
                    $cupon = CuponDescuentoController::verificarAplicacionCupon(
                        $propiedad,
                        $request->fecha_ini,
                        $request->fecha_fin,
                        str_replace('-', '', $request->codigo_promocional)
                    );

                    if ($cupon['valido']) {
                        $tipo_descuento = $cupon['cupon']['campania']['n_modo_aplicacion_descuento_id'];
                        $valor_descuento = $cupon['cupon']['campania']['valor'];
                        if ($tipo_descuento == 1) { # 1 es fijo
                            $monto_descuento = $valor_descuento;
                        } elseif ($tipo_descuento == 2) { # 2 es porcentual
                            $monto_descuento = ($total * $valor_descuento) / 100;
                        }
                        $total = $total - $monto_descuento;

                        $response->put('total_descuento_cupon', cambioMoneda($monto_descuento, 'CLP', session('valor')));
                        $response->put('total_no_descuento_cupon', cambioMoneda($total + $monto_descuento, 'CLP', session('valor')));
                    } else {
                        $response->put('cupon_invalido', $cupon['mensaje']);
                    }
                }
                # fin cupon descuento


                $response->put('desgloce', $desgloce_precios);
                $response->put('noches', $noches);
                $response->put('precio_promedio', cambioMoneda($precio_promedio, $propiedad->administracion->moneda, session('valor')));
                $response->put('precio_base', cambioMoneda($precio_base, $propiedad->administracion->moneda, session('valor')));
                $response->put('tarifa_servicio', cambioMoneda($tarifa_servicio, $propiedad->administracion->moneda, session('valor')));
                $response->put('gastos_limpieza', cambioMoneda($gastos_limpieza, $propiedad->administracion->moneda, session('valor')));
                $response->put('total', cambioMoneda($total, $propiedad->administracion->moneda, session('valor')));


                if (session('moneda') <> 'CLP') {
                    $monto = number_format($total, 0, '', ',');
                    $response->put('total_clp', $monto);
                }

                return $response;
            }
        }
    }

    public function costoPropiedad($propiedad, $checkin = null, $checkout = null)
    {
        $fecha = new FechasController;

        $fecha_entrada = $fecha->formato($checkin);
        $fecha_salida = $fecha->formato($checkout);

        if (isset($checkin) && isset($checkout)) {
            $propiedad = Propiedad::ByPropiedad($propiedad->id)
            ->ByDisponible($fecha->formatoFechaHora($fecha_entrada, $propiedad->detalles->checkin), $fecha->formatoFechaHora($fecha_salida, $propiedad->detalles->checkout))
            ->first();
            $desgloce_precios = Propiedad::obtenerPrecios($propiedad->id, $fecha_entrada, $fecha_salida->subDay());
            $monto = $desgloce_precios->promedio;
        } else {
            $precioActual = Propiedad::where('propiedades.id', $propiedad->id)
            ->join('propiedades_precios_especificos', function ($join) use ($fecha_entrada) {
                $join->on('propiedades_precios_especificos.propiedad_id', '=', 'propiedades.id')
                ->whereBetween("fecha_inicio", [$fecha_entrada->format('Y-m-d 00:01'), $fecha_entrada->format('Y-m-d 23:59')]);
            })
            ->select('propiedades_precios_especificos.*')
            ->first();

            if ($precioActual) {
                $monto = $precioActual->precio;
            } else {
                $monto = $propiedad->administracion->precio;
            }
        }

        $precio = $monto * (($this->PorcentajePublicacion / 100) + 1);
        return cambioMoneda($precio, $propiedad->administracion->moneda, session('valor'));
    }
    /*
    public function costoPropiedad($propiedad)
    {
        $fecha = new FechasController;
        $fecha = $fecha->formato(Carbon::parse());

        $precioActual = Propiedad::where('propiedades.id', $propiedad->id)
        ->join('propiedades_precios_especificos', function ($join) use ($fecha) {
            $join->on('propiedades_precios_especificos.propiedad_id', '=', 'propiedades.id')
            ->whereBetween("fecha_inicio", [$fecha->format('Y-m-d 00:01'), $fecha->format('Y-m-d 23:59')]);
        })
        ->select('propiedades_precios_especificos.*')
        ->first();

        if ($precioActual) {
            $monto = $precioActual->precio;
        } else {
            $monto = $propiedad->administracion->precio;
        }

        $precio = $monto * (($this->PorcentajePublicacion / 100) + 1);
        return cambioMoneda($precio, $propiedad->administracion->moneda, session('valor'));
    }
    */
    
    public static function totalPagado($reserva)
    {
        $totalAbonado = 0;
        $existe_pago_no_aprobado = false;

        if (count($reserva->pagoDeposito) > 0) {
            foreach ($reserva->pagoDeposito as $key => $deposito) {
                $totalAbonado += (gettype($deposito->estatus) == 'NULL' || $deposito->estatus == true) ? $deposito->monto : 0;
                if (gettype($deposito->estatus) == 'NULL') {
                    $existe_pago_no_aprobado = true;
                }
            }
        }

        if (count($reserva->pagoWesternUnion) > 0) {
            foreach ($reserva->pagoWesternUnion as $key => $western) {
                $totalAbonado += (gettype($western->estatus) == 'NULL' || (gettype($western->estatus) == 'boolean' && $western->estatus == true)) ? $western->monto : 0;
                if (gettype($western->estatus) == 'NULL') {
                    $existe_pago_no_aprobado = true;
                }
            }
        }

        if (count($reserva->pagoWebPay->where('estado', 'ACEPTADO'))) {
            foreach ($reserva->pagoWebPay->where('estado', 'ACEPTADO') as $key => $pago) {
                $totalAbonado += $pago->amount;
            }
        }

        $porcentaje_aceptado = $reserva->propiedad->administracion->garantia->porcentaje_aceptado ?? 100;

        $minimo_requerido = ($porcentaje_aceptado * $reserva->total_pago) / 100;
        # $monto_restante = $minimo_requerido - $totalAbonado;
        $monto_restante = $reserva->total_pago - $totalAbonado;

        return collect([
            'total_abonado'             => $totalAbonado,
            'minimo_requerido'          => $minimo_requerido,
            'monto_restante'            => $monto_restante,
            'existe_pago_no_aprobado'   => $existe_pago_no_aprobado
        ]);
    }

    public function migrarImagenes($variable)
    {
        # echo "entro";
        $imagen = PropiedadImagen::whereNull('carpeta')->orderBy('id')->first();
        # echo "antes: ".$imagen->id;
        # return $imagen;
        if ($imagen) {
            $id = $imagen->id;
            echo "id: ".$id;
            $disco = Storage::disk('minio');
            $imgage_format = 'jpg';

            $imagen_ruta_original = $disco->temporaryUrl($imagen->ruta, \Carbon\Carbon::now()->addMinutes(30));
            #$imagen_ruta_original = storage_path('app/public/'.$imagen->ruta);
            if ($disco->exists($imagen->ruta)) {
                $extension  = strtolower(collect(explode(".", $imagen->ruta))->last());
                $size = getimagesize($imagen_ruta_original);
                $width = 20 * $size[0] / 100;

                $carpeta = md5(date('YmdHis')) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
                $ruta = 'alojamientos/usuario_'.$imagen->propiedad->usuario->id.'/'.$carpeta;

                $temporal_image = Image::make($imagen_ruta_original);

                $watermark_image = Image::make('img/watermark.png');
                $watermark_image->resize(round($width), null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image_original = Image::make($imagen_ruta_original);
                $image_original->resize(null, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->stream()
                ->detach();

                $image_large = Image::make($imagen_ruta_original);
                $image_large->orientate()
                ->insert($watermark_image, 'bottom-right', 20, 10)
                ->resize(null, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode($imgage_format)
                ->stream()
                ->detach();

                $image_medium = Image::make($imagen_ruta_original);
                $image_medium->orientate()
                ->resize(null, 480, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode($imgage_format)
                ->stream()
                ->detach();

                $image_small = Image::make($imagen_ruta_original);
                $image_small->orientate()
                ->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode($imgage_format)
                ->stream()
                ->detach();

                $image_original_save = $disco->put($ruta.'/base.'.$extension, $image_original->__toString());
                $image_large_save = $disco->put($ruta.'/lg.'.$imgage_format, $image_large->__toString());
                $image_medium_save = $disco->put($ruta.'/md.'.$imgage_format, $image_medium->__toString());
                $image_small_save = $disco->put($ruta.'/sm.'.$imgage_format, $image_small->__toString());


                if ($image_original_save && $image_large_save && $image_medium_save && $image_small_save) {
                    $imagen->carpeta = $carpeta;
                    $imagen->save();
                }
            } else {
                echo 'no existe imagen '.$imagen->id;
                $imagen->carpeta = 'Imagen no existe';
                $imagen->save();
                die;
            }

            $procesadas = PropiedadImagen::whereNotNull('carpeta')->count();
            $sinProcesar = PropiedadImagen::whereNull('carpeta')->count();
            $total = $procesadas+$sinProcesar;
            $porcentaje = ($procesadas *100) / $total;

            echo '<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title></title>
			<link rel="stylesheet" href="">
			</head>
			<body>
			<h1>
			Procesadas: '.$procesadas.'<br>
			Pendientes: '.$sinProcesar.'<br>
			Porcentaje: '.$porcentaje.'<br>
			</h1>
			<script>document.location = "https://mybooktravel.com/estructura/imagenes/'.date('His').'";</script>
			</body>
			</html>';
        } else {
            echo 'Nada que cambiar';
        }
    }
}
