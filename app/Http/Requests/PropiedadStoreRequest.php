<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropiedadStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'                        => 'required',
            'tipo_propiedades_id'           => 'required',
            'descripcion'                   => 'required',

            'superficie'                    => 'numeric',
            'capacidad'                     => 'required|numeric',
            'nhabitaciones'                 => 'required|numeric|max:10',
            'nbanios'                       => 'required|numeric|max:10',
            'estacionamientos'              => 'required|numeric|max:10',
            'checkin'                       => 'required',
            'checkin_estricto'              => 'filled',
            
            # 'checkin'                       => 'required|greater_than_time:checkout',
            # 'checkin_estricto'              => 'filled|greater_than_time:checkin',
            'checkout'                      => 'required',
            
            'direccion'                     => 'required',
            'como_llegar'                   => 'required',
            
            'nombre_anfitrion'              => 'filled',
            'telefono_anfitrion'            => 'filled',
            'correo_anfitrion'              => 'filled|email',
            
            'precio'                        => 'required',
            'noches_minimas'                => 'required|numeric',
            'dias_intervalo'                => 'numeric',

            'inf_pago[titular]'             => 'filled',
            'inf_pago[tipo_cuenta]'         => 'filled',
            'inf_pago[email_beneficiario]'  => 'filled|email',
            'inf_pago[identificacion]'      => 'filled',
            'inf_pago[nro_cuenta]'          => 'filled|numeric',
            'inf_pago[banco]'               => 'filled',
            'inf_pago[pais_id]'             => 'filled',

            'inf_pago[persona]'             => 'filled',
            'inf_pago[direccion]'           => 'filled',
            'medio'                         => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required'                    => 'Completa este campo para continuar',
            '*.filled'                      => 'Completa este campo para continuar',
            '*.max'                         => 'No puede indicar mas de 10.',
            '*.numeric'                     => 'Este campo solo puede contener números',
            '*.email'                       => 'Formato de correo no valido',
        ];
    }
}
