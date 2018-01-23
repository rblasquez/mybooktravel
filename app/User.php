<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";

    # protected $guarded = [];
    protected $fillable = [
        'nombres',
        'apellidos',
        'avatar',
        'password',
        'email',
        'telefono',
        'fecha_naci',
        'pais_id',
        'divisa',
        'direccion',
        'idiomas',
        'sexo',
        'descripcion',
        'imagen',
        'tipo_usuario',
        'estatus',
        'confirm_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function medio_cobro_transferencia()
    {
        return $this->hasMany('App\DUsuariosMetodosCobrosTransferencia', 'usuarios_id');
    }

    public function propiedades()
    {
        return $this->hasMany('App\Propiedad', 'usuarios_id');
    }

    public function reservas()
    {
        return $this->hasMany('App\Reserva', 'usuarios_id');
    }

    public function reservaManual()
    {
        return $this->hasMany('App\ReservaManual', 'usuarios_id');
    }

    public function imagenesTemporales()
    {
        return $this->hasMany('App\DImagenesTemporales', 'usuarios_id');
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = \Hash::make($value);
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function pais()
    {
        return $this->belongsTo('App\Pais', 'pais_id', 'id');
    }
}
