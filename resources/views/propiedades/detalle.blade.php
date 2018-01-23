@extends('layouts.app')

@inject('helper', 'App\Http\Controllers\HelperController')

@section('content')
@php
	$precio = $helper->costoPropiedad($propiedad);
@endphp

	<section class="container profileContent">
		<div class="row">
			<div class="col-md-9">
				@if(Auth::user() && Auth::user()->id == $propiedad->usuario->id)
					<div class="row">
						<div class="col-md-10">
							<h1>{{ $propiedad->nombre }}</h1>
						</div>
						<div class="col-md-2">
							<h1><a href="{{ route('propiedad.editar.seccion',[$propiedad->id,'resumen']) }}" class="btn btn-primary btn-block"><i class="fa fa-edit" style="color: #fff"></i> Editar</a></h1>
						</div>
					</div>
				@else
					<h1>{{ $propiedad->nombre }}</h1>
				@endif

				<span class="hidden-sm hidden-md hidden-lg precioXs">
					@if ($propiedad->administracion)
						@if ($propiedad->administracion->reserva_automatica)
							<i class="fa fa-bolt masterTooltip" title="Reserva Inmediata" aria-hidden="true"></i>
						@endif
						<span class="pbase">${{ $precio }} <small>{{ session('moneda') }}</small></span>
					@endif
				</span>
				@if (count($propiedad->imagenes) > 0)
					@php
					$imagenf = $propiedad->imagenes->where('primaria', true)->first()->ruta;
					$imagenf = $helper->getUrlImg($propiedad->usuario->id, $imagenf, 'lg');
					@endphp

					<div class="galeria">
						@foreach ($propiedad->imagenes->sortByDesc('primaria') as $imagen)
							@if ($loop->first)
								<a class="propertyGalery" href="{{ $imagenf }}" title="{{ $propiedad->nombre }}">
									<div class="preview_container mbt_mt-5" style="
									background: url('{{ $imagenf }}') no-repeat center;
									-webkit-background-size: cover;
									-moz-background-size: cover;
									-o-background-size: cover;
									background-size: cover;">
									<h4 class="text-left">
										ID: A{{ $propiedad->id }}
										<span class="pull-right">+{{ count($propiedad->imagenes) - 1 }} imagenes</span></h4>
									</div>
								</a>
							@else
								<a class="propertyGalery hide" href="{{ $helper->getUrlImg($propiedad->usuario->id, $imagen->ruta, 'lg') }}" title="{{ $propiedad->nombre }}"></a>
							@endif

						@endforeach
					</div>
				@else
					<div class="preview_container mbt_mt-5" style="background: url('{{ asset('img/mail/publicacion_banner.jpg') }}') no-repeat center;
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
					background-size: cover;
					">
					<h4 class="text-left">
						ID: A{{ $propiedad->id }}
						<span class="pull-right">no ha cargado imagenes</span>
					</h4></div>
				@endif


				<div class="row">
					<div class="col-md-12">
						<figure class="servicios">
							@if ($propiedad->caracteristicas->contains('n_caracteristicas_propiedades_id', 23))
								<div class="col-md-3 col-sm-3 col-xs-3">
									<img src="{{ asset('img/iconos/wifi') }}.svg" class=""><span>WI-Fi</span>
								</div>
							@else
								<div class="col-md-3 col-sm-3 col-xs-3">
									<img src="{{ asset('img/iconos/wifi-2') }}.svg" class=""><span>Sin WI-Fi</span>
								</div>
							@endif
							@if ($propiedad->detalles->estacionamientos > 0)
								<div class="col-md-3 col-sm-3 col-xs-3">
									<img src="{{ asset('img/iconos/carro.svg') }}" class=""><span>{{ trans_choice('propiedad_detalle.estacionamiento', $propiedad->detalles->estacionamientos) }} {{ $propiedad->detalles->estacionamientos }}</span>
								</div>
							@else
								<div class="col-md-3 col-sm-3 col-xs-3">
									<img src="{{ asset('img/iconos/carro-2.svg') }}" class=""><span>{{ trans_choice('propiedad_detalle.estacionamiento', 0) }}</span>
								</div>
							@endif
							<div class="col-md-3 col-sm-3 col-xs-3">
								<img src="{{ asset('img/iconos/habitaciones.svg') }}" class=""><span>@lang('propiedad_detalle.habitaciones') {{ $propiedad->detalles->nhabitaciones }}</span>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3">
								<img src="{{ asset('img/iconos/noches.svg') }}" class=""><span>@lang('propiedad_detalle.noches_minimas') {{ $propiedad->administracion->noches_minimas }}</span>
							</div>
						</figure>
					</div>
				</div>

				<hr style="
				margin-top: 30px;
				border-top: #E6E7E8 1px solid;
				padding-bottom: 5px;
				">

				<h3 style="
				border-bottom: #0ec8db 1px solid;
				padding-bottom: 5px;
				margin: 25px 0;
				">Resumen</h3>

				<div class="row">
					<div class="col-md-12">
						<h4>{{ $propiedad->tipo->descripcion }}</h4>
						<div id="descrip">
							{!! nl2br($propiedad->descripcion) !!}
						</div>
					</div>

					<div class="col-md-12">
						<div class="col-xs-4 col-md-2 columnsResumen">
							<h5>Superficie</h5>
							<p>{{ $propiedad->detalles->superficie }} mts<sup>2</sup></p>
						</div>
						<div class="col-xs-4 col-md-2 columnsResumen">
							<h5>@lang('propiedad_detalle.capacidad_p')</h5>
							<p>{{ $propiedad->detalles->capacidad }}</p>
						</div>
						<div class="col-xs-4 col-md-2 columnsResumen">
							<h5>@lang('propiedad_detalle.banios_p')</h5>
							<p>{{ $propiedad->detalles->nbanios }}</p>
						</div>
						<div class="col-xs-4 col-md-2 columnsResumen">
							<h5>@lang('propiedad_detalle.dormitorios_p')</h5>
							<p>{{ $propiedad->detalles->nhabitaciones }}</p>
						</div>
						<div class="col-xs-4 col-md-3 columnsResumen">
							<h5>Estacionamientos</h5>
							<p>{{ $propiedad->detalles->estacionamientos }}</p>
						</div>
						<div class="clearfix hidden-md hidden-lg"></div>
						<div class="col-xs-4 col-md-3 columnsResumen">
							<h5>Check In</h5>
							<p>{{ Carbon\carbon::parse($propiedad->detalles->checkin)->format('H:i') }} Hrs</p>
						</div>

						<div class="col-xs-4 col-md-3 columnsResumen">
							<h5>Check Out</h5>
							<p>{{ Carbon\carbon::parse($propiedad->detalles->checkout)->format('H:i') }} Hrs</p>
						</div>
					</div>
				</div>


				<h3 style="
				border-bottom: #0ec8db 1px solid;
				padding-bottom: 5px;
				margin: 25px 0;
				">Detalles</h3>

				<div class="row">
					<div class="col-md-12">

						@foreach ($propiedad->detalles->distribucionhabitaciones as $habitacion)
							<div class="columnsResumen">
								<h5 {{ $loop->first ? 'style="margin-top: 0"' : '' }}>Habitación {{ $loop->iteration }}</h5>
								<div class="row stuffHabs_2">
									@php
										$distCamas = json_decode($habitacion->camas);
									@endphp

									@foreach ($distCamas as $cam)
										<div class="habitacionesRow col-md-4 col-xs-6">
											@php
												$cama = $camas->where('id', $cam)->first();

											@endphp
											<p><strong>Cama {{ $loop->iteration }}</strong>: {{ $cama->descripcion ?? '' }}</p>
										</div>
									@endforeach
								</div>

								<div class="row stuffHabs">
									<div class="col-md-4 col-xs-3">
										<strong>Baño</strong>: {{ $habitacion->tiene_banio ? 'Sí' : 'No' }}
									</div>
									<div class="col-md-4 col-xs-3">
										<strong>TV</strong>: {{ $habitacion->tiene_tv ? 'Sí' : 'No' }}
									</div>
									<div class="col-md-4 col-xs-6">
										<strong>Calefacción</strong>: {{ $habitacion->tiene_calefaccion ? 'Sí' : 'No' }}
									</div>
								</div>
								@if ($habitacion->descripcion)
									<p class="pInfoAdd">{{ $habitacion->descripcion }}</p>
								@endif
							</div>
						@endforeach

						@php
							$caracteristicas_propiedad = array_pluck($propiedad->caracteristicas->toArray(), "n_caracteristicas_propiedades_id");
							$normas_propiedad = array_pluck($propiedad->normas->toArray(), "n_norma_id");
							$caracteristicas_descripcion = array_pluck($propiedad->caracteristicasComentarios->toArray(), 'descripcion', 'id') ;
						@endphp
						@foreach ($gruposCaracteristicas as $key => $grupo)
							<div class="col-xs-6 col-md-4 col-sm-4 columnsResumen">
								<h5>{{ $grupo->descripcion }}</h5>
								@foreach ($grupo->caracteristicas as $caracteristica)
									<p class="{{ in_array($caracteristica->id , $caracteristicas_propiedad) ? '' : 'isnot' }}" >{{ $caracteristica->descripcion }}</p>
								@endforeach

								@if ($propiedad->caracteristicasComentarios->where('n_grupo_caracteristicas_propiedades_id', $grupo->id)->count() > 0 )
									<h6 class="hInfoAdd">Descripción {{ $grupo->descripcion }}</h6>
									<p class="pInfoAdd">{{ $propiedad->caracteristicasComentarios->where('n_grupo_caracteristicas_propiedades_id', $grupo->id)->first()->comentario }}</p>
								@endif

							</div>

							{!! $key == 2 ? '<div class="clearfix"></div>' : '' !!}

						@endforeach

						<div class="col-xs-6 col-md-4 col-sm-4 columnsResumen">
							<h5>Normas</h5>
							@foreach ($normas as $norma)
								<p class="{{ in_array($norma->id , $normas_propiedad) ? '' : 'isnot' }}">{{ $norma->descripcion }}</p>
							@endforeach
							@if ($propiedad->normasAdicionales)
								<h6 class="hInfoAdd">Otras Normas</h6>
								<p class="pInfoAdd">{!! nl2br($propiedad->normasAdicionales->normas) !!}</p>
							@endif
						</div>
					</div>
				</div>

				<h3 style="
				border-bottom: #0ec8db 1px solid;
				padding-bottom: 5px;
				margin: 25px 0;
				">Ubicación</h3>

				<div class="ubicando">
					<aside>Este alojamiento se encuentra ubicado en {{ $propiedad->ubicacion->localidad }}, {{ $propiedad->ubicacion->provincia }}, {{ $propiedad->ubicacion->datosPais->nombre }}.</aside>

					<div class="jumbotron" style="height: 250px; margin-bottom: 0px;" id="ubicacionMapa"></div>
					<aside>Tendrás los datos exactos de la ubicación cuando la reserva esté confirmada.</aside>
					<hr>
					@if ($propiedad->ubicacion->zona_descripcion)
						<div class="row">
							<div class="col-xs-12">
								<h5>Descripción de la zona</h5>
								<p id="moverse">{!! nl2br($propiedad->ubicacion->zona_descripcion) !!}</p>
							</div>
						</div>
					@endif
				</div>

				<h3 style="
				border-bottom: #0ec8db 1px solid;
				padding-bottom: 5px;
				margin: 25px 0;
				">Anfitrión</h3>

				<div class="row">
					<div class="col-md-2 col-xs-2">
						<figure>
							@if ($propiedad->usuario->imagen)
								<img class="img-responsive img-circle" src="{{ Storage::cloud('minio')->temporaryUrl('user_img/'.$propiedad->usuario->imagen, \Carbon\Carbon::now()->addMinutes(30)) }}">
							@else
								<img class="img-responsive img-circle" src="{{ asset('img/user.jpg') }}">
							@endif
						</figure>
					</div>

					<div class="col-md-10 col-xs-10 anfitrion">
						@php
							Carbon\Carbon::setLocale(config('app.locale'));
						@endphp

						<b>Alojado por {{ $propiedad->usuario->nombres }} {{ $propiedad->usuario->apellidos }}</b>
						<i class="anfitrionI">Se registró {{ $propiedad->usuario->created_at->diffForHumans() }}</i>
						<p>{{ $propiedad->usuario->descripcion }}</p>
						@if ( $propiedad->usuario->idiomas)
							<p><strong>Idiomas:</strong> {{ $propiedad->usuario->idiomas }}</p>
						@endif
					</div>
				</div>

			</div>

			{{-- INCLUIR ASIDE ACA --}}
			<div id="reser"></div>
		</div>

		@if (count($recomendaciones) > 0)

			<div class="row">

				<div class="col-md-12">
					<h3 class="header30 recomendation">Recomendaciones</h3>
				</div>

				@foreach ($recomendaciones as $propiedad_igual)
					<div class="col-md-3 col-xs-6 alojamientos">
						<a href="{{ route('propiedad.detalle', $propiedad_igual->id) }}">
							<div class="img_container">
								<figure>
									@if ($propiedad_igual->imagenes->first())
										<img class="img-responsive" src="{{ Storage::cloud()->temporaryUrl($propiedad_igual->imagenes->first()['ruta'], \Carbon\Carbon::now()->addMinutes(30)) }}" alt="">
									@else
										<img class="img-responsive" src="{{ asset('img/casa.jpg') }}">
									@endif
								</figure>
							</div>

							<h4 class="hidden-xs">{{ str_limit($propiedad_igual->nombre, 19, '...') }}</h4>
							<h4 class="visible-xs">{{ str_limit($propiedad_igual->nombre, 14, '...') }}</h4>


							<div class="row">
								<div class="precio col-md-4 col-sm-4">${{ cambioMoneda($propiedad_igual->administracion->precio, $propiedad_igual->ubicacion->datosPais->moneda, session('valor')) }}</div>
								<div class="col-md-8 col-sm-8">{{ $propiedad_igual->tipo->descripcion }}</div>
							</div>
						</a>
					</div>
				@endforeach

			</div>
		@endif

	</section>


	<div class="modal fade" id="miReserva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title" id="exampleModalLabel">Reserva</h2>
				</div>
				<div class="modal-body text-center">

					<p><strong>¡Solicita una reserva!</strong></p>
					<p>Nuestro equipo te confirmara de inmediato</p>

					<div id="getting-started" class="countDown text-justify">
						<div class="col-md-12">

							<p>Chile: <strong class="pull-right">+56 (3) 2251 7530</strong></p>
							<p>Argentina: <strong class="pull-right">+54 (115) 984 5148</strong></p>
							<p>Whatsapp: <strong class="pull-right">+56 (9) 8767 6444</strong></p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade" id="miMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title" id="exampleModalLabel">Mensajes</h2>
				</div>
				<div class="modal-body text-center">
					<p>5,4,3… Ya estamos en cuenta regresiva...</p>
					<p>Pronto podrás reservar y contactar a los anfitriones.</p>
				</div>
			</div>
		</div>
	</div>

	<button class="resersBtn hidden-md hidden-sm hidden-lg" onclick="window.location.href='#reser'">RESERVAR</button>

	<a href="{{ route('calcular.noches', $propiedad->id) }}" class="hide ruta_fechas"></a>
	<a class="hide urlPropiedad" href="{{ route('propiedad.detalle', $propiedad->id) }}"></a>
	<span class="token hide" data-token="{{ csrf_token() }}"></span>
@endsection

@push('css')
	<style>
		.preview_container {
			height: 320px;
			position: relative;
			overflow: hidden;
			margin: 0px auto;
			text-align: center;
			border-radius: 6px;
			box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);

		}
		.preview_container h4 {
			position: absolute;
			width: 100%;
			padding: 15px;
			color: #fff;
			bottom: 0;
			background: rgba(0, 0, 0, 0.4);
		}

		.preview_container img {
			position: absolute;
			left: 50%;
			top: 50%;
			width: 100% !important;
			height: auto;
			-webkit-transform: translate(-50%,-50%);
			-ms-transform: translate(-50%,-50%);
			transform: translate(-50%,-50%);
		}

		@media (max-width:375px) {
			.alojamientos .img_container { height: 115px; }
			.alojamientos .img_container img { max-height: 100%; min-width: 120%; }
		}

		.priceBox .input-daterange div {
			width: 50% !important;
		}

		span.aviso {
			font-size: .8em;
			display: block;
		}

		.strikethrough {
			position: relative;
		}

		.strikethrough:before {
			position: absolute;
			content: "";
			left: 0;
			top: 50%;
			right: 0;
			border-top: 1px solid;
			border-color: inherit;

			-webkit-transform:rotate(-50deg);
			-moz-transform:rotate(-50deg);
			-ms-transform:rotate(-50deg);
			-o-transform:rotate(-50deg);
			transform:rotate(-50deg);
		}

		.priceBox .date-picker-wrapper.no-shortcuts.has-gap.single-month,
		.priceBox .date-picker-wrapper.no-shortcuts.no-gap.single-month {
			z-index: 0;
			width: 90%;
		}

		.priceBox .date-picker-wrapper .month-wrapper table {
			width: 100%;
		}

		.slbCloseBtn:hover,
		.slbArrow.prev:hover,
		.slbArrow.next:hover {
			background: transparent;
			border: none;
		}

		.help-block {
			margin-top: -35px;
		}
	</style>
@endpush

@push('js')
	<script type="text/javascript">

	var token = $('.token').data('token')
	var reservas 	= {!! json_encode($reservas) !!}
	var total_inquilinos = {{ $propiedad->detalles->capacidad }}
	var dias_minimos = {{ ($propiedad->administracion->noches_minimas) ?? 1 }}

	var checkin_default = '{{ $request->fecha_entrada ?? '' }}';
	var checkout_default = '{{ $request->fecha_salida ?? '' }}';
	var adultos_default = '{{ $request->total_adultos ?? 1 }}';
	var codigo_promocional = '{{ $request->codigo_promocional ?? '' }}';


	var marcadores = [{
		name: '{{ $propiedad->nombre }}',
		location_latitude: {{ $propiedad->ubicacion->latitud }},
		location_longitude: {{ $propiedad->ubicacion->longitud }},
	}];


	$(document).ready(function() {
		mostrarMapa ()
	});

	function mostrarMapa () {
		let ubicacion = {
			lat : {{ $propiedad->ubicacion->latitud }},
			lng : {{ $propiedad->ubicacion->longitud }}
		};
		mapaUbicacionPropiedad(marcadores, ubicacion, 'ubicacionMapa');
	}



	</script>
	{!! Html::script('js/propiedades-detalles.js?'.$version) !!}
	{{--
	--}}

@endpush
