<?php

use Illuminate\Database\Seeder;

class AdministracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdministracionNModoAplicacionDescuentoTableSeeder::class);
        $this->call(AdministracionNEstatusCuponDescuentoTableSeeder::class);

    }
}
