@extends('layouts.app')

@section('content')

<div class="container " style="position:relative;margin: 100px;">
	<div class="row">
		<div class="col-md-12 ">
			<h3>Tus fechas bloquedas para reserva <span class="pull-right">
			<a class="btn btn-primary" href="#" id="btnAgregar" data-opcion="agregar"> <i class="fa fa-plus"></i> Agregar fecha</a></span></h3>
                
			<p>Alojamiento: <span class="text-primary">{{$propiedad->nombre}}</span></p>
			
			<div id="form-crear" style="display: none">
				{!! Form::open(['route' => 'tus-propiedades.store-reserva-manual','class'=>'form-inline']) !!}
				<div class="rango " style="display:inline !important;">
					<div class="form-group">
						<label class="sr-only">Fecha inicio</label>
							{{Form::text('fecha_inicio',null, ['class'=>'form-control date-pick', 'autocomplete'=>'off','placeholder'=>'Fecha inicio'])}}
					</div>
					<div class="form-group">
						<label class="sr-only">Fecha fin</label>
							{{Form::text('fecha_fin',null, ['class'=>'form-control date-pick', 'autocomplete'=>'off','placeholder'=>'Fecha fin'])}}
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only">Descripci&oacute;n</label>
						<input type="text" name="descripcion" class="form-control" id="inputGroupSuccess3" placeholder="Descripci&oacute;n">
				</div>
				<button type="submit" class="btn btn-info">Guardar</button>
				<input type="hidden" name="propiedades_id" value="{{$propiedad->id}}">
				{!!Form::close()!!}
			</div>
			
			<div class="filter-item-wrapper">
				@if($reservas->count()>0)
				<div class="table table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr class="text-primary">
								<th>Descripci&oacute;n</th>
								<th>Fecha Inicio</th>
								<th>Fecha Fin</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($reservas as $reserva)
							<tr>
								<td>{{$reserva->descripcion}}</td>
								<td>{{$reserva->fecha_inicio}}</td>
								<td>{{$reserva->fecha_fin}}</td>
								<td>
									{!!Form::open(['route' => ['tus-propiedades.destroy-reserva-manual',$reserva->id], 'class'=>'form-horizontal', 'style'=>'display:inline'])!!}
									<input type="hidden" name="id" value="{{$reserva->id}}">
									<button type="submit" class="btn btn-xs btn-icon btn-sm btn-danger btn-danger"> <i class="fa fa-trash"></i> </button>
									{!!Form::close()!!}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@else
				<p>No existen datos registrados.</p>
				@endif
			</div>

			<!-- PAGINATION -->
			<div class="page__pagination text-center">
				{{ $reservas->links() }}
			</div>
		</div>
	</div>
</div>
@endsection()
@push('js')


{!! Html::style('template/css/date_time_picker.css') !!}
{!! Html::script('template/js/bootstrap-datepicker.js') !!}


<script>

	//inicializacion del datepicker
	$('.rango').datepicker({
        startDate: 'today',
        format: 'dd-mm-yyyy',
        language: 'es',
        inputs: $('.date-pick'),
    });

    $(document).ready(function() {
        $('#btnAgregar').click(function(event) {
            event.preventDefault();
            var accion = ($("#btnAgregar").data('opcion'));
            if(accion=='agregar'){
                $('#form-crear').show('fast');
                $("#btnAgregar").data('opcion','cancelar');
                $("#btnAgregar").html('<i class="fa fa-arrow-up"></i> Cancelar');
                $("#btnAgregar").removeClass('btn-primary');
                $("#btnAgregar").addClass('btn-danger');
            } else {
                $('#form-crear').hide('fast');
                $("#btnAgregar").data('opcion','agregar');
                $("#btnAgregar").html('<i class="fa fa-plus"></i> Agregar Fecha');
                $("#btnAgregar").removeClass('btn-danger');
                $("#btnAgregar").addClass('btn-primary');
            }
        });
    });

</script>
@endpush()