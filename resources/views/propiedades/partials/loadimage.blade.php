<div class="container">
	<div id="contenedor_imagenes_galeria" class="row imagine_gallery_container"></div>
</div>

<div class="hide" >
	<input type="text" id="cantidad_maxima_imagenes" name="cantidad_maxima_imagenes" value="{{ $CantidadMaximaImagenesPorPropiedad }}" class="" />
</div>

{{--
pasado a variables de javascript en Imagine.js
<input type="file" multiple="multiple" accept=".png, .jpg, .jpeg"  name="galeria[]" id="galeria" class="hide" >

<div class="hide" >

	<div class="col-md-2 preview_image_template" id="preview_image_template">
		<div class="panel panel-default">
			<div class="panel-heading mbt_pt-0 mbt_pb-0 preview_image_header">
				<input type="radio" id="" class="main_image_input" name="main_image" >
				<label for="" class="make_main_image main_image_label mbt_mt-20" >Portada</label>
			</div>
			<div class="panel-body img_container preview_image_body">
				<figure>
					<preview_image ></preview_image>
				</figure>
			</div>
			<div class="panel-footer preview_image_footer">
				<div class="row">
					<div class="col-xs-4">
						<button type="button" class="btn btn-xs btn-default rotator counter_clockwise " title="Girar a la izquierda"><i class="fa fa-rotate-left"></i></button>
					</div>
					<div class="col-xs-4">
						<button type="button" class="btn btn-xs btn-default delete" onclick="eliminar_imagen($(this).parents('.preview_image_container').find('.preview_image').attr('id'))" title="Eliminar archivo"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></button>
					</div>
					<div class="col-xs-4">
						<button type="button" class="btn btn-xs btn-default rotator clockwise " title="Girar a la derecha"><i class="fa fa-rotate-right"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class=" add_button_template col-md-2 col-sm-3 col-xs-6" id="add_button_template" >
		<button type="button" class="add_image" onclick="$('#galeria').click()" >
			<i class="fa fa-plus" ></i>
			Agregar imágenes
		</button>
	</div>



</div>

--}}
