@inject('helper', 'App\Http\Controllers\HelperController')

<div class="col-md-3">
	{!! Form::open(['route' => ['reserva.visualizar', $propiedad->id], 'method' => 'GET', 'autocomplete' => 'off']) !!}
	<div class="valorXnoche">
		<div class="valorXnoche_1">
			@if ($propiedad->administracion->reserva_automatica)
				<i class="fa fa-bolt masterTooltip" title="Reserva Inmediata" aria-hidden="true"></i>
			@endif

			@php
				$precio = 0;
				if ($valores['precio_promedio']) {
					$precio = $valores['precio_promedio'];
				} else {
					$precio = $helper->costoPropiedad($propiedad);
				}
			@endphp
			<span class="pbase">${{ $precio }} <small>{{ session('moneda') }}</small></span>
		</div>
		<div class="valorXnoche_2">por noche</div>
	</div>

	<div class="priceBox col-xs-12">
		<b>Fechas</b>
		<hr class="mbt_mt-5 mbt_mb-10">
		<div class="clearfix"></div>
		<div class="form-group">
			<div class="input-daterange formingUpDate" id="fechas_reservas">
				<div>
					{!! Form::label('fecha_ini', 'Llegada', ['class' => 'mbt_mt-0']) !!}
					<button type="button" class="btn btn-default mbt_border-default-1 mbt_p-10 mbt_mt-0 btn-checkin">
						{{ $request->fecha_ini ?? '&nbsp;' }}
					</button>
					{!! Form::text('fecha_ini', $request->fecha_ini ?? null, ['class' => 'hide', 'placeholder' => 'Llegada', 'style' => 'margin-bottom: 0px']) !!}
				</div><div>
					{!! Form::label('fecha_fin', 'Salida', ['class' => 'mbt_mt-0']) !!}
					<button type="button" class="btn btn-default mbt_border-default-1 mbt_p-10 mbt_mt-0 btn-checkout">
						{{ $request->fecha_fin ?? '&nbsp;' }}
					</button>
					{!! Form::text('fecha_fin', $request->fecha_fin ?? null, ['class' => 'hide', 'placeholder' => 'Salida', 'style' => 'margin-bottom: 0px']) !!}
				</div>
			</div>
		</div>
		<div class="panel-collapse collapse" id="checkInContainer">
			<div class="checkInSelect"></div>
		</div>
		<div class="panel-collapse collapse" id="checkOutContainer">
			<div class="checkOutSelect"></div>
		</div>
		<div class="huespedes mbt_mt-15">
			<b>Huéspedes</b>
			@php
			$capacidad = collect([1 => '1 huésped']);
			@endphp
			@for ($i = 2; $i <= $propiedad->detalles->capacidad; $i++)
				@php
				$capacidad->push($i.' huéspedes');
				@endphp
			@endfor
			{!! Form::label('total_adultos', '', ['class' => 'sr-only']) !!}
			{!! Form::select('total_adultos', $capacidad, $request->total_adultos ?? null, []) !!}
		</div>

		<div class="form-group form-group-sm">
			{{--
			<b>Codigo promocional</b>
			--}}
			{!! Form::label('codigo_promocional', '', ['class' => 'sr-only']) !!}
			{!! Form::text('codigo_promocional', $request->codigo_promocional ?? null, ['class' => 'form-control mbt_mt-5', 'style' => 'text-transform:uppercase;']) !!}
			@if(isset($valores['cupon_invalido']))
				<span id="helpBlock" class="help-block">{{ $valores['cupon_invalido'] }}.</span>
			@endif
		</div>


		@if ($valores)
			@php
				$promedio = '$'.$valores['precio_promedio'];
			@endphp

			<div class="mbt_datos"><strong>${{ $valores['precio_promedio'] }}</strong> X {{ $valores['noches'] }} noches
				<span class="pull-right">{{ $valores['precio_base'] }}</span>

				@if (count($valores['desgloce']->precios) < 6)
					<a href="#detalleDias" class="text-right" style="display:block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">detalle</a></div>
					<div class="collapse" id="detalleDias">
						<div class="well">
							@php
								$i = 1;
							@endphp
							@foreach ($valores['desgloce']->precios as $key => $precio)
								<div class="col-xs-4 mbt_p-0"><h5><small>Noche {{ $i++ }}</small></h5></div>
								<div class="col-xs-5 mbt_p-0"><h5><small>{{ Carbon\Carbon::parse($precio->fecha)->format('d/m/Y') }}</small></h5></div>
								@php
									$valor = $precio->precio * (($PorcentajePublicacion/100) + 1);
								@endphp
								<div class="col-xs-3 mbt_p-0 text-right"><h5><small>${{ cambioMoneda($valor, $propiedad->ubicacion->datosPais->moneda, session('valor')) }}</small></h5></div>
								<div class="clearfix"></div>
							@endforeach
						</div>
					</div>
				@else
					<p href="#detalleDias" class="text-right" style="display:block"><small>Valor promedio por noche.</small></p>
				</div>
			@endif

			@if ($valores['gastos_limpieza'] > 0)
				<div class="mbt_datos">Gasto de limpieza <a href="#" class="masterTooltip" title="Costo por servicio de mantenimiento."><i class="fa fa-question-circle" aria-hidden="true"></i></a> <span class="pull-right">{{ $valores['gastos_limpieza'] }}</span></div>
			@endif

			<div class="mbt_datos">Tarifa de servicio <a href="#" class="masterTooltip" title="Descontamos un porcentaje por reserva concretada, por costo y gestión."><i class="fa fa-question-circle" aria-hidden="true"></i></a> <span class="pull-right">{{ $valores['tarifa_servicio'] }}</span></div>

			@isset($valores['total_descuento_cupon'])

				<div class="mbt_datos">Valor de la reserva <span class="pull-right">{{ $valores['total_no_descuento_cupon'] }}</span></div>
				<div class="mbt_datos">Descuento por cupon <span class="pull-right">{{ $valores['total_descuento_cupon'] }}</span></div>
			@endisset

			<div class="precioBig text-right">{{ $valores['total_pagar'] ?? $valores['total'] }} <small>{{ session('moneda') }}</small></div>

			@if (isset($valores['total_clp']))
				<div class="precioBig text-right"><h4>{{ $valores['total_pagar_clp'] ?? $valores['total_clp'] }}<small>CLP</small></h4></div>
			@endif
		@endif

		{!! Form::submit($propiedad->administracion->reserva_automatica ? 'Reserva' : 'Solicita reserva', [
			'class' => 'btn btn-lg btn-primary btn-block mbt_mt-20 mbt_p-0',
			'disabled' => $valores ? false : true,
			'style' => 'padding: 0px;'
			]) !!}
		{{--
		@if (Auth::user() && Auth::user()->tipo_usuario == 'A')
			{!! Form::submit($propiedad->administracion->reserva_automatica ? 'Reserva' : 'Solicita reserva', [
				'class' => 'btn btn-lg btn-primary btn-block mbt_mt-20 mbt_p-0',
				'disabled' => $valores ? false : true,
				'style' => 'padding: 0px;'
				]) !!}
		@else
			{!! link_to('#', $title = 'Reservar', $attributes = [
				'class' => 'btn btn-lg btn-primary btn-block mbt_mt-20',
				'data-toggle' => 'modal',
				'data-target' => '#miReserva'
			], $secure = null) !!}
		@endif
		--}}

	</div>

	<aside class="vistas col-xs-12 col-md-12 col-sm-4 ctcAlpro">
		<button type="button" data-toggle="modal" data-target="#miMsg">
			Realiza una pregunta al anfitrión <i class="fa fa-comments-o" aria-hidden="true"></i>
		</button>
	</aside>
</div>
</div>
{!! Form::close() !!}
