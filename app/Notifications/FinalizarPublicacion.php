<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FinalizarPublicacion extends Notification
{
    use Queueable;

    public $propiedad;

    public function __construct($propiedad)
    {
        return $this->propiedad = $propiedad;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Publicación realizada')
                    ->greeting('¡Hola, '.$this->propiedad->usuario->nombres.' '.$this->propiedad->usuario->apellidos.'!')
                    ->line('Has finalizado la publicación de tu propiedad.')
                    ->line('Puedes visualizarla en el siguiente enlace.')
                    ->action('Publicación', route('propiedad.detalle', $this->propiedad))
                    ->line('Gracias por utilizar nuestros servicios!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
