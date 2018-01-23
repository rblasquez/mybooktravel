@extends('emails.layout')

@section('content')
@php
setLocale(LC_TIME, '');
$horas_checkin = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkin));
$horas_checkout = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkout));

$fecha_entrada = Carbon\Carbon::parse($reserva->fecha_entrada);
$fecha_salida = Carbon\Carbon::parse($reserva->fecha_salida);

$noches = $fecha_entrada->diffInDays($fecha_salida);
@endphp

@include('emails.partials.banner_random')

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
										<tr><td height="30">&nbsp;</td></tr>
										<tr><td align="center"><img src="{{ $message->embed('img/mail/logo_small.jpg') }}" width="58" alt="Image"></td></tr>
										<tr><td height="10" style="font-size:10px; mso-line-height-rule:exactly; line-height:10px;">&nbsp;</td></tr>
										<tr>
											<td class="font_fix" style="font-size:27px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Maven Pro', sans-serif;" align="center">
												¡Hola, {{ $reserva->propiedad->usuario->nombres }}!
											</td>
										</tr>
										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Queremos informarte que {{ $reserva->usuario->nombres }}, ha realizado el pago completo de la reserva de tu propiedad.
												<br><br>
												{{ $reserva->usuario->nombre }} llegara el dia <strong>{{ $fecha_entrada->formatLocalized('%A %d  de %B del %Y') }}</strong>, hasta el dia <strong>{{ $fecha_salida->formatLocalized('%A %d  de %B del %Y') }}</strong>, sera una estadia de <strong>{{ $reserva->dias_estadia }}</strong> noches.

												<br><br><br>

												Aca te dejamos la información detallada del pago:


											</td>
										</tr>
										<tr>
											<td height="20" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td>
										</tr>
										<tr>
											<td>
												@foreach ($reserva->detalles as $element)
												{{ $element->monto_anfitrion }}
												<br>
												@endforeach
											</td>
											<td>
												@foreach ($reserva->detalles as $element)
												{{ $element->fecha }}
												<br>
												@endforeach
											</td>
										</tr>
										
										<tr>
											<td align="center">
												<table cellspacing="0" cellpadding="0" border="0" align="center">
													<tbody>
														<tr>
															<td align="center" style="display:block; padding: 16px 0px;width: 200px; -webkit-text-size-adjust:none;">
															</td>
														</tr>
													</tbody>

												</table>
											</td>
										</tr>
										<tr><td height="90">&nbsp;</td></tr>
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