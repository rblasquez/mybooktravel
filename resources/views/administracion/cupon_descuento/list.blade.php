<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Título</th>
			<th>Descipción</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tbody>
		@foreach($modelos as $modelo)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{$modelo->titulo}}</td>
				<td>{{$modelo->descripcion}}</td>
				<td>
					<a href="{{route('cupon_descuento.show',['id'=>$modelo->id])}}" class="btn btn-primary">Ver</a>
					<!--<a href="{{route('cupon_descuento.edit',['id'=>$modelo->id])}}" class="btn btn-primary">Editar</a>-->
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
