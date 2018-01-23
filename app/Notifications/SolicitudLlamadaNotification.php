<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class SolicitudLlamadaNotification extends Notification
{
    use Queueable;

    public $contacto;

    public function __construct($contacto)
    {
        return $this->contacto = $contacto;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('¡Hola, '.$this->contacto->nombre.'!')
                    ->line('Hemos recibido su solicitud de llamada')
                    ->line('Te llamaremos el dia ' . Carbon::parse($this->contacto->fecha)->format('d/m/Y'))
                    ->line('a las ' . $this->contacto->hora);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
