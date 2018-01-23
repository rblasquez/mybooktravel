@extends('layouts.app')

@section('content')
<section class="container profileContent" style="min-height: 400px">

    <div class="row">

        <div class="col-md-8 col-md-offset-2 col-sm-offset-2 col-sm-8 login">
            <div class="row">
                <div class="col-md-12 text-center ctcTitle">
                    <h5>Contacta con el Soporte técnico de MyBookTravel</h5>
                </div>
                <div class="col-md-12 col-xs-12 text-center">
                    <h1>¿Cómo te prefieres contactar?</h1>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12 ctcMBT">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <h4>¡Llámanos!</h4>
                        <p>Te responderemos de inmediato.</p>
                        <div class="row">
                            <div class="col-xs-6 col-md-12">
                                <p class="text-left"><img src="{{ asset('img/tels/chile.svg') }}"> <a href="tel: +56322517530">+56 322517530</a></p>
                                <p class="text-left"><img src="{{ asset('img/tels/argentina.svg') }}"> <a href="tel: +541159845148">+54 1159845148</a></p>
                            </div>
                            <div class="col-xs-6 col-md-12">
                                <p class="text-left"><img src="{{ asset('img/tels/brazil.svg') }}"> <a href="tel: +552135000190">+55 2135000190</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <button class="col-md-12 ctcMBT" data-toggle="modal" data-target="#programar">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <h4>¿Te llamamos? </h4>
                        <p>Indícanos fecha y hora y te contactaremos.</p>
                    </button>

                </div>
                <div class="col-md-3">  
                    <div class="col-md-12 ctcMBT llamar_chat">  
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                        <h4>Escríbenos</h4>
                        <p>Envianos un WhatsApp siempre estamos en línea.</p>
                        <p><strong><i class="fa fa-whatsapp" style="font-size: 15px; color: #333; "></i> +56 9 8767 6444</strong></p>
                    </div>
                </div>

                <div class="col-md-3">
                    <button class="ctcMBT" data-toggle="modal" data-target="#formu">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <h4>Formulario</h4>
                        <p>Escríbenos un correo electrónico contándonos tus dudas.</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- MODAL PROGRAMAR LLAMADA -->

<div class="modal fade" id="programar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'contacto.telefono', 'id' => 'frmContactoLlamada']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="exampleModalLabel">Programa tu llamada</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Llena el formulario a continuación y en breve nos pondremos en contacto contigo.</p>
                        <div class="col-md-6 col-xs-12 programmingCall">
                            <div class="form-group">
                                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::tel('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12 programmingCall">
                            <div class="form-group">
                                {!! Form::text('pais', null, ['class' => 'form-control', 'placeholder' => 'País']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::date('fecha', null, ['class' => 'form-control', 'placeholder' => 'Fecha']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::time('hora', null, ['class' => 'form-control', 'placeholder' => 'Hora']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit">Programar</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



<div class="modal fade" id="formu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Formulario de contacto</h2>
            </div>
            {!! Form::open(['route' => 'contacto.correo', 'id' => 'frmContactoCorreo']) !!}
            <div class="modal-body">
                <p>Escríbenos tus dudas y te contectaremos a la brevedad.</p>
                <div class="col-md-6 col-xs-12 programmingCall">
                    <div class="form-group">
                        {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::tel('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) !!}
                    </div>
                    <div class="text-left">
                        {!! Form::checkbox('whatsapp', true, false, ['id' => 'whatsapp']) !!}
                        <label for="whatsapp"> Whataspp</label>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 programmingCall">
                    <div class="form-group">
                        {!! Form::text('pais', null, ['class' => 'form-control', 'placeholder' => 'País']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::textArea('mensaje', null, ['class' => 'form-control', 'placeholder' => 'Mensaje']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit">Enviar</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@push('css')
<style>

    @media (min-width: 992px) {
        .ctcMBT {
            height: 311px!important;
        }
    }

    .ctcMBT p {
        margin: 10px 0 0 0;
    }

    .modal-dialog .form-group .form-control {
        margin-top: 35px !important;
    }

    .modal-dialog .form-group .form-control {
        margin-bottom: 0px !important;
    }

    .programmingCall textarea {
        height: 135px;
    }
</style>
@endpush




@push('js')
{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
{!! JsValidator::formRequest('App\Http\Requests\ContactoTelefonoRequest', '#frmContactoLlamada'); !!}
{!! JsValidator::formRequest('App\Http\Requests\ContactoEmailRequest', '#frmContactoCorreo'); !!}

<script>
    $('#frmContactoLlamada, #frmContactoCorreo').on('submit', function(event) {
        var form = $(this);
        if (form.valid()) {
            var element = $(this).parents('.modal');
            $(element).block({
                message: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
                overlayCSS: {
                    backgroundColor: '#E6E7E8',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    width: 100,
                    '-webkit-border-radius': 10,
                    '-moz-border-radius': 10,
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        }
    });
</script>
@endpush