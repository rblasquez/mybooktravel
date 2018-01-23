<header>
    <div class="telHeader">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-md-offset-2 col-xs-12 col-xs-offset-0 text-right">
                    <div class="pull-left text-left">
                        <a href="{{ route('informacion', 'faq') }}" title="Ayuda">
                            <i class="fa fa-2x fa-question" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('informacion', 'contacto') }}" class="marginHedRs" title="Contacto">
                            <i class="fa fa-user-circle" aria-hidden="true"></i> ¡Contáctanos!
                        </a>
                    </div>

                    <a href="{{ url('https://www.facebook.com/Mybooktravel/') }}" target="_blank">
                        <i class="fa-2x fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="{{ url('https://www.instagram.com/mybooktravel/?hl=es') }}" target="_blank">
                        <i class="fa-2x fa fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="{{ url('https://twitter.com/MybooktravelCL') }}" target="_blank">
                        <i class="fa-2x fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="{{ url('https://www.youtube.com/channel/UCRBBUo9vkFGUzaSavJhKANQ') }}" target="_blank">
                        <i class="fa fa-2x fa-youtube-play" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-5 hidden-xs logo-dk">
                <figure>
                    <a href="{{ route('index') }}"><img src="{{ asset('img/my_book_travel_logo.svg') }}"/></a>
                </figure>
            </div>

            <div class="col-xs-2 visible-xs logoMobile">
                <figure>
                    <a href="{{ route('index') }}"><img src="{{ asset('img/my_book_travel_isotipo.svg') }}"/></a>
                </figure>
            </div>

            <!-- INICIO BUSQUEDA DESKTOP -->
            <div class="col-xs-6 col-md-7 hidden-xs hidden-sm contenedor_buscador" id="contenedor_buscador_google_principal">
                {!! Form::open(['route' => 'propiedad.buscar', 'method' => 'GET', 'class' => 'formingUp', 'name' => 'frmBuscar', 'id' => 'frmBuscar', 'autocomplete' => 'off']) !!}
                <div class="col-md-6 formingUpSearch">
                    {!! Form::label('destino_busqueda', 'Destino', ['class' => 'sr-only']) !!}
                    {!! Form::text('destino_busqueda', null, ['class' => 'direccion', 'placeholder' => __('layout_header.destino'), 'onkeypress' => 'verificarEnterBuscador(event)','onkeydown' => 'verificarEnterBuscador(event)','onkeyup' => 'verificarEnterBuscador(event)']) !!}
                </div>

                @include("layouts.partials.campos_adicionales_ubicacion")

                <div class="col-md-3 formingUphuespedes">
                    <button id="fechasBtn" class="formingUpFechasBtnMd" type="button">@lang('layout_header.fecha')</button>
                    <div class="fechasGroup">
                        <div class="hide" id="fechas_busquedas">
                            <div class="col-md-6">
                                {!! Form::label('fecha_entrada', '', ['class' => 'sr-only']) !!}
                                {!! Form::text('fecha_entrada', null, ['class' => 'form-control startDate']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('fecha_salida', '', ['class' => 'sr-only']) !!}
                                {!! Form::text('fecha_salida', null, ['class' => 'form-control endDate']) !!}
                            </div>
                        </div>
                        <div id="date-range12-container"></div>
                    </div>
                </div>

                <div class="col-md-3 formingUphuespedes">
                    <button id="huespedBtn" class="formingUpHuespedesBtnMd" type="button">@lang('layout_header.huespedes')</button>

                    <div class="huespedesGroup">
                        <div class="form-inline row">
                            <div class="col-md-5">
                                <label class="control-label">Adultos</label>
                            </div>
                            <div class="numbers-row col-md-5">
                                <div class="dec button_inc">-</div>
                                {!! Form::label('total_adultos', '', ['class' => 'sr-only']) !!}
                                {!! Form::text('total_adultos', 1, ['class' => 'qty2 form-control']) !!}
                                <div class="inc button_inc">+</div>
                            </div>
                        </div>

                        <div class="form-inline row">

                            <div class="col-md-5">
                                <label class="control-label">
                                    Niños
                                    <span>Mayores a 2 años</span>
                                </label>
                            </div>
                            <div class="numbers-row col-md-5">
                                <div class="dec button_inc">-</div>
                                {!! Form::label('total_ninos', '', ['class' => 'sr-only']) !!}
                                {!! Form::text('total_ninos', 0, ['class' => 'qty2 form-control']) !!}
                                <div class="inc button_inc">+</div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-5">
                                <a id="closingHuesped" style="cursor:pointer;" onclick="verificarEnvioFormBuscaresktop()" >Aplicar</a>
                            </div>
                        </div>

                    </div>

                </div>
                <button class="hide" onclick="frmBuscar.submit()">enviar</button>
                {!! Form::close() !!}
            </div>
            <!-- FIN BUSQUEDA DESKTOP -->

            <!-- INICIO MENU DESKTOP -->
            <div class="menuMain hidden-xs hidden-sm">
                <ul class="nav navbar-nav pull-right">
                    @if (Auth::check())
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ (explode(" ",Auth::user()->nombres))[0] }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('propiedad.create') }}">Publica tu alojamiento</a></li>
                            <li><a href="{{ route('perfil.index') }}">Mi Perfil</a></li>
                            <li><a href="{{ route('propiedad.index') }}">Mis Alojamientos</a></li>
                            <li><a href="{{ route('reserva.index') }}">Mis Reservas</a></li>
                            <li><a href="{{ route('logout') }}">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    @else
                    {{--<li><a href="{{ route('login.registro') }}">Registrarse</a></li>--}}
                    <li><a href="{{ route('login.index') }}">Ingresa</a></li>
                    @endif
                    <li><a href="{{ route('propiedad.create') }}" class="publicaBtn">Publica</a></li>
                </ul>
            </div>

            <!-- INICIO BUSQUEDA MOBILE -->
            @if (Request::is('/'))
            <div class="btnSerchMobile col-xs-4 col-sm-3 visible-xs visible-sm">
                <button id="searchBtnMobile" type="button">
                    ¡Busca!
                </button>
            </div>
            <div class="btnSerchMobile col-xs-4 col-sm-3 visible-xs visible-sm">
                <button onclick="window.location.href='{{ route('propiedad.create') }}';" type="button">
                    ¡Publica!
                </button>
            </div>
            @else
            <div class="btnSerchMobile col-xs-8 col-sm-6 visible-xs visible-sm">
                <button id="searchBtnMobile" type="button">
                    ¡Planifica tu viaje!
                </button>
            </div>
            @endif

            <div class="searchEquis bg-blue col-xs-12 col-md-12 hidden-md contenedor_buscador" id="contenedor_buscador_google_principal_mobile" >


                {!! Form::open(['route' => 'propiedad.buscar', 'method' => 'GET', 'class' => 'formingUp', 'name' => 'frmBuscarMobile', 'id' => 'frmBuscarMobile', 'autocomplete' => 'off']) !!}

                <div class="col-xs-12 col-sm-12 formingUpSearch" >
                    {{--
                    <h4>@lang('layout_header.destino_movil')</h4>
                    --}}
                    <h3>Buscar </h3>
                    <p>Destinos, alojamientos e incluso una dirección</p>
                    {!! Form::text('destino_busqueda', $request->destino_busqueda ?? '', ['class' => 'direccion', 'id' => 'destino_busqueda', 'placeholder' => '¿A dónde quieres viajar?']) !!}

                    @include("layouts.partials.campos_adicionales_ubicacion")

                </div>

                <div class="col-xs-12 col-sm-6">
                    {{--
                    <h4>@lang('layout_header.fechas_movil')</h4>
                    --}}
                    <div class="input-daterange formingUpDate fechas_mobile" id="datepicker-2">
                        <div class="col-xs-6">
                            {!! Form::text('fecha_entrada', $request->fecha_entrada ?? '', ['class' => 'form-control startDate', 'placeholder' => 'Llegada']) !!}
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('fecha_salida', $request->fecha_salida ?? '', ['class' => 'form-control endDate', 'placeholder' => 'Retorno']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 formingUphuespedes">
                    {{--
                    <h4>@lang('layout_header.huespedes_movil')</h4>
                    --}}
                    <div class="form-horizontal">
                        <div class="form-inline">
                            <div class="col-xs-6">
                                <label for="total_ninos" class="control-label">
                                    @lang('layout_header.adultos_movil')
                                    <div class="clearfix"></div>
                                    <div class="dec button_inc mbt_m-0">-</div>
                                    {!! Form::text('total_adultos', $request->total_adultos ?? 1, ['class' => 'qty2 form-control']) !!}
                                    <div class="inc button_inc mbt_m-0">+</div>
                                </label>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div class="col-xs-6 text-right">
                                <label for="total_ninos" class="control-label">
                                    @lang('layout_header.ninos_movil')
                                    <div class="clearfix"></div>
                                    <div class="dec button_inc mbt_m-0">-</div>
                                    {!! Form::text('total_ninos', $request->total_adultos ?? 0, ['class' => 'qty2 form-control']) !!}
                                    <div class="inc button_inc mbt_m-0">+</div>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <hr style="border: 1px dashed #fff">
                <div class="searchBtnMobile col-xs-12">
                    <div class="col-xs-6 col-xs-offset-3">
                        {{-- Type button porque el type submit envia el formulario al seleccionar una localidad --}}
                        <button type="button" class="btn btn-default" onclick="frmBuscarMobile.submit()" > Buscar</button>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
            <!-- FIN BUSQUEDA MOBILE -->

            <!-- INICIO MENU MOBILE -->
            <div class="menuIconXs col-xs-2 col-sm-1 visible-xs visible-sm">
                <a href="#" id="closeMenu" class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <a href="#" id="barsMenu">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </a>
                <a href="#" id="closeFilters" class="pull-right">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </a>

            </div>

            <div class="menuEquis col-xs-12 col-md-12">

                <a href="#" id="closeMenu" class="pull-right">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </a>

                <nav>
                    <ul >
                        <li><a href="{{ route('index') }}">Inicio</a></li>
                        @if (Auth::check())

                        <li><a href="{{ route('perfil.index') }}">Mi Perfil</a></li>
                        <li><a href="{{ route('propiedad.index') }}">Mis Alojamientos</a></li>
                        <li><a href="{{ route('reserva.index') }}">Mis Reservas</a></li>
                        
                        <li><a href="{{ route('propiedad.create') }}">Publica</a></li>
                        <li><a href="{{ route('logout') }}">Cerrar sesión</a></li>
                        @else
                        <li><a href="{{ route('login.index') }}">Ingresa</a></li>
                        <li><a href="{{ route('login.registro') }}">Registrate</a></li>
                        <li><a href="{{ route('propiedad.create') }}">Publica</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
