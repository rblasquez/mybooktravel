<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-sm-12">
                        <select>
                            <option value="es">Español</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-12">
                        {!! Form::open(['route' => 'cambio.moneda', 'id' => 'cambioMoneda']) !!}
                        {!! Form::label('moneda', '', ['class' => 'sr-only']) !!}
                        {!! Form::select('moneda', $monedas, session('moneda') ?? null, ['class' => '']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-4 col-sm-3 footerColumns hidden-xs">
                <h4>Mybooktravel</h4>
                <a href="{{ route('informacion', 'nosotros') }}">@lang('layout_footer.nosotros')</a>
                <a href="{{ route('informacion', 'faq') }}">@lang('layout_footer.preguntas')</a>
                <a href="{{ route('informacion', 'contacto') }}">@lang('layout_footer.contacto')</a>
            </div>
            <div class="col-md-3 col-xs-4 col-sm-3 footerColumns hidden-xs">
                <h4>@lang('layout_footer.descubre_h4')</h4>
                <a href="La Serena" class="localidad">La Serena</a>
                <a href="Viña del Mar" class="localidad">Viña del mar</a>
                <a href="Concón" class="localidad">Concón</a>
                <a href="Santiago" class="localidad">Santiago</a>
                <a href="Pucón" class="localidad">Pucón</a>
                <a href="Maintecillo" class="localidad">Maitencillo</a>
            </div>
            <div class="col-md-3 col-xs-4 col-sm-3 footerColumns hidden-xs">
                <a href="http://blog.mybooktravel.com" target="_blank"><h4>@lang('layout_footer.blog_h4')</h4></a>
                <a href="http://blog.mybooktravel.com/por-que-mybooktravel-es-considerada-la-mejor-plataforma-de-alquileres-en-linea/" target="_blank">¿Por qué MyBookTravel?</a>
                <a href="http://blog.mybooktravel.com/como-elegir-el-mejor-hospedaje-sin-fallar-en-el-intento/" target="_blank">¿Cómo elegir el mejor hospedaje?</a>
                <a href="http://blog.mybooktravel.com/cinco-razones-para-que-definitivamente-le-digas-sayonara-al-hotel/" target="_blank">Adiós al hotel</a>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-2 col-xs-8 col-sm-4 hidden-xs">
                <figure class="footerLogo">
                    <img src="{{ asset('img/my_book_travel_logo_w.svg') }}" alt="My Book Travel"/>
                </figure>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-4 visible-xs">
                <figure class="footerLogo">
                <img src="{{ asset('img/simbolo_logo_w.svg') }}" alt="My Book Travel"/>
                </figure>
            </div>
            <div class="col-md-10 col-xs-10 col-sm-5 text-right little-letter">
                <a href="{{ route('informacion', 'terminos') }}">@lang('layout_footer.condiciones')</a> • <a href="{{ route('informacion', 'politicas') }}">@lang('layout_footer.privacidad')</a> • <a href="#">@lang('layout_footer.mapa')</a>
            </div>

        </div>
    </div>
</footer>
