<?php

use Illuminate\Database\Seeder;

class AdministracionNModoAplicacionDescuentoTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('n_modo_aplicacion_descuento')->insert([
      'descripcion' => 'Monto Fijo'
    ]);
    DB::table('n_modo_aplicacion_descuento')->insert([
      'descripcion' => 'Porcentaje'
    ]);
  }
}
