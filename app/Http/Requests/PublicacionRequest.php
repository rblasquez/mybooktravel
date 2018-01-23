<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoria_id'  => 'required',
            'titulo'        => 'required',
            'descripcion'   => 'required',
            'pais_id'       => 'required',
            'region_id'     => 'required',
            'provincia_id'  => 'required',
            'ubicacion'     => 'required',
            'telefono'      => 'required',
            'email'         => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            '*.required'    => 'este campo es obligatorio',
        ];
    }
}
