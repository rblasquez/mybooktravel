@extends('layouts.app')

@section('content')
<section class="container profileContent">
	<div class="row">
		
		@include('auth.partials.aside')
		
		<div class="col-md-9 col-xs-12 formPublicar_1">
			<div class="col-md-12 col-sm-12">
				<h1 class="h1">Mis Reservas</h1>
			</div>
			@include('reservas.partials.preview_list')
		</div>
	</div>
</section>
@endsection
