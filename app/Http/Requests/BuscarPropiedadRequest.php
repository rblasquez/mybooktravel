<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuscarPropiedadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'destino'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'destino.required'    => 'Debes indicar a donde deseas ir.',
        ];
    }
}
