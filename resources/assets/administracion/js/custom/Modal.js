var Modal = (function () {

	//private methods
  var wait = function(parametros)
  {
    if(parametros)
    {
      var mensaje = parametros["mensaje"] != '' ? parametros["mensaje"] : 'Mientras se verifica la información.' ;
      swal({
    		title: "Espere",
    		animation: false,
    		text: mensaje,
    		icon: $(".rutaImageLoader").attr("src"),
    		buttons: false,
    		closeOnClickOutside :false
    	});
    }

  }
  var error = function(parametros)
  {
    if(parametros)
    {

      var mensaje = parametros["mensaje"] !=  '' ? parametros["mensaje"] : "Ha ocurrido algo inusual, verifique los datos del formulario. \n Si aún no tiene éxito, intente mas tarde.";
      var callback = typeof parametros["callback"] !== 'undefined' ? parametros["callback"] : null;
      var result = typeof parametros["result"] !== 'undefined' ? parametros["result"] : null;

      var status = 'error';
    	swal({
    		title: "Disculpe!",
    		text: mensaje,
    		icon: "error",
    		button: "Aceptar",
    		closeOnClickOutside :false
    	}).then(function () {
    		if(callback!="")eval(callback);
    	});
    }
  }
  var success = function(parametros)
  {
    if(parametros)
    {

      var mensaje = parametros["mensaje"] != '' ? parametros["mensaje"] : "Operación Completada Con Éxito";
      var callback = typeof parametros["callback"] !== 'undefined' ? parametros["callback"] : null;
      var result = typeof parametros["result"] !== 'undefined' ? parametros["result"] : null;

      var status = 'success';
    	swal({
    		title: "Listo!",
    		text: mensaje,
    		icon: "success",
    		button: "Aceptar",
    		closeOnClickOutside :false
    	}).then(function () {
    		if(callback!="")eval(callback);
    	});
    }
  }
  var close = function()
  {
    swal.close();
  	$(".swal-overlay").remove();
  }


	//public methods
	return {
    wait:wait,
    error:error,
    success:success,
    close:close
	}
}());
