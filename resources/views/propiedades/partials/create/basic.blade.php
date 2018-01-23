<h5>@lang('propiedad_create.info_basica_h5')</h5>

<div class="row">
	<div class="col-md-6">

		<div class="form-group">
			{!! Form::label('nombre', __('propiedad_create.propiedad_titulo'), ['class' => '']) !!}
			{!! Form::text('nombre', $nombre, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => 'Ej: Tipo de propiedad + Ciudad: Departamento en Concón']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('tipo_propiedades_id', '', ['class' => 'sr-only']) !!}
			{!! Form::select('tipo_propiedades_id', $categorias, $tipo_propiedades_id, ['class' => 'form-control', 'placeholder' => __('propiedad_create.propiedad_tipo')]) !!}
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
			{!! Form::label('descripcion', __('propiedad_create.propiedad_descripcion'), ['class' => '']) !!}
			{!! Form::textArea('descripcion', $descripcion, ['class' => 'form-control textarea_1', 'maxlength' => 255, 'placeholder' => 'Te recomendamos escribir detalles de la infraestructura y equipamiento de tu propiedad; Por ejemplo: Departamento amplio con dormitorios y cocina equipada, vista al mar, espacio para juegos y ambiente tranquilo.']) !!}
		</div>
	</div>

</div>

<h5>@lang('propiedad_create.detalles_h5')</h5>
<div class="row">
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			{!! Form::label('superficie', __('propiedad_create.propiedad_superficie'), ['class' => '']) !!}
			{!! Form::number('superficie', $superficie, ['class' => 'form-control', 'placeholder' => 'Ej: 240 m2', 'min' => 1, 'max' => 9999, 'maxlength'=>'4']) !!}
		</div>
	</div>
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			{!! Form::label('capacidad', __('propiedad_create.propiedad_huespedes'), ['class' => '']) !!}
			{!! Form::number('capacidad', $capacidad, ['class' => 'form-control', 'placeholder' => 'Ej: 3', 'min' => 1, 'max' => 20, 'maxlength'=>'2']) !!}
		</div>
	</div>
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			{!! Form::label('nhabitaciones', __('propiedad_create.propiedad_habitaciones'), ['class' => '']) !!}
			{!! Form::number('nhabitaciones', $nhabitaciones, ['class' => 'form-control', 'placeholder' => 'Ej: 4', 'min' => 1, 'max' => 10, 'maxlength'=>'2']) !!}
		</div>
	</div>
	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			{!! Form::label('nbanios', __('propiedad_create.propiedad_banios'), ['class' => '']) !!}
			{!! Form::number('nbanios', $nbanios, ['class' => 'form-control', 'placeholder' => 'Ej: 3', 'min' => 0,'max' => 10, 'maxlength'=>'2']) !!}
		</div>
	</div>

	<div class="col-md-2 col-xs-6">
		<div class="form-group">
			{!! Form::label('estacionamientos', __('propiedad_create.propiedad_estacionamientos'), ['class' => '']) !!}
			{!! Form::number('estacionamientos', $estacionamientos, ['class' => 'form-control', 'placeholder' => 'Ej: 5', 'min' => 0,'max' => 10, 'maxlength'=>'2']) !!}
		</div>
	</div>

	<div class="col-md-3 col-xs-6">
		<div class="form-group">
			{!! Form::label('checkin', __('propiedad_create.propiedad_checkin'), ['class' => '']) !!}
			{!! Form::time('checkin', Carbon\Carbon::parse('14:00:00')->format('H:i'), ['class' => 'form-control', 'placeholder' => '']) !!}
		</div>
	</div>
	{{--
	<div class="col-md-3 col-xs-6 tipo">

		<div class="row">
			<div class="col-md-3 chkEstricto">
				{!! Form::checkbox('tipo_checkin', true, false, ['id' => 'tipo_checkin_flexible']) !!}

				<label for="tipo_checkin_flexible" class="estricto"></label>
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
				{!! Form::time('checkin_estricto', Carbon\Carbon::parse('14:00:00')->addHours(4)->format('H:i'), ['class' => 'form-control', 'disabled' => true]) !!}
			</div>
		</div>
	</div>
	--}}

	<div class="col-md-3 col-xs-6">
		<div class="form-group">
			{!! Form::label('checkout', __('propiedad_create.propiedad_checkout'), ['class' => '']) !!}
			{!! Form::time('checkout', Carbon\Carbon::parse('11:00:00')->format('H:i'), ['class' => 'form-control']) !!}
		</div>
	</div>

</div>
