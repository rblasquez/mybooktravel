@extends('layouts.app')

@inject('helper', 'App\Http\Controllers\HelperController')

@section('content')

	<div class="container-fluid jom hidden-xs">
		<div class="row">
			<div class="sliding">
				<div>
					<img src="{{ asset('img/slider/slider.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Descubre</p>
							<aside>Lugares impresionantes</aside>
						</div>
					</div>
				</div>
				<div>
					<img src="{{ asset('img/slider/slider5.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Explora</p>
							<aside>Nuevas culturas</aside>
						</div>
					</div>
				</div>
				<div>
					<img src="{{ asset('img/slider/slider6.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Conoce</p>
							<aside>Gente maravillosa</aside>
						</div>
					</div>
				</div>
				<div>
					<img src="{{ asset('img/slider/slider7.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Hospeda</p>
							<aside>A cientos de turistas </aside>
						</div>
					</div>
				</div>
				<div>
					<img src="{{ asset('img/slider/slider2.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Comparte</p>
							<aside>Nuevas experiencias</aside>
						</div>
					</div>
				</div>
				<div>
					<img src="{{ asset('img/slider/slider3.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Encuentra</p>
							<aside>Destinos fascinantes </aside>
						</div>
					</div>
				</div>
				<div>
					<img src="{{ asset('img/slider/slider1.jpg') }}">
					<div class="container">
						<div class="slidingCaption">
							<p>Viaja</p>
							<aside>Con quienes amas</aside>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<section class="container sectionHome">
		<div class="row">
			<div class="col-md-12 homeh1">
				<h1>@lang('index.homeh2')</h1>
			</div>
			@php
				$i = 0;
			@endphp

			@foreach (collect($propiedades_principales) as $ubicacion)

				@php
					$localidad = collect($ubicacion);
					$valor = $localidad['precio'] * (($PorcentajePublicacion / 100) + 1);
					$valor =  number_format($valor, 0, '', ',');
					$i++;
					$imageng = asset('img/descubre/'.sanear_string(strtolower($localidad['ubicacion'])).'g.jpg');
					$imagenp = asset('img/descubre/'.sanear_string(strtolower($localidad['ubicacion'])).'p.jpg');
				@endphp

				<div class="card-box col-md-3 col-sm-6">


					<div class="card text-center hidden-xs"  data-background="image" data-src="{{ $imageng }}">
						<h4 class="title title-modern">
							{{ $localidad['ubicacion'] }}
						</h4>


						<div class="content">
							<div class="price">
								<h3 style="margin-top: 45px">
									<small style="display: block;">Desde</small>
									<b class="currency">$</b>{{ $valor }}
								</h3>

							</div>
							<p class="description">{{ $localidad['cantidad'] }} {{ $localidad['cantidad'] == 1 ? 'Alojamiento' : 'Alojamientos' }}</p>
						</div>
						<div class="filter"></div>
						<div class="footer btn-center">
							<a href="{{ $localidad['ubicacion'] }}" class="btn btn-block btn-neutral btn-round btn-modern localidad">Ver</a>
						</div>
					</div>

					<div class="card card-with-border visible-xs" data-background="image" data-src="{{ $imagenp }}">
						<div class="content text-center">
							<p class="description"><small>Desde</small> ${{ $valor }} <small>//</small> {{ $localidad['cantidad'] }} {{ $localidad['cantidad'] == 1 ? 'Alojamiento' : 'Alojamientos' }}</p>
							<h4 class="title title-modern" style="margin-top: 6px;margin-bottom: 0;font-size: 35px;">{{ $localidad['ubicacion'] }}</h4>
						</div>
						<div class="footer text-center">
							<a href="{{ $localidad['ubicacion'] }}" class="btn btn-neutral btn-round btn-modern localidad">Ver</a>

						</div>
						<div class="filter"></div>
					</div>
				</div>
				@if ($i == 4)
					<div class="col-md-12 mbt_mt-20 hidden-xs">
						<div class="clearfix"></div>
						<h3 class="lined-heading">
							<span>Descubre alojamientos en tu destino favorito</span>
						</h3>
						<div class="clearfix"></div>
					</div>
				@endif
			@endforeach



		</div>

		<div class="hidden-xs">
			<div class="row">
				<div class="col-md-12 homeh1">
					<h1>@lang('index.homeh1')</h1>
				</div>

				<?php $delay = 0; ?>
				@foreach ($propiedades as $propiedad)
					<div class="col-md-3 col-xs-6 alojamientos animated fadeIn">
						<a href="{{ route('propiedad.detalle', $propiedad->id) }}">
							<div class="img_container">
								<figure>
									@if (count($propiedad->imagenes))
										<img class="b-lazy"
										src="{{ asset('img/Isotipo_carga.gif') }}"
										data-src="{{ $helper->getUrlImg($propiedad->usuario->id, $propiedad->imagenes->where('primaria', true)->first()['ruta'], 'lg') }}"
										alt="alt-text"
										/>

									@else
										<img class="img-responsive" src="{{ asset('img/casa.jpg') }}">
									@endif
								</figure>
							</div>

							<h4>{{ $propiedad->tipo->descripcion }} en {{ $propiedad->ubicacion->localidad ?? $propiedad->ubicacion->distrito }}</h4>

							<div class="row">
								@php
									# $precio = $propiedad->administracion->precio * (($PorcentajePublicacion / 100) + 1);
									# $precio = cambioMoneda($precio, $propiedad->ubicacion->datosPais->moneda, session('valor'));
									$precio = $helper->costoPropiedad($propiedad);
								@endphp
								<div class="precio col-md-12">${{ $precio }}</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<div class="hidden-xs">
		<div class="parallax" style="height: 250px">
			<div class="container">
				<a>Viaja, <span>Con quienes amas</span></a>
			</div>
		</div>
		<div class="alojamientosCercanos"></div>
	</div>
@endsection

@push('css')
	<style>
		@media (max-width:375px) {
			.alojamientos .img_container { height: 115px; }
			.alojamientos .img_container img { max-height: 100%; min-width: 120%; }
		}
	</style>
@endpush

@push('js')
	<script>
		var url_lugares = '{{ route('propiedad.cerca', [':PAIS', ':LAT', ':LNG']) }}';
		var ruta_detalles = '{{ route('propiedad.detalle', [':ID']) }}';
		var ruta_busqueda_by_localidad = '{{ route('propiedad.buscar') }}';

		$('.sliding-movil').slick({
			autoplay: true,
			autoplaySpeed: 3000,
			arrows: false,
			dots: false,
			dotsClass: 'personalized-dots'
		});


	</script>
@endpush
