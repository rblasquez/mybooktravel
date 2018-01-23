<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->insert([
			'nombres'       => 'Rosmar',
			'apellidos'     => 'Blasquez',
			'email'         => 'reblasquez@gmail.com',
            'pais_id'       => 41,
			'password'      => bcrypt('123456789'),
            'telefono'      => '(+56) 973572671',
			'tipo_usuario'  => 'C',
            'estatus'  => '1',
            'created_at'    => '2017-05-17 13:35:45',
            'updated_at'    => '2017-05-17 13:35:45',
        ]);
        
        DB::table('usuarios')->insert([
            'nombres'       => 'Juan Carlos',
            'apellidos'     => 'Estrada Nieto',
            'email'         => 'juancarlosestradanieto@gmail.com',
            'pais_id'       => 41,
            'password'      => bcrypt('18977647'),
            'telefono'      => null,
            'tipo_usuario'  => 'C',
            'estatus'  => '1',
            'created_at'    => '2017-05-17 13:35:45',
            'updated_at'    => '2017-05-17 13:35:45',
        ]);
    }
}
