@extends('layouts.app')

@section('content')


<section class="container profileContent">
	<div class="col-md-4 col-md-offset-4 col-sm-offset-2 col-sm-8 login">
		{!! Form::open(['route' => 'password.request', 'method' => 'POST']) !!}
		<div class="row">
			<h1 class="h1Sena">Recuperación de contraseña</h1>
			<p class="txtSena">Indica tu email y tu nueva contraseña.</p>
			{!! Form::hidden('token', $token) !!}

					<div class="form-group">
						{!! Form::label('email', 'Correo electrónico', ['class' => 'sr-only']) !!}
						{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Correo electrónico']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('password', 'Contraseña', ['class' => 'sr-only']) !!}
						{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nueva contraseña']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('password-confirm', 'Confirmar contraseña', ['class' => 'sr-only']) !!}
						{!! Form::password('password-confirm', ['class' => 'form-control', 'placeholder' => 'Repetir contraseña']) !!}
					</div>
		</div>
		<div class="row loginChiquis">
			<button type="submit">Guardar nueva contraseña</button>
		</div>
		{!! Form::close() !!}
	</div>
</section>
@endsection

