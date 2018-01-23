<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Propiedad;
use App\Reserva;
use App\ReservaDetalle;
use App\MetodoPago;
use App\ReservaPago;
use App\Banco;
use App\DPagoReservasWesternUnion;
use App\ServWebpayWebservice;

use Carbon\Carbon;

use Auth;
use PDF;
use DB;
use Alert;

use App\Mail\Reservas\Anfitrion\Realizada;
use App\Mail\Reservas\Huesped\RealizarPago;
use App\Mail\Reservas\Anfitrion\RealizarConfirmacion;
use App\Mail\Reservas\Huesped\EsperarConfirmacion;
use App\Mail\Reservas\Huesped\ReservaRechazada;
use App\Mail\Reservas\Huesped\ReservaAprobada;
use App\Mail\Notificaciones\Reservas\MailReserva;

class ReservaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $reservas = Reserva::byUsuario()->orderBy('created_at', 'DESC')->paginate(5);
        return view('reservas.index', ['reservas' => $reservas]);
    }

    public function show($id)
    {
        $reserva = Reserva::find($id);
        if (Auth::user()->id == $reserva->usuario->id) {
            $fecha_entrada = Carbon::parse($reserva->fecha_entrada)->format('Y-m-d');
            $fecha_salida = Carbon::parse($reserva->fecha_salida)->format('Y-m-d');
            $desgloce_precios = Propiedad::obtenerPrecios($reserva->propiedad->id, $fecha_entrada, $fecha_salida);

            $pago = HelperController::totalPagado($reserva);

            if ($reserva) {
                $metodos_pago = MetodoPago::where('estatus', true)->pluck('descripcion', 'id');
                return view('reservas.show', [
                'reserva' 			=> $reserva,
                'metodos_pago' 		=> $metodos_pago,
                'desgloce_precios' 	=> $desgloce_precios,
            ]);
            }
            return redirect()->intended('/');
        }
        return redirect()->intended('/');
    }

    public function reservaVisualizar(Request $request, $id)
    {
        #return $request->all();
        $propiedad = Propiedad::find($id);
        $disponible = new HelperController;
        $disponible = $disponible->calcularNoches($request, $propiedad);
        if ($disponible) {
            $metodos_pago = MetodoPago::where('estatus', true)->pluck('descripcion', 'id');
            return view('reservas.detalle', [
                'propiedad' 	=> $propiedad,
                'request' 		=> $request,
                'detalle' 		=> $disponible,
                'metodos_pago' 	=> $metodos_pago,
            ]);
        }
    }

    public function reservar(Request $request, $id)
    {
        $propiedad = Propiedad::find($id);
        $disponible = new HelperController;
        $disponible = $disponible->calcularNoches($request, $propiedad);


        if (!$disponible) {
            alert()->error('No puede generar una reserva para estas fechas, existe ocupación de la propiedad', '¡Lo sentimos!')->autoclose(3500);
            return back()->withInput();
        } else {
            $reserva = DB::transaction(function () use ($request, $propiedad, $disponible) {
                $estatus = false;
                $propiedad;
                $horas_checkin = Carbon::parse(Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon::parse($propiedad->detalles->checkin));
                $horas_checkout = Carbon::parse(Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon::parse($propiedad->detalles->checkout));
                $fecha_entrada = Carbon::parse($request->fecha_ini);
                $fecha_salida = Carbon::parse($request->fecha_fin);
                $noches_estadia = Carbon::parse($request->fecha_ini)->diffInDays(Carbon::parse($request->fecha_fin));
                try {
                    # $estatus_reserva = ($fecha_entrada->diffInHours() <= 24 && $propiedad->administracion->reserva_automatica == true) ? 2 : 1;
                    $estatus_reserva = ($propiedad->administracion->reserva_automatica == true) ? 2 : 1;

                    $reserva = new Reserva;
                    $reserva->fecha_entrada 		= $fecha_entrada;
                    $reserva->fecha_salida 			= $fecha_salida;
                    $reserva->total_adultos 		= $request->total_adultos;
                    $reserva->total_ninos 			= 0;
                    $reserva->dias_estadia 			= $noches_estadia;
                    $reserva->precio_noche 			= sanear_string($disponible['precio_promedio']);
                    $reserva->precio_base 			= sanear_string($disponible['precio_base']);
                    $reserva->gastos_limpieza 		= sanear_string($disponible['gastos_limpieza']);
                    $reserva->tarifa_servicio 		= sanear_string($disponible['tarifa_servicio']);
                    $reserva->total_pago 			= (session('moneda') == 'CLP') ? sanear_string($disponible['total']) : sanear_string($disponible['total_clp']);
                    $reserva->usuarios_id 			= Auth::user()->id;
                    $reserva->propiedad_id 			= $propiedad->id;
                    $reserva->estatus_reservas_id 	= $estatus_reserva;
                    $reserva->save();


                    foreach ($disponible['desgloce']->precios as $key => $datos) {
                        $monto_anfitrion = $datos->precio;
                        $monto_mbt = ($this->PorcentajeReserva * $monto_anfitrion) / 100;
                        $monto_huesped = $monto_anfitrion + $monto_mbt;

                        $detalle = new ReservaDetalle;
                        $detalle->monto_anfitrion = $monto_anfitrion;
                        $detalle->monto_mbt = $monto_mbt;
                        $detalle->monto_huesped = $monto_huesped;
                        $detalle->fecha = $datos->fecha;
                        $detalle->reservas_id = $reserva->id;
                        $detalle->save();
                    }
                    DB::commit();
                    return $reserva;
                } catch (\Exception $e) {
                    $error = [get_class($e),$e->getMessage()];
                    DB::rollBack();
                    return $error;
                }
            });

            if ($reserva) {
                $email_anfitrion = $reserva->propiedad->usuario->email;
                $email_huesped = $reserva->usuario->email;

                # si el alojamiento tiene reserva automatica se debe notificar
                # al anfitrion que le hicieron una reserva (Reservas\Anfitrion\Realizada)
                # al huesped que el anfitrion ha confirmado su reserva y debe pagar (Reservas\Huesped\RealizarPago)
                # si el alojamiento no tiene reserva automatica se debe notificar
                # al anfitrion que tiene una reserva pendiente por confirmar (Reservas\Anfitrion\RealizarConfirmacion)
                # al huesped que debe esperar a que el anfitrion confirme su reserva (Reservas\Huesped\EsperarConfirmacion)

                $reserva_automatica = $reserva->propiedad->reserva_automatica;
                if ($reserva_automatica) {
                    Mail::to($email_anfitrion)->send(new Realizada($reserva));
                    Mail::to($email_huesped)->send(new RealizarPago($reserva));
                    Mail::to('mybooktravell@gmail.com')
                    ->cc(['jrivero@mybooktravel.com', 'esanchez@mybooktravel.com', 'alejandrofernand@gmail.com', 'rblasquez@mybooktravel.com'])
                    ->send(new MailReservaAutomatica($reserva));
                } else {
                    Mail::to($email_anfitrion)->send(new RealizarConfirmacion($reserva));
                    Mail::to($email_huesped)->send(new EsperarConfirmacion($reserva));
                    Mail::to('mybooktravell@gmail.com')
                    ->cc(['jrivero@mybooktravel.com', 'esanchez@mybooktravel.com', 'alejandrofernand@gmail.com', 'rblasquez@mybooktravel.com'])
                    ->send(new MailReserva($reserva));
                }

                if ($reserva_automatica) {
                    alert()->success('Ya solo estas a un paso, realiza el pago de tu reserva', '¡Felicidades!')->persistent('Aceptar');
                    return redirect()->route('pagos.elegir', $reserva->id);
                } else {
                    alert()->info('Espera la confirmación de disponibilidad de esta propiedad', '¡Felicidades!')->persistent('Aceptar');
                    return redirect()->route('reserva.show', $reserva->id);
                }
            } else {
                alert()->error('Algo ha salido mal, por favor intente nuevamente', '¡Lo sentimos!')->autoclose(3500);
                return back();
            }
        }
    }

    public function listadoReservas($id)
    {
        $propiedad = Propiedad::find($id);
        $reservas = Reserva::byPropiedad($id)
                        ->join('estatus_reservas', 'estatus_reservas.id', '=', 'reservas.estatus_reservas_id')
                        ->orderBy('estatus_reservas.order')
                        ->orderBy('reservas.updated_at')
                        ->select('reservas.*')
                        ->get();

        if (Auth::user()->id == $propiedad->usuario->id) {
            return view('reservas.listadoPropiedad', [
                'propiedad' => $propiedad,
                'reservas' => $reservas
            ]);
        }
        return redirect()->intended('/');
    }

    public function aprobar($id)
    {
        $reserva = Reserva::find($id);
        $reserva->estatus_reservas_id = 2;
        $reserva->save();
        # TODO: Crear correo de alerta de pago.
        Mail::to($reserva->usuario->email)->send(new ReservaAprobada($reserva));
        return response()->json($reserva);
    }

    public function rechazar($id)
    {
        $reserva = Reserva::find($id);
        $reserva->estatus_reservas_id = 10;
        $reserva->save();
        Mail::to($reserva->usuario->email)->send(new ReservaRechazada($reserva));
        return response()->json($reserva);
    }
}
