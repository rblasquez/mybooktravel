@inject('helper', 'App\Http\Controllers\HelperController')

@php
$id_unico = date("YmdHis");

$ruta  = '?fecha_entrada=' . $request->fecha_entrada ?? '';
$ruta .= '&fecha_salida=' . $request->fecha_salida ?? '';
$ruta .= '&total_adultos=' . $request->total_adultos ?? 1;
$ruta .= '&total_ninos=' . $request->total_ninos ?? 0;

@endphp
@if($propiedades->count() == 0)
<div class="well">
	<h4 class="text-left">
		No se han encontrado propiedades con las caracteristicas señaladas,
		intenta modificando los filtros.
	</h4>
	<p>Trata de refinar tu búsqueda. Aquí tienes algunas ideas:</p>
	<ul>
		<li>Cambia tus filtros o fechas</li>
		<li>Reduce la ampliación del mapa</li>
		<li>Busca una ciudad, dirección o lugar de referencia específico</li>
	</ul>
</div>
@else

<div class="col-md-12 resultadosFiltros">
	<div class="col-md-12 col-sm-12 resultadosFiltros">
		<div class="col-md-10 col-sm-10">
			{!! $mensaje !!}
		</div>
		<div class="col-md-2 col-sm-2 text-right">
			<button class="verMapa" id="mostrar_mapa_general_{{ $id_unico }}" name="mostrar_mapa_general_{{ $id_unico }}" onclick="">Ver Mapa <i class="fa fa-map-marker" aria-hidden="true"></i></button>
			<button class="cerrarMapa"><i class="fa fa-times" aria-hidden="true"></i></button>
		</div>
	</div>
</div>

<div class=" col-md-12">
	<div class="elMapa" name="mapa_general_{{ $id_unico }}" id="mapa_general_{{ $id_unico }}" mapa_generado="0" style="height:200px;" ></div>
</div>
<div class="clearfix"></div>
@foreach ($propiedades as $propiedad)

<div class="col-md-4">
	<div class="mbt-card mbt_mb-20">
		<div class="mbt-card-header">
			<div class="row">
				<div class="col-xs-10">
					<h5>
						<a href="{{ route('propiedad.detalle', $propiedad->id) . $ruta }}">
							{{ $propiedad->nombre }}
						</a>
					</h5>
				</div>
				<div class="col-xs-2 text-right">
					@if($propiedad->administracion->reserva_automatica)
					<i class="fa fa-bolt" style="color: gray; display: inherit"></i>
					@endif
				</div>
			</div>
		</div>

		<a href="{{ route('propiedad.detalle', $propiedad->id) . $ruta }}">
			<div class="mbt-card-image {{ (count($propiedad->imagenes) > 0) ? 'fotos-miniatura' : '' }}">
				@if(count($propiedad->imagenes) > 0)

				@foreach ($propiedad->imagenes->sortByDesc('primaria') as $imagen)
				<div class="img_container">
					<img
					data-lazy="{{ App\Http\Controllers\HelperController::getUrlImg($propiedad->usuario->id, $imagen->ruta, 'lg') }}"
					alt=""
					>
				</div>
				@endforeach

				@else
				<div class="img_container">
					<img src="{{ asset('img/casa.jpg') }}" class="img-responsive" alt="Image">
				</div>
				@endif
			</div>
		</a>

		@php
		$precio = $helper->costoPropiedad($propiedad, $request->fecha_entrada, $request->fecha_salida);
		@endphp

		<div class="mbt-card-action mbt_p-0 mbt_pb-10">
			<div class="col-xs-4 price mbt_mt-5">
				<h5><small>Valor por noche</small></h5>
				<h4>
					<b>${{ $precio }}</b>
				</h4>
			</div>
			<div class="col-xs-4 mbt_mt-15">
				<h6><i class="fa fa-circle"></i> {{ $propiedad->detalles->capacidad }} {{ $propiedad->detalles->capacidad == 1 ? 'persona' : 'personas' }}</h6>
			</div>
			<div class="col-xs-4 mbt_mt-15 mbt_p-0">
				<h6><i class="fa fa-circle"></i> {{ $propiedad->detalles->nhabitaciones }} {{ $propiedad->detalles->nhabitaciones == 1 ? 'habitación' : 'habitaciones' }}</h6>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

@endforeach
<div class="col-md-12 text-center">
	{{$propiedades->links()}}
</div>

<script>
	document.getElementById("mostrar_mapa_general_{{$id_unico}}").addEventListener("click", function(){
		$('#mapa_general_{{$id_unico}}').toggle('slow',function (e){

			var marcadores = [
			@foreach ($propiedades as $propiedad)
			{
				name: 'descripcion',
				location_latitude: parseFloat("{{ $propiedad->ubicacion->latitud }}"),
				location_longitude: parseFloat("{{ $propiedad->ubicacion->longitud }}")
			},
			@endforeach
			];

			var ubicacion = {
				lat : parseFloat({{$request->latitud_busqueda}}),
				lng : parseFloat({{$request->longitud_busqueda}})
			}, mapa = $("#mapa_general_{{$id_unico}}");

			if(mapa.attr("mapa_generado") == 0)
			{
				mapaUbicacionPropiedad(marcadores, ubicacion, 'mapa_general_{{$id_unico}}');
				$("#mapa_general_{{$id_unico}}").attr("mapa_generado",1);
			}

		});

	});

</script>

@endif
