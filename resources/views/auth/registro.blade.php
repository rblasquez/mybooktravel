@extends('layouts.app')

@section('content')
<section class="container">

	<div class="row">
		<div class="col-md-8 col-md-offset-2 login">

			<h1>Regístrate</h1>
			<div class="row">
				{!! Form::open(['route' => 'registro.store', 'class' => '', 'autocomplete' => 'off', 'id'=>'frmRegister']) !!}
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
						{!! Form::label('email', '', ['class' => 'sr-only']) !!}
						{!! Form::email('email', null, ['class' => 'form-control minusculas', 'placeholder' => 'Email']) !!}
					</div>
				</div>

				<div class="col-md-6 regSelect">
					<div class="form-group">
						{!! Form::label('pais_id', 'Pais', ['class' => 'sr-only']) !!}
						{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Pais']) !!}
					</div>
				</div>
				<div class="col-md-6 regSelect">
					<div class="form-group">
						{!! Form::label('telefono', '', ['class' => 'sr-only']) !!}
						{!! Form::tel('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono móvil']) !!}
					</div>
				</div>
				<div class="col-md-6 regSelect">
					<div class="form-group">
						{!! Form::label('password', 'Clave', ['class' => 'sr-only']) !!}
						{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña']) !!}
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 loginChiquis mr">
						<div class="col-md-6">
							{!! Form::checkbox('terminos', true, false, ['id' => 'terminos']) !!}
							<label for="terminos">Estoy de acuerdo con <a href="{{ route('informacion', 'terminos') }}" target="_blank">términos y condiciones</a>.</label>
						</div>
						<div class="col-md-6">
							{!! Form::checkbox('novedades', true, false, ['id' => 'novedades']) !!}
							{!! Form::label('novedades', 'Deseo recibir novedades.') !!}
						</div>
					</div>
				</div>

				<div class="col-md-6 col-md-offset-6">
					<button type="submit">Regístrate</button>
				</div>
				{!! Form::close() !!}
			</div>

			<div class="row dontya">
				<div class="col-md-12">
					<p>
						<a href="{{ route('login.index') }}">¿Ya tienes una cuenta?</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push("head")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('js')
{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
{!! JsValidator::formRequest('App\Http\Requests\RegisterUserRequest', '#frmRegister'); !!}
<script>
	var ruta_paises_info = '{{ route('pais.info', ':ID') }}'


	/*
	$('#frmRegister').on('submit', function(event) {
		event.preventDefault();

	});
	*/
</script>
{!! Html::script('js/register.js') !!}
@endpush
