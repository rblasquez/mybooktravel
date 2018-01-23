<div class="table-responsive">
    <table class="table table-hover table-sm ">
        <thead>
            <tr>
                <th width=""># Reserva</th>
                <th width="">Estatus</th>
                <th width="" class="text-right">Monto a pagar</th>
                <th width="" class="text-right">Minimo aceptado</th>
                <th width="" class="text-right">Pagos</th>
                <th width="" class="text-right">Total abonado</th>
                <th width="" class="text-right">Monto restante</th>
                <th width=""></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($reservas as $reserva)
                @php
                $totalPagado = App\Http\Controllers\HelperController::totalPagado($reserva);
                @endphp

                <tr id="{{ $reserva->id }}">
                    <td>{{ str_pad($reserva->id, 9, 0, STR_PAD_LEFT) }}</td>
                    <td class=""> <span class="d-block badge badge-{{ $reserva->estatusreserva->color }}">{{ $reserva->estatusreserva->descripcion }}</span></td>
                    <td class="text-right">${{ cambioMoneda($reserva->total_pago, 'CLP', session('valor')) }}</td>
                    <td class="text-right">${{ cambioMoneda($totalPagado['minimo_requerido'], 'CLP', session('valor')) }}</td>
                    <td class="text-right">
                        {!! Form::open() !!}
                        @foreach ($reserva->pagoDeposito as $key => $deposito)
                            @php
                            $estado = gettype($deposito->estatus) == 'NULL' ? false : true;
                            if (gettype($deposito->estatus) == 'NULL') {
                                $text_clase = 'text-secondary';
                            }else{
                                $text_clase = $deposito->estatus ? 'text-success' : 'text-danger';
                            }
                            @endphp
                            <div class="checkbox">
                                <a href="#" class="{{ $text_clase }} detalle-pago" data-metodo="deposito" data-pago-id="{{ $deposito->id }}">
                                    Deposito
                                    {{--
                                    ${{ cambioMoneda($deposito->monto, 'CLP', session('valor')) }}
                                    --}}
                                </a>
                                <label>
                                    {!! Form::checkbox('deposito[]', $deposito->id, false, ['disabled' => $estado]) !!}
                                </label>
                            </div>
                        @endforeach

                        @foreach ($reserva->pagoWesternUnion as $key => $western)
                            @php
                                $estado = gettype($western->estatus) == 'NULL' ? false : true;
                                if (gettype($western->estatus) == 'NULL') {
                                    $text_clase = 'text-secondary';
                                }else{
                                    $text_clase = $western->estatus ? 'text-success' : 'text-danger';
                                }
                            @endphp
                            <div class="checkbox">
                                <a href="#" class="{{ $text_clase }} detalle-pago" data-metodo="western" data-pago-id="{{ $western->id }}">
                                    Western
                                    {{--
                                    ${{ cambioMoneda($western->monto, 'CLP', session('valor')) }}
                                    --}}
                                </a>
                                <label class="">
                                    {!! Form::checkbox('western[]', $western->id, false, ['disabled' => $estado]) !!}
                                </label>
                            </div>
                        @endforeach
                        {!! Form::close() !!}
                    </td>
                    <td class="text-right">
                        <span class="{{ ($totalPagado['total_abonado'] < $totalPagado['minimo_requerido']) ? 'text-danger' : 'text-success' }}">
                            ${{ cambioMoneda($totalPagado['total_abonado'] , 'CLP', session('valor')) }}
                        </span>
                    </td>
                    <td class="text-right">
                        ${{ cambioMoneda($totalPagado['monto_restante'], 'CLP', session('valor')) }}
                    </td>
                    <td>
                        @php
                            $null = 0;
                            foreach ($reserva->pagoWesternUnion as $key => $pago) {
                                $null += (gettype($pago->estatus) == 'NULL') ? 1 : 0;
                            }

                            foreach ($reserva->pagoDeposito as $key => $pago) {
                                $null += (gettype($pago->estatus) == 'NULL') ? 1 : 0;
                            }
                            $estado_botones = ($null > 0) ? '' : 'disabled';
                        @endphp
                        <div class="{{ ($null > 0) ? '' : 'd-none' }}" data-values="{{ $totalPagado }}">
                            <button type="button" {{ $estado_botones }} class="btn btn-sm btn-primary btn-aprobar" data-estatus="aprobar"><i class="fa fa-check"></i></button>
                            <button type="button" {{ $estado_botones }} class="btn btn-sm btn-warning btn-aprobar" data-estatus="parcial"><i class="fa fa-flag-checkered"></i></button>
                            <button type="button" {{ $estado_botones }} class="btn btn-sm btn-danger btn-rechazar" data-estatus="rechazar"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
