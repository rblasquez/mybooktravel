@extends('administracion.layouts.card')

@section('titulo', $titulo ?? 'Detalles' )

@section('contenido')
	<table class='table table-hover table-bordered'>
		<thead>
			<tr>
				<th>Campo</th>
				<th>Información</th>
			</tr>
		</thead>
		@yield('detalles')
	</table>
@endsection
