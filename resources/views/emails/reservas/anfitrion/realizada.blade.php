@component('mail::message')
Estimado: 
# {{ $reserva->propiedad->usuario->nombres }}, {{ $reserva->propiedad->usuario->apellidos }}
<br>
{{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }} te hizo una reserva

@component('mail::button', ['url' => ''])
Visualizar Reserva
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
