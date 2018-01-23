console.log('prueba2')
var contador_imagenes = 0,
	imagenes_cargar = 0;

function calcular() {
	var value = $('#precio').val()
	console.log(value)
	var porcentaje = 7;
	value = value.replace('$', '');
	value = value.replace(',', '');
	value = $.trim(value);
	if ($('input[name=anfitrion]:checked').val() == 'mybooktravel') {
		porcentaje = porcentaje + 5;
	}

	var base = value,
		comision = (porcentaje * parseInt(value)) / 100,
		ingreso = parseInt(value) + comision;

	comision = $.number(comision, 0, '.', ',');
	ingreso = $.number(ingreso, 0, '.', ',');
	base = $.number(base, 0, '.', ',');

	//$('#comision-porcentaje').html(porcentaje)
	$('.base').html(base)
	$('.comision').html(comision)
	$('.ingreso').html(ingreso)
}

jQuery(document).ready(function($) {

	$('#precio').on('change, keyup', function(event) {
		event.preventDefault();
		calcular()
	});

	$('.moneda').inputmask({
		alias: 'numeric',
		groupSeparator: ',',
		autoGroup: true,
		digitsOptional: true,
		prefix: '$ ',
		placeholder: '0',
	});

	$('#moneda_propiedad').on('change', function(event) {
		event.preventDefault();
		console.log($(this).val())
		$('.totalizando .moneda_iso').html($(this).val())
	});

	$('input:text, textarea').maxlength({
		customMaxAttribute: "90",
		warningClass: "label label-success",
		limitReachedClass: "label label-danger",
		preText: 'Tienes ',
		separator: ' de ',
		postText: ' caracteres restantes.',
	});

	$('.lugares_cercanos').repeater({
		initEmpty: false,
		isFirstItemUndeletable: true,
		defaultValues: {
			'text-input': 'foo'
		},
		show: function() {
			$(this).slideDown();
		},
		hide: function(deleteElement) {
			$(this).slideUp(deleteElement);
		},
		ready: function(setIndexes) {},
		isFirstItemUndeletable: true
	})

	$('.dist-habitaciones').repeater({
		initEmpty: true,
		isFirstItemUndeletable: true,
		defaultValues: {
			tipo_habitacion: 2,
			tipo_cama: 2,
		},
		defaultValues: {
			tipo_cama: ['1'],
		},
		show: function() {
			var params = [this];
			$(this).find("label[for]").each(function(index, element) {
				var currentRepeater = params[0];
				var originalFieldId = $(element).attr("for");
				var newField = $(currentRepeater).find("input[id='" + originalFieldId + "']");
				if ($(newField).length > 0) {
					var newFieldName = $(newField).attr('name');
					$(newField).attr('id', newFieldName);
					$(currentRepeater).find("label[for='" + originalFieldId + "']").attr('for', newFieldName);
				}
			}, params);

			$(this).slideDown();
			$(this).find('.numero-habitacion').html(nroHabitacion)
		},
		hide: function(deleteElement) {
			$(this).slideUp(deleteElement);
		},
		repeaters: [{
			isFirstItemUndeletable: true,
			selector: '.inner-repeater',
			show: function() {
				$(this).slideDown();
			},
			hide: function(deleteElement) {
				$(this).slideUp(deleteElement);
			}
		}],
	})

	$("#direccion").on("keydown", function(e) {
		if (e.which == 13) {
			event.preventDefault();
		}
	});

	$('input[name=anfitrion]').on('change', function(event) {
		var div = $('#anfitriones');
		div.find('.collapse').collapse('hide');
		div.find('.form-control').attr('disabled', true);
		if ($(this).val() == 'otro') {
			div.find('div#anfitrionDatos').collapse('show');
			div.find('input').attr('disabled', false);
		} else if ($(this).val() == 'mybooktravel') {
			div.find('div#costo_adicional_anfitrion').collapse('show');
		} else {
			div.collapse('hide')
		}
		calcular();
	});

	$('input:radio[name=medio]').on('change', function(event) {
		if ($(this).val() == 'wu') {
			var div = $('.wu');
			div.collapse('show');
			$('.transferencia').collapse('hide');
			div.find('input').attr('disabled', false);
			$('.transferencia').find('input').attr('disabled', true);
		} else if ($(this).val() == 'transferencia') {
			var div = $('.transferencia');
			div.collapse('show');
			$('.wu').collapse('hide');
			div.find('input').attr('disabled', false);
			$('.wu').find('input').attr('disabled', true);
		} else {
			$('.wu').collapse('hide');
			$('.transferencia').collapse('hide');
			$('.wu, .transferencia').find('input').attr('disabled', true);
		}
	});

	$('input:radio[name=oferta_propiedad_id]').on('change', function(event) {
		event.preventDefault();
		$('.ayudaOferta').collapse('hide');
		$('#ayudaOferta' + $(this).val()).collapse('show');
	});

	$('input:radio[name=garantia_reserva_id]').on('change', function(event) {
		event.preventDefault();
		$('.ayudaGarantia').collapse('hide');
		$('#ayudaGarantia' + $(this).val()).collapse('show');
	});

	$('.check-tarifa').on('change', function(event) {
		event.preventDefault();
		var check = $(this)
		if (check.prop('checked')) {
			var collapse = 'show';
			var state = false;
		} else {
			var collapse = 'hide';
			var state = true;
		}
		check = check.parents('div.tarifa')
		check.find('.costo').collapse(collapse)
		check.find('input:text').attr('disabled', state);
	});

});

var mostrarMapa = false;

$("#formPublicar").steps({
	titleTemplate: '#title#',
	headerTag: 'h3',
	bodyTag: 'div',
	transitionEffect: 'slideLeft',
	autoFocus: true,
	labels: {
		cancel: "Cancelars",
		finish: "Publicar",
		next: "Siguiente",
		previous: "Anterior",
		loading: "Cargando ..."
	},
	onInit: function(event, currentIndex) {
		$(".wizard > .actions > ul > li:nth-child(1) a").css({
			display: "none"
		});
		$(".wizard > .actions > ul > li").addClass("pull-right");
	},
	onContentLoaded: function(event, currentIndex) {
		console.log('Prueba')
	},
	onStepChanged: function(event, currentIndex, priorIndex) {
		if (currentIndex == 1) {
			dist_habitaciones();

			var banios_selected = 0;
			$('.banio').click(function(event) {
				var checked = $(this).siblings('input[type=checkbox]')[0].checked;

				if (banios_selected == nro_banios && checked == false) {
					event.preventDefault()
				}
			});

			$('.tiene_banio').on('change', function(event) {
				banios_selected = $('.tiene_banio:checked').length;
			});
		}

		if (currentIndex == 2 && mostrarMapa == false) {
			mapaPropiedadCrear();
			mostrarMapa = true;
		}
	},
	onStepChanging: function(event, currentIndex, newIndex) {
		var form = $(this).parent('form');

		if (newIndex == 0) {
			$(".wizard > .actions > ul > li:nth-child(1) a").css({
				display: "none"
			});
			$(".wizard > .actions > ul > li").addClass("pull-right");
		} else {
			$(".wizard > .actions > ul > li:nth-child(1) a").css({
				display: "block"
			});
			$(".wizard > .actions > ul > li").removeClass("pull-right");
		}

		if (currentIndex < newIndex) {
			return form.valid();
		} else {
			return true;
		}
	},
	onFinishing: function(event, currentIndex) {
		if ($('input[name=anfitrion]:checked').length == 0) {
			swal({
					icon: 'info',
					title: 'Espera!',
					text: 'no indicaste un anfitrión para tu propiedad!',
				})
				.then((value) => {
					$('html, body').animate({
						scrollTop: ($('#anfitriones').offset().top - 140) + 'px'
					}, 'fast');
				})

		} else if ($('input[name=medio]:checked').length == 0) {
			swal({
					icon: 'info',
					title: 'Espera!',
					text: 'no seleccionaste un medio de pago!',
				})
				.then((value) => {
					$('html, body').animate({
						scrollTop: ($('#metodoPagoSeccion').offset().top - 140) + 'px'
					}, 'fast');
				})

		} else {
			$(this).parent('form').submit();
		}
	},
});

$('#frmStore').on('submit', function(event) {
	event.preventDefault();
	if (Object.keys(validate.invalid).length == 0) {
		block('#frmStore')
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			dataType: 'json',
			data: $(this).serialize(),
		}).done(function(data) {
			var url_redirecciona = $('#rutaPropiedad').attr('href').replace(':ID', data.id);
			swal({
					icon: 'success',
					title: 'Completado!',
					text: 'Su propiedad ha sido publicada correctamente, puede editarla para agregar mas fotos y el detalle de las habitaciones',
					buttons: false,
					timer: 3000,
				})
				.then((value) => {
					$('#frmStore').unblock();
					location.href = url_redirecciona;
				})
			$('#frmStore').unblock();
		}).fail(function(data) {
			swal({
				icon: 'error',
				title: 'Disculpa!',
				text: 'Algo ha salido mal, por favor intenta nuevamente, o presiona <strong>"F5"</strong> para recargar el sitio.',
				animation: false,
				html: true,
			});
			$('#frmStore').unblock();
		})
	}
});

$('input:checkbox[name=tipo_checkin]').on('change', function(event) {
	var input = $('#checkin_estricto');
	var check = $(this).prop('checked');

	if (check) {
		input.removeAttr('disabled');
	} else {
		input.attr('disabled', true);
	}
});

if ($('#nhabitaciones').val() != '') {
	$('#nhabitaciones').change();
}

var nro_habitaciones = 0;
$('#nhabitaciones').on('change', function(event) {
	nro_habitaciones = parseInt($(this).val())
});

var nro_banios = 0;
$('#nbanios').on('change keyup keydown', function(event) {
	nro_banios = parseInt($(this).val())
});

var habitacion = $('.habitacion');
var habitaciones = 0;
var nroHabitacion = 0;

function dist_habitaciones() {
	if (nro_habitaciones > habitaciones) {
		var dif = nro_habitaciones - habitaciones;
		for (var i = 1; i <= dif; i++) {
			nroHabitacion = nroHabitacion + 1;
			$('.agregar-habitacion').click();
		}
		habitaciones = nro_habitaciones;
	} else if (nro_habitaciones < habitaciones) {
		var dif = habitaciones - nro_habitaciones;
		for (var i = 1; i <= dif; i++) {
			nroHabitacion = nroHabitacion - 1;
			$('.eliminar-habitacion').last().click();
		}
		habitaciones = nro_habitaciones;
	}
}


function bloquearEnvioImagen(mensaje = '') {
	block('.imagenes-preview', mensaje);
	block('[role=menu][aria-label=Pagination]');
}

function desbloquearEnvioImagen() {
	$('.imagenes-preview').unblock();
	$('[role=menu][aria-label=Pagination]').unblock();
}

document.addEventListener("DOMContentLoaded", function(event) {

	Imagine.previewer.start({
		containerSelector: "#contenedor_imagenes_galeria",
		maxFiles: 20,
		maxFilesOnSelect: 20,
		onSelect: function(files) {
			console.log("seleccionaron archivos");
			bloquearEnvioImagen('Archivos Seleccionados');

			// console.log(files);
		},
		onFinishSelect: function(files) {

			// console.log("previsualizó todas");
			$(".blockMsg").html("Seleccionó todas, Preparando envío.");

			inicializarRotators();
			verificarCantidadImagenes();
			inicializarSelectorImagenPrimaria();

			//compression en lote recargando el src
			Imagine.compressor.start({
				containerSelector: "#contenedor_imagenes_galeria",
				compressionLevel: 0.6, //quality. 0: worst, 1: best
				maxWidth: 1920,
				maxHeight: 1080,
				onFinishEveryImage: function(img) {
					$(".preview_image_container .preview_image").each(function(index, element) {
						console.log(index);
						console.log(element);
					});
					// console.log("comprimio la imagen "+img.getAttribute('preview_id'));
				},
				onfinishAllImages: function(selector) {

					// console.log("comprimió todas");

					Imagine.sender.send({
						containerSelector: "#contenedor_imagenes_galeria",
						url: ruta_imagen_temporales,
						csrfToken: $("[name=_token]").val(),
						onFinishEveryImage: function(response, domImage) {
							console.log("imgen enviada");
							console.log(domImage);

							if (JSON.parse(response.responseText).success == true) {
								$(domImage).attr("id", JSON.parse(response.responseText).id_imagen);
							} else {
								$(domImage).parents(".preview_image_container").remove();

								inicializarRotators();
								verificarCantidadImagenes();
								inicializarSelectorImagenPrimaria();

								desbloquearEnvioImagen();
							}

						},
						onfinishAllImages: function() {

							console.log('envió todas');
							desbloquearEnvioImagen();

						}
					});


				}
			});

		}
	});
});

setInterval(function() {
	$('.preview_image_container .delete').each(function(key, element) {
		var old_onclick = $(element).attr('onclick');
		var new_onclick = "eliminar_imagen($(this).parents('.preview_image_container').find('.preview_image').attr('id'))";
		if (old_onclick != new_onclick) {
			$(element).attr('onclick', '');
			$(element).attr('onclick', new_onclick);
		}

	});
}, 100);

function eliminar_imagen(id_imagen) {
	bloquearEnvioImagen();
	console.log(id_imagen)
	var token = $('input[name=_token]').val();
	var ruta = document.getElementById('rutaBorrarTemporal').href;
	ruta = ruta.replace(':ARCHIVO', id_imagen)

	$.getJSON(ruta, function(json, textStatus) {

		if (json.estatus == 'success') {} else {

		}
		$(".preview_image[id=" + id_imagen + "]").parents(".preview_image_container").remove();
		desbloquearEnvioImagen();
		verificarCantidadImagenes();

	});
}

function inicializarRotators() {
	$('.rotator').unbind('click').on('click', function(e) {

		bloquearEnvioImagen();

		var sentido;
		var preview_image_container = $(this).parents('.preview_image_container');
		var preview_image = $(preview_image_container).find(".preview_image");
		var id_imagen = $(preview_image).attr('id');

		preview_image.on('load', function(event) {
			$('.imagenes-preview').unblock();
		});

		if ($(this).hasClass('clockwise')) {
			sentido = "derecha";
		} else {
			sentido = "izquierda";
		}

		var url = document.getElementById('rutaRotarTemporal').href;
		url = url.replace(':ARCHIVO', id_imagen)
		url = url.replace(':SENTIDO', sentido)
		var token = $('input[name=_token]').val();

		$.ajax({
				url: url,
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': token
				},
			})
			.done(function(result) {
				$(preview_image).attr('id', result.imagen.id);
				$(preview_image).attr('src', result.imagen.url);

				desbloquearEnvioImagen();

			})
			.fail(function(XMLHttpRequest, textStatus, errorThrown) {
				console.log(XMLHttpRequest);
				console.log(textStatus);
				console.log(errorThrown);

				desbloquearEnvioImagen();

			})
	});
}

function inicializarSelectorImagenPrimaria() {
	$(".make_main_image").unbind('click')
	$(".make_main_image").on("click", function() {
		if ($(this).attr("for") == "") {
			var uniqueId = Date.now();
			var header = $(this).parents(".preview_image_header");
			$(header).find(".main_image_input").attr("id", uniqueId);
			$(this).attr("for", uniqueId);
		}
		var id_imagen = $(this).parents('.preview_image_container').find('.preview_image').attr('id');
		var url = $(".asignarImagenPrimaria").attr("href");
		var token = $('input[name=_token]').val();
	});
}

function verificarCantidadImagenes() {
	var seleccionadas = $(".preview_image_container").length;
	$("#imagenes_guardadas").val(seleccionadas);
	var cantidad_maxima_imagenes = $("#cantidad_maxima_imagenes").val();
	console.log(cantidad_maxima_imagenes);

	if (seleccionadas >= cantidad_maxima_imagenes) {
		$(".add_button").hide();
	} else {
		$(".add_button").show();
	}
}