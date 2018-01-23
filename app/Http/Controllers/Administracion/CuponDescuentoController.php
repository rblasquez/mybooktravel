<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;

//models
use App\Pais;
use App\Models\Administracion\NModoAplicacionDescuento;
use App\Models\Administracion\DCampaniaCuponDescuento;
use App\Models\Administracion\DCuponDescuento;
use App\Propiedad;
use App\User;

//requests
use App\Http\Requests\Administracion\StoreCuponDescuentoRequest;
use App\Http\Requests\Administracion\ListCuponDescuentoRequest;

//mail
use Illuminate\Support\Facades\Mail;
use App\Mail\Administracion\CuponesDescuento\CuponPorRegistro;

class CuponDescuentoController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view("administracion.cupon_descuento.index");
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('administracion.cupon_descuento.create',[
      "action" => "create",
      "monedas" => Pais::whereIn('moneda',['ARS','CLP'])->pluck('moneda','moneda'),
      "modos_aplicacion_descuento" => NModoAplicacionDescuento::all()->pluck('descripcion','id'),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCuponDescuentoRequest $request)
  {
    $success = true;
		$modelo = null;
		$excepcion = null;

		DB::beginTransaction();
		try
		{

      $fecha_inicio = \DateTime::createFromFormat('d/m/Y', $request->fecha_inicio);
      $fecha_inicio = $fecha_inicio->format('Y-m-d');

      $fecha_fin = \DateTime::createFromFormat('d/m/Y', $request->fecha_fin);
      $fecha_fin = $fecha_fin->format('Y-m-d');

			$modelo = DCampaniaCuponDescuento::create([
				"titulo" => $request->titulo,
				"descripcion" => $request->descripcion,
				"moneda" => $request->moneda,
				"n_modo_aplicacion_descuento_id" => $request->n_modo_aplicacion_descuento_id,
				"valor" => $request->valor,
				"fecha_inicio" => $fecha_inicio,
				"fecha_fin" => $fecha_fin,
				"noches_minimas" => $request->noches_minimas,
        "cantidad" => $request->cantidad,

        "lat" => $request->lat,
        "lng" => $request->lng,
				"lat_max" => $request->lat_max,
				"lat_min" => $request->lat_min,
				"lng_max" => $request->lng_max,
				"lng_min" => $request->lng_min,

        "usuario_id" => Auth::id()
			]);

      $cantidad = $request->cantidad;
      while($cantidad > 0)
      {
        CuponDescuentoController::agregarCuponACampania($modelo);
        $cantidad--;
      }

		}
		catch (\Exception $e)
		{
			$success = false;
			$excepcion = [get_class($e),$e->getMessage()];
		}

		if($success)
		{
			DB::commit();
			return response()->json(['modelo' => $modelo ]);
		}
		else
		{
			DB::rollBack();
			return response()->json(['errors' =>
				["submit"=>["Ha ocurrido un algo inusual"]],
				"excepcion" => $excepcion
			], 422);
		}
  }

  public static function agregarCuponACampania(DCampaniaCuponDescuento $campania)
  {
    $cupon = new DCuponDescuento([
      'codigo' => strtoupper(substr( md5(microtime()), 1, 20)),
      'n_estatus_cupon_descuento_id' => 1
    ]);

    $campania->cupones()->save($cupon);

    return $cupon;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $modelo = DCampaniaCuponDescuento::find($id);

    return view('administracion.cupon_descuento.show',[
      "modelo" => $modelo
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  //custom methods
  public function list(ListCuponDescuentoRequest $request)
  {
    $modelos = DCampaniaCuponDescuento::where('titulo','ilike',"%$request->titulo%")->get();

    return view('administracion.cupon_descuento.list',[
      'modelos'=>$modelos
    ]);
  }

  public static function verificarAplicacionCupon(Propiedad $propiedad,$fecha_inicio, $fecha_fin,$codigo_cupon)
  {

    $valido = false;
    $mensaje = '';
    $cupon = null;
    // $tests= null;

    $cupon = DCuponDescuento::byCodigo($codigo_cupon)->first();

    if(!$cupon)
    {
      $valido = false;
      $mensaje = 'Cupón no hallado';
    }
    else
    {
      if($cupon->estatus->id == 2)
      {
        $valido = false;
        $mensaje = 'Cupón vencido';
      }
      if($cupon->estatus->id == 3)
      {
        $valido = false;
        $mensaje = 'Cupón usado';
      }
      if($cupon->estatus->id == 1)
      {

        $formato = 'd-m-Y';
        $fecha_inicio_cupon = \Carbon\Carbon::parse($cupon->campania->fecha_inicio)->format($formato);
        $fecha_fin_cupon = \Carbon\Carbon::parse($cupon->campania->fecha_fin)->format($formato);

        $intervalo_contenido = CuponDescuentoController::intervaloFechaContenido($fecha_inicio_cupon,$fecha_fin_cupon,$fecha_inicio,$fecha_fin);
        if(!$intervalo_contenido)
        {
          $valido = false;
          $mensaje = 'El Cupón no es válido para las fechas indicadas';
        }
        else
        {

          $dias_a_reservar = CuponDescuentoController::diasEntreDosFechas($fecha_inicio, $fecha_fin);

          if($dias_a_reservar < $cupon->campania->noches_minimas)
          {

            $valido = false;
            $mensaje = 'El Cupón no es válido para estadías inferiores a '.$cupon->campania->noches_minimas.' noches';

          }
          else
          {

            $lat = $propiedad->ubicacion->latitud;
            $lng = $propiedad->ubicacion->longitud;
            $lat_min = $cupon->campania->lat_min;
            $lat_max = $cupon->campania->lat_max;
            $lng_min = $cupon->campania->lng_min;
            $lng_max = $cupon->campania->lng_max;

            $puntoGeograficoContenido = CuponDescuentoController::puntoGeograficoContenido($lat,$lng,$lat_min,$lat_max,$lng_min,$lng_max);

            if(!$puntoGeograficoContenido)
            {
              $valido = false;
              $mensaje = 'El Cupón no es válido para la ubicación de la propiedad';
            }
            else
            {

              $valido = true;
              $mensaje = 'El Cupón puede ser aplicado en la reserva';

              // $tests = [
              //   'dias_calculados' => $dias_a_reservar,
              //   'noches_minimas' => $cupon->campania->noches_minimas,
              //   'fecha_inicio' => $fecha_inicio_cupon,
              //   'fecha_fin' => $fecha_fin_cupon,
              //   'intervalo_contenido' => $intervalo_contenido ? 'si' : 'no',
              //   'latitud' => $lat,
              //   'longitud' => $lng,
              //   'puntoGeograficoContenido' => $puntoGeograficoContenido ? 'si' : 'no',
              // ];

            }

          }

        }

      }

    }

    return [
      'valido' => $valido,
      'mensaje' => $mensaje,
      // 'tests' => $tests,
      'cupon' => $cupon,
    ];

  }

  public static function obtenerMontoDescuentoCupon(Propiedad $propiedad, $fecha_inicio_reserva, $fecha_fin_reserva, $codigoCupon,$moneda_reserva,$monto_reserva)
  {

    $verificacionCupon = CuponDescuentoController::verificarAplicacionCupon($propiedad, $fecha_inicio_reserva, $fecha_fin_reserva, $codigoCupon);
    $monto_descuento = 0;

    if($verificacionCupon['valido'])
    {

      $cupon = $verificacionCupon['cupon'];
      $campania = $cupon->campania;
      // $monto_descuento = 0;

      if($campania->modoAplicacion->id == 1)//monto fijo
      {
        $monto_descuento = $campania->moneda == $moneda_reserva ? $campania->valor : cambioMoneda($campania->valor,$campania->moneda,$moneda_reserva);
      }
      if($campania->modoAplicacion->id == 2)//porcentaje
      {
        $monto_descuento = ( $monto_reserva / 100 ) * $campania->valor;
      }


    }

    $verificacionCupon['monto_descuento'] = $monto_descuento;

    return $verificacionCupon;

  }

  public static function crearCuponPorRegistrarse(User $usuario)
  {
    $cupon = null;
    if( $usuario->pais->iso2 == 'AR' )
    {
      $campania = DCampaniaCuponDescuento::where('titulo','descuento_por_registro')->first();
      $cupon = CuponDescuentoController::agregarCuponACampania($campania);

      //se genera la imagen del cupon
      // create Image from file
  		$img = Image::make('img/cupon_descuento/correo.jpg');

  		// write text
  		$img->text($cupon->codigo_formateado, 190, 287, function($font) {
  			$font->file('fonts/maven_pro/MavenPro-Bold.ttf');
  			$font->size(15);
  			$font->color('#000000');
  		});

  		// save the same file as jpg with default quality
      $image_path = 'img/cupon_descuento/'.$cupon->codigo.'.jpg';
  		$img->save($image_path);

      //envio el cupon por correo
      Mail::to($usuario->email)->send(new CuponPorRegistro($usuario,$cupon));

      //se elimina la imagen del cupon
      unlink($image_path);

    }
    return $cupon;
  }

  public static function diasEntreDosFechas($fecha_inicio, $fecha_fin)
  {
    $fecha_inicio = strtotime($fecha_inicio);
    $fecha_fin = strtotime($fecha_fin);
    // date('d/m/Y', $fecha_inicio)//esto es un objeto fecha
    $dias = ($fecha_fin - $fecha_inicio) / (60 * 60 * 24);
    return $dias;
  }

  public static function intervaloFechaContenido($fecha_inicio_a,$fecha_fin_a,$fecha_inicio_b,$fecha_fin_b)
  {

    //toda dos intervalos de fechas en formato d-m-Y, ejemplo: 07-04-1988
    //verifica si el intervalo b está contenido en el intervalo a
    //de manera inclusiva en los extremos

    $timestamp_inicio_a = strtotime($fecha_inicio_a);
    $timestamp_fin_a = strtotime($fecha_fin_a);
    $timestamp_inicio_b = strtotime($fecha_inicio_b);
    $timestamp_fin_b = strtotime($fecha_fin_b);

    return ( $timestamp_inicio_a <= $timestamp_inicio_b && $timestamp_fin_b <= $timestamp_fin_a );

  }

  public static function puntoGeograficoContenido($lat,$lng,$lat_min,$lat_max,$lng_min,$lng_max)
  {
    //verifica si una latitud y una longitud está contenida dentro de un rectangulo de área geográfica
    //el rectangulo está formado por 2 puntos
    // nor-este = lat_max, lng_max y suroeste = lat_max, lng_max
    return ( CuponDescuentoController::numeroEnIntervalo($lat, $lat_min, $lat_max) && CuponDescuentoController::numeroEnIntervalo($lng, $lng_min, $lng_max) );
  }

  public static function numeroEnIntervalo($value, $min, $max, $inclusive_of_start = true, $inclusive_of_end = true)
  {
    //compara si el $value está entre el $min y $max
    //recibe parametros adicionales para incluir o no los extremos
    $start_comparison = ( $inclusive_of_start ? $min <= $value : $min < $value );
    $end_comparison = ( $inclusive_of_end ? $value <= $max : $value < $max );
    return $start_comparison && $end_comparison;
  }

}
