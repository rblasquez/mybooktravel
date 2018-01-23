@extends('layouts.app')


@section('content')
	<section class="container mbt_pt-20">


		<div class="col-md-6 col-md-offset-3 mbt_mt-20">
			<div class="panel panel-login">

				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-6 tabs">
							<a href="#" class="active" id="login-form-link">
								<div class="login">INGRESA</div>
							</a>
						</div>
						<div class="col-xs-6 tabs">
							<a href="#" id="register-form-link">
								<div class="register">REGISTRATE</div>
							</a>
						</div>
					</div>
				</div>

				<div class="panel-body">
					<div class="form-group mbt_mb-20">
						<div class="col-xs-4 text-left mbt_pr-5">

							<a href="{{ route('social.auth', 'google') }}" class="btn btn-block btn-social btn-google btn-fill">
								<i class="fa fa-google-plus" aria-hidden="true"></i> Google
							</a>
						</div>
						<div class="col-xs-4 mbt_p-0">

							<a href="{{ route('social.auth', 'facebook') }}" class="btn btn-block btn-social btn-facebook btn-fill">
								<i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook
							</a>
						</div>
						<div class="col-xs-4 text-right mbt_pl-5">

							<a href="{{ route('social.auth', 'twitter') }}" class="btn btn-block btn-social btn-twitter btn-fill">
								<i class="fa fa-twitter" aria-hidden="true"></i> Twitter
							</a>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="col-lg-12 mbt_mt-20">
						{!! Form::open(['route' => 'login.store', 'autocomplete' => 'off', 'class' => 'mbt_pt-20', 'id' => 'login-form', 'style' => 'display:block']) !!}
							<div class="form-group">
								{!! Form::label('email', '', ['class' => 'sr-only']) !!}
								{!! Form::text('email', null, ['class' => 'form-control minusculas', 'placeholder' => 'Email']) !!}
							</div>
							<div class="form-group mbt_mt-20">
								{!! Form::label('password', 'Clave', ['class' => 'sr-only']) !!}
								{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña']) !!}
							</div>
							<div class="form-group mbt_mt-20 mbt_mb-0">
								{!! Form::checkbox('conectado', true, false, ['id' => 'conectado']) !!}
								{!! Form::label('conectado', 'Mantenerme conectado', ['class' => 'mbt_p-0']) !!}
							</div>
							<div class="form-group mbt_mt-0 mbt_mb-20">
								{!! link_to_route('password.request', $title = '¿Olvidaste contraseña?', $parameters = [], $attributes = [])!!}
							</div>
							<div class="clearfix"></div>
							<div class="form-group mbt_mt-20 mbt_mb-20">
								{!! Form::submit('Ingresa', ['class' => 'btn btn-primary btn-block']) !!}
							</div>
						{!! Form::close() !!}

						{!! Form::open(['route' => 'registro.store', 'autocomplete' => 'off', 'class' => 'mbt_pt-20', 'id'=>'register-form', 'style' => 'display:none']) !!}
							<div class="form-group">
								{!! Form::label('nombres', '', ['class' => 'sr-only']) !!}
								{!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
							</div>
							<div class="form-group mbt_mt-20">
								{!! Form::label('apellidos', '', ['class' => 'sr-only']) !!}
								{!! Form::text('apellidos', null, ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
							</div>
							<div class="form-group mbt_mt-20">
								{!! Form::label('email', '', ['class' => 'sr-only']) !!}
								{!! Form::email('email', null, ['class' => 'form-control minusculas', 'placeholder' => 'Email']) !!}
							</div>
							<div class="form-group mbt_mt-20">
								{!! Form::label('pais_id', 'Pais', ['class' => 'sr-only']) !!}
								{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Pais']) !!}
							</div>
							<div class="form-group mbt_mt-20">
								{!! Form::label('telefono', '', ['class' => 'sr-only']) !!}
								{!! Form::tel('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono móvil']) !!}
							</div>

							<div class="form-group mbt_mt-20">
								{!! Form::label('password', 'Clave', ['class' => 'sr-only']) !!}
								{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña']) !!}
							</div>

							<div class="clearfix"></div>

							<div class="form-group mbt_mt-20 mbt_mb-0">
								{!! Form::checkbox('terminos', true, false, ['id' => 'terminos']) !!}
								<label for="terminos">Estoy de acuerdo con <a href="{{ route('informacion', 'terminos') }}" target="_blank">términos y condiciones</a>.</label>
							</div>

							<div class="form-group mbt_mt-0  mbt_mb-20">
								{!! Form::checkbox('novedades', true, false, ['id' => 'novedades']) !!}
								{!! Form::label('novedades', 'Deseo recibir novedades.') !!}
							</div>
							<div class="clearfix"></div>
							<div class="form-group mbt_mt-20  mbt_mb-20">
								{!! Form::submit('Registrate', ['class' => 'btn btn-primary btn-block']) !!}
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

@endsection

@push('css')
	<style>
		body {
			background: #f5f5f5;
			/*
			padding-top: 90px;
			background:#F7F7F7;
			color:#666666;
			font-family: 'Roboto', sans-serif;
			font-weight:100;


			width: 100%;
			background: -webkit-linear-gradient(left, #22d686, #24d3d3, #22d686, #24d3d3);
			background: linear-gradient(to right, #22d686, #24d3d3, #22d686, #24d3d3);
			background-size: 600% 100%;
			-webkit-animation: HeroBG 20s ease infinite;
			animation: HeroBG 20s ease infinite;
			*/
		}

		@-webkit-keyframes HeroBG {
			0% { background-position: 0 0; }
			50% { background-position: 100% 0; }
			100% { background-position: 0 0; }
		}

		@keyframes HeroBG {
			0% { background-position: 0 0; }
			50% { background-position: 100% 0; }
			100% { background-position: 0 0; }
		}

		.panel {
			border-radius: 5px;
		}


		.panel-login {
			border:none;
			border: 1px solid #ddd;
			/*
			-webkit-box-shadow: 0px 0px 3px rgba(188,190,194,0.39);
			-moz-box-shadow: 0px 0px 3px rgba(188,190,194,0.39);
			*/
			box-shadow: 0px 0px 3px rgba(188,190,194,0.39);
		}
		/*
		.panel-login .checkbox input[type=checkbox]{
		margin-left: 0px;
	}
	.panel-login .checkbox label {
	padding-left: 25px;
	font-weight: 300;
	display: inline-block;
	position: relative;
}
.panel-login .checkbox {
padding-left: 20px;
}
.panel-login .checkbox label::before {
content: "";
display: inline-block;
position: absolute;
width: 17px;
height: 17px;
left: 0;
margin-left: 0px;
border: 1px solid #cccccc;
border-radius: 3px;
background-color: #fff;
-webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
-o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
}
.panel-login .checkbox label::after {
display: inline-block;
position: absolute;
width: 16px;
height: 16px;
left: 0;
top: 0;
margin-left: 0px;
padding-left: 3px;
padding-top: 1px;
font-size: 11px;
color: #555555;
}
.panel-login .checkbox input[type="checkbox"] {
opacity: 0;
}
.panel-login .checkbox input[type="checkbox"]:focus + label::before {
outline: thin dotted;
outline: 5px auto -webkit-focus-ring-color;
outline-offset: -2px;
}
.panel-login .checkbox input[type="checkbox"]:checked + label::after {
font-family: 'FontAwesome';
content: "\f00c";
}
*/

.btn .fa{
	color: #fff;
}
.panel-login>.panel-heading .tabs{
	padding: 0;
}
.panel-login h2{
	font-size: 20px;
	font-weight: 300;
	margin: 30px;
}
.panel-login>.panel-heading {
	color: #848c9d;
	background-color: #e8e9ec;
	border-color: #fff;
	text-align:center;
	border-bottom-left-radius: 0px;
	border-bottom-right-radius: 0px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	border-bottom: 0px;
	padding: 0px 15px;
}
.panel-login .form-group {
	/*padding: 0 30px;*/
}
.panel-login>.panel-heading .login {
	padding: 20px 30px;
	font-weight: 700;
	color: #0EC8DB;
	/*border-bottom-leftt-radius: 0px;*/
}
.panel-login>.panel-heading .register {
	padding: 20px 30px;
	/*background: #2d3b55;*/
	/*border-bottom-right-radius: 0px;*/
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: 300;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a#register-form-link {
	/*color: #fff;*/
	width: 100%;
}
.panel-login>.panel-heading a#login-form-link {
	width: 100%;
}

.panel-login>.panel-heading>.active>.login{
	color: red;
}

.panel-login input[type="text"],
.panel-login input[type="email"],
.panel-login input[type="tel"],
.panel-login input[type="password"],
.panel-login select{
	height: 45px;
	border: 0;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
	-webkit-box-shadow: none;
	box-shadow: none;
	border-bottom: 1px solid #e7e7e7;
	border-radius: 0px;
	padding: 6px 0px;
	margin: 0px;
}
/*
.panel-login input:hover,
.panel-login input:focus {
outline:none;
-webkit-box-shadow: none;
-moz-box-shadow: none;
box-shadow: none;
border-color: #ccc;
}
*/
.btn-login {
	background-color: #E8E9EC;
	outline: none;
	color: #2D3B55;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border: none;
	border-radius: 0px;
	box-shadow: none;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #2D3B55;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #E8E9EC;
	outline: none;
	color: #2D3B55;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border: none;
	border-radius: 0px;
	box-shadow: none;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #2D3B55;
}

</style>
@endpush

@push('js')
	{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
	{!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login-form'); !!}
	{!! JsValidator::formRequest('App\Http\Requests\RegisterUserRequest', '#register-form'); !!}

	<script>
		var ruta_paises_info = '{{ route('pais.info', ':ID') }}'

		$(function() {
			$('#login-form-link').click(function(e) {
				$("#login-form").delay(100).fadeIn(100);
				$("#register-form").fadeOut(100);
				$('#register-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
			$('#register-form-link').click(function(e) {
				$("#register-form").delay(100).fadeIn(100);
				$("#login-form").fadeOut(100);
				$('#login-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});

		});
	</script>
@endpush
