<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaPagoTrasnferenciaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'                => 'required',
            'rut'                   => 'required',
            'banco'                 => 'required',
            'numero_transferencia'  => 'required|unique:d_pago_reservas_depositos,numero_transferencia',
            'bauche_img'            => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Este campo es obligatorio',
            'numero_transferencia.unique'   => 'Numero de transferencia ya ha sido registrado',
        ];
    }
}
