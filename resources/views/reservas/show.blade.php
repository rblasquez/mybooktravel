@extends('layouts.app')

@section('content')
	@php
	setlocale(LC_TIME, '');
	$fecha_entrada = Carbon\Carbon::parse($reserva->fecha_entrada);
	$fecha_salida = Carbon\Carbon::parse($reserva->fecha_salida);
	$pago = App\Http\Controllers\HelperController::totalPagado($reserva);
@endphp

<section class="container">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="img_container" style="min-height: 240px">
					<picture>
						@if (count($reserva->propiedad->imagenes) > 0)
							<img class="img-responsive b-lazy"
							src=""
							data-src="{{ App\Http\Controllers\HelperController::getUrlImg($reserva->propiedad->usuario->id, $reserva->propiedad->imagenes->where('primaria', true)->first()['ruta'], 'lg') }}"
							alt="alt-text"
							/>
						@else
							<img class="img-responsive" style="margin-bottom: 10px;" src="{{ asset('img/mail/publicacion_banner.jpg') }}" alt="">
						@endif
						<h3 style="
						position: absolute;
						margin: 8px;
						color: #fff;
						text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.83);
						">Reserva #{{ str_pad($reserva->id, 9, 0, STR_PAD_LEFT) }}</h3>
					</picture>
				</div>
				<div class="invoice-title">
				</div>

				<hr>

				<div class="row">
					<div class="col-md-4">

						<h3 style="margin-bottom: 15px">{{ $reserva->dias_estadia }} noches en {{ $reserva->propiedad->ubicacion->localidad }}</h3>
						<p>{{ $reserva->propiedad->nombre }}</p>
						<p><strong>Llegada:</strong></p>
						<p>{{ $fecha_entrada->formatLocalized('%A %d  de %B del %Y') }}</p>
						<p><strong>Salida:</strong></p>
						<p>{{ $fecha_salida->formatLocalized('%A %d  de %B del %Y') }}</p>

						<hr>

						<h4>Recuerda las reglas de la casa</h4>
						<ul class="list-unstyled">
							@foreach ($reserva->propiedad->normas as $element)
								<li>{{ $element->norma->descripcion }} <i class="fa fa-close"></i></li>
							@endforeach
						</ul>
					</div>
					<div class="col-md-5">
						<h3 class="mbt_mb-15">
							Descripción del pago
						</h3>

						<div class="panel panel-default mbt_mb-10">
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-6">Valor por noche</div>
									<div class="col-xs-6 text-right">
										${{ cambioMoneda($reserva->precio_base, $reserva->propiedad->ubicacion->datosPais->moneda, session('valor')) }}
									</div>
								</div>
							</div>
							<ul class="list-group">
								@foreach ($desgloce_precios->precios as $element)
									@php
										$fecha = Carbon\Carbon::parse($element->fecha);
									@endphp
									<li class="list-group-item">
										<div class="row">
											<div class="col-xs-4">Noche {{ $loop->iteration }}</div>
											<div class="col-xs-4">{{ $fecha->format('d/m/Y') }}</div>
											<div class="col-xs-4 text-right">${{ cambioMoneda($element->precio, $reserva->propiedad->ubicacion->datosPais->moneda, session('valor')) }}</div>
										</div>
									</li>
								@endforeach
							</ul>
						</div>

						<div class="panel panel-default mbt_mb-10">
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-6">Gastos de limpieza</div>
									<div class="col-xs-6 text-right">
										${{ cambioMoneda($reserva->gastos_limpieza, $reserva->propiedad->ubicacion->datosPais->moneda, session('valor')) }}
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-default mbt_mb-10">
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-6">Tarifa de servicio</div>
									<div class="col-xs-6 text-right">
										${{ cambioMoneda($reserva->tarifa_servicio, $reserva->propiedad->ubicacion->datosPais->moneda, session('valor')) }}
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-default mbt_mb-10">
							<div class="panel-body" style="background-color: #58595B; color: #fff; border-radius: 4px">
								<div class="row">
									<div class="col-xs-6">Total ({{ session('moneda') }})</div>
									<div class="col-xs-6 text-right">
										<span class="precioBig" style="color: #fff">${{ cambioMoneda($reserva->total_pago, $reserva->propiedad->ubicacion->datosPais->moneda, session('valor')) }}</span>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="col-md-3">
						{{-- Evaluar si los pagos no sobrepasan el monto minimo requerido --}}
						@if ($pago['total_abonado'] < $pago['minimo_requerido'])
							{{-- Si la reserva fue rechazada mostrar el anfitrión --}}
							@if ($reserva->estatus_reservas_id == 10)
								<h3 class="text-right" style="margin-bottom: 15px">
									Disculpa
								</h3>
								<div class="alert alert-warning" role="alert">
									El anfitrión de esta propiedad ha rechazado tu reserva
								</div>
							@elseif ($reserva->estatus_reservas_id == 1)
								<h3 class="text-right" style="margin-bottom: 15px">
									Espera la aprobación de tu reserva
								</h3>
							@elseif($pago['existe_pago_no_aprobado']  && $reserva->estatus_reservas_id <> 1)
								<h3 class="text-right" style="margin-bottom: 15px">
									Paga tu reserva
								</h3>
								<div class="alert alert-warning mbt_mt-15" role="alert">
									Tu pago esta pendiente de validación
								</div>

							@else
								<h3 class="text-right" style="margin-bottom: 15px">
									Paga tu reserva
								</h3>
								<a href="{{ route('pagos.elegir', $reserva->id) }}" class="btn btn-primary btn-lg btn-block">Continuar</a>
							@endif
						@elseif($pago['existe_pago_no_aprobado'])
							<h3 class="text-right" style="margin-bottom: 15px">
								Validando pagos
							</h3>

							<div class="alert alert-info" role="alert">
								Tienes pagos pendientes de validación
							</div>
						@elseif($pago['total_abonado'] >= $pago['minimo_requerido'])
							<h3 class="text-right" style="margin-bottom: 15px">
								Reserva pagada
							</h3>

							<div class="alert alert-info" role="alert">
								Esta reserva ya fue pagada completamente
							</div>
						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('css')
	<style>
		.informacion p {
			margin-bottom: 1px;
			font-weight: 500;
		}

		.img-thumbnail {
			border-radius: 0px;
		}

		.panel{
			box-shadow: 0px 0px 5px #ddd;
		}
	</style>
@endpush


@push('js')
	<script type="text/javascript">
		var marcadores = [{
			name: '{{ $reserva->propiedad->nombre }}',
			location_latitude: {!! $reserva->propiedad->ubicacion->latitud !!},
			location_longitude: {!! $reserva->propiedad->ubicacion->longitud !!},
		}];

		var estatus_mapa = false
		$('.nav-tabs li:eq(1) a').on('shown.bs.tab', function (e) {
			if (estatus_mapa == false) {
				var ubicacion = { lat : {!! $reserva->propiedad->ubicacion->latitud !!}, lng : {!! $reserva->propiedad->ubicacion->longitud !!} };
				mapaUbicacionPropiedad(marcadores, ubicacion, 'ubicacionMapa')
				estatus_mapa = true
			}
		})

	</script>
@endpush
