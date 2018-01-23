$("#direccion").on("keydown", function (e) {
	if(e.which == 13) {
		event.preventDefault();
	}
});

console.log(moment().subtract(10, 'days').calendar());
console.log();

$(document).ready(function() {
	$( "#fecha_naci" ).dateRangePicker({
		autoClose: true,
		format: 'DD-MM-YYYY',
		separator: ' a ',
		language: 'es',
		startOfWeek: 'monday',
		endDate: false,
		hoveringTooltip: true,
		customArrowPrevSymbol: '<i class="fa fa-arrow-circle-left"></i>',
		customArrowNextSymbol: '<i class="fa fa-arrow-circle-right"></i>',
		monthSelect: true,
		yearSelect: true,
		singleDate : true,
		showShortcuts: false,
		singleMonth: true
	})

	$( "#fecha_naci" ).data('dateRangePicker').setStart('11-20-01')

	var placeSearch, autocomplete;
	var componentForm = {
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		administrative_area_level_2: 'short_name',
		country: 'short_name',
	};

	var campo = {
		locality: 'localidad',
		administrative_area_level_1: 'provincia',
		administrative_area_level_2: 'distrito',
		country: 'pais'
	};
	var input = (document.getElementById('direccion'));
	var autocomplete = new google.maps.places.Autocomplete(input);

	autocomplete.addListener('place_changed', function() {

		var place = autocomplete.getPlace();

		$.each(campo, function(index, val) {
			document.getElementById(val).value = '';
		});

		document.getElementById('longitud').value = place.geometry.location.lng()
		document.getElementById('latitud').value = place.geometry.location.lat()

		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
			}
		}

	});
});

$('#pais_id').on('change', function(event) {
	console.log($(this).val())
	$.ajax({
		url: ruta_pais.replace(':PAIS', $(this).val()),
		dataType: 'json',
	})
	.done(function(data) {
		$('#telefono').val('')
		$('#telefono').unmask()

		$('#telefono').mask('('+data.prefijo_telefono+') 00000000000', {
			placeholder: '('+data.prefijo_telefono+') '
		});
	})
	.fail(function(data) {
		console.log("error");
	})
	
});