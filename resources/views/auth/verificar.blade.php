@extends('layouts.app')

@section('content')
<section class="container profileContent" style="min-height: 300px;">
    <div class="col-md-8 col-md-offset-2 col-sm-offset-2 col-sm-8 login">
        <div class="row">
        <h1>¡Hola, {{ $usuario->nombres }} {{ $usuario->apellidos }}!</h1>
            <p class="txtSena">Aún no has verificado tu cuenta, debemos confirmar tu correo electrónico para que puedas disfrutar de nuestros servicios.</p>

        </div>
        <div class="row loginChiquis">
            <div class="col-md-4 col-md-offset-4">
                <div class="row">
                    <button onclick="document.location='{{ route('reenviar.confirmacion', [$usuario->id, csrf_token()]) }}'">Re-enviar mail</button>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection