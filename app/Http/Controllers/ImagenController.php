<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

//controllers
use App\Http\Controllers\HelperController;

//models
use App\User;
use App\Propiedad;
use App\PropiedadImagen;
use App\DImagenesTemporales;

class ImagenController extends Controller
{
	const DISK = 'minio';
	const FORMAT = 'jpg';
	public function __construct()
	{
		parent::__construct();
		$this->middleware('auth')->only([
			'imagenesTemporales',
			'eliminarTemporales',
			'actualizarAgregarImagenes',
			'actualizarEliminarImagen',
			'actualizarAsignarImagenPrimaria',
			'obtenerCarruselImagenes',
		]);
	}

	public function imagenesTemporales(Request $request)
	{
		$file = $request->image;
		if ($file) {
			$archivo = ImagenController::addWaterMark($file);
			if ($archivo) {
				# $rutaArchivo = HelperController::getUrlImg(Auth::user()->id, $archivo, 'sm');
				$img = new DImagenesTemporales;
				$img->ruta = $archivo;
				$img->token = csrf_token();
				Auth::user()->imagenesTemporales()->save($img);
				return response()->json(['success' =>  true, 'id_imagen' =>  $archivo ]);
			}else{
				return response()->json(['success' =>  false]);
			}
		}
		return response()->json(['success' =>  false]);
	}

	public function rotarTemporales($archivo, $sentido)
	{
		$disco = Storage::disk(self::DISK);
		$carpeta_usuario = 'alojamientos/usuario_'.Auth::user()->id;
		$carpetas_imagenes_usuario = $disco->directories($carpeta_usuario);
		$carpeta_imagen = $carpeta_usuario."/".$archivo;

		if (in_array($carpeta_imagen,$carpetas_imagenes_usuario))
		{
			$archivos = $disco->files($carpeta_imagen);
			foreach ($archivos as $file)
			{
				$nombre = (explode(".",basename($file)))[0];
				if($nombre == "base")
				{

					$grados = $sentido == 'derecha' ? -90 : 90 ;
					$ruta_imagen_original = $disco->get($file);

					$temporal_image = Image::make($ruta_imagen_original);
					$temporal_image->rotate($grados);

					$base64Image = (string)$temporal_image->encode('data-url');

					$rutaNuevaImagen = ImagenController::addWaterMark($base64Image);

					$imagen = DImagenesTemporales::where('ruta', $archivo)->update(['ruta' => $rutaNuevaImagen]);

					$ruta = 'alojamientos/usuario_'.Auth::user()->id.'/'.$rutaNuevaImagen.'/sm.jpg';

					$imagenGuardada = collect(['id' => $rutaNuevaImagen, 'url' => HelperController::getUrlImg(Auth::user()->id, $rutaNuevaImagen, 'sm')]);
					// $imagenGuardada = collect(['id' => $rutaNuevaImagen, 'url' => asset('storage/'.$ruta)]);


					return response()->json([
						'success' =>  true,
						'imagen' =>  $imagenGuardada,
					]);

				}
			}
		}else{
			echo 'no';
		}
	}

	public function eliminarTemporales($archivo)
	{
		Storage::disk(self::DISK)->deleteDirectory('alojamientos/usuario_'.Auth::user()->id.'/'.$archivo);
		$imagen = DImagenesTemporales::where('ruta', $archivo)->delete();
		if ($imagen) {
			return response()->json(['estatus' => 'success']);
		}else{
			return response()->json(['estatus' => 'error']);
		}
	}

	public function actualizarAgregarImagenes(Request $request, $id)
	{
		$propiedad = Propiedad::find($id);
		$cantidad = $propiedad->imagenes()->count();

		$files = $request->galeria;

		$primera = $propiedad->imagenes()->where('primaria', true)->count();

		$count = 0;

		if (count($files)>0) {
			$imagenes = collect();
			$rutas = collect();
			foreach($files as $key => $file){
				$archivo = ImagenController::addWaterMark($file);

				$img = new PropiedadImagen;
				$img->primaria = ($key == 0 && $primera == 0) ? true : false;
				$img->ruta = $archivo;
				$imagen = $propiedad->imagenes()->save($img);
			}
		}


		$success = true;

		return response()->json([
			'success' =>  $success
		]);

	}

	public function actualizarAgregarImagenesNew(Request $request, $id)
	{

		$success = false;

		$imagen_a_guardar = $request->image;
		if($imagen_a_guardar != "")
		{

			$propiedad = Propiedad::find($id);
			// $cantidad = $propiedad->imagenes()->count();

			$guardadas = $propiedad->imagenes()->count();
			if($guardadas < $this->CantidadMaximaImagenesPorPropiedad)
			{
				$primera = $propiedad->imagenes()->where('primaria', true)->count();

				$archivo = ImagenController::addWaterMark($imagen_a_guardar);

				$img = new PropiedadImagen;
				$img->primaria = ($primera == 0) ? true : false;
				$img->ruta = $archivo;

				$imagen = $propiedad->imagenes()->save($img);

				return response()->json([
					'success' =>  true,
					'id_imagen' =>  $imagen->id,
				]);

			}


		}

		return response()->json([
			'success' =>  false,
		]);

	}

	public function rotarImagen(Request $request)
	{
		// echo "llego";

		$imagenOriginal = PropiedadImagen::where('id', $request->id_imagen)->first();

		if($imagenOriginal)
		{

			$propiedad = $imagenOriginal->propiedad;
			$usuario_id = $imagenOriginal->propiedad->usuario->id;
			$carpeta_usuario = "alojamientos/usuario_$usuario_id";

			$primera = $propiedad->imagenes()->where('primaria', true)
			->where("id","<>",$imagenOriginal->id)->count();

			$disco = Storage::disk('minio');

			$carpetas_imagenes_usuario = $disco->directories($carpeta_usuario);
			$carpeta_imagen = $carpeta_usuario."/".$imagenOriginal->ruta;

			//se verifica si existe el directorio de la imagen
			if ( in_array($carpeta_imagen,$carpetas_imagenes_usuario) )
			{
				//se obtiene el nombre del archivo base
				//$files = Storage::files($imagen->ruta);

				$archivos = $disco->files($carpeta_imagen);
				foreach ($archivos as $archivo)
				{
					$nombre = (explode(".",basename($archivo)))[0];
					if($nombre == "base")
					{

						$grados = $request->sentido == 'derecha' ? -90 : 90 ;

						$ruta_imagen_original = $disco->url($archivo);
						$temporal_image = Image::make($ruta_imagen_original);
						$temporal_image->rotate($grados);

						$base64Image = (string)$temporal_image->encode('data-url');

						$rutaNuevaImagen = ImagenController::addWaterMark($base64Image);

						$objImg = new PropiedadImagen;
						$objImg->primaria = ($primera == 0) ? true : false;
						$objImg->ruta = $rutaNuevaImagen;

						$imagenGuardada = $propiedad->imagenes()->save($objImg);
						$imagenGuardada->url = HelperController::getUrlImg($usuario_id, $imagenGuardada->ruta, 'sm');

						return response()->json([
							'success' =>  true,
							'imagen' =>  $imagenGuardada,
						]);
					}
				}
			}
		}

		return response()->json([
			'success' =>  false,
		]);

	}

	public function actualizarEliminarImagen($id, Request $request)
	{
		$propiedad = Propiedad::byUsuario()->find($id);

		$eliminada_storage = null;
		$eliminada_database = null;

		if($propiedad)
		{
			$imagen_hallada = $propiedad->imagenes()->where('id', $request->id_imagen)->get();

			if($imagen_hallada)
			{
				$disco = Storage::disk('minio');
				foreach($imagen_hallada as $imagen)
				{
					if ($disco->exists($imagen->ruta)) {
						$eliminada_storage = $disco->delete($imagen->ruta);
					}else{
						$disco->deleteDirectory('alojamientos/usuario_' . $propiedad->usuario->id .'/'. $imagen->ruta);
						$eliminada_storage = true;
					}
					$eliminada_database = $imagen->delete();
				}

				if ($imagen_hallada->contains('primaria', true)) {
					$nueva_primaria = $propiedad->imagenes()->first();
					if($nueva_primaria)$nueva_primaria->update(['primaria'=>true]);
				}
			}
		}

		$success = ($eliminada_storage && $eliminada_database) ? true : false;

		return response()->json([
			'success' =>  $success
		]);

	}

	public function actualizarAsignarImagenPrimaria($id, Request $request)
	{
		$success = false;
		if(is_numeric($id) && is_numeric($request->id_imagen))
		{
			$propiedad = Propiedad::byUsuario()->find($id);
			if(count($propiedad) > 0)
			{
				$propiedad->imagenes()->update(['primaria'=>false]);
				$propiedad->imagenes()->where('id',$request->id_imagen)->update(['primaria'=>true]);
				$success = true;
			}
		}

		return response()->json([
			'success' =>  $success
		]);
	}

	public function obtenerCarruselImagenes($id)
	{
		$propiedad = Propiedad::byUsuario()->byPropiedad($id)->first();
		$imagenes = $propiedad->imagenes()->get();

		$html = \View::make('propiedades.partials.carruselgaleria',
			[
				'propiedad' => $propiedad
			]
		)->render();

		return response()->json([
			'html' =>  $html,
			'imagenes_guardadas' => $propiedad->imagenes()->count()
		]);
	}

	public static function addWaterMark($file)
	{
		if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $file, $matches)) {
			$extension 	= $matches[1];
			$file 		= base64_decode($matches[2]);
			$tipo 		= 'string';
		}else{
			$fileName 	= $file->getClientOriginalName();
			$extension 	= strtolower(collect(explode(".",  $fileName))->last());
			$extension 	= ($extension == 'blob') ? 'jpeg' : $extension ;
			$tipo 		= 'file';
		}
		$disco = Storage::disk(self::DISK);
		$imgage_format = self::FORMAT;

		$size = ($tipo == 'string') ? getimagesizefromstring($file) : getimagesize($file);

		$temporal_image = Image::make($file);
		$watermark_image = Image::make('img/watermark.png');

		$width = 20 * $size[0] / 100;

		$watermark_image->resize(round($width), null, function ($constraint) {
			$constraint->aspectRatio();
		});
		$image_original = Image::make($file);
		$image_original->resize(null, 720, function ($constraint) {
			$constraint->aspectRatio();
		})
		->stream()
		->detach();

		$image_large = Image::make($file);
		$image_large->orientate()
		->insert($watermark_image, 'bottom-right', 20, 10)
		->resize(null, 720, function ($constraint) {
			$constraint->aspectRatio();
		})
		->encode($imgage_format)
		->stream()
		->detach();

		$image_medium = Image::make($file);
		$image_medium->orientate()
		->resize(null, 480, function ($constraint) {
			$constraint->aspectRatio();
		})
		->encode($imgage_format)
		->stream()
		->detach();

		$image_small = Image::make($file);
		$image_small->orientate()
		->resize(null, 300, function ($constraint) {
			$constraint->aspectRatio();
		})
		->encode($imgage_format)
		->stream()
		->detach();

		$carpeta = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10).md5(date('YmdHis'));

		$image_original_save 	= $disco->put('alojamientos/usuario_'.Auth::user()->id.'/'.$carpeta.'/base.'.$extension, $image_original->__toString());
		$image_large_save 		= $disco->put('alojamientos/usuario_'.Auth::user()->id.'/'.$carpeta.'/lg.'.$imgage_format, $image_large->__toString(), 'public');
		$image_medium_save 		= $disco->put('alojamientos/usuario_'.Auth::user()->id.'/'.$carpeta.'/md.'.$imgage_format, $image_medium->__toString(), 'public');
		$image_small_save 		= $disco->put('alojamientos/usuario_'.Auth::user()->id.'/'.$carpeta.'/sm.'.$imgage_format, $image_small->__toString(), 'public');

		if ($image_original_save && $image_large_save && $image_medium_save && $image_small_save) {
			return $carpeta;
		}
		return false;
	}


}
