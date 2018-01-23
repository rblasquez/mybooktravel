@extends('layouts.app')

@section('content')
<section class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('img/chile1.jpg') }}" data-natural-width="1400" data-natural-height="470">
	<div class="parallax-content-1">
		<div class="animated fadeInDown">
			<h1>Bienvenido(a) {{ Auth::user()->nombres }}!</h1>
			<p>Puedes manejar el contenido de tu cuenta como mejor te parezca.</p>
		</div>
	</div>
</section>

<div class="container margin_60">
	<div class="row">
		
		@include('auth.partials.aside')
		
		<div class="col-md-9" >
			@if($reserva->calificaciones()->count() == 0)
			<form action="{{route('calificacion.guardar',['id_reserva'=>$reserva->id])}}" method="post" id="form_calificar" callback="callback_form_calificar(status,result)">
				
				{{csrf_field()}}
				
				<div class="form-group">
					Califica el alojamiento
				</div>
				
				<div class="form-group">
					@for($i=1;$i<=5;$i++)
						{{$i}} <input type="radio" id="puntuacion"  name="puntuacion" value="{{$i}}">
					@endfor
				</div>
			
				<div class="form-group">
					<textarea id="comentario" name="comentario"></textarea>
				</div>
				
				<div class="form-group">
					<button type="submit" >Guardar</button>
				</div>
				
				<div class="row" id="resultado_envio_form">
					
				</div>
			
			</form>
			@else
				Ya has calificado el alojamiento<br>
				Puntuacion: {{$reserva->calificaciones()->first()->puntuacion}}<br>
				Comentario: {{$reserva->calificaciones()->first()->comentario}}
			@endif
		</div>
	</div>
</div>
@endsection

@push('js')
<script>	

	$("#form_calificar").on("submit", function(){
		
		event.preventDefault();
		
		var form = $(this);
		var callback = form.attr("callback");
		$.ajax({
			type: form.attr("method"),
			url: form.attr("action"),
			data: form.serialize(),
			success: function(result,status)
			{
				if(callback!="")eval(callback);
			},
			error: function(result,status)
			{
				if(callback!="")eval(callback);
			}
		});
		
	});
	
	function callback_form_calificar(status,result)
	{
		//console.log(status);
		//console.log(result);
		if(status == "success")
		{
			location.reload();
		}
	}
</script>


{!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
{!! JsValidator::formRequest('App\Http\Requests\PropiedadCalificacionGuardarRequest', '#form_calificar'); !!}

@endpush
