<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\TipoPropiedad;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {

        //View::share('tipoAlojamientos', TipoPropiedad::pluck('descripcion', 'id'));
		
        Validator::extend('entero_positivo', function($attribute, $value, $parameters, $validator) {
            if( ctype_digit($value) && strlen($value) <= 10 && $value > 0 )
			{
                return true;
            }
			else 
			{
				return false;
			}
        });
        Validator::extend('monto_positivo', function($attribute, $value, $parameters, $validator) {
            if( is_numeric($value) && strlen($value) <= 10 && $value > 0 )
			{
                return true;
            }
			else 
			{
				return false;
			}
        });

        Validator::extend('existe_direccion', function ($attribute, $value, $parameters, $validator) {
            return $value;
        });
		
		Validator::extend('greater_than_time', function($attribute, $value, $parameters, $validator) {
			
			$min_field = $parameters[0];
			$data = $validator->getData();
			$min_value = $data[$min_field];
			return strtotime($value) > strtotime($min_value);
		  
		});  
		
		Validator::replacer('greater_than_time', function($message, $attribute, $rule, $parameters) {
		  return str_replace(':field', $parameters[0], $message);
		});
		
    }

    public function register()
    {

    }
}
