<?php

namespace App\Http\Requests\Administracion;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuponDescuentoRequest extends FormRequest
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
          'titulo' => 'required',
          'descripcion' => 'required',
          'titulo' => 'required|unique:d_campania_cupon_descuento',
          'alcance_geografico' => 'required',
          'moneda' => 'required',
          'n_modo_aplicacion_descuento_id' => 'required',
          'valor' => 'required',
          'fecha_inicio' => 'required',
          'fecha_fin' => 'required',
          'noches_minimas' => 'required',
          'cantidad' => 'required',
          'lat' => 'required',
          'lng' => 'required',
          'lat_max' => 'required',
          'lat_min' => 'required',
          'lng_max' => 'required',
          'lng_min' => 'required',
        ];
    }
}
