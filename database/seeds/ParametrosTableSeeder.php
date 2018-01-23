<?php

use Illuminate\Database\Seeder;

class ParametrosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('parametros')->insert([
			'atributo'       => 'PorcentajePublicacion',
			'valor'     => 7,
			'descripcion'         => '',
            'deleted_at'    => date("Y-m-d H:i:s"),
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]);
        DB::table('parametros')->insert([
			'atributo'       => 'PorcentajeReserva',
			'valor'     => 10,
			'descripcion'         => '',
            'deleted_at'    => date("Y-m-d H:i:s"),
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]);
        
    }
}
