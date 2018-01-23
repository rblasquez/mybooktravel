<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoTelefonoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'        => 'required',
            'email'         => 'required|email',
            'telefono'      => 'required',
            'pais'          => 'required',
            'fecha'         => 'required',
            'hora'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required'    => 'Complete este campo',
            '*.email'       => 'Formato de correo invalido'
        ];
    }
}
