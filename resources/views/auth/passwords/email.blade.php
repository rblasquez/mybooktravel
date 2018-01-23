@extends('layouts.app')

@section('content')
<section class="container profileContent">
	<div class="col-md-4 col-md-offset-4 col-sm-offset-2 col-sm-8 login">
		{!! Form::open(['route' => 'password.email', 'autocomplete' => 'off', 'id' => 'resetPassword']) !!}
		<div class="row">
			<h1 class="h1Sena">Recupera tu contraseña</h1>
			<p class="txtSena">Escribe tu email a continuación y recibirás el link de recuperación.</p>

			<div class="form-group">
				{!! Form::label('email', '', ['class' => 'sr-only']) !!}
				{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
			</div>
		</div>
		<div class="row loginChiquis">
			<button type="submit">Enviar</button>
		</div>
		{!! Form::close() !!}
	</div>
</section>
@endsection

@push('js')
{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
{!! JsValidator::formRequest('App\Http\Requests\RecuperarContraseniaRequest', '#resetPassword'); !!}
@endpush