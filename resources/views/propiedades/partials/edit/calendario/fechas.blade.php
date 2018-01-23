	{!! Form::text('fecha_inicio_formato', null, ['class' => 'hide','id'=>'fecha_inicio_formato']) !!}
	{!! Form::text('fecha_fin_formato', null, ['class' => 'hide','id'=>'fecha_fin_formato']) !!}

	
	<div class="row" id="contenedor_datepicker_eventos">
	
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => '']) !!}
				{!! Form::text('fecha_inicio', null, ['class' => 'form-control', 'placeholder' => 'Fecha Inicio', $disabled_fechas => $disabled_fechas ]) !!}
			</div>
		</div>
			
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('fecha_fin', 'Fecha Fin', ['class' => '']) !!}
				{!! Form::text('fecha_fin', null, ['class' => 'form-control', 'placeholder' => 'Fecha Fin', $disabled_fechas => $disabled_fechas ]) !!}
			</div>
		</div>
		
	</div>