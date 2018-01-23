@extends('layouts.app')

@section('content')

<section class="container profileContent">
	<div class="row">
		@include('auth.partials.aside')
		<div class="col-md-9 col-xs-12 formPublicar_1 editaPerfil">
			<div class="row">
				<div class="col-md-12">
					<h1 class="h1">Edita tu perfil</h1>
				</div>
			</div>

			{!! Form::model(Auth::user(), ['route' => ['perfil.update', Auth::user()->id], 'method' => 'PUT', 'id' => 'frmDataUser']) !!}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('nombres', '', ['class' => 'sr-only']) !!}
						{!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('apellidos', '', ['class' => 'sr-only']) !!}
						{!! Form::text('apellidos', null, ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('fecha_naci', '', ['class' => 'sr-only']) !!}
						{!! Form::text('fecha_naci', Carbon\Carbon::parse(Auth::user()->fecha_naci)->format('d-m-Y') ?? null, ['class' => 'form-control', 'placeholder' => 'Fecha de nacimiento']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('sexo', '', ['class' => 'sr-only']) !!}
						{!! Form::select('sexo', ['masculino' => 'Masculino', 'femenino' => 'Femenino'], null, ['class' => 'form-control', 'placeholder' => 'Sexo']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('pais_id', '', ['class' => 'sr-only']) !!}
						{!! Form::select('pais_id', $paises, $pais ? $pais->iso2 : null, ['class' => 'form-control', 'placeholder' => 'Pais', 'maxlength'=>'20']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('email', '', ['class' => 'sr-only']) !!}
						{!! Form::email('email', null, ['class' => 'minusculas', 'placeholder' => 'E-mail']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('telefono', '', ['class' => 'sr-only']) !!}
						{!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Número de teléfono', 'maxlength'=>'20']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('idiomas', '', ['class' => 'sr-only']) !!}
						{!! Form::select('idiomas', ['es' => 'Español', 'en' => 'Ingles', 'pt-BR' => 'Portugues - Brasil'], null, ['class' => 'form-control', 'placeholder' => 'Idioma']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('direccion', '', ['class' => 'sr-only']) !!}
						{!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => '¿Donde Vives?', 'maxlength'=>'255']) !!}
						{{--
						{!! Form::label('pais_id', '', ['class' => 'sr-only']) !!}
						{!! Form::hidden('pais_id', null) !!}
						--}}
					</div>
					<div class="form-group">
						{!! Form::label('divisa', '', ['class' => 'sr-only']) !!}
						{!! Form::select('divisa', ['USD' => 'USD - Dolar Americano', 'CLP' => 'CLP - Pesos Chilenos', 'BRL' => 'Reales de Brasil', 'ARS' => 'Pesos Argentinos'], null, ['class' => 'form-control', 'placeholder' => 'Divisa']) !!}
					</div>
				</div>

				<div class="col-md-6">
					{!! Form::label('descripcion', '', ['class' => 'sr-only']) !!}
					{!! Form::textArea('descripcion', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Escribe un breve resumen de tí', 'maxlength'=>'255']) !!}
				</div>

				<div class="col-md-12">
					<div class="row">
						<div class="col-md-3 col-md-offset-6">
							<button type="submit">Actualizar</button>
						</div>
						<div class="col-md-3">
							<button type="button" class="cancelando" onclick="window.location.href='{{ route('perfil.index') }}'">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</section>

@endsection

@push('css')
<style>
.editaPerfil textarea {
	height: 136px;
	margin-top: 0;
}
.help-block.error-help-block {
	margin-top: -35px !important;
}
</style>
@endpush

@push('js')
{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
{!! JsValidator::formRequest('App\Http\Requests\EditUserRequest', '#frmDataUser'); !!}

<script>
	var ruta_pais = "{{ route('pais.info', ':PAIS') }}";
</script>

{!! Html::script('js/perfil-edit.js') !!}
@endpush