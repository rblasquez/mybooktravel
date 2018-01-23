@component('mail::message')
# Solicitud de Información

{{ $contacto->nombre }} nos ha escrito

"{{ $contacto->mensaje }}"

Numero de contacto: {{ $contacto->telefono }}

Whatsapp {{ $contacto->whatsapp ? 'Si' : 'No' }}

Correo del usuario: {{ $contacto->email }}
@endcomponent