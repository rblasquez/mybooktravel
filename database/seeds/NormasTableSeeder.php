<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NormasTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
        ['descripcion' => 'No furmar'],
        ['descripcion' => 'No fiestas'],
        ['descripcion' => 'No Mascotas'],
        ['descripcion' => 'Calefactores Eléctricos'],
        // ['descripcion' => 'Se prohiben los ruidos molestos', 'tipo'=>'predeterminada'],
        // ['descripcion' => 'No se permiten mascotas','tipo'=>'predeterminada'],
        // ['descripcion' => 'No se permite fumar','tipo'=>'predeterminada'],
        // ['descripcion' => 'No se permiten fiestas o eventos','tipo'=>'predeterminada'],
        // ['descripcion' => 'No traer electrodomesticos de alto consumo', 'tipo'=>'predeterminada'],
        ];

        foreach ($data as $key => $value) {
            DB::table('n_normas')->insert([
                'descripcion' => $value['descripcion'],
                ]);
        }
    }
}
