<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

//models
use Auth;
use App\Propiedad;
use App\PropiedadPrecioEspecifico;
use App\DPropiedadesNochesMinimas;
use App\NMotivoBloqueo;
use App\Reserva;
use App\ReservaManual;
use App\Pais;

//requests
use App\Http\Requests\PropiedadActualizarCalendarioReservaManualRequest;
use App\Http\Requests\PropiedadActualizarCalendarioPrecioEspecificoRequest;
use App\Http\Requests\PropiedadActualizarCalendarioNochesMinimasRequest;

//controllers
use App\Http\Controllers\HelperController;

//mailers
use App\Mail\ComprobanteReservaManual;

class CalendarioController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function obtenerEventos($id)
    {
        $propiedad = Propiedad::byUsuario()->find($id);
        $events = [];

        if (count($propiedad) > 0) {
            $db_events = Propiedad::obtenerCalendario($id);
            $normal_events = collect($db_events);
            $bg_events = collect($db_events)
                        ->whereIn('tipo', ['reservas','reservas_manuales'])
                        ->toArray();

            $bg_events_processed = [];
            foreach ($bg_events as $current) {
                $current = (array)$current;
                $current['start'] = Carbon::parse($current['start'])->format('Y-m-d');
                $current['end'] = Carbon::parse($current['end'])->format('Y-m-d');
                $current['rendering'] = 'background' ;
                $current['imagen'] = '' ;
                $bg_events_processed[] = $current ;
            }

            $events = $normal_events->merge($bg_events_processed);
        }

        return response()->json([
            'events' =>  $events
        ]);
    }

    public function eliminarEvento(Request $request, $id)
    {
        $mensaje = "";
        $result = false;

        $propiedad = Propiedad::byUsuario()->find($id);
        if (count($propiedad) > 0) {
            $eliminada = ReservaManual::find($request->id)->delete();
            if ($eliminada) {
                $result = true;
            }
        }

        return response()->json([
            'success' =>  $result,
            "mensaje" => $mensaje
        ]);
        return 'eliminado';
    }

    public function obtenerFormulario($id, Request $request)
    {
        $propiedad = Propiedad::byUsuario()->find($id);
        $tipo = $request->tipo;

        $variables = [
            'motivo'=>$request->motivo,
            'modo'=>$request->modo,
            'propiedad'=>$propiedad,
        ];

        switch ($tipo) {
            case 'reservas':
            {
                $reserva = $propiedad->reservas()->find($request->id);
                $variables['reserva'] = $reserva;

                return view('propiedades.partials.edit.calendario.reservas', $variables);
            }
            break;
            case 'reservas_manuales':
            {
                if ($request->modo == 'update') {
                    $reserva_manual = Auth::user()->reservaManual()->find($request->id);
                    $variables['reserva_manual'] = $reserva_manual;
                }

                $paises = Pais::all()->pluck('nombre', 'id');
                $variables['paises'] = $paises;

                return view('propiedades.partials.edit.calendario.reservas_manuales', $variables);
            }
            break;
            case 'precios_especificos':
            {
                return view('propiedades.partials.edit.calendario.precios_especificos', $variables);
            }
            break;
            case 'noches_minimas':
            {
                return view('propiedades.partials.edit.calendario.noches_minimas', $variables);
            }
            break;
        }
    }

    public function actualizarReservaManual($id, PropiedadActualizarCalendarioReservaManualRequest $request)
    {
        $registered = false;
        $mensaje = "";

        $propiedad = Propiedad::byUsuario()->find($id);
        if (count($propiedad) > 0) {
            $modo = $request->modo;

            $fecha_inicio = $request->fecha_inicio_formato;
            $fecha_fin = $request->fecha_fin_formato;

            $cantidad_reservas_reales = Reserva::byPropiedad($id)
                                        ->byOcupada($fecha_inicio, $fecha_fin)
                                        ->count();

            $reservas_manuales = ReservaManual::byPropiedad($id)
                                        ->byOcupada($fecha_inicio, $fecha_fin);

            if ($modo == 'update') {
                $reservas_manuales = $reservas_manuales->where('id', '<>', $request->id);
            }
            $cantidad_reservas_manuales = $reservas_manuales->count();

            if ($cantidad_reservas_reales != 0 || $cantidad_reservas_manuales != 0) {
                $mensaje="El alojamiento no está disponible en ese intervalo.";
            } else {
                $motivo = NMotivoBloqueo::where('siglas', $request->motivo)->first();

                $datos = [
                    "fecha_inicio" => $fecha_inicio,
                    "fecha_fin"=>$fecha_fin,
                    "descripcion"=>$request->descripcion,
                    "nombres"=>$request->nombres,
                    "apellidos"=>$request->apellidos,
                    "telefono"=>$request->telefono,
                    "precio"=>$request->precio,
                    "costos_adicionales"=>$request->costos_adicionales,
                    "noches"=>$request->noches,
                    "monto_total"=>$request->monto_total,
                    "monto_anticipo"=>$request->monto_anticipo,
                    "monto_deuda_actual"=>$request->monto_deuda_actual,
                    "comprobante"=>$request->comprobante == "on" ? true : false,
                    "email"=>$request->email,
                    "n_motivo_bloqueo_id"=>$motivo->id ,
                    "propiedad_id"=>$id,
                    "paises_id"=>$request->paises_id,
                    "ciudad"=>$request->ciudad,
                ];

                if ($modo == 'update') {
                    $registered = Auth::user()->reservaManual()->find($request->id);
                    if ($registered) {
                        $registered->update($datos);
                    }
                } else {
                    $registered = Auth::user()->reservaManual()->create($datos);
                }

                if ($request->motivo == "reserva" && $request->comprobante == "on") {
                    // return $registered;
                    Mail::to($request->email)
                    ->send(new ComprobanteReservaManual($registered));
                }
            }

            $result = false;
            if ($registered) {
                $result = true;
            }
        }

        return response()->json([
            'success' =>  $result,
            "mensaje" => $mensaje
        ]);
    }

    public function actualizarPrecioEspecifico($id, PropiedadActualizarCalendarioPrecioEspecificoRequest $request)
    {
        $registered = false;
        $mensaje = "";
        $cantidad = 0;

        $propiedad = Propiedad::byUsuario()->find($id);
        if (count($propiedad) > 0) {
            $eventos = CalendarioController::separarEventosEnDias($request->fecha_inicio_formato, $request->fecha_fin_formato);

            foreach ($eventos as $evento) {
                // echo $evento['start'].": ".date('w',strtotime($evento['start']));
                // return ;
                // die;

                if (
                    $request->tipo_modificacion_precio == 'todas_las_fechas' ||
                    (
                        $request->tipo_modificacion_precio == 'fin_de_semana' &&
                        // Carbon::parse($evento['start'])->isWeekend()
                        in_array(date('w', strtotime($evento['start'])), $request->dias_de_la_semana ?? [])
                    )
                ) {
                    PropiedadPrecioEspecifico::whereRaw("
						to_char( fecha_inicio ,'YYYY-MM-DD' ) = '".date('Y-m-d', strtotime($evento['start']))."' and
						to_char( fecha_fin ,'YYYY-MM-DD' ) = '".date('Y-m-d', strtotime($evento['end']))."' and
						propiedad_id = $id
					")->delete();

                    $datos = [
                        "fecha_inicio" => $evento['start'],
                        "fecha_fin"=>$evento['end'],
                        "descripcion"=>$request->descripcion,
                        "precio"=>$request->precio,
                        "propiedad_id"=>$id,
                    ];

                    $registered = PropiedadPrecioEspecifico::create($datos);

                    $cantidad++;
                }
            }

            $result = false;
            if ($registered || $cantidad == 0) {
                $result = true;
            }
        }

        return response()->json([
            'success' =>  $result,
            "mensaje" => $mensaje
        ]);
    }

    public function obtenerPrecios(Request $request, $id)
    {
        $propiedad = Propiedad::byUsuario()->find($id);
        $precios = [];

        if (count($propiedad) > 0) {
            $precios = Propiedad::obtenerPrecios($id, $request->fecha_incio, $request->fecha_fin);
        }

        return response()->json($precios);
    }

    public function actualizarNochesMinimas($id, PropiedadActualizarCalendarioNochesMinimasRequest $request)
    {
        $registered = false;
        $mensaje = "";

        $propiedad = Propiedad::byUsuario()->find($id);
        if (count($propiedad) > 0) {
            $eventos = CalendarioController::separarEventosEnDias($request->fecha_inicio_formato, $request->fecha_fin_formato);

            foreach ($eventos as $evento) {
                $datos = [
                    "fecha_inicio" => $evento['start'],
                    "fecha_fin"=>$evento['end'],
                    "descripcion"=>$request->descripcion,
                    "noches"=>$request->noches,
                    "propiedad_id"=>$id,
                ];

                DPropiedadesNochesMinimas::whereRaw("
					to_char( fecha_inicio ,'YYYY-MM-DD' ) = '".date('Y-m-d', strtotime($evento['start']))."' and
					to_char( fecha_fin ,'YYYY-MM-DD' ) = '".date('Y-m-d', strtotime($evento['end']))."' and
					propiedad_id = $id
				")->delete();

                $registered = DPropiedadesNochesMinimas::create($datos);
            }

            $result = false;
            if ($registered) {
                $result = true;
            }
        }

        return response()->json([
            'success' =>  $result,
            "mensaje" => $mensaje
        ]);
    }

    public function obtenerNoches(Request $request, $id)
    {
        $propiedad = Propiedad::byUsuario()->find($id);
        $noches = [];

        if (count($propiedad) > 0) {
            $noches = Propiedad::obtenerNochesMinimas($id, $request->fecha_incio, $request->fecha_fin);
        }

        return response()->json($noches);
    }

    public static function generateDateRange($first, $last, $step = '+1 day', $format = 'Y-m-d H:i:sT')
    {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function separarEventosEnDias($start, $end)
    {
        $checkins = CalendarioController::generateDateRange($start, $end);
        $checkout_time_formtated = date('H:i:sT', strtotime($end));

        $events = [];
        $interval = '+1 day';
        foreach ($checkins as $checkin_datetime_formated) {
            $checkin_datetime_numeric = strtotime($checkin_datetime_formated);
            $checkin_date_formated = date('Y-m-d', $checkin_datetime_numeric);
            $checkin_date_numeric = strtotime($checkin_date_formated);
            $checkout_date_numeric = strtotime($interval, $checkin_date_numeric);
            $checkout_date_formated = date('Y-m-d', $checkout_date_numeric);
            $checkout_datetime_formated  = $checkout_date_formated." ".$checkout_time_formtated;

            $events[] = ['start'=>$checkin_datetime_formated,
                        'end'=> $checkout_datetime_formated];
        }
        return $events;
    }
}
