@extends('emails.layout')

@section('content')
    @php
    setLocale(LC_TIME, '');
    $horas_checkin = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkin));
    $horas_checkout = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkout));

    $fecha_entrada = Carbon\Carbon::parse($reserva->fecha_entrada);
    $fecha_salida = Carbon\Carbon::parse($reserva->fecha_salida);

    $noches = $fecha_entrada->diffInDays($fecha_salida);

    $imagen = $reserva->propiedad->imagenes->where('primaria', true)->first()->ruta;
    $imagen = App\Http\Controllers\HelperController::getUrlImg($reserva->propiedad->usuario->id, $imagen, 'lg');

    $totalPagado = App\Http\Controllers\HelperController::totalPagado($reserva);
    $propiedad = $reserva->propiedad;
    $huesped = $reserva->usuario;
    $anfitrion = $reserva->propiedad->usuario;


@endphp

<table bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
    <tbody>
        <tr>
            <td valign="top" align="left">
                <img src="{{ $message->embed($imagen) }}" class="emailImage" width="600">
            </td>
        </tr>
    </tbody>
</table>


<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width">
    <tbody>
        <tr>
            <td align="center">
                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                    <tbody>
                        <tr>
                            <td align="center">
                                <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" class="full-width">
                                    <tbody>
                                        <tr>
                                            <td height="30">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="font_fix" style="font-size:16px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Montserrat', sans-serif;" align="center">
                                                <h4>
                                                    <span style="font-size:20px; text-transform:uppercase; color:#0EC5D8 !important;">¡Felicidades {{ $anfitrion->nombres }}!</span>
                                                    <small style="display:block; color: #555">¡Hemos registrado una reserva en tu propiedad!</small>
                                                </h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="30">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

{{-- ############ DETALLE DE LA RESERVA ############ --}}
<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width" bgcolor="#ffffff">
    <tbody>
        <tr>
            <td align="center" valign="top">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
                    <tbody>
                        <tr>
                            <td class="font_fix" align="center" bgcolor="#0EC5D8" style="color:#ffffff;font-weight:bold; font-family: 'Montserrat', sans-serif; font-size:18px; text-transform:uppercase; padding-top:10px; padding-bottom:10px">- Detalle de la reserva -</td>
                        </tr>
                    </tbody>
                </table>

            </td>
        </tr>

        <tr>
            <td height="15"></td>
        </tr>

        <tr>
            <td align="center" valign="top">
                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td valign="top">
                                <table align="center" cellpadding="0" cellspacing="0" border="0" class="table608" style="mso-table-lspace:0pt;mso-table-rspace:0pt;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width= align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" class="table608" style="mso-table-lspace:0pt;mso-table-rspace:0pt;">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table align="center" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;">
                                                                    <tbody>

                                                                        @foreach ($reserva->detalles as $key => $info)

                                                                            <tr style="{{ $loop->iteration%2 ? 'background-color:#f4f4f4;' : '' }}">
                                                                                <td width="275" valign="middle" height="25">Noche {{ $loop->iteration }}: {{ Carbon\Carbon::parse($info->fecha)->format('d/m/Y') }}</td>
                                                                                <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($info->monto_anfitrion, 'CLP', session('valor')) }} <strong>CLP</strong></td>
                                                                            </tr>
                                                                        @endforeach



                                                                        <tr>
                                                                            <td colspan="3" height="20" style="font-size:0;line-height:0;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table align="center" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt; background: #58595B; color: #fff">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width="275" valign="middle" height="25" align="right"><strong>Total</strong></td>
                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->detalles->sum('monto_anfitrion'), 'CLP', session('valor')) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="275" valign="middle" height="25" align="right">Hemos recibido el pago de</td>
                                                                            <td width="275" valign="middle" height="25" align="right">
                                                                                @if ((int)$totalPagado['total_abonado'] < (int)$reserva->total_pago)
                                                                                    <strong>${{ cambioMoneda($reserva->detalles->sum('monto_anfitrion') - $totalPagado['total_abonado'], 'CLP', session('valor')) }}</strong>
                                                                                @else
                                                                                    <strong>${{ cambioMoneda($reserva->detalles->sum('monto_anfitrion'), 'CLP', session('valor')) }}</strong>
                                                                                @endif
                                                                            </td>
                                                                        </tr>

                                                                        @if ((int)$totalPagado['total_abonado'] < (int)$reserva->total_pago)
                                                                            <tr>
                                                                                <td width="275" valign="middle" height="25" align="right">Vas a recibir del huesped en efectivo</td>
                                                                                <td width="275" valign="middle" height="25" align="right"> <strong>${{ cambioMoneda($reserva->total_pago - $totalPagado['total_abonado'], 'CLP', session('valor')) }}</strong> </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td height="15" style="font-size:0;line-height:0;">&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" align="center">
                                                                <small>
                                                                    <strong style="color: #02CE68">Recuerda</strong> que Mybooktravel transfiere el dinero de tu reserva 24 horas despues de la llegada del huesped a tu alojamiento.
                                                                </small>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <table class="discount" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">Check In</strong>: </td>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">Check Out</strong>: </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $fecha_entrada->addHours($horas_checkin)->format('d/m/Y -- h:i a') }}</td>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $fecha_salida->addHours($horas_checkout)->format('d/m/Y -- h:i a') }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="30">
                                                                <hr>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <table class="discount" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">Huespedes</strong>: </td>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">Pais</strong>: </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $reserva->total_adultos + $reserva->total_ninos }}</td>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $huesped->pais->nombre ?? '' }}</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">Reservado por</strong>: </td>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">e-mail</strong>: </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $huesped->nombres }}, {{ $huesped->apellidos }}</td>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $huesped->email }}</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">DNI / RUT</strong>: </td>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8;">Contacto</strong>: </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"></td>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $huesped->telefono }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td height="30">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection
