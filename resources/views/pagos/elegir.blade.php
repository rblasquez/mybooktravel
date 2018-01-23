@extends('layouts.app')

@section('content')
<section class="container">
	<div class="col-md-12">
		<h2 class="text-center mbt_pb-20">
			Selecciona un medio de pago
			<small style="display: block;">Listo solo te falta realizar el pago de tu reserva para continuar, </small>
			<small style="display: block;">Selecciona el medio que mas te convenga.</small>
		</h2>
	</div>
	<div class="col-md-4">
		<a href="{{ route('reserva.pago', [$reserva->id, 1]) }}" class="btn btn-default btn-lg btn-block">
			<img class="img-responsive" src="{{ asset('img/pagos/web_pay.png') }}" alt="WebPay">
		</a>
	</div>

	<div class="col-md-4">
		<a href="{{ route('reserva.pago', [$reserva->id, 3]) }}" class="btn btn-default btn-lg btn-block">
			<img class="img-responsive" src="{{ asset('img/pagos/transferencia.png') }}" alt="Transferencia o deposito">
		</a>
	</div>

	<div class="col-md-4">
		<a href="{{ route('reserva.pago', [$reserva->id, 4]) }}" class="btn btn-default btn-lg btn-block">
			<img class="img-responsive" src="{{ asset('img/pagos/western_union.png') }}" alt="Western Union">
		</a>
	</div>
</section>
@endsection

@push('css')
<style type="text/css">
.btn {
 	border: 1px solid #ddd;
 	border-radius: 6px;
 	box-shadow: 0px 0px 5px #ddd;
}
</style>
@endpush

@push('js')
<script>

</script>
@endpush
