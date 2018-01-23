<div>
	<h5>@lang('propiedad_create.fotos_h5', ['variable' => 'replacement'])</h5>

	<div class="row">
		<div class="imagenes-preview">
			@include('propiedades.partials.loadimage')
		</div>
	</div>


	<h5>@lang('propiedad_create.ubicacion_h5', ['variable' => 'replacement'])</h5>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('direccion', __('propiedad_create.propiedad_ubicacion_direccion'), ['class' => '']) !!}
				{!! Form::text('direccion', null, ['class' => 'form-control direccion', 'maxlength' => 100, 'placeholder' => __('propiedad_create.propiedad_ubicacion_direccion_placeholder')]) !!}
			</div>

			@include("layouts.partials.campos_adicionales_ubicacion")

			<div id="resultadoMapa" style="min-height: 250px; border-radius: none; width: 100%; margin-top: 30px; border: 1px solid #E6E7E8;"></div>
		</div>


		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('como_llegar', __('propiedad_create.propiedad_ubicacion_como_llegar'), ['class' => '']) !!}
				{!! Form::textArea('como_llegar', null, ['class' => 'form-control textarea_2', 'maxlength' => 255, 'placeholder' => 'Como Llegar a esta propiedad: “Por ejemplo: Desde el terminal puedes tomar las siguientes líneas de microbuses: 602, 307, 605 y 608, y solicita bajarte en la avenida concon reñaca una vez acá puedes llegar caminando 3 cuadras desde la avenida principal o en colectivo.”']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('zona_descripcion', __('propiedad_create.propiedad_ubicacion_zona_descripcion'), ['class' => '']) !!}
				{!! Form::textArea('zona_descripcion', null, ['class' => 'form-control textarea_2', 'maxlength' => 255, 'placeholder' => 'Redacta una breve descripción de la zona: “En este espacio te recomendamos escribir acerca de las características más atractivas del lugar en el que se encuentra tu propiedad. Por Ejemplo: “ Departamento ubicado en barrio central, con locomoción a la puerta, supermecados a menos de 5 minutos en auto, playa y dunas a 15 minutos caminando”.']) !!}
			</div>
		</div>
	</div>
	{{--
	<div class="row">
		<div class="col-md-12">
			<h6>@lang('propiedad_create.propiedad_ubicacion_lugares_h')</h6>
			<p>@lang('propiedad_create.propiedad_ubicacion_lugares_p')</p>
			<div class="lugares_cercanos">
				<div class="row">
					<div data-repeater-list="lugares_cercanos">
						<div data-repeater-item class="validar">
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('lugar', __('propiedad_create.propiedad_ubicacion_lugares_lugar'), ['class' => '']) !!}
									{!! Form::text('lugar', null, ['class' => 'form-control lugar', 'maxlength' => 45, 'placeholder' => 'Ej. Jumbo']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('distancia', __('propiedad_create.propiedad_ubicacion_lugares_distancia'), ['class' => '']) !!}
									{!! Form::number('distancia', null, ['class' => 'form-control distancia', 'placeholder' => 'Ej. 200 metros']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('caminando', __('propiedad_create.propiedad_ubicacion_lugares_caminando'), ['class' => '']) !!}
									{!! Form::text('caminando', null, ['class' => 'form-control caminando', 'placeholder' => 'Ej. 15 min']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-6">
								<div class="form-group">
									{!! Form::label('vehiculo', __('propiedad_create.propiedad_ubicacion_lugares_vehiculo'), ['class' => '']) !!}
									{!! Form::text('vehiculo', null, ['class' => 'form-control vehiculo', 'placeholder' => 'Ej. 15 min']) !!}
								</div>
							</div>
							<div class="col-md-2 col-xs-3  eliminarLugar">
								<a style="cursor: pointer;" data-repeater-delete>@lang('propiedad_create.propiedad_ubicacion_btn_eliminar')</a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="col-md-15">
					<button data-repeater-create type="button" class="anadiendoLug">@lang('propiedad_create.propiedad_ubicacion_btn_agregar')</button>
				</div>

			</div>
		</div>
	</div>
	--}}
</div>
