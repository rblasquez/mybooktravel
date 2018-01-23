<?php

use Illuminate\Database\Seeder;

class ReservasTableSeeder extends Seeder
{
    public function run()
    {
        $garantiaReservas = [
                ['descripcion' => '100% mbt', 'porcentaje_aceptado' => 100],
                ['descripcion' => '50% mbt - 50% mbt antes de 48hrs', 'porcentaje_aceptado' => 50],
                ['descripcion' => '50% mbt – 50% presencial', 'porcentaje_aceptado' => 50]
            ];


        $estatusReservas = [
            ['descripcion' => 'pre reserva', 'order' => 1, 'etiqueta' => 'pre_reserva', 'color' => 'label-warning'],
            ['descripcion' => 'Pago alertado', 'order' => 2, 'etiqueta' => 'pago_alertado', 'color' => 'label-info'],
            ['descripcion' => 'Validando pago', 'order' => 3, 'etiqueta' => 'validando_pago', 'color' => 'label-info'],
            ['descripcion' => 'Pago Rechazado', 'order' => 4, 'etiqueta' => 'reservada', 'color' => 'label-info'],
            ['descripcion' => 'Reservada', 'order' => 5, 'etiqueta' => 'pago_rechazado', 'color' => 'label-success'],
            ['descripcion' => 'Finalizada', 'order' => 6, 'etiqueta' => 'finalizada', 'color' => 'label-success'],
            ['descripcion' => 'Suspendida', 'order' => 7, 'etiqueta' => 'suspendida', 'color' => 'label-danger'],
            ['descripcion' => 'Pendiente de Registro', 'order' => 8, 'etiqueta' => 'pendiente_registro', 'color' => 'label-danger'],
            ['descripcion' => 'Pago parcial', 'order' => 9, 'etiqueta' => 'pago_parcial', 'color' => 'label-warning'],
        ];

        $reservas = [
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '210000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '2'],
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '210000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '2'],
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '182000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '5'],
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '182000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '5'],
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '182000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '5'],
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '182000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '5'],
            ['fecha_entrada' => '2017-05-02', 'fecha_salida' => '2017-05-09', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '210000', 'estatus_reservas_id' => '1', 'dias_estadia' => '7', 'created_at' => '2017-05-02', 'usuarios_id' => '1', 'propiedades_id' => '2'],
            ['fecha_entrada' => '2017-06-03', 'fecha_salida' => '2017-06-04', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '140000', 'estatus_reservas_id' => '1', 'dias_estadia' => '2', 'created_at' => '2017-06-03', 'usuarios_id' => '1', 'propiedades_id' => '7'],
            ['fecha_entrada' => '2017-06-05', 'fecha_salida' => '2017-06-07', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '140000', 'estatus_reservas_id' => '1', 'dias_estadia' => '3', 'created_at' => '2017-06-05', 'usuarios_id' => '1', 'propiedades_id' => '7'],
            ['fecha_entrada' => '2017-05-13', 'fecha_salida' => '2017-06-15', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '140000', 'estatus_reservas_id' => '1', 'dias_estadia' => '3', 'created_at' => '2017-06-13', 'usuarios_id' => '1', 'propiedades_id' => '7'],
            ['fecha_entrada' => '2017-05-21', 'fecha_salida' => '2017-06-23', 'total_adultos' => '1', 'total_ninos' => '0', 'total_pago' => '140000', 'estatus_reservas_id' => '1', 'dias_estadia' => '3', 'created_at' => '2017-06-21', 'usuarios_id' => '1', 'propiedades_id' => '7'],
        ];

        foreach ($garantiaReservas as $key => $value) {
            DB::table('garantia_reservas')->insert([
                'descripcion'           => $value['descripcion'],
                'porcentaje_aceptado'   => $value['porcentaje_aceptado'],
            ]);
        }

        foreach ($estatusReservas as $key => $value) {
        	DB::table('estatus_reservas')->insert([
                    'descripcion'   => $value['descripcion'],
                    'order'         => $value['order'],
        			'etiqueta'       => $value['etiqueta'],
        			'color'          => $value['color'],
        		]);
        }

        /*

        foreach ($reservas as $key => $reserva) {
            DB::table('reservas')->insert([
                    'fecha_entrada'         => $reserva['fecha_entrada'],
                    'fecha_salida'          => $reserva['fecha_salida'],
                    'total_adultos'         => $reserva['total_adultos'],
                    'total_ninos'           => $reserva['total_ninos'],
                    'total_pago'            => $reserva['total_pago'],
                    'estatus_reservas_id'   => $reserva['estatus_reservas_id'],
                    'dias_estadia'          => $reserva['dias_estadia'],
                    'usuarios_id'           => $reserva['usuarios_id'],
                    'propiedad_id'          => $reserva['propiedades_id'],
                    'created_at'            => $reserva['created_at'],
                    'updated_at'            => $reserva['created_at'],
                ]);
        }

        */
    }
}
