<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoEmailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'        => 'required',
            'email'         => 'required|email',
            'telefono'      => 'required',
            'pais'          => 'required',
            'mensaje'       => 'required',
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
