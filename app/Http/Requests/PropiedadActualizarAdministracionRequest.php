<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropiedadActualizarAdministracionRequest extends FormRequest
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
            'anfitrion'                     => 'required',
            'nombre_anfitrion'              => 'required_if:anfitrion,otro',
            'telefono_anfitrion'            => 'required_if:anfitrion,otro',
            'correo_anfitrion'              => 'email|required_if:anfitrion,otro',
            // 'precio' => 'required|monto_positivo',
            'noches_minimas'                => 'required|entero_positivo',
            'dias_intervalo'                => '',
            'oferta_propiedad_id'           => 'required',
            'garantia_reserva_id'           => 'required',
            'medio'                         => 'required',
            'aseo_unico'                    => 'required',
            'inf_pago.titular'              => 'required_if:medio,transferencia',
            'inf_pago.nro_cuenta'           => 'required_if:medio,transferencia',
            'inf_pago.tipo_cuenta'          => 'required_if:medio,transferencia',
            'inf_pago.banco'                => 'required_if:medio,transferencia',
            'inf_pago.email_beneficiario'   => 'required_if:medio,transferencia',
            'inf_pago.pais_id'              => 'required_if:medio,transferencia',
            'inf_pago.identificacion'       => 'required_if:medio,transferencia',
            'inf_pago.persona'              => 'required_if:medio,wu',
            'inf_pago.direccion'            => 'required_if:medio,wu',
        ];
    }

    public function messages()
    {
        return [
            "inf_pago.persona.required_if"=>"Debe indicar la persona que retira en Western Union.",
            "inf_pago.direccion.required_if"=>"Debe indicar direccion de retiro de Western Union.",
            "inf_pago.titular.required_if"=>"Debe indicar Titular de Transferencia.",
            "inf_pago.nro_cuenta.required_if"=>"Debe indicar Número Cuenta de Transferencia.",
            "inf_pago.tipo_cuenta.required_if"=>"Debe indicar Tipo de Cuenta de Transferencia.",
            "inf_pago.banco.required_if"=>"Debe indicar Banco de Transferencia.",
            "inf_pago.email_beneficiario.required_if"=>"Debe indicar Email de Transferencia.",
            "inf_pago.pais_id.required_if"=>"Debe indicar País de Transferencia.",
            "inf_pago.identificacion.required_if"=>"Debe indicar Identificación de Transferencia.",
        ];
    }
}
