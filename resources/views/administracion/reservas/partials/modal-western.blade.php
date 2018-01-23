<div class="modal-header">
            <h5 class="modal-title">
                Detalles del pago
                <small class="reserva-id text-secondary">{{ str_pad($pago->reserva->id, 9, 0, STR_PAD_LEFT) }}</small>
                <small class="">
                    <span class="d-block">{{ Carbon\Carbon::parse($pago->created_at)->format('d/m/Y h:i a') }}</span>
                </small>
            </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12 text-center">
            <span class="badge badge-pill badge-warning">Western Union</span>
            <hr>
        </div>
        <div class="col">
            <address>
                <h4>Informacion del Usuario</h4>
                <div class="usuario-detalles">
                    <strong>Nombres:</strong> <span class="pull-right">{{ $pago->reserva->usuario->nombres }}</span><br>
                    <strong>Apellidos:</strong> <span class="pull-right">{{ $pago->reserva->usuario->apellidos }}</span><br>
                    <strong>Dirección:</strong> <span class="pull-right">{{ $pago->reserva->usuario->direccion }}</span><br>
                    <strong>Número telefónico:</strong> <span class="pull-right">{{ $pago->reserva->usuario->telefono }}</span><br>
                    <strong>Email:</strong> <span class="pull-right">{{ $pago->reserva->usuario->email }}</span>
                </div>
            </address>
        </div>
        <div class="col">
            <address>
                <h4>Datos del pago</h4>
                <div class="pago-detalles">
                    <strong>MTCN:</strong> <span class="pull-right">{{ $pago->mtcn }}</span><br>
                    <strong>Remitente:</strong> <span class="pull-right">{{ $pago->remitente }}</span><br>
                    <strong>Monto:</strong> <span class="pull-right">${{ cambioMoneda($pago->monto, 'CLP', session('valor')) }}</span><br>
                    <strong>Comentario:</strong> <span class="pull-right">{{ $pago->comentario }}</span>

                </div>
            </address>
        </div>
    </div>
    <hr>
    <figure class="figure">
        <figcaption class="figure-caption text-right">Imagen de recibo o bauche.</figcaption>
        <img src="{{ Storage::disk('minio')->url($pago->bauche) }}" class="figure-img img-fluid rounded ">

    </figure>
</div>
