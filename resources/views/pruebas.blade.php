@extends('layouts.app')

@section('content')

	<section class="container">


<h1>Hola Adrian villasmil, espero que estes bien... De parte de mybooktravel te damos la bienvenida y te invitamos a llenar el siguiente formulario para que podamos conseguir el mejor hospedaje para tus vacaciones<span>&nbsp;</span></h1>
		<a class="btn btn-primary" href="{{ route('social.auth', 'facebook') }}">
			Facebook
		</a>

	</section>

@endsection

@push('css')
	<style media="screen">
	h1{
		position:relative;
		float:left;
	}

	@keyframes escribiendo{
		from{width:100%}
		to{width:0}
	}

	@-webkit-keyframes escribiendo{
		from{width:100%}
		to{width:0}
	}

	@-moz-keyframes escribiendo {
		from{width:100%}
		to{width:0}
	}
	h1 span{
		position:absolute;
		top:0;
		right:0;
		width:0;
		background-color:#fff;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		animation: escribiendo 17s steps(200, end);
		/*-webkit-animation: escribiendo 5s steps(36, end);
		-moz-animation: escribiendo 5s steps(36, end);
	}
	</style>
@endpush
