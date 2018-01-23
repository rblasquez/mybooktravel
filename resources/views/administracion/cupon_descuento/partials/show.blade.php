@extends('administracion.layouts.show')

@section('detalles')
	<tr>
		<td>Título</td>
		<td>{{$modelo->titulo}}</td>
	</tr>
	<tr>
		<td>Descripción</td>
		<td>{{$modelo->descripcion}}</td>
	</tr>
	<tr>
		<td>Moneda</td>
		<td>{{$modelo->moneda}}</td>
	</tr>
	<tr>
		<td>Modo Aplicación Descuento</td>
		<td>{{$modelo->modoAplicacion->descripcion}}</td>
	</tr>
	<tr>
		<td>Valor</td>
		<td>{{$modelo->valor}}</td>
	</tr>
	<tr>
		<td>Vigencia</td>
		<td>{{$modelo->fecha_inicio_formato}} - {{$modelo->fecha_fin_formato}} </td>
	</tr>
	<tr>
		<td>Noches Mínimas</td>
		<td>{{$modelo->noches_minimas}}</td>
	</tr>
	<tr>
		<td>Creado</td>
		<td>{{$modelo->created_at}}</td>
	</tr>
	<tr>
		<td>Creador</td>
		<td>{{$modelo->usuario->nombres}} {{$modelo->usuario->apellidos	}}</td>
	</tr>
	<tr>
		<td colspan="2" >Área</td>
	</tr>
	<tr>
		<td colspan="2" >
			<div class="mapa_con_rectangulo" style='height:300px;'></div>
		</td>
	</tr>
	<tr>
		<td colspan='2' >

			<br>
			Cupones

			<table class='table' >
				<thead>
					<tr>
							<th>Código</th>
							<th>Estatus</th>
					</tr>
				<thead>

				<tbody>
					@foreach($modelo->cupones as $cupon)
					<tr>
						<td>{{$cupon->codigo}}</td>
						<td>{{$cupon->estatus->descripcion}}</td>
					<tr>
					@endforeach
				</tbody>
			</table>

		</td>
	</tr>

	@push('js')
		<script>
			CuponDescuento.show.start({!!$modelo->toJson()!!});
		</script>
	@endpush

@endsection
