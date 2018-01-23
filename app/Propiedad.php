<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use App\Reserva;
use App\ReservaManual;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\FechasController;

class Propiedad extends Model
{
    protected $table =  "propiedades";

    protected $guarded = [];

    public static $cantidad_maxima_imagenes = 20;
    public static $porcentaje_comision = 12;
    public static $porcentaje_comision_anfitrion_mybooktravel = 17;
    public static $porcentaje_comision_huesped = 5;

    public function ubicacion()
    {
        return $this->hasOne('App\PropiedadUbicacion');
    }

    public function metodosCobroTransferencia()
    {
        return $this->hasMany('App\RPropiedadAdministracionTransferencia');
    }

    public function metodosCobroTransferenciaStore()
    {
        return $this->belongsToMany('App\RPropiedadAdministracionTransferencia', 'r_propiedad_administracion_transferencia', 'propiedad_id', 'd_usuarios_metodos_cobros_transferencia_id');
    }

    public function caracteristicas()
    {
        return $this->hasMany('App\PropiedadCaracteristica');
    }

    public function caracteristicaStore()
    {
        return $this->belongsToMany('App\PropiedadCaracteristica', 'r_propiedades_caracteristicas', 'propiedad_id', 'n_caracteristicas_propiedades_id');
    }

    public function caracteristicasComentarios()
    {
        return $this->hasMany('App\DPropiedadesCaracteristicasComentarios');
    }

    public function normas()
    {
        return $this->hasMany('App\PropiedadNormas');
    }

    public function normaStore()
    {
        return $this->belongsToMany('App\PropiedadNormas', 'r_propiedades_normas', 'propiedad_id', 'n_norma_id');
    }

    public function normasAdicionales()
    {
        return $this->hasOne('App\PropiedadNormasPersonal');
    }

    public function tipo()
    {
        return $this->belongsTo('App\TipoPropiedad', 'tipo_propiedades_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'usuarios_id');
    }

    public function anfitriones()
    {
        return $this->hasOne('App\PropiedadAnfitrion');
    }

    public function administracion()
    {
        return $this->hasOne('App\PropiedadAdministracion');
    }

    public function costos()
    {
        return $this->hasMany('App\PropiedadConceptosCobros');
    }

    public function reservas()
    {
        return $this->hasMany('App\Reserva', 'propiedad_id', 'id');
    }

    public function reservaManual()
    {
        return $this->hasMany('App\ReservaManual', 'propiedad_id', 'id');
    }

    public function preciosEspecificos()
    {
        return $this->hasMany('App\PropiedadPrecioEspecifico', 'propiedad_id');
    }

    public function mensajes()
    {
        return $this->hasMany('App\PropiedadMensajes');
    }

    public function fechasbloqueadas()
    {
        return $this->hasMany('App\ReservaManual', 'propiedades_id', 'id');
    }

    public function detalles()
    {
        return $this->hasOne('App\PropiedadDetalles');
    }

    public function imagenes()
    {
        return $this->hasMany('App\PropiedadImagen', 'propiedad_id', 'id');
    }

    public function scopeLocalidad($query, $id)
    {
        return $query->where('localidades_id', $id);
    }

    public function scopeCapacidad($query, $capacidad)
    {
        return $query->where('capacidad', '>=', $capacidad);
    }

    public function scopeByPropiedad($query, $propiedad)
    {
        return $query->where('propiedades.id', $propiedad);
    }

    public function scopeSelectcampos($query)
    {
        return $query->select("propiedades.id", "propiedades.localidades_id", "propiedades.tipo_propiedades_id", "propiedades.nombre", "propiedades.descripcion", "propiedades.metros", "propiedades.nhabitaciones", "propiedades.capacidad", "propiedades.pais_id", "propiedades.ciudad", "propiedades.direccion", "propiedades.longitud_mapa", "propiedades.latitud_mapa", "propiedades.precio", "propiedades.categorias_propiedades_id");
    }

    public function scopeFiltrolocalidad($query, $localidad)
    {
        return $query->join('localidades', function ($join) use ($localidad) {
            $join->on('propiedades.localidades_id', '=', 'localidades.id')
                     ->where('localidades.descripcion', 'like', '%'.$localidad.'%');
        });
    }

    public function scopeByDisponible($query, $fecha_inicio, $fecha_fin)
    {
        return $query->whereDoesntHave('reservas', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereIn('estatus_reservas_id', [2, 3, 4, 5, 6, 9])
                ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
                    $query->whereBetween('reservas.fecha_entrada', [$fecha_inicio, $fecha_fin])
                        ->orWhereBetween('reservas.fecha_salida', [$fecha_inicio, $fecha_fin])
                        ->orWhereRaw("'".$fecha_inicio."' BETWEEN reservas.fecha_entrada and reservas.fecha_salida")
                        ->orWhereRaw("'".$fecha_fin."' BETWEEN reservas.fecha_entrada and reservas.fecha_salida");
                });
        })->whereDoesntHave('reservaManual', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('reservas_manuales.fecha_inicio', [$fecha_inicio, $fecha_inicio])
                ->orWhereBetween('reservas_manuales.fecha_fin', [$fecha_inicio, $fecha_inicio])
                ->orWhereRaw("'".$fecha_inicio."' BETWEEN reservas_manuales.fecha_inicio and reservas_manuales.fecha_fin")
                ->orWhereRaw("'".$fecha_inicio."' BETWEEN reservas_manuales.fecha_inicio and reservas_manuales.fecha_fin");
        });

        /*
        $reservas = Reserva::byOcupada($fecha_inicio, $fecha_fin)->select('propiedad_id');
        $query_reservas = HelperController::getRealSqlQuery($reservas);

        $reservas_manuales = ReservaManual::byOcupada($fecha_inicio, $fecha_fin)->select('propiedad_id');
        $query_reservas_manuales = HelperController::getRealSqlQuery($reservas_manuales);

        return $query->whereRaw(" propiedades.id not in ( $query_reservas )")
                ->whereRaw(" propiedades.id not in ( $query_reservas_manuales )");
        */
    }

    public function scopeFiltrodisponibilidad($query, $fecha_llegada, $fecha_salida)
    {
        $fecha_llegada = (is_null($fecha_llegada)) ? date('Y-m-d') : Carbon::parse($fecha_llegada)->format('Y-m-d') ;
        $fecha_salida = (is_null($fecha_salida)) ? date('Y-m-d') : Carbon::parse($fecha_salida)->format('Y-m-d') ;

        $propiedades_con_reserva = \DB::raw("(
							SELECT
								reservas.propiedad_id,
								count(reservas.propiedad_id) as cantidad_reservas
							FROM
								reservas
							WHERE
							( fecha_entrada BETWEEN '$fecha_llegada' AND '$fecha_salida' )
							OR ( fecha_salida BETWEEN '$fecha_llegada' AND '$fecha_salida' )
							OR ( '$fecha_llegada' BETWEEN fecha_entrada AND fecha_salida )
							OR ( '$fecha_salida' BETWEEN fecha_entrada AND fecha_salida )
							AND estatus_reservas_id IN (1, 2, 3)
							group by reservas.propiedad_id
						) as propiedades_con_reserva");
        $query->leftJoin($propiedades_con_reserva, 'propiedades_con_reserva.propiedad_id', '=', 'propiedades.id');

        $propiedades_con_reserva_manual = \DB::raw("(
							SELECT
									reservas_manuales.propiedad_id,
									count(reservas_manuales.propiedad_id) as cantidad_reservas_manuales
							FROM
								reservas_manuales
							WHERE
							( fecha_inicio BETWEEN '$fecha_llegada' AND '$fecha_salida' )
							OR ( fecha_fin BETWEEN '$fecha_llegada' AND '$fecha_salida' )
							OR ( '$fecha_llegada' BETWEEN fecha_inicio AND fecha_fin )
							OR ( '$fecha_salida' BETWEEN fecha_inicio AND fecha_fin )
							group by reservas_manuales.propiedad_id
						) as propiedades_con_reserva_manual");
        $query->leftJoin($propiedades_con_reserva_manual, 'propiedades_con_reserva_manual.propiedad_id', '=', 'propiedades.id');

        $query->where('propiedades_con_reserva.cantidad_reservas', null);
        $query->where('propiedades_con_reserva_manual.cantidad_reservas_manuales', null);
        return $query;
    }

    public function scopeByUsuario($query)
    {
        if (Auth::user()->tipo_usuario=='C') {
            return $query->where('usuarios_id', Auth::user()->id);
        }
        return $query->whereNotNull('usuarios_id');
    }

    public static function busquedaAvanzada($request)
    {
        //servicios y caracteristicas
        $tipo_propiedades_id = is_null($request->input('tipo_propiedades_id')) ? [] : $request->input('tipo_propiedades_id') ;
        $checkbox_caracteristica_propiedad = is_null($request->input('checkbox_caracteristica_propiedad')) ? [] : $request->input('checkbox_caracteristica_propiedad') ;
        $array_rango_precio = is_null($request->input('array_rango_precio')) ? [] : $request->input('array_rango_precio') ;

        //ubicacion geografica
        $pais 		= ($request->input('pais')) ?? "";
        $provincia 	= ($request->input('provincia')) ?? "";
        $localidad 	= ($request->input('localidad')) ?? "";
        $distrito 	= ($request->input('distrito')) ?? "";


        $reserva_inmediata = ($request->input('reserva_inmediata')) ?? 0;

        //huespedes
        $total_adultos = ($request->input('total_adultos')) ?? 1;
        $total_ninos = ($request->input('total_ninos')) ?? 0;
        $total_bebes = ($request->input('total_bebes')) ?? 0;
        $capacidad = $total_adultos + $total_ninos + $total_bebes;

        //fechas
        if (is_null($request->input('fecha_entrada')) || $request->input('fecha_entrada') == "") {
            //echo "fecha_salida: '".$request->input('fecha_salida')."'";
            $fecha1 = date('Y-m-d');
            $fecha2 = strtotime('+7 day', strtotime($fecha1));
            $fecha2 = date('Y-m-d', $fecha2);
        } elseif (is_null($request->input('fecha_salida')) || $request->input('fecha_salida') == "") {
            $fecha1 = $request->input('fecha_entrada');
            $fecha2 = strtotime('+7 day', strtotime($fecha1));
            $fecha2 = date('Y-m-d', $fecha2);
        } else {
            $fecha1 = Carbon::parse($request->fecha_entrada)->format('Y-m-d'); //$request->input('fecha_entrada')
            $fecha2 = Carbon::parse($request->fecha_salida)->format('Y-m-d'); //$request->input('fecha_salida')
        }

        $fecha_entrada = Carbon::createFromFormat('Y-m-d', $fecha1);
        $fecha_salida = Carbon::createFromFormat('Y-m-d', $fecha2);

        $mensajes=[];

        //inicio busqueda
        $propiedades = $propiedades->join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id')
                        // ->leftJoin('propiedades_caracteristicas as pc', 'pc.propiedad_id', '=', 'propiedades.id')
                        ->join('propiedades_detalles as pd', 'pd.propiedad_id', '=', 'propiedades.id')
                        ->join('propiedades_administracion', 'propiedades.id', '=', 'propiedades_administracion.propiedad_id')
                        ->select('propiedades.*')
                        ->distinct('propiedades.id');

        $propiedades->get();
        //aplicacion de filtros opcionales

        if (count($tipo_propiedades_id) > 0) {
            //filtro
            $propiedades = $propiedades->whereIn('tipo_propiedades_id', $tipo_propiedades_id);

            //mensaje
            $tipos_propiedad = TipoPropiedad::whereIn('id', $tipo_propiedades_id)->get()->toArray();
            $string_tipos_propiedad = "";
            $i=0;
            while (isset($tipos_propiedad[$i])) {
                if ($i !=0 && !isset($tipos_propiedad[$i+1])) {
                    $string_tipos_propiedad .=" y ";
                }
                if ($i !=0 && isset($tipos_propiedad[$i+1])) {
                    $string_tipos_propiedad .=", ";
                }
                //$string_tipos_propiedad .=" ";
                $string_tipos_propiedad .= "<span>".$tipos_propiedad[$i]["descripcion"]."</span>";
                //if(!isset($tipos_propiedad[$i+1]))$string_tipos_propiedad .=" ";
                $i++;
            }
            //$mensajes[] = $string_tipos_propiedad."disponible".(count($tipos_propiedad)>1?"s":"")."";
            $mensajes[] = $string_tipos_propiedad;
        }

        //a nivel geografico se busca de lo especifico a lo general
        if ($localidad  != "") {
            $propiedades = $propiedades->where('propiedades_ubicaciones.localidad', $localidad);
        } elseif ($distrito  != "") {
            $propiedades = $propiedades->where('propiedades_ubicaciones.distrito', $distrito);
        } elseif ($provincia  != "") {
            $propiedades = $propiedades->where('propiedades_ubicaciones.provincia', $provincia);
        } elseif ($pais  != "") {
            $propiedades = $propiedades->where('propiedades_ubicaciones.pais', $pais);
        }

        if (count($checkbox_caracteristica_propiedad) > 0) {
            $propiedades = $propiedades->whereIn('pc.caracteristica_propiedad_id', $checkbox_caracteristica_propiedad);
        }

        if ($capacidad != "" && is_numeric($capacidad)) {
            //filtro
            $propiedades = $propiedades->where('pd.capacidad', '>=', $capacidad);
            //mensaje
            $mensajes[] = "Capacidad para <span>".$capacidad."</span> persona".($capacidad>1?"s":"");
        }

        if ($reserva_inmediata == 1) {
            //filtro
            $propiedades = $propiedades->where('propiedades_administracion.reserva_automatica', 1);
            //mensaje
            $mensajes[] = "<span>Reserva inmediata</span>";
        }

        if (count($array_rango_precio)==2) {
            //filtro
            $propiedades = $propiedades->whereBetween('propiedades.precio', $array_rango_precio);

            //mensaje
            $mensajes[]="De <span>$".$array_rango_precio[0]."</span> a <span>$".$array_rango_precio[1]."</span>";
        }

        //aplicacion de filtros obligatorios
        //filtro
        $propiedades = $propiedades->filtroDisponibilidad($fecha_entrada, $fecha_salida);
        //mensaje
        $mensajes[] = "Del <span>".Carbon::parse($fecha_entrada)->format('d-m-Y')."</span> al <span>".
                Carbon::parse($fecha_salida)->format('d-m-Y')."</span>";

        //armado del mensaje de resultados
        $mensaje = "";
        $i=0;
        while (isset($mensajes[$i])) {
            if ($i!=0) {
                $mensaje.=", ";
            }
            $mensaje.= $mensajes[$i];
            $i++;
        }

        //busqueda y paginacion
        $propiedades = $propiedades->simplePaginate(5);

        return ["propiedades"=>$propiedades,"mensaje"=>$mensaje];
    }

    public static function obtenerPrecios($id, $fecha_inicio, $fecha_fin)
    {
        $fecha = new FechasController;
        $fecha_inicio = $fecha->formato($fecha_inicio);
        $fecha_fin = $fecha->formato($fecha_fin);
        /*
        $fecha_inicio = Carbon::parse($fecha_inicio)->format('Y-m-d');
        $fecha_fin = Carbon::parse($fecha_fin)->addDay()->format('Y-m-d');
        */

        // $fecha_fin_precios = "pe.fecha_fin::date";
        $fecha_fin_precios = " ( to_char(pe.fecha_fin,'YYYY-MM-DD' )::timestamp - interval '1 second' )::date ";
        $precio = " case when especificos.precio is not null then especificos.precio else generales.precio end ";

        $query = "SELECT
					generales.propiedad_id,
					generales.fecha,
					$precio as precio

					FROM
					(
						SELECT
						p.id as propiedad_id,
						generate_series(date '$fecha_inicio', date '$fecha_fin', '1 day')::date as fecha,
						pa.precio
						from propiedades p
						INNER JOIN propiedades_administracion pa ON pa.propiedad_id = p.id
						where
						p.id = $id
					) generales
					left join
					(
						SELECT
						  pe.propiedad_id,
						  generate_series(pe.fecha_inicio::date, $fecha_fin_precios , '1 day')::date as fecha,
						  pe.precio
						FROM
						  public.propiedades_precios_especificos pe
						  where
						  pe.propiedad_id = $id
						  and ".HelperController::verifyOverlapSqlIntervals("pe.fecha_inicio", "pe.fecha_fin", "'$fecha_inicio'", "'$fecha_fin'")."
					) especificos on especificos.fecha = generales.fecha

					order by generales.fecha asc ";
        // return $query;
        $precios = \DB::select($query);
        $precios = collect($precios);
        $precios->pop();
        $promedio = $precios->pluck('precio')->avg();

        return (object)['precios'=>$precios,'promedio'=>$promedio];
    }

    public function scopeValor()
    {
        $precio = $propiedad->administracion->precio * (($PorcentajePublicacion / 100) + 1);
        $precio = cambioMoneda($precio, $this->ubicacion->datosPais->moneda, session('valor'));
        return $precio;
    }

    public static function obtenerNochesMinimas($id, $fecha_inicio, $fecha_fin)
    {
        $fecha_inicio = Carbon::parse($fecha_inicio)->format('Y-m-d');
        $fecha_fin = Carbon::parse($fecha_fin)->addDay()->format('Y-m-d');

        $fecha_fin_noches = " ( to_char(pnm.fecha_fin,'YYYY-MM-DD' )::timestamp - interval '1 second' )::date ";
        $noches = " case when especificos.noches is not null then especificos.noches else generales.noches end ";

        $query = "SELECT
					generales.propiedad_id,
					generales.fecha,
					$noches as noches

					FROM
					(
						SELECT
						p.id as propiedad_id,
						generate_series(date '$fecha_inicio', date '$fecha_fin', '1 day')::date as fecha,
						pa.noches_minimas as noches
						from propiedades p
						INNER JOIN propiedades_administracion pa ON pa.propiedad_id = p.id
						where
						p.id = $id
					) generales
					left join
					(
						SELECT
						  pnm.propiedad_id,
						  generate_series(pnm.fecha_inicio::date, $fecha_fin_noches , '1 day')::date as fecha,
						  pnm.noches
						FROM
						  public.d_propiedades_noches_minimas pnm
						  where
						  pnm.propiedad_id = $id
						  and ".HelperController::verifyOverlapSqlIntervals("pnm.fecha_inicio", "pnm.fecha_fin", "'$fecha_inicio'", "'$fecha_fin'")."
					) especificos on especificos.fecha = generales.fecha

					order by generales.fecha asc ";

        $noches = \DB::select($query);
        $noches = collect($noches);
        $noches->pop();

        $inicial = $noches->pluck('noches')->first();

        return (object)['noches'=>$noches,'inicial'=>$inicial];
    }

    public static function obtenerCalendario($id)
    {
        $formato_datetime = "YYYY-MM-DD HH:MI:SSTZ";
        $formato_date = "YYYY-MM-DD";

        $query = "
		SELECT
			to_char( r.fecha_entrada , '$formato_date ' )||pd.checkin AS start,
			to_char( r.fecha_salida, '$formato_date ' )||pd.checkout AS end,
			u.nombres||' '||u.apellidos AS title,
			'' AS rendering,
			'#0EC8DB' AS color,
			'reservas' as tipo,
			r.id as pk,
			'reserva_mybooktravel' as motivo,
			case when u.imagen is not null then u.imagen else '' end as imagen
		FROM
			reservas r
		inner join propiedades_detalles pd on pd.propiedad_id =  r.propiedad_id
		inner join propiedades p on p.id =  r.propiedad_id
		inner join usuarios u on u.id = r.usuarios_id
		WHERE
			r.propiedad_id = ".$id."
			and estatus_reservas_id in (2,3,4,5,6,9)

		union

		select
			to_char(r.fecha_inicio, '$formato_date ')||pd.checkin as start,
			to_char(r.fecha_fin, '$formato_date ')||pd.checkout as end,
			r.descripcion as title ,
			'' as rendering ,
			mb.color,
			'reservas_manuales' as tipo,
			r.id as pk,
			mb.siglas as motivo,
			'' as imagen
		from
			reservas_manuales as r
		inner join propiedades_detalles pd on pd.propiedad_id =  r.propiedad_id
		inner join n_motivo_bloqueo mb on mb.id = r.n_motivo_bloqueo_id
		where
			r.propiedad_id = ".$id."

		union

		select
			to_char(p.fecha_inicio, '$formato_date') as start,
			to_char(p.fecha_fin, '$formato_date') as end,
			'precio: '||p.descripcion as title,
			'background' as rendering,
			'#E0F8E0' as color,
			'precios_especificos' as tipo,
			p.id as pk,
			'precio' as motivo,
			'' as imagen
		from
			propiedades_precios_especificos p
		where
			p.propiedad_id = ".$id."
		";
        // return $query;

        $events = \DB::select($query);

        return $events;
    }
}
