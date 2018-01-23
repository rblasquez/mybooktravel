@extends('propiedades.edit')

@section('seccion_a_editar')

	{!! Form::model($propiedad,['route' => ['propiedad.actualizar.resumen',$propiedad->id],"class"=>"form_editar_seccion","id"=>"form_resumen","name"=>"form_resumen","callback"=>"callback_actualizar_datos(result)"]) !!}

		<h3>
			<span class="hidden-xs">Resumen</span>
		</h3>
		
		<div>
		
			<h1 class="visible-xs">Resumen</h1>
			
			<h5>@lang('propiedad_create.info_basica_h5')</h5>
			
			<div class="row">
			
				<div class="col-md-6">

					<!--
					<input type="text" placeholder="Ej: Tipo de propiedad + Ciudad: Departamento en Concón">
					-->
					<div class="form-group">
						{!! Form::label('nombre', __('propiedad_create.propiedad_titulo'), ['class' => '']) !!}
						{!! Form::text('nombre', null, ['class' => 'form-control','placeholder' => "Ej: Tipo de propiedad + Ciudad: Departamento en Concón"]) !!}
					</div>
					<!--
					<select name="Tipo de Propiedad" autofocus tabindex="1">
						<option value="tipo" selected>Tipo de Propiedad</option>
						<option value="casa">Casa</option>
						<option value="departamento">Departamento</option>
						<option value="lodge">Lodge</option>
						<option value="hostal">Hostal</option>	
					</select>
					-->
					<div class="form-group">
						{!! Form::label('tipo_propiedades_id', '', ['class' => 'sr-only']) !!}
						{!! Form::select('tipo_propiedades_id', $categorias, null, ['class' => 'form-control']) !!}
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('descripcion', __('propiedad_create.propiedad_descripcion'), ['class' => '']) !!}
						<!--
						<textarea class="textarea_1" placeholder="Te recomendamos escribir detalles de la infraestructura y equipamiento de tu propiedad; Por ejemplo: Departamento amplio con dormitorios y cocina equipada, vista al mar, espacio para juegos y ambiente tranquilo."></textarea>
						-->
						{!! Form::textArea('descripcion', null, ['class' => 'form-control textarea_1','placeholder' => 'Te recomendamos escribir detalles de la infraestructura y equipamiento de tu propiedad; Por ejemplo: Departamento amplio con dormitorios y cocina equipada, vista al mar, espacio para juegos y ambiente tranquilo.', ]) !!}
					</div>
				</div>

				<!-- esto va en administracion y pagos
				
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-3">
							<input class="checkAdicionales" id="chk" type="checkbox" />
							<label for="chk">¿Ofreces reserva inmediata?</label>
						</div>
						<div class="col-md-6 helpMargin">
							<a class="red-tooltip" data-toggle="tooltip" data-placement="right" title="Al seleccionar esta opción accedes a que tu propiedad quede reservada de forma automática cuando un huésped confirme su reserva, nosotros nos encargaremos de avisarte cuando esto ocurra."><i class="fa fa-question-circle" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
				-->
				
			</div>

			<h5>@lang('propiedad_create.detalles_h5')</h5>
			
			<div class="row">
			
				<div class="col-md-2 col-xs-6">
					<div class="form-group">
						{!! Form::label('superficie', __('propiedad_create.propiedad_superficie'), ['class' => '']) !!} 
						{!! Form::number('superficie', $propiedad->detalles->superficie ?? '', ['class'=>'form-control','paceholder' => 'Ej: 240 m2', 'min' => 1, 'max' => 9999,'maxlength'=>'4']) !!}
					</div>
				</div>
				
				<div class="col-md-2 col-xs-6">
					<div class="form-group">
						{!! Form::label('capacidad', __('propiedad_create.propiedad_huespedes'), ['class' => '']) !!}
						{!! Form::number('capacidad', $propiedad->detalles->capacidad ?? '', ['class'=>'form-control','paceholder' => 'Ej: 3', 'min' => 1, 'max' => 20, 'maxlength'=>'2']) !!}
					</div>
				</div>
				
				<div class="col-md-2 col-xs-6">
					<div class="form-group">
						{!! Form::label('nbanios', __('propiedad_create.propiedad_banios'), ['class' => '']) !!}
						{!! Form::number('nbanios', $propiedad->detalles->nbanios ?? '', ['class'=>'form-control','paceholder' => 'Ej: 2', 'min' => 0, 'max' => 10, 'maxlength'=>'2']) !!}
					</div>
				</div>
				
				<div class="col-md-2 col-xs-6">
					<div class="form-group">
						{!! Form::label('estacionamientos', __('propiedad_create.propiedad_estacionamientos'), ['class' => '']) !!}
						{!! Form::number('estacionamientos', $propiedad->detalles->estacionamientos ?? '', ['class'=>'form-control','paceholder' => 'Ej: 5', 'min' => 0, 'max' => 10,'maxlength'=>'2']) !!}
					</div>
				</div>
				
				<div class="col-md-2 col-xs-6 ">
					<div class="form-group">
						{!! Form::label('nhabitaciones', __('propiedad_create.propiedad_habitaciones'), ['class' => '']) !!}
						{!! Form::number('nhabitaciones', $propiedad->detalles->nhabitaciones ?? '', ['class' => 'form-control','placeholder' => 'Ej: 4', 'min' => 1, 'max' => 10, 'maxlength'=>'2']) !!}
					</div>
				</div>

				<div class="col-md-3 col-xs-6">
					<div class="form-group">
						{!! Form::label('checkin', __('propiedad_create.propiedad_checkin'), ['class' => '']) !!}
						{!! Form::time('checkin', $propiedad->detalles->checkin ?? '', ['class'=>'form-control','placeholder' => 'Ej: 15:00']) !!}					
					</div>
				</div>

				{{--
				<div class="col-md-3 col-xs-6">
					
					<div class="row ">
						<div class="col-md-3 chkEstricto">
							<!--
							<input class="checkAdicionales" id="chk4" type="checkbox" />
							<label for="chk4" class="estricto"></label>
							-->
							
							{!! Form::checkbox('tipo_checkin', 'estricto', $propiedad->detalles->checkin_estricto ?? false == "" ? false : true, ["id"=>"tipo_checkin"] )  !!} 
							<label for="tipo_checkin" class="estricto"></label>
							
						</div>
						<div class="col-md-8 chkEstrictoH6">
							<h6>{{__('propiedad_create.propiedad_checkin_tipo_1')}}</h6>
						</div>
						<div class="col-md-1 noPadd chkEstrictoHelp">
							<a href="#" class="masterTooltip" title="¡Ayúdenme que no entiendo nada!"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-12">
							<!--
							<input type="time" placeholder="Ej: 15:00" disabled >
							-->
							<div class="form-group">
								{!! Form::time('checkin_estricto', $propiedad->detalles->checkin_estricto ?? false, ['class'=>'form-control','placeholder' => 'Ej: 18:00', 'disabled' => true]) !!}
							</div>		
						</div>
					</div>
					
				</div>
				--}}
				
				<div class="col-md-3 col-xs-6">
					<div class="form-group">
						{!! Form::label('checkout', __('propiedad_create.propiedad_checkout'), ['class' => '']) !!}
						{!! Form::time('checkout', $propiedad->detalles->checkout ?? false, ['class' => 'form-control', 'placeholder' => 'Ej: 11:00']) !!}	
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
		   <button>Guardar</button>
		</div>
		
	{!! Form::close() !!}
	
@endsection

@push('css')
	
	<style>
	</style>

@endpush

@push('js')

	<script>
		
		$(document).ready(function(){
			
			var checked_estricto = false;
			// var checked_estricto = $('input[type=checkbox][name=tipo_checkin][value=estricto]')[0].checked;
			// alert(1);
			// alert("flexible: "+checked_flexible+" estricto: "+checked_estricto);
			if(checked_estricto)
			{
				mostrar_checkin_estricto();
			}
			
		});
		
		function mostrar_checkin_estricto()
		{
			// var div = $('.checkin_estricto');
			// div.removeClass('hide');
			// div.find('input').removeAttr('disabled');	
			$('input[name=checkin_estricto]').removeAttr('disabled');		
		}
		
		$('input[type=checkbox][name=tipo_checkin]').on('change', function(event) {
			// alert("aqui");
			
			if ($(this).val() == 'estricto' && $(this)[0].checked) 
			{
				mostrar_checkin_estricto();
			}
			else
			{
				// var div = $('.checkin_estricto');
				// div.addClass('hide');
				// div.find('input').attr('disabled', true);
				$('input[name=checkin_estricto]').val("").attr('disabled', true);
			}
		});
		
	</script>
	
	
	{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
	{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarResumenRequest', '#form_resumen'); !!}


@endpush