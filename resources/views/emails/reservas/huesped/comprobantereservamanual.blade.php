@extends('emails.layout')

@inject('helper', 'App\Http\Controllers\HelperController')
@inject('fechas', 'App\Http\Controllers\FechasController')

@php
	$huesped 	= $reserva->usuario;
	$propiedad 	= $reserva->propiedad;
	$imagen 	= $propiedad->imagenes->where('primaria', true)->first()->ruta;
    $imagen 	= $helper->getUrlImg($propiedad->usuario->id, $imagen, 'lg');
@endphp

@section('content')


	<table bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
	    <tbody>
	        <tr>
	            <td valign="top" align="left">
	                <img src="{{ $message->embed($imagen) }}" class="emailImage" width="600">
	            </td>
	        </tr>
	    </tbody>
	</table>


	{{-- ############ MENSAJE AL HUESPED ############ --}}
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
	                                                    <span style="font-size:20px; text-transform:uppercase; color:#0EC5D8 !important;">Estimado (a) {{ $reserva->nombres }} {{ $reserva->apellidos }}</span>
	                                                    <small style="display:block; color: #555">
															Se ha registrado una reserva a su nombre.
															Esta reserva fué generada por el anfitrión de la alojamiento en base a una solicitud externa.
														</small>
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
	                                                                            <td width="275" valign="middle" height="25" align="right">${{ cambioMoneda($reserva->precio, 'CLP', session('valor')) }}</td>
	                                                                        </tr>


	                                                                        <tr style="background-color:#f4f4f4;">
	                                                                            <td width="275" valign="middle" height="25">X {{ $reserva->noches }} noches</td>
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
	                                                                                            <td height="25" width="275" style="padding:5px;">{{ $fechas->formatoFechaHora($reserva->fecha_inicio, $propiedad->detalles->checkin)->format('d/m/Y h:i a') }}</td>
	                                                                                            <td height="25" width="275" style="padding:5px;">{{ $fechas->formatoFechaHora($reserva->fecha_fin, $propiedad->detalles->checkout)->format('d/m/Y h:i a') }}</td>
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


	Estimado huesped:
	<br>
	<br>
	Se ha registrado una reserva a su nombre.<br>
	<br>
	Esta reserva fué generada por el anfitrión de la alojamiento en base a una solicitud externa.<br>
	<br>
	Los detalles de la reserva son los siguientes:<br>
	<br>
	Descripcion del alojamiento: {{ $reserva->propiedad->nombre }}<br>
	<br>

	Precio por Noche {{  }}<br>
	Duracion de la Estadía: {{  }} Noches<br>
	Costos Adicionales {{ $reserva->costos_adicionales }} días<br>
	Total a Pagar:{{ $reserva->monto_total }}<br>
	Monto Anticipado:{{ $reserva->monto_anticipo }}<br>
	Deuda Actual:{{ $reserva->monto_deuda_actual }}<br>
	<br>
	<br>
	Gracias<br>

@endsection
