<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Intervention\Image\ImageManagerStatic as Image;

use App\Propiedad;

class ComprimirImagenes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    protected $propiedad;

    public function __construct(Propiedad $propiedad)
    {
        $this->propiedad = $propiedad;
    }

    public function handle()
    {
        $propiedad = $this->propiedad;
        foreach ($propiedad->imagenes as $key => $imagen) {
             $image_thumb = Image::make(Storage::cloud()->temporaryUrl('alojamiento/'.$imagen->ruta, \Carbon\Carbon::now()->addMinutes(1)))->resize(null, 720, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->stream();
            # })->save(storage_path('app/public/alojamiento/'.$imagen->ruta));
            
            $filepath = 'alojamiento/'.$imagen->ruta;
            
            $imgPath = Storage::cloud('minio')->put($filepath, $image_thumb->__toString());
        }
    }
}
