
@if($reservas->count() == 0)
<center>
	<h4>
		No se han encontrado reservas.
	</h4>
</center>
@else

<div class="row">
	@foreach ($reservas as $reserva)
	<div class="col-md-6">
		<div class="mbt-card mbt_mb-20">
			<div class="mbt-card-header">
				<h5>{{ $reserva->propiedad->nombre }}</h5>
			</div>

			<div class="mbt-card-image">
				<a href="{{ route('reserva.show', $reserva->id) }}">
					<div class="img_container">
						@if(count($reserva->propiedad->imagenes) > 0)
						<img class="b-lazy"
						src=""
						data-src="{{ App\Http\Controllers\HelperController::getUrlImg($reserva->propiedad->usuario->id, $reserva->propiedad->imagenes->where('primaria', true)->first()['ruta'], 'lg') }}"
						alt="&nbsp;"
						/>
						@else
						<img src="{{ asset('img/casa.jpg') }}" width="800" height="533" class="img-responsive" alt="Image">
						@endif
					</div>
				</a>
			</div>


			<div class="mbt-card-action">
				<div class="row">
					<div class="col-xs-3">
						<h6>
							Llegada
							{{ Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}
						</h6>
					</div>
					<div class="col-xs-3">
						<h6>
							Salida
							{{ Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}
						</h6>
					</div>
					<div class="col-xs-6 text-right">
						<span class="label label-{{ $reserva->estatusReserva->color == 'secondary' ? 'default' : $reserva->estatusReserva->color }}">{{ $reserva->estatusreserva->descripcion }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endif
