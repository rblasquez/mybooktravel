const pickerOptions = {
	format: 'DD-MM-YYYY',
	language: 'es',
	startOfWeek: 'monday',
	startDate: moment(),
	autoClose: true,
	singleDate: true,
	showShortcuts: false,
	singleMonth: true,
	showTopbar: false,
	inline: true,
	container: '',
	alwaysOpen: true,
	beforeShowDay: function(t) {
		let curr_date = moment(t).format().substring(0, 10);
		let valid = !(reservas.indexOf(curr_date) > -1);
		let _class = valid ? '' : 'strikethrough';
		let _tooltip = valid ? '' : 'Día ocupado';
		return [valid, _class, _tooltip];
	}
}

const gallery = $('.galeria a.propertyGalery');

gallery.simpleLightbox({
	closeBtnCaption: 'Cerrar',
	nextBtnCaption: 'Siguiente',
	prevBtnCaption: 'Anterior',
	loadingCaption: 'Cargando...',

	urlAttribute: 'href',
});

const $items = gallery;

$items.on('click', function(e) {
	resourceLoader.makeSureIsLoaded('$.SimpleLightbox', function() {
		$.SimpleLightbox.open({
			$items: $items,
			startAt: $items.index($(e.target)),
			bindToItems: false
		});
	});
});

calcular();


function init() {

	$('.btn-checkin, .btn-checkout, .btn-codigo-promocional').off('click');
	$('.date').unmask();
	$('#codigo_promocional').mask('AAAA-AAAA-AAAA-AAAA-AAAA', {
		translation: {
			'A': {
				pattern: /[a-zA-Z0-9]/
			},
		},
		placeholder: "Codigo promocional",
		onKeyPress: function(cep, event, currentField, options) {
			//this.value=this.value.toUpperCase()
		},
		onComplete: function(cp) {
			codigo_promocional = cp;
			calcular();
			changeUrlParam();
		},
	});

	$('.priceBox .huespedes #total_adultos').on('change', function(event) {
		event.preventDefault();
		changeUrlParam()
	});


	$('.btn-checkin').on('click', function(event) {
		$('#checkInContainer').collapse('toggle');
	});

	$('.btn-checkout').on('click', function(event) {
		$('#checkOutContainer').collapse('toggle');
	});

	$('#checkInContainer').on('show.bs.collapse', function() {
		$('#checkOutContainer').collapse('hide');
	});

	$('#checkOutContainer').on('show.bs.collapse', function() {
		$('#checkInContainer').collapse('hide');
	});

	pickerOptions.container = '.checkInSelect';
	$('.btn-checkin').dateRangePicker(pickerOptions)
		.bind('datepicker-change', function(event, obj) {

			let date = moment(obj.value, "DD-MM-YYYY").add(dias_minimos, 'days').format('DD-MM-YYYY');
			let elemento = $('.btn-checkout')

			elemento.data('dateRangePicker').destroy();
			pickerOptions.container = '.checkOutSelect';
			pickerOptions.startDate = date;
			elemento.dateRangePicker(pickerOptions);

			elemento.data('dateRangePicker').setStart(date);

			$('.btn-checkin').html(obj.value)
			$('#fechas_reservas #fecha_ini').val(obj.value)
			$('#checkInContainer').collapse('toggle')
			checkin_default = obj.value;
			$('#checkInContainer').on('hidden.bs.collapse', function() {
				$('#checkOutContainer').collapse('show');
			});
		});

	pickerOptions.container = '.checkOutSelect';
	$('.btn-checkout').dateRangePicker(pickerOptions)
		.bind('datepicker-change', function(event, obj) {
			$('.btn-checkout').html(obj.value)
			$('#fechas_reservas #fecha_fin').val(obj.value)
			$('#checkOutContainer').collapse('hide')


			checkout_default = obj.value;
			if ($('#fechas_reservas .form-control#checkin').val() != '') {
				$.when(calcular()).then(
					changeUrlParam()
				);
			}
		});

	$('.valorXnoche, .priceBox').unblock();
}

function changeUrlParam() {
	let url = $('.urlPropiedad').attr('href');
	url += '?fecha_entrada=' + $('#fechas_reservas #fecha_ini').val();
	url += '&fecha_salida=' + $('#fechas_reservas #fecha_fin').val();
	url += '&total_adultos=' + $('.priceBox .huespedes #total_adultos').val();

	//url += '&codigo_promocional=' + $('.priceBox .huespedes #codigo_promocional').val();
	// url += '&total_ninos=0';

	window.history.replaceState('', '', url);
}

async function calcular() {
	block('.valorXnoche, .priceBox');
	let ruta;
	let serialize = {
		fecha_ini: checkin_default,
		fecha_fin: checkout_default,
		total_adultos: adultos_default,
		codigo_promocional: codigo_promocional,
		_token: token
	}


	if ($('.ruta_fechas').length > 0) {
		ruta = $('.ruta_fechas').prop('href');
		const ajaxValor = $.ajax({
			url: ruta,
			type: 'GET',
			dataType: 'html',
			data: serialize,
		});

		$.when(ajaxValor).done(function(data) {
			$.when($('#reser').html(data)).then(init());
		})

		$.when(ajaxValor).fail(function() {
			swal({
				title: "Disculpa",
				text: "Lo sentimos, ha ocurrido un error, intente nuevamente",
				icon: "warning",
			}).then((value) => {
				init()
			})
		})
	}
}