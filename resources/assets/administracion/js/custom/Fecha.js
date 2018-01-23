var Fecha = (function () {

	//private methods
	var selector = (function () {
		return {
			start:function(selector)
			{
        $(selector).each(function(){

      		$(this).datepicker
      		({
      			dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      			monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
      			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      			changeMonth: true,
      			changeYear: true,
      			// yearRange: "1900:+1",
      			dateFormat: "dd/mm/yy"
      		});

      		$(this).on("keydown keyup",function(){
      			$(this).blur();
      		});

      	});
			}
		}
	}());


	//public methods
	return {
		selector:selector
	}
}());
