<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropiedadActualizarResumenRequest extends FormRequest
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

		$data = $this->validationData();
		// print_r($data["checkin"]);

        return [
            'nombre' => 'required',
            'tipo_propiedades_id' => 'required',
            'descripcion' => 'required',
            'capacidad' => 'required',
            'nhabitaciones' => 'required|entero_positivo',
            'nbanios' => 'required|entero_positivo',
            'superficie' => 'required',
            'estacionamientos' => 'required',
            'checkin' => 'required|greater_than_time:checkout',
            // 'tipo_checkin' => 'required',
            'checkin_estricto' => 'required_if:tipo_checkin,estricto|greater_than_time:checkin',
            'checkout' => 'required',
        ];
    }

	public function messages()
	{
		return [
			"nbanios.required"=>"El campo Cantidad de Baños es obligatorio."
		];
	}
}
