@extends('propiedades.edit')

@section('seccion_a_editar')

	{!! Form::model($propiedad,['route' => ['propiedad.actualizar.administracion',$propiedad->id],"class"=>"form_editar_seccion","id"=>"form_administracion","name"=>"form_administracion","callback"=>"callback_actualizar_datos(result)"]) !!}


		<?php

        $anfitrion = "usuario";
        $anfitrion_usuario = true;
        $anfitrion_otro = false;
        $anfitrion_mybooktravel = false;

        $prefijo_guardado = "";
        $telefono_guardado = "";
        $nombre_anfitrion = "";
        $correo_anfitrion = "";
        if ($propiedad->anfitriones()->count() > 0) {
            $anfitrion = "otro";
            $anfitrion_otro = true;
            $anfitrion_usuario = false;
            // $partes = explode(" ", $propiedad->anfitriones->telefono_anfitrion);
            // $prefijo_guardado = str_replace(['(',')'],['',''],$partes[0]);
            // $telefono_guardado = isset($partes[1]) ? $partes[1] : "" ;
            $telefono_guardado = $propiedad->anfitriones->telefono_anfitrion;

            $nombre_anfitrion = $propiedad->anfitriones->nombre_anfitrion;
            $correo_anfitrion = $propiedad->anfitriones->correo_anfitrion;
        }

        $noches_minimas = 0;
        $dias_intervalo = 1;
        $precio = 1;
        $aseo_unico = 0;
        $total_a_pagar = 0;
        $comision = 0;
        $ingreso_total = 0;
        $reserva_automatica = 0;
        $oferta_propiedad_id = 0;
        $garantia_reserva_id = 0;
        $tipo_metodo_cobro_id = 0;
        $metodo_cobro_id = 0;
        // $porcentaje = $propiedad::$porcentaje_comision;
        $porcentaje = $PorcentajePublicacion;
        if ($propiedad->administracion()->count() > 0) {
            $anfitrion = $propiedad->administracion()->first()->anfitrion;
            if ($anfitrion == "mybooktravel") {
                $anfitrion_mybooktravel = true;
                $anfitrion_usuario = false;
                $anfitrion_otro = false;
                // $porcentaje = $propiedad::$porcentaje_comision_anfitrion_mybooktravel;
                $porcentaje = $PorcentajePublicacion;
            }
            // echo "aqui '$anfitrion_mybooktravel'";

            $noches_minimas = $propiedad->administracion()->first()->noches_minimas;
            $dias_intervalo = $propiedad->administracion()->first()->dias_intervalo;
            $precio = $propiedad->administracion()->first()->precio;
            $moneda = $propiedad->administracion()->first()->moneda;
            $aseo_unico = $propiedad->administracion()->first()->aseo_unico;
            $total_a_pagar = $precio + $aseo_unico;
            $comision = $propiedad->administracion()->first()->comision;
            $ingreso_total = $propiedad->administracion()->first()->ingreso_total;
            $reserva_automatica = $propiedad->administracion()->first()->reserva_automatica;
            $oferta_propiedad_id = $propiedad->administracion()->first()->oferta_propiedad_id;
            $garantia_reserva_id = $propiedad->administracion()->first()->garantia_reserva_id;

            $tipo_metodo_cobro_id = $propiedad->administracion()->first()->usuario_metodo_cobro_id;
            if ($propiedad->metodosCobroTransferencia->count()>0) {
                $metodo_cobro_id = $propiedad->metodosCobroTransferencia->first()->d_usuarios_metodos_cobros_transferencia_id;
            }
        }
        // echo "PorcentajePublicacion $PorcentajePublicacion";
        ?>

		<h3>

			<span class="hidden-xs">@lang('propiedad_create.administracion_h5')</span>
		</h3>

		<div>
			<h1 class="visible-xs">@lang('propiedad_create.administracion_h5')</h1>
			<h5>@lang('propiedad_create.administracion_h5')</h5>

			<div class="row">
				<div class="col-md-2">
					{!!Form::radio('anfitrion', 'usuario', $anfitrion_usuario, ["id"=>"anfitrion_usuario", "class"=>"variablesQueAfectanPrecioTotal"] ) !!}
					{!! Form::label('anfitrion_usuario', __('propiedad_create.propiedad_administracion_anfitrion_0')) !!}
				</div>
				<div class="col-md-3">
					{!!Form::radio('anfitrion', 'otro', $anfitrion_otro, ["id"=>"anfitrion_otro", "class"=>"variablesQueAfectanPrecioTotal"] ) !!}
					{!! Form::label('anfitrion_otro', __('propiedad_create.propiedad_administracion_anfitrion_1')) !!}
				</div>
				<div class="col-md-3">
					{!! Form::radio('anfitrion', 'mybooktravel', $anfitrion_mybooktravel, ['id' => 'anfitrion_mybooktravel', "class"=>"variablesQueAfectanPrecioTotal"]) !!}
					{!! Form::label('anfitrion_mybooktravel', __('propiedad_create.propiedad_administracion_anfitrion_2')) !!}
				</div>
			</div>

			<div id="anfitrionDatos" class="row anotherMan ">
				<div class="col-md-12">
					<h6>@lang('propiedad_create.anfitrion_h6')</h6>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('nombre_anfitrion', '', ['class' => 'sr-only']) !!}
						{!! Form::text('nombre_anfitrion', null, ['class' => 'form-control','id' => 'nombre_anfitrion', 'placeholder' => 'Nombre', 'disabled' => true, 'maxlength' => 50]) !!}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('telefono_anfitrion', '', ['class' => 'sr-only']) !!}
						{!! Form::text('telefono_anfitrion', null, ['class' => 'form-control','id' => 'telefono_anfitrion', 'placeholder' => 'Teléfono / Whatsapp', 'disabled' => true,'maxlength' => 15 ]) !!}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('correo_anfitrion', '', ['class' => 'sr-only']) !!}
						{!! Form::text('correo_anfitrion', null, ['class' => 'form-control minusculas','id' => 'correo_anfitrion', 'placeholder' => 'Correo', 'disabled' => true, 'maxlength' => 60]) !!}
					</div>
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

							{!! Form::radio('oferta_propiedad_id', $oferta->id, $oferta->id == $oferta_propiedad_id ? true: false, ['id' => "oferta_id".$oferta->id, 'class' => 'check-tipo-oferta']) !!}
							<label for='{{"oferta_id".$oferta->id}}' class="{{$classArray[$loop->index]}} form-control" >{{ $oferta->titulo }}</label>

					@endforeach


				</div>

				<div class="col-md-6 finalDesc">

					<div class="ayudaOferta mensaje_ayuda_tipo_oferta">@lang('propiedad_create.propiedad_administracion_ayuda_oferta')</div>
					<div class="ayudaOferta_1 mensaje_ayuda_tipo_oferta">@lang('propiedad_create.propiedad_administracion_tipo_oferta_ayuda1')</div>
					<div class="ayudaOferta_2 mensaje_ayuda_tipo_oferta">@lang('propiedad_create.propiedad_administracion_tipo_oferta_ayuda2')</div>
					<div class="ayudaOferta_3 mensaje_ayuda_tipo_oferta">@lang('propiedad_create.propiedad_administracion_tipo_oferta_ayuda3')</div>

				</div>
			</div>

			<div class="row dividingMetodos">

				<div class="col-md-6">

					<h6>Pago de garantía de reserva</h6>

					@foreach ($metodoGarantia as $garantia)
						{!! Form::radio('garantia_reserva_id', $garantia->id, $garantia->id == $garantia_reserva_id ? true : false, ["id"=>"garantia_reserva_".$garantia->id, 'class' => 'check-garantia']) !!}
						<label for='{{"garantia_reserva_".$garantia->id}}' >{{ $garantia->descripcion }}</label>
					@endforeach

				</div>

				<div class="col-md-6 finalDesc">
					<div class="ayudaGarantia mensaje_ayuda_garantia">@lang('propiedad_create.propiedad_administracion_ayuda_garantia')</div>
					<div class="ayudaGarantia_1 mensaje_ayuda_garantia">@lang('propiedad_create.propiedad_administracion_pago_garantia_ayuda1')</div>
					<div class="ayudaGarantia_2 mensaje_ayuda_garantia">@lang('propiedad_create.propiedad_administracion_pago_garantia_ayuda2')</div>
					<div class="ayudaGarantia_3 mensaje_ayuda_garantia">@lang('propiedad_create.propiedad_administracion_pago_garantia_ayuda3')</div>
				</div>

			</div>

			<div class="row radioAlign dividingMetodos" id="metodoPagoSeccion">

				<div class="col-md-6">

					<h6>@lang('propiedad_create.recibir_dinero_h6')</h6>


					{!!Form::radio('medio', 'transferencia', false,["id"=>"medio_transferencia"]) !!}
					<label for="medio_transferencia" class="transfer">Transferencia electrónica</label>

					{{--
					{!!Form::radio('medio', 'wu', false,["id"=>"medio_wu"]) !!}
					<label for="medio_wu" class="western">Western Union</label>
					--}}

				</div>

				<div class="col-md-6 finalDesc"  >
					<div class="dependientesMetodoCobro dependientesMetodoCobro_ninguno">
						Haz click en un Método para saber más información.
					</div>
					<div class="dependientesMetodoCobro dependientesMetodoCobro_transferencia ">
						Transferencia
					</div>
					<div class="dependientesMetodoCobro dependientesMetodoCobro_wu ">
						Texto de ayuda de western union
					</div>
				</div>

				<div class="col-md-12 dividingMetodos_2">

					<div class="dependientesMetodoCobro dependientesMetodoCobro_wu">
						<div class="row">
							<div class="col-md-12">
								<h6>Western Union</h6>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('inf_pago[persona]', __('propiedad_create.propiedad_medio_wu_persona'), ['class' => '']) !!}
									{!! Form::text('inf_pago[persona]', null, ['class' => 'form-control','placeholder' => '']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('inf_pago[direccion]', __('propiedad_create.propiedad_medio_wu_direccion'), ['class' => '']) !!}
									{!! Form::text('inf_pago[direccion]', null, ['class' => 'form-control','placeholder' => '']) !!}
								</div>
							</div>
						</div>
					</div>

					<div class="dependientesMetodoCobro dependientesMetodoCobro_transferencia">
						<div class="row">
							<div class="col-md-12">
								<h6>Transferencia Electrónica</h6>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('inf_pago[titular]', __('propiedad_create.propiedad_medio_trans_titular'), ['class' => '']) !!}
									{!! Form::text('inf_pago[titular]', null, ['class' => 'form-control','placeholder' => '', 'maxlength' => 100]) !!}
								</div>

								<div class="form-group">
									{!! Form::label('inf_pago[tipo_cuenta]', __('propiedad_create.propiedad_medio_trans_tipo_cuenta'), ['class' => '']) !!}
									{!! Form::text('inf_pago[tipo_cuenta]', null, ['class' => 'form-control','placeholder' => '', 'maxlength' => 100]) !!}
								</div>

								<div class="form-group">
									{!! Form::label('inf_pago[email_beneficiario]', __('propiedad_create.propiedad_medio_trans_email_beneficiario'), ['class' => '']) !!}
									{!! Form::email('inf_pago[email_beneficiario]', null, ['class' => 'form-control','placeholder' => '', 'maxlength' => 100]) !!}
								</div>

								<div class="form-group">
									{!! Form::label('inf_pago[identificacion]', __('propiedad_create.propiedad_medio_trans_identificacion'), ['class' => '']) !!}
									{!! Form::text('inf_pago[identificacion]', null, ['class' => 'form-control','placeholder' => '', 'maxlength' => 100]) !!}
								</div>

							</div>
							<div class="col-md-6">

								<div class="form-group">
									{!! Form::label('inf_pago[nro_cuenta]', __('propiedad_create.propiedad_medio_trans_nro_cuenta'), ['class' => '']) !!}
									{!! Form::text('inf_pago[nro_cuenta]', null, ['class' => 'form-control','placeholder' => '', 'maxlength' => 100]) !!}
								</div>

								<div class="form-group">
									{!! Form::label('inf_pago[banco]', __('propiedad_create.propiedad_medio_trans_banco'), ['class' => '']) !!}
									{!! Form::text('inf_pago[banco]', null, ['class' => 'form-control','placeholder' => '', 'maxlength' => 100]) !!}
								</div>

								<div class="form-group">
									{!! Form::label('inf_pago[pais_id]', __('propiedad_create.propiedad_medio_trans_pais_id'), ['class' => '']) !!}
									{!! Form::select('inf_pago[pais_id]', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país']) !!}
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="row">
					{!! Form::label('otros_medios_cobro', 'Elegir medio registrado', ['class' => 'control-label col-md-4']) !!}
					<div class="col-md-12">
						<table class="table table-condensed table-striped tablaMetodosCobro">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>Medio de Cobro</th>
									<th>Información</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach (Auth::user()->medio_cobro_transferencia as $medio)
								<tr>
									<td style="vertical-align: middle;">
										<div class="radio" >
											{!!Form::radio('medio', $medio->id, $medio->id == $metodo_cobro_id ? true : false,["id"=>"medio_".$medio->id]) !!}
											<label for='{{"medio_".$medio->id}}'  ></label>
										</div>
									</td>
									<td style="vertical-align: middle;" >{{ $medio->metodo->descripcion }}</td>
									<td style="vertical-align: middle;" >
										@php
											// $variable = json_decode($medio->info_pago, true);
											// $variable = collect($variable);
											// $variable = $medio->info_pago;
										@endphp
										@if($medio->metodo->id == 1)
											{{  $medio->titular }}, {{  $medio->banco }}, XXXX XXXX XXXX {{ substr( $medio->nro_cuenta, -4) }}
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

			</div>

			<div class="row dividingMetodos">
				<div class="col-md-12">
					<div class="col-md-3 noPaddRight">
						{!! Form::checkbox('reserva_automatica', true,  $reserva_automatica, ['id' => 'reserva_automatica','class' => '']) !!}
						<label for="reserva_automatica">¿Ofreces reserva inmediata?</label>
					</div>
					<div class="col-md-1 noPaddLeft">
						<span class="masterTooltip" title="Seleccionando esta opción tu propiedad quede reservada de forma automática cuando un huésped confirme su reserva, nosotros nos encargaremos de avisarte cuando esto ocurra."><i class="fa fa-question-circle" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>

			<h6 class="hide" >Servicios adicionales</h6>

			<p class="hide" >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

			<div class="row dividingMetodos hide">

				@foreach ($conceptos as $concepto)

					@php
					$checked = false;
					$visibility = "";
					$disabled = "disabled";
					$value = "";
					if($propiedad->costos()->where('conceptos_cobros_id',$concepto->id)->count() > 0)
					{
						$checked = true;
						$visibility = "mostrar_al_inicio";
						$disabled = "";
						$data=$propiedad->costos()->where('conceptos_cobros_id',$concepto->id)->first()->toArray();
						$value = $data["valor"];
					}

					@endphp

					<div class="col-md-2 col-xs-6 tarifa">

						{!! Form::checkbox('checkPrecio'.$concepto->id, true, $checked, ["id"=> "checkPrecio_".$concepto->id ,'class' => 'check-tarifa']) !!}

						<label for='{{"checkPrecio_".$concepto->id}}' >{{$concepto->concepto}}</label>

						<div class="adicionalesInput5 {{$visibility}} costo">
							{!! Form::text('concepto_costo['.$concepto->id.']', $value, ['class' => ' checkPrecio'.$concepto->id, $disabled => $disabled, 'placeholder' => '$',"maxlength"=>"5"]) !!}
						</div>
					</div>

				@endforeach

			</div>

			<div class="row">
				<div class="col-xs-12 col-md-3">
					<div class="form-group">
						{!! Form::label('precio', __('propiedad_create.propiedad_administracion_precio'), ['class' => '']) !!}
						{!! Form::text('precio', $precio, ['id' => 'precio', 'class' => 'form-control variablesQueAfectanPrecioTotal moneda precioInputPublicando ', "min"=>"1",'placeholder' => '$ 0']) !!}
					</div>
				</div>

				<div class="col-xs-12 col-md-2">
			        <div class="form-group">
			            {!! Form::label('moneda_propiedad', '&nbsp;', ['class' => '']) !!}
			            {!! Form::select('moneda_propiedad', $monedas, $moneda, ['class' => 'form-control precioInputPublicando', 'min' => 0]) !!}
			        </div>
			    </div>

				<div class="col-xs-12 col-md-2">
					<div class="form-group">
						{!! Form::label('aseo_unico', __('propiedad_create.propiedad_administracion_aseo_unico'), ['class' => '']) !!}
						{!! Form::text('aseo_unico', $aseo_unico, ['class' => 'form-control variablesQueAfectanPrecioTotal moneda precioInputPublicando', 'min' => 0, 'placeholder' => '$ 0']) !!}
					</div>
				</div>
				<div class="col-xs-6 col-md-2">
					<div class="form-group">
						{!! Form::label('noches_minimas', __('propiedad_create.propiedad_administracion_noches_minimas'), ['class' => '']) !!}
						{!! Form::number('noches_minimas', $noches_minimas, ['placeholder' => 'Ej: 7', "min"=>"1", "max"=>365, "maxlength"=>"2"]) !!}
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="form-group">
						{!! Form::label('dias_intervalo', __('propiedad_create.propiedad_administracion_dias_intervalo'), ['class' => '']) !!}
						{!! Form::number('dias_intervalo', $dias_intervalo, ['placeholder' => 'Ej: 7', "min"=>"0", "max"=> 10, "maxlength"=>"2"]) !!}
					</div>
				</div>
			</div>

			<h5>Totales</h5>

			<div class="totalizando">

				<div class="row">
					<div class="col-md-7">
						<h6>@lang('propiedad_create.propiedad_administracion_base')</h6>
						{{--<p>@lang('propiedad_create.propiedad_administracion_base_help_text')</p>--}}
					</div>
					<div class="col-md-5">
						<div class="precioBig precioBigOtherColor">$<span class="base valor"></span> <small class="moneda_iso">CLP</small></div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-7">
						<h6>@lang('propiedad_create.propiedad_administracion_comision')</h6>
						<div>@lang('propiedad_create.propiedad_administracion_comision_help_text',['comision-porcentaje'=>$porcentaje])</div>
					</div>
					<div class="col-md-5">
						<div class="precioBigOtherColor">$<span class="comision"></span>  <small class="moneda_iso">CLP</small></div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-7">
						<hr>
						<h6>@lang('propiedad_create.propiedad_administracion_ingreso')</h6>
						{{--<div>@lang('propiedad_create.propiedad_administracion_ingreso_help_text')</div>--}}
					</div>
					<hr class="hidden-xs">
					<div class="col-md-5">
						<div class="precioBig">$<span class="ingreso"></span> <small class="moneda_iso">CLP</small></div>
					</div>
				</div>

			</div>

		</div>

		<div class="col-md-2 col-md-offset-10">
		   <button type="button" onclick="validar_antes_de_enviar()">Guardar</button>
		   <button class="hide" id="boton_envio_formulario" >Guardar</button>
		</div>

	{!! Form::close() !!}

@endsection

@push('css')

	<style>
	</style>

@endpush

@push('js')

	{!! Html::script('plugins/mask/src/jquery.mask.js') !!}

	{!! Html::script('plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
	{!! Html::script('plugins/inputmask/dist/inputmask/phone-codes/phone.js') !!}
	{!! Html::script('plugins/inputmask/dist/inputmask/phone-codes/phone-be.js') !!}
	{!! Html::script('plugins/inputmask/dist/inputmask/phone-codes/phone-ru.js') !!}

	{!! Html::script('plugins/numbers/jquery.number.min.js') !!}

	<script>

		$( document ).ready(function() {

			//ANFITRION
			// console.log("'"+$('input[name=anfitrion]:checked').val()+"'");
			if($('input[name=anfitrion]:checked').val() == "otro")
			{
				div = $('#anfitrionDatos');
				// div.collapse('show');
				$(div).slideDown();
				div.find('input').attr('disabled', false);
			}

			$('#nombre_anfitrion').val('{{$nombre_anfitrion}}');
			$('#correo_anfitrion').val('{{$correo_anfitrion}}');

			var prefijo_guardado = "{{$prefijo_guardado}}";
			var telefono_guardado = "{{$telefono_guardado}}";
			var prefijo_pais = "{{$propiedad->prefijo_telefono}}";
			$('#telefono_anfitrion').val(telefono_guardado);

			// if(prefijo_guardado == prefijo_pais)
			// {
				// $('#telefono_anfitrion').val(telefono_guardado);
			// }
			// else
			// {
				// $('#telefono_anfitrion').val('');
			// }

			// $('#telefono_anfitrion').unmask();

			$('#telefono_anfitrion').mask('({{$propiedad->prefijo_telefono}}) 00000000000', {
				placeholder: '({{$propiedad->prefijo_telefono}}) '
			});

			//TIPO OFERTA
			if($('input[name=oferta_propiedad_id]:checked').length > 0 )
			{
				var val = $('input[name=oferta_propiedad_id]:checked').val();
				$(".mensaje_ayuda_tipo_oferta").hide();
				$(".ayudaOferta_"+val).slideDown();
			}

			//GARANTIA
			if($('input[name=oferta_propiedad_id]:checked').length > 0 )
			{
				var val = $('input[name=garantia_reserva_id]:checked').val();
				$(".mensaje_ayuda_garantia").hide();
				$(".ayudaGarantia_"+val).slideDown();
			}

			//MEDIO DE COBRO
			$(".dependientesMetodoCobro").hide();
			$(".dependientesMetodoCobro_ninguno").slideDown();

			//SERVICIOS ADICIONALES
			$(".mostrar_al_inicio").slideDown();

			$('.moneda').inputmask({
				alias: 'integer',
				groupSeparator: ',',
				autoGroup: true,
				digitsOptional: true,
				prefix: '$ ',
				placeholder: '0',
			});

			//se genera el click para que actualice los totales que vienen de la base de datos
			$('.variablesQueAfectanPrecioTotal').keyup();

		});

		//ANFITRION
		$('input[name=anfitrion]').on('change', function(event) {
			var div = $('#anfitrionDatos');
			if ($(this).val() == 'otro')
			{
				// div.collapse('show');
				$(div).slideDown();
				div.find('input').attr('disabled', false);
			}
			else
			{
				// div.collapse('hide');
				$(div).slideUp();
				div.find('input').attr('disabled', true);
			}
		});

		//TIPO OFERTA
		$(".check-tipo-oferta").on("change",function(event) {
			$(".mensaje_ayuda_tipo_oferta").hide();
			if (this.checked)
			{
				$(".ayudaOferta_"+this.value).slideDown();
			}
		});

		//GARANTIA
		$(".check-garantia").on("change",function(event) {
			$(".mensaje_ayuda_garantia").hide();
			if (this.checked)
			{
				$(".ayudaGarantia_"+this.value).slideDown();
			}
		});

		//MEDIO DE COBRO
		$('input:radio[name=medio]').on('change', function(event) {

			$('.dependientesMetodoCobro').find('input').attr('disabled', true);
			$('.dependientesMetodoCobro').slideUp();

			var wu = $('.dependientesMetodoCobro_wu');
			var transferencia = $('.dependientesMetodoCobro_transferencia');

			if ($(this).val() == 'wu')
			{
				transferencia.find('input').attr('disabled', true);
				transferencia.slideUp();

				wu.find('input').attr('disabled', false);
				wu.slideDown();

			}
			if($(this).val() == 'transferencia')
			{
				wu.find('input').attr('disabled', true);
				wu.slideUp();

				transferencia.find('input').attr('disabled', false);
				transferencia.slideDown();
			}

		});

		//SERVICIOS ADICIONALES
		$('.check-tarifa').on('change', function(event) {
			event.preventDefault();
			var check = $(this);
			var inputParent = check.parents('div.tarifa').find('.costo');
			if (check.prop('checked'))
			{
				inputParent.slideDown();
				var state = false;
			}
			else
			{
				inputParent.slideUp();
				var state = true;
			}
			inputParent.find('input:text').attr('disabled', state);
		});

		function quitarFormato(value)
		{
			return parseInt((value).replace('$', '').replace(',', ''));
		}
		$('.variablesQueAfectanPrecioTotal').on('click change keyup', function(event) {

			// console.clear();

			var anfitrion = $("input[type=radio][name='anfitrion']:checked").val();
			// console.log("anfitrion "+anfitrion);
			// var porcentaje = anfitrion == "mybooktravel" ? {{$propiedad::$porcentaje_comision_anfitrion_mybooktravel}} : {{$propiedad::$porcentaje_comision}};
			var porcentaje = {{$PorcentajePublicacion}};
			// console.log("porcentaje "+porcentaje);
			// console.log( "precio real '" + $('#precio').val()+"'" );
			var precio = $('#precio').val() != "" ? quitarFormato($('#precio').val()) : 0;
			// console.log("precio "+precio);
			// console.log( "aseo unico real '" + $('#aseo_unico').val()+"'"  );
			var aseo_unico = $('#aseo_unico').val() != "" ? quitarFormato($('#aseo_unico').val()) : 0;
			// console.log("aseo_unico "+aseo_unico);

			// var total_a_pagar = precio + aseo_unico;
			var total_a_pagar = precio;
			// console.log("total_a_pagar "+total_a_pagar);
			var comision = ( total_a_pagar / 100 )  * porcentaje;
			// console.log("comision "+comision);
			var ingreso = total_a_pagar + comision ;
			// console.log("ingreso "+ingreso);

			$('.valor').html(ponerFormatoMonto(total_a_pagar));
			$('.comision').html( ponerFormatoMonto(comision) );
			$('.ingreso').html( ponerFormatoMonto(ingreso) );
			$('#comision-porcentaje').html( ponerFormatoMonto(porcentaje) );

		});

		function ponerFormatoMonto(monto)
		{
			return numberFormat(parseInt(monto),2,'.',',');
		}
		function numberFormat(number,amountOfDecimals, decimalSeparator, thousandSeparator)
		{
			decimalSeparator = typeof decimalSeparator !== 'undefined' ? decimalSeparator : '.';
			thousandSeparator = typeof thousandSeparator !== 'undefined' ? thousandSeparator : ',';

			var parts = number.toFixed(amountOfDecimals).split('.');
			parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);

			return parts.join(decimalSeparator);
		}

		function validar_antes_de_enviar()
		{
			console.log("valida");

			if ($('input[name=medio]:checked').length == 0)
			{
				swal({
					type: 'info',
					title: 'Espera!',
					text: 'no seleccionaste un medio de pago!',
					animation:false,
					}, function() {
					$('html, body').animate({
						scrollTop: ($('#metodoPagoSeccion').offset().top  - 140) + 'px'
					}, 'fast');
				});
			}
			else
			{
				document.querySelector("#boton_envio_formulario").click();
			}

		}

	</script>

	{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
	{!! JsValidator::formRequest('App\Http\Requests\PropiedadActualizarAdministracionRequest', '#form_administracion'); !!}

@endpush
