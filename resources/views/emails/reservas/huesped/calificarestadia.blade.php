@component('mail::message')

Estimado: 
{{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }} 

Cuentanos como te fue en el alojamiento de

# {{ $reserva->propiedad->usuario->nombres }}, {{ $reserva->propiedad->usuario->apellidos }}

@component('mail::button', ['url' => 'https://mybooktravel.com/public'])
	Compartir Experiencia
@endcomponent

Gracias,<br>
{{ config('app.name') }}
	
@endcomponent
