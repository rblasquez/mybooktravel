@extends('propiedades.edit')

@section('seccion_a_editar')

	{!! Form::model($propiedad->ubicacion,['route' => ['propiedad.actualizar.ubicacion',$propiedad->id],"class"=>"form_editar_seccion","id"=>"form_ubicacion","name"=>"form_ubicacion","callback"=>"callback_actualizar_datos(result)"]) !!}
		
		<h3>
			
			<span class="hidden-xs">@lang('propiedad_create.ubicacion_h5', ['variable' => 'replacement'])</span>
		</h3>

		<div>
		
			<h1 class="visible-xs">@lang('propiedad_create.ubicacion_h5', ['variable' => 'replacement'])</h1>
			<div class="row">

				<div class="col-md-6">

					<div id="contenedor_buscador_google_editar_propiedad" >
						
						<div class="form-group">
							{!! Form::label('direccion', __('propiedad_create.propiedad_ubicacion_direccion'), ['class' => '']) !!}
							{!! Form::text('direccion', null, ['class' => 'form-control direccion', 'placeholder' => __('propiedad_create.propiedad_ubicacion_direccion_placeholder')]) !!}
						</div>
						
						@include("layouts.partials.campos_adicionales_ubicacion")
						
					</div>
					

					<div id="contenedor_mapa_propiedad">
						<div id="mapa_propiedad" class='mapa_propiedad' latitud="{{$propiedad->ubicacion->latitud}}" longitud="{{$propiedad->ubicacion->longitud}}" ></div>
					</div>
					
				</div>

				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('como_llegar', __('propiedad_create.propiedad_ubicacion_como_llegar'), ['class' => '']) !!}
						{!! Form::textArea('como_llegar', null, ['class' => 'textarea_2 form-control', 'placeholder' => "Como Llegar a esta propiedad: “Por ejemplo: Desde el terminal puedes tomar las siguientes líneas de microbuses: 602, 307, 605 y 608, y solicita bajarte en la avenida concon reñaca una vez acá puedes llegar caminando 3 cuadras desde la avenida principal o en colectivo.”"]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('zona_descripcion', __('propiedad_create.propiedad_ubicacion_zona_descripcion'), ['class' => '']) !!}
						{!! Form::textArea('zona_descripcion', null, ['class' => 'textarea_2 form-control', 'placeholder' => "Redacta una breve descripción de la zona: “En este espacio te recomendamos escribir acerca de las características más atractivas del lugar en el que se encuentra tu propiedad. Por Ejemplo: “ Departamento ubicado en barrio central, con locomoción a la puerta, supermecados a menos de 5 minutos en auto, playa y dunas a 15 minutos caminando”."]) !!}
					</div>
				</div>
				
			</div>
			
			<div class="row hide">	
			
				<div class="col-md-12">
					<h6>@lang('propiedad_create.propiedad_ubicacion_lugares_h')</h6>
				</div>
				
				<div class="lugares_cercanos">
					<div data-repeater-list="lugares_cercanos">
						<div class="row" data-repeater-item >
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('lugar', __('propiedad_create.propiedad_ubicacion_lugares_lugar'), ['class' => '']) !!}
									{!! Form::text('lugar', null, ['placeholder' => 'Ej. Jumb']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('distancia', __('propiedad_create.propiedad_ubicacion_lugares_distancia'), ['class' => '']) !!}
									{!! Form::text('distancia', null, ['placeholder' => 'Ej. 200 metros']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('caminando', __('propiedad_create.propiedad_ubicacion_lugares_caminando'), ['class' => '']) !!}
									{!! Form::text('caminando', null, ['placeholder' => 'Ej. 20 minutos']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('vehiculo', __('propiedad_create.propiedad_ubicacion_lugares_vehiculo'), ['class' => '']) !!}
									{!! Form::text('vehiculo', null, ['placeholder' => 'Ej. 5 minutos']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-3 eliminarLugar">
								<div class="form-group">
									<!--
									<input type="button" data-repeater-delete value="Eliminar" ></button>
									-->
									<a  data-repeater-delete >Eliminar Lugar</a>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-2 pull-right">
						<!--
						<input type="button" class="anadiendoLug" data-repeater-create value="Añadir Lugar" ></button>
						-->
						<button type="button" class="anadiendoLug" data-repeater-create>Añadir Lugar</button>
					</div>					
					
				</div>
				
			</div>

		</div>
		
		<!--
		<div class="row pull-right">
			<button type="submit" class="btn btn-lg  ">Guardar</button>
		</div>
		-->
		<div class="col-md-2 col-md-offset-10">
			<button type="button" onclick="verificarUbicacionAntesDeEnviar();" >Guardar</button>
		   <button class="hide" id="boton_submit_real" >Guardar</button>
		</div>
		
	{!! Form::close() !!}
	
@endsection

@push('css')
	
	<style>
		.mapa_propiedad
		{
			margin: 30px 0 0 0;
			width:100%;
			height:250px; 
			border: 0;
		}
	</style>

@endpush

@push('js')
	
	{!! Html::script('plugins/jquery.repeater/jquery.repeater.min.js') !!}

	<script>
		//INICIO MAPA
		
		function verificarUbicacionAntesDeEnviar()
		{
			var contenedor = '#contenedor_buscador_google_editar_propiedad';
			var input = document.querySelector(contenedor+' .direccion');
			var longitud = $(contenedor+' .longitud').val();
			var latitud = $(contenedor+' .latitud').val();
			var condicion = " $('"+contenedor+" .longitud').val() != '' && $('"+contenedor+" .latitud').val() != '' ";
			var accion = "$('#boton_submit_real').click();";
			
			if( input.value != "" && ( longitud == '' || latitud == '' ) )
			{
				// console.log("aqui");
				// console.log("condicion: "+condicion);
				hacerCuando(accion,condicion,10);
			}
			else
			{
				eval(accion);
			}
		}
		
		//inicializar mapa de la base de datos
		function actualizarDivMapa(contenedor)
		{
			var latitud = $(contenedor+" .latitud").val();
			var longitud = $(contenedor+" .longitud").val();
			
			$("#contenedor_mapa_propiedad").empty().append("<div id='mapa_propiedad' class='mapa_propiedad' latitud='"+latitud+"' longitud='"+longitud+"' ></div>");
		}
		
		//la primera vez se ejecuta la funcion
		showSingleMarkerMap('.mapa_propiedad');
		
		//inicializar buscador y callback
		google.maps.event.addDomListener(window, 'load', function(){
			
			var contenedor = '#contenedor_buscador_google_editar_propiedad';
			var callback = "actualizarDivMapa('"+contenedor+"');showSingleMarkerMap('.mapa_propiedad');";
			
			inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(contenedor,callback);
			
			var input = document.querySelector(contenedor+' .direccion');
			
			input.addEventListener("focus", function(){
				//cuando ingresen al campo borra los campos adicionales de direccion
				vaciarCamposDireccion(contenedor);
			}, true);
			
			input.addEventListener("blur", function(){
				
				setTimeout(function(){

					// si abandona el campo de direccion, tiene algo escrito, pero no ha elegido lugar
					// se ejecuta simple geocoding o se borra el campo para forzar eleccion
					if($(contenedor+' .longitud').val() == "" || $(contenedor+' .latitud').val() == "" )
					{
						if(input.value != "")
						{
							inicializar_autocompletar_direccion_google_simple_geocoding(contenedor, callback);
						}
					}
				
				}, 250);
				
			}, true);
			
			input.addEventListener("keydown", function(e){
				if (e.keyCode == 13) 
				{
					e.preventDefault();
					console.log("hicieron enter");
					return false;
				}
			}, true);
		
		});
		//FIN MAPA
		
		//INICIO REPEATER
		$(document).ready(function() {
			
			var repeaterOptions = {
				initEmpty: true,
				show: function () 
				{
					// console.log("soy el evento agregar item");
					$(this).slideDown();
				},
				hide: function (deleteElement) 
				{
					// console.log("soy el evento eliminar item");
					$(this).slideUp(deleteElement);
				},
				isFirstItemUndeletable: true,				
			};
			
			var $repetidificador = $('.lugares_cercanos').repeater(repeaterOptions);
			{{--
			$repetidificador.setList([
				@foreach( $propiedad->ubicacion->lugares->toArray() as $index => $actual )
				{
					'lugar':'{{$actual["lugar"]}}',
					'distancia':'{{$actual["distancia"]}}',
					'caminando':'{{$actual["distancia_caminando"]}}',
					'vehiculo':'{{$actual["distancia_vehiculo"]}}',
				},	
				@endforeach
			]);
			--}}
		});
			
		//FIN REPEATER
	
	</script>
	
	{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
	{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarUbicacionRequest', '#form_ubicacion'); !!}

@endpush