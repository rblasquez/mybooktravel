@extends('layouts.app')

@section('content')
@php
setLocale(LC_TIME, 'es_CL.UTF-8');

$fecha = new App\Http\Controllers\FechasController;

$horas_checkin = $fecha->formatoHora($propiedad->detalles->checkin);
$horas_checkout = $fecha->formatoHora($propiedad->detalles->checkout);

$fecha_entrada = $fecha->formato($request->fecha_ini);
$fecha_salida = $fecha->formato($request->fecha_fin);

$noches = $fecha->diasDiferencia($request->fecha_ini, $request->fecha_fin);
@endphp


<section class="container">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="img_container" style="min-height: 240px">
					<picture>
						@if (count($propiedad->imagenes) > 0)
						<img class="img-responsive b-lazy"
						src=""
						data-src="{{ App\Http\Controllers\HelperController::getUrlImg($propiedad->usuario->id, $propiedad->imagenes->where('primaria', true)->first()['ruta'], 'lg') }}"
						alt="alt-text"
						/>
						@else
						<img class="img-responsive img-thumbnail" style="margin-bottom: 10px;" src="{{ asset('img/mail/publicacion_banner.jpg') }}" alt="">
						@endif
						<h3 class="text-center" style="
						color: #fff;
						text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.83);
						position: absolute;
						bottom: 0;
						background: #0000004d;
						padding: 19px;
						margin: 0;
						width: 100%;
						">Información detallada para esta reserva</h3>
					</picture>
				</div>
				<div class="invoice-title">
				</div>

				<hr>
				<div class="row">
					<div class="col-sm-6">

						<h3 style="margin-bottom: 15px">Disfruta de:</h3>
						<h4 style="margin-bottom: 15px">
							{{ $detalle['noches'] }} noches en {{ $propiedad->ubicacion->localidad }} para {{ $request->total_adultos }} Personas
						</h4>
						<p>{{ $propiedad->nombre }}</p>
						<p><strong>Llegada:</strong></p>
						<p>{{ $fecha_entrada->formatLocalized('%A %d  de %B del %Y') }}</p>
						<p>a las {{ $fecha->formatoHora($horas_checkin) }}</p>
						<p><strong>Salida:</strong></p>
						<p>{{ $fecha->formatoLetras($fecha_salida) }}</p>
						<p>a las {{ $fecha->formatoHora($horas_checkout) }}</p>

						<hr>

						@if(count($propiedad->normas) > 0)
						<h4>Recuerda las reglas de la casa</h4>
						<ul class="list-unstyled">
							@foreach ($propiedad->normas as $element)
							<li><i class="fa fa-close"></i> {{ $element->norma->descripcion }}</li>
							@endforeach
						</ul>
						@endif
					</div>

					<div class="col-md-6">
						<h3 style="margin-bottom: 15px">
							Descripción del pago
						</h3>

						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<div class="row">
										<div class="col-xs-8">${{ $detalle['precio_promedio'] }} X {{ $detalle['noches'] }} noches</div>
										<div class="col-xs-4 text-right">${{ $detalle['precio_base'] }}</div>
										<div class="col-xs-12 text-right">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												detalle <span class="caret"></span>
											</a>
										</div>
									</div>
								</div>
								<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										@foreach ($detalle['desgloce']->precios as $element)
										@php
										$fecha = Carbon\Carbon::parse($element->fecha);
										$valor = $element->precio * (($PorcentajePublicacion/100) + 1);
										@endphp
										<div class="col-xs-4">Noche {{ $loop->iteration }}</div>
										<div class="col-xs-4">{{ $fecha->format('d/m/Y') }}</div>
										<div class="col-xs-4 text-right">${{ cambioMoneda($valor, $propiedad->administracion->moneda, session('valor')) }}</div>
										@endforeach
									</div>
								</div>
							</div>
							@if ($detalle['gastos_limpieza'] > 0)
							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-6">Gastos de limpieza</div>
										<div class="col-xs-6 text-right">
											${{ $detalle['gastos_limpieza'] }}
										</div>
									</div>
								</div>
							</div>
							@endif

							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-6">Tarifa de servicio</div>
										<div class="col-xs-6 text-right">
											${{ $detalle['tarifa_servicio'] }}
										</div>
									</div>
								</div>
							</div>

							@isset($detalle['total_descuento_cupon'])
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-6">Valor de la reserva</div>
											<div class="col-xs-6 text-right">
												<strong>${{ $detalle['total_no_descuento_cupon'] }}</strong>
											</div>
										</div>
									</div>
								</div>

								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-6">Descuento por cupon</div>
											<div class="col-xs-6 text-right">
												${{ $detalle['total_descuento_cupon'] }}
											</div>
										</div>
									</div>
								</div>
							@endisset

							<div class="panel panel-info" style="border:none;">
								<div class="panel-footer" style="background-color: #58595B; color: #fff">
									<div class="row">
										<div class="col-xs-2">Total ({{ session('moneda') }})</div>
										<div class="col-xs-10 text-right">
											<span class="precioBig" style="color: #fff">${{ $detalle['total'] }}</span>
											@if (isset($detalle['total_clp']))
											<h5>equivalente a ${{ $detalle['total_clp'] }} CLP</h>
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-12 text-right">
								@if ($propiedad->administracion->reserva_automatica == true)
								Si esta de acuerdo con la información específicada puede continuar y realizar el pago de esta propiedad
								@else
								Si esta de acuerdo con la información específicada puede solicitar esta reserva al anfitrión de esta propiedad
								@endif
							</div>
							<div class="col-md-6 col-md-offset-6 mbt_mt-20">
								{!! Form::open(['route' => ['reserva.propiedad', $propiedad->id], 'method' => 'GET']) !!}
								{!! Form::hidden('fecha_ini', null) !!}
								{!! Form::hidden('fecha_fin', null) !!}
								{!! Form::hidden('total_adultos', null) !!}
								{!! Form::hidden('codigo_promocional', null) !!}

								@if ($propiedad->administracion->reserva_automatica == true)
								{!! Form::submit('Confirmar y continuar', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
								@else
									{!! Form::submit($propiedad->administracion->reserva_automatica ? 'Reserva' : 'Solicita reserva', [
										'class' => 'btn btn-lg btn-primary btn-block mbt_mt-20',
										'style' => 'padding: 0px;'
										]) !!}
								@endif
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
