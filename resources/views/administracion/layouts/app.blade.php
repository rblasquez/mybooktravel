@php
	$version = "version=".App\Http\Controllers\HelperController::getLastMixUpdate();
@endphp
<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" sizes="180x180" href="{{asset('img/icon/apple-icon-60x60.png')}}">
		<link rel="stylesheet" href='{{asset("administracion/app.css?$version")}}' type="text/css">

		@stack('css')

	</head>

	<body>

		{{csrf_field()}}

		@yield('contenedor_app')

		@include('administracion.partials.routes')

		{!! Html::script('https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyBULVo0G2pzkb79frHM3n_YFR-Ao_6CT-8&libraries=places') !!}
		<script src='{{asset("administracion/app.js?$version")}}' ></script>

		@stack('js')

	</body>

</html>
