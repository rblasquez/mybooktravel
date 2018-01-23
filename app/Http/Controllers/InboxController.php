<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;


use App\Mail\FinalizarRegistro;
use App\Mail\CargarPropiedad;
use App\Mail\Registro;
use Illuminate\Http\File;

use App\User;
use App\Propiedad;
use App\PropiedadImagen;

use Intervention\Image\ImageManagerStatic as Image;

class InboxController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        return view('mensajes.index');
    }

    public function mensajeEnviar(Request $request, $propiedad_id, $remitente_id = null)
    {
        $propiedad = Propiedad::find($propiedad_id);

        $mensaje = $propiedad->mensajes()->firstOrCreate([
            'usuario_id' => Auth::user()->id,
            'mensaje' => $request->mensaje,
        ]);


        $email = ($remitente_id) ? User::find($remitente_id)->email : $propiedad->usuario->email;

        Mail::to($email)->queue(new Mensaje($propiedad));

        $mensajes = $propiedad->mensajes->where('usuario_id', Auth::user()->id)->groupBy('usuario_id');

        return back();
    }

    public function emailPrueba()
    {
        $imagen = PropiedadImagen::whereNull('carpeta')->orderBy('id')->first();
        if ($imagen) {
        $disco = Storage::disk('public');
        $imgage_format = 'jpg';

        
        # $imagen_ruta_original = $disco->temporaryUrl($file, \Carbon\Carbon::now()->addMinutes(30));
        $imagen_ruta_original = storage_path('app/public/'.$imagen->ruta);
        if ( $disco->exists($imagen->ruta) ) {
            $extension  = strtolower(collect(explode(".", $imagen->ruta ))->last());
            $size = getimagesize($imagen_ruta_original);
            $width = 20 * $size[0] / 100;

            $carpeta = md5(date('YmdHis')) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $ruta = 'alojamientos/usuario_'.$imagen->propiedad->usuario->id.'/'.$carpeta;

            $temporal_image = Image::make($imagen_ruta_original);

            $watermark_image = Image::make('img/watermark.png');
            $watermark_image->resize(round($width), null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_original = Image::make($imagen_ruta_original);
            $image_original->resize(null, 720, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->stream()
            ->detach();

            $image_large = Image::make($imagen_ruta_original);
            $image_large->orientate()
            ->insert($watermark_image, 'bottom-right', 20, 10)
            ->resize(null, 720, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode($imgage_format)
            ->stream()
            ->detach();

            $image_medium = Image::make($imagen_ruta_original);
            $image_medium->orientate()
            ->resize(null, 480, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode($imgage_format)
            ->stream()
            ->detach();

            $image_small = Image::make($imagen_ruta_original);
            $image_small->orientate()
            ->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode($imgage_format)
            ->stream()
            ->detach();

            $image_original_save = $disco->put($ruta.'/base.'.$extension, $image_original->__toString());
            $image_large_save = $disco->put($ruta.'/lg.'.$imgage_format, $image_large->__toString());
            $image_medium_save = $disco->put($ruta.'/md.'.$imgage_format, $image_medium->__toString());
            $image_small_save = $disco->put($ruta.'/sm.'.$imgage_format, $image_small->__toString());


            if ($image_original_save && $image_large_save && $image_medium_save && $image_small_save) {
                $imagen->carpeta = $carpeta;
                $imagen->save();
            }
        }else{
            echo 'no existe imagen ' . $imagen->id;
            $imagen->carpeta = 'Imagen no existe';
            $imagen->save();
            die;
        }
        $procesadas = PropiedadImagen::whereNotNull('carpeta')->count();
        $sinProcesar = PropiedadImagen::whereNull('carpeta')->count();


        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title></title>
            <link rel="stylesheet" href="">
        </head>
        <body>
        <h1>'.$procesadas.' de '.$sinProcesar.'</h1>
        <script>document.location.reload();</script>
        </body>
        </html>';
        die;
        }
        echo 'Nada que cambiar';
        
    }
}
