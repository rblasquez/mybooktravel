<section class="container profileContent sectionHome">
	<div class="row">
		<div class="col-md-12 homeh1">
			<h1 class="lugaresCercanos">Alojamientos cercanos a ti</h1>
		</div>

        @foreach ($propiedades as $key => $propiedad)
        <div class="col-md-3 col-xs-6 alojamientos">
         <a href="{{ route('propiedad.detalle', $propiedad->propiedad->id) }}">
            <div class="img_container">
                <figure>
                    @if ($propiedad->propiedad->imagenes->first())
                    {{--
                    <img class="b-lazy" 
                    src="{{ asset('img/Isotipo_carga.gif') }}"
                    data-src="{{ App\Http\Controllers\HelperController::getUrlImg($propiedad->propiedad->usuario->id, $propiedad->propiedad->imagenes->where('primaria', true)->first()['ruta'], 'sm') }}"
                    alt="alt-text"
                    />
                    --}}
                    
                    <img src="{{ App\Http\Controllers\HelperController::getUrlImg($propiedad->propiedad->usuario->id, $propiedad->propiedad->imagenes->where('primaria', true)->first()['ruta'], 'sm') }}" />
                    
                    
                    @else
                    <img src="{{asset('img/casa.jpg')}}">
                    @endif
                </figure>
            </div>

            <h4>{{ $propiedad->propiedad->nombre }}</h4>

            <div class="row">
                @php
                        $precio = $propiedad->propiedad->administracion->precio * (($PorcentajePublicacion / 100) + 1);
                        $precio = cambioMoneda($precio, $propiedad->propiedad->administracion->moneda, session('valor'));
                    @endphp
                    <div class="precio col-md-4 col-sm-4">${{ $precio }}</div>
                <div class="col-md-8 col-sm-8">{{ $propiedad->propiedad->tipo->descripcion }}</div>
            </div>
        </a>
    </div>
    @endforeach
</div>
</section>
