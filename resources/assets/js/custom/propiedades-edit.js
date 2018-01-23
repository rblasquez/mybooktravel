$('a[title]').tooltip();

function send_form(form_selector) {
	var form = $(form_selector);
	var callback = $(form_selector).attr("callback");
	$.ajax({
		type: form.attr("method"),
		url: form.attr("action"),
		data: form.serialize(), // $(form_selector).serialize() serializes the form's elements.
		success: function(result) {
			// console.log(result);
			if (callback != "") eval(callback);
		},
		error: function(result) {
			// console.log(result);
			if (callback != "") eval(callback);
		}
	});
}


function inicializar_enviador_formularios() {
	$(".form_editar_seccion").on("submit", function(event) {
		// alert("hizo el submit");
		event.preventDefault();
		var form = $(this);

		var data = form.serialize();

		var prevenir_envio = $(form).attr("prevenir_envio");

		if (prevenir_envio != 1) {
			$(form).attr("prevenir_envio", "1");
			// console.log (data);

			abrir_modal_espera();

			var callback = form.attr("callback");
			$.ajax({
				type: form.attr("method"),
				url: form.attr("action"),
				data: data,
				success: function(result, status) {
					setTimeout(function() {
						$(form).attr("prevenir_envio", "0");
					}, 3000);
					if (callback != "") eval(callback);
				},
				error: function(result, status) {
					setTimeout(function() {
						$(form).attr("prevenir_envio", "0");
					}, 3000);
					if (callback != "") eval(callback);
				}
			});

		}

	});
}
inicializar_enviador_formularios();

function callback_actualizar_datos(result) {

	if (result.success == true) {
		// alert("guardado con exito");
		abrir_modal_success();
		// swal.close();
	} else {
		// alert("guardado con exito");
		abrir_modal_error();
	}
}

function abrir_modal_espera(mensaje = 'Mientras se verifica la información.') {
	swal({
		title: "Espere",
		text: mensaje,
		icon: $(".carpetaPublic").attr("href") + "img/Isotipo_MBT.gif",
		button: false,
		closeOnClickOutside: false,
		closeOnEsc: false
	});
}

function abrir_modal_error(mensaje = "Ha ocurrido algo inusual, verifique los datos del formulario. \n Si aún no tiene éxito, intente mas tarde.") {
	swal({
		title: "Disculpe",
		text: mensaje,
		icon: "error",
		confirmButtonText: "Entiendo",
		// timer: 2000,
		// showConfirmButton: false,
	});
}

function abrir_modal_success(mensaje = "Guardado con Éxito") {
	swal({
		title: "Listo",
		text: mensaje,
		type: "success",
		confirmButtonText: "Entiendo",
		// timer: 2000,
		// showConfirmButton: false,
	});
}