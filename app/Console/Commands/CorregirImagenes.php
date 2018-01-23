<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\File;

use App\User;
use App\Propiedad;
use App\PropiedadImagen;

use Intervention\Image\ImageManagerStatic as Image;

class CorregirImagenes extends Command
{
    protected $signature = 'corregir:imagenes';

    protected $description = 'Mueve las imagenes de las propiedades a nueva carpeta, genera distintos tamaños de la misma y actualiza la base de datos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $disco = Storage::disk('public');
        $files = $disco->allFiles('alojamiento');

        $bar = $this->output->createProgressBar(count($files));
        foreach ($files as $key => $file) {
            $propiedadImagen = PropiedadImagen::where('ruta', $file)->first();

            if (count($propiedadImagen) > 0) {
                $imagen_ruta_original = storage_path('app/public/'.$file);

                $archivo = new File($imagen_ruta_original); 
                $extension  = strtolower(collect(explode(".",  $archivo))->last());

                $size = getimagesize($archivo);
                $width = 20 * $size[0] / 100;

                $carpeta = md5(date('YmdHis')) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
                $ruta = 'alojamientos/usuario_'.$propiedadImagen->propiedad->usuario->id.'/'.$carpeta;
                $temporal_image = Image::make($imagen_ruta_original);
                
                $watermark_image = Image::make(asset('img/watermark.png'));
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
                ->encode('webp')
                ->stream()
                ->detach();

                $image_medium = Image::make($imagen_ruta_original);
                $image_medium->orientate()
                ->resize(null, 480, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('webp')
                ->stream()
                ->detach();

                $image_small = Image::make($imagen_ruta_original);
                $image_small->orientate()
                ->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('webp')
                ->stream()
                ->detach();

                $disco->put($ruta.'/base.'.$extension, $image_original->__toString());
                $disco->put($ruta.'/lg.webp', $image_large->__toString());
                $disco->put($ruta.'/md.webp', $image_medium->__toString());
                $disco->put($ruta.'/sm.webp', $image_small->__toString());
                
                $propiedadImagen->ruta = $carpeta;
                $propiedadImagen->save();
            }else{
                # $disco->delete($file);
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
