@extends('emails.layout')

@section('content')

	@php

		$ruta_imagen_cupon = $message->embed('img/cupon_descuento/'.$cupon->codigo.'.jpg');

	@endphp

	<img src='{{$ruta_imagen_cupon}}' style='width:100%;height: 562px;' >
	<div style="width:100%;height: 100px;font-family: 'Maven Pro';">
		Hola {{$usuario->nombres}} {{$usuario->apellidos}}
		<br>
		Por registrarte, has ganado un cupón de descuento por {{$cupon->campania->valor}} pesos {{$cupon->campania->pais->nombre}}
		<br>
		para usar entre las fechas
		{{date('d/m/Y', strtotime($cupon->campania->fecha_inicio))}} y
		{{date('d/m/Y', strtotime($cupon->campania->fecha_fin))}}
		<br> tu cupon es <br> {{$cupon->codigo_formateado}}
	</div>

	{{-- <div style="width:100%;"  style="font-family: 'Maven Pro';" >


	</div> --}}

	</iframe>

@endsection
