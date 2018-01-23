@php
use Carbon\Carbon;
@endphp

Nombres: {{$reserva->usuario->nombres}}<br>
Apellidos: {{$reserva->usuario->apellidos}}<br>
Fecha Inicio: {{ Carbon::parse( $reserva->fecha_entrada )->format('Y-m-d H:i:s') }}<br>
Fecha Fin: {{ Carbon::parse( $reserva->fecha_salida )->format('Y-m-d H:i:s') }}<br>
Teléfono:{{$reserva->usuario->telefono}} <br>
Email: {{$reserva->usuario->email}} <br>
Precio :   {{$reserva->precio_base}} <br>
Costos Adicionales: {{$reserva->gastos_limpieza}}<br>
Noches: {{$reserva->dias_estadia}}<br>
Monto Total:  {{$reserva->total_pago}} <br>
{{--
Monto Anticipo: ?<br>
Monto Deuda Actual: ?
--}}