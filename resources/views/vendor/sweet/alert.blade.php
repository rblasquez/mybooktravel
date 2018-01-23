@if (Session::has('sweet_alert.alert'))
<script>
	
	var mensaje = {!! Session::pull('sweet_alert.alert') !!}
	mensaje.animation = false;
	swal(mensaje);

</script>
@endif
