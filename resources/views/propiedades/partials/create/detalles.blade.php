<h5>@lang('propiedad_create.dist_habitacioones_h5', ['variable' => 'replacement'])</h5>     


<div class="dist-habitaciones">
	<div data-repeater-list="dist_habitaciones">
		<div data-repeater-item>
			<div class="row habisBorder">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<h6>@lang('propiedad_create.propiedad_habitacion_h') <span class="numero-habitacion">1</span></h6>
						</div>
						<div class="col-md-5">
							<div class="row">
								<div class="inner-repeater">
									<div data-repeater-list="listado_camas">
										<div data-repeater-item>
											<div class="col-md-11 col-xs-11">
												<div class="form-group" style="margin-bottom: 0px;">
													{!! Form::label('tipo_cama', '', ['class' => 'sr-only']) !!}
													{!! Form::select('tipo_cama', $tipo_cama, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una cama']) !!}
												</div>
											</div>
											<div class="col-md-1 col-xs-1 helpingClose">
												<a class="cerrarCama" title="Eliminar cama" data-repeater-delete>
													<i class="fa fa-times-circle" aria-hidden="true"></i>
												</a>
											</div>
										</div>
									</div>

									<div class="col-md-12 col-xs-12">
										<a class="addCama" title="Añadir cama" data-repeater-create>
											<i class="fa fa-plus-circle" aria-hidden="true"></i> <span>Añadir Cama</span>
										</a>
									</div>
								</div>

								<div class="col-md-4 col-xs-4">
									{!! Form::checkbox('tiene_banio', true, false, ['id' => 'tiene_banio','class' => 'tiene_banio']) !!}
									{!! Form::label('tiene_banio', __('propiedad_create.propiedad_habitacion_tiene_banio'), ['class' => 'banio']) !!}
								</div>
								<div class="col-md-4 col-xs-4">
									{!! Form::checkbox('tiene_tv', true, false, ['id' => 'tiene_tv']) !!}
									{!! Form::label('tiene_tv', __('propiedad_create.propiedad_habitacion_tiene_tv'), ['class' => '']) !!}
								</div>
								<div class="col-md-4 col-xs-4">
									{!! Form::checkbox('tiene_calefaccion', true, false, ['id' => 'tiene_calefaccion']) !!}
									{!! Form::label('tiene_calefaccion', __('propiedad_create.propiedad_habitacion_tiene_calefaccion'), ['class' => '']) !!}
								</div>
							</div>
						</div>
						<div class="col-md-7 col-xs-12">
							<div class="form-group">
								{!! Form::label('descripcion', '', ['class' => 'sr-only']) !!}
								{!! Form::textArea('descripcion', null, ['class' => 'form-control textarea_1', 'maxlength' => 255, 'rows' => 3, 'maxlength' => '140', 'placeholder' => __('propiedad_create.propiedad_habitacion_descripcion')]) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<button type="button" data-repeater-delete class="hide eliminar-habitacion">X</button>
		</div>
		<div class="col-md-3 col-xs-12">
			<input data-repeater-create type="button" class="hide anadiendoHab agregar-habitacion" value="Añadir Habitacion"/>
		</div>
	</div>
</div>

<div class="clearfix"></div>

@php

$distribucion_columnas_caracteristicas = [
	"cocina" => ['cantidad_grupos'=>4,'tamanio_grupos'=>4],
	"living_comedor" => ['cantidad_grupos'=>2,'tamanio_grupos'=>4],
	"exteriores" => ['cantidad_grupos'=>2,'tamanio_grupos'=>4],
	"servicios" => ['cantidad_grupos'=>3,'tamanio_grupos'=>4],
	"seguridad" => ['cantidad_grupos'=>2,'tamanio_grupos'=>4],
];


$definicion_caracteristica = [
	1 => 'Describir muy bien tu cocina, ¡es un gran plus! especifica todo lo que dispone, recuerda que cada característica es importante para tus potenciales huéspedes.',
	2 => 'Los huéspedes quieren conocer cada rincón de tu alojamiento, describe tu living comedor y todas las comodidades a disposición.',
	3 => 'El ambiente exterior de tu alojamiento atrae la atención de tus huéspedes, que no te falte nada por mencionar.',
	4 => '¡A todos nos gusta el wifi libre! Especifica los servicios disponibles en tu alojamiento y de existir restricciones detállalas en la descripción.',
	5 => 'Las indicaciones de seguridad son realmente importante. Facilita a tus usuarios lo necesario para cualquier contingencia.',
]

@endphp

@foreach ($gruposCaracteristicasPropiedades->chunk(2) as $grupos_caracteristica)
<div class="row">
	@foreach ($grupos_caracteristica as $grupo)
	<div class="col-md-6">
		<h5>{{ $grupo->descripcion }}</h5>
        <p class="txtPublish">{{ $definicion_caracteristica[$grupo->id] }}</p>

		<div class="row">
			@php
			
			$caracteristica = $grupo->etiqueta;
			$detalles = $grupo->caracteristicas;
			
			$cantidad_grupos = $distribucion_columnas_caracteristicas[$caracteristica]['cantidad_grupos'];
			$ancho_columna_md = ( 12 / $distribucion_columnas_caracteristicas[$caracteristica]['cantidad_grupos'] );
			$tamanio_grupos = $distribucion_columnas_caracteristicas[$caracteristica]['tamanio_grupos'];

			@endphp

			@foreach ($detalles->chunk($tamanio_grupos) as $grupo_elementos)
			<div class="col-md-{{$ancho_columna_md}} col-xs-6">
				@foreach ($grupo_elementos as $element)
				{!! Form::checkbox('caracteristica['.$element->id.']', $element->id, false, ['id' => $caracteristica.$element->id]) !!}
				{!! Form::label($caracteristica.$element->id, $element->descripcion) !!}
				@endforeach
			</div>
			@endforeach
			<div class="col-md-12 col-xs-12">
				{!! Form::textArea('descripcion_caracteristica['.$grupo->id.']', null, ['class' => 'textarea_1', 'maxlength' => '140', 'placeholder' => 'Describe este espacio']) !!}
			</div>
		</div>
	</div>
	@endforeach

	@if ($loop->last)
	<div class="col-md-6">
		<h5>@lang('propiedad_create.normas_h5')</h5>
		<p class="txtPublish">Señala a tus huéspedes cuales son tus normas, indicarlas claramente permitirá que conozcan cuales son tus restricciones.</p>
		@foreach ($normas as $norma)
		{!! Form::checkbox('normas[]', $norma->id, false, ['id' => 'norma'.$norma->id]) !!}
		{!! Form::label('norma'.$norma->id, $norma->descripcion) !!}
		@endforeach
		<div class="form-group">
			{!! Form::label('normas_adicionales', '', ['class' => 'sr-only']) !!}
			{!! Form::TextArea('normas_adicionales', null, ['class' => 'form-control textarea_1', 'maxlength' => 255, 'rows' => 3, 'placeholder' => __('propiedad_create.propiedad_normas_otras')]) !!}
		</div>
	</div>
	@endif
</div>
@endforeach