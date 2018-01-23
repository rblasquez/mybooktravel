@extends('administracion.layouts.app')


@section('contenedor_app')
    <div class="container">
        <div class="listado_pagos"></div>
    </div>

    <div class="container pago_detalle_prueba"></div>

    <div class="modal fade" id="mdl_pago_info">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
    var alerta = '';
    const swallContentAprobar = {
        title: 'Autorizar pagos',
        text: 'Una vez confirmes el pago no podras reversar este cambio',
        buttons: ['Cancelar', {
            text: "Confirmar",
            closeModal: false,
        }],
        dangerMode: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
    }

    var swallContentParcial = {
        title: 'Pago parcial',
        text: 'Pago parcial de la reserva.',
        content: {
            element: "input",
            attributes: {
                placeholder: "Monto aprobado",
                type: "textarea",
            },
        },
        buttons: ['Cancelar', {
            text: "Confirmar",
            closeModal: false,
        }],
        dangerMode: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
    }

    var swallContentRechazar = {
        title: 'Rechazo de pago',
        text: 'Una vez confirmes el rechazo no podras reversar este cambio',
        content: {
            element: "input",
            attributes: {
                placeholder: "indica el motivo del rechazo",
                type: "textarea",
            },
        },
        buttons: ['Cancelar', {
            text: "Confirmar",
            closeModal: false,
        }],
        dangerMode: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
    }

    // swallContentRechazar.content.attributes['value'] = 'prueba';
    // console.log(swallContentRechazar.content.attributes);

    listaPagos()

    $(document).ajaxStop(function(){
        inicializar();
    });

    /*
    |--------------------------------------------------------------------------
    | AUTORIZAR UN PAGO
    |--------------------------------------------------------------------------
    | Envia la petición al servidor para autorizar o rechazar un pago.
    |
    */
    async function autorizar (elemento) {
        let estatus = elemento.data('estatus');
        let padre = elemento.parents('tr')
        let reserva = padre.attr('id');
        let form = padre.find('form').serialize()

        if (padre.find("input[type=checkbox]:checked").length > 0) {

            var valores_reserva = elemento.parent('div').data('values');

            let url_autorizar = '{!! route('pagos.autorizar', [':RESERVA', ':ESTATUS']) !!}'
            .replace(':RESERVA', reserva)
            .replace(':ESTATUS', estatus);

            switch (estatus) {
                case 'aprobar':
                var swallContent = swallContentAprobar
                break;
                case 'parcial':
                var swallContent = swallContentParcial
                form = form + '&monto_parcial=';
                break;
                case 'rechazar':
                var swallContent = swallContentRechazar
                form = form + '&motivo_rechazo=';
                break;
                default:

            }

            const alerta = await swal(swallContent)

            if (alerta) {

                form = (estatus != 'aprobar') ? form + alerta : form;

                const ajaxCall = $.ajax({
                    url: url_autorizar,
                    dataType: 'json',
                    data: form
                });

                $.when(ajaxCall).done(function(data) {
                    $.when(mensaje('Listo')).done(function() {
                        listaPagos()
                    });
                })

                $.when(ajaxCall).fail(function(jqXHR, textStatus, errorThrown) {
                    mensaje('Error')
                    swal('¡Oops!', 'Parece que algo ha salido mal', 'error')
                });

            }

        };

    }

    /*
    |--------------------------------------------------------------------------
    | Mensajes con confirmación
    |--------------------------------------------------------------------------
    | Permite mostrar una alerta y retornar un boleano cuando se confirme
    |
    */
    async function mensaje (texto) {
        const swallMensaje = await swal({
            title: 'Esto es una prueba',
            text: texto,
            icon: 'info',
        })

        if (swallMensaje) {
            return true;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DETALLES DE UN PAGO
    |--------------------------------------------------------------------------
    | Envia la información al servidor para consultar los datos de un pago,
    | el mismo se encarga de ordenar toda la información en formato Html
    | y la retorna, de esta forma se asignan a los espacios correspondientes,
    | y finalmente se levanta un modal donde se muestra la información.
    |
    */
    function detallePago(elemento) {
        var metodo = elemento.data('metodo');
        var pago_id = elemento.data('pago-id');

        $('#mdl_pago_info').modal('show')
        var metodo_pago;

        var url = '{{ route('pagos.consultar', [':METODO', ':ID']) }}'
        .replace(':METODO', metodo)
        .replace(':ID', pago_id);

        $.ajax({
            url: url,
            dataType: 'html',
        })
        .done(function(data) {
            $('.modal-content').html(data)
        })
        .fail(function(data) {
            console.log(data);
        })
    }

    /*
    |--------------------------------------------------------------------------
    | LISTA DE PAGOS
    |--------------------------------------------------------------------------
    | Esta funcion unicamente retorna una vista con una tabla
    | donde se listan todos los pagos realizados.
    |
    */
    function listaPagos () {
        const ajaxLista = $.ajax({
            url: '{!! route('pagos.listado.vista') !!}',
            dataType: 'html',
        })
        .done(function(data) {
            $('.listado_pagos').html(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            swal('¡Oops!', 'Parece que algo ha salido mal', 'error')
        });
    }

    function inicializar() {
        $('button.btn-rechazar, button.btn-aprobar, a.detalle-pago').off('click');

        $('button.btn-rechazar, button.btn-aprobar').on('click', function () {
            autorizar($(this));
        });

        $('a.detalle-pago').on('click', function(event) {
            detallePago($(this))
        });
    }
</script>
@endpush
