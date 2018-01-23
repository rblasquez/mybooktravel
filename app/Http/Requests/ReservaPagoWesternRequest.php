<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaPagoWesternRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mtcn'          => 'required|unique:d_pago_reservas_western_union,mtcn',
            'remitente'     => 'required',
            'bauche_img'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required'    => 'Debes completar este campo.',
            'mtcn.unique'   => 'MTCN ya ha sido registrado',
        ];
    }
}
