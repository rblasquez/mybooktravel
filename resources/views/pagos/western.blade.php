@extends('layouts.app')

@section('content')
<section class="container">
	<h2 style="margin-bottom: 20px;">Pago a travez de Western Union</h2>

	<div class="row ">
		<div class="col-md-5 mbt_mt-20">
			<fieldset>
				<legend>Nuestros datos:</legend>

				<div class="card-box">
					<div class="card card-just-text card-with-border" data-background="color" data-color="azure">
						<div class="content mbt_p-20">
								<p class="text-left"><span>Destinatario: <strong class="pull-right">Jaime Alejandro Fernández Robles</strong></span></p>
								<p class="text-left"><span>Dirección: <strong class="pull-right">San Pedro 219, Concón - Chile</strong></span></p>
								<p class="text-left"><span>RUT: <strong class="pull-right">15.081.925-3</strong></span></p>
								<p class="text-left"><span>Monto: <strong class="pull-right">${{ cambioMoneda($reserva->total_pago, 'CLP', session('valor'))  }}</strong></span></p>

								@php
								$totalPagado = App\Http\Controllers\HelperController::totalPagado($reserva);
								@endphp
								@if($reserva->propiedad->administracion->garantia_reserva_id == 3)
									<hr>
									<p class="text-left">
										<span>Puedes abonar :
											<strong class="pull-right">
												${{ cambioMoneda($totalPagado['minimo_requerido'], 'CLP', session('valor')) }}
											</strong>
										</span>
									</p>
								@endif


								@if($totalPagado['total_abonado'] > 0)
									<hr>
									<p class="text-left">
										<span>Has abonado :
											<strong class="pull-right">${{ cambioMoneda($totalPagado['total_abonado'], 'CLP', session('valor')) }}</strong>
										</span>
									</p>
									<h3 class="text-left">
										<small>Restas por pagar</small> <strong class="pull-right">${{ cambioMoneda($totalPagado['monto_restante'], 'CLP', session('valor')) }}</strong></h3>
								@endif

							<div class="clearfix"></div>
						</div>
						<div class="filter"></div>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="card-box">
					<div class="card" data-background="color" data-color="black">
						<div class="header">
							<img src="{{ asset('img/pagos/factura_western.jpg') }}" />
						</div>

						<div class="content mbt_p-15">
							<p class="description">Una vez hayas realizado el pago de tu reserva a través de un depósito o transferencia bancaria llena el formulario y completa el proceso de reserva.</p>
						</div>
					</div>
				</div>
			</fieldset>

		</div>
		<div class="col-md-6 col-md-offset-1 mbt_mt-20">
			{!! Form::open(['route' => ['reserva.pago.western', $reserva->id], 'enctype' => 'multipart/form-data', 'id' => 'frmPagoWestern']) !!}
			<fieldset>
				<legend>Formulario de registro de pago</legend>
				<div class="form-group">
					{!! Form::label('mtcn', 'MTCN') !!}
					{!! Form::text('mtcn', null, ['class' => 'form-control']) !!}
				</div>
				<div class="row">

					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('remitente', 'Remitente') !!}
							{!! Form::text('remitente', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('bauche_img', 'Imagen del bauche') !!}
							{!! Form::file('bauche_img', ['class' => 'form-control', "accept" => "image/*"]) !!}
						</div>
					</div>
				</div>


				<div class="form-group">
					{!! Form::label('comentario', 'Comentario') !!}
					{!! Form::textArea('comentario', null, ['class' => 'form-control mbt_m-0', 'rows' => '4']) !!}
				</div>

				<div class="form-group mbt_mt-20 text-right">
					{!! Form::submit('Cargar pago', ['class' => 'btn btn-primary btn-lg']) !!}
				</div>

			</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
</section>
@endsection

@push('css')
<style>
address span {
	display: block;
}

.transfer-sample p {
	margin-bottom: 15px;
}

.form-group label {
	margin-top: 15px;
}

.form-control {
	margin-bottom: 0px;
}

#bauche_img {
	margin: 0px;
}

.well {
	border-radius: 6px;
	border: none;
	color: #58595B;
	background: #ffffff;
	box-shadow: 0px 0px 6px #000;
}
</style>
@endpush

@push('js')
	{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
	{!! JsValidator::formRequest('App\Http\Requests\ReservaPagoWesternRequest', '#frmPagoWestern'); !!}
	{!! Html::script('js/generate.js?'.$version) !!}
	<script>
	$('.moneda').inputmask({
		alias: 'numeric',
		groupSeparator: '',
		autoGroup: true,
		digitsOptional: true,
	});

	</script>
@endpush
