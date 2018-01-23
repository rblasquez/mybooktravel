@component('mail::message')

Estimado: 
{{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }} 
<br>
# {{ $reserva->propiedad->usuario->nombres }}, {{ $reserva->propiedad->usuario->apellidos }}
Ha confirmado tu reserva

@component('mail::button', ['url' => ''])
	Pagar Reserva
@endcomponent

Gracias,<br>
{{ config('app.name') }}
	
@endcomponent
