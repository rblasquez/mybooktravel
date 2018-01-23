<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformePagoReservaRequest extends FormRequest
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
            'fecha_pago'     => 'required|date',
            'monto'          => 'required|numeric',
            'bancos_id'      => 'required',
            'metodo_pagos_id'=> 'required',
            'num_operacion'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required'    => 'este campo es obligatorio',
        ];
    }
}
