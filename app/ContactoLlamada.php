<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ContactoLlamada extends Model
{
    use Notifiable;
    
    protected $table = 'contacto_llamadas';

    protected $guarded = [];
}
