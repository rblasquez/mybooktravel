@php
$form_config = [
					'route' => ['propiedad.calendario.actualizar.noches_minimas', $propiedad->id ], 
					'id' => 'form_noches_minimas',
					'class' => 'form_editar_seccion',
					'callback' => 'callback_form_eventos(result)',
				];
				
$disabled_fechas = '';//aqui estaba disabled		

@endphp

@if( $modo == 'create') 
	{!! Form::open($form_config) !!}
@else
	{!! Form::model($noches_minimas, $form_config) !!} 
@endif

	{{csrf_field()}}
	
	{!! Form::text('id', null, ['class' => 'hide']) !!} 
	{!! Form::text('modo', $modo, ['name' => 'modo', 'class' => 'hide' ]) !!} 
	{!! Form::text('motivo', 'noches_minimas', [ 'name' => 'motivo', 'class' => 'hide' ]) !!} 
	{!! Form::text('propiedad_id', null, ['class' => 'hide']) !!} 

	@include('propiedades.partials.edit.calendario.fechas')
	
	<div class="row">
	
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('descripcion', 'descripcion', ['class' => '']) !!}
				{!! Form::text('descripcion', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Descripción del cambio de noches mínimas de estadía']) !!}
			</div>
		</div>
			
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('noches', 'noches', ['class' => '']) !!}
				{!! Form::number('noches', null, ['class' => 'form-control', 'maxlength' => 15, 'min' => 1, 'max' => 999999999, 'placeholder' => 'Noches Mínimas']) !!}
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
{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarCalendarioNochesMinimasRequest', '#form_noches_minimas'); !!}
