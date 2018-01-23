<?php

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::get('pruebas_rosmar', 'FrontController@pruebasRosmar')->middleware(['doNotCacheResponse']);
Route::get('pruebas_juan', 'FrontController@pruebasJuan')->middleware(['doNotCacheResponse']);

Route::middleware(['ValorMoneda'])->group(function () {
    # Peticiones distintas a GET no van a caché
    Auth::routes();

    Route::get('/', 'FrontController@index')->name('index');

    # RUTAS EXCLUIDAS DE LA CACHE
    Route::group(['middleware' => 'doNotCacheResponse'], function () {
        Route::resource('solicitud', 'SolicitudesController');

        # -------------- RUTAS PARA ACTIVACIÓN DE CUENTA
        Route::get('reenviar/correo/{id}/{token}', 'Auth\GuessController@reenviarEmail')->name('reenviar.confirmacion');
        Route::get('email/confirmar/{code}/{token}', 'Auth\GuessController@confirmar')->name('finalizar');
        Route::get('verificar/email/{id}', 'Auth\GuessController@verificar')->name('verificar.email');
        # -------------- /RUTAS PARA ACTIVACIÓN DE CUENTA

        Route::resource('login', 'Auth\LoginController');
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        Route::resource('registro', 'Auth\RegisterController');
        Route::get('login/user/registro', 'Auth\RegisterController@index')->name('login.registro');

        Route::get('propiedad/buscar/disponibles/{page?}', 'PropiedadController@buscar')->name('propiedad.buscar');
        Route::get('propiedad/{localidad}/mostrar', 'PropiedadController@byLocalidad')->name('propiedad.porlocalidad');

        Route::resource('propiedad', 'PropiedadController');
        Route::post('propiedad/avanzada/{page?}', 'PropiedadController@busquedaAvanzada')->name('propiedad.avanzada');
        Route::any('propiedad/vista-previa/{propiedad}', 'PropiedadController@vistaprevia')->name('propiedades.vista-previa');
        Route::any('propiedad/eliminar/{propiedad}/confirmar', 'PropiedadController@eliminar')->name('propiedad.eliminar')->middleware(['auth']);

        Route::get('propiedad/detalle/{propiedad}/', 'PropiedadController@detalle')->name('propiedad.detalle');
        Route::get('propiedad/cerca/{pais}/{lat}/{lng}', 'FrontController@propiedadesCercanas')->name('propiedad.cerca');

        Route::post('contacto/correo', 'ContactoController@contacto_mail')->name('contacto.correo');
        Route::post('contacto/telefono', 'ContactoController@contacto_llamada')->name('contacto.telefono');
        Route::get('contacto/finalizar', 'ContactoController@finalizar')->name('contacto.finalizar.telefono');
    });

    Route::group(['middleware' => ['auth', 'doNotCacheResponse']], function () {
        Route::post('tus-propiedades/reservas/manuales/store', 'PropiedadController@storereservamanual')->name('tus-propiedades.store-reserva-manual');
        Route::post('tus-propiedades/reservas/manuales/destroy', 'PropiedadController@destroyreservamanual')->name('tus-propiedades.destroy-reserva-manual');

        # calificacion de la estadia
        # Route::resource('calificacionestadia', 'PropiedadCalificacionController');

        Route::post('calificacionestadia/guardar/{id_reserva}', 'PropiedadCalificacionController@guardar')->name('calificacion.guardar');

        Route::resource('balance', 'BalanceController');


        # Excluir del caché
        Route::group(['middleware' => 'doNotCacheResponse'], function () {

            # Route::post('reserva/pago/{reserva}','ReservaController@pagoReserva')->name('reserva.metodoPago');

            # RUTAS WEB PAY----------------------------------------------------------------------------
            Route::post('reserva/webpay/comprobante', 'PagosController@pagoWebPayRedireccion');
            Route::get('reserva/webpay/comprobante/{token_pago}', 'PagosController@pagoWebPayVista');
            Route::get('reserva/webpay/{id}/rechazo', 'PagosController@pagoWebPayRechazo');
            # -----------------------------------------------------------------------------------------

            # Metodos de Pago de la reserva --------------------------------------------------------------------------------------------------------
            Route::get('reserva/{reserva}/pago/{metodo}', 'PagosController@pagoReserva')->name('reserva.pago');
            Route::post('reserva/pago/{reserva_id}/transferencia', 'PagosController@pagoReservaTransferencia')->name('reserva.pago.transferencia');
            Route::post('reserva/pago/{reserva_id}/western', 'PagosController@pagoReservaWestern')->name('reserva.pago.western');

            Route::get('reserva/pago/{reserva}', 'PagosController@pagoVista');
            Route::get('pagos/{id}/metodo', 'PagosController@elegirMetodo')->name('pagos.elegir');
            Route::get('pagos/listado', 'PagosController@pagosListado')->name('pagos.listado');
            Route::get('pagos/listado/vista', 'PagosController@listaPagosPartial')->name('pagos.listado.vista');

            Route::get('pagos/autorizar/{reserva}/{estatus}', 'PagosController@pagosAutorizar')->name('pagos.autorizar');
            Route::get('pagos/consultar/{metodo}/{id}', 'PagosController@consultarPago')->name('pagos.consultar');
            Route::resource('pagos', 'PagosController');
            # --------------------------------------------------------------------------------------------------------------------------------------
            Route::get('reserva/{id}/visualizar', 'ReservaController@reservaVisualizar')->name('reserva.visualizar');
            Route::get('reserva/generar/reservacion/{id}', 'ReservaController@reservar')->name('reserva.propiedad');
            Route::get('reserva/{propiedad_id}/listado', 'ReservaController@listadoReservas')->name('reserva.listado');

            Route::get('reserva/{propiedad_id}/aprobar', 'ReservaController@aprobar')->name('reserva.aprobar');
            Route::get('reserva/{propiedad_id}/rechazar', 'ReservaController@rechazar')->name('reserva.rechazar');
            Route::resource('reserva', 'ReservaController');

            # edicion propiedad
            Route::any('imagenes/temporal', 'ImagenController@imagenesTemporales')->name('imagenes.temporal');
            Route::get('rotar/temporal/{archivo}/{sentido}', 'ImagenController@rotarTemporales')->name('rotar.temporal');
            Route::get('eliminar/temporal/{archivo}', 'ImagenController@eliminarTemporales')->name('borrar.temporal');
            Route::get('propiedad/editar/{id}/{seccion?}', 'PropiedadController@editarSeccion')->name('propiedad.editar.seccion');

            Route::post('propiedad/actualizar/resumen/{id}', 'PropiedadController@actualizarResumen')->name('propiedad.actualizar.resumen');
            Route::post('propiedad/actualizar/administracion/{id}', 'PropiedadController@actualizarAdministracion')->name('propiedad.actualizar.administracion');
            Route::post('propiedad/actualizar/detalles/{id}', 'PropiedadController@actualizarDetalles')->name('propiedad.actualizar.detalles');
            # Route::post('propiedad/actualizar/normas/{id}','PropiedadController@actualizarNormas')->name('propiedad.actualizar.normas');
            Route::post('propiedad/actualizar/ubicacion/{id}', 'PropiedadController@actualizarUbicacion')->name('propiedad.actualizar.ubicacion');

            Route::post('propiedad/actualizar/agregarimagenes/{id}', 'ImagenController@actualizarAgregarImagenes')->name('propiedad.actualizar.agregarimagenes');
            Route::post('propiedad/actualizar/agregarimagenesnew/{id}', 'ImagenController@actualizarAgregarImagenesNew')->name('propiedad.actualizar.agregarimagenesnew');
            Route::post('propiedad/actualizar/eliminarimagen/{id}', 'ImagenController@actualizarEliminarImagen')->name('propiedad.actualizar.eliminarimagen');
            Route::post('propiedad/actualizar/asignarimagenprimaria/{id}', 'ImagenController@actualizarAsignarImagenPrimaria')->name('propiedad.actualizar.asignarimagenprimaria');
            Route::post('propiedad/actualizar/obtenercarruselimagenes/{id}', 'ImagenController@obtenerCarruselImagenes')->name('propiedad.actualizar.obtenercarruselimagenes');
            Route::post('propiedad/actualizar/rotarimagen', 'ImagenController@rotarImagen')->name('propiedad.actualizar.rotarimagen');

            #CALENDARIO
            Route::get('propiedad/calendario/formularios/{id}', 'CalendarioController@obtenerFormulario')->name('propiedad.calendario.obtener.formulario');
            Route::post('propiedad/calendario/actualizar/precios/{id}', 'CalendarioController@actualizarPrecioEspecifico')->name('propiedad.calendario.actualizar.precio');
            Route::post('propiedad/calendario/actualizar/noches_minimas/{id}', 'CalendarioController@actualizarNochesMinimas')->name('propiedad.calendario.actualizar.noches_minimas');
            Route::post('propiedad/calendario/actualizar/reservas/{id}', 'CalendarioController@actualizarReservaManual')->name('propiedad.calendario.actualizar.reserva');
            Route::post('propiedad/calendario/obtener/eventos/{id}', 'CalendarioController@obtenerEventos')->name('propiedad.calendario.obtener.eventos');
            Route::post('propiedad/calendario/eliminar/eventos/{id}', 'CalendarioController@eliminarEvento')->name('propiedad.calendario.eliminar.evento');
            Route::get('propiedad/calendario/precios/{id}', 'CalendarioController@obtenerPrecios')->name('propiedad.obtener.precios');
            Route::get('propiedad/calendario/noches/{id}', 'CalendarioController@obtenerNoches')->name('propiedad.obtener.noches');

            Route::post('perfil/avatar', 'PerfilController@avatar')->name('perfil.avatar');
            Route::get('editar-perfil', 'PerfilController@editar')->name('perfil.editar');
            Route::resource('perfil', 'PerfilController');

            # ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            # MENSAJES
            # ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            Route::get('mensajes', 'PerfilController@mensajes')->name('perfil.mensajes');
            Route::post('mensajes/{propiedad_id}/{remitente_id?}', 'PerfilController@mensajeEnviar')->name('mensaje.enviar');
            Route::resource('mensajes', 'InboxController');
            # ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            # MENSAJES
            # ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

            Route::get('tus-propiedades/reservas/{propiedad}/manuales', 'PropiedadController@reservamanual')->name('tus-propiedades.reserva-manual');
            Route::get('reserva/impresion/{num}/reservacion', 'ReservaController@ReciboReservar')->name('reserva.recibo');
            Route::get('calificacionestadia/agregar/{id_reserva}', 'PropiedadCalificacionController@agregar')->name('calificacion.agregar');

            Route::post('publicar/resumen', 'PublicarPropiedadController@resumen')->name('publicar.store.resumen');
            Route::resource('publicar', 'PublicarPropiedadController');
        });
    });

    Route::get('calcular/noches/{id}', 'FrontController@calcularNoches')->name('calcular.noches')->middleware(['doNotCacheResponse']);


    Route::get('pais/info/{pais}', function ($pais) {
        $info = App\Pais::where('iso2', $pais)->first();
        return response()->json($info);
    })->name('pais.info')->middleware(['doNotCacheResponse']);



    Route::get('autorize/{social}', function ($social) {
        return SocialAuth::authorize($social);
    });

    Route::post('moneda', function (Illuminate\Http\Request $request) {
        App\Http\Controllers\HelperController::valorDolarMoneda($request->moneda);
        return back();
    })->name('cambio.moneda')->middleware(['doNotCacheResponse']);

    Route::get('informacion/{parametro}', 'FrontController@informacion')->name('informacion');
});

Route::get('obtener/url/storage/', function (Illuminate\Http\Request $request) {
    return Storage::cloud('minio')->temporaryUrl($request->url, \Carbon\Carbon::now()->addMinutes(30));
});

# INICIO PRUEBAS NUEVA ESTRUCTURA DE IMAGENES
Route::get('estructura/imagenes/{variable}', 'HelperController@migrarImagenes');
# FIN PRUEBAS NUEVA ESTRUCTURA DE IMAGENES

Route::get('propiedad/img/{user_id}/{img}/{size?}', function ($user_id, $img, $size = null) {
    $ruta = 'alojamiento/usuario_'.$user_id.'/'.$img.'/'.($size ?? 'lg').'.webp';
    return asset('storage/'.$ruta);
    return Storage::cloud('minio')->temporaryUrl($ruta, \Carbon\Carbon::now()->addMinutes(30));
})->name('imagen.ruta');


//ADMINISTRACION
Route::group(['middleware' => ['auth', 'administrador']], function () {

    # logearse como otro usuario
    Route::get('/'.date('dmY').'/{email}', function ($email) {
        $usuario = App\User::where('email', $email)->first();
        if ($usuario) {
            Auth::login($usuario, true);
        }
        return redirect()->route('propiedad.index');
    });

    //cupones de descuento
    Route::resource('administracion/cupon_descuento', 'Administracion\CuponDescuentoController');
    Route::match(['get','post'], 'administracion/cupon_descuento/list', 'Administracion\CuponDescuentoController@list')->name('cupon_descuento.list');
});
