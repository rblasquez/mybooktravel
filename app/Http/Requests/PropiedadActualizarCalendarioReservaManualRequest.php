<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropiedadActualizarCalendarioReservaManualRequest extends FormRequest
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
            'fecha_inicio_formato' => 'required',
            'fecha_fin_formato' => 'required',
            'descripcion' => 'required',
            'motivo' => 'required',
            'nombres' => 'required_if:motivo,reserva',
            'apellidos' => 'required_if:motivo,reserva',
            'telefono' => 'required_if:motivo,reserva|string|size:11',
            'precio' => 'required_if:motivo,reserva|min:1',
            'costos_adicionales' => 'required_if:motivo,reserva|min:1',
            'noches' => 'required_if:motivo,reserva',
            'monto_total' => 'required_if:motivo,reserva',
            'monto_anticipo' => 'required_if:motivo,reserva',
            'monto_deuda_actual' => 'required_if:motivo,reserva',
            'paises_id' => 'required_if:motivo,reserva',
            'ciudad' => 'required_if:motivo,reserva',
            // 'comprobante' => 'required_if:motivo,reserva',
            'email' => 'required_if:comprobante,on|email',
        ];
    }
}
