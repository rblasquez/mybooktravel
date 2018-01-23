<?php

use Illuminate\Database\Seeder;

class MotivoBloqueoTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('n_motivo_bloqueo')->insert([
			'descripcion'       => 'Reserva',
			'siglas'       => 'reserva',
			'color'       => '#0FD8A8',
        ]);
        
        DB::table('n_motivo_bloqueo')->insert([
            'descripcion'       => 'Bloqueo',
            'siglas'       => 'bloqueo',
            'color'       => '#BCBEC0',
        ]);
    }
}
