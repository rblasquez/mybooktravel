<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecuperarContraseniaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|exists:usuarios|email'
        ];
    }

    public function messages()
    {
        return [
            '*.required'    => 'Debes llenar este campo',
            '*.email'       => 'Este no es un email valido',
        ];
    }
}
