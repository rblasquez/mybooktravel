@component('mail::message')

Estimado: 
{{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }} 
<br>
Debes esperar que
# {{ $reserva->propiedad->usuario->nombres }}, {{ $reserva->propiedad->usuario->apellidos }}
Confirme tu reserva

Gracias,<br>
{{ config('app.name') }}
	
@endcomponent
