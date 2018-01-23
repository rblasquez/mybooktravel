<section id="alojamientos">
	@foreach ($propiedades as $propiedad)
	<div class="strip_booking">
		<div class="row">
			<div class="col-md-2 col-sm-2">
				@if ($propiedad->imagenes->first())
				<img src="{{ $propiedad->imagenes->first()['ruta'] }}" class="img-responsive" />
				@else
				<img src="{{ asset('img/default.png') }}" class="img-responsive" />
				@endif
			</div>
			<div class="col-md-6 col-sm-5">
				<h3 class="">
					{{ $propiedad->nombre }}
					<span>{{ str_limit($propiedad->descripcion, 100) }}</span>
				</h3>
			</div>
			<div class="col-md-2 col-sm-3">
				<ul class="info_booking">
					<li><strong>{{ $propiedad->tipo->descripcion }}</strong></li>
				</ul>
			</div>
			<div class="col-md-2 col-sm-2">
				<div class="booking_buttons">
					<a href="#0" class="btn_2">Editar</a>
					<a href="#0" class="btn_3">Cancel</a>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</section>