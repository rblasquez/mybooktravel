//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//TOKEN EN TODAS LAS PETICIONES AJAX
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//INICIALIZACIONES CUANDO EL DOCUMENTO ESTA LISTO
$( document ).ready(function() {

	Form.start.sender();
	Fecha.selector.start(".calendario");
	Validador.general.start();

});
