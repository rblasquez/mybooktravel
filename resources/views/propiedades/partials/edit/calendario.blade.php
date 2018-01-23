@extends('propiedades.edit')

@section('seccion_a_editar')

	@php
		# function isWeekend($date)
		# {
		# $timestamp =strtotime($date);
		# echo date('w', $timestamp);
		# }

		# use Carbon\Carbon;

		# $finde = isWeekend('2017-10-09');
		# $finde = Carbon::parse('2017-10-07')->isWeekend();
		# echo "2017-10-05: '$finde'";
	@endphp

	<div class="row contenedor_calendario" style="padding-top:1em;">
		<div id='calendar'></div>
	</div>

	<!-- Modal crear eventos -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">¿Que deseas Hacer?</h4>
				</div>

				<div class="modal-body">

					<div class="row">

						{{csrf_field()}}

						<div class="form-group ">
							<div class="col-md-3">
								<div class="radio">
									<input type="radio" id="accion_precio" name="accion_calendario" tipo="precios_especificos" motivo="precio" >
									<label for="accion_precio" class="accion_por_defecto" >Modificar Precio</label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="radio">
									<input type="radio" id="accion_estadia" name="accion_calendario" tipo="noches_minimas" motivo="noches_minimas" >
									<label for="accion_estadia" >Estadía Mínima</label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="radio">
									<input type="radio" id="accion_reserva" name="accion_calendario" tipo="reservas_manuales" motivo="reserva" >
									<label for="accion_reserva" >Registrar Reserva</label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="radio">
									<input type="radio" id="accion_bloqueo" name="accion_calendario" tipo="reservas_manuales" motivo="bloqueo" >
									<label for="accion_bloqueo" >Bloquear</label>
								</div>
							</div>
						</div>


					</div>

					<div class="row">
						<div class="col-md-12">
							<div id="contenedor_formulario_calendario"></div>
						</div>
					</div>

				</div>

				<div class="modal-footer hide">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>

			</div>
		</div>
	</div>

	<!-- Modal editar eventos -->
	<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Edicion</h4>
				</div>

				<div class="modal-body">

					<div class="row">
						<div class="col-md-12">

							{{csrf_field()}}

							<div id="contenedor_formulario_calendario_edicion">
							</div>

						</div>
					</div>

				</div>

				<div class="modal-footer hide">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>

			</div>
		</div>
	</div>

	<!-- Modal mostrar reservas mybooktravel -->
	<div class="modal fade" id="myModalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Reserva Mybooktravel</h4>
				</div>

				<div class="modal-body">

					<div class="row">
						<div class="col-md-12">

							<div id="contenedor_formulario_reserva_mybooktravel">
							</div>

						</div>
					</div>

				</div>

				<div class="modal-footer hide">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>

			</div>
		</div>
	</div>

	<div id="contenedor_leyenda_calendario" class='hide'>
		<div class='row leyenda_calendario'>
			<div class='col-sm-offset-2 col-md-3'>
				<li style="color:#0FD8A8;list-style-type: square;">Reserva Manual</li>
			</div>
			<div class='col-md-3' >
				<li style="color:#0EC8DB;list-style-type: square;">Reserva Mybooktravel</li>
			</div>
			<div class='col-md-3' >
				<li style="color:#BCBEC0;list-style-type: square;">Bloqueada</li>
			</div>
		</div>
	</div>

	<div class="hide">
		<input type="text" id="checkin_" name="checkin_" value="{{ $propiedad->detalles->checkin }}" >
		<input type="text" id="checkout_" name="checkout_" value="{{ $propiedad->detalles->checkout }}" >
		<input type="text" id="fecha_inicio_" name="fecha_inicio_" value="" >
		<input type="text" id="fecha_inicio_formato_" name="fecha_inicio_formato_" value="" >
		<input type="text" id="fecha_fin_" name="fecha_fin_" value="" >
		<input type="text" id="fecha_fin_formato_" name="fecha_fin_formato_" value="" >
		<input type="text" id="noches_" name="noches_" value="" >
		<input type="text" id="id_fc_evento_en_edicion_" name="id_fc_evento_en_edicion_" value="" >

		<a href="{{route('propiedad.calendario.obtener.eventos',['id'=>$propiedad->id])}}" class="rutaObtenerEventosCalendario" ></a>
		<a href="{{route('propiedad.calendario.obtener.formulario',['id'=>$propiedad->id])}}" class="rutaObtenerFormularioCalendario" ></a>
		<a href="{{route('propiedad.calendario.eliminar.evento',['id'=>$propiedad->id])}}" class="rutaEliminarEventoCalendario" ></a>
		<a href="{{route('propiedad.obtener.precios',['id'=>$propiedad->id])}}" class="rutaObtenerPreciosPropiedad" ></a>
		<a href="{{route('propiedad.obtener.noches',['id'=>$propiedad->id])}}" class="rutaObtenerNochesPropiedad" ></a>

	</div>
@endsection

@push('css')

	<style>
		.formPublicar select,
		.formPublicar textarea,
		.formPublicar select,
		.formPublicar input,
		.formPublicar iframe {
			margin: 0px !important;
		}

		#calendar
		{
			max-width: 900px;
			margin: 0 auto;
		}
		.mensaje_modificacion_precio
		{
			color: #000000 !important;
			font-size:10px !important;
		}
		.contenedor_calendario button
		{
			width: auto;
		}
		/*inicio numeros en la celda del dia*/
		.contenedor_precio_calendario
		{
			font-size: .7em !important;
			position:absolute;
			bottom:2.5%;
		}
		.contenedor_noches_minimas_calendario
		{
			font-size: .7em !important;
			position:absolute;
			top:3.5%;
		}
		/*fin numeros en la celda del dia*/

		/*.date-picker-wrapper.single-date.no-shortcuts.single-month.has-gap,
		.date-picker-wrapper.no-shortcuts.no-gap.single-month */
		.date-picker-wrapper{
			z-index: 1051 !important;
		}

		.fc-event-container
		{
			cursor:pointer;
		}
		.fc-right
		{
			font-size: 30px;
		}
		.fc-center h2
		{
			text-transform:capitalize;
			font-size:20px;
		}
		.fc-toolbar.fc-header-toolbar
		{
			text-align: center;
		}
		.leyenda_calendario div
		{
			float:left;
		}
		.fc-day
		{
			background-color:#F1F2F2;
		}
		.fc-day.fc-other-month
		{
			background-color:#F1F2F2;
			opacity: 0.2;
			filter: alpha(opacity=20);
		}
		.fc-bgevent
		{
			/*background-color:transparent !important;*/
		}
		.fc-bgevent .contenedor_imagen_evento
		{
			visibility:hidden;
		}
		.contenedor_imagen_evento
		{
			height: 24px;
			width: 24px;
			border: 2px solid #a1a1a1;
			background: #ffffff;
			border-radius: 12px;
			float:left;
			margin-left:-5px;
			margin-top:-5px;
			color: black;
			font-size: 18px;
			font-weight:bold;
			text-align: center;
		}
		.contenedor_imagen_evento img
		{
			height: 24px;
			width: 24px;
			border-radius: 12px;
			vertical-align: top;
		}
		.fc-content
		{
			height: 16px;
		}
		.borde_azul, .borde_azul *
		{
			border-color:#0EC8DB;
			color:#0EC8DB;
		}
		.borde_rojo, .borde_rojo *
		{
			border-color:red;
			color:lightgrey;
		}
		.borde_verde, .borde_verde *
		{
			border-color:#0FD8A8;
			color:#0FD8A8;
		}
		.fc-time
		{
			display:none;
		}
		.fc-content
		{
			margin-left:30px;
			text-transform:capitalize;
		}
		.fc-day.fc-widget-content
		{
			border: 5px solid white;
		}
		.fc-day-header.fc-widget-header
		{
			border: 5px solid white;
		}
		.fc-head-container.fc-widget-header
		{
			color:white;
			background-color:#0FD8A8;
			border: 5px solid white;
		}
		.formPublicar h4
		{
			color: #a0a1a2;
		}

		/*botones de flechas*/
		.fc-prev-button, .fc-next-button
		{
			border: transparent;
			background: transparent;
			box-shadow: none;
		}

	</style>
@endpush

@push('js')
	{!! Html::script('js/calendario.js') !!}
@endpush
