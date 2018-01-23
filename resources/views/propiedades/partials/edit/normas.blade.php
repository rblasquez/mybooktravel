@extends('propiedades.edit')

@section('seccion_a_editar')

	{!! Form::model($propiedad,['route' => ['propiedad.actualizar.normas',$propiedad->id],"class"=>"form_editar_seccion","id"=>"form_normas","name"=>"form_normas","callback"=>"callback_actualizar_datos(result)"]) !!}

		<?php
		$normas_basicas = [];
		if($propiedad->normas->where('tipo','basicas')->count()>0)
		{	
			$normas_basicas = array_values($propiedad->normas->where('tipo','basicas')->toArray());
			$normas_basicas = $normas_basicas[0]["normas"];
			eval(' $normas_basicas = '.$normas_basicas.'; ');
		}
		// App\Http\Controllers\HelperController::echoPre($normas_basicas);
		
		$normas_adicionales = [];
		$normas_adicional = "";
		if($propiedad->normas->where('tipo','adicionales')->count()>0)
		{	
			$normas_adicionales = array_values($propiedad->normas->where('tipo','adicionales')->toArray());
			$normas_adicional = $normas_adicionales[0]["normas"];
		}
		// App\Http\Controllers\HelperController::echoPre($normas_adicionales);
		?>

		
		<h3>
			
			<span class="hidden-xs">Normas</span>
		</h3>
			
		<div>
		
			<h1 class="visible-xs">Normas</h1>
			
			<div class="row">
			
				@foreach ($normas->chunk(3) as $grupos_normas)
				<div class="col-md-3 col-xs-6">
					@foreach ($grupos_normas as $norma)
						@if ($norma->id <> 1)
							<!--
							<input class="" id="chk14" type="checkbox" />
							-->
							{!! Form::checkbox('normas[]', $norma->id, in_array($norma->id,$normas_basicas ) ? true : false,["id"=>"norma_id_".$norma->id]) !!}
						
							<label for="norma_id_{{$norma->id}}">{{ $norma->descripcion }}</label>
						@endif
					@endforeach	
				</div>	
				@endforeach		
				
				<div class="col-md-12 col-xs-12">
					<!--
					<textarea class="textarea_1" placeholder="Describe tu cocina lo mejor que puedas..."></textarea>
					-->
					{!! Form::textArea('normas_adicionales', $normas_adicional, ['class' => 'textarea_1', 'maxlength' => '140', 'placeholder' => 'Describe tus normas']) !!}
				</div>	
						
			</div>
			
		</div>
		
		
		<!-- funcional
		
		<h3 class="text-center">Normas de la casa</h3>
		<div class="form-horizontal">
			<div class="form-group">
				{!! Form::label('normas', 'Normas pre-establecidas', ['class' => 'control-label col-md-4']) !!}
				<div class="col-md-8">
					@foreach ($normas as $norma)
					@if ($norma->id <> 1)
					<div class="checkbox the-icons">
						<label>
							{!! Form::checkbox('normas[]', $norma->id, in_array($norma->id,$normas_basicas ) ? true : false) !!}
							<i class="{{ $norma->icono }}"></i>
							{{ $norma->descripcion }}
						</label>
					</div>
					@endif
					@endforeach
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('normas_adicionales', 'Otras normas', ['class' => 'control-label col-md-4']) !!}
				<div class="col-md-8">
					{!! Form::TextArea('normas_adicionales', $normas_adicional, ['class' => 'form-control', 'rows' => 3]) !!}
				</div>
			</div>	
		</div>
		
		<button type="submit" class="btn btn-success btn-outline-rounded green"> Guardar Cambios <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></button>

		-->
		
		<div class="row pull-right">
			<button type="submit" class="btn btn-lg  ">Guardar</button>
		</div>
		
	{!! Form::close() !!}
	
@endsection

@push('css')
	
	<style>
	</style>

@endpush

@push('js')

	<script>
	</script>

@endpush