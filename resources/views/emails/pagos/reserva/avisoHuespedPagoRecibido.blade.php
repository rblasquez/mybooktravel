@extends('emails.layout')

@push('css')
<style>
.webPayInvoice tr td {
	border-bottom: 1px dashed #ddd;
}
</style>
@endpush

@section('content')
@php
setLocale(LC_TIME, '');
$horas_checkin = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkin));
$horas_checkout = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkout));

$fecha_entrada = Carbon\Carbon::parse($reserva->fecha_entrada);
$fecha_salida = Carbon\Carbon::parse($reserva->fecha_salida);

$noches = $fecha_entrada->diffInDays($fecha_salida);
@endphp

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
										<tr><td height="10" style="font-size:10px; mso-line-height-rule:exactly; line-height:10px;">&nbsp;</td></tr>
										<tr>
											<td class="font_fix" style="font-size:27px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Maven Pro', sans-serif;" align="center">
												¡Hola, {{ $reserva->usuario->nombres }}!
											</td>
										</tr>
										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Queremos informarte que hemos recibido los datos de tu pago, estamos confirmando que todo este correcto para poder liberar tu reserva.
											</td>
										</tr>
										<tr>
											<td height="20" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td>
										</tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Detalle del pago
											</td>
										</tr>
										<table class="webPayInvoice" width="100%" style="font-size:14px; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;">
										@if ($reserva->metodo_pago_id == 4)
										@foreach ($reserva->pagoWesternUnion as $pago)
											<tr>
												<td>MTCN</td>
												<td align="right">{{ $pago->mtcn }}</td>
											</tr>

											<tr>
												<td>Nombre del depositante</td>
												<td align="right">{{ $pago->remitente }}</td>
											</tr>

											<tr>
												<td>Monto</td>
												<td align="right">{{ $pago->monto }}</td>
											</tr>
											
											@if ($pago->comentario)
											<tr>
												<td>Comentario</td>
												<td align="right">{{ $pago->comentario }}</td>
											</tr>
											@endif
										@endforeach

										@elseif ($reserva->metodo_pago_id == 3)
										
										@foreach ($reserva->pagoDeposito as $pago)
											<tr>
												<td>Depositante</td>
												<td align="right">{{ $pago->nombre }}</td>
											</tr>
											<tr>
												<td>RUT</td>
												<td align="right">{{ $pago->rut }}</td>
											</tr>
											<tr>
												<td>Banco</td>
												<td align="right">{{ $pago->banco }}</td>
											</tr>
											<tr>
												<td>Nº de Transferencia</td>
												<td align="right">{{ $pago->numero_transferencia }}</td>
											</tr>
										@endforeach
										@endif
										</table>
										
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