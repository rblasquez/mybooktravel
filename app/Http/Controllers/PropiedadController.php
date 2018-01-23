<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Http\Requests\PropiedadActualizarResumenRequest;
use App\Http\Requests\PropiedadActualizarAdministracionRequest;
use App\Http\Requests\PropiedadActualizarUbicacionRequest;
use App\Http\Requests\PropiedadActualizarDetallesRequest;
use App\Http\Requests\PropiedadStoreRequest;
use App\Notifications\FinalizarPublicacion;
use App\Mail\CargarPropiedad;
use App\Mail\PublicacionPropiedad;
use App\Mail\ComprobanteReservaManual;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\FechasController;

use App\Jobs\ComprimirImagenes;

use App\NGrupoCaracteristicasPropiedades;
use App\PropiedadPrecioEspecifico;
use App\CaracteristicaPropiedad;
use App\PropiedadCaracteristica;
use App\PropiedadUbicacion;
use App\OfertasPropiedad;
use App\ServiciosBasicos;
use App\GarantiaReserva;
use App\PropiedadImagen;
use App\ConceptosCobros;
# use App\LocalCategoria;
use App\TipoHabitacion;
use App\TipoPropiedad;
use App\ReservaManual;

# Con estos modelos creo una nueva propiedad
use App\Propiedad;
use App\PropiedadDetalles;
use App\DPropiedadesCaracteristicasComentarios;
use App\DistribucionHabitaciones;
use App\PropiedadNormasPersonal;
use App\PropiedadConceptosCobros;
use App\PropiedadAdministracion;
use App\PropiedadAnfitrion;
use App\MetodoCobro;
# ---------------------------------------------

# Para cargar las imagenes antes de crear la propiedad
use App\DImagenesTemporales;
# ----------------------------------------------------

use App\Localidad;
use App\TipoCama;
use App\Reserva;
use App\Normas;
use App\Pais;

use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Validator;
use Auth;
use File;
use DB;
use Meta;

class PropiedadController extends Controller
{
    # public $cantidad_maxima_imagenes = 5;
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth')->only([
            'index',
            'create',
            'store',
            'edit',
            'editarSeccion',
            'actualizarResumen',
            'actualizarAdministracion',
            'actualizarDetalles',
            'actualizarUbicacion',
            'actualizarNormas',
            'deleteUpload',
            'reservamanual',
            'storereservamanual',
            'storeimagenpropiedadprimaria',
            'destroyreservamanual',
            'destroyimagenpropiedad',
            'eliminar',
            'destroy',
        ]);
    }

    public function index()
    {
        $propiedades = Auth::user()->propiedades;
        return view('propiedades.index', ['propiedades' => $propiedades]);
    }

    public function create()
    {
        $imagenes_temporales =  DImagenesTemporales::where('usuarios_id', Auth::user()->id)->delete();
        return view('propiedades.create', [
            'categorias' 		=> TipoPropiedad::pluck('descripcion', 'id'),
            'tipo_cama'			=> TipoCama::pluck('descripcion', 'id'),
            'normas'			=> Normas::all(),
            'caracteristicas'	=> CaracteristicaPropiedad::all(),
            'gruposCaracteristicasPropiedades'	=> NGrupoCaracteristicasPropiedades::all(),
            'conceptos'			=> ConceptosCobros::all(),
            'metodoGarantia'	=> GarantiaReserva::all(),
            'tipo_oferta'		=> OfertasPropiedad::all(),
            'metodos_cobro'		=> MetodoCobro::all(),
            'paises'			=> Pais::orderBy('nombre')->pluck('nombre', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $propiedad = DB::transaction(function () use ($request) {
            $pais = Pais::where('iso2', ($request->pais) ?? 'CL')->first();
            $usuario = Auth::user();
            $success = true;
            try {
                $propiedad = new Propiedad;
                $propiedad->nombre = $request->nombre;
                $propiedad->descripcion = $request->descripcion;
                $propiedad->tipo_propiedades_id = $request->tipo_propiedades_id;
                $usuario->propiedades()->save($propiedad);

                $detalles = new PropiedadDetalles;
                $detalles->checkin = $request->checkin ?? '14:00';
                $detalles->checkin_estricto = $request->checkin_estricto ?? null;
                $detalles->checkout = $request->checkout ?? '11:00';
                $detalles->superficie = $request->superficie ?? 0;
                $detalles->nhabitaciones = $request->nhabitaciones ?? 1;
                $detalles->nbanios = $request->nbanios ?? 1;
                $detalles->estacionamientos = $request->estacionamientos ?? 0;
                $detalles->capacidad = $request->capacidad ?? 1;
                $propiedad->detalles()->save($detalles);

                if (count($request->dist_habitaciones) > 0) {
                    foreach (collect($request->dist_habitaciones) as $key => $habitacion) {
                        $cuarto = new DistribucionHabitaciones;
                        $cuarto->camas = json_encode(collect($habitacion['listado_camas'])->flatten());
                        $cuarto->tiene_banio = (isset($habitacion['tiene_banio'])) ? true : false;
                        $cuarto->tiene_tv = (isset($habitacion['tiene_tv'])) ? true : false;
                        $cuarto->tiene_calefaccion = (isset($habitacion['tiene_calefaccion'])) ? true : false;
                        $cuarto->descripcion = $habitacion['descripcion'];
                        $propiedad->detalles->distribucionhabitaciones()->save($cuarto);
                    }
                }

                $propiedad->caracteristicaStore()->attach($request->caracteristica);

                foreach ($request->descripcion_caracteristica as $key => $value) {
                    if ($value) {
                        $comentariosCaracteristicas = new DPropiedadesCaracteristicasComentarios;
                        $comentariosCaracteristicas->n_grupo_caracteristicas_propiedades_id = $key;
                        $comentariosCaracteristicas->comentario = $value;

                        $propiedad->caracteristicasComentarios()->save($comentariosCaracteristicas);
                    }
                }

                $ubicacion = new PropiedadUbicacion;
                $ubicacion->pais = $pais->iso2;
                $ubicacion->pais_id = $pais->id;
                $ubicacion->distrito = $request->distrito;
                $ubicacion->localidad = $request->localidad;
                $ubicacion->provincia = $request->provincia;
                $ubicacion->direccion = $request->direccion;
                $ubicacion->longitud = $request->longitud;
                $ubicacion->latitud = $request->latitud;
                $ubicacion->zona_descripcion = $request->zona_descripcion;
                $ubicacion->como_llegar = $request->como_llegar;
                $propiedad->ubicacion()->save($ubicacion);

                if (count($request->normas) > 0) {
                    $propiedad->normaStore()->attach($request->normas);
                }


                if ($request->normas_adicionales) {
                    $normas = new PropiedadNormasPersonal;
                    $normas->normas = $request->normas_adicionales;
                    $propiedad->normasAdicionales()->save($normas);
                }

                $metodo_cobro = null;
                switch ($request->medio) {
                    case 'transferencia':
                    $metodo_cobro = MetodoCobro::find(1);
                    break;
                    case 'wu':
                    $metodo_cobro = MetodoCobro::find(2);
                    break;
                }

                if ($request->medio <> 'transferencia' && $request->medio <> 'wu') {
                    $usuario_metodo_cobro = Auth::user()->medio_cobro_transferencia->where('id', $request->medio)->first();
                    $metodo_cobro = MetodoCobro::find($usuario_metodo_cobro->metodo_cobro_id);
                } else {
                    $info_pago = $request->inf_pago;
                    $info_pago["metodo_cobro_id"] = $metodo_cobro->id;

                    $usuario_metodo_cobro = Auth::user()->medio_cobro_transferencia()->create($info_pago);
                }

                $propiedad->metodosCobroTransferenciaStore()->attach([$usuario_metodo_cobro->id]);

                $administracion 						= new PropiedadAdministracion;
                $administracion->moneda					= $request->moneda_propiedad;
                $administracion->precio 				= intval(preg_replace('/[^0-9]+/', '', $request->precio), 10); # $precio ?? 1;
                $administracion->aseo_unico				= $aseo_unico ?? 0;
                $administracion->comision 				= 0; # $comision ?? 0;
                $administracion->ingreso_total 			= 0; # $ingreso_total ?? 1;
                $administracion->anfitrion				= $request->anfitrion ?? 'usuario';
                $administracion->dias_intervalo 		= $request->dias_intervalo ?? 0;
                $administracion->noches_minimas 		= $request->noches_minimas ?? 1;
                $administracion->reserva_automatica 	= ($request->reserva_automatica) ?? false;
                $administracion->garantia_reserva_id 	= $request->garantia_reserva_id ?? 1;
                $administracion->oferta_propiedad_id 	= $request->oferta_propiedad_id ?? 1;
                $administracion->metodo_cobro_id 		= $metodo_cobro->id;
                $propiedad->administracion()->save($administracion);

                if ($request->anfitrion == 'otro') {
                    $anfitrion = new PropiedadAnfitrion;
                    $anfitrion->nombre_anfitrion		= $request->nombre_anfitrion ?? ' ';
                    $anfitrion->telefono_anfitrion		= $request->telefono_anfitrion ?? ' ';
                    $anfitrion->correo_anfitrion		= $request->correo_anfitrion ?? ' ';
                    $propiedad->anfitriones()->save($anfitrion);
                }

                $imagenes_temporales =  DImagenesTemporales::where('token', $request->_token)->where('usuarios_id', Auth::user()->id)->get();
                if (count($imagenes_temporales) > 0) {
                    foreach ($imagenes_temporales as $key => $imagen) {
                        $img = new PropiedadImagen;
                        $img->primaria 	= false;
                        $img->ruta 		= $imagen->ruta;
                        $img = $propiedad->imagenes()->save($img);
                    }
                    $imagenes_temporales= DImagenesTemporales::where('usuarios_id', Auth::user()->id)->delete();

                    if (isset($request->imagen_principal)) {
                        $propiedad->imagenes()->where('ruta', 'like', '%'.$request->imagen_principal.'%')->update(['primaria' => true]);
                    } else {
                        $propiedad->imagenes()->first()->update(['primaria' => true]);
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                $success = false;
                $error = [get_class($e),$e->getMessage()];
                DB::rollBack();
            }

            if ($success) {
                session(['primera_vez' => true]);
                if ($request->ajax()) {
                    return $propiedad;
                } else {
                    # alert()->success('Su propiedad ha sido publicada correctamente, puede editarla para agregar mas fotos y el detalle de las habitaciones', 'Listo')->persistent('Aceptar');
                    return redirect()->route('propiedad.editar.seccion', [$propiedad->id, 'calendario']);
                }
            } else {
                return false;
            }
        }, 5);

        if ($propiedad) {
            Mail::to(Auth::user()->email)->send(new CargarPropiedad($propiedad));
            Mail::to('aandrade@mybooktravel.com')
                ->cc(['jrivero@mybooktravel.com', 'esanchez@mybooktravel.com', 'alejandrofernand@gmail.com', 'rblasquez@mybooktravel.com'])
                ->send(new PublicacionPropiedad($propiedad));
            return response()->json($propiedad);
        }
        return false;
        # return response()->json(false);
    }

    public function show($id)
    {
        $propiedad = Propiedad::find($id);

        $reservas = Reserva::where('propiedad_id', $id)->select('fecha_entrada', 'fecha_salida', 'propiedad_id');
        $reservas = ReservaManual::where('propiedad_id', $id)->select('fecha_inicio', 'fecha_fin', 'propiedad_id')->union($reservas)->get();


        $reservasArray = collect();
        foreach ($reservas as $key => $value) {
            $fecha_entrada 	= Carbon::parse($value->fecha_inicio)->format('Y-m-d');
            $fecha_salida 	= Carbon::parse($value->fecha_fin)->format('Y-m-d');
            $fecha_entrada 	= Carbon::parse($fecha_entrada);
            $fecha_salida 	= Carbon::parse($fecha_salida);
            $diferencia 	= $fecha_entrada->diffInDays($fecha_salida);

            for ($i=0; $i <= $diferencia; $i++) {
                $reservasArray->push($fecha_entrada->format('Y-m-d'));
                $fecha_entrada->addDay();
            }
        }

        return view('propiedades.show', [
            'propiedad' 			=> $propiedad,
            'reservas' 				=> $reservasArray,
            'gruposCaracteristicas' => NGrupoCaracteristicasPropiedades::all(),
            'normas' 				=> Normas::all(),
        ]);
    }

    public function detalle(Request $request, $id)
    {
        $propiedad = Propiedad::find($id);

        $recomendaciones = collect();
        # -----------------------------------------------------------------------
        # PROPIEDADES CON CARACTERISTICAS SIMILARES
        # -----------------------------------------------------------------------

        # $lat = $propiedad->ubicacion->latitud;
        # $lng = $propiedad->ubicacion->longitud;
        # $distancia = 150;
        # $box = getBoundaries($lat, $lng, $distancia);
        # $precio = $propiedad->administracion->precio * .1;

        # $recomendaciones = Propiedad::join('propiedades_administracion', 'propiedades.id', '=', 'propiedades_administracion.propiedad_id')
        # ->join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id')
        # ->whereBetween('propiedades_ubicaciones.latitud', [$box['min_lat'], $box['max_lat']])
        # ->whereBetween('propiedades_ubicaciones.longitud', [$box['min_lng'], $box['max_lng']])
        # ->whereRaw('(6371 * ACOS(COS(RADIANS('.$lat.') ) * COS(RADIANS(propiedades_ubicaciones.latitud)) * COS(RADIANS(propiedades_ubicaciones.longitud)  - RADIANS('.$lng.')) + SIN(RADIANS('.$lat.')) *  SIN(RADIANS(propiedades_ubicaciones.latitud)))) < '. $distancia)
        # ->where('propiedades_ubicaciones.pais', $propiedad->ubicacion->pais)
        # ->where('propiedades.id', '<>',$propiedad->id)
        # ->whereBetween('propiedades_administracion.precio', [$propiedad->administracion->precio - $precio, $propiedad->administracion->precio + $precio])
        # ->select('propiedades.*')
        # ->limit(4)
        # ->get();

        $normas = Normas::all();
        $camas = TipoCama::all();
        $gruposCaracteristicas = NGrupoCaracteristicasPropiedades::all();

        $reservas = Reserva::where('propiedad_id', $id)->whereIn('estatus_reservas_id', [2, 3, 4, 5, 6, 9])->select('fecha_entrada', 'fecha_salida', 'propiedad_id');
        $reservas = ReservaManual::where('propiedad_id', $id)->select('fecha_inicio', 'fecha_fin', 'propiedad_id')->union($reservas)->get();

        $fecha = new FechasController;
        $reservasArray = collect();
        foreach ($reservas as $key => $value) {
            $fecha_entrada	= $fecha->formato($value->fecha_inicio);
            $fecha_salida	= $fecha->formato($value->fecha_fin);
            $diferencia = $fecha->diasDiferencia($value->fecha_inicio, $value->fecha_fin);

            for ($i = 0; $i <= $diferencia; $i++) {
                $reservasArray->push($fecha_entrada->format('Y-m-d'));
                $fecha_entrada->addDay();
            }
        }


        if (count($propiedad->imagenes) > 0) {
            $imagen = $propiedad->imagenes->where('primaria', true)->first()->ruta ?? $propiedad->imagenes->first()->ruta;
            $imagen = HelperController::getUrlImg($propiedad->usuario->id, $imagen, 'lg');
        } else {
            $imagen = asset('img/mail/publicacion_banner.jpg');
        }

        return view('propiedades.detalle', [
            'propiedad' 			=> $propiedad,
            'reservas' 				=> $reservasArray,
            'request' 				=> $request,
            'gruposCaracteristicas' => $gruposCaracteristicas,
            'normas' 				=> $normas,
            'camas'					=> $camas,
            'recomendaciones'		=> $recomendaciones,

            'meta_og_title'			=> 'Mybooktravel | '.$propiedad->nombre,
            'meta_og_description'	=> $propiedad->descripcion,
            'meta_og_image'			=> $imagen,
        ]);
    }

    public function editarSeccion($id, $seccion = "resumen")
    {
        $propiedad = Propiedad::join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id')
        ->join('paises', 'paises.id', '=', 'propiedades_ubicaciones.pais_id')
        ->select('propiedades.*', 'paises.prefijo_telefono', 'paises.nombre as nombre_pais', 'paises.moneda')
        ->where('propiedades.id', $id)
        ->byUsuario()
        ->first();

        if (!isset($propiedad)) {
            // return "esta propiedad no es tuya";
            return redirect()->route('propiedad.index');
        } else {
            $variables_vista['seccion']=$seccion;
            $variables_vista['propiedad']=$propiedad;
            switch ($seccion) {
                case "resumen": {
                    $variables_vista['categorias']=TipoPropiedad::pluck('descripcion', 'id');
                }
                break;
                case "detalles": {
                    $variables_vista['tipo_cama'] = TipoCama::pluck('descripcion', 'id');
                    // $variables_vista['caracteristicas_old'] = CaracteristicaPropiedad::orderBy('tipo_caracteristica')->orderBy('descripcion')->get();

                    $distribucion_columnas_caracteristicas = [
                        "cocina" => ['cantidad_grupos'=>4,'tamanio_grupos'=>4],
                        "living_comedor" => ['cantidad_grupos'=>2,'tamanio_grupos'=>4],
                        "exteriores" => ['cantidad_grupos'=>2,'tamanio_grupos'=>4],
                        "servicios" => ['cantidad_grupos'=>3,'tamanio_grupos'=>4],
                        "seguridad" => ['cantidad_grupos'=>2,'tamanio_grupos'=>4],
                    ];

                    //mysql
                    $sortByRaw = " FIELD( tipo_caracteristica , '".str_replace(",", "','", implode(",", array_keys($distribucion_columnas_caracteristicas)))."' )  ";

                    //postgres
                    $arrayPostgres= " array[ '".str_replace(",", "','", implode(",", array_keys($distribucion_columnas_caracteristicas)))."' ]  ";

                    $joinRaw = "
					(

						SELECT
						row_number() over() as orden ,
						tipo_caracteristica_b
						from

						/*
						unnest(array['cocina','living_comedor','espacios','seguridad','servicios']) tipo_caracteristica_b
						*/

						unnest( $arrayPostgres ) tipo_caracteristica_b

						) as o
						";

                        $gruposCaracteristicasPropiedades = NGrupoCaracteristicasPropiedades::join(DB::raw($joinRaw), 'o.tipo_caracteristica_b', '=', 'n_grupo_caracteristicas_propiedades.etiqueta')->get();

                        $variables_vista['distribucion_columnas_caracteristicas'] = $distribucion_columnas_caracteristicas;
                        $variables_vista['gruposCaracteristicasPropiedades'] = $gruposCaracteristicasPropiedades;

                        $variables_vista['normas'] = Normas::orderBy('descripcion')->get();
                    }
                    break;
                    case "normas": {
                        // seccion normas se consolido con detalles
                        // $variables_vista['normas'] = Normas::orderBy('descripcion')->get();
                    }
                    break;
                    case "imagenes": {

                        //$variables_vista['cantidad_maxima_imagenes'] = Propiedad::$cantidad_maxima_imagenes;

                        $initialPreviews = [];
                        foreach ($propiedad->imagenes as $imagen) {
                            $initialPreviews[] = [
                                'id' => $imagen->id,
                                'src' => HelperController::getUrlImg($imagen->propiedad->usuario->id, $imagen->ruta, 'sm')
                            ];
                        }
                        $initialPreviews = json_encode($initialPreviews, JSON_UNESCAPED_SLASHES);

                        $variables_vista['initial_previews'] = $initialPreviews;

                    }
                    break;
                    case "administracion": {
                        $variables_vista['conceptos'] = ConceptosCobros::all();
                        $variables_vista['metodoGarantia'] = GarantiaReserva::all();
                        $variables_vista['tipo_oferta'] = OfertasPropiedad::all();
                        $variables_vista['metodos_cobro'] = MetodoCobro::all();
                        $variables_vista['paises'] = Pais::pluck('nombre', 'id');
                    }
                    break;
                }

            if (session('primera_vez') && $seccion == 'calendario') {
                alert()->success('Su propiedad ha sido publicada correctamente, puede editarla para agregar mas fotos y el detalle de las habitaciones', 'Felicitaciones')->persistent('Aceptar');
                session(['primera_vez' => false]);
            }
            return view(
                    "propiedades.partials.edit.$seccion",
                $variables_vista
            );
        }
    }

    public function actualizarResumen($id, PropiedadActualizarResumenRequest $request)
    {
        $success = true;
        $mensaje = "";
        $error = [];
        $borrar = 0;
        $agregar = 0;
        $guardadas = 0;
        $borradas = 0;

        # utilizar bloques try-catch para capturar las excepciones
        DB::beginTransaction();
        try {
            $propiedad = null;
            $propiedad = Propiedad::byUsuario()->byPropiedad($id)->first();

            # asegurarse que un modelo buscado existe antes de realizar
            # operaciones sobre este
            if (count($propiedad) == 1) {
                # asegurarse de insertar valores que existen
                # en tablas con clave foránea
                $tipo_propiedad = TipoPropiedad::find($request->tipo_propiedades_id);
                if (count($tipo_propiedad) != 1) {
                    $tipo_propiedad = TipoPropiedad::first();
                }

                # indicar cada campo a guardar,
                # y para cada caso, un valor deseado por defecto
                $propiedad->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'tipo_propiedades_id' => $tipo_propiedad->id
                ]);

                # inicio modicicacion cantidad de habitaciones
                $nhabitaciones_anterior = $propiedad->detalles->nhabitaciones;
                $nhabitaciones = $request->nhabitaciones ?? 1;
                $guardadas = $propiedad->detalles->distribucionhabitaciones()->count() ;

                if ($guardadas != $nhabitaciones) {
                    if ($guardadas > $nhabitaciones) {
                        $borrar = $guardadas - $nhabitaciones;
                        $borradas = $propiedad->detalles->distribucionhabitaciones()
                        ->orderBy("id", "DESC")->select("id")->take($borrar)->get()->toArray();
                        DistribucionHabitaciones::whereIn("id", $borradas)->delete();
                    }
                    if ($nhabitaciones > $guardadas) {
                        $agregar = $nhabitaciones - $guardadas;
                        while ($agregar > 0) {
                            $propiedad->detalles->distribucionhabitaciones()->create([
                                'camas' 			=> collect(["1"])->flatten(),
                                'tiene_banio' 		=> false,
                                'tiene_tv' 			=> false,
                                'tiene_calefaccion' => false,
                                'descripcion' 		=> '',
                            ]);
                            $agregar--;
                        }
                    }
                }

                //fin modicicacion cantidad de habitaciones

                //al actualizar tablas hijo de un modelo en una relación
                //uno a uno, utilizar el método updateOrCreate, filtrando
                //por el id del padre, así si el hijo no existe, lo crea,
                //y se garantiza que no se actualizará algo que no existe,
                //ni se creará otro registro en caso de ya existir
                $detalle = PropiedadDetalles::updateOrCreate(
                    ['propiedad_id' => $propiedad->id],
                    [
                        'checkin' => $request->checkin ?? '14:00:00',
                        'checkin_estricto' => $request->checkin_estricto ?? '14:00:00',
                        'checkout' => $request->checkout ?? '11:00:00',
                        'superficie' => $request->superficie ?? 1,
                        'nhabitaciones' => $nhabitaciones,
                        'nbanios' => $request->nbanios ?? 1,
                        'estacionamientos' => $request->estacionamientos ?? 1,
                        'capacidad' => $request->capacidad ?? 1,
                    ]
                );
            } else {
                $success = false;
                $mensaje = __('errors.objeto_no_encontrado');
            }
        } catch (\Exception $e) {
            $success = false;
            $mensaje = __('errors.excepcion');
            $error = [get_class($e),$e->getMessage()];
        }

        if ($success) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return response()->json([
            'success' =>  $success,
            'mensaje' =>  $mensaje,
            'error' =>  $error,
            'borrar' =>  $borrar,
            'agregar' =>  $agregar,
            'guardadas' =>  $guardadas,
            'borradas' =>  $borradas,
        ]);
    }

    public function actualizarAdministracion($id, PropiedadActualizarAdministracionRequest $request)
    {
        $propiedad = Propiedad::byUsuario()->byPropiedad($id)->first();

        $success = false;

        //anfitrion
        $propiedad->anfitriones()->delete();
        if ($request->anfitrion == 'otro') {
            $saved = $propiedad->anfitriones()->create($request->only('nombre_anfitrion', 'telefono_anfitrion', 'correo_anfitrion'));
            // $updated->save();
            $success = $saved->exists;
        } else {
            $success = true;
        }

        //conceptos cobro
        if (count($request->concepto_costo)>0) {
            $propiedad->costos()->delete();
            foreach ($request->concepto_costo as $concepto => $valor) {
                // echo "aqui";
                $saved = $propiedad->costos()->create([
                    'conceptos_cobros_id' 	=> $concepto,
                    'valor' 				=> $valor
                ]);
                $success = $saved->exists;
            }
        }

        $metodo_cobro = null;
        switch ($request->medio) {
            case 'transferencia':
            $metodo_cobro = MetodoCobro::find(1);
            break;
            case 'wu':
            $metodo_cobro = MetodoCobro::find(2);
            break;
        }

        if ($request->medio <> 'transferencia' && $request->medio <> 'wu') {
            $usuario_metodo_cobro = Auth::user()->medio_cobro_transferencia->where('id', $request->medio)->first();
            $metodo_cobro = MetodoCobro::find($usuario_metodo_cobro->metodo_cobro_id);
        } else {
            $info_pago = $request->inf_pago;
            $info_pago["metodo_cobro_id"] = $metodo_cobro->id;

            $usuario_metodo_cobro = Auth::user()
            ->medio_cobro_transferencia()
            ->firstOrCreate($info_pago);
        }

        $propiedad->metodosCobroTransferenciaStore()->detach();
        $propiedad->metodosCobroTransferenciaStore()->attach([$usuario_metodo_cobro->id]);

        // $porcentajeComision = $propiedad::$porcentaje_comision;
        // $porcentajeComision = ($request->anfitrion == 'mybooktravel') ? $propiedad::$porcentaje_comision_anfitrion_mybooktravel : $porcentajeComision;
        // return $PorcentajePublicacion;
        $porcentajeComision = $this->PorcentajePublicacion;

        $partes_precio = explode(" ", $request->precio);
        $partes_precio = explode(".", $partes_precio[1]);
        $precio = intval(preg_replace('/[^0-9]+/', '', $partes_precio[0]), 10).".".($partes_precio[1] ?? '00');

        $partes_aseo_unico = explode(" ", $request->aseo_unico);
        $partes_aseo_unico = explode(".", $partes_aseo_unico[1]);
        $aseo_unico = intval(preg_replace('/[^0-9]+/', '', $partes_aseo_unico[0]), 10).".".($partes_aseo_unico[1] ?? '00');

        $suma_valores = $precio ;
        $comision = ($porcentajeComision * $suma_valores) / 100;
        $ingreso_total = $suma_valores - $comision;

        $propiedad->administracion()->update([
            'moneda'					=> $request->moneda_propiedad ?? $propiedad->administracion()->first()->moneda,
            'precio' 					=> $precio,
            'aseo_unico'				=> $aseo_unico,
            'comision' 					=> 0,
            'ingreso_total' 			=> 0,

            'anfitrion' 				=> $request->anfitrion,
            'dias_intervalo' 			=> $request->dias_intervalo ?? 0,
            'noches_minimas' 			=> $request->noches_minimas,
            'reserva_automatica' 		=> ($request->reserva_automatica) ?? false,
            'garantia_reserva_id' 		=> $request->garantia_reserva_id,
            'oferta_propiedad_id' 		=> $request->oferta_propiedad_id,
            'metodo_cobro_id' 			=> $metodo_cobro->id,
        ]);

        return response()->json([
            'success' =>  $success
        ]);
    }

    public function actualizarDetalles($id, PropiedadActualizarDetallesRequest $request)
    {
        $propiedad = Propiedad::byUsuario()->byPropiedad($id)->first();
        $propiedad->caracteristicaStore()->detach();
        $propiedad->detalles->distribucionhabitaciones()->delete();

        //distribucion habitaciones
        foreach (collect($request->dist_habitaciones) as $key => $habitacion) {
            $propiedad->detalles->distribucionhabitaciones()->create([
                'camas' 			=> collect($habitacion['listado_camas'] ?? ["1"])->flatten(),
                'tiene_banio' 		=> (isset($habitacion['tiene_banio'])) ? true : false,
                'tiene_tv' 			=> (isset($habitacion['tiene_tv'])) ? true : false,
                'tiene_calefaccion' => (isset($habitacion['tiene_calefaccion'])) ? true : false,
                'descripcion' 		=> $habitacion['descripcion'],
            ]);
        }

        /*caracteristicas*/
        $propiedad->caracteristicaStore()->attach($request->caracteristica);

        foreach ($request->descripcion_caracteristica as $key => $value) {
            if ($value) {
                $datos = [
                    'n_grupo_caracteristicas_propiedades_id' 	=> $key,
                    'comentario' 								=> $value,
                ];

                $comentario = $propiedad->caracteristicasComentarios()->where('n_grupo_caracteristicas_propiedades_id', $key)->first();
                if (!is_null($comentario)) {
                    $comentario->update($datos);
                } else {
                    $propiedad->caracteristicasComentarios()->create($datos);
                }
            }
        }

        /*normas*/
        $propiedad->normaStore()->detach();
        $propiedad->normaStore()->attach($request->normas);

        if ($request->normas_adicionales) {
            $datos = ['normas' => $request->normas_adicionales,];

            $registro = $propiedad->normasAdicionales()->first();
            if (!is_null($registro)) {
                $registro->update($datos);
            } else {
                $propiedad->normasAdicionales()->create($datos);
            }
        }
        /*fin cambios*/

        return response()->json([
            'success' =>  true
        ]);
    }

    public function actualizarUbicacion($id, PropiedadActualizarUbicacionRequest $request)
    {
        // $pais = Pais::where('iso2', $request->pais)->first();
        $pais = Pais::where('iso2', ($request->pais) ?? 'CL')->first();

        $propiedad = Propiedad::byUsuario()->byPropiedad($id)->first();
        // $propiedad->ubicacion->lugares()->delete();
        //$propiedad->ubicacion()->delete();

        // HelperController::echoPre($request->all());
        // die;

        $propiedad->ubicacion()->update([
            'pais' 					=> $pais->iso2,
            'pais_id' 				=> $pais->id,
            'distrito' 				=> $request->distrito,
            'localidad' 			=> $request->localidad,
            'provincia' 			=> $request->provincia,
            'direccion' 			=> $request->direccion,
            'longitud' 				=> $request->longitud,
            'latitud' 				=> $request->latitud,
            'zona_descripcion'		=> $request->zona_descripcion,
            'como_llegar'			=> $request->como_llegar,
        ]);



        return response()->json([
            'success' =>  true
        ]);
    }

    public function actualizarNormas($id, Request $request)
    {
        die("en desuso, diseño pidio que las normas quedaran en la seccion de detalles como al crear la propiedad");

        $propiedad = Propiedad::byUsuario()->byPropiedad($id)->first();
        $propiedad->normas()->delete();

        // HelperController::echoPre($request->all());
        // die;

        if (count($request->normas)>0) {
            $propiedad->normas()->firstOrCreate([
            'normas' 	=> json_encode($request->normas),
            'tipo' 		=> 'basicas',
        ]);
        }

        if ($request->normas_adicionales) {
            $propiedad->normas()->firstOrCreate([
            'normas' 	=> $request->normas_adicionales,
            'tipo' 		=> 'adicionales',
        ]);
        }

        return response()->json([
            'success' =>  true
        ]);
    }

    public function deleteUpload(Request $request)
    {
        return $filename = $request->id;

        if (!$filename) {
            return 0;
        }

        $response = $this->image->delete($filename);
        return $response;
    }


    public function buscar(Request $request)
    {
        $resultado  = $request->destino_busqueda ?? '';
        $resultado .= $request->localidad ? ' / '.$request->localidad : '';
        $resultado .= $request->distrito ? ' / '.$request->distrito : '';
        $resultado .= $request->provincia ? ' / '.$request->provincia : '';



        Meta::set('title', 'Mybooktravel | Busqueda en '. $resultado);
        Meta::set('description', 'Alquileres vacacionales casas, departamentos, cabañas | Chile, Viña del Mar, Concon, La Serena, Pucon');


        $tipo_propiedades_id = is_null($request->input('tipo_propiedades_id')) ? [] : [$request->input('tipo_propiedades_id')] ;
        $total_adultos = ($request->total_adultos) ?? 1;
        $total_ninos = ($request->total_ninos) ?? 0;
        $capacidad = $total_adultos + $total_ninos;
        $mensajes = collect();
        $mensaje = "";
        $i=0;
        $reserva_inmediata = (isset($request->reserva_inmediata) && $request->reserva_inmediata == 'true')  ? 1: 0;
        $checkbox_caracteristica_propiedad = is_null($request->input('checkbox_caracteristica_propiedad')) ? [] : $request->input('checkbox_caracteristica_propiedad') ;

        if (!is_null($request->latitud) && !is_null($request->longitud)) {
            # --------------------
            #
            # FORMULA DE HAVERSINE
            #
            # --------------------

            $lat 	= $request->latitud;
            $lng 	= $request->longitud;
            $tipo 	= explode(",", $request->tipo);

            $distancia = 6500;
            $distancia = collect($tipo)->contains('route') ? 1 : $distancia ;
            $distancia = collect($tipo)->contains('street_address') ? 4 : $distancia ;
            $distancia = collect($tipo)->contains('establishment') ? 25 : $distancia ;
            $distancia = collect($tipo)->contains('natural_feature') ? 50 : $distancia ;

            $distancia = collect($tipo)->contains('locality') ? 50 : $distancia ;
            $distancia = collect($tipo)->contains('administrative_area_level_2') ? 1000 : $distancia ;
            $distancia = collect($tipo)->contains('administrative_area_level_1') ? 2000 : $distancia ;
            $distancia = collect($tipo)->contains('country') ? 6500 : $distancia ;

            if ($request->min_lat != "" && $request->max_lat != "" && $request->min_lng != "" && $request->max_lng != "") {
                //die("nuevo");
                $box['min_lat'] = $request->min_lat;
                $box['min_lng'] = $request->min_lng;
                $box['max_lat'] = $request->max_lat;
                $box['max_lng'] = $request->max_lng;
            } else {
                //("normal");
                $box = getBoundaries($lat, $lng, $distancia);
                //return $box;
            }

            $pais_data = Pais::where('iso2', $request->pais ?? 'CL')->first();
            $haversineCalculo = '(6371 * ACOS(COS(RADIANS('.$lat.')) * COS(RADIANS(propiedades_ubicaciones.latitud)) * COS(RADIANS(propiedades_ubicaciones.longitud) - RADIANS('.$lng.')) + SIN(RADIANS('.$lat.')) *  SIN(RADIANS(propiedades_ubicaciones.latitud))))';

            $propiedades = Propiedad::join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id')
        ->join('propiedades_detalles', 'propiedades_detalles.propiedad_id', '=', 'propiedades.id')
        #->join('propiedades_administracion', 'propiedades_administracion.propiedad_id', '=', 'propiedades.id')
        ->whereBetween('propiedades_ubicaciones.latitud', [$box['min_lat'], $box['max_lat']])
        ->whereBetween('propiedades_ubicaciones.longitud', [$box['min_lng'], $box['max_lng']])
        ->whereRaw($haversineCalculo.' < '. $distancia)
        ->where('propiedades_ubicaciones.pais_id', $pais_data->id)
        ->select('propiedades.*')
        ->has('imagenes')
        ->orderByRaw($haversineCalculo);

            //return $propiedades->count();

            if (in_array('administrative_area_level_1', $tipo) && isset($request->provincia) && $request->provincia != "") {
                $propiedades = $propiedades->where('propiedades_ubicaciones.provincia', '=', $request->provincia);
            }
            if (collect($tipo)->contains('administrative_area_level_2') && isset($request->distrito) && $request->distrito != "") {
                $propiedades = $propiedades->where('propiedades_ubicaciones.distrito', $request->distrito);
            }
            if (in_array('locality', $tipo) && isset($request->localidad) && $request->localidad != "") {
                $propiedades = $propiedades->where('propiedades_ubicaciones.localidad', '=', $request->localidad);
            }
        } else {
            $propiedades = Propiedad::join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id')
        ->join('propiedades_detalles', 'propiedades_detalles.propiedad_id', '=', 'propiedades.id')
        # ->join('propiedades_administracion', 'propiedades_administracion.propiedad_id', '=', 'propiedades.id')
        ->select('propiedades.*');
        }

        if (isset($request->fecha_entrada) && !empty($request->fecha_entrada) && isset($request->fecha_salida) && !empty($request->fecha_salida)) {
            $fecha_entrada = Carbon::parse($request->fecha_entrada)->format('Y-m-d');
            $fecha_salida = Carbon::parse($request->fecha_salida)->format('Y-m-d');

            $propiedades = $propiedades->ByDisponible($fecha_entrada, $fecha_salida);
            /*
            $propiedades->join(DB::raw("(SELECT p.id as propiedad_id, generate_series(date '$fecha_entrada', date '$fecha_salida', '1 day')::date as fecha, pa.precio from propiedades p INNER JOIN propiedades_administracion pa ON pa.propiedad_id = p.id ) generales"), function($join)
            {
                $join->on('propiedades.id', '=', 'generales.propiedad_id');
            });
            $propiedades->leftJoin(DB::raw("( SELECT pe.propiedad_id, generate_series(pe.fecha_inicio::date, ( to_char(pe.fecha_fin,'YYYY-MM-DD' )::timestamp - interval '1 second' )::date , '1 day')::date as fecha, pe.precio FROM public.propiedades_precios_especificos pe where CASE WHEN ( ( pe.fecha_inicio BETWEEN '$fecha_entrada' AND '$fecha_salida' ) OR ( pe.fecha_fin BETWEEN '$fecha_entrada' AND '$fecha_salida' ) OR ( '$fecha_entrada' BETWEEN pe.fecha_inicio AND pe.fecha_fin ) OR ( '$fecha_salida' BETWEEN pe.fecha_inicio AND pe.fecha_fin ) ) THEN true ELSE false END) especificos"), function($join)
            {
                $join->on('especificos.fecha', '=', 'generales.fecha');
            });
            $propiedades->select('propiedades.*');
            $propiedades->selectRaw('AVG(CASE WHEN especificos.precio IS NOT NULL THEN especificos.precio ELSE generales.precio END) AS precio_real');
            */
            $propiedades->groupBy('propiedades.id');
            # $propiedades->groupBy('propiedades_precios_especificos.precio');
            # $propiedades->groupBy('propiedades_administracion.precio');
            $propiedades->groupBy('propiedades_ubicaciones.latitud');
            $propiedades->groupBy('propiedades_ubicaciones.longitud');
        }


        /*
        return HelperController::getRealSqlQuery($propiedades);
        return $prueba->get();
        die;
        */
        if ($request->precio_minimo && $request->precio_maximo) {
            $propiedades = $propiedades->whereBetween("precio", [$request->precio_minimo, $request->precio_maximo]);
        }

        if (count($tipo_propiedades_id) > 0) {
            $propiedades = $propiedades->whereIn('tipo_propiedades_id', $tipo_propiedades_id);

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
                $string_tipos_propiedad .= "<span>".$tipos_propiedad[$i]["descripcion"]."</span>";
                $i++;
            }
            $mensajes->push($string_tipos_propiedad);
        }

        # return HelperController::getRealSqlQuery($propiedades);

        if ($capacidad != "" && is_numeric($capacidad)) {
            $propiedades = $propiedades->where('propiedades_detalles.capacidad', '>=', $capacidad);
            $mensajes->push("Capacidad para <span>".$capacidad."</span> persona".($capacidad>1?"s":""));
        }

        if ($reserva_inmediata == 1) {
            // echo "reserva inmediata";
            $propiedades = $propiedades->where('propiedades_administracion.reserva_automatica', true);
            $mensajes->push("<span>Reserva inmediata</span>");
        }

        if (count($checkbox_caracteristica_propiedad) > 0) {
            $propiedades = $propiedades->whereIn('propiedades_caracteristicas.caracteristica_propiedad_id', $checkbox_caracteristica_propiedad);
        }

        # --------------------------------------------
        # FALTA EL FILTRO DE RANGO DE PRECIOS
        # --------------------------------------------

        if (isset($request->fecha_entrada) && !empty($request->fecha_entrada) && isset($request->fecha_salida) && !empty($request->fecha_salida)) {
            $mensajes->push("Del <span>".Carbon::parse($fecha_entrada)->format('d-m-Y')."</span> al <span>".Carbon::parse($fecha_salida)->format('d-m-Y')."</span>");
        }

        $mensajes->prepend("Total <span>".$propiedades->count()."</span>");

        while (isset($mensajes[$i])) {
            if ($i!=0) {
                $mensaje.=", ";
            }
            $mensaje.= $mensajes[$i];
            $i++;
        }
        // $query = HelperController::getRealSqlQuery($propiedades);
        $propiedades = $propiedades->paginate(18);





        $categorias = TipoPropiedad::pluck('descripcion', 'id');
        $tipos_propiedad = TipoPropiedad::activos()->pluck('descripcion', 'id');
        $caracteristicas_propiedad = CaracteristicaPropiedad::all();

        $data_para_la_vista = [
        'request' 					=> $request,
        'propiedades' 				=> $propiedades,
        'mensaje' 					=> $mensaje,
        'categorias' 				=> $categorias,
        'localidad' 				=> $request->input('localidad'),
        'tipos_propiedad'			=> $tipos_propiedad,
        'caracteristicas_propiedad'	=> $caracteristicas_propiedad,
        // 'query'	=> $query
    ];


        if ($request->ajax()) {
            $html = \View::make('propiedades.partials.preview_list', $data_para_la_vista)->render();

            return response()->json(['html' =>  $html,'mensaje' => $mensaje, "cantidad"=>$propiedades->count()]);
        } else {
            return view('propiedades.listado', $data_para_la_vista);
        }
    }

    public function busquedaAvanzada(Request $request)
    {
        $propiedades = Propiedad::busquedaAvanzada($request);

        //variables para armar los filtros de filtro.blade
        $tipos_propiedad = TipoPropiedad::activos()->pluck('descripcion', 'id');
        $caracteristicas_propiedad = CaracteristicaPropiedad::all();

        $html = \View::make('propiedades.partials.preview_list', [
            'propiedades' 				=> $propiedades["propiedades"],
            'mensaje' 					=> $propiedades["mensaje"],
            'request' 					=> $request,
            'localidad'					=> $request->input('localidad'),
            'tipos_propiedad'			=> $tipos_propiedad,
            'caracteristicas_propiedad'	=> $caracteristicas_propiedad,
        ])->render();

        return response()->json(['html' =>  $html,'mensaje' => $propiedades["mensaje"]]);
    }
}
