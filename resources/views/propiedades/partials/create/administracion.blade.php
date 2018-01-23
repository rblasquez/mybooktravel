<h5>@lang('propiedad_create.administracion_h5')</h5>
<div id="anfitriones">
    <div class="row administracionChks">

        <div class="col-md-2 col-sm-3 col-xs-12">
            {!! Form::radio('anfitrion', 'usuario', false, ['id' => 'anfitrion_usuario']) !!}
            {!! Form::label('anfitrion_usuario', __('propiedad_create.propiedad_administracion_anfitrion_0')) !!}
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            {!! Form::radio('anfitrion', 'otro', false, ['id' => 'anfitrion_otro']) !!}
            {!! Form::label('anfitrion_otro', __('propiedad_create.propiedad_administracion_anfitrion_1')) !!}
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            {!! Form::radio('anfitrion', 'mybooktravel', false, ['id' => 'anfitrion_mybooktravel']) !!}
            {!! Form::label('anfitrion_mybooktravel', __('propiedad_create.propiedad_administracion_anfitrion_2')) !!}
        </div>

    </div>

    <div id="anfitrionDatos"  class="collapse">
        <div class="row">
            <div class="col-md-12">
                <h6>@lang('propiedad_create.anfitrion_h6')</h6>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('nombre_anfitrion', '', ['class' => 'sr-only']) !!}
                    {!! Form::text('nombre_anfitrion', null, ['class' => 'form-control', 'placeholder' => __('propiedad_create.propiedad_administracion_anfitrion_nombre'), 'disabled' => true, 'maxlength' => 50]) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('telefono_anfitrion', '', ['class' => 'sr-only']) !!}
                    {!! Form::text('telefono_anfitrion', null, ['class' => 'form-control', 'placeholder' => __('propiedad_create.propiedad_administracion_anfitrion_tel'), 'disabled' => true, 'maxlength' => 15 ]) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('correo_anfitrion', '', ['class' => 'sr-only']) !!}
                    {!! Form::text('correo_anfitrion', null, ['class' => 'form-control minusculas', 'placeholder' => __('propiedad_create.propiedad_administracion_anfitrion_email'), 'disabled' => true, 'maxlength' => 60]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="collapse" id="costo_adicional_anfitrion">
        @lang('propiedad_create.propiedad_administracion_anfitrion_mensaje')
    </div>
</div>

<h5>Pago</h5>
<div class="row radioAlign dividingMetodos">
    <div class="col-md-6">
        <h6>@lang('propiedad_create.propiedad_administracion_tipo_oferta')</h6>
        @php
        $classArray = collect(['mixta', 'tAlta', 'turista']);
        @endphp
        @foreach ($tipo_oferta as $oferta)
        {!! Form::radio('oferta_propiedad_id', $oferta->id, false, ['id' => 'oferta'.$oferta->id]) !!}
        {!! Form::label('oferta'.$oferta->id, $oferta->titulo, ['class' => $classArray[$loop->index]]) !!}
        @endforeach
    </div>
    <div class="col-md-6 finalDesc">
        <div id="ayudaOferta0" class="ayudaOferta collapse in">@lang('propiedad_create.propiedad_administracion_ayuda_oferta')</div>
        <div id="ayudaOferta1" class="ayudaOferta collapse">@lang('propiedad_create.propiedad_administracion_tipo_oferta_ayuda1')</div>
        <div id="ayudaOferta2" class="ayudaOferta collapse">@lang('propiedad_create.propiedad_administracion_tipo_oferta_ayuda2')</div>
        <div id="ayudaOferta3" class="ayudaOferta collapse">@lang('propiedad_create.propiedad_administracion_tipo_oferta_ayuda3')</div>
    </div>
</div>

<div class="row dividingMetodos">
    <div class="col-md-6">
        <h6>@lang('propiedad_create.propiedad_administracion_pago_garantia')</h6>
        @foreach ($metodoGarantia as $garantia)
        {!! Form::radio('garantia_reserva_id', $garantia->id, false, ['class' => 'check-tarifa', 'id' => 'garantia'.$garantia->id]) !!}
        {!! Form::label('garantia'.$garantia->id, $garantia->descripcion) !!}
        @endforeach
    </div>
    <div class="col-md-6 finalDesc">
        <div id="ayudaGarantia0" class="ayudaGarantia collapse in">@lang('propiedad_create.propiedad_administracion_ayuda_garantia')</div>
        <div id="ayudaGarantia1" class="ayudaGarantia collapse">@lang('propiedad_create.propiedad_administracion_pago_garantia_ayuda1')</div>
        <div id="ayudaGarantia2" class="ayudaGarantia collapse">@lang('propiedad_create.propiedad_administracion_pago_garantia_ayuda2')</div>
        <div id="ayudaGarantia3" class="ayudaGarantia collapse">@lang('propiedad_create.propiedad_administracion_pago_garantia_ayuda3')</div>
    </div>
</div>

<div class="row radioAlign dividingMetodos" id="metodoPagoSeccion">
    <div class="col-md-6">
        <h6>@lang('propiedad_create.recibir_dinero_h6')</h6>
        {!! Form::radio('medio', 'transferencia', false, ['id' => 'medio_trans']) !!}
        {!! Form::label('medio_trans', __('propiedad_create.propiedad_medio_transferencia'), ['class' => 'transfer']) !!}
        {{--
        {!! Form::label('medio_wu', __('propiedad_create.propiedad_medio_western_union'), ['class' => 'western']) !!}
        {!! Form::radio('medio', 'wu', false, ['id' => 'medio_wu']) !!}
        --}}
    </div>

    <div class="col-md-12 dividingMetodos_2">
        <div class="wu collapse">
            <div class="row">
                <div class="col-md-12">
                    <h6>Western Union</h6>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('inf_pago[persona]', __('propiedad_create.propiedad_medio_wu_persona'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[persona]', null, ['class' => 'form-control', 'disabled' => true]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('inf_pago[direccion]', __('propiedad_create.propiedad_medio_wu_direccion'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[direccion]', null, ['class' => 'form-control', 'disabled' => true]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="transferencia collapse">
            <div class="row">
                <div class="col-md-12">
                    <h6>Transferencia Electrónica</h6>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('inf_pago[titular]', __('propiedad_create.propiedad_medio_trans_titular'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[titular]', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inf_pago[tipo_cuenta]', __('propiedad_create.propiedad_medio_trans_tipo_cuenta'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[tipo_cuenta]', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inf_pago[email_beneficiario]', __('propiedad_create.propiedad_medio_trans_email_beneficiario'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[email_beneficiario]', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inf_pago[identificacion]', __('propiedad_create.propiedad_medio_trans_identificacion'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[identificacion]', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('inf_pago[nro_cuenta]', __('propiedad_create.propiedad_medio_trans_nro_cuenta'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[nro_cuenta]', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inf_pago[banco]', __('propiedad_create.propiedad_medio_trans_banco'), ['class' => '']) !!}
                        {!! Form::text('inf_pago[banco]', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inf_pago[pais_id]', __('propiedad_create.propiedad_medio_trans_pais_id'), ['class' => '']) !!}
                        {!! Form::select('inf_pago[pais_id]', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (count(Auth::user()->medio_cobro_transferencia) > 0)
<div class="row">
    <div class="col-md-12">
        <h6>Elegir medio registrado</h6>
        <table style="margin-top: 15px" class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th width="15px" align="center">&nbsp;</th>
                    <th width="15%">Medio de Cobro</th>
                    <th>Información</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach (Auth::user()->medio_cobro_transferencia as $medio)
                <tr>
                    <td style="vertical-align: middle;">
                        <div class="radio" >
                            {!!Form::radio('medio', $medio->id,  false,["id"=>"medio_".$medio->id]) !!}
                            <label for='{{"medio_".$medio->id}}'  ></label>
                        </div>
                    </td>
                    <td style="vertical-align: middle;">{{ $medio->metodo->descripcion }}</td>
                    <td style="vertical-align: middle;">
                        @if($medio->metodo->id == 1)
                        {{  $medio->titular }}, {{  $medio->banco }}, ... {{ substr( $medio->nro_cuenta, -4) }}
                        @elseif ($medio->metodo->id == 2)
                        {{  $medio->persona }}, {{  $medio->direccion }}
                        @endif
                    </td>
                    <td>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{--
****** OCULTO TEMPORALMENTE MIENTRAS SE EXPLICA DE MEJOR MANERA *****

<h6>Reserva Inmediata</h6>
<div class="row dividingMetodos">
    <div class="col-md-3 noPaddRight">
        {!! Form::checkbox('reserva_automatica', true, false, ['class' => 'checkAdicionales', 'id' => 'reserva_automatica']) !!}
        {!! Form::label('reserva_automatica', '¿Ofreces reserva inmediata?', []) !!}
    </div>
    <div class="col-md-1 noPaddLeft">
        <span class="masterTooltip" title="Seleccionando esta opción tu propiedad queda reservada de forma automática cuando un huésped confirme su reserva, nosotros nos encargaremos de avisarte cuando esto ocurra."><i class="fa fa-question-circle" aria-hidden="true"></i></span>
    </div>
</div>


<h6>@lang('propiedad_create.propiedad_administracion_costos_otros')</h6>
<p class="serAdTxtHelp">@lang('propiedad_create.propiedad_administracion_costos_otros_ht')</p>

<div class="row dividingMetodos">
    @foreach ($conceptos as $concepto)
    <div class="col-md-2 col-xs-6 tarifa">
        {!! Form::checkbox('checkPrecio'.$concepto->id, true, null, ['class' => 'check-tarifa', 'id' => 'checkPrecio'.$concepto->id]) !!}
        {!! Form::label('checkPrecio'.$concepto->id, $concepto->concepto, ['id' => '']) !!}

        <div class="costo collapse">
            <div class="form-group">
                {!! Form::text('concepto_costo['.$concepto->id.']', null, ['class' => 'form-control moneda checkPrecio'.$concepto->id, 'disabled' => 'disabled', 'placeholder' => '$ 0']) !!}
            </div>
        </div>
    </div>
    @endforeach
</div>
--}}

<div class="row">
    <div class="col-xs-12 col-md-2">
        <div class="form-group">
            {!! Form::label('precio', __('propiedad_create.propiedad_administracion_precio'), ['class' => '']) !!}
            {!! Form::text('precio', null, ['class' => 'form-control moneda precioInputPublicando', 'min' => 0, 'placeholder' => '$ 0']) !!}
        </div>
    </div>

    <div class="col-xs-12 col-md-2">
        <div class="form-group">
            {!! Form::label('moneda_propiedad', '&nbsp;', ['class' => '']) !!}
            {!! Form::select('moneda_propiedad', $monedas, session('moneda') ?? null, ['class' => 'form-control precioInputPublicando', 'min' => 0]) !!}
        </div>
    </div>

    <div class="col-xs-12 col-md-2">
        <div class="form-group">
            {!! Form::label('aseo_unico', __('propiedad_create.propiedad_administracion_aseo_unico'), ['class' => '']) !!}
            {!! Form::text('aseo_unico', null, ['class' => 'form-control moneda precioInputPublicando', 'min' => 0, 'placeholder' => '$ 0']) !!}
        </div>
    </div>
    <div class="col-xs-6 col-md-2">
        <div class="form-group">
            <label for="noches_minimas">@lang('propiedad_create.propiedad_administracion_noches_minimas') <span class="masterTooltip" title="Señala a tus huéspedes la cantidad de noches mínimas requeridas para reservar. Siempre ten en cuenta la temporada."><i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
            {!! Form::number('noches_minimas', null, ['class' => 'form-control', 'min' => 0, 'max' => 365, 'maxlength' => 2]) !!}
        </div>
    </div>
    <div class="col-xs-6 col-md-3">
        <div class="form-group">
            <label for="dias_intervalo">@lang('propiedad_create.propiedad_administracion_dias_intervalo') <span class="masterTooltip" title="Indica a tus huéspedes los días sin ocupación que permites entre una reserva y otra."><i class="fa fa-question-circle" aria-hidden="true"></i></span> </label>
            {!! Form::number('dias_intervalo', null, ['class' => 'form-control', 'min' => 0, 'max' => 10, 'maxlength' => 2]) !!}
        </div>
    </div>
</div>

<h5>Totales</h5>

<div class="totalizando">

    <div class="row">
        <div class="col-md-7">
            <h6>@lang('propiedad_create.propiedad_administracion_base')</h6>
        </div>
        <div class="col-md-5">
            <div class="precioBig precioBigOtherColor">$<span class="base">0</span> <small class="moneda_iso">CLP</small></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <h6>@lang('propiedad_create.propiedad_administracion_comision')</h6>
            <div>@lang('propiedad_create.propiedad_administracion_comision_help_text',['comision-porcentaje'=>7])</div>
        </div>
        <div class="col-md-5">
            <div class="precioBigOtherColor">$<span class="comision">0</span>  <small class="moneda_iso">CLP</small></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <hr>
            <h6>@lang('propiedad_create.propiedad_administracion_ingreso')</h6>
        </div>
        <hr class="hidden-xs">
        <div class="col-md-5">
            <div class="precioBig">$<span class="ingreso">0</span> <small class="moneda_iso">CLP</small></div>
        </div>
    </div>

</div>
