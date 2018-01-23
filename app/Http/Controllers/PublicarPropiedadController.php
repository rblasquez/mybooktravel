<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TipoPropiedad;
use App\TipoCama;
use App\Normas;
use App\CaracteristicaPropiedad;
use App\NGrupoCaracteristicasPropiedades;
use App\ConceptosCobros;
use App\GarantiaReserva;
use App\OfertasPropiedad;
use App\MetodoCobro;
use App\Pais;

# Con estos modelos creo una nueva propiedad
use App\Propiedad;
use App\PropiedadDetalles;
use App\DPropiedadesCaracteristicasComentarios;
use App\DistribucionHabitaciones;
use App\PropiedadNormasPersonal;
use App\PropiedadConceptosCobros;
use App\PropiedadAdministracion;
# ---------------------------------------------

use Auth;

class PublicarPropiedadController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create()
	{

		return view('pruebas', [
			'categorias' 		=> TipoPropiedad::pluck('descripcion', 'id'),
			'tipo_cama'			=> TipoCama::pluck('descripcion', 'id'),
			'normas'			=> Normas::all(),
			'caracteristicas'	=> CaracteristicaPropiedad::all(),
			'gruposCaracteristicasPropiedades'	=> NGrupoCaracteristicasPropiedades::all(),
			'conceptos'			=> ConceptosCobros::all(),
			'metodoGarantia'	=> GarantiaReserva::all(),
			'tipo_oferta'		=> OfertasPropiedad::all(),
			'metodos_cobro'		=> MetodoCobro::all(),
			'paises'			=> Pais::pluck('nombre', 'id'),
		]);
	}

	public function resumen(Request $request)
	{
		return response()->json('success');
		return $request->all();
		$usuario = Auth::user();
		
		# Determino la información básica de la propiedad
		$propiedad 							= new Propiedad;
		$propiedad->nombre 					= $request->nombre;
		$propiedad->descripcion 			= $request->descripcion;
		$propiedad->tipo_propiedades_id 	= $request->tipo_propiedades_id;
		$propiedad->estatus_propiedad_id 	= 7;
        # Asocio la propiedad al usuario
		$usuario->propiedades()->save($propiedad);

		# Determino los detalles de la propiedad
		$detalles 						= new PropiedadDetalles;
		$detalles->checkin 				= $request->checkin ?? '14:00';
		$detalles->checkin_estricto 	= $request->checkin_estricto ?? null;
		$detalles->checkout 			= $request->checkout ?? '11:00';
		$detalles->superficie 			= $request->superficie ?? 0;
		$detalles->nhabitaciones 		= $request->nhabitaciones ?? 1;
		$detalles->nbanios 				= $request->nbanios ?? 1;
		$detalles->estacionamientos 	= $request->estacionamientos ?? 0;
		$detalles->capacidad 			= $request->capacidad ?? 1;
		# Asocio los detalles a la propiedad
		$propiedad->detalles()->save($detalles);

		if ($propiedad && $detalles) {
			return response()->json(['status' => 'success', 'propiedad' => $propiedad->id]);
		}
	}
}
