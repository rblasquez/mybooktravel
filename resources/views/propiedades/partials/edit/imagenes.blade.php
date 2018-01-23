@extends('propiedades.edit')

@section('seccion_a_editar')

	<div class="mbt_mt-20">
		@include('propiedades.partials.loadimage')
	</div>

	<!--rutas y variables-->
	<div class="hide" >
		<input type="text" id="cantidad_maxima_imagenes" name="cantidad_maxima_imagenes" value="{{$CantidadMaximaImagenesPorPropiedad}}" class="" />
		<input type="text" id="imagenes_guardadas" name="imagenes_guardadas" value="{{$propiedad->imagenes->count()}}" class="" />
		<input type="text" id="initial_previews" name="initial_previews" value="{{$initial_previews}}" class="" />
		<input type="text" id="id_imagen_primaria" name="id_imagen_primaria" value="{{$propiedad->imagenes()->where('primaria', true)->first()->id ?? 0}}" class="" />
		<a href="{{route('propiedad.actualizar.obtenercarruselimagenes',[$propiedad->id])}}" class="obtenerCarruselImagenes " >c</a>
		<a href="{{route('propiedad.actualizar.eliminarimagen',[$propiedad->id])}}" class="eliminarImagen " >e</a>
		<a href="{{route('propiedad.actualizar.agregarimagenesnew',[$propiedad->id])}}" class="agregarImagen " >a</a>
		<a href="{{route('propiedad.actualizar.asignarimagenprimaria',[$propiedad->id])}}" class="asignarImagenPrimaria " >a</a>
		<a href="{{route('propiedad.actualizar.rotarimagen',[$propiedad->id])}}" class="rotarImagen " >a</a>
	</div>

@endsection

@push('js')

	{!! Html::script('js/Imagine.js?'.$version) !!}
	{!! Html::script('js/Imagenes.js?'.$version) !!}
	<script>Imagenes.edit.start();</script>

@endpush
