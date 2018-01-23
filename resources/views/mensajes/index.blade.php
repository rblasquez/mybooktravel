@extends('layouts.app')

@section('content')
<section class="container profileContent">
	<div class="row">
		
		@include('auth.partials.aside')
		
		<div class="col-md-9 col-xs-12 col-sm-8 formPublicar_1">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h1 class="h1">Mensajes</h1>
				</div>
			</div>
			<div class="row">

				<div class="col-md-12 col-xs-12 alojamientos">

					<p class="house text-right">Casa en Valaparíso</p>
					<p class="huesped">Rodrigo Bustos García</p>

					<div class="col-md-12 el">
						<div class="row">
							<div class="col-md-1 col-xs-2">
								<figure>
									<a href="publicacion.php"><img src="img/guy.jpg" class="img-circle"></a>
								</figure>
							</div>
							<div class="col-md-11 col-xs-10">
								Hola, amigo, cómo estás?, quiero información sobre la cabaña.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 messdate">12 de Julio de 1990</div>
					</div>

					<div class="col-md-12 text-right yo">
						<div class="row">

							<div class="col-md-11 col-xs-10">
								Sí, por supuesto, cuesta 2.000.000 la 1/2 noche.
							</div>
							<div class="col-md-1 col-xs-2">
								<figure>
									<a href="publicacion.php"><img src="img/guy.jpg" class="img-circle"></a>
								</figure>
							</div>
						</div>
					</div>

					<div class="col-md-12 yo text-right">
						<div class="row">
							<div class="col-md-11 col-xs-10">
								Sí, por supuesto, cuesta 2.000.000 la 1/2 noche.
							</div>
							<div class="col-md-1 col-xs-2">
								<figure>
									<a href="publicacion.php"><img src="img/guy.jpg" class="img-circle"></a>
								</figure>
							</div>
						</div>
					</div>

					<div class="col-md-12 respondiendo">
						<div class="row">
							<div class="col-md-10 col-xs-9">
								<textarea>Escribe aquí tu respuesta</textarea>
							</div> 
							<div class="col-md-2 col-xs-3">
								<button>Enviar</button>
							</div>
						</div>
					</div>
				</div>
			</div>



		</div>

	</div>
</section>

@endsection