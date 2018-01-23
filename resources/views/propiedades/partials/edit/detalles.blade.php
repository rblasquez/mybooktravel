@extends('propiedades.edit')

@section('seccion_a_editar')

	{!! Form::model($propiedad,['route' => ['propiedad.actualizar.detalles',$propiedad->id],"class"=>"form_editar_seccion","id"=>"form_detalles","name"=>"form_detalles","callback"=>"callback_actualizar_datos(result)"]) !!}
	
		<h3>
			
			<span class="hidden-xs">Detalles</span>
		</h3>
		
		<div>
		
			<h1 class="visible-xs">Detalles</h1>
			
			<h5>Distribución de habitaciones</h5>    
			
			<div id="lista_habitaciones" >
			
				<div data-repeater-list="dist_habitaciones">
					
					<div class="row habisBorder" data-repeater-item >

						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<h6>Habitación</h6>
								</div>
								<div class="col-md-5">
								
									<div class="row">
									
										<div class="inner-repeater">
										
											<div data-repeater-list="listado_camas">
											
												<div class="form-group" data-repeater-item >
												
													<div class="col-md-11 col-xs-11">
													
														{!! Form::select('tipo_cama', $tipo_cama, null, ['class' => 'form-control']) !!}
																
													</div>
													
													<div class="col-md-1 col-xs-1 helpingClose" data-repeater-delete >
														<a class="cerrarCama" title="Eliminar cama" >
														<i class="fa fa-times-circle" aria-hidden="true"></i></a>
													</div>													
													
												</div>
											</div>
											
											<div class="col-md-12 col-xs-12" data-repeater-create>
												<a  class="addCama" title="Añadir cama"  >
												<i class="fa fa-plus-circle" aria-hidden="true"></i> <span>Añadir Cama</span></a>
											</div>
											
										</div>

										<div class="col-md-4 col-xs-4">
											<div class="form-group">
												{!! Form::checkbox('tiene_banio', true, null, ['id' => 'tiene_banio', 'class' => 'checkbox_tiene_banio']) !!}
												<label for="tiene_banio">Baño</label>
											</div>
										</div>
										<div class="col-md-4 col-xs-4">
											<div class="form-group">
												{!! Form::checkbox('tiene_tv', true, null, ['id' => 'tiene_tv', 'class' => '']) !!}
												<label for="tiene_tv">TV</label>
											</div>
										</div>
										<div class="col-md-4 col-xs-4">
											<div class="form-group">
												{!! Form::checkbox('tiene_calefaccion', true, null, ['id' => 'tiene_calefaccion', 'class' => '']) !!}
												<label for="tiene_calefaccion">Calefacción</label>
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-7 col-xs-12">
								{!! Form::textArea('descripcion', '', ['class' => 'textarea_1', 'maxlength' => '140', 'placeholder' => __('propiedad_create.propiedad_habitacion_descripcion')]) !!}
								</div>
							</div>
						</div>
						
						{{--
						<!--
						<div class="col-md-12 col-xs-12 helpingClose" data-repeater-delete >
							<a class="cerrarCama" >
								<i class="fa fa-times-circle" aria-hidden="true"></i>
								<span>Eliminar habitacion</span>
							</a>
						</div>	
						-->
						--}}

					</div>
					
				</div>
				
				{{--
				<!--
				<div class="col-md-12 col-xs-12" data-repeater-create>
					<a  class="addCama"  >
						<i class="fa fa-plus-circle" aria-hidden="true"></i> 
						<span>Añadir Habitación</span>
					</a>
				</div>
				-->
				--}}
				
			</div>
			
			@foreach ($gruposCaracteristicasPropiedades->chunk(2) as $grupos_caracteristica)
			<div class="row" >
				@foreach ($grupos_caracteristica as $grupo)
				
				<div class="col-md-6">
				
					<h5>{{$grupo->descripcion}}</h5>
					
					
					<p class="txtPublish">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
						sed do eiusmod tempor incididunt ut labore et dolore 
						magna aliqua.
					</p>
					
					
					<div class="row">

						<?php 
							
							$caracteristica = $grupo->etiqueta;
							$detalles = $grupo->caracteristicas;
						
							$caracteristicas_actual = array_pluck($propiedad->caracteristicas->toArray(),"n_caracteristicas_propiedades_id");
							$descripcion_actual = array_values($propiedad->caracteristicasComentarios->where('n_grupo_caracteristicas_propiedades_id',$grupo->id)->toArray());
							$descripcion_actual = $descripcion_actual[0]["comentario"] ?? "" ;
							
							$cantidad_grupos = $distribucion_columnas_caracteristicas[$caracteristica]['cantidad_grupos'];
							$ancho_columna_md = ( 12 / $distribucion_columnas_caracteristicas[$caracteristica]['cantidad_grupos'] );
							$tamanio_grupos = $distribucion_columnas_caracteristicas[$caracteristica]['tamanio_grupos'];
							
							$aaa = $detalles->split($cantidad_grupos);
							$bbb = $detalles->chunk($tamanio_grupos);
						?>
							
						@foreach ($bbb as $grupo_elementos)
						<div class="col-md-{{$ancho_columna_md}} col-xs-6">
						
						
							@foreach ($grupo_elementos as $element)
							<!--
							<input class="" id="chk14" type="checkbox" />
							-->
							<?php $id_actual = 'caracteristica['.$element->id.']'; ?>
							{!! Form::checkbox($id_actual, $element->id, in_array($element->id , $caracteristicas_actual ) ? true : false,["id"=>$id_actual]) !!}
							
							<label for="{{$id_actual}}">{{ $element->descripcion }}</label>
							
							@endforeach	
						</div>	
						@endforeach		
						
						<div class="col-md-12 col-xs-12">
							<!--
							<textarea class="textarea_1" placeholder="Describe tu cocina lo mejor que puedas..."></textarea>
							-->
							{!! Form::textArea('descripcion_caracteristica['.$grupo->id.']', $descripcion_actual, ['class' => 'textarea_1', 'maxlength' => '140', 'placeholder' => 'Describe este espacio']) !!}
						</div>				
						
					</div>
				</div>
				@endforeach
				
				
				@if ($loop->last)
					
					@php

						$normas_basicas = array_pluck($propiedad->normas()->get()->toArray(),"n_norma_id");
						
						$normas_adicionales = $propiedad->normasAdicionales()->get()->toArray();
						$normas_adicional = $normas_adicionales[0]["normas"] ?? "" ;
						
						// App\Http\Controllers\HelperController::echoPre($normas_adicional);
					
					@endphp
				
					<div class="col-md-6">
						<h5>Normas</h5>
						
						<p class="txtPublish">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
							sed do eiusmod tempor incididunt ut labore et dolore 
							magna aliqua.
						</p>
						
						<div class="row">
						
							@foreach ($normas->chunk(4) as $grupos_normas)
							<div class="col-md-6 col-xs-6">
								@foreach ($grupos_normas as $norma)
								
									{!! Form::checkbox('normas[]', $norma->id, in_array($norma->id,$normas_basicas ) ? true : false,["id"=>"norma_id_".$norma->id]) !!}
								
									<label for="norma_id_{{$norma->id}}">{{ $norma->descripcion }}</label>
										
								@endforeach	
							</div>	
							@endforeach		
							
							<div class="col-md-12 col-xs-12">
								{!! Form::textArea('normas_adicionales', $normas_adicional, ['class' => 'textarea_1', 'maxlength' => '140', 'placeholder' => 'Describe tus normas']) !!}
							</div>	
						
						</div>
						
					</div>
				@endif

			</div>
			@endforeach
		
		</div>
		
		<!--
		<div class="row pull-right">
			<button type="submit" class="btn btn-lg  ">Guardar</button>
		</div>
		-->
		<div class="col-md-2 col-md-offset-10">
		   <button>Guardar</button>
		</div>

	{!! Form::close() !!}

@endsection

@push('css')
	
	<style>
	</style>

@endpush

@push('js')

	{!! Html::script('plugins/jquery.repeater/jquery.repeater.min.js') !!}

	<script>
	
		$(document).ready(function() {
			
			var repeaterOptions = {
				initEmpty: false,
				isFirstItemUndeletable: true,
				show: function () 
				{
					// console.log("i am the event add item");
					
					//fixing the issue of the labels
					var params = [this];
					$(this).find("label[for]").each(function(index, element) {
						// console.log($(element).attr("for"));
						// console.log(params[0]);
						var currentRepeater = params[0];
						var originalFieldId = $(element).attr("for");
						var newField = $(currentRepeater).find("input[id='"+originalFieldId+"']");
						if($(newField).length > 0)
						{
							var newFieldName = $(newField).attr('name');
							$(newField).attr('id', newFieldName);
							$(currentRepeater).find("label[for='"+originalFieldId+"']").attr('for', newFieldName);
						}
					},params);					
					
					//showing the new repeater
					$(this).slideDown();
				},
				hide: function (deleteElement) 
				{
					// console.log("soy el evento eliminar item");
					$(this).slideUp(deleteElement);
					
					//forza la seleccion de 1 habitacion al eliminar todas las habitaciones 
					// if( $('.eliminar-habitacion').length == 1 )$(".agregar-habitacion").click();
				},
				ready: function (setIndexes) 
				{
					//console.log("el cotenido ha sido cargado");
				},
				repeaters: [{
					initEmpty: false,
					isFirstItemUndeletable: true,
					selector: '.inner-repeater',
					show: function () {
						$(this).slideDown();
						
						//forza la seleccion de un tipo de cama al crear una cama
						$(this).find("#tipo_cama").val(1);
					},
					hide: function (deleteElement) {
						$(this).slideUp(deleteElement);
					}
				}],
				
				
			};
			
			var $repetidificador = $('#lista_habitaciones').repeater(repeaterOptions);
		
			/*
			$repetidificador.setList([
				//ejemplo
				{
					'listado_camas': [
						{'tipo_cama': '1'},
						{'tipo_cama': '1'},
					],
					'tiene_banio':['0'],//esto checkea los check box que tengan el name 'tiene_banio' y el value '1' o true, en este caso
					'tiene_tv':['1'],
					'tiene_calefaccion':['1'],
					'descripcion':'una descripcion x',
				},
			]);
			*/
			
			@php 
			
				$cantidad_habitaciones_permitidas = $propiedad->detalles->nhabitaciones;
				$cantidad_habitaciones_existentes = $propiedad->detalles->distribucionhabitaciones->count();
				$habitaciones_existentes = collect($propiedad->detalles->distribucionhabitaciones)->toArray();
				
				// print_r("orale");
				// print_r($cantidad_habitaciones_existentes);
				// print_r($habitaciones_existentes);
				// print_r("orale");
				
				$habitacion_nueva = ["camas"=>'["1"]',"tiene_banio"=>0,"tiene_tv"=>0,"tiene_calefaccion"=>0,"descripcion"=>""];
				$habitaciones_a_precargar = [];
				
				$i=0;
				while($i<$cantidad_habitaciones_permitidas)
				{
					$habitaciones_a_precargar[] = isset($habitaciones_existentes[$i])? $habitaciones_existentes[$i] : $habitacion_nueva ;
					$i++;
				}
				
			@endphp			

			@if(count($habitaciones_a_precargar) > 0)
				$repetidificador.setList([
					@foreach( $habitaciones_a_precargar as $index => $habitacion_actual )
					{
						@php 
							eval (' $tipo_cama_actual = '.$habitacion_actual["camas"].';');
						@endphp
						
						'listado_camas': [
						@foreach($tipo_cama_actual as $key =>$id_cama)
							{'tipo_cama': '{{$id_cama}}'},
						@endforeach
						],
						'tiene_banio':['{{$habitacion_actual["tiene_banio"]}}'],
						'tiene_tv':['{{$habitacion_actual["tiene_tv"]}}'],
						'tiene_calefaccion':['{{$habitacion_actual["tiene_calefaccion"]}}'],
						'descripcion':'{{$habitacion_actual["descripcion"]}}',
					},	
					@endforeach
				]);
			@endif
			//console.log($('#lista_habitaciones').repeaterVal());
			

			//control de baños
			$(".checkbox_tiene_banio").click(function (event){
				//banos
				var cantidad_banios_perimitidos = "{{$cantidad_habitaciones_permitidas = $propiedad->detalles->nbanios }}";
				var cantidad_banios_seleccionados = $(".checkbox_tiene_banio:checked").length;
				
				// alert("cantidad_banios_perimitidos: "+cantidad_banios_perimitidos);
				// alert("cantidad_banios_seleccionados: "+cantidad_banios_seleccionados);
				
				if(cantidad_banios_seleccionados > cantidad_banios_perimitidos)
				{
					event.preventDefault();
				}
				
			});
			
			
			
		});
		
		

		
	</script>
	
	{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
	{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarDetallesRequest', '#form_detalles'); !!}

@endpush