@php

	$reserva_class = 'hide';
	$disabled = 'disabled';
	if($motivo == 'reserva')
	{
		$reserva_class = '';
		$disabled = '';
	}

	$disabled_fechas = ''; # aqui estaba disabled
	$disabled_email = 'disabled';
	$class_eliminar = 'hide';

	$form_config = [
		'route' => ['propiedad.calendario.actualizar.reserva', $propiedad->id ],
		'id' => 'form_reserva_manual',
		'class' => 'form_editar_seccion',
		'callback' => 'callback_form_eventos(result)',
	];

@endphp

@if( $modo == 'create')
	{!! Form::open($form_config) !!}
@else

	{!! Form::model($reserva_manual, $form_config) !!}

	@php

		$disabled_fechas = '';

		if($reserva_manual->comprobante)
		{
			$disabled_email = '';
		}

		$class_eliminar = '';

	@endphp

@endif

	{{csrf_field()}}

	{!! Form::text('id', null, ['class' => 'hide']) !!}
	{!! Form::text('modo', $modo, ['name' => 'modo', 'class' => 'hide' ]) !!}
	{!! Form::text('motivo', $motivo, [ 'name' => 'motivo', 'class' => 'hide' ]) !!}
	{!! Form::text('propiedad_id', null, ['class' => 'hide']) !!}

	<div class="row">

		<div class="col-md-8">
			Completa estos datos para llevar el control de tu propiedad,
			así será mas facil saber la disponibilidad, precio e ingresos en cualquier momento
		</div>

		<div class="col-md-4">
			<a class=" {{$class_eliminar}}" style='cursor:pointer; font-size:18px;' onclick=eliminar_evento("{{$reserva_manual->id ?? ''}}") >
				<i class="fa fa-times-circle" style='color: red;' aria-hidden="true"></i>
				<span>Eliminar Este Evento</span>
			</a>
		</div>

	</div>

	@include('propiedades.partials.edit.calendario.fechas')

	<div class="row">

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('descripcion', 'Descripción', ['class' => '']) !!}
				{!! Form::text('descripcion', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Descripción']) !!}
			</div>
		</div>

		<div class="col-md-6 {{$reserva_class}}">
			<div class="form-group">
				{!! Form::label('nombres', 'Nombres', ['class' => '']) !!}
				{!! Form::text('nombres', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Nombres']) !!}
			</div>
		</div>

	</div>

	<div class="row {{$reserva_class}}">

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('apellidos', 'Apellidos', ['class' => '']) !!}
				{!! Form::text('apellidos', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Apellidos']) !!}
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('paises_id', 'Pais', ['class' => '']) !!}
				{!! Form::select('paises_id', $paises, null) !!}
			</div>
		</div>

	</div>

	<div class="row {{$reserva_class}}">

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('ciudad', 'Ciudad', ['class' => '']) !!}
				{!! Form::text('ciudad', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Ciudad']) !!}
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('telefono', 'Teléfono', ['class' => '']) !!}
				{!! Form::number('telefono', null, ['class' => 'form-control', 'maxlength' => 11, 'placeholder' => 'Teléfono', $disabled => $disabled]) !!}
			</div>
		</div>

	</div>

	<div class="row {{$reserva_class}}">

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('precio', 'Precio', ['class' => '']) !!}
				{!! Form::number('precio', null, ['class' => 'form-control montos_reserva', 'maxlength' => 15, 'min' => 0, 'max' => 999999999, 'placeholder' => 'Precio', $disabled => $disabled]) !!}
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('costos_adicionales', 'Costos Adicionales', ['class' => '']) !!}
				{!! Form::number('costos_adicionales', null, ['class' => 'form-control montos_reserva', 'maxlength' => 15, 'min' => 0, 'max' => 999999999, 'placeholder' => 'Costos Adicionales', $disabled => $disabled]) !!}
			</div>
		</div>

	</div>

	<div class="row {{$reserva_class}}">

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('noches', 'Noches', ['class' => '']) !!}
				{!! Form::number('noches', null, ['class' => 'form-control montos_reserva', 'maxlength' => 3, 'min' => 1, 'max' => 365, 'placeholder' => 'Noches','readonly'=>'readonly']) !!}
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('monto_total', 'Monto Total', ['class' => '']) !!}
				{!! Form::number('monto_total', null, ['class' => 'form-control montos_reserva', 'maxlength' => 15, 'min' => 0, 'max' => 999999999, 'placeholder' => 'Monto Total','readonly'=>'readonly']) !!}
			</div>
		</div>

	</div>

	<div class="row {{$reserva_class}}">

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('monto_anticipo', 'Monto Anticipo', ['class' => '']) !!}
				{!! Form::number('monto_anticipo', null, ['class' => 'form-control montos_reserva', 'maxlength' => 15, 'min' => 0, 'max' => 999999999, 'placeholder' => 'Monto Anticipo']) !!}
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('monto_deuda_actual', 'Monto Deuda Actual', ['class' => '']) !!}
				{!! Form::number('monto_deuda_actual', null, ['class' => 'form-control montos_reserva', 'maxlength' => 15, 'min' => 0, 'max' => 999999999, 'placeholder' => 'Monto Deuda Actual','readonly'=>'readonly']) !!}
			</div>
		</div>

	</div>
	{{--
	<div class="row {{$reserva_class}}">

		<div class="col-md-6">

			<div class="radio-inline ">
				{!! Form::checkbox('comprobante', null, null,['class' => 'form-control', 'id' => 'comprobante' ]) !!}
				{!! Form::label('comprobante', 'Enviar Comprobante al Huesped', ['class' => '']) !!}
			</div>

		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('email', 'Email Huesped', ['class' => '']) !!}
				{!! Form::email('email', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Email Huesped', $disabled_email => $disabled_email ]) !!}
			</div>
		</div>

	</div>
	--}}
	
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
{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarCalendarioReservaManualRequest', '#form_reserva_manual'); !!}
