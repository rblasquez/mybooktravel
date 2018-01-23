@extends('layouts.app')

@section('content')
<section class="container profileContent">

	<div class="">
		<div class="row">
			@include('auth.partials.aside')

			<div class="col-md-9 col-xs-12 formPublicar_1">
				<div class="row">

					<div class="col-md-12">
						<h1 class="h1 nomargin">Hola, {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</h1>
						@php
							Carbon\Carbon::setLocale(config('app.locale'));
						@endphp
						<i class="anfitrionI">{{ Auth::user()->direccion ?? 'No ha indicado su dirección' }} · Se registró {{ (Auth::user()->created_at) ? Auth::user()->created_at->diffForHumans() : '' }}</i>
					</div>
				</div>

				<div class="row anfitrion">

					<div class="col-md-12 col-xs-12">
						<p class="bioGra">{{ Auth::user()->descripcion }}</p>
						@if (Auth::user()->idiomas)
						<p><strong>Idioma:</strong> {{ Auth::user()->idiomas }}</p>
						@endif
					</div>
				</div>

				@if(session('cupon') !== null)
					<img src='' class='img-responsive postcargar' >
					{{--
					@php
						$cupon = session('cupon');
					@endphp


					<br>
					Por registrarte, has ganado un cupón de descuento por {{$cupon->campania->valor}} pesos {{$cupon->campania->pais->nombre}}
					<br>
					para usar entre las fechas
					{{date('d/m/Y', strtotime($cupon->campania->fecha_inicio))}} y
					{{date('d/m/Y', strtotime($cupon->campania->fecha_fin))}}
					<br>
					tu cupon es

					{{$cupon->codigo}}

					--}}
				@endif

			</div>
		</div>
	</div>
</section>
@endsection

@push('js')
<script>
	$(function() {
	     $(".postcargar").attr('src','{{asset('img/cupon_descuento/pagina.gif')}}');
	});
</script>
@endpush
