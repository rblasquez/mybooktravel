var CuponDescuento = (function () {

	//private methods

	var index = (function () {
		return {
			start:function(selector)
			{

			}
		}
	}());

	var createAndEdit = (function () {
		return {
			start:function(selector)
			{
				$( document ).ready(function() {

					$('#n_modo_aplicacion_descuento_id').on('change',function(){
						if($(this).val() == 1)//monto fijo
						{
							$("#valor").attr('min',0).attr('max',100000).val('');
							// $("#moneda").prop("disabled",false);
						}
						if($(this).val() == 2)//porcentaje
						{
							$("#valor").attr('min',0).attr('max',30).val('');
							// $("#moneda").prop("disabled",true);
						}
						Validador.general.start();
					});
					$('#n_modo_aplicacion_descuento_id').change();

					//mostrar mapa por defecto
					var marker = {lat: -32.93135107884853, lng: -71.53950505041502};
					mostrarMapaConRectangulo(marker);

					//inicio mapa
					JMap.search.autocomplete({
			      input_selector:'.buscador_rectangulo',
			      onPlaceChanged:function(place){

			        var lat = place.geometry.location.lat();
			        var lng = place.geometry.location.lng();
			        var marker = {lat: lat, lng: lng};

			        mostrarMapaConRectangulo(marker);

			      }
			    });


			    function mostrarMapaConRectangulo(marker)
			    {

			      var markers = [marker];

			      var map = JMap.draw.markers({
			        map_selector:'.mapa_con_rectangulo',
			        markers:markers,
							onMapDrawed:function(markers){
								// console.log(markers[0]);

								var lat = markers[0].lat;
								var lng = markers[0].lng;
								var marker = {lat: lat, lng: lng};
								var bounds = JMap.helper.getBoundsFromMarker({marker:marker,size:.0009});

								$("[name='lat']").val(lat);
								$("[name='lng']").val(lng);

								JMap.draw.rectangle({
									map:map,
									bounds:bounds,
									onBoundsChanged:function(limits,corners,rectangle)
									{
										// console.log(limits);

										for(var key in limits)
										{
											// console.log(key);
											// console.log(limits[key]);
											$("[name='"+key+"']").val(limits[key]);
										}

									}
								});

							}
			      });


			    }
					//fin mapa


				});
			}
		}
	}());

	var show = (function () {
		return {
			start:function(model)
			{
				$( document ).ready(function() {

					var marker = {lat: parseFloat(model.lat),lng: parseFloat(model.lng)};
					console.log(marker);

					var bounds = {
						north: parseFloat(model.lat_max),
						south: parseFloat(model.lat_min),
						east: parseFloat(model.lng_max),
						west: parseFloat(model.lng_min)
					};

					var markers = [marker];

					var map = JMap.draw.markers({
						map_selector:'.mapa_con_rectangulo',
						markers:markers,
						onMapDrawed:function(markers){

							JMap.draw.rectangle({
								map:map,
								bounds:bounds,
								editable:false,
								draggable:false,
								onBoundsChanged:function(limits,corners,rectangle)
								{

									map.setZoom(10);// This will trigger a zoom_changed on the map

								}
							});


						}
					});


				});
			}
		}
	}());

	//public methods
	return {
		index:index,
		createAndEdit:createAndEdit,
		show:show
	}

}());
