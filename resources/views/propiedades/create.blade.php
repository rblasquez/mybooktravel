@extends('layouts.app')

@section('content')
@php
/*
	$nombre = 'Propiedad de prueba';
	$tipo_propiedades_id = 3;
	$descripcion = 'Esta propiedad es una prueba, por favor ignorar';
	$superficie = 45;
	$capacidad = 6;
	$nhabitaciones = 3;
	$nbanios = 2;
	$estacionamientos = 1;
*/
	$nombre = null;
	$tipo_propiedades_id = null;
	$descripcion = null;
	$superficie = null;
	$capacidad = null;
	$nhabitaciones = null;
	$nbanios = null;
	$estacionamientos = null;
@endphp

<section class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="h1">@lang('propiedad_create.page_title')</h1>
		</div>
		{!! Form::open(['route' => 'propiedad.store', 'id' => 'frmStore']) !!}
		<div id="formPublicar" class="formPublicar">
			{{--
			--}}
			<h3><span class="hache3span">1</span><span class="hidden-xs"> @lang('propiedad_create.step_resumen')</span></h3>
			<div>
				<h1 class="visible-xs">@lang('propiedad_create.step_resumen')</h1>
				@include('propiedades.partials.create.basic')
			</div>
			<h3><span class="hache3span">2</span> <span class="hidden-xs"> @lang('propiedad_create.step_detalles')</span></h3>
			<div>
				<h1 class="visible-xs">@lang('propiedad_create.step_detalles')</h1>
				@include('propiedades.partials.create.detalles')
			</div>
			<h3><span class="hache3span">3</span><span class="hidden-xs"> @lang('propiedad_create.step_fotos_ubicacion')</span></h3>
			<div>
				<h1 class="visible-xs">@lang('propiedad_create.step_fotos_ubicacion')</h1>
				@include('propiedades.partials.create.ubicacion_imagenes')
			</div>
			<h3><span class="hache3span">4</span> <span class="hidden-xs"> @lang('propiedad_create.step_administracion')</span></h3>
			<div>
				<h1 class="visible-xs">@lang('propiedad_create.step_administracion')</h1>
				@include('propiedades.partials.create.administracion')
			</div>
		</div>
		{!! Form::close() !!}
	</div>


	<a href="{{ route('imagenes.temporal') }}" class="hide" id="rutaImagenTemporal"></a>
	<a href="{{ route('rotar.temporal', [':ARCHIVO', ':SENTIDO']) }}" class="hide" id="rutaRotarTemporal"></a>
	<a href="{{ route('borrar.temporal', ':ARCHIVO') }}" class="hide" id="rutaBorrarTemporal"></a>
	<a href="{{ route('propiedad.editar.seccion', [':ID', 'calendario']) }}" class="hide" id="rutaPropiedad"></a>
</section>
@endsection

@push('css')
<style>
	.btn-file {
		position: inherit;
	}

	.label {
		border-radius: 0px;
		font-size: 10px;
		font-weight: 100;
	}

	.label-success {
		background-color: #02CE68;
	}

	.label-danger {
		background-color:
	}

	.table>thead>tr>th
	{
		border-bottom: none !important;
	}

	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
	{
		border-top: none !important;
	}

	.table-striped>tbody>tr:nth-of-type(odd)
	{
		background-color: #f2f2f2;
	}

	@media (max-width:375px) {
		.img_container { height: 115px; }
	}

	@media (min-width:400px) {
		.img_container { height: 126px; }
	}

	@media (min-width:768px) {
		.img_container { height: 130px; }
	}

	@media (min-width:992px) {
		.img_container { height: 100px; }
	}

	@media (min-width:1400px) {
		.img_container { height: 190px; }
	}

	.imagenes-preview {
		margin-top: 30px;
	}

	.image-add,
	.image-add:hover {
		height: 177px;
		background-color: white;
		border: 1px dashed gray;
		color: gray;
		border-radius: 10px;
		margin-bottom: 20px;
	}

	.delete-thumbnail i.fa.fa-trash-o {
		color: gray;
	}

	.image-add i.fa {
		display: block;
		font-size: 2em;
		color: gray;
	}

	.caption input[type=checkbox]+label,
	.caption input[type=radio]+label {
		text-indent: 10px;
		display: block;
		margin-top: 10px;
		margin-left: 15px;
	}

	.div-carga {
		background-color: #fff;
		border: 1px dashed gray;
		height: 177px;
		border-radius: 10px;
		margin-bottom: 20px;
	}

	.div-carga .content
	{
		position: relative; top: 50%;
		-ms-transform: translateY(-50%);
		-webkit-transform: translateY(-50%);
		transform: translateY(-50%);
		font-size: 120%;
	}
	.div-carga .content i {
		color: gray;
	}

	.thumbnail {
		border: 0px;
		border-bottom: 1px solid #ddd;
		border-radius: 0px;
	}
</style>
@endpush

@push('js')

{!! Html::script('js/generate.js?'.$version) !!}
{!! Html::script('js/Imagine.js?'.$version) !!}

{!! Html::script('vendor/jsvalidation/js/jsvalidation.min.js?'.$version) !!}
{!! JsValidator::formRequest('App\Http\Requests\PropiedadStoreRequest', '#frmStore'); !!}
<script>
	var ruta_paises_info = '{{ route('pais.info', ':ID') }}'
	var ruta_imagen_temporales = $('#rutaImagenTemporal').attr('href');
	var token = $('input[name=_token').val()
</script>
{!! Html::script('js/propiedades-create.js?'.$version) !!}
@endpush
