@extends('layouts.app')

@inject('helper', 'App\Http\Controllers\HelperController')

@section('content')


<section class="container profileContent">

	<div class="row">

		@include('auth.partials.aside')

		<div class="col-md-9 col-xs-12 formPublicar_1">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h1 style="margin: 0 0 30px 0;
					border-bottom: 1px dashed gray;
					padding-bottom: 10px;">
					Mis Alojamientos
					{{--
					<a class="btn btn-primary pull-right" href="{{ route('propiedad.create') }}">Publica tu alojamiento</a>
					--}}
				</h1>
			</div>
		</div>



		<div class="row">
			@foreach ($propiedades as $propiedad)
			<div class="col-md-6">
				<div class="mbt-card mbt_mb-20">
					<div class="mbt-card-header">
						<h4>{{ $propiedad->nombre }}</h4>
					</div>

					<div class="mbt-card-image">
						<a href="{{ route('propiedad.detalle', $propiedad->id) }}">
							<div class="img_container">
								@if(count($propiedad->imagenes) > 0)
								<img class="b-lazy"
								src=""
								data-src="{{ App\Http\Controllers\HelperController::getUrlImg($propiedad->usuario->id, $propiedad->imagenes->where('primaria', true)->first()['ruta'], 'lg') }}"
								alt="&nbsp;"
								/>
								@else
								<img src="{{ asset('img/casa.jpg') }}" width="800" height="533" class="img-responsive" alt="Image">
								@endif

								@php
								$precio = $propiedad->precio_real ?? $propiedad->administracion->precio;
								$precio = $precio * (($PorcentajePublicacion / 100) + 1);
								$precio = cambioMoneda($precio, $propiedad->administracion->moneda, session('valor'));


								@endphp
								<h4 class="mbt-card-title"><strong>${{ $precio }}</strong> {!! $propiedad->administracion->reserva_automatica ? '<span class="pull-right"><i class="fa fa-bolt" style="color: #fff"></i></span>' : '' !!}</h4>
							</div>
						</a>
					</div>


					<div class="mbt-card-action">
						<div class="row">
							<div class="col-xs-4">
								<a href="{{ route('propiedad.editar.seccion',[$propiedad->id,'resumen']) }}"><i class="fa fa-pencil-square-o"></i> Editar</a>
							</div>
							<div class="col-xs-4">
								<a href="{{ route('reserva.listado', $propiedad->id) }}">
									<i class="fa fa fa-key"></i> Reservas {!! count($propiedad->reservas->where('estatus_reservas_id', 1)) > 0 ? '<span class="badge" style="display: inline">'.count($propiedad->reservas->where('estatus_reservas_id', 1)).'</span>' : '' !!}
								</a>
							</div>
							<div class="col-xs-4">
								<a href="{{ route('propiedad.editar.seccion', [$propiedad->id, 'calendario']) }}"><i class="fa fa-calendar"></i> Calendario</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>

	</div>
</div>
</section>

@endsection

@push('css')
<style>
@media (max-width:375px) {
	.alojamientos .img_container { height: 115px; }
	.alojamientos .img_container img { max-height: 100%; min-width: 120%; }
}



</style>
@endpush
