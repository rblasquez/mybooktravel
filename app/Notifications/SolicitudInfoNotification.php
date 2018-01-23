<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SolicitudInfoNotification extends Notification
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
                    ->line('Gracias por escribirnos, hemos recibido tu mensaje.')
                    ->line('Te responderemos a la brevedad posible!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
