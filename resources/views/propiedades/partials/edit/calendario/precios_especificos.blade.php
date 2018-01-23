@php
$form_config = [
					'route' => ['propiedad.calendario.actualizar.precio', $propiedad->id ], 
					'id' => 'form_precio_especifico',
					'class' => 'form_editar_seccion',
					'callback' => 'callback_form_eventos(result)',
				];
				
$disabled_fechas = '';//aqui estaba disabled		

@endphp

@if( $modo == 'create') 
	{!! Form::open($form_config) !!}
@else
	{!! Form::model($precio_especifico, $form_config) !!} 
@endif

	{{csrf_field()}}
	
	{!! Form::text('id', null, ['class' => 'hide']) !!} 
	{!! Form::text('modo', $modo, ['name' => 'modo', 'class' => 'hide' ]) !!} 
	{!! Form::text('motivo', 'precio', [ 'name' => 'motivo', 'class' => 'hide' ]) !!} 
	{!! Form::text('propiedad_id', null, ['class' => 'hide']) !!} 
	
	
	<div class="row" >
		<div class="col-md-12">
			<h4 style="margin-top: 15px;" >¿Cuándo deseas aplicar este precio?</h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="radio">
				<input type="radio" id="modificar_precio_todas_las_fechas" name="tipo_modificacion_precio" value="todas_las_fechas" checked >
				<label for="modificar_precio_todas_las_fechas" >Todas las fechas</label>
			</div>
		</div>
		<div class="col-md-4">
			<div class="radio">
				<input type="radio" id="modificar_precio_fin_de_semana" name="tipo_modificacion_precio" value="fin_de_semana" >
				<label for="modificar_precio_fin_de_semana" >Fines de Semana</label>
			</div>
		</div>
	</div>
	<script>
		$('[name=tipo_modificacion_precio]').change(function(){
			if($(this).val() == 'fin_de_semana')
			{
				$('.dias_de_la_semana').prop('checked',true);
				$('.dias_de_la_semana').prop('disabled',false);
			}
			if($(this).val() == 'todas_las_fechas')
			{
				$('.dias_de_la_semana').prop('checked',false);
				$('.dias_de_la_semana').prop('disabled',true);
			}
		});
	</script>
	<div class="row" >
		<div class="col-md-12">
		
			<!--
			<div class="col-md-2">
				<input type="checkbox" id="dia_1" value="1" >
				<label for="dia_1" class="checkbox-inline">Lunes</label>
			</div>
			
			<div class="col-md-2">
				<input type="checkbox" id="dia_2" value="2" >
				<label for="dia_2" class="checkbox-inline">Martes</label>
			</div>
			
			<div class="col-md-2">
				<input type="checkbox" id="dia_3" value="3" >
				<label for="dia_3" class="checkbox-inline">Miercoles</label>
			</div>
			
			<div class="col-md-2">
				<input type="checkbox" id="dia_4" value="4" >
				<label for="dia_4" class="checkbox-inline">Jueves</label>
			</div>
			-->
			
			<div class="col-md-offset-4 col-md-2">
				<input type="checkbox" id="dia_5" value="5" class='dias_de_la_semana' name="dias_de_la_semana[]" disabled >
				<label for="dia_5" class="checkbox-inline">Viernes</label>
			</div>
			
			<div class="col-md-2">			
				<input type="checkbox" id="dia_6" value="6" class='dias_de_la_semana' name="dias_de_la_semana[]" disabled >
				<label for="dia_6" class="checkbox-inline">Sábado</label>
			</div>
			
			<div class="col-md-2">		
				<input type="checkbox" id="dia_0" value="0" class='dias_de_la_semana' name="dias_de_la_semana[]" disabled >
				<label for="dia_0" class="checkbox-inline">Domingo</label>
			</div>
			
		</div>
	</div>

	@include('propiedades.partials.edit.calendario.fechas')
	
	<div class="row">
		
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('descripcion', 'descripcion', ['class' => '']) !!}
				{!! Form::text('descripcion', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Descripción del cambio de precio']) !!}
			</div>
		</div>
			
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('precio', 'precio', ['class' => '']) !!}
				{!! Form::number('precio', null, ['class' => 'form-control', 'maxlength' => 15, 'min' => 1, 'max' => 999999999, 'placeholder' => 'Precio Específico']) !!}
			</div>
		</div>
		
	</div>
	
	<hr>
	
	<div class="row" >
		<div class="col-md-12">
			<div class="form-group pull-right">
				<button type="submit" class="btn btn-primary" onclick="" >Guardar</button>
			</div>
		</div>
	</div>

{!! Form::close() !!}

{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarCalendarioPrecioEspecificoRequest', '#form_precio_especifico'); !!}
