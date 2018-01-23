var JMap = (function () {

	var mapOptions = {
		zoom: 14,
		mapTypeId: 'roadmap'
	};

	//private methods
	var search = (function () {
		return {
			autocomplete:function(parameters)
			{
        var input_selector = parameters["input_selector"];
        var onPlaceChanged = typeof parameters["onPlaceChanged"] != 'undefined' ? parameters["onPlaceChanged"] : null ;

        var input = document.querySelector(input_selector);
				var autocomplete = new google.maps.places.Autocomplete(input,{types:[ "geocode" ]});

        autocomplete.addListener('place_changed', function() {

					var place = autocomplete.getPlace();

					if (!place.geometry )
					{
						console.log("Autocomplete: There is no available details for: '" + place.name + "'");
					}
					else
					{
						if(onPlaceChanged != null)onPlaceChanged(place);
					}

				});

			}
		}
	}());

	var draw = (function () {
		return {
			markers:function(parameters)
			{
        var map_selector = parameters["map_selector"];
				var markers = parameters["markers"];
				var onMapDrawed = typeof parameters["onMapDrawed"] != 'undefined' ? parameters["onMapDrawed"] : null ;

				var map = new google.maps.Map(document.querySelector(map_selector), mapOptions);
				var bounds = new google.maps.LatLngBounds();

				for(var i = 0; i < markers.length ;i++)
				{
					var marker = new google.maps.Marker({
						position: {lat: markers[i].lat, lng: markers[i].lng},
						map: map,
						anchorPoint: new google.maps.Point(0, -29),
						animation: google.maps.Animation.DROP,
					});

					bounds.extend(marker.getPosition());

				}

				map.fitBounds(bounds);

				//fix zoom when there's only one marker
				if(markers.length == 1)
				{
					//add a listener when the map is idle
					//because if it is added before, it wont take the zoom
					google.maps.event.addListenerOnce(map, "idle", function(){
						map.setOptions(mapOptions);
						if(onMapDrawed!=null)onMapDrawed(markers);
					});
				}

				return map;
			},
			rectangle:function(parameters)
			{

				var map = parameters["map"];
				var bounds = parameters["bounds"];
				var size = parameters["size"];
				var editable = typeof parameters["editable"] != 'undefined' ? parameters["editable"] : true;
				var draggable = typeof parameters["draggable"] != 'undefined' ? parameters["draggable"] : true;
				var onBoundsChanged = typeof parameters["onBoundsChanged"] != 'undefined' ? parameters["onBoundsChanged"] : null ;

				// Define the rectangle and set its editable property to true.
				rectangle = new google.maps.Rectangle({
					bounds: bounds,
					editable: editable,
					draggable: draggable
				});

				rectangle.setMap(map);

				if(onBoundsChanged != null)
				{

					// Define an info window on the map.
					infoWindow = new google.maps.InfoWindow();

					rectangle.addListener('bounds_changed', function(){

						var north_east = rectangle.getBounds().getNorthEast();
						var south_west = rectangle.getBounds().getSouthWest();

						var corners = {
							north_east:north_east,
							south_west:south_west
						};

						var limits = {
							lat_max : north_east.lat(),
							lng_max : north_east.lng(),
							lat_min : south_west.lat(),
							lng_min : south_west.lng()
						};

						var contentString = '<b>Details.</b><br>' +
						'North East= lat:' + north_east.lat() + ', lng: ' + north_east.lng() + '<br>' +
						'South West= lat:' + south_west.lat() + ', lng: ' + south_west.lng();

						// Set the info window's content and position.
						infoWindow.setContent(contentString);
						infoWindow.setPosition(north_east);

						infoWindow.open(map);

						onBoundsChanged(limits,corners,this);
					});

					google.maps.event.trigger(rectangle, "bounds_changed");

				}

			}
		}
	}());

	var helper = (function () {
		return {
			getBoundsFromMarker:function(parameters)
			{
				var marker = parameters["marker"];
				var size = parameters["size"];

				var lat = marker['lat'];
				var lng = marker['lng'];

				var bounds = {
					north: lat+size,
					south: lat-size,
					east: lng+size,
					west: lng-size
				};

				return bounds;
			},
			subMetodo:function(result,status)
			{

			}
		}
	}());

	var metodo = (function () {
		return {
			subMetodo:function(result,status)
			{

			}
		}
	}());

	//public methods
	return {
		search:search,
		draw:draw,
		helper:helper,
	}
}());
