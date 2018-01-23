@extends('administracion.layouts.modulo')

@section('contenedor_modulo')

  <div class="container">

				@if($action == 'edit')
					{!! Form::model($modelo, ['route' => ['cupon_descuento.update', $modelo->id ], 'method' => 'patch', 'id' => 'form_d_cupon_descuento_create', 'callback' => "console.log(result,status)", 'modal_confirm' => '1', 'redirect_target' => 'index', 'success_callback' => 'alert(1)', 'ruta_index' => route("cupon_descuento.index") ]) !!}
				@else
					{!! Form::open(['route' => 'cupon_descuento.store', 'method' => 'post', 'id' => 'form_d_cupon_descuento_create', 'callback' => "console.log(result,status)", 'modal_confirm' => '1', 'redirect_target' => 'index', 'success_callback' => 'alert(1)', 'ruta_index' => route("cupon_descuento.index") ]) !!}
				@endif

        <div class="row">

          <div class="col-md-4">
            @include('administracion.cupon_descuento.partials.titulo')
          </div>

          <div class="col-md-8">
  					<div class="form-group">
  						{!!Form::label('descripcion', 'Descripción', ['class' => 'form-control-label'])!!}
  						{!!Form::text('descripcion', null, ['class'=>'form-control', 'placeholder'=>'Descripción'] )!!}
  					</div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('alcance_geografico', 'Alcance Geográfico', ['class' => 'form-control-label'])!!}
              {!!Form::text('alcance_geografico', null, ['class'=>'form-control buscador_rectangulo', 'placeholder'=>'Alcance Geográfico'] )!!}
            </div>
          </div>

          <div class="col-md-8">
            <div class="mapa_con_rectangulo" style='height:300px;'></div>
          </div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('n_modo_aplicacion_descuento_id', 'Modo Aplicación Descuento', ['class' => 'form-control-label'])!!}
  						{!!Form::select('n_modo_aplicacion_descuento_id', $modos_aplicacion_descuento, null, ['class' => 'form-control']) !!}
  					</div>
          </div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('valor', 'Valor', ['class' => 'form-control-label'])!!}
  						{!!Form::number('valor', null, ['class'=>'form-control entero_positivo', 'placeholder'=>'Valor'] )!!}
  					</div>
          </div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('moneda', 'Moneda', ['class' => 'form-control-label'])!!}
  						{!!Form::select('moneda', $monedas, null, ['class' => 'form-control']) !!}
  					</div>
          </div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'form-control-label'])!!}
  						{!!Form::text('fecha_inicio', null, ['class'=>'form-control calendario', 'placeholder'=>'Fecha Inicio'] )!!}
  					</div>
          </div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('fecha_fin', 'Fecha Fin', ['class' => 'form-control-label'])!!}
  						{!!Form::text('fecha_fin', null, ['class'=>'form-control calendario', 'placeholder'=>'Fecha Fin'] )!!}
  					</div>
          </div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('noches_minimas', 'Noches Mínimas', ['class' => 'form-control-label'])!!}
  						{!!Form::number('noches_minimas', null, ['class'=>'form-control entero_positivo', 'placeholder'=>'Noches Mínimas', 'min'=>'7', 'max'=>'30'] )!!}
            </div>
					</div>

          <div class="col-md-4">
  					<div class="form-group">
  						{!!Form::label('cantidad', 'Cantidad', ['class' => 'form-control-label'])!!}
  						{!!Form::number('cantidad', null, ['class'=>'form-control entero_positivo', 'placeholder'=>'Cantidad', 'min'=>'1', 'max'=>'50'] )!!}
  					</div>
          </div>

        </div>

        <div style='visibility:hidden;display:none;' >
          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('lat', 'lat', ['class' => 'form-control-label'])!!}
              {!!Form::text('lat', null, ['class'=>'form-control'] )!!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('lng', 'lng', ['class' => 'form-control-label'])!!}
              {!!Form::text('lng', null, ['class'=>'form-control'] )!!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('lat_max', 'lat_max', ['class' => 'form-control-label'])!!}
              {!!Form::text('lat_max', null, ['class'=>'form-control'] )!!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('lat_min', 'lat_min', ['class' => 'form-control-label'])!!}
              {!!Form::text('lat_min', null, ['class'=>'form-control'] )!!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('lng_max', 'lng_max', ['class' => 'form-control-label'])!!}
              {!!Form::text('lng_max', null, ['class'=>'form-control'] )!!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('lng_min', 'lng_min', ['class' => 'form-control-label'])!!}
              {!!Form::text('lng_min', null, ['class'=>'form-control'] )!!}
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>

				{!! Form::close() !!}

	</div>

@endsection

@push('js')

  <script>
    CuponDescuento.createAndEdit.start();
  </script>

  @if($action == 'edit' )
    {!! JsValidator::formRequest('App\Http\Requests\Administracion\UpdateCuponDescuentoRequest', '#form_d_cupon_descuento_create'); !!}
  @else
    {!! JsValidator::formRequest('App\Http\Requests\Administracion\StoreCuponDescuentoRequest', '#form_d_cupon_descuento_create'); !!}
  @endif
@endpush
