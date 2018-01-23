@extends('propiedades.edit')

@section('seccion_a_editar')
<h3><span class="hidden-xs">Fotos</span></h3>
{!! Form::open(['route' => ['propiedad.actualizar.agregarimagenes',$propiedad->id], 'enctype' =>  'multipart/form-data', 'id' => 'frmGalery']) !!}
<h1 class="visible-xs">Fotos</h1>
<div>
	<div class="form-group">

		{!! Form::file('galeria[]', ['id' => 'galeria', 'multiple' => 'multiple']) !!}
	</div>
</div>
<div class="row" >
	<div class="col-md-3 col-md-offset-9" id="contenedor_boton_enviar_imagenes">
		{!! Form::submit('Agregar imagenes',['id'=>'enviar_imagenes']) !!}
	</div>
</div>
{!! Form::close() !!}
<div class="row" id="contenedor_carrusel"></div>




<div class="contenedor_template_footer_fileinput hide">
	<div class="file-thumbnail-footer">
		<div class="row">
			<div class="col-xs-4">
				<button type="button" class="btn btn-xs btn-default rotar-archivo-izquierda hide"><i class="fa fa-rotate-left"></i></button> 
			</div>
			<div class="col-xs-4">
				<button type="button" class="btn btn-xs btn-default rotar-archivo-derecha hide"><i class="fa fa-rotate-right"></i></button> 
			</div>
			<div class="col-xs-4">
				<button type="button" class="kv-file-remove btn btn-xs btn-default" title="Eliminar archivo"><i class="glyphicon glyphicon-trash text-danger"></i></button>    
			</div>
		</div>
	</div>
</div>


<input type="text" id="cantidad_maxima_imagenes" name="cantidad_maxima_imagenes" value="{{ $propiedad::$cantidad_maxima_imagenes}}" class="hide" />
<input type="text" id="imagenes_guardadas" name="imagenes_guardadas" value="{{$propiedad->imagenes->count()}}" class="hide" />
<a href="{{route('propiedad.actualizar.obtenercarruselimagenes',[$propiedad->id])}}" class="obtenerCarruselImagenes hide" ></a>
<a href="{{route('propiedad.actualizar.eliminarimagen',[$propiedad->id])}}" class="eliminarImagen hide" ></a>
@endsection

@push('css')

@endpush

@push('js')

{!! Html::script('plugins/bootstrapfileinput/js/locales/es.js') !!}

<script>
	$(document).ready(function(){

			// $(img_preview_selector).each(function(index, element){
				// var contenedor = $(element).parent('.file-preview-frame.krajee-default.kv-preview-thumb');
				// console.log(contenedor);
				// $(contenedor).find('.file-footer-buttons').append('girar');	
			// });	
	});

	//inicializacion de variables
	var cantidad_maxima_imagenes = $("#cantidad_maxima_imagenes").val();
	var imagenes_guardadas = $("#imagenes_guardadas").val();
	var imagenes_en_preview = 0;
	var imagenes_restantes = cantidad_maxima_imagenes - imagenes_guardadas;
	var img_preview_selector = '.kv-preview-thumb .file-preview-image';

	var footerTemplate = $('.contenedor_template_footer_fileinput').html();
	
	//inicializacion y eventos del fileinput
	$("#galeria").fileinput({
		language: "es",
		browseLabel: 'Agregar imágenes',
		browseIcon: '',
		removeIcon: '',
		showUpload: false,
		showRemove: false,
		fileType: 'img',
		maxFileCount: imagenes_restantes,
		resizePreference: 'heigth',
		browseClass: "btn btn-primary btn-block",
		showCaption: false,
		msgFilesTooMany: 'El número de archivos seleccionados para la carga ({n}) excede el límite máximo permitido de {m}. Por favor, vuelva a intentar su subida!',
		uploadAsync: true,
		uploadUrl: "{{ route('propiedad.actualizar.agregarimagenes',[$propiedad->id]) }}", 
		uploadExtraData: {_token: document.querySelector("[name='_token'").value },
		showBrowse: false,
		browseOnZoneClick: true,
		maxFileSize: 15360,
		layoutTemplates: {footer: footerTemplate},
	});
	
	$('#galeria').on('fileremoved', function(event, id, index) {
		monitorear_galeria('fileremoved');		
	});
	
	$('#galeria').on('fileselected', function(event, previewId) {
		// console.log("bloquear");
		$("#enviar_imagenes").attr('disabled','disabled');
		monitorear_galeria('fileimageloaded');
		
	});
	
	$('#galeria').on('fileimagesloaded', function(event) {
		// monitorear_galeria();		
		$("#enviar_imagenes").attr('disabled','disabled');
		// console.log("compresion:init");
		
		imagine.compressImagesToBase64({ 
			selector: img_preview_selector, 
			status_attr: 'compressed', 
			maxHeight: 1080,
			compressionLevel: 0.9,
			outputFormat: "png",
			onfinish:function(){
				// console.log("compresion:finish");
				$("#enviar_imagenes").removeAttr('disabled');

				$(".kv-preview-thumb .rotar-archivo-derecha, .kv-preview-thumb .rotar-archivo-izquierda").on("click",function(){
					
					abrir_modal_espera();
					
					var rotar_a_la_derecha = $(this).hasClass("rotar-archivo-derecha") ? true : false;
					// console.log(rotar_a_la_derecha);
					
					var contenedor_id = $(this).parents('.kv-preview-thumb').attr('id');
					var selector_imagen_a_rotar = "#"+contenedor_id+" .file-preview-image";
					// console.log(image);
					
					
					imagine.rotateBase64Image90deg({
						selector: selector_imagen_a_rotar,
						isClockwise: rotar_a_la_derecha,
						onfinish:function(){
							console.log('rotacion finalizada');
							swal.close();
						}
					});

				});				
			}
		});
	
	});
	
	//buscar imagenes guardadas
	refrescar_galeria();
	//verifica valores actuales
	monitorear_galeria('onload');

	//envio del formulario
	$("#frmGalery").on("submit",function(event){

		event.preventDefault();
		
		var url = $(this).attr('action');
		
		var galeria = [];
		$(".file-preview-image[compressed=1]").each(function(index, element){
			galeria.push($(element).attr('src'));			
		});		
		
		var token = $('input[name=_token]').val();
		
		abrir_modal_espera();

		$.ajax(url, {
			type: 'post',
			headers: {'X-CSRF-TOKEN' : token },
			data: {galeria:galeria},
			dataType: 'json',
			success: function (result) {
				callback_actualizar_datos(result);
				$('#galeria').fileinput('clear');
				refrescar_galeria();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				swal.close();
			},
		});
	});

	function refrescar_galeria()
	{
		var token = $('input[name=_token]').val();
		
		$.ajax({
			url: $('.obtenerCarruselImagenes').attr('href'), 
			headers: {'X-CSRF-TOKEN' : token },
			type: "POST",
			success: function(result){
				// console.log(result);
				$("#imagenes_guardadas").val(result.imagenes_guardadas);
				$("#contenedor_carrusel").empty().append(result.html);
				monitorear_galeria('refrescar_galeria');
				swal.close();
			}
		});		
	}
	
	function monitorear_galeria(origen)
	{
		// console.log(origen);
		cantidad_maxima_imagenes = $("#cantidad_maxima_imagenes").val();
		// console.log("cantidad_maxima_imagenes: "+cantidad_maxima_imagenes);
		
		imagenes_guardadas = $("#imagenes_guardadas").val();
		// console.log("imagenes_guardadas: "+imagenes_guardadas);
		
		imagenes_en_preview = $(img_preview_selector).length;
		// console.log("imagenes_en_preview: "+imagenes_en_preview);
		
		imagenes_restantes = cantidad_maxima_imagenes - imagenes_guardadas - imagenes_en_preview;
		// console.log("imagenes_restantes: "+imagenes_restantes);
		
		if(imagenes_en_preview == 0)
		{
			// console.log("bloquear");
			$("#enviar_imagenes").attr('disabled','disabled');
		}
		
		if(cantidad_maxima_imagenes == imagenes_guardadas )
		{	
			$("#galeria").fileinput('disable');
		}
		else
		{
			$("#galeria").fileinput('enable');
		}
		
		if(origen == "refrescar_galeria" || origen == "borrar_imagen_guardada")
		{
			//el unico detalle es que cuando seleccionan archivos 
			//para el preview y luego borran alguno de los guardados
			//se debe reinicializar la galeria y se borran los seleccionados para el preview
			$("#galeria").fileinput('refresh', {maxFileCount :imagenes_restantes});
		}
		
		return imagenes_restantes;
	}

</script>
@endpush
