<?php

use Illuminate\Database\Seeder;

class AdministracionNEstatusCuponDescuentoTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('n_estatus_cupon_descuento')->insert([
      'descripcion' => 'Vigente'
    ]);
    DB::table('n_estatus_cupon_descuento')->insert([
      'descripcion' => 'Vencido'
    ]);
    DB::table('n_estatus_cupon_descuento')->insert([
      'descripcion' => 'Usado'
    ]);
  }
}
