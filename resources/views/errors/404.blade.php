@extends('layouts.app')

@section('content')
<section class="container">
	<div class="row">
		<div class="col-md-5">
			<img class="b-lazy img-responsive"
			src=""
			data-src="{{ asset('img/ups.gif') }}"
			alt="alt-text"
			/>
		</div>
		<div class="col-md-7">
			<h2 style="border-bottom: 2px solid #0ec8db; margin-bottom: 15px; padding-bottom: 5px;">Algo ha salido mal</h2>
			<p>Quizas la página que estas buscando no existe, o ha ocurrido un error en nuestro servidor.</p>
			<p style="font-size: 20px;"><a href="javascript:history.go(-1)">&laquo; Ir atras</a> / <a href="{{ url('/') }}">Ir al inicio &raquo;</a></p>
		</div>
	</div>
</section>

@endsection
