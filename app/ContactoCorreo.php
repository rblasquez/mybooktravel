<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ContactoCorreo extends Model
{
    use Notifiable;
    
    protected $table = 'contacto_correos';

    protected $guarded = [];
}
