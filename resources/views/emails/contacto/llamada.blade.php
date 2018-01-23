@component('mail::message')
# Solicitud de llamada

Una llamada ha sido agendada por {{ $contacto->nombre }}
el día {{ Carbon\Carbon::parse($contacto->fecha)->format('d/m/Y') }} a las {{ $contacto->hora }} Horas.

Numero de contacto: {{ $contacto->telefono }}

Correo del usuario: {{ $contacto->email }}


@endcomponent
