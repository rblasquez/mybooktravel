<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordsReset extends Model
{
    protected $table = 'password_resets';

    protected $fillable = ['email', 'token', 'created_at'];
    
    public $timestamps = false;

    protected $hidden = [
        'token',
    ];

    protected $dates = [
        'created_at',
    ];
    
    public function setTokenAttribute($value){
        if(!empty($value)){
            $this->attributes['token'] = \Hash::make($value);
        }
    }
}
