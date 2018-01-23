<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Este campo es obligatorio',
            '*.email'
        ];
    }
}
