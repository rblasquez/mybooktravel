<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'             => 'required|unique:usuarios,email|email',
            'nombres'           => 'required',
            'apellidos'         => 'required',
            'pais_id'           => 'required',
            'telefono'          => 'required',
            'password'          => 'required|min:8',
            'terminos'          => 'required'
        ];
    }

    public function messages()
    {
        return [
            '*.required'    => 'este campo es obligatorio',
        ];
    }
}
