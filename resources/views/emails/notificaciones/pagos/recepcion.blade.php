@component('mail::message')
# Recepción de pago

Hemos recibido un pago de {{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }}

correspondiente a la reserva Nº {{ $reserva->id }}

# Información de la reserva
@component('mail::table')
| Detalles          | Valores                                                 |
| :---------------- |--------------------------------------------------------:|
| Fecha de llegada  | {{ Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}                           |
| Fecha de salida   | {{ Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}                            |
| Huespedes         | {{ $reserva->total_adultos + $reserva->total_ninos }}   |
| Noches de estadía | {{ $reserva->dias_estadia }}                            |
@endcomponent

# Montos a facturar
@component('mail::table')
| Detalles                                                                                       | Valores                     |
| :----------------------------------------------------------------------------------------------|----------------------------:|
| {{ $reserva->dias_estadia }} noches X {{ number_format($reserva->precio_noche, 0, '', ',') }}  | {{ number_format($reserva->precio_base, 0, '', ',') }} |
@if ($reserva->gastos_limpieza > 0)
| Gastos de limpieza  | {{ number_format($reserva->gastos_limpieza, 0, '', ',') }}   |
@endif
| Tarifa de servicio  | {{ number_format($reserva->tarifa_servicio, 0, '', ',') }}   |
| <b>TOTAL</b>        | <b>{{ number_format($reserva->total_pago, 0, '', ',') }}</b> |

@endcomponent

# Información del pago realizado
@component('mail::table')

@if ($reserva->metodo_pago_id == 1)
# Pago realizado por medio de WebPay
|Dato       | Detalles              |
|:----------|----------------------:|
@foreach ($reserva->pagoWebPay->where('estado', 'ACEPTADO') as $pago)
|TDC        |XXXX-XXXX-XXXX-{{ $pago->cardnumber }} |
|Monto      |{{ $pago->amount }}                    |
|Fecha      |{{ $pago->transactiondate }}           |
|           |                                       |
@endforeach
@elseif ($reserva->metodo_pago_id == 4)
# Pago realizado por medio de deposito o transferencia

|Dato       | Detalles              |
|:----------|----------------------:|
@foreach ($reserva->pagoWesternUnion as $pago)
|Depositante                 |{{ $pago->nombre }}                          |
|Documento de identidad      |{{ $pago->rut }}                             |
|Banco                       |{{ $pago->banco }}                           |
|Numero de transferencia     |{{ $pago->numero_transferencia }}            |
|Monto                       |{{ number_format($pago->monto, 0, '', ',') }}|
|Comentario                  |{{ $pago->comentario }}                      |
|                            |                                             |
@endforeach

@elseif ($reserva->metodo_pago_id == 3)
# Pago realizado con Western Union

|Dato       | Detalles              |
| :---------|----------------------:|
@foreach ($reserva->pagoWesternUnion as $pago)
|MTCN       |{{ $pago->mtcn }}                            |
|Depositante|{{ $pago->remitente }}                       |
|Monto      |{{ number_format($pago->monto, 0, '', ',') }}|
|Comentario |{{ $pago->comentario }}                      |
@endforeach
@endif
@endcomponent



@endcomponent
