<?php

function cambioMoneda($monto, $moneda, $valorMoneda)
{
    $monto = sanear_string($monto);
    if ($moneda == session('moneda')) {
        return number_format($monto, 0, '', ',');
    }
    $monto = $monto / session('monedas')[$moneda];
    $monto = $monto * session('monedas')[session('moneda')];
    # $monto = $monto * 1.06;
    return number_format($monto, 0, '', ',');
}

function contarPropiedades($entidad, $valor)
{
    $propiedades = App\Propiedad::join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id');


    if ($entidad == 'localidad') {
        $propiedades = $propiedades->Where('propiedades_ubicaciones.localidad', $valor);
    } elseif ($entidad == 'distrito') {
        $propiedades = $propiedades->Where('propiedades_ubicaciones.distrito', $valor);
    } elseif ($entidad == 'provincia') {
        $propiedades = $propiedades->Where('propiedades_ubicaciones.provincia', $valor);
    } elseif ($entidad == 'pais') {
        $propiedades = $propiedades->Where('propiedades_ubicaciones.pais', $valor);
    }

    return $propiedades = $propiedades->count();
}

function sanear_string($string)
{
    $string = trim($string);

    // $string = mb_convert_encoding($string, 'UTF-8','');

    $string = str_replace(
        ['á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'],
        ['a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'],
        $string
    );

    $string = str_replace(
        ['é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'],
        ['e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'],
        $string
    );

    $string = str_replace(
        ['í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'],
        ['i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'],
        $string
    );

    $string = str_replace(
        ['ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'],
        ['o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'],
        $string
    );

    $string = str_replace(
        ['ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'],
        ['u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'],
        $string
    );

    $string = str_replace(
        ['ñ', 'Ñ', 'ç', 'Ç'],
        ['n', 'N', 'c', 'C',],
        $string
    );

    $string = str_replace(',', '', $string);
    $string = str_replace(' ', '', $string);

    //Esta parte se encarga de eliminar cualquier caracter extraño
    /*
    $string = str_replace(
        ["\", "¨", "º", "-", "~",
             "#", "@", "|", "!", """,
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "],
        '',
        $string
    );
    */

    return $string;
}

function getBoundaries($lat, $lng, $distance = 1, $earthRadius = 6371)
{
    $return = array();

    $cardinalCoords = [ 'north' => '0',
                        'south' => '180',
                        'east' => '90',
                        'west' => '270'
                    ];

    $rLat = deg2rad($lat); # convertimos la latitud a su equivalente en radianes
    $rLng = deg2rad($lng); # convertimos la longitud a su equivalente en radianes

    $rAngDist = $distance/$earthRadius;

    foreach ($cardinalCoords as $puntoCardinal => $angulo) {
        $rAngulo = deg2rad($angulo);
        $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngulo));
        $rLonB = $rLng + atan2(sin($rAngulo) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));
        $return[$puntoCardinal] = ['lat' => (float) rad2deg($rLatB), 'lng' => (float) rad2deg($rLonB)];
    }
    return [
            'min_lat'  => $return['south']['lat'],
            'max_lat' => $return['north']['lat'],
            'min_lng' => $return['west']['lng'],
            'max_lng' => $return['east']['lng']
            ];
}
