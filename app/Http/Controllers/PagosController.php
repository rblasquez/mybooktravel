<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservaPagoTrasnferenciaRequest;
use App\Http\Requests\ReservaPagoWesternRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

# MAILS ============================================
use App\Mail\Pagos\PagoReservaAnfitrion;
use App\Mail\Pagos\AvisoPagoRecibidoHuesped;
use App\Mail\Notificaciones\Pagos\Recepcion;

use App\Mail\Pagos\PagoCompletoHuesped;
use App\Mail\Pagos\PagoCompletoAnfitrion;
use App\Mail\Pagos\PagoRechazado;
use App\Mail\Pagos\PagoAprobado; # Este correo se envia una vez que se comprobo que el pago fue realizado correctamente y fue aprobado por Mybooktravel
# /MAILS ===========================================

use App\Reserva;
use App\MetodoPago;
use App\DPagoReservasDeposito;
use App\DPagoReservasWesternUnion;
use App\ServWebpayWebservice;

use Carbon\Carbon;
use Auth;
use DB;

class PagosController extends Controller
{
    const DISK = 'minio';

    public function __construct()
    {
        parent::__construct();
    }

    public function elegirMetodo($id)
    {
        $reserva = Reserva::find($id);
        if (Auth::user()->id == $reserva->usuario->id) {
            if ($this->continuarPago($reserva)) {
                return view('pagos.elegir', [
                    'reserva' => $reserva,
                    'metodos_pago' => MetodoPago::where('estatus', true)->pluck('descripcion', 'id'),
                ]);
            }
        }
        return redirect()->intended('/');
    }

    public function pagoReserva($reserva, $metodo)
    {
        $reserva = Reserva::find($reserva);

        if ($reserva->usuarios_id == Auth::user()->id) {
            if ($reserva->estatus_reservas_id == 1) {
                alert()->info('Debes esperar la confirmación de disponibilidad del anfitrión de esta propiedad para poder realizar el pago', 'Disculpa')->persistent('Aceptar');
                return back();
            } elseif ($this->continuarPago($reserva)) {
                $reserva->metodo_pago_id = $metodo;
                $reserva->save();

                $metodoPago = MetodoPago::find($metodo);

                if ($metodoPago->id == 1) {
                    return redirect('webpay/tbk-normal-inicio.php?id=' . $reserva->id);
                } elseif ($metodoPago->id == 3 || $metodoPago->id == 4) {
                    return redirect()->action('PagosController@pagoVista', ['reserva_id' => $reserva->id]);
                }
            } else {
                alert()->info('Ya se ha registrado un pago para esta reserva', 'Disculpa')->persistent('Aceptar');
                return back();
            }
        }
        return back();
    }

    public function pagoWebPayRedireccion(Request $request)
    {
        $pago = ServWebpayWebservice::where('token', $request->token_ws)->first();
        $reserva = Reserva::find($pago->buyorder);
        $totalPagado = HelperController::totalPagado($reserva);

        Mail::to($reserva->usuario->email)->send(new PagoCompletoHuesped($reserva));
        Mail::to($reserva->usuario->email)->send(new PagoCompletoAnfitrion($reserva));

        Mail::to('aandrade@mybooktravel.com')
        ->cc(['jrivero@mybooktravel.com', 'esanchez@mybooktravel.com', 'rblasquez@mybooktravel.com'])
        ->send(new Recepcion($reserva));

        if ($pago) {
            return redirect()->action('PagosController@pagoWebPayVista', [
                'token_pago' => $pago->token
            ]);
        }
    }

    public function pagoWebPayVista($token_pago)
    {
        $pago = ServWebpayWebservice::where('token', $token_pago)->first();

        if ($pago) {
            $reserva = Reserva::find($pago->buyorder);
            # $reserva = Reserva::find(6);
            if ($reserva) {
                return view('pagos.webpay', ['pago' => $pago, 'reserva' => $reserva]);
            }
        }
    }

    public function pagoWebPayRechazo($id)
    {
        return view('pagos.webpayRechazo');
    }

    public function pagoReservaTransferencia(ReservaPagoTrasnferenciaRequest $request, $reserva_id)
    {
        $reserva = Reserva::find($reserva_id);

        if ($reserva) {
            if ($reserva->usuarios_id == Auth::user()->id) {
                if ($this->continuarPago($reserva)) {
                    $success = true;

                    DB::beginTransaction();
                    try {
                        $bauche_img = $request->file('bauche_img');
                        $fileName 	= $bauche_img->getClientOriginalName();
                        $extension 	= strtolower(collect(explode(".", $fileName))->last());

                        $rutaArchivo = 'documento_pago/transferencia';
                        $archivo = Storage::disk(self::DISK)->putFileAs($rutaArchivo, $bauche_img, 'reserva_'.$reserva->id.'_recibo_'.md5(date('YmdHis')).'.'.$extension, 'public');
                        if ($archivo) {
                            $pago = new DPagoReservasDeposito;
                            $pago->nombre = $request->nombre;
                            $pago->rut = $request->rut;
                            $pago->banco = $request->banco;
                            $pago->numero_transferencia = $request->numero_transferencia;
                            $pago->comentario = $request->comentario;
                            $pago->bauche_img = $archivo;
                            $pago->monto = 0;
                            $pago->usuarios_id = Auth::user()->id;
                            $pago->reserva_id = $reserva->id;

                            $pago->save();

                            $reserva->estatus_reservas_id = 3;
                            $reserva->save();

                            DB::commit();
                        }
                    } catch (\Exception $e) {
                        $success = false;
                        $error = [get_class($e),$e->getMessage()];
                        DB::rollBack();
                    }

                    if ($success == true) {
                        return PagosController::respuestaPago($reserva->id, 3);
                    } else {
                        alert()->warning('No se pudo completar la operación, por favor intente nuevamente', 'Disculpe')->persistent('Aceptar');
                        return redirect()->route('reserva.show', $reserva->id);
                    }
                } elseif ($reserva->estatus_id == 1) {
                    alert()->info('Aun no se ha confirmado la disponibilidad de su reserva')->persistent('Aceptar');
                    return back();
                }
                alert()->info('Esta reserva ya fue pagada previamente.')->persistent('Aceptar');
                return back();
            }
        }
        return back();
    }

    public function pagoReservaWestern(ReservaPagoWesternRequest $request, $reserva_id)
    {
        $reserva = Reserva::find($reserva_id);
        if ($reserva && $reserva->usuarios_id == Auth::user()->id) {
            if ($this->continuarPago($reserva)) {
                $success = true;
                DB::beginTransaction();
                try {
                    $bauche_img = $request->file('bauche_img');
                    $fileName 	= $bauche_img->getClientOriginalName();
                    $extension 	= strtolower(collect(explode(".", $fileName))->last());

                    $rutaArchivo = 'documento_pago/westenUnion';
                    $archivo = Storage::disk(self::DISK)->putFileAs($rutaArchivo, $bauche_img, 'reserva_'.$reserva->id.'_recibo_'.md5(date('YmdHis')).'.'.$extension, 'public');
                    if ($archivo) {
                        $pago               = new DPagoReservasWesternUnion;
                        $pago->mtcn         = $request->mtcn;
                        $pago->remitente    = $request->remitente;
                        $pago->monto        = 0;
                        $pago->comentario   = $request->comentario;
                        $pago->bauche       = $archivo;
                        $pago->usuarios_id  = Auth::user()->id;
                        $pago->reserva_id   = $reserva->id;
                        $pago->save();

                        $reserva->estatus_reservas_id = 3;
                        $reserva->save();

                        DB::commit();
                    }
                } catch (\Exception $e) {
                    $success = false;
                    $error = [get_class($e),$e->getMessage()];
                    DB::rollBack();
                }

                if ($success == true) {
                    return PagosController::respuestaPago($reserva->id, 4);
                } else {
                    alert()->warning('No se pudo completar la operación, por favor intente nuevamente', 'Disculpe')->persistent('Aceptar');
                    return redirect()->route('reserva.show', $reserva->id);
                }
                return redirect()->route('reserva.show', $reserva->id);
            } elseif ($reserva->estatus_id == 1) {
                alert()->info('Aun no se ha confirmado la disponibilidad de su reserva')->persistent('Aceptar');
                return back();
            }

            alert()->info('Esta reserva ya fue pagada previamente.')->persistent('Aceptar');
            return back();
        }
        return back();
    }

    public function respuestaPago($id, $metodo)
    {
        $reserva = Reserva::find($id);
        $deuda = HelperController::totalPagado($reserva);

        if ($deuda['total_abonado'] >= $deuda['minimo_requerido']) {
            # Abono 100% o mas
            # Pasa a evaluación y la reserva procede
            $mensaje = 'Tu pago ha sido recibido, ha entrado en proceso de evaluación, te confirmaremos en un lapso estimado de 12 horas.';
        } else {
            # Abono menos del monto requerido
            # Pasa a evaluación y debe abonar el resto
            $mensaje = 'Recibimos tu pago, y lo evaluaremos, sin embargo has registrado una cantidad menor a la requerida, por lo que tendrias que cancelar un monto adicional';
        }

        Mail::to('aandrade@mybooktravel.com')
        ->cc(['jrivero@mybooktravel.com', 'esanchez@mybooktravel.com', 'rblasquez@mybooktravel.com'])
        ->send(new Recepcion($reserva));
        Mail::to($reserva->usuario->email)->send(new AvisoPagoRecibidoHuesped($reserva));
        # Mail::to($reserva->propiedad->usuario->email)->send(new PagoReservaAnfitrion($reserva));

        alert()->success($mensaje, 'Completado')->persistent('Aceptar');
        return redirect()->route('reserva.show', $reserva->id);
    }

    public function pagoVista($reserva_id)
    {
        $reserva = Reserva::find($reserva_id);
        if (Auth::user()->id == $reserva->usuario->id) {
            $deuda = HelperController::totalPagado($reserva);
            if ($deuda['total_abonado'] < $deuda['minimo_requerido']) {
                $metodoPago = MetodoPago::find($reserva->metodo_pago_id);
                return view('pagos.' . $metodoPago->view, ['reserva' => $reserva]);
            }

            return redirect()->intended('/reserva/'.$reserva->id);
        }
    }

    public function pagosListado()
    {
        # $reservas = Reserva::where('estatus_reservas_id', 3)->get();
        $reservas = Reserva::all();
        return view('administracion.reservas.aprobar', ['reservas' => $reservas]);
    }

    public function listaPagosPartial()
    {
        $reservas = Reserva::all();
        return view('administracion.reservas.partials.listado', ['reservas' => $reservas]);
    }

    public function pagosAutorizar(Request $request, $reserva_id, $estatus)
    {
        $reserva = Reserva::find($reserva_id);


        $proceso = DB::transaction(function () use ($request, $reserva, $estatus) {
            $monto = ($estatus == 'parcial') ? $request->monto_parcial : 0;
            $estatus_pago = ($estatus == 'rechazar') ? false : true;
            $deuda = HelperController::totalPagado($reserva);
            $success = true;
            switch ($estatus) {
                case 'aprobar':
                $monto = $deuda['monto_restante'];
                break;
                case 'parcial':
                $monto = $request->monto_parcial;
                break;
                case 'rechazar':
                $monto = 0;
                break;
            }

            $pagosRechazados = collect();
            DB::beginTransaction();
            try {
                if ($request->deposito) {
                    foreach ($request->deposito as $key => $deposito) {
                        $pago = DPagoReservasDeposito::find($deposito);
                        if (gettype($pago->estatus) == 'NULL') {
                            $pago->comentario_mbt   = $request->motivo_rechazo ?? null;
                            $pago->estatus          = $estatus_pago;
                            $pago->monto            = $monto;
                            $pago->monto_aprobado   = $monto;
                            $pago->save();

                            if ($estatus_pago == false) {
                                $pagosRechazados->push(['tipo' => 'deposito', 'id' => $pago->id]);
                            }
                        }
                    }
                }

                if ($request->western) {
                    foreach ($request->western as $key => $deposito) {
                        $pago = DPagoReservasWesternUnion::find($deposito);
                        if (gettype($pago->estatus) == 'NULL') {
                            $pago->comentario_mbt = $request->motivo_rechazo ?? null;
                            $pago->estatus = $estatus_pago;
                            $pago->save();
                            if ($estatus_pago == false) {
                                $pagosRechazados->push(['tipo' => 'western', 'id' => $pago->id]);
                            }
                        }
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                $success = false;
                $error = [get_class($e),$e->getMessage()];
                DB::rollBack();
            }

            if ($success) {
                return $reserva;
            }
        }, 5);

        if ($proceso) {
            $reserva = Reserva::find($reserva_id);
            $deuda = HelperController::totalPagado($reserva);

            if ((round($deuda['total_abonado']) >= round($deuda['minimo_requerido'])) && ($estatus == 'aprobar' || $estatus == 'parcial')) {
                $reserva->estatus_reservas_id = 5;
            } elseif (round($deuda['total_abonado']) < round($deuda['minimo_requerido']) && $deuda['total_abonado'] > 0) {
                $reserva->estatus_reservas_id = 9;
            } elseif ($deuda['total_abonado'] == 0) {
                $reserva->estatus_reservas_id = 2;
            }
            $reserva->save();

            if (!$estatus) {
                Mail::to($reserva->usuario->email)->send(new PagoRechazado($reserva, $pagosRechazados));
            }

            switch ($reserva->estatus_reservas_id) {
                case 5:
                    Mail::to($reserva->usuario->email)->send(new PagoCompletoHuesped($reserva));
                    Mail::to($reserva->usuario->email)->send(new PagoCompletoAnfitrion($reserva));
                    break;
                case 9:
                    # TODO: CORREO PAGO APROBADO CON DEUDA PENDIENTE
                    # TODO: Mail Pagos\PagoAprobado
                    # TODO: MailView emails.pagos.reserva.pagoAprobado
                    # TODO: php artisan make:mail Pagos/PagoAprobado --markdown=emails.pagos.reserva.pagoAprobado
                    # Mail::to($reserva->usuario->email)->send(new PagoCompletoAnfitrion($reserva));
                break;
            }

            return response()->json('success');
        }
    }

    public function consultarPago($metodo, $id)
    {
        if ($metodo == 'western') {
            $pago = DPagoReservasWesternUnion::find($id);
        } elseif ($metodo == 'deposito') {
            $pago = DPagoReservasDeposito::find($id);
        }

        return view('administracion.reservas.partials.modal-'.$metodo, [
            'pago' => $pago,
        ]);
    }

    public function continuarPago($reserva)
    {
        $deuda = HelperController::totalPagado($reserva);

        if (!$deuda['existe_pago_no_aprobado']) {
            return true;
        }
        return false;
    }
}
