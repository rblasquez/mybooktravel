@extends('emails.layout')

@inject('helper', 'App\Http\Controllers\HelperController')
@inject('fechas', 'App\Http\Controllers\FechasController')

@section('content')
    @php
    $fecha_entrada = $fechas->formato($reserva->fecha_entrada);
    $fecha_salida = $fechas->formato($reserva->fecha_salida);

    $noches = $fechas->diasDiferencia($reserva->fecha_entrada, $reserva->fecha_salida);

    $totalPagado = $helper->totalPagado($reserva);

    $propiedad = $reserva->propiedad;
    $imagen = $propiedad->imagenes->where('primaria', true)->first()->ruta;
    $imagen = $helper->getUrlImg($propiedad->usuario->id, $imagen, 'lg');
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
                                                    <span style="font-size:20px; text-transform:uppercase; color:#0EC5D8 !important;">¡Felicidades {{ $reserva->usuario->nombres }}!</span>
                                                    <small style="display:block; color: #555">¡Has realizado una reserva a travez de Mybooktravel!</small>
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
                                                                        <tr>
                                                                            <td width="275" valign="middle" height="25">Precio neto por noche</td>
                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->precio_noche, 'CLP', session('valor')) }}</td>
                                                                        </tr>

                                                                        <tr style="background-color:#f4f4f4;">
                                                                            <td width="275" valign="middle" height="25">X {{ $reserva->dias_estadia }} noches</td>
                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->precio_base, 'CLP', session('valor')) }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td width="275" valign="middle" height="25">Tarifa de servicio de Mybooktravel</td>
                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->tarifa_servicio, 'CLP', session('valor')) }}</td>
                                                                        </tr>

                                                                        <tr style="background-color:#f4f4f4;">
                                                                            <td width="275" valign="middle" height="25">Tarifa de limpieza unica</td>
                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->gastos_limpieza, 'CLP', session('valor')) }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="3" height="20" style="font-size:0;line-height:0;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table align="center" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt; background: #58595B; color: #fff">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width="275" valign="middle" height="25" align="right"><strong>Total</strong></td>
                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->total_pago, 'CLP', session('valor')) }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td width="275" valign="middle" height="25" align="right">Has pagado</td>
                                                                            <td width="275" valign="middle" height="25" align="right"> ${{ cambioMoneda($totalPagado['total_abonado'], 'CLP', session('valor')) }} </td>
                                                                        </tr>
                                                                        @if ($totalPagado['total_abonado'] < $reserva->total_pago)
                                                                            <tr>
                                                                                <td width="275" valign="middle" height="25" align="right">Debes cancelar al anfitrion</td>
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
                                                            <td>
                                                                <table class="discount" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8">Check In</strong>: </td>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8">Check Out</strong>: </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $fechas->formatoFechaHora($reserva->fecha_entrada, $propiedad->detalles->checkin)->format('d/m/Y h:i a') }}</td>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $fechas->formatoFechaHora($reserva->fecha_salida, $propiedad->detalles->checkout)->format('d/m/Y h:i a') }}</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td height="25" colspan="2"><hr style=" border-top: 2px dashed #9BA2AB;"></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8">Anfitrión</strong>: </td>
                                                                                            <td height="25" width="275" style="padding:5px;"><strong style="color: #0EC5D8">Contacto</strong>:</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $reserva->propiedad->usuario->nombres }} {{ $reserva->propiedad->usuario->apellidos }}</td>
                                                                                            <td height="25" width="275" style="padding:5px;">{{ $reserva->propiedad->usuario->telefono ?? $reserva->propiedad->usuario->email }}</td>
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

{{-- ############ NORMAS DE LA CASA ############ --}}
@if (count($reserva->propiedad->normas) > 0 || isset($reserva->propiedad->normasAdicionales))
    <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width" bgcolor="#ffffff">
        <tbody>
            <tr>
                <td align="center" valign="top">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
                        <tbody>
                            <tr>
                                <td class="font_fix" align="center" bgcolor="#0EC5D8" style="color:#ffffff;font-weight:bold; font-family: 'Montserrat', sans-serif; font-size:18px; text-transform:uppercase; padding-top:10px; padding-bottom:10px">- Normas de la casa -</td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>

            <tr>
                <td align="center">
                    <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" class="full-width">
                                        <tbody>
                                            @if (count($reserva->propiedad->normas) > 0)
                                                <tr>
                                                    <td height="30">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_fix" style="font-size:16px; mso-line-height-rule:exactly; color:#555555; font-family: 'Montserrat', sans-serif;" align="center">
                                                        @foreach ($reserva->propiedad->normas as $key => $norma)
                                                            {{ $norma->norma->descripcion }} {!! ($loop->last) ? '' : '<strong>/</strong> ' !!}
                                                        @endforeach
                                                    </td>
                                                </tr>

                                            @endif

                                            @if (count($reserva->propiedad->normas) > 0 || isset($reserva->propiedad->normasAdicionales))

                                                <tr>
                                                    <td> <hr> </td>
                                                </tr>
                                            @endif

                                            @if (isset($reserva->propiedad->normasAdicionales))
                                                <tr>
                                                    <td class="font_fix" style="font-size:16px; mso-line-height-rule:exactly; color:#555555; font-family: 'Montserrat', sans-serif;" align="center">
                                                        <strong>Nota del propietario:</strong> {{ $reserva->propiedad->normasAdicionales->normas }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30">&nbsp;</td>
                                                </tr>
                                            @endif
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
@endif

{{-- ############ DETALLE DE UBICACIÓN DE LA PROPIEDAD ############ --}}
<table width="600" bgcolor="#f9f9f9" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width">
    <tbody>
        <tr>
            <td align="center">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
                    <tbody>
                        <tr>
                            <td align="center" class="font_fix" bgcolor="#0EC5D8" style="color:#ffffff;font-weight:bold; font-family:'Montserrat', sans-serif; font-size:18px; text-transform:uppercase; padding-top:10px; padding-bottom:10px">- Ubicación -</td>
                        </tr>
                    </tbody>
                </table>

                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                    <tbody>
                        <tr>
                            <td valign="top" align="center">
                                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width" style="border-bottom:1px solid #ddd;">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
                                                    <tbody>
                                                        <tr>
                                                            <td height="25"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @php
                                                                    $latitud = $reserva->propiedad->ubicacion->latitud;
                                                                    $longitud = $reserva->propiedad->ubicacion->longitud;
                                                                    $url  = 'https://maps.googleapis.com/maps/api/staticmap?center='.$latitud.','.$longitud.'&zoom=15&size=600x200&maptype=roadmap';
                                                                    $url .= '&markers=color:red%7Clabel:M%'.$latitud.','.$longitud;
                                                                    $url .= '&key=AIzaSyApHKA1lOLj17lDcBMEjOfr20hENk8vRZU';

                                                                    $url  = 'https://maps.googleapis.com/maps/api/staticmap?center='.$latitud.','.$longitud.'&zoom=15&size=600x300&maptype=roadmap';
                                                                    $url .= '&markers=color:red%7C'.$latitud.','.$longitud;
                                                                    $url .= '&key=AIzaSyApHKA1lOLj17lDcBMEjOfr20hENk8vRZU';
                                                                @endphp
                                                                <img src="{{ $message->embed($url) }}" width="550" class="emailImage" border="0" style="border-radius: 10px;border: 1px solid #ddd;box-shadow: 0px 0px 6px 0px #ddd;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table width="100%" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width">
                                                    <tbody>
                                                        <tr>
                                                            <td class="font_fix" style="font-size:15px; color:#555; font-weight:bold; font-family: 'Montserrat', sans-serif;" align="left">
                                                                <span style="color:#2c3e50; text-decoration:none !important">
                                                                    Ubicación:
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td height="26" align="left"><img src="{{ $message->embed('http://www.sonicdesign.it/varie/idro_mail/img/green_line.jpg') }}" width="30" height="2" alt="Image"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size:13px; mso-line-height-rule:exactly; line-height:16px; color:#333; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" align="left">
                                                                {{ $reserva->propiedad->ubicacion->direccion }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="25" style="font-size:30px; line-height:25px;">&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="font_fix" style="font-size:15px; color:#555; font-weight:bold; font-family: 'Montserrat', sans-serif;" align="left">
                                                                <span style="color:#2c3e50; text-decoration:none !important">
                                                                    Como llegar:
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td height="26" align="left"><img src="{{ $message->embed('http://www.sonicdesign.it/varie/idro_mail/img/green_line.jpg') }}" width="30" height="2" alt="Image"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size:13px; mso-line-height-rule:exactly; line-height:16px; color:#333; font-weight:normal; font-family: Arial, Helvetica, sans-serif;" align="left">
                                                                {{ $reserva->propiedad->ubicacion->como_llegar }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="25" style="font-size:30px; line-height:25px;">&nbsp;</td>
                                                        </tr>

                                                        <tr>
                                                            <td height="25" style="font-size:30px; line-height:25px;">&nbsp;</td>
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
