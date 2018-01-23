//var divBlock

/*
$('#telefono').inputmask("phone", {
    onKeyValidation: function () {
        console.log($(this).inputmask("getmetadata"));
    }
});
*/

$('#pais_id').on('change', function(event) {
	event.preventDefault();
	$.ajax({
		url: ruta_paises_info.replace(':ID', $(this).val()),
		dataType: 'json',
	})
	.done(function(data) {
		console.log(data);
		console.log(data.moneda);
		$('#telefono').val('');
		$('#telefono').unmask();

		$('#telefono').mask('('+data.prefijo_telefono+') 00000000000', {
			placeholder: '('+data.prefijo_telefono+') '
		});
	})
	.fail(function(data) {
		console.log("error");
	})
});

$("#frmRegister").submit(function(event){
	if(!terminos.checked){
		event.preventDefault();
		swal({
			title: "Disculpe",
			text: "Debe completar sus datos y aceptar los términos y condiciones.",
			type: "error",
			confirmButtonText: "Entiendo",
			animation: false,
		});	
	}
});