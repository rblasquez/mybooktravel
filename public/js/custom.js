"use strict";function showInputs(){$(".checkAdicionales62").change(function(e){e.preventDefault(),this.checked?$(".anotherMan").slideDown():this.checked&&$(".anotherMan").slideUp()}),$(".anfMbt").change(function(e){e.preventDefault(),this.checked?$(".anfMbt2").slideDown():this.checked&&$(".anfMbt2").slideUp()}),$(".checkAdicionales61, .anfMbt").change(function(e){e.preventDefault(),$(".anotherMan").slideUp()}),$(".checkAdicionales61, .checkAdicionales62").change(function(e){e.preventDefault(),$(".anfMbt2").slideUp()}),$(".checkAdicionales").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput").slideDown():$(".adicionalesInput").slideUp()}),$(".checkAdicionales5").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput5").slideDown():$(".adicionalesInput5").slideUp()}),$(".checkAdicionales6").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput6").slideDown():$(".adicionalesInput6").slideUp()}),$(".checkAdicionales7").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput7").slideDown():$(".adicionalesInput7").slideUp()}),$(".checkAdicionales8").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput8").slideDown():$(".adicionalesInput8").slideUp()}),$(".checkAdicionales9").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput9").slideDown():$(".adicionalesInput9").slideUp()}),$(".checkAdicionales10").change(function(e){e.preventDefault(),this.checked?$(".adicionalesInput10").slideDown():$(".adicionalesInput10").slideUp()}),$(".checkAdicionales11").change(function(e){e.preventDefault(),this.checked?$(".ayudaOferta_1").slideDown():$(".ayudaOferta").hide()}),$(".checkAdicionales11").click(function(){$(".ayudaOferta, .ayudaOferta_2, .ayudaOferta_3").hide()}),$(".checkAdicionales12").change(function(e){e.preventDefault(),this.checked?$(".ayudaOferta_2").slideDown():$(".ayudaOferta").hide()}),$(".checkAdicionales12").click(function(){$(".ayudaOferta, .ayudaOferta_1, .ayudaOferta_3").hide()}),$(".checkAdicionales13").change(function(e){e.preventDefault(),this.checked?$(".ayudaOferta_3").slideDown():$(".ayudaOferta").hide()}),$(".checkAdicionales13").click(function(){$(".ayudaOferta, .ayudaOferta_1, .ayudaOferta_2").hide()}),$(".checkAdicionales56").change(function(e){e.preventDefault(),this.checked?$(".ayudaGarantia_1").slideDown():$(".ayudaGarantia").hide()}),$(".checkAdicionales56").click(function(){$(".ayudaGarantia, .ayudaGarantia_2, .ayudaGarantia_3").hide()}),$(".checkAdicionales57").change(function(e){e.preventDefault(),this.checked?$(".ayudaGarantia_2").slideDown():$(".ayudaGarantia").hide()}),$(".checkAdicionales57").click(function(){$(".ayudaGarantia, .ayudaGarantia_1, .ayudaGarantia_3").hide()}),$(".checkAdicionales58").change(function(e){e.preventDefault(),this.checked?$(".ayudaGarantia_3").slideDown():$(".ayudaGarantia").hide()}),$(".checkAdicionales58").click(function(){$(".ayudaGarantia, .ayudaGarantia_1, .ayudaGarantia_2").hide()}),$(".checkAdicionales59").change(function(e){e.preventDefault(),this.checked?$(".ayudaMetodo_1").slideDown():$(".ayudaMetodo").hide()}),$(".checkAdicionales59").click(function(){$(".ayudaMetodo, .ayudaMetodo_2").hide()}),$(".checkAdicionales60").change(function(e){e.preventDefault(),this.checked?$(".ayudaMetodo_2").slideDown():$(".ayudaMetodo").hide()}),$(".checkAdicionales60").click(function(){$(".ayudaMetodo, .ayudaMetodo_1").hide()}),$("input:checkbox").on("click",function(){var e=$(this);if(e.is(":checked")){var a="input:checkbox[name='"+e.attr("name")+"']";$(a).prop("checked",!1),e.prop("checked",!0)}else e.prop("checked",!1)})}function inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(e){var a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"geocode",t=document.querySelector(e+" .direccion"),n=new google.maps.places.Autocomplete(t,{types:[o]});n.addListener("place_changed",function(){vaciarCamposDireccion(e);var o=n.getPlace();console.log(o),o.geometry?rellenarCamposDireccion(e,o,componentForm,campos,a):(console.log("Autocomplete no hallo detalles disponibles para: '"+o.name+"'"),console.log("Se procede a buscar con la api geocoding-simple"),inicializar_autocompletar_direccion_google_simple_geocoding(e,a))})}function inicializar_autocompletar_direccion_google_simple_geocoding(e){var a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",o=new google.maps.Geocoder,t=document.querySelector(e+" .direccion"),n=t.value;o.geocode({address:n},function(o,n){if("OK"===n){var i=o[0];rellenarCamposDireccion(e,i,componentForm,campos,a)}else console.log("Geocode was not successful for the following reason: "+n),t.value="",vaciarCamposDireccion(e)})}function vaciarCamposDireccion(e){for(var a=document.querySelectorAll(e+" .campos_adicionales_direccion"),o=0;o<a.length;o++)a[o].value=""}function rellenarCamposDireccion(container,place,componentForm,campos,callback){var latitud=document.querySelector(container+" #latitud"),longitud=document.querySelector(container+" #longitud"),tipo=document.querySelector(container+" #tipo");latitud.value=place.geometry.location.lat(),longitud.value=place.geometry.location.lng(),tipo.value=place.types;for(var i=0;i<place.address_components.length;i++){var addressType=place.address_components[i].types[0];if(componentForm[addressType]){var val=place.address_components[i][componentForm[addressType]];document.querySelector(container+" #"+campos[addressType]).value=val}}""!=callback&&$.when(""!=latitud.value&&longitud.value).then(function(x){eval(callback)})}function verificarEnterBuscador(e){13==(e.which||e.keyCode||0)&&(e.preventDefault(),vaciarCamposDireccion("#frmBuscar"),inicializar_autocompletar_direccion_google_simple_geocoding("#frmBuscar","enviarFormularioBuscador()"))}function enviarFormularioBuscador(){$.when(""!==$("#frmBuscar .latitud").val()&&""!==$("#frmBuscar .longitud").val()).then(function(e){console.log("intenta: latitud '"+$("#frmBuscar .latitud").val()+"' \n longitud '"+$("#frmBuscar .longitud").val()+"'"),document.frmBuscar.submit()})}function mapaUbicacionPropiedad(e,a,o){var t=new google.maps.Map(document.getElementById(o),mapOptions),n=new google.maps.LatLngBounds;$.each(e,function(e,a){var o=new google.maps.Marker({position:{lat:a.location_latitude,lng:a.location_longitude},map:t,anchorPoint:new google.maps.Point(0,-29),animation:google.maps.Animation.DROP});n.extend(o.getPosition())}),t.fitBounds(n),1==e.length&&google.maps.event.addListenerOnce(t,"idle",function(){t.setOptions({zoom:15})})}function showSingleMarkerMap(e){var a=$(e),o=a.attr("id"),t=parseFloat(a.attr("latitud")),n=parseFloat(a.attr("longitud"));mapaUbicacionPropiedad([{name:"",location_latitude:t,location_longitude:n}],{lat:t,lng:n},o)}function mapaPropiedadCrear(){var e,a={locality:"long_name",administrative_area_level_1:"short_name",administrative_area_level_2:"short_name",country:"short_name"},o={locality:"localidad",administrative_area_level_1:"provincia",administrative_area_level_2:"distrito",country:"pais"},t=new google.maps.Map(document.getElementById("resultadoMapa"),mapOptions);navigator.geolocation?navigator.geolocation.getCurrentPosition(function(e){var a={lat:e.coords.latitude,lng:e.coords.longitude};t.setCenter(a),c=new google.maps.Marker({position:a,map:t,animation:google.maps.Animation.DROP,draggable:!0})},function(){handleLocationError(!0,infoWindow,t.getCenter())}):handleLocationError(!1,infoWindow,t.getCenter());var n=document.getElementById("direccion");n.addEventListener("focus",function(){vaciarCamposDireccion("#frmStore")},!0),n.addEventListener("blur",function(){setTimeout(function(){if((""==$("#frmStore").find("#longitud").val()||""==$("#frmStore").find("#latitud").val())&&""!=n.value){var e="$('#resultadoMapa').attr('latitud',place.geometry.location.lat());";e+="$('#resultadoMapa').attr('longitud',place.geometry.location.lng());",e+="showSingleMarkerMap('#resultadoMapa');",inicializar_autocompletar_direccion_google_simple_geocoding("#frmStore",e)}},250)},!0);var e=new google.maps.places.Autocomplete(n,{types:["geocode"]});e.bindTo("bounds",t);var i=new google.maps.InfoWindow,c=new google.maps.Marker({map:t,anchorPoint:new google.maps.Point(0,-29),animation:google.maps.Animation.DROP,draggable:!0});e.addListener("place_changed",function(){i.close(),c.setVisible(!0);var n=e.getPlace();if(!n.place_id)return!1;n.geometry.viewport?t.fitBounds(n.geometry.viewport):(t.setCenter(n.geometry.location),t.setZoom(13)),c.setPosition(n.geometry.location),c.setVisible(!0),i.setContent("<div><strong>"+n.name+"</strong>"),i.open(t,c);var n=e.getPlace();$.each(o,function(e,a){document.getElementById(a).value=""}),$("#frmStore").find("#longitud").val(n.geometry.location.lng()),$("#frmStore").find("#latitud").val(n.geometry.location.lat());for(var l=0;l<n.address_components.length;l++){var r=n.address_components[l].types[0];if(a[r]){var s=n.address_components[l][a[r]];$("#frmStore").find("#"+o[r]).val(s),"pais"==o[r]&&showCallback(s)}}})}function showCallback(e){$.ajax({url:ruta_paises_info.replace(":ID",e),dataType:"json"}).done(function(e){$("#telefono_anfitrion").val(""),$("#telefono_anfitrion").unmask(),$("#telefono_anfitrion").mask("("+e.prefijo_telefono+") 00000000000",{placeholder:"("+e.prefijo_telefono+") "}),$(".moneda_iso").html(e.moneda)}).fail(function(e){console.log("error")})}function obtenerLimitesMaxMin(e,a){var o=a[0],t=e[0],n=a[1],i=e[1],c="";return c+="&min_lat="+o,c+="&max_lat="+t,c+="&min_lng="+n,c+="&max_lng="+i,{url:c,bounds:{min_lat:o,max_lat:t,min_lng:n,max_lng:i}}}function lazyImages(){new Blazy({selector:"img",offset:100,breakpoints:[{width:420,src:"data-src"}],success:function(e){setTimeout(function(){var a=e.parentNode;a.className=a.className.replace(/\bloading\b/,"")},200)}})}function iniciarTooltip(){$(".masterTooltip, .info").hover(function(){var e=$(this).attr("title");$(this).data("tipText",e).removeAttr("title"),$('<p class="tooltipp"></p>').text(e).appendTo("body").fadeIn("slow")},function(){$(this).attr("title",$(this).data("tipText")),$(".tooltipp").remove()}).mousemove(function(e){var a=e.pageX+20,o=e.pageY+10;$(".tooltipp").css({top:o,left:a})})}function block(e){var a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";$(e).block({message:void 0!==a?a:"",baseZ:5,overlayCSS:{backgroundColor:"#fff",opacity:.8,cursor:"wait"},css:{width:100,"-webkit-border-radius":10,"-moz-border-radius":10,border:0,padding:0,backgroundColor:"transparent"}})}function verificarEnvioFormBuscaresktop(){var e=$("[name=frmBuscar]"),a=e.find(".startDate").val(),o=e.find(".endDate").val(),t=(e.find(".direccion").val(),e.find("#latitud").val());e.find("#longitud").val();""!=t&&void 0!==t&&""!=a&&""!=o&&o>a&&e.submit()}function dmyToDate(e){var a=e.split("-");return new Date(a[2],a[1]-1,a[0])}function inicializarValidacionesGenerales(){$("[maxlength]").on("keydown",function(e){if(($(this).val()?$(this).val().length:0)>=$(this).attr("maxlength")&&"Backspace"!=e.key&&"Delete"!=e.key)return!1}),$(".minusculas").on("keyup",function(e){this.value=this.value.toLowerCase()}),$("[type=number][min][max]").on("keyup",function(e){var a=$(this).attr("min")?parseInt($(this).attr("min")):0,o=$(this).attr("max")?parseInt($(this).attr("max")):1,t=$(this).val()?parseInt($(this).val()):0;if(t<a||t>o){var n=$(this).val();if(t<a)n="";else for(;parseInt(n)>o;)n=n.substring(0,n.length-1);$(this).val(n)}})}function imageResponsive(){$.each(document.querySelectorAll(".img_container img"),function(e,a){a.width<a.height&&a.addClass("portrait")})}$(".dropdown").on("show.bs.dropdown",function(){$(this).find(".dropdown-menu").first().stop(!0,!0).slideDown("fast")}),$(".dropdown").on("hide.bs.dropdown",function(){$(this).find(".dropdown-menu").first().stop(!0,!0).slideUp("fast")}),$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip()}),$(".carousel").carousel({interval:3500}),$(".button_inc").on("click",function(){var e=$(this),a=e.parent().find("input").val();if("+"==e.text())var o=parseFloat(a)+1;else if(a>1)var o=parseFloat(a)-1;else o=0;e.parent().find("input").val(o)}),$(document).scroll(function(){var e=$(this).scrollTop();e>5&&e<900?$(".resersBtn").slideDown():$(".resersBtn").slideUp()}),$(".resersBtn").click(function(e){e.stopPropagation(),$("#reser").css("paddingTop","120px")}),$(".verMapa").click(function(){$(this).fadeOut("fast"),$(".cerrarMapa").delay(300).fadeIn("fast"),$(".elMapa").delay(300).slideDown("fast")}),$(".cerrarMapa").click(function(){$(this).fadeOut("fast"),$(".verMapa").delay(300).fadeIn("fast"),$(".elMapa").delay(300).slideUp("fast")}),$("#fechasBtn").click(function(e){e.stopPropagation(),$(".fechasGroup").slideToggle("fast",function(){})}),$("#closingFechas").click(function(){$(".fechasGroup").slideToggle("fast",function(){})}),$("#huespedBtn").click(function(e){e.stopPropagation(),$(".huespedesGroup").slideToggle("fast",function(){})}),$("#closingHuesped").click(function(){$(".huespedesGroup").slideToggle("fast",function(){})}),$(".fechasGroup, .huespedesGroup, .dropdown-menu").click(function(e){e.stopPropagation()}),$(document).click(function(){$(".fechasGroup, .huespedesGroup, .dropdown-menu").slideUp()}),$("#fechasBtn").click(function(e){e.stopPropagation(),$(".huespedesGroup, .dropdown-menu").slideUp("fast",function(){})}),$("#huespedBtn").click(function(e){e.stopPropagation(),$(".fechasGroup, .dropdown-menu").slideUp("fast",function(){})}),$(".dropdown").click(function(e){$(".fechasGroup, .huespedesGroup").slideUp("fast",function(){})}),$("#searchBtnMobile").click(function(){}),$("#barsMenu").click(function(){$(this).fadeOut(100),$("#closeMenu").delay(100).fadeIn(100),$(".menuEquis").slideDown("fast",function(){})}),$("#closeMenu").click(function(){$(this).fadeOut(100),$("#barsMenu").delay(100).fadeIn(100),$(".menuEquis, .searchEquis").slideUp("fast",function(){})}),$("#closeFilters").click(function(){$(this).fadeOut(100),$("#barsMenu").delay(100).fadeIn(100),$(".menuEquis, .searchEquis, .filteringMobile").slideUp("fast",function(){})}),$("#searchBtnMobile").click(function(){$("#barsMenu, #closeFilters").fadeOut(100),$("#closeMenu").delay(100).fadeIn(100),$(".searchEquis").slideDown("fast"),$(".menuEquis, .filteringMobile").slideUp("fast",function(){})}),$("#filtering").click(function(){$(".filteringMobile").slideDown("fast"),$("#closeFilters").delay(100).fadeIn(100),$("#barsMenu").fadeOut(100)});var styles=[{featureType:"landscape",stylers:[{saturation:45},{lightness:40}]},{featureType:"poi",stylers:[{hue:"#00FF6A"},{saturation:-10.098901098901123},{lightness:-11.200000000000017},{gamma:1}]},{featureType:"poi.business",elementType:"geometry.fill",stylers:[{color:"#06b257"}]},{featureType:"poi.park",elementType:"geometry.fill",stylers:[{color:"#02ce68"}]},{featureType:"poi.park",elementType:"geometry.stroke",stylers:[{color:"#02ce68"}]},{featureType:"road.arterial",stylers:[{hue:"#FF0300"},{saturation:-100},{lightness:51.19999999999999},{gamma:1}]},{featureType:"road.highway",stylers:[{hue:"#FFC200"},{saturation:-61.8},{lightness:45.599999999999994},{gamma:1}]},{featureType:"road.local",stylers:[{hue:"#FF0300"},{saturation:-100},{lightness:52},{gamma:1}]},{featureType:"water",stylers:[{color:"#0ec8db"},{hue:"#0ec8db"},{saturation:15},{lightness:-5},{visibility:"simplified"}]}],image=$(".marcadorGoogleMap").attr("href"),mapOptions={zoom:15,center:new google.maps.LatLng(-33.8688,151.2195),mapTypeId:google.maps.MapTypeId.ROADMAP,mapTypeControl:!1,mapTypeControlOptions:{style:google.maps.MapTypeControlStyle.DROPDOWN_MENU,position:google.maps.ControlPosition.LEFT_CENTER},panControl:!1,panControlOptions:{position:google.maps.ControlPosition.TOP_RIGHT},zoomControl:!0,zoomControlOptions:{style:google.maps.ZoomControlStyle.LARGE,position:google.maps.ControlPosition.TOP_LEFT},scrollwheel:!1,scaleControl:!1,scaleControlOptions:{position:google.maps.ControlPosition.TOP_LEFT},streetViewControl:!0,streetViewControlOptions:{position:google.maps.ControlPosition.LEFT_TOP},styles:[]},componentForm={locality:"long_name",administrative_area_level_1:"short_name",administrative_area_level_2:"short_name",country:"short_name"},campos={locality:"localidad",administrative_area_level_1:"provincia",administrative_area_level_2:"distrito",country:"pais"};google.maps.event.addDomListener(window,"load",function(){var e="#contenedor_buscador_google_principal";inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(e,"enviarFormularioBuscador()","(regions)");var a="#contenedor_buscador_google_principal_mobile";inicializar_autocompletar_direccion_google_autocomplete_geocoding_simple(a,"/*document.frmBuscarMobile.submit();*/","(regions)"),$(e+", "+a).each(function(){var e=this,a=$(e).attr("id"),o=$(e).find(".direccion"),t=$(e).find(".latitud").val(),n=$(e).find(".longitud").val();$(o).on("focus",function(){vaciarCamposDireccion("#"+a)}),$(o).on("blur",function(){setTimeout(function(){""!=t&&""!=n||""!=o.value&&inicializar_autocompletar_direccion_google_simple_geocoding("#"+a,"")},250)})})}),$(document).ready(function(){lazyImages()}),$('[data-background="image"]').each(function(){var e=$(this),a=e.data("src");if("undefined"!=a){var o={"background-image":"url('"+a+"')","background-position":"center center","background-size":"cover"};e.css(o)}}),$(".card .header img, .card .content img").each(function(){var e=$(this).parent(),a=$(this).attr("src");if("undefined"!=a){var o={"background-image":"url('"+a+"')","background-position":"center center","background-size":"cover"};e.css(o)}}),$("#status").fadeOut(),$("#preloader").delay(350).fadeOut("slow"),$("body").delay(350).css({overflow:"visible"}),$(document).ready(function(){$("#moneda").on("change",function(e){e.preventDefault(),$("#cambioMoneda").submit()}),iniciarTooltip()}),$(document).ready(function(){$("#fechas_busquedas").dateRangePicker({autoClose:!0,format:"DD-MM-YYYY",separator:" a ",language:"es",startOfWeek:"monday",startDate:moment(),endDate:!1,hoveringTooltip:!0,customArrowPrevSymbol:'<i class="fa fa-arrow-circle-left"></i>',customArrowNextSymbol:'<i class="fa fa-arrow-circle-right"></i>',monthSelect:!0,yearSelect:!1,inline:!0,container:"#date-range12-container",alwaysOpen:!0,getValue:function(){var e=$(this).find(".startDate"),a=$(this).find(".endDate");return e.val()&&a.val()?e.val()+" to "+a.val():""},setValue:function(e,a,o){var t=$(this).find(".startDate"),n=$(this).find(".endDate");t.val(a),n.val(o)}}).bind("datepicker-change",function(e,a){verificarEnvioFormBuscaresktop()}),$(".fechas_mobile").find(".startDate").dateRangePicker({format:"DD-MM-YYYY",startDate:moment(),language:"es",startOfWeek:"monday",autoClose:!0,singleDate:!0,showShortcuts:!1,singleMonth:!0,showTopbar:!1,getValue:function(){var e=$(".fechas_mobile .startDate");return e.val()?e.val()+" to "+$(".fechas_mobile .endDate").val():""},setValue:function(e,a,o){$(".fechas_mobile .startDate").val(a)}}).bind("datepicker-change",function(e,a){var o=moment(a.value,"DD-MM-YYYY").add(1,"days").format("DD-MM-YYYY");$(".fechas_mobile .endDate").data("dateRangePicker").setStart(o).open()}),$(".fechas_mobile .endDate").dateRangePicker({format:"DD-MM-YYYY",startDate:moment(),language:"es",startOfWeek:"monday",autoClose:!0,singleDate:!0,showShortcuts:!1,singleMonth:!0,showTopbar:!1,getValue:function(){var e=$(".fechas_mobile .endDate");return e.val()?$(".fechas_mobile .startDate").val()+" to "+e.val():""},setValue:function(e,a,o){$(".fechas_mobile .endDate").val(a)}}),$("#fechas_busquedas, .fechas_mobile .startDate, .fechas_mobile .endDate").data("dateRangePicker").setDateRange($(this).find(".startDate").val(),$(this).find(".endDate").val())}),$("document").ready(function(){inicializarValidacionesGenerales()}),function(e,a,o,t,n,i,c){e.GoogleAnalyticsObject=n,e[n]=e[n]||function(){(e[n].q=e[n].q||[]).push(arguments)},e[n].l=1*new Date,i=a.createElement(o),c=a.getElementsByTagName(o)[0],i.async=1,i.src="https://www.google-analytics.com/analytics.js",c.parentNode.insertBefore(i,c)}(window,document,"script",0,"ga"),ga("create","UA-105825789-1","auto"),ga("send","pageview");