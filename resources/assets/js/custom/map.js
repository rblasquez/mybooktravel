
var styles = [
{
    "featureType": "landscape",
    "stylers": [
    { "saturation": 45 },
    { "lightness": 40 }
    ]
},
{
    "featureType": "poi",
    "stylers": [
    { "hue": "#00FF6A" },
    { "saturation": -10.098901098901123 },
    { "lightness": -11.200000000000017 },
    { "gamma": 1 }
    ]
},
{
    "featureType": "poi.business",
    "elementType": "geometry.fill",
    "stylers": [
    { "color": "#06b257" }
    ]
},
{
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
    { "color": "#02ce68" }
    ]
},
{
    "featureType": "poi.park",
    "elementType": "geometry.stroke",
    "stylers": [
    { "color": "#02ce68" }
    ]
},
{
    "featureType": "road.arterial",
    "stylers": [
    { "hue": "#FF0300" },
    { "saturation": -100 },
    { "lightness": 51.19999999999999 },
    { "gamma": 1 }
    ]
},
{
    "featureType": "road.highway",
    "stylers": [
    { "hue": "#FFC200" },
    { "saturation": -61.8 },
    { "lightness": 45.599999999999994 },
    { "gamma": 1 }
    ]
},
{
    "featureType": "road.local",
    "stylers": [
    { "hue": "#FF0300" },
    { "saturation": -100 },
    { "lightness": 52 },
    { "gamma": 1 }
    ]
},
{
    "featureType": "water",
    "stylers": [
    { "color": "#0ec8db" },
    { "hue": "#0ec8db" },
    { "saturation": 15 },
    { "lightness": -5 },
    { "visibility": "simplified" }
    ]
}
];

var image = $(".marcadorGoogleMap").attr("href");

var mapOptions = {
    zoom: 15,
    center: new google.maps.LatLng(-33.8688, 151.2195),
    mapTypeId: google.maps.MapTypeId.ROADMAP,

    mapTypeControl: false,
    mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    panControl: false,
    panControlOptions: {
        position: google.maps.ControlPosition.TOP_RIGHT
    },
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE,
        position: google.maps.ControlPosition.TOP_LEFT
    },
    scrollwheel: false,
    scaleControl: false,
    scaleControlOptions: {
        position: google.maps.ControlPosition.TOP_LEFT
    },
    streetViewControl: true,
    streetViewControlOptions: {
        position: google.maps.ControlPosition.LEFT_TOP
    },
    styles: []
};

var componentForm = {
	locality: 'long_name',
	administrative_area_level_1: 'short_name',
	administrative_area_level_2: 'short_name',
	country: 'short_name',
};
var campos = {
	locality: 'localidad',
	administrative_area_level_1: 'provincia',
	administrative_area_level_2: 'distrito',
	country: 'pais'
};

//con la api autocomplete y si no halla nada aplica geocoding-simple a la cadena
function inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(container, callback = "", places_type = "geocode")
{
	var input = document.querySelector(container+" .direccion");
	var autocomplete = new google.maps.places.Autocomplete(input,{types:[ places_type ]});

	autocomplete.addListener('place_changed', function() {

		vaciarCamposDireccion(container);

		var place = autocomplete.getPlace();
		console.log(place);

		if (!place.geometry )
		{
			console.log("Autocomplete no hallo detalles disponibles para: '" + place.name + "'");
			console.log("Se procede a buscar con la api geocoding-simple");
			inicializar_autocompletar_direccion_google_simple_geocoding(container, callback );
		}
		else
		{
			rellenarCamposDireccion(container, place, componentForm, campos, callback);
		}

	});

}

//con la api de geocoding-simple
function inicializar_autocompletar_direccion_google_simple_geocoding(container, callback = "")
{
	var geocoder = new google.maps.Geocoder();

	var input = document.querySelector(container+" .direccion");
	var address = input.value;
	// console.log(address);

	geocoder.geocode({'address': address}, function(results, status) {
		if (status === 'OK')
		{
			// console.log(results);
			var place = results[0];
			rellenarCamposDireccion(container, place, componentForm, campos, callback);
		}
		else
		{
			console.log('Geocode was not successful for the following reason: ' + status);
			input.value = '';
			vaciarCamposDireccion(container);
		}
	});
}

function vaciarCamposDireccion(container)
{
	var elementos = document.querySelectorAll(container+" .campos_adicionales_direccion");
	// console.log(elementos);
	for(var i=0; i<elementos.length; i++)
	{
		elementos[i].value = '';
	}

}

function rellenarCamposDireccion(container, place, componentForm, campos, callback)
{
	var latitud = document.querySelector(container+' #latitud');
	var longitud = document.querySelector(container+' #longitud');
	var tipo = document.querySelector(container+' #tipo');

	latitud.value = place.geometry.location.lat();
	longitud.value = place.geometry.location.lng();
	tipo.value = place.types;

	for (var i = 0; i < place.address_components.length; i++)
	{
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType])
		{
			var val = place.address_components[i][componentForm[addressType]];
			document.querySelector(container+" #"+campos[addressType]).value = val;
		}
	}

	if (callback != "")
	{
		$.when(latitud.value != "" && longitud.value).then(function( x ) {
			eval(callback);
		});

	}
}

google.maps.event.addDomListener(window, 'load', function(){

	//inicializa buscador desktop
	var desktop = "#contenedor_buscador_google_principal";
	inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(desktop, "enviarFormularioBuscador()", "(regions)");
	//inicializa buscador mobile
	var mobile = "#contenedor_buscador_google_principal_mobile";
	inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(mobile, "/*document.frmBuscarMobile.submit();*/", "(regions)");

	$(desktop+", "+mobile).each(function(){
		var actual = this;
		var id_buscador  = $(actual).attr('id');
		var input  = $(actual).find('.direccion');
		var latitud  = $(actual).find('.latitud').val();
		var longitud  = $(actual).find('.longitud').val();

		$(input).on("focus", function(){
			//on focus, se vacian los campos derivados de la busqueda
			vaciarCamposDireccion("#"+id_buscador);
		});

    /*
    $(input).on("keyup keypress keydown",function(e) {
			if(e.which == 13) {
				e.preventDefault();
				var id_contenedor = $(this).parents(".contenedor_buscador").attr("id");
        //enviarFormularioBuscador();
				//console.log("User entered Enter key "+id_contenedor);
				//vaciarCamposDireccion("#"+id_contenedor);
				//$(this).trigger("blur");

        //inicializar_autocompletar_direccion_google_simple_geocoding("#"+id_contenedor,"");

			}
		});
    */

		$(input).on("blur", function(){
      //alert("blur");

			setTimeout(function(){

				// si abandona el campo de direccion, tiene algo escrito, pero no ha elegido lugar
				// se ejecuta simple geocoding o se borra el campo para forzar eleccion
				if(latitud == "" || longitud == "" )
				{
					if(input.value != "")
					{
						// console.log(input.value);
						inicializar_autocompletar_direccion_google_simple_geocoding("#"+id_buscador, '');
					}
				}

			}, 250);

		});
	});

});

function verificarEnterBuscador(e)
{
  var key = e.which || e.keyCode || 0;

  if(key == 13)
  {
    //console.log(key);
    e.preventDefault();
    vaciarCamposDireccion("#frmBuscar");
    inicializar_autocompletar_direccion_google_simple_geocoding("#frmBuscar", 'enviarFormularioBuscador()');
    //console.log("intento");
  }
}

function enviarFormularioBuscador()
{

  $.when( $("#frmBuscar .latitud").val() !== "" && $("#frmBuscar .longitud").val() !== "" ).then(function( x ) {
    console.log("intenta: latitud '"+$("#frmBuscar .latitud").val()+"' \n longitud '"+$("#frmBuscar .longitud").val()+"'");
    document.frmBuscar.submit();
  });
/*
  var x = 0;
  var intervalID = setInterval(function () {
    console.log("intenta: latitud '"+$("#frmBuscar .latitud").val()+"' \n longitud '"+$("#frmBuscar .longitud").val()+"'");

    if($("#frmBuscar .latitud").val() !== "" && $("#frmBuscar .longitud").val() !== "")
    {
      console.log("envia: latitud '"+$("#frmBuscar .latitud").val()+"' \n longitud '"+$("#frmBuscar .longitud").val()+"'");
    }

    if (++x === 10) {
      window.clearInterval(intervalID);
      //document.frmBuscar.submit();
    }
  }, 100);

  */

/*
  $.when( $("#frmBuscar .latitud").val() !== "" && $("#frmBuscar .longitud").val() !== "" ).then(function( x ) {


    var x = 0;
    var intervalID = setInterval(function () {

       console.log("latitud '"+document.frmBuscar.latitud.value+"' \n longitud '"+document.frmBuscar.longitud.value+"'");

       if (++x === 3) {
           window.clearInterval(intervalID);
           document.frmBuscar.submit();
       }
    }, 100);



    //
  });
  */

}

function mapaUbicacionPropiedad(marcadores, ubicacion, div)
{

	var map = new google.maps.Map(document.getElementById(div), mapOptions);
	var bounds = new google.maps.LatLngBounds();

	$.each(marcadores, function(index, val) {
		var marker = new google.maps.Marker({
			position: {lat: val.location_latitude, lng: val.location_longitude},
			map: map,
			anchorPoint: new google.maps.Point(0, -29),
			animation: google.maps.Animation.DROP,
		});
		bounds.extend(marker.getPosition());
	});

	map.fitBounds(bounds);
	//map.panToBounds(bounds);
	//map.setCenter(ubicacion);

	//solo debe reajustar el zoom cuando hay 1 marcador
	if(marcadores.length == 1)
	{
		//se agrega un listener para cuando el mapa ya esté ocioso
		//porque si se agrega antes de cargar no toma el zoom
		google.maps.event.addListenerOnce(map, "idle", function(){
			map.setOptions({
				zoom: 15
			});
		});
	}

}

function showSingleMarkerMap(selector)
{
	var map = $(selector);
	var id = map.attr('id');
	var latitud = parseFloat(map.attr('latitud'));
	var longitud = parseFloat(map.attr('longitud'));
	var markers = [{
		name: '',
		location_latitude: latitud,
		location_longitude: longitud,
	}];
	var location = { lat : latitud, lng : longitud };

	mapaUbicacionPropiedad(markers, location, id);
}

function mapaPropiedadCrear() {
	var placeSearch, autocomplete;
	var componentForm = {
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		administrative_area_level_2: 'short_name',
		country: 'short_name',
	};

	var campos = {
		locality: 'localidad',
		administrative_area_level_1: 'provincia',
		administrative_area_level_2: 'distrito',
		country: 'pais'
	};
	var map = new google.maps.Map(document.getElementById('resultadoMapa'), mapOptions);

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};

			map.setCenter(pos);
			marker = new google.maps.Marker({
				position: pos,
				map: map,
				animation: google.maps.Animation.DROP,
				draggable:true,
			});
		}, function() {
			handleLocationError(true, infoWindow, map.getCenter());
		});
	} else {
		handleLocationError(false, infoWindow, map.getCenter());
	}

	var input = (document.getElementById('direccion'));

	input.addEventListener("focus", function(){
		//cuando ingresen al campo borra los campos adicionales de direccion
		vaciarCamposDireccion('#frmStore');
	}, true);

	input.addEventListener("blur", function(){

		setTimeout(function(){

			// si abandona el campo de direccion, tiene algo escrito, pero no ha elegido lugar
			// se ejecuta simple geocoding o se borra el campo para forzar eleccion
			if($('#frmStore').find('#longitud').val() == "" || $('#frmStore').find('#latitud').val() == "" )
			{
				if(input.value != "")
				{
					var callback = "$('#resultadoMapa').attr('latitud',place.geometry.location.lat());";
					callback += "$('#resultadoMapa').attr('longitud',place.geometry.location.lng());";
					callback += "showSingleMarkerMap('#resultadoMapa');";
					inicializar_autocompletar_direccion_google_simple_geocoding('#frmStore', callback);
				}
			}

		}, 250);

	}, true);

	// input.addEventListener("keydown", function(e){
		// if (e.keyCode == 13)
		// {
			// e.preventDefault();
			// console.log("hicieron enter");
			// return false;
		// }
	// }, true);

	var autocomplete = new google.maps.places.Autocomplete(input,{types:[ "geocode" ]});
	autocomplete.bindTo('bounds', map);

	var infowindow = new google.maps.InfoWindow();
	var marker = new google.maps.Marker({
		map: map,
		anchorPoint: new google.maps.Point(0, -29),
		animation: google.maps.Animation.DROP,
		draggable:true,
	});

	autocomplete.addListener('place_changed', function() {
		infowindow.close();
		marker.setVisible(true);
		var place = autocomplete.getPlace();
		if (!place.place_id)
		{
			return false;
		}

		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(13);
		}

		marker.setPosition(place.geometry.location);
		marker.setVisible(true);


		infowindow.setContent('<div><strong>' + place.name + '</strong>');
		infowindow.open(map, marker);

		var place = autocomplete.getPlace();

		$.each(campos, function(index, val) {
			document.getElementById(val).value = '';
		});

		$('#frmStore').find('#longitud').val(place.geometry.location.lng());
		$('#frmStore').find('#latitud').val(place.geometry.location.lat());
		//document.getElementById('longitud').value = place.geometry.location.lng()
		//document.getElementById('latitud').value = place.geometry.location.lat()

		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				//document.getElementById(campos[addressType]).value = val;

				$('#frmStore').find('#' + campos[addressType]).val(val)
				if (campos[addressType] == 'pais') {
					showCallback(val)
				}
			}
		}

	});
}


function showCallback(pais){

	$.ajax({
		url: ruta_paises_info.replace(':ID', pais),
		dataType: 'json',
	})
	.done(function(data) {
		$('#telefono_anfitrion').val('')
		$('#telefono_anfitrion').unmask()


		$('#telefono_anfitrion').mask('('+data.prefijo_telefono+') 00000000000', {
			placeholder: '('+data.prefijo_telefono+') '
		});


		$('.moneda_iso').html(data.moneda)
	})
	.fail(function(data) {
		console.log("error");
	})
}

function obtenerLimitesMaxMin(north_east_corner,south_west_corner)
{

  var min_lat = south_west_corner[0];
  var max_lat = north_east_corner[0];
  var min_lng = south_west_corner[1];
  var max_lng = north_east_corner[1];

  var url = ""
  url += "&min_lat="+min_lat;
  url += "&max_lat="+max_lat;
  url += "&min_lng="+min_lng;
  url += "&max_lng="+max_lng;

  var bounds = {min_lat: min_lat, max_lat :max_lat,min_lng :min_lng, max_lng: max_lng};

  return {url:url,bounds:bounds};

}
