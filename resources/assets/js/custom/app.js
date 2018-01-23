$(document).ready(function() {
	lazyImages()
});


$('[data-background="image"]').each(function() {
	var elemento = $(this);

	var background_src = elemento.data("src");

	if (background_src != "undefined") {
		var new_css = {
			"background-image": "url('" + background_src + "')",
			"background-position": "center center",
			"background-size": "cover"
		};

		elemento.css(new_css);
	}
});

$('.card .header img, .card .content img').each(function() {
	//$card = $(this).parent().parent();
	var header = $(this).parent();

	var background_src = $(this).attr("src");

	if (background_src != "undefined") {
		var new_css = {
			"background-image": "url('" + background_src + "')",
			"background-position": "center center",
			"background-size": "cover"
		};

		header.css(new_css);
	}
});


function lazyImages() {
	var bLazy = new Blazy({
		selector: 'img',
		offset: 100,
		breakpoints: [{
			width: 420,
			src: 'data-src'
		}],
		success: function(element) {
			setTimeout(function() {
				var parent = element.parentNode;
				parent.className = parent.className.replace(/\bloading\b/, '');
			}, 200);
		}
	});
}


$('#status').fadeOut();
$('#preloader').delay(350).fadeOut('slow');
$('body').delay(350).css({
	'overflow': 'visible'
});

$(document).ready(function() {

	$('#moneda').on('change', function(event) {
		event.preventDefault();
		var form = $('#cambioMoneda');
		form.submit();
	});
	iniciarTooltip()
});


function iniciarTooltip() {
	$('.masterTooltip, .info').hover(function() {
		var title = $(this).attr('title');
		$(this).data('tipText', title).removeAttr('title');
		$('<p class="tooltipp"></p>')
			.text(title)
			.appendTo('body')
			.fadeIn('slow');
	}, function() {
		$(this).attr('title', $(this).data('tipText'));
		$('.tooltipp').remove();
	}).mousemove(function(e) {
		var mousex = e.pageX + 20;
		var mousey = e.pageY + 10;
		$('.tooltipp')
			.css({
				top: mousey,
				left: mousex
			})
	});
}

function block(elemento, mensaje = '') {

	$(elemento).block({
		//message: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
		message: typeof mensaje !== 'undefined' ? mensaje : '',
		baseZ: 5,
		overlayCSS: {
			backgroundColor: '#fff',
			opacity: 0.8,
			cursor: 'wait'
		},
		css: {
			width: 100,
			'-webkit-border-radius': 10,
			'-moz-border-radius': 10,
			border: 0,
			padding: 0,
			backgroundColor: 'transparent'
		}
	});
}

$(document).ready(function() {
	$('#fechas_busquedas').dateRangePicker({
			autoClose: true,
			format: 'DD-MM-YYYY',
			separator: ' a ',
			language: 'es',
			startOfWeek: 'monday',
			startDate: moment(),
			endDate: false,
			hoveringTooltip: true,
			customArrowPrevSymbol: '<i class="fa fa-arrow-circle-left"></i>',
			customArrowNextSymbol: '<i class="fa fa-arrow-circle-right"></i>',
			monthSelect: true,
			yearSelect: false,
			inline: true,
			container: '#date-range12-container',
			alwaysOpen: true,
			getValue: function() {
				var fecha_in = $(this).find('.startDate'),
					fecha_out = $(this).find('.endDate')

				if (fecha_in.val() && fecha_out.val())
					return fecha_in.val() + ' to ' + fecha_out.val();
				else
					return '';
			},
			setValue: function(s, s1, s2) {
				var fecha_in = $(this).find('.startDate'),
					fecha_out = $(this).find('.endDate')
				fecha_in.val(s1);
				fecha_out.val(s2);
			}
		})
		.bind('datepicker-change', function(event, obj) {
			verificarEnvioFormBuscaresktop();
		});

	$('.fechas_mobile').find('.startDate').dateRangePicker({
		format: 'DD-MM-YYYY',
		startDate: moment(),
		language: 'es',
		startOfWeek: 'monday',
		autoClose: true,
		singleDate: true,
		showShortcuts: false,
		singleMonth: true,
		showTopbar: false,
		getValue: function() {
			var fecha_in = $('.fechas_mobile .startDate');
			if (fecha_in.val())
				return fecha_in.val() + ' to ' + $('.fechas_mobile .endDate').val();
			else
				return '';
		},
		setValue: function(s, s1, s2) {
			var fecha_in = $('.fechas_mobile .startDate');
			fecha_in.val(s1);
		}
	}).bind('datepicker-change', function(event, obj) {
		var date = moment(obj.value, "DD-MM-YYYY").add(1, 'days').format('DD-MM-YYYY');
		$(".fechas_mobile .endDate").data('dateRangePicker').setStart(date).open();
	});


	$('.fechas_mobile .endDate').dateRangePicker({
		format: 'DD-MM-YYYY',
		startDate: moment(),
		language: 'es',
		startOfWeek: 'monday',
		autoClose: true,
		singleDate: true,
		showShortcuts: false,
		singleMonth: true,
		showTopbar: false,
		getValue: function() {
			var fecha_out = $('.fechas_mobile .endDate');
			if (fecha_out.val())
				return $('.fechas_mobile .startDate').val() + ' to ' + fecha_out.val();
			else
				return '';
		},
		setValue: function(s, s1, s2) {
			var fecha_out = $('.fechas_mobile .endDate');
			fecha_out.val(s1);
		}
	});

	$('#fechas_busquedas, .fechas_mobile .startDate, .fechas_mobile .endDate').data('dateRangePicker').setDateRange($(this).find('.startDate').val(), $(this).find('.endDate').val());

});

function verificarEnvioFormBuscaresktop() {
	var form = $('[name=frmBuscar]');
	// console.log(form.attr("id"));
	var startDateValue = form.find('.startDate').val();
	var endDateValue = form.find('.endDate').val();

	var direccion = form.find('.direccion').val();
	// console.log("direccion "+direccion);
	var latitud = form.find('#latitud').val();
	// console.log("latitud "+latitud);
	var longitud = form.find('#longitud').val();
	// console.log("longitud "+longitud);
	if (latitud != "" && latitud !== undefined && startDateValue != "" && endDateValue != "" && endDateValue > startDateValue) {
		// console.log("envio");
		form.submit();
	}
}


function dmyToDate(dateStr) {
	var parts = dateStr.split("-");
	return new Date(parts[2], parts[1] - 1, parts[0]);
}

$('document').ready(function() {
	inicializarValidacionesGenerales();
});

function inicializarValidacionesGenerales() {
	$('[maxlength]').on("keydown", function(event) {
		var length = $(this).val() ? ($(this).val()).length : 0;
		var maxlength = $(this).attr('maxlength');
		if (length >= maxlength && event.key != 'Backspace' && event.key != 'Delete') {
			return false;
		}
	});
	$('.minusculas').on("keyup", function(event) {
		this.value = this.value.toLowerCase();
	});
	$('[type=number][min][max]').on("keyup", function(event) {
		// console.clear();
		// console.log('campo con max y min');
		var min = $(this).attr('min') ? parseInt($(this).attr('min')) : 0;
		var max = $(this).attr('max') ? parseInt($(this).attr('max')) : 1;
		var value = $(this).val() ? parseInt($(this).val()) : 0;

		// console.log('min: '+min);
		// console.log('max: '+max);
		// console.log('value: '+value);

		if (value < min || value > max) {
			// console.log('previno');
			var new_value = $(this).val();
			if (value < min) new_value = "";
			else {
				// console.log('else');
				while (parseInt(new_value) > max) {
					// console.log('while');
					new_value = new_value.substring(0, new_value.length - 1);
				}
			}
			$(this).val(new_value);
			// return false;
		}
	});
}

function imageResponsive() {
	$.each(document.querySelectorAll('.img_container img'), function(index, val) {
		if (val.width < val.height) {
			val.addClass('portrait')
		}
	});
}

/*----------------------------------------------------------------------------------*/
/*--------------------------- Google Analitics -------------------------------------*/
(function(i, s, o, g, r, a, m) {
	i['GoogleAnalyticsObject'] = r;
	i[r] = i[r] || function() {
		(i[r].q = i[r].q || []).push(arguments)
	}, i[r].l = 1 * new Date();
	a = s.createElement(o),
		m = s.getElementsByTagName(o)[0];
	a.async = 1;
	a.src = g;
	m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-105825789-1', 'auto');
ga('send', 'pageview');

/*----------------------------------------------------------------------------------*/