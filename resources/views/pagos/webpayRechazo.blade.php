@extends('layouts.app')

@section('content')
<section class="container">
	<div class="row">
		<div class="col-md-6">
			<h1>Transacción Rechazada</h1>
			<a href="" class="btn btn-primary">Intentar nuevamente</a>
		</div>
		<div class="col-md-6">
			<table class="table table-striped">
				<tr>
					<th><div class="alert alert-error">Las posibles causas de este rechazo son:</div></th>
				</tr>
				<tr>
					<td><img src="{{ asset('webpay/images/vineta.gif') }}" style="margin-right: 10px;"/> Error en el ingreso de los datos de su tarjeta de cr&eacute;dito o debito (fecha y/o c&oacute;digo de seguridad). </td>
				</tr>
				<tr>
					<td><img src="{{ asset('webpay/images/vineta.gif') }}" style="margin-right: 10px;"/>Su tarjeta no cuenta con saldo suficiente. </td>
				</tr>
				<tr>
					<td><img src="{{ asset('webpay/images/vineta.gif') }}" style="margin-right: 10px;"/>Tarjeta aun no habilita en el sistema financiero.</td>
				</tr>
			</table>
		</div>
	</div>
</section>
@endsection
