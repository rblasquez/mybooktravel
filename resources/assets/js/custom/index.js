$('.localidad').on('click', function(event) {
	event.preventDefault();

	var address = $(this).attr('href'),
	geocoder = new google.maps.Geocoder();

	geocoder.geocode({'address': address}, function(results, status) {
		if (status === 'OK') {
			var result = results[0].geometry.location;
			$('.direccion').val(address)
			var campos_busqueda = $('campos_adicionales_ubicacion')
			$('.pais').val('CL')
			$('.tipo').val('natural_feature')
			$('.latitud').val(result.lat())
			$('.longitud').val(result.lng())

			var limites = null;
			if(address == 'La Serena')
			{
			  limites = obtenerLimitesMaxMin([-29.84454433631571, -71.17005078125021],[-29.953317192714483, -71.31837255859386]);
			}
			if(address == 'Viña del Mar')
			{
			  limites = obtenerLimitesMaxMin([-32.945329481700966, -71.46942822265635],[-33.058331446357684, -71.58822424316406]);
			}
			if(address == 'Concón')
			{
			  limites = obtenerLimitesMaxMin([-32.91276672197713, -71.49449078369162],[-32.95180175810558, -71.56213171386736]);
			}
			if(address == 'Pucón')
			{
			  limites = obtenerLimitesMaxMin([-39.266709083560656, -71.91746441650412],[-39.29925317022208, -71.99471838378906]);
			}
			if(address == 'Maitencillo')
			{
			  limites = obtenerLimitesMaxMin([-32.56883348591596, -71.36059490966773],[-32.6976288923101, -71.52642614746117]);
			}
			if(address == 'Reñaca')
			{
			  limites = obtenerLimitesMaxMin([-32.94619381640774, -71.50067059326148],[-32.99817237882023, -71.58273107910173]);
			}
			if(address == 'Santiago')
			{			
			  limites = obtenerLimitesMaxMin([-33.26541672999623, -70.39208142089859],[-33.678800654877755, -70.93659765625006]);
			}
			if(address == 'Coquimbo')
			{
			  limites = obtenerLimitesMaxMin([-29.92074968988513, -71.23253552246103],[-30.044300094321216, -71.4035166015625]);
			}

			if(limites != null)
			{
				$.each( limites.bounds , function(key, value){
		      $('.'+key, '#frmBuscar' ).val(value);
		    });
			}

			$('#frmBuscar').submit();

		} else {
			alert('Geocode was not successful for the following reason: ' + status);
		}
	});
});


$(function() {
	google.maps.event.addDomListener(window, 'load', function(){
		getGeo();
	});

	$('.parallax').parallaxBackground({
		parallaxBgImage: 'img/slider/slider4.jpg',
		parallaxBgSize: 'cover',
		parallaxSpeed: 12,
		parallaxDirection: 'down',
	});

	$('.sliding').slick({
		accessibility: true,
		lazyLoad: 'ondemand',
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: 2500,
		fade: true,
		easing: 'easeInBack',
		pauseOnHover: false,
		cssEase: 'linear',
		arrows: false
	});
});

function getGeo(){
	if (navigator.geolocation) {
		var geocoder = new google.maps.Geocoder();

		navigator.geolocation.getCurrentPosition(function (position) {
			var yourLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			geocoder.geocode({ 'latLng': yourLocation }, processGeocoder);
		}, function (position) {
			var yourLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			geocoder.geocode({ 'latLng': yourLocation }, processGeocoder);
		});
	} else {
		//geoMaxmind();
	}
}

var component = {
	country: 'short_name',
};

var campo = {
	country: ':PAIS'
};

var lat;
var lng;

function processGeocoder(results, status){
	var place = results[0];
	lng = place.geometry.location.lng();
	lat = place.geometry.location.lat();
	if (status == google.maps.GeocoderStatus.OK) {
		if (place) {
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (component[addressType]) {
					var val = place.address_components[i][component[addressType]];
					component[addressType] = val;
				}
			}
			propiedadesCercanas()
		} else {
			error('Google no retorno resultado alguno.');
		}
	} else {
		error("Geocoding fallo debido a : " + status);
	}
}

function propiedadesCercanas() {

	if (typeof url_lugares === 'undefined') {
	}else {
		$.each(component, function(index, val) {
			url_lugares = url_lugares.replace(campo[index], val);
		});

		url_lugares = url_lugares.replace(':LAT', lat).replace(':LNG', lng);

		$.get(url_lugares, function(data) {
			$('.alojamientosCercanos').append(data).ready(function() {
				lazyImages()
			});
		});
	}

}

function error(msg) {
	console.log(msg);
}
