$(document).ready(function() {

	//--------------------------------------------------------------------------
	//INICIALIZACION DEL CALENDARIO
	var initialLocaleCode = "es";
	var defaultDate = new Date();

	$('#calendar').fullCalendar({

		//botones del header
		header: {
			left: 'today',
			center: 'prev, title, next',
			right: ''
		},
		buttonText: {
			today: 'hoy'
		},
		defaultDate: defaultDate, //fecha por defecto
		locale: initialLocaleCode, //idioma por defecto
		displayEventTime: true,
		selectable: true, //para poder seleccionar
		eventLimit: true, // muestra el link "mas" cuando hay demasiados eventos
		//editable: true,
		select: function(start, end) {

			let calendarObject = $('#calendar').fullCalendar('getCalendar'),
				time_zone = calendarObject.moment().format('Z');

			let checkin = $("#checkin_").val(),
				checkout = $("#checkout_").val(),
				objetoMomentoInicial = moment(start),
				objetoMomentoFinal = moment(end);

			//se asignan checkin y checkout
			objetoMomentoInicial.time(checkin);
			objetoMomentoFinal.time(checkout).subtract(1, 'days');

			$("#fecha_inicio_").val(objetoMomentoInicial.format('DD/MM/YYYY HH:mm:ss'));
			$("#fecha_inicio_formato_").val(objetoMomentoInicial.format('YYYY-MM-DD HH:mm:ss') + time_zone);

			$("#fecha_fin_").val(objetoMomentoFinal.format('DD/MM/YYYY HH:mm:ss'));
			$("#fecha_fin_formato_").val(objetoMomentoFinal.format('YYYY-MM-DD HH:mm:ss') + time_zone);

			$("#noches_").val(daysBetweenTwoDates(objetoMomentoInicial, objetoMomentoFinal));

			reiniciar_formulario_eventos();

			$('#myModal').modal();

		},

		eventRender: function(event, element) {
			// console.log("renderizando...")
			// console.log(event);
			// console.log(element);

			var contenedor_imagen_evento = "<div class='contenedor_imagen_evento' ></div>";
			$(element).prepend(contenedor_imagen_evento);

			switch (event.tipo) {
				case 'reservas':
					{
						var src = $('.carpetaPublic').attr('href') + 'img/Isotipo_MBT.gif';
						if (event.imagen == '') {
							var imagen = "<img class='imgen_evento' src='" + src + "' />";
							$(element).find('.contenedor_imagen_evento').append(imagen).addClass('borde_azul');
						} else {
							src = '';
							var src_minio = 'user_img/' + event.imagen;
							// console.log("paso por aqui: "+src_minio);

							//una vez asignado la imagen se busca la ruta real para las reservas
							//reales
							var token = $('input[name=_token]').val();
							var rutaObtenerUrlStorage = $('.carpetaPublic').attr('href') + "obtener/url/storage/";
							$.ajax({
								url: rutaObtenerUrlStorage,
								type: "get",
								headers: {
									'X-CSRF-TOKEN': token
								},
								datatype: 'json',
								data: {
									url: src_minio
								},
								success: function(data) {
									// console.log(data);
									var imagen = "<img class='imgen_evento' src='" + data + "' />";
									$(element).find('.contenedor_imagen_evento').append(imagen).addClass('borde_azul');
								}
							});
						}
					}
					break;
				case 'reservas_manuales':
					{
						switch (event.motivo) {
							case 'reserva':
								{
									$(element).find('.contenedor_imagen_evento').append('R').addClass('borde_verde');
								}
								break;
							case 'bloqueo':
								{
									var imagen = "<i class='fa fa-lock' aria-hidden='true'></i>";
									$(element).find('.contenedor_imagen_evento').append(imagen).addClass('borde_rojo');
								}
								break;
						}
					}
					break;
				case 'precios_especificos':
					{
						$(element).find('.contenedor_imagen_evento').remove();

						if (event.rendering == 'background') {
							//oculta los backgrounds de los backgrounds events de precio
							$(element).attr("style", "background: transparent !important;")
							// element.append("<b class='mensaje_modificacion_precio' >Precio Modificado:</b><br>"+event.title);
						}

					}
					break;
			}

		},

		dayRender: function(date, cell) {

			//los dias renderizan primero que la vista, asi que no sirve
			var dia = moment(date).format('YYYY-MM-DD');
			// console.log('dia: '+dia);
			// console.log(cell);
			// cell.css("background-color", "white");

		},

		viewRender: function(view, element) {
			var mes_anio = $('.fc-center h2').text();
			var partes = mes_anio.split(" ");
			var mes = partes[0];
			var anio = partes[1];
			$('.fc-center h2').empty().append(mes);
			$('.fc-right').empty().append(anio);

			$("#calendar .leyenda_calendario").remove();
			$(".fc-toolbar.fc-header-toolbar").after($('#contenedor_leyenda_calendario').html());

			refrescar_eventos();
			// actualizarPreciosDiarios();
			// actualizarNochesMinimas();

		},

		eventClick: function(event, element) {

			$('#id_fc_evento_en_edicion_').val('');

			// event.title = "CLICKED! "+event.tipo+' '+event.pk;

			// $('#calendar').fullCalendar('updateEvent', event );

			var rutaObtenerFormularios = $('.rutaObtenerFormularioCalendario').attr('href');
			var token = $('input[name=_token]').val();
			var id = event.pk;
			var motivo = event.motivo;
			var tipo = event.tipo;

			if (event.tipo == 'reservas') {
				contenedor = $('#contenedor_formulario_reserva_mybooktravel');
				contenedor.empty();

				$('#myModalShow').modal();
				var modo = 'show';

				$.ajax({
					url: rutaObtenerFormularios,
					type: "get",
					headers: {
						'X-CSRF-TOKEN': token
					},
					datatype: 'json',
					data: {
						tipo: tipo,
						motivo: motivo,
						modo: modo,
						id: id
					},
					success: function(data) {

						contenedor.empty();
						contenedor.append(data);
					}
				});

			}
			if (event.tipo == 'reservas_manuales') {

				$('#id_fc_evento_en_edicion_').val(event._id);

				$('#myModalEdit').modal();

				var contenedor = $('#contenedor_formulario_calendario_edicion');
				contenedor.empty();
				var modo = 'update';

				$.ajax({
					url: rutaObtenerFormularios,
					type: "get",
					headers: {
						'X-CSRF-TOKEN': token
					},
					datatype: 'json',
					data: {
						tipo: tipo,
						motivo: motivo,
						modo: modo,
						id: id
					},
					success: function(data) {

						contenedor.append(data);

						//zona horaria
						var calendarObject = $('#calendar').fullCalendar('getCalendar');
						var time_zone = calendarObject.moment().format('Z');

						//se inicializan las fechas en formato legible y compatible con el datepicker
						//fecha inicial
						var objFechaInicio = $(contenedor).find('#fecha_inicio');
						var objFechaInicioFormato = $(contenedor).find('#fecha_inicio_formato');

						var objDateFechaInicio = Date.parse(objFechaInicio.val());
						var objMomentFechaInicio = $.fullCalendar.moment(objDateFechaInicio);
						var fecha_inicio = $.fullCalendar.moment(objMomentFechaInicio).format('DD/MM/YYYY HH:mm:ss');
						var fecha_inicio_formato = $.fullCalendar.moment(objMomentFechaInicio).format('YYYY-MM-DD HH:mm:ss') + time_zone;
						objFechaInicio.val(fecha_inicio);
						objFechaInicioFormato.val(fecha_inicio_formato);

						//fecha final
						var objFechaFin = $(contenedor).find('#fecha_fin');
						var objFechaFinFormato = $(contenedor).find('#fecha_fin_formato');

						var objDateFechafin = Date.parse(objFechaFin.val());
						var objMomentFechaFin = $.fullCalendar.moment(objDateFechafin);
						var fecha_fin = $.fullCalendar.moment(objMomentFechaFin).format('DD/MM/YYYY HH:mm:ss');
						var fecha_fin_formato = $.fullCalendar.moment(objMomentFechaFin).format('YYYY-MM-DD HH:mm:ss') + time_zone;
						objFechaFin.val(fecha_fin);
						objFechaFinFormato.val(fecha_fin_formato);

						inicializar_date_pickers_calendario(contenedor);
						inicializarValidacionesGenerales();
						inicializar_enviador_formularios();
						inicializar_calculo_montos_reserva();
					}
				});

			}

		}

	});

	//--------------------------------------------------------------------------
	//al iniciar la pagina se buscan los eventos que esten guardados
	// refrescar_eventos();//se movio al view render

	//--------------------------------------------------------------------------
	//LISTENERS DE EVENTOS SOBRE LOS CAMPOS DE LOS FORMULARIOS

	$(".solo_entero_positivo").on("keypress", function(event) {
		return solo_entero_positivo(this, event);
	});

	$('input[name=accion_calendario]').on('change', function(event) {

		var tipo = $(this).attr('tipo');
		var motivo = $(this).attr('motivo');
		var modo = 'create';
		var ruta = $('.rutaObtenerFormularioCalendario').attr('href');

		var contenedor = $('#contenedor_formulario_calendario');
		contenedor.empty();

		abrir_modal_espera();

		$.ajax({
			url: ruta,
			type: "get",
			headers: {
				'X-CSRF-TOKEN': $('input[name=_token]').val()
			},
			datatype: 'json',
			data: {
				tipo: tipo,
				motivo: motivo,
				modo: modo
			},
			success: function(data) {
				contenedor.empty();
				contenedor.append(data);
				$(contenedor).find('#fecha_inicio').val($("#fecha_inicio_").val());
				$(contenedor).find('#fecha_inicio_formato').val($("#fecha_inicio_formato_").val());
				$(contenedor).find('#fecha_fin').val($("#fecha_fin_").val());
				$(contenedor).find('#fecha_fin_formato').val($("#fecha_fin_formato_").val());
				$(contenedor).find('#noches').val($("#noches_").val());

				inicializar_date_pickers_calendario(contenedor);

				inicializarValidacionesGenerales();
				inicializar_enviador_formularios();
				inicializar_calculo_montos_reserva();

				swal.close();
			}
		});

	});

	/*
	$('#motivo').on('change', function(event) {
		// console.log('cambio motivo');
		ocultar_campos('.campos_motivo');
		var seleccion = $(this).val();
		mostrar_campos('.campos_motivo_'+seleccion);
	});
	*/

});


//----------------------------------------------------------------------
//FUNCIONES

function inicializar_calculo_montos_reserva() {
	// console.log('montos_reserva '+$(".montos_reserva").length);
	$(".montos_reserva").on("change keyup keydown", function() {
		// console.log("cambio");

		var form = $(this).parents('form:first');
		// console.log(form);

		var precio = $(form).find("#precio").val() != "" ? parseFloat($(form).find("#precio").val()) : 0;
		var costos_adicionales = $(form).find("#costos_adicionales").val() != "" ? parseFloat($(form).find("#costos_adicionales").val()) : 0;
		var monto_anticipo = $(form).find("#monto_anticipo").val() != "" ? parseFloat($(form).find("#monto_anticipo").val()) : 0;
		var noches = $(form).find("#noches").val() != "" ? parseInt($(form).find("#noches").val()) : 0;
		var monto_total = 0;
		var monto_deuda_actual = 0;

		monto_total = (precio * noches) + costos_adicionales;
		monto_anticipo = (monto_anticipo > monto_total) ? 0 : monto_anticipo;
		monto_deuda_actual = monto_total - monto_anticipo;

		$(form).find("#monto_total").val(monto_total);
		$(form).find("#monto_anticipo").val(monto_anticipo);
		$(form).find("#monto_deuda_actual").val(monto_deuda_actual);

	});

	$('input[name=comprobante]').on('change', function(event) {
		if ($(this)[0].checked) {
			$('#email').prop('disabled', false);
		} else {
			$('#email').prop('disabled', true);
		}
	});

}

function mostrar_campos(selector_contenedor) {
	var contenedor = $(selector_contenedor);
	contenedor.removeClass('hide').show();
	var campos = contenedor.find('.form-control-mbt')
	campos.attr('disabled', false);

	$.each(campos, function(key, value) {
		//campos es un array clave valor,
		//pero en realidad valor contiene objetos
		$(value).attr("value", $(value).attr("valor_predeterminado") ? $(value).attr("valor_predeterminado") : "");
	});
}

function ocultar_campos(selector_contenedor) {
	//console.log("paso por aqui");
	var campos = $(selector_contenedor);
	campos.find('.form-control-mbt').attr('disabled', true).val('');
	campos.hide();
}

function reiniciar_formulario_eventos() {

	//si hay alguna accion seleccionada, se deselecciona
	var accion = $('input[name=accion_calendario]:checked');
	if (accion.length > 0) accion.prop("checked", false);

	$('#contenedor_formulario_calendario').empty();


	//se quitan los mensajes de error
	// var validator = $( "#form_eventos" ).validate();
	// validator.resetForm();

	//se quita el estilo de los campos con error
	// $('.form-group row col-md-12').removeClass('has-error has-feedback');

	//se dispara el clic en las acciones por defecto
	// $(".accion_por_defecto").click();

	//se vacian los campos obligatorios para todas las acciones
	// $(".obligatorio").val("");

	// swal("Deleted!", "Your imaginary file has been deleted!", "success");

}

function actualizarPreciosDiarios() {
	$('.contenedor_precio_calendario').empty();

	var viewObject = $('#calendar').fullCalendar('getView');
	var viewElement = viewObject.el;
	// console.log(viewObject);
	var inicio = moment(viewObject.start).format('YYYY-MM-DD');
	var fin = moment(viewObject.end).format('YYYY-MM-DD');
	// console.log('nuevo intervalo: '+inicio+' '+fin);

	var ruta = $('.rutaObtenerPreciosPropiedad').attr('href');

	$.ajax({
		url: ruta,
		type: "get",
		headers: {
			'X-CSRF-TOKEN': $('input[name=_token]').val()
		},
		datatype: 'json',
		data: {
			fecha_incio: inicio,
			fecha_fin: fin
		},
		success: function(data) {
			$(data.precios).each(function(index, element) {
				var celda = $(viewElement).find(".fc-day.fc-widget-content[data-date=" + element.fecha + "]");
				var contenedor_precio = celda.find('.contenedor_precio_calendario');
				var precio = ponerFormatoMonto(element.precio);
				if (contenedor_precio.length == 0) {
					celda.append("<b class='contenedor_precio_calendario' >" + precio + "</b>");
				} else {
					$(contenedor_precio).empty().append(precio);
				}
			});
		}
	});
}

function actualizarNochesMinimas() {
	$('.contenedor_noches_minimas_calendario').empty();

	var viewObject = $('#calendar').fullCalendar('getView');
	var viewElement = viewObject.el;
	// console.log(viewObject);
	var inicio = moment(viewObject.start).format('YYYY-MM-DD');
	var fin = moment(viewObject.end).format('YYYY-MM-DD');
	// console.log('nuevo intervalo: '+inicio+' '+fin);

	var ruta = $('.rutaObtenerNochesPropiedad').attr('href');

	$.ajax({
		url: ruta,
		type: "get",
		headers: {
			'X-CSRF-TOKEN': $('input[name=_token]').val()
		},
		datatype: 'json',
		data: {
			fecha_incio: inicio,
			fecha_fin: fin
		},
		success: function(data) {
			$(data.noches).each(function(index, element) {
				var celda = $(viewElement).find(".fc-day.fc-widget-content[data-date=" + element.fecha + "]");
				var contenedor_noches_minimas = celda.find('.contenedor_noches_minimas_calendario');
				var noches = ponerFormatoMonto(element.noches);
				if (contenedor_noches_minimas.length == 0) {
					celda.append("<b class='contenedor_noches_minimas_calendario' >" + noches + "</b>");
				} else {
					$(contenedor_noches_minimas).empty().append(noches);
				}
			});
		}
	});
}

function callback_form_eventos(result) {
	var success = result.success;
	var mensaje = result.mensaje;
	if (success) {
		// $("#form_eventos")[0].reset();
		$('#myModal').modal('hide');
		$('#myModalEdit').modal('hide');
		refrescar_eventos();
		swal.close();
	} else {
		// console.log(mensaje);
		//alert(mensaje);
		abrir_modal_error(mensaje);
	}

}

function remover_eventos() {
	$('#calendar').fullCalendar('removeEvents');
}

function eliminar_evento(id) {
	// var id_fc_evento = $('#id_fc_evento_en_edicion_').val();
	// console.log("id_fc_evento: "+id_fc_evento);

	//eliminar el evento del calendario, no funciona
	// $('#calendar').fullCalendar('removeEvents',id_fc_evento);

	abrir_modal_espera();

	var ruta = $('.rutaEliminarEventoCalendario').attr('href');
	var token = $('input[name=_token]').val();

	//errores de token mismatch exception
	$.ajax({
		url: ruta,
		type: "post",
		headers: {
			'X-CSRF-TOKEN': $('input[name=_token]').val()
		},
		// datatype : 'json',
		data: {
			id: id
		},
		success: function(data) {
			// console.log(data);
			$('#myModalEdit').modal('hide');
			refrescar_eventos();
			swal.close();
		}
	});

}

function refrescar_eventos() {
	remover_eventos();
	var ruta = $('.rutaObtenerEventosCalendario').attr('href');

	$.ajax({
		url: ruta,
		type: "post",
		headers: {
			'X-CSRF-TOKEN': $('input[name=_token]').val()
		},
		datatype: 'json',
		success: function(data) {

			$('#calendar').fullCalendar('renderEvents', data.events);

			/*
			$('#calendar').fullCalendar({
				events: [data.events],
				// eventRender: function(event, element) {
					// element.qtip({
						// content: event.description
					// });
				// }
			});
			*/

			/*
			$.each(data.events, function(index, eventData){
				console.log("se ordena renderizar el evento");
				console.log(eventData);
				//$('#calendar').fullCalendar('renderEvent', event);
				$('#calendar').fullCalendar('renderEvent', eventData, true);
			});
			*/
			actualizarPreciosDiarios();
			actualizarNochesMinimas();
		}
	});
}

function daysBetweenTwoDates(first, second) {
	var difference = (second - first) / (1000 * 60 * 60 * 24);
	//console.log(difference);
	return Math.round(difference);
}

function solo_entero_positivo(campo, event) {
	var valor_campo = campo.value;
	var valor_tecla_pulsada = event.key;
	var valor_a_evaluar = valor_campo + valor_tecla_pulsada;

	// alert(parseInt('2'));
	if (Number.isInteger(parseInt(valor_a_evaluar)) && valor_a_evaluar > 0) {
		campo.value = parseInt(valor_campo);
		return true;
	} else return false;
}

function reemplazar(esto, por_esto, en_este_string) {
	return en_este_string.split(esto).join(por_esto);
}

function ponerFormatoMonto(monto) {
	return numberFormat(parseInt(monto), 0, ',', '.');
}

function numberFormat(number, amountOfDecimals, decimalSeparator, thousandSeparator) {
	decimalSeparator = typeof decimalSeparator !== 'undefined' ? decimalSeparator : '.';
	thousandSeparator = typeof thousandSeparator !== 'undefined' ? thousandSeparator : ',';

	var parts = number.toFixed(amountOfDecimals).split('.');
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);

	return parts.join(decimalSeparator);
}

function inicializar_date_pickers_calendario(contenedor) {
	var calendarObject = $('#calendar').fullCalendar('getCalendar');
	var time_zone = calendarObject.moment().format('Z');
	var checkin = $("#checkin_").val();
	var checkout = $("#checkout_").val();
	var objFechaInicio = $(contenedor).find('#fecha_inicio');
	var objFechaFin = $(contenedor).find('#fecha_fin');

	//datepicker
	var opciones_datepicker = {
		autoClose: true,
		singleDate: true,
		showShortcuts: false,
		singleMonth: true,
		format: 'DD/MM/YYYY HH:mm:ss',
		language: 'es',
		setValue: function(s) {
			// console.clear();
			// console.log('seleccion '+s);

			//hora
			var id = $(this).attr('id');
			var time = (id == 'fecha_inicio') ? checkin : (id == 'fecha_fin') ? checkout : '00:00:00';

			//fecha
			var objMoment = $.fullCalendar.moment(s, 'DD/MM/YYYY HH:mm:ss');
			var fecha_visible = $.fullCalendar.moment(objMoment).format('DD/MM/YYYY HH:mm:ss');
			var fecha_formateada = $.fullCalendar.moment(objMoment).format('YYYY-MM-DD HH:mm:ss') + time_zone;

			//datos originales
			var fecha_original = $(contenedor).find('#' + id).val();
			var fecha_mormateada_original = $(contenedor).find('#' + id + '_formato').val();

			//asignacion de nuevas fechas
			$(contenedor).find('#' + id).val(fecha_visible);
			$(contenedor).find('#' + id + '_formato').val(fecha_formateada);

			// console.log("objFechaInicio: "+objFechaInicio.val());
			// console.log("objFechaFin: "+objFechaFin.val());

			// si la fecha inicial supera a la final, se devuelven los cambios
			if (objFechaInicio.val() > objFechaFin.val()) {
				$(contenedor).find('#' + id).val(fecha_original);
				$(contenedor).find('#' + id + '_formato').val(fecha_mormateada_original);
			}

			var objetoMomentoInicial = $.fullCalendar.moment(objFechaInicio.val(), 'DD/MM/YYYY');
			var objetoMomentoFinal = $.fullCalendar.moment(objFechaFin.val(), 'DD/MM/YYYY');

			var noches = objetoMomentoFinal.diff(objetoMomentoInicial, 'days');
			// console.log(noches);
			$(contenedor).find("#noches").val(noches);

		}
	};
	// console.log('inicializacion datepickers');
	// console.log(contenedor);
	objFechaInicio.dateRangePicker(opciones_datepicker);
	objFechaFin.dateRangePicker(opciones_datepicker);

	//no permitir editar
	$(objFechaInicio).on("keydown keyup", function() {
		return false;
	});
	$(objFechaFin).on("keydown keyup", function() {
		return false;
	});

}

//en desuso
//permite agregar eventos en tiempo real
//sin almacenarlos antes en base de datos
function agregarEvento() {
	var title = $("#titulo").val();

	var start = $.fullCalendar.moment.utc($("#fecha_inicio_formato").val());
	var end = $.fullCalendar.moment.utc($("#fecha_fin_formato").val());

	var eventData;
	if (title == "") {
		alert("Debes Indicar un titulo");
	} else {
		eventData = {
			title: title,
			start: start,
			end: end,
			allDay: false
		};
		//console.log(eventData);

		$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

		$('#calendar').fullCalendar('unselect');

		$('#myModal').modal('toggle');

		// $("#form_eventos")[0].reset();
	}


}