<h4>Publicación realizada</h4>
<p>Usuario: <strong>{{ $propiedad->usuario->nombres }} {{ $propiedad->usuario->apellidos }}</strong></p>
<p>Email: <strong>{{ $propiedad->usuario->email }}</strong></p>
<p>Telefono: <strong>{{ $propiedad->usuario->telefono }}</strong></p>

<br>
<br>
<br>
<a href="{{ route('propiedad.detalle', $propiedad->id) }}">
    Ver publicación
</a>
