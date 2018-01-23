var Imagenes = (function () {

	//private methods
	var edit = (function () {
		return {
			start:function()
			{
				$( document ).ready(function() {

					setInterval(function(){
						$('.preview_image_container .delete').each(function(key,element){
							var old_onclick = $(element).attr('onclick');
							var new_onclick = "Imagenes.edit.eliminar($(this).parents('.preview_image_container').find('.preview_image').attr('id'))";
							if(old_onclick != new_onclick)
							{
								$(element).attr('onclick','');
								$(element).attr('onclick',new_onclick);
							}

						});
					},100);

					Imagine.previewer.start({
						containerSelector: "#contenedor_imagenes_galeria",
						maxFiles:20,
						maxFilesOnSelect:5,
						onSelect:function (files)
						{
							console.log("seleccionaron archivos");
							// console.log(files);
							abrir_modal_espera();
						},
						onFinishSelect:function (files)
						{

							console.log("previsualizó todas");

							//compression en lote recargando el src
							Imagine.compressor.start({
								containerSelector: "#contenedor_imagenes_galeria",
								compressionLevel: 0.6,//quality. 0: worst, 1: best
								maxWidth: 1920,
								maxHeight: 1080,
								onFinishEveryImage:function(img)
								{
									// console.log("comprimio la imagen "+img.getAttribute('preview_id'));
								},
								onfinishAllImages:function(selector)
								{

									console.log("comprimió todas");

									Imagine.sender.send({
										containerSelector: "#contenedor_imagenes_galeria",
										url: $(".agregarImagen").attr("href"),
										csrfToken:$("[name=_token]").val(),
										onFinishEveryImage:function(response,domImage){

											console.log("imgen enviada");
											// console.log(response);
											// console.log(domImage);


											if(JSON.parse(response.responseText).success == true)
				              {

				                $(domImage).attr("id",JSON.parse(response.responseText).id_imagen);
												Imagenes.edit.startSelectorPrimaria();
												Imagenes.edit.startRotators();
												Imagenes.edit.verificarCantidades();

				              }
				              else
				              {

				                $(domImage).parents(".preview_image_container").remove();
												swal.close();

				              }

										},
										onfinishAllImages:function(){

											console.log('envió todas');
											swal.close();

										}
									});

								}
							});

						}
					});

					var initialPreviews = JSON.parse($("#initial_previews").val());
					// console.log(initialPreviews);

					// console.log("la previsualizacion de imágenes está dejando de mostrar algunas");

					Imagine.previewer.setInitialPreviews({
						containerSelector: "#contenedor_imagenes_galeria",
						initialPreviews:initialPreviews
					});


					/*

					imagine.initializePreviewImageUpload({
						fileInputSelector: "#galeria",
						previewContainerSelector: "#contenedor_imagenes_galeria",
						previewTemplateId: "preview_image_template",
						addButtonTemplateId: "add_button_template",
						qualityPercentage: 60,
						maxWidth: 1920,
						maxHeight: 1080,
						sendOnSelected: true,
						onStartSendOnSelected:function(domImage){
							// abrir_modal_espera();
						},
						onFinishSendOnSelected:function(response,domImage)
						{

							if(JSON.parse(response.responseText).success == true)
							{
								$(domImage).attr("id",JSON.parse(response.responseText).id_imagen);
								Imagenes.edit.startSelectorPrimaria();
								Imagenes.edit.startRotators();
								Imagenes.edit.verificarCantidades();

								if($('.preview_image[uploaded=2]').length == $('.preview_image').length)
								{
									swal.close();
								}
							}
							else
							{
								$(domImage).parents(".preview_image_container").remove();
								swal.close();
							}

						},
						onFileInputChanged:function(files)
			      {
							abrir_modal_espera();
							// console.log('abrir modal');
			        // console.log("cambio el input, han seleccionado para cargar las siguientes imagenes:");
			        // console.log(files);
			      },
			      onFinishSingleImageCompression:function(selector)
			      {
			        // console.log("finalizó la compresión de la imagen con el selector: "+selector);

			      },
			      onFinishAllImagesCompression:function()
			      {
			        // console.log('todas comprimidas');
			      },
						sendOnRotated: false,
						sendUrl:$(".agregarImagen").attr("href"),
						initialPreviews:initialPreviews,
						outputFormat: 'png',
						csrfToken: $("[name=_token]").val()
					});

					*/

					Imagenes.edit.startSelectorPrimaria();
					Imagenes.edit.startRotators();
					Imagenes.edit.verificarCantidades();

					//guardada
					var id_imagen_primaria = $("#id_imagen_primaria").val();
					if(id_imagen_primaria != 0)
					{
						var preview_image_container = $(".preview_image#"+id_imagen_primaria).parents('.preview_image_container');
						if(preview_image_container.length > 0)
						{
							var checkbox = $(preview_image_container).find(".main_image_input");
							if(checkbox.length > 0)checkbox[0].checked = true;
						}
					}

				});

			},
			eliminar:function(id_imagen)
			{
				//var preview_image_container = $(element).parents('.preview_image_container');
				//var id_imagen = $(preview_image_container).find('.preview_image').attr('id');

				var url = $(".eliminarImagen").attr("href");
				var token = $('input[name=_token]').val();

				abrir_modal_espera();
				$.ajax(url, {
					type: 'post',
					headers: {'X-CSRF-TOKEN' : token },
					data: {id_imagen:id_imagen},
					dataType: 'json',
					success: function (result) {
						$(".preview_image[id="+id_imagen+"]").parents(".preview_image_container").remove();
						swal.close();
						Imagenes.edit.verificarCantidades();
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						swal.close();
					},
				});
			},
			startSelectorPrimaria:function()
			{
				$(".make_main_image").on("click",function(){
					// console.log("click");
					if($(this).attr("for") == "")
					{
						var uniqueId = Date.now();
						var header = $(this).parents(".preview_image_header");
						$(header).find(".main_image_input").attr("id",uniqueId);
						$(this).attr("for",uniqueId);
					}

					var id_imagen = $(this).parents('.preview_image_container').find('.preview_image').attr('id');
					var url = $(".asignarImagenPrimaria").attr("href");
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
			},
			startRotators:function()
			{
				$('.rotator').unbind('click');
				$(".rotator").on("click",function(){
          var sentido = '';
					if($(this).hasClass('clockwise'))
					{
						//console.log('girar a la derecha');
						sentido = "derecha";
					}
					else
					{
						//console.log('girar a la izquierda');
						sentido = "izquierda";
					}

					var preview_image_container = $(this).parents('.preview_image_container');
					var preview_image = $(preview_image_container).find(".preview_image");

					var id_imagen = $(preview_image).attr('id');
					var url = $(".rotarImagen").attr("href");
					var token = $('input[name=_token]').val();

					abrir_modal_espera();
					$.ajax(url, {
						type: 'post',
						headers: {'X-CSRF-TOKEN' : token },
						data: {id_imagen:id_imagen,sentido:sentido},
						dataType: 'json',
						success: function (result) {

							$(preview_image).attr('id',result.imagen.id);
							$(preview_image).attr('src',result.imagen.url);

							swal.close();
							Imagenes.edit.eliminar(id_imagen);
						},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							swal.close();
						},
					});

				});
			},
			verificarCantidades:function()
			{
				//console.log("verificando");
				var seleccionadas = $(".preview_image_container").length;
				$("#imagenes_guardadas").val(seleccionadas);
				var cantidad_maxima_imagenes = $("#cantidad_maxima_imagenes").val();
				//console.log(seleccionadas);

				if(seleccionadas >= cantidad_maxima_imagenes)
				{
					$(".add_button_template").hide();
				}
				else
				{
					$(".add_button_template").show();
				}
			}
		}
	}());

	var method = (function () {
		return {
			submethod:function()
			{

			}
		}
	}());

	//public methods
	return {
		edit:edit
	}
}());
