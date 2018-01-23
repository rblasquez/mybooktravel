<?php

use Illuminate\Database\Seeder;

class PropiedadesTableSeeder extends Seeder
{
    public function run()
    {
        $tipoPropiedades = ['Casa', 'Departamento', 'Apartahotel', 'Cabañas', 'Hostal', 'Habitaciones', 'Lodge'];
        $estatusPropiedades = ['Publicada' ,'En Revisión' ,'Suspendida Temporal' ,'Suspendida' ,'Eliminada por usuario' ,'Remodelacion'];
        $conceptosCobros = ['Desayuno', 'Almuerzo', 'Cena', 'Mucama / Aseo diario', 'Garantia', 'Lavanderia'];
        $tipo_oferta = ['Turista', 'Temporada alta', 'Mixto'];
		
		$gruposCaracateristicasPropiedades = [
			["descripcion"=>"Cocina", "etiqueta"=>"cocina"],
			["descripcion"=>"Living Comedor", "etiqueta"=>"living_comedor"],
			["descripcion"=>"Exteriores", "etiqueta"=>"exteriores"],
			["descripcion"=>"Servicios", "etiqueta"=>"servicios"],
			["descripcion"=>"Seguridad", "etiqueta"=>"seguridad"],
		];

        $caracteristicasPropiedades = [
		
            ['descripcion' => 'Vajilla', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Refrigerador', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Lavavajilla', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Art. Limpieza', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Horno', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Cubiertos', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Cocina', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Ollas', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Microondas ', 'grupo_caracteristicas_propiedades_id' => 1],
            ['descripcion' => 'Licuadora', 'grupo_caracteristicas_propiedades_id' => 1],

            ['descripcion' => 'Mesa Comedor', 'grupo_caracteristicas_propiedades_id' => 2],
            ['descripcion' => 'TV', 'grupo_caracteristicas_propiedades_id' => 2],
            ['descripcion' => 'Sofa', 'grupo_caracteristicas_propiedades_id' => 2],
            ['descripcion' => 'Sofá cama', 'grupo_caracteristicas_propiedades_id' => 2],

            // ['descripcion' => 'Cocina', 'grupo_caracteristicas_propiedades_id' => 'exteriores', 'prioritario' => true],
            // ['descripcion' => 'comedor', 'grupo_caracteristicas_propiedades_id' => 'exteriores', 'prioritario' => true],
			
            ['descripcion' => 'Piscina', 'grupo_caracteristicas_propiedades_id' => 3],			
			['descripcion' => 'Terraza', 'grupo_caracteristicas_propiedades_id' => 3],
            ['descripcion' => 'Quincho / Parrillera', 'grupo_caracteristicas_propiedades_id' => 3],
            ['descripcion' => 'Balcón', 'grupo_caracteristicas_propiedades_id' => 3],
            ['descripcion' => 'Jardin', 'grupo_caracteristicas_propiedades_id' => 3],
            ['descripcion' => 'Juegos infantiles', 'grupo_caracteristicas_propiedades_id' => 3],
            ['descripcion' => 'Gimnasio', 'grupo_caracteristicas_propiedades_id' => 3],

            ['descripcion' => 'Acceso Discapacitados', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'WiFi', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Amenities', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Secadora', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Calefacción', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Lavanderia', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Sabanas', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Desayuno', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Mucama', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Toallas', 'grupo_caracteristicas_propiedades_id' => 4],
            ['descripcion' => 'Cable TV', 'grupo_caracteristicas_propiedades_id' => 4],
            // ['descripcion' => 'Agua Caliente', 'grupo_caracteristicas_propiedades_id' => 4],
            // ['descripcion' => 'Lavadora', 'grupo_caracteristicas_propiedades_id' => 4],
            
            ['descripcion' => 'Extintores', 'grupo_caracteristicas_propiedades_id' => 5],
            ['descripcion' => 'Detectores de monóxido', 'grupo_caracteristicas_propiedades_id' => 5],
            ['descripcion' => 'Botiquínes', 'grupo_caracteristicas_propiedades_id' => 5],
            ['descripcion' => 'Alarmas', 'grupo_caracteristicas_propiedades_id' => 5],
            ['descripcion' => 'Cámaras de vigilancia ', 'grupo_caracteristicas_propiedades_id' => 5],
            ['descripcion' => 'Rociadores contra incendio', 'grupo_caracteristicas_propiedades_id' => 5],

        ];

        $propiedadDescripcion1 = 'Se arrienda hermosa casa para 6 personas a solo 4 km de villarrica sector urbano';
        $propiedadDescripcion2 = 'Arriendo cómodas y hermosas cabañas totalmente equipadas para 4 a 8 personas.
        Ubicadas entre Pucon y caburgua, en una parcela de agrado de 5000 mts. Cuentan lavadora, combustión lenta, parrilla para asados, tv satelital, juegos infantiles.
        El uso de la tina caliente tiene un costo adicional, y debe ser programado.
        Los valores publicados corresponden a temporada baja, y la cabaña mas pequeña.';
        $propiedadDescripcion3 = 'Amplia casa (150 mt2)
        amplio estacionamiento
        4 habitaciones
        2 baños
        amoblada
        lavadora
        portón fierro corredera
        a metro de supermercado y estaciones de servicio
        pasaje residencial
        a 5 minutos del centro de pucón, sector tranquilo y seguro
        guardia durante el dia';
        $propiedadDescripcion4 = 'Se arrienda amplia cabaña para 8 personas';
        $propiedadDescripcion5 = 'Se arrienda casa en villarica promoción solo por 1, 2 y 3 de febrero, casa equipada para 5 personas, solo llegar e instalarse.';
        $propiedadDescripcion6 = 'Casa independiente, equipada.';
        $propiedadDescripcion7 = 'Completamente equipadas, hasta para 6 personas, comedor, cocina, y baño independiete, con agua caliente y refrigerador, televisión, estacionamiento privado, quinchos, agradable y tranquilo ambiente familiar, dentro de comunidad cerrada, a minutos de la playa y el centro.
        cada cabaña cuenta con dos dormitorios, uno con cama matrimonial y el otro con dos camarotes de plaza y media.';
        $propiedadDescripcion8 = 'Arriendo mi casa en el tabito en ciudadela relocanvi.
        La casa cuenta con living-comedor, cocina equipada,  tres dormitorios; uno con cama de dos plazas y un sillon cama, el segundo con dos camas de plaza y media, y el tercero con una cama de plaza y media y un camarote.
        ademas tenemos un pequeño quincho para asados y estacionamiento para automoviles.';
        $propiedadDescripcion9 = 'Alugo casas para o carnaval em Tramandai, tendo opcoes para abrigar tanto poucas quanto muitas pessoas, depois a ideia  e alugar anual. Ali no valor tem uma media que pode ser por pessoas, podrém estou disposto a negociar o pacote dependendo do número de dias e pessoas.';
        $propiedadDescripcion10 = 'Arriendo mi casa en el Tabito en ciudadela Relocanví.
        La casa cuenta con living-comedor, cocina equipada, tres dormitorios; uno con una cama de dos plazas y un sillon cama, el segundo con dos camas de plaza y media y el tercero con una cama de plaza y media y un camarote.
        Ademas tenemos un pequeño quincho para asados y estacionamiento para dos automoviles.';

        $propiedadesEjemplo = [
            ['id_publicacion' => '2-041-0000000001', 'tipo_propiedades_id' => 1, 'nombre' => 'Casa para 6 personas', 'descripcion' => $propiedadDescripcion1, 'metros' => 250, 'nhabitaciones' => 3, 'capacidad' => 6, 'pais' => 'Chile', 'distrito' => 'Cautín', 'localidad' => 'Villarrica', 'provincia' => 'IX Región', 'direccion' => 'Villarrica, IX Región, Chile', 'longitud' => -72.2307798, 'latitud' => -39.2820124, 'precio' => 45000, 'anfitrion' => 1, 'nombre_anfitrion' => 'Yolanda Palma', 'telefono_anfitrion' => '(56) 996387896', 'correo_anfitrion' => 'yolanditapalma@gmail.com', 'estatus_propiedades_id' => 2, 'usuarios_id' => 1, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000002', 'tipo_propiedades_id' => 4, 'nombre' => 'Cabañas con tinaja', 'descripcion' => $propiedadDescripcion2, 'metros' => 5000, 'nhabitaciones' => 3, 'capacidad' => 8, 'pais' => 'Chile', 'distrito' => 'Cautín', 'localidad' => 'Pucon', 'provincia' => 'IX Región', 'direccion' => 'Pucon, Pucón, IX Región, Chile', 'longitud' => -71.98310509999999, 'latitud' => -39.2929692, 'precio' => 30000, 'anfitrion' => 1, 'nombre_anfitrion' => 'Carmen', 'telefono_anfitrion' => '(56) 981601480', 'correo_anfitrion' => 'carmen@gmail.com', 'estatus_propiedades_id' => 2, 'usuarios_id' => 1, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000003', 'tipo_propiedades_id' => 1, 'nombre' => 'Casa para hasta 8 en pucón', 'descripcion' => $propiedadDescripcion3, 'metros' => 150, 'nhabitaciones' => 3, 'capacidad' => 8, 'pais' => 'Chile', 'distrito' => 'Cautín', 'localidad' => 'Pucon', 'provincia' => 'IX Región', 'direccion' => 'Pucon, Pucón, IX Región, Chile', 'longitud' => -71.98310509999999, 'latitud' => -39.2929692, 'precio' => 80000, 'anfitrion' => 1, 'nombre_anfitrion' => 'Maximiliano Caro Vargas', 'telefono_anfitrion' => '999794834', 'correo_anfitrion' => 'maximilianocaroVargas@gmail.com', 'estatus_propiedades_id' => 2, 'usuarios_id' => 1, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000004', 'tipo_propiedades_id' => 4, 'nombre' => 'Cabaña pucón', 'descripcion' => $propiedadDescripcion4, 'metros' => 150, 'nhabitaciones' => 3, 'capacidad' => 8, 'pais' => 'Chile', 'distrito' => 'Cautín', 'localidad' => 'Pucon', 'provincia' => 'IX Región', 'direccion' => 'Pucon, Pucón, IX Región, Chile', 'longitud' => -71.98310509999999, 'latitud' => -39.2929692, 'precio' => 75000, 'anfitrion' => 0, 'nombre_anfitrion' => null, 'telefono_anfitrion' => null, 'correo_anfitrion' => null, 'estatus_propiedades_id' => 2, 'usuarios_id' => 2, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000005', 'tipo_propiedades_id' => 1, 'nombre' => 'Promoción 1, 2 y 3 de Febrero Villarica', 'descripcion' => $propiedadDescripcion5, 'metros' => 420, 'nhabitaciones' => 3, 'capacidad' => 8, 'pais' => 'Chile', 'distrito' => 'Cautín', 'localidad' => 'Villarrica', 'provincia' => 'IX Región', 'direccion' => 'Villarrica, IX Región, Chile', 'longitud' => -72.2307798, 'latitud' => -39.2820124, 'precio' => 26000, 'anfitrion' => 0, 'nombre_anfitrion' => null, 'telefono_anfitrion' => null, 'correo_anfitrion' => null, 'estatus_propiedades_id' => 2, 'usuarios_id' => 2, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000006', 'tipo_propiedades_id' => 1, 'nombre' => 'Casa', 'descripcion' => $propiedadDescripcion6, 'metros' => 150, 'nhabitaciones' => 2, 'capacidad' => 4, 'pais' => 'Chile', 'distrito' => 'Valparaiso', 'localidad' => 'Viña del Mar', 'provincia' => 'Región de Valparaíso', 'direccion' => 'Viña del Mar, Región de Valparaíso, Chile', 'longitud' => -71.55002760000002, 'latitud' => -33.0153481, 'precio' => 25000, 'anfitrion' => 0, 'nombre_anfitrion' => null, 'telefono_anfitrion' => null, 'correo_anfitrion' => null, 'estatus_propiedades_id' => 2, 'usuarios_id' => 2, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000007', 'tipo_propiedades_id' => 4, 'nombre' => 'Cabaña Villablanca 6 personas El Quisco', 'descripcion' => $propiedadDescripcion7, 'metros' => 280, 'nhabitaciones' => 2, 'capacidad' => 6, 'pais' => 'Chile', 'distrito' => 'San Antonio', 'localidad' => 'El Quisco', 'provincia' => 'Región de Valparaíso', 'direccion' => 'El Quisco, Región de Valparaíso, Chile', 'longitud' => -71.6981538, 'latitud' => -33.398596, 'precio' => 20000, 'anfitrion' => 0, 'nombre_anfitrion' => null, 'telefono_anfitrion' => null, 'correo_anfitrion' => null, 'estatus_propiedades_id' => 2, 'usuarios_id' => 1, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-041-0000000008', 'tipo_propiedades_id' => 1, 'nombre' => 'Casa 8 personas en el Tabito', 'descripcion' => $propiedadDescripcion8, 'metros' => 180, 'nhabitaciones' => 3, 'capacidad' => 8, 'pais' => 'Chile', 'distrito' => 'San Antonio', 'localidad' => 'El Tabo', 'provincia' => 'Región de Valparaíso', 'direccion' => 'El Tabo, Región de Valparaíso, Chile', 'longitud' => -71.66693409999999, 'latitud' => -33.4557162, 'precio' => 30000, 'anfitrion' => 1, 'nombre_anfitrion' => 'Alejandra Meneses', 'telefono_anfitrion' => '(56) 991251337', 'correo_anfitrion' => 'alejandrameneses@hotmail.com', 'estatus_propiedades_id' => 2, 'usuarios_id' => 2, 'moneda' => 'CLP', 'pais_id' => 41],
            ['id_publicacion' => '2-031-0000000009', 'tipo_propiedades_id' => 1, 'nombre' => 'Casa de um ou 2 quartos', 'descripcion' => $propiedadDescripcion9, 'metros' => 120, 'nhabitaciones' => 3, 'capacidad' => 6, 'pais' => 'Brasil', 'distrito' => 'Porto Alegre', 'localidad' => 'Porto Alegre', 'provincia' => 'Río Grande del Sur', 'direccion' => 'Porto Alegre, Río Grande del Sur, Brasil', 'longitud' => -51.217658400000005, 'latitud' => -30.0346471, 'precio' => 50, 'anfitrion' => 1, 'nombre_anfitrion' => 'Leandro Mainerie', 'telefono_anfitrion' => null, 'correo_anfitrion' => 'leandromaineriebanda3@gmail.com', 'estatus_propiedades_id' => 2, 'usuarios_id' => 2, 'moneda' => 'BRL', 'pais_id' => 31],
            ['id_publicacion' => '2-041-0000000010', 'tipo_propiedades_id' => 1, 'nombre' => 'Casa 8 personas en el Tabito', 'descripcion' => $propiedadDescripcion10, 'metros' => 200, 'nhabitaciones' => 3, 'capacidad' => 8, 'pais' => 'Chile', 'distrito' => 'San Antonio', 'localidad' => 'El Tabo', 'provincia' => 'Región de Valparaíso', 'direccion' => 'El Tabo, Valparaíso, Chile', 'longitud' => -71.66693409999999, 'latitud' => -33.4557162, 'precio' => 30000, 'anfitrion' => 0, 'nombre_anfitrion' => null, 'telefono_anfitrion' => null, 'correo_anfitrion' => null, 'estatus_propiedades_id' => 2, 'usuarios_id' => 1, 'moneda' => 'CLP', 'pais_id' => 41],
        ];


        $propiedadesEjemplosImagenes = [
            ['propiedad_id' => 10, 'ruta' => '642ac45a46280c00d6b9ffe921c1ba480.jpg', 'descripcion' => 'principal', 'primaria' => 1],
            ['propiedad_id' => 10, 'ruta' => '642ac45a46280c00d6b9ffe921c1ba481.jpg', 'descripcion' => null, 'primaria' => 0],
            ['propiedad_id' => 10, 'ruta' => 'ff1ff78b56e9fea34d6f9567c28d81c82.jpg', 'descripcion' => null, 'primaria' => 0],
            ['propiedad_id' => 10, 'ruta' => 'ff1ff78b56e9fea34d6f9567c28d81c83.jpg', 'descripcion' => null, 'primaria' => 0],
            ['propiedad_id' => 10, 'ruta' => 'ff1ff78b56e9fea34d6f9567c28d81c84.jpg', 'descripcion' => null, 'primaria' => 0],
        ];

        // $propiedadesEjemplosCaracteristicas = [
            // ['tipo' => 'exteriores', 'propiedad_id' => '7', 'caracteristicas' => '["25","26","30","31"]', 'descripcion' => NULL],
            // ['tipo' => 'cocina', 'propiedad_id' => '7', 'caracteristicas' => '["1","2","3","4","6","7"]', 'descripcion' => 'La cocina esta bien equipada.'],
            // ['tipo' => 'living_comedor', 'propiedad_id' => '7', 'caracteristicas' => '["10","11","13"]', 'descripcion' => 'Amplio espacio en la sala'],
            // ['tipo' => 'servicios', 'propiedad_id' => '7', 'caracteristicas' => '["14","15","16","17","18","19","20","21"]', 'descripcion' => NULL],
            // ['tipo' => 'seguridad', 'propiedad_id' => '7', 'caracteristicas' => '["35","36"]', 'descripcion' => NULL],
        // ];

        $propiedadDistribucionHabitaciones = [
            ['camas' => '["1"]', 'tiene_banio' => 1, 'tiene_tv' => 1,  'tiene_calefaccion' => 0, 'descripcion' => 'La habitación es muy espaciosa, con vista al mar', 'propiedad_detalles_id' => 7],
            ['camas' => '["4","3"]', 'tiene_banio' => 0, 'tiene_tv' => 0,  'tiene_calefaccion' => 0, 'descripcion' => 'Apta para los niños de la familia, con amplio espacio y camas resistentes.', 'propiedad_detalles_id' => 7],
        ];

        /*
        $tipo_habitaciones = [
            ['descripcion' => 'Matrimonial'],
            ['descripcion' => 'Familiar'],
            ['descripcion' => 'Individual'],
            ['descripcion' => 'Area comun'],
        ];
        */

        $tipo_camas = [
            ['descripcion' => 'Cama Matrimonial'],
            ['descripcion' => 'Cama King'],
            ['descripcion' => 'Cama Sencilla'],
            ['descripcion' => 'Cama Litera'],
            ['descripcion' => 'Sofa-cama'],
            ['descripcion' => 'Nido'],
        ];

        /*
        foreach ($tipo_habitaciones as $key => $value) {
            DB::table('tipo_habitaciones')->insert(['descripcion' => $value]);
        }
        */

        foreach ($tipo_oferta as $key => $oferta) {
            DB::table('ofertas_propiedades')->insert(['titulo' => $oferta]);
        }

        foreach ($tipo_camas as $key => $value) {
            DB::table('tipo_camas')->insert(['descripcion' => $value]);
        }

        foreach ($conceptosCobros as $key => $value) {
            DB::table('conceptos_cobros')->insert(['concepto' => $value]);
        }

        foreach ($estatusPropiedades as $key => $value) {
            DB::table('estatus_propiedades')->insert(['descripcion' => $value]);
        }

        foreach ($tipoPropiedades as $key => $value) {
            DB::table('tipo_propiedades')->insert([
                'descripcion' => $value,
                'estatus' => 1
                ]);
        }

        foreach ($gruposCaracateristicasPropiedades as $key => $value) {
            DB::table('n_grupo_caracteristicas_propiedades')->insert([
                'descripcion'               => $value['descripcion'],
                'etiqueta'      			=> $value['etiqueta'],
                ]);
        }
		
        foreach ($caracteristicasPropiedades as $key => $value) {
            DB::table('n_caracteristicas_propiedades')->insert([
                'descripcion'               => $value['descripcion'],
                'n_grupo_caracteristicas_propiedades_id'       => $value['grupo_caracteristicas_propiedades_id'],
                // 'prioritario'               => ($value['prioritario']) ?? false,
                //'permite_cantidad' => ($value['permite_cantidad']) ?? false,
                ]);
        }
        
        foreach ($propiedadesEjemplo as $key => $value) {
            DB::table('propiedades')->insert([
                'id_publicacion'            => $value['id_publicacion'],
                'tipo_propiedades_id'       => $value['tipo_propiedades_id'],
                'nombre'                    => $value['nombre'],
                'descripcion'               => $value['descripcion'],
                //'moneda'                    => $value['moneda'],
                //'precio'                    => $value['precio'],
                'estatus_propiedad_id'      => $value['estatus_propiedades_id'],
                'usuarios_id'               => $value['usuarios_id'],
                /*
                'metros'                    => $value['metros'],
                'nhabitaciones'             => $value['nhabitaciones'],
                'capacidad'                 => $value['capacidad'],
                */
                ]);
        }

		/**/
        foreach ($propiedadesEjemplo as $key => $value) {
            DB::table('propiedades_administracion')->insert([
                'precio' => $precio = $value['precio'],
                'comision' => $comision = (12 * $precio) / 100,
                'ingreso_total' => $precio - $comision,
                'moneda' => $value['moneda'],
                'dias_intervalo' => 2,
                'noches_minimas' => 4,
                'garantia_reserva_id' => 1,
                'oferta_propiedad_id' => 1,
                // 'usuario_metodo_cobro_id' => null,
                'metodo_cobro_id' => null,
                'propiedad_id' => $key+1,
                ]);
        }
		

        foreach ($propiedadesEjemplo as $key => $value) {
            DB::table('propiedades_ubicaciones')->insert([
                'pais'                      => $value['pais'],
                'distrito'                  => $value['distrito'],
                'localidad'                 => $value['localidad'],
                'provincia'                 => $value['provincia'],
                'direccion'                 => $value['direccion'],
                'longitud'                  => $value['longitud'],
                'latitud'                   => $value['latitud'],
                'propiedad_id'              => $key+1,
                'pais_id'                   => $value['pais_id'],
            ]);
        }

        foreach ($propiedadesEjemplo as $key => $value) {
            DB::table('propiedades_detalles')->insert([
                'checkin'                   => '14:00',
                'checkout'                  => '11:00',
                'superficie'                => $value['metros'],
                'nhabitaciones'             => $value['nhabitaciones'],
                'nbanios'                   => 1,
                'estacionamientos'          => 0,
                'capacidad'                 => $value['capacidad'],
                'propiedad_id'              => $key+1,
            ]);
        }

        // foreach ($propiedadesEjemplosCaracteristicas as $key => $value) {
            // DB::table('propiedades_caracteristicas')->insert([
                // 'tipo' => $value['tipo'],
                // 'propiedad_id' => $value['propiedad_id'],
                // 'caracteristicas' => $value['caracteristicas'],
                // 'descripcion' => $value['descripcion'],
                // ]);
        // }

        foreach ($propiedadDistribucionHabitaciones as $key => $value) {
            DB::table('distribucion_habitaciones')->insert([
                'camas'                     => $value['camas'],
                'tiene_banio'               => $value['tiene_banio'],
                'tiene_tv'                  => $value['tiene_tv'],
                'tiene_calefaccion'         => $value['tiene_calefaccion'],
                'descripcion'               => $value['descripcion'],
                'propiedad_detalles_id'     => $value['propiedad_detalles_id'],
                ]);
        }

        /*
        foreach ($propiedadesEjemplosImagenes as $key => $value) {
            DB::table('propiedades_imagenes')->insert([
                'propiedad_id' => $value['propiedad_id'],
                'ruta' => $value['ruta'],
                'descripcion' => $value['descripcion'],
                'primaria' => $value['primaria'],

                ]);
        }

        */

    }
}
