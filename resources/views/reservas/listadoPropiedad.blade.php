@extends('layouts.app')

@php
setlocale(LC_TIME, $lang);
@endphp

@section('content')
    <section class="container" style="min-height: 400px">
        <h1 class="h1 mbt_pb-5 mbt_mt-10" style="border-bottom: 1px solid #ddd;">Listado de reservas</h1>
        <div class="listado">
                @foreach ($reservas as $key => $reserva)
                    @php
                        $fecha_entrada = Carbon\Carbon::parse($reserva->fecha_entrada)->formatLocalized('%A %B %d, %Y');
                        $fecha_salida = Carbon\Carbon::parse($reserva->fecha_salida)->formatLocalized('%A %B %d, %Y');
                        $huespedes = $reserva->total_adultos + $reserva->total_ninos + $reserva->total_bebes;
                        $valor_total = cambioMoneda($reserva->total_pago, $propiedad->administracion->moneda, session('valor'));
                    @endphp
                    <div class="col-sm-2 mbt_pb-10">
                        Quien reserva:
                        <strong style="display: block">
                            {{ $reserva->usuario->nombres }}
                        </strong>
                        <hr class="visible-xs" style="border-top: 1px dashed #eee;">
                    </div>
                    <div class="col-sm-6 mbt_pb-10">
                        <dl class="dl-horizontal">
                            <dt>fecha de llegada: </dt> <dd>{{ $fecha_entrada }}</dd>
                            <dt>fecha de salida: </dt> <dd>{{ $fecha_salida }}</dd>
                            <dt>huespedes: </dt> <dd>{{ $huespedes }}</dd>
                            <dt>monto a cancelar: </dt> <dd>{{ $valor_total }}</dd>
                        </dl>
                        <hr class="visible-xs" style="border-top: 1px dashed #eee;">
                    </div>
                    <div class="col-sm-2 mbt_pb-10">
                        <small class="label label-{{ $reserva->estatusReserva->color == 'secondary' ? 'default' : $reserva->estatusReserva->color }}">{{ $reserva->estatusReserva->descripcion }}</small>
                    </div>
                    <div class="col-sm-2 text-right acciones mbt_pb-5" data-reserva-id="{{ $reserva->id }}">
                        <div class="row">
                            <div class="col-xs-4 col-sm-12 mbt_pb-5">
                                <a href="#" data-action="see" class="btn btn-default btn-sm btn-block">
                                    <i class="fa fa-eye"></i> ver
                                </a>
                            </div>
                            @if ($reserva->estatus_reservas_id == 1)
                                <div class="col-xs-4 col-sm-12 mbt_pb-5">
                                    <a href="{{ route('reserva.aprobar', $reserva->id) }}" data-action="confirm" class="btn btn-default btn-sm btn-block">
                                        <i class="fa fa-check-square-o"></i> confirmar
                                    </a>
                                </div>
                                <div class="col-xs-4 col-sm-12 mbt_pb-5">
                                    <a href="{{ route('reserva.rechazar', $reserva->id) }}" data-action="deny" class="btn btn-default btn-sm btn-block">
                                        <i class="fa fa-ban"></i> rechazar
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                @endforeach

        </div>
    </section>
@endsection


@push('js')
    <script>

        $(document).ready(function() {
            init();
        });

        function init()
        {
            $('.listado .acciones a').off('click')
            $('.listado .acciones a').on('click', function(event) {
                event.preventDefault();
                let id = $(this).parents('.acciones').data('reserva-id'),
                action = $(this).data('action'),
                url = $(this).attr('href');

                if (action == 'see') {
                    see(id, url)
                } else if(action == 'confirm') {
                    confirm(id, url)
                } else if(action == 'deny') {
                    deny(id, url);
                }
            });
        }

        async function see(id, url){
            console.log(id);
            console.log(url);
        }

        async function confirm(id, url) {
            validar(function() {
                let ajaxDeny = $.ajax({
                    url: url,
                    dataType: 'json',
                })

                $.when(ajaxDeny).done(function(data) {
                    swal("Completado...", "Haz aprobado esta reserva, Avisaremos al huesped, solo debes esperar el pago.")
                    .then(willDelete => {
                        if (willDelete) {
                            location.reload();
                        }
                    });
                })

                $.when(ajaxDeny).fail(function(data) {
                    swal("Algo ha salido mal...", "Instanta nuevamente, o recarga la página.")
                })
            });
        }

        async function deny(id, url){
            validar(function() {
                let ajaxDeny = $.ajax({
                    url: url,
                    dataType: 'json',
                })

                $.when(ajaxDeny).done(function(data) {
                    swal("Completado...", "Haz rechazado esta reserva.")
                    .then(willDelete => {
                        if (willDelete) {
                            location.reload();
                        }
                    });
                })

                $.when(ajaxDeny).fail(function(data) {
                    swal("Algo ha salido mal...", "Instanta nuevamente, o recarga la página.")
                })
            });
        }


        async function validar(callback) {
            const proceder = await swal({
                title: "Precaución",
                text: "¿Esta seguro que desea continuar?",
                button: {
                    text: "Continuar",
                    closeModal: false,
                },
                icon: "info",
            })

            if (proceder) {
                callback();
            }
        }


    </script>
@endpush
