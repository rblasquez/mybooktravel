@extends('layouts.app')

@section('content')
	<section class="container profileContent" style="min-height: 400px;">
    <div class="col-md-8 col-md-offset-2 col-sm-offset-2 col-sm-8 login">
        <div class="row">
        <h1 class="text-center">¡Gracias!</h1>
            <p class="txtSena text-center">Te contactaremos a la brevedad posible y atenderemos tu solicitud.</p>
        </div>
        <div class="row loginChiquis">
            <div class="col-md-4 col-md-offset-4">
                <div class="row">
                    <button onclick="document.location='{{ url('/') }}'"><i style="color: #fff" class="fa fa-home" aria-hidden="true"></i> Ir al inicio</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection