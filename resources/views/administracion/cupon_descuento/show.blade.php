@extends('administracion.layouts.modulo')

@section('contenedor_modulo')

	<div class="container">
		<div class="row">
			<div class="offset-md-2 col-md-8">
				@include('administracion.cupon_descuento.partials.show')
			</div>
		</div>
	</div>

@endsection
