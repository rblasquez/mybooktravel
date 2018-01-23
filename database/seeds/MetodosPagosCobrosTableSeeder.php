<?php

use Illuminate\Database\Seeder;

class MetodosPagosCobrosTableSeeder extends Seeder
{
    public function run()
    {
        $metodosPagos = [
            ['descripcion' => 'Tarjeta de credito o Red compra', 'view' => 'webpay','estatus' => 1],
            ['descripcion' => 'PayPal', 'view' => 'paypal','estatus' => 0],
        	['descripcion' => 'Transferencia', 'view' => 'transferencia','estatus' => 1],
        	# ['descripcion' => 'Deposito', 'view' => 'deposito','estatus' => 1],
        	['descripcion' => 'Wester Union','view' => 'western', 'estatus' => 1],
        ];

        $metodosCobro = [
            ['descripcion' => 'Transferencia', 'estatus' => 1],
            ['descripcion' => 'Wester Union', 'estatus' => 1],
        ];

        foreach ($metodosPagos as $key => $value) {
        	DB::table('metodos_pagos')->insert([
        			'descripcion' => $value['descripcion'],
                    'estatus' => $value['estatus'],
        			'view' => $value['view']
        		]);
        }

        foreach ($metodosCobro as $key => $value) {
            DB::table('metodos_cobros')->insert([
                    'descripcion' => $value['descripcion'],
                    'estatus' => $value['estatus']
                ]);
        }
    }
}
