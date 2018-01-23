@extends('emails.layout')

@section('content')
    @php
    setLocale(LC_TIME, '');
    $horas_checkin = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkin));
    $horas_checkout = Carbon\Carbon::parse(Carbon\Carbon::now()->format('Y-m-d 00:00:00'))->diffInHours(Carbon\Carbon::parse($reserva->propiedad->detalles->checkout));

    $fecha_entrada = Carbon\Carbon::parse($reserva->fecha_entrada);
    $fecha_salida = Carbon\Carbon::parse($reserva->fecha_salida);

    $noches = $fecha_entrada->diffInDays($fecha_salida);

    $imagen = $reserva->propiedad->imagenes->where('primaria', true)->first()->ruta;
    $imagen = App\Http\Controllers\HelperController::getUrlImg($reserva->propiedad->usuario->id, $imagen, 'lg');

    $totalPagado = App\Http\Controllers\HelperController::totalPagado($reserva);
    $propiedad = $reserva->propiedad;
    $huesped = $reserva->usuario;
    $anfitrion = $reserva->propiedad->usuario;

@endphp


@include('emails.partials.banner_random')


<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width">
    <tbody>
        <tr>
            <td align="center">
                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                    <tbody>
                        <tr>
                            <td align="center">
                                <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" class="full-width">
                                    <tbody>
                                        <tr>
                                            <td height="30">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="font_fix" style="font-size:16px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Montserrat', sans-serif;" align="center">
                                                <h4>
                                                    <span style="font-size:20px; text-transform:uppercase; color:#0EC5D8 !important;">Hola {{ $huesped->nombres }}</span>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr><td height="20" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td></tr>

                                        <tr>
                                            <td class="font_fix" style="font-size:16px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Montserrat', sans-serif;" align="center">
                                                <small style="display:block; color: #555">Lamentamos informarte que {{ $anfitrion->nombres }}, ha rechazado tu reserva, sin embargo te invitamos a seguir buscando entre otras opciones que tenemos disponibles para ti.</small>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="30">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection
