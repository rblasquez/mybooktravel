@extends('layouts.app')

@section('content')
<section class="container" style="min-height: 350px">

	<div id="site_content">
		<h1>Comprobante de pago</h1>
		<div class="alert alert-info text-center">
			PAGO REALIZADO SATISFACTORIAMENTE
		</div>
		<p class="">Estimado (a),  {{ $pago->first_name }} {{ $pago->last_name }}, gracias por reservar con nosotros. Aca tienes los datos de tu pago</p>

		<div class="row mbt_mt-20">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Descripción de pagos</strong></h3>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-hover">
							<tbody>
								<tr>
									<th>Nº de Reserva</th>
									<th>Producto</th>
									<th class="text-right">Precio Total</th>
								</tr>
								<tr>
									<td>{{ str_pad($reserva->id, 9, 0, STR_PAD_LEFT) }}</td>
									<td>$ 0</td>
									<td class="text-right">$ {{ cambioMoneda($reserva->total_pago, $reserva->propiedad->administracion->moneda, session('valor')) }}</td>
								</tr>
							</tbody>
						</table>

						<table class="table table-condensed table-hover">
							<tbody>
								<tr>
									<th colspan="2" class="text-center">Detalles de la compra</th>
								</tr>
								<tr>
									<td>Numero de reserva:</td>
									<td class="text-right">{{ str_pad($reserva->id, 9, 0, STR_PAD_LEFT) }}</td>
								</tr>
								<tr>
									<td>Fecha del Pago: </td>
									<td class="text-right">{{ Carbon\Carbon::parse($pago->transactiondate)->format('d/m/Y') }}</td>
								</tr>
								{{--
								<tr>
									<td>URL página Web:</td>
									<td class="text-right"><a href="http://https://mybooktravel.com">https://mybooktravel.com</a></td>
								</tr>
								--}}
								<tr>
									<td>Código de Autorización:</td>
									<td class="text-right">{{ $pago->authorizationcode }}</td>
								</tr>
								<tr>
									<td>Tipo de Transacción:</td>
									<td class="text-right">Venta</td>
								</tr>
								<tr>
									<td>Número de Tarjeta:</td>
									<td class="text-right">XXXX-XXXX-XXXX-{{ $pago->cardnumber }}</td>
								</tr>
								{{--
								<tr>
									<td>Tipo de Pago:</td>
									<td class="text-right"></td>
								</tr>
								<tr>
									<td>Tipo de Cuotas:</td>
									<td class="text-right"></td>
								</tr>

								<tr>
									<td>Cantidad de Cuotas:</td>
									<td class="text-right"></td>
								</tr>
								--}}
								<tr>
									<td>Pago Total:</td>
									<td class="text-right">$ {{ number_format($pago->amount,0,',','.') }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<a class="btn btn-primary pull-right" href="{{ route('reserva.show', $reserva->id) }}">Ver tu reserva</a>
			</div>
		</div>
	</div>
</section>
@endsection

@push('css')
<style>
.alert-info {
	background-color: transparent;
	border-color: #0ec8db;
	color: #0ec8db;
	font-weight: 500;
	font-size: 17px;
	border-radius: 0px;
}

.panel-default {
	border: 1px dashed gray;
	border-radius: 0px;
}
</style>
@endpush
