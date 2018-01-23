<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Mail\RecuperarPassword as Mailable;

class UserResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Recuperacion de Contraseña')
        ->greeting('Hola!')
        ->line('Está recibiendo este correo electrónico porque recibimos una solicitud de reinicio de su contraseña para su cuenta.')
        ->action('Recuperar contraseña', route('password.reset', $this->token));

        /*
        return (new Mailable($this->token))->view('emails.usuarios.password.reset')->to($this->mail);
        */
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
