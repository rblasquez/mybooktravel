@if($propiedad->imagenes()->count() == 0 )

Ninguna imagen seleccionada

@else

<div class="col-md-12">
	<hr>
	<div class="row">
	@foreach($propiedad->imagenes()->get()->chunk(6) as $grupos_imagen)
		@foreach($grupos_imagen as $imagen)
		@php
		$form_eliminar_imagen_actual = "form_eliminar_imagen_".$imagen->id;
		$id_radio = "radio_imagen_principal_".$imagen->id;
		@endphp
		
		<form action="{{ route('propiedad.actualizar.eliminarimagen', [$propiedad->id]) }}" method="POST" class='form_editar_seccion' name="{{$form_eliminar_imagen_actual}}" id="{{$form_eliminar_imagen_actual}}" callback="callback_actualizar_datos(result);$('#imagenes_guardadas').val($('#imagenes_guardadas').val()-1);monitorear_galeria('borrar_imagen_guardada');$('#{{$form_eliminar_imagen_actual}}').remove();" >
			<div class="col-md-3">
				{{csrf_field()}}
				<input type="text" id="id_imagen" name="id_imagen" value="{{$imagen->id}}" class="hide" >
				<div class="form-group">
					<input type="radio" value='{{$imagen->id}}' name="hacer_imagen_principal" id="{{$id_radio}}" {{$imagen->primaria ? 'checked' : '' }}>
					<label for="{{$id_radio}}">Portada</label>
				</div>
				<div class="img_container">
					<figure>
						
						<img src="{{ App\Http\Controllers\HelperController::getUrlImg($imagen->propiedad->usuario->id, $imagen->ruta, 'sm') }}" class="img-responsive" alt="">
					</figure>
				</div>
				<button type="submit" class="hidden submit_{{$form_eliminar_imagen_actual}}" >Eliminar</button>
				<i style="cursor:pointer;" onclick="$('.submit_{{$form_eliminar_imagen_actual}}').click();" class="fa fa-trash-o text-danger pull-right" aria-hidden="true"></i>
			</div>
		</form>
		@endforeach
	@endforeach
	
	</div>
</div>

<script>
	$(document).ready(function(){
		inicializar_enviador_formularios();
	});
	
	$("[name=hacer_imagen_principal]").on("click",function(){
		var id_imagen = $(this).val();
		
		$("[name=hacer_imagen_principal]").each(function(){
			var current = $(this)[0];
			if(current.value != id_imagen)
			{
				current.checked = false;
			}
		});
		
		var url = "{{ route('propiedad.actualizar.asignarimagenprimaria', [$propiedad->id]) }}";
		var token = $('input[name=_token]').val();
		abrir_modal_espera();

		$.ajax(url, {
			type: 'post',
			headers: {'X-CSRF-TOKEN' : token },
			data: {id_imagen:id_imagen},
			dataType: 'json',
			success: function (result) {
				swal.close();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				swal.close();
			},
		});
		
	});
</script>
@endif