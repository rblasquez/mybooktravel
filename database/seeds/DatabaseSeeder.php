<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(PaisesTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(MetodosPagosCobrosTableSeeder::class);
        $this->call(ReservasTableSeeder::class);
        $this->call(PropiedadesTableSeeder::class);
        $this->call(NormasTableSeeder::class);
        $this->call(MotivoBloqueoTableSeeder::class);
        $this->call(ParametrosTableSeeder::class);
    }
}
