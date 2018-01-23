<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FinalizarRegistro extends Notification
{
    use Queueable;

    public $usuario;

    public function __construct($usuario)
    {
        return $this->usuario = $usuario;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('¡Hola, '.$this->usuario->nombres.' '.$this->usuario->apellidos.'!')
                    ->line('Estás a solo un paso de activar tu cuenta, verifica tu correo.')
                    ->line('haz clic en el botón de enlace y conoce la nueva forma de publicar o buscar hospedajes en el destino que deseas.')
                    ->action('Confirmar', route('finalizar', [$this->usuario->id, csrf_token()]))
                    ->line('Gracias por unirse a nuestra gran comunidad!');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
