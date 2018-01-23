@php
    $propiedad  = $reserva->propiedad;
    $anfitrion  = $reserva->propiedad->usuario;
    $huesped    = $reserva->usuario;

    $fecha = new App\Http\Controllers\FechasController;

@endphp
<h3>Solicitud de reserva realizada</h3>

<hr>
<h4>Datos del huesped</h4>
<p>Huesped: <strong>{{ $huesped->nombres }} {{ $huesped->apellidos }}</strong></p>
<p>Telefono: <strong>{{ $huesped->telefono }}</strong></p>
<p>Email: <strong>{{ $huesped->email }}</strong></p>

<br>
<br>
<br>

<hr>
<h4>Datos de la reserva</h4>
<p>Fecha de entrada: <strong>{{ $fecha->formatoFechaHora($reserva->fecha_entrada, $propiedad->detalles->checkin)->format('d/m/Y h:i a') }}</strong> </p>
<p>Fecha de salida: <strong>{{ $fecha->formatoFechaHora($reserva->fecha_salida, $propiedad->detalles->checkout)->format('d/m/Y h:i a') }}</strong> </p>
<p>Noches de estadia: <strong>{{ $reserva->dias_estadia }}</strong></p>
<p>Para : <strong>{{ $reserva->total_adultos }} personas</strong></p>

<br>
<br>
<br>

<hr>
<h4>Datos del propietario</h4>
<p>Anfitrión: <strong>{{ $anfitrion->nombres }} {{ $anfitrion->apellidos }}</strong></p>
<p>Telefono: <strong>{{ $anfitrion->telefono }}</strong> </p>
<p>Email: <strong>{{ $anfitrion->email }}</strong> </p>

<br>
<br>
<br>
<a href="{{ route('propiedad.detalle', $propiedad->id) }}">
    Ver publicación
</a>
