@extends('layouts.app')

@section('content')

	<?php
		$seccionesMenu = [
			"resumen" => "Resumen",
			"detalles" => "Detalle",
			"ubicacion" => "Ubicación",
			"imagenes" => "Imágenes",
			"administracion" => "Administración",
			"calendario" => "Calendario",
		];
	?>
	<section class="container">

		<select class="visible-xs visible-sm menuEditMobile" onchange="document.location=this.value;" >
			@foreach($seccionesMenu as $ruta => $descripcion)
				<option value="{{route('propiedad.editar.seccion',[$propiedad->id, $ruta ])}}" {{$seccion == $ruta ? 'selected' : '' }} >{{$descripcion}}</option>
			@endforeach
		</select>

		<ul class="nav nav-tabs nav-justified visible-md visible-lg menuEditDesktop ">

			@foreach($seccionesMenu as $ruta => $descripcion)
				<li class="pestana_{{$ruta}}" >
					<a href="{{ route('propiedad.editar.seccion',[$propiedad->id, $ruta ]) }}" >
						{{$descripcion}}
					</a>
				</li>
			@endforeach

		</ul>


		<div class="row">
			<div class="col-md-12">
				<div id="example-basic" class="formPublicar editPublish" >
					@yield('seccion_a_editar')
				</div>
			</div>
		</div>

	</section>

@endsection

@push("css")
	<style>
		.img_container {
			height: 100px;
		}

		.imagine_gallery_container .add_image, .imagine_gallery_container .add_image:hover{
			height: 192px;
		}

	</style>
@endpush

@push("js")

	{!! Html::script('js/generate.js?'.$version) !!}
	{!! Html::script('js/propiedades-edit.js?'.$version) !!}

	<script>
		$(".pestana_{{$seccion}}").addClass("active");

		function hacerCuando(accion,condicion,milisegundos)
		{
			//ejecuta una accion solo cuando se llega a cumplir cierta condicion
			var intervalo = setInterval(function(){
				eval("var se_cumple = ( "+condicion+" ) ? true : false;");
				// console.log("se_cumple:"+se_cumple);
				// console.log(condicion);
				if(se_cumple)
				{
					eval(accion);
					clearInterval(intervalo);
				}
			},milisegundos);
		}
	</script>
	<script type="text/javascript">
	/*
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		*/
	</script>

@endpush

@push("head")
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
