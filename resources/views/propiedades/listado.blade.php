@extends('layouts.app')

@section('content')
<section class="container profileContent">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-12">
			<h1>Resultado de la búsqueda</h1>
		</div>

		{{--
		@include('propiedades.partials.filtro')
		--}}

		<div id="lista_propiedades">
			@include('propiedades.partials.preview_list')
		</div>
	</div>
</section>
<a href="{{ route('propiedad.buscar') }}" class="busquedaAvanzadaRoute hide "></a>
@endsection

@push('css')
<style>
.galery-prev {
	left: 3px;
}

.galery-nex {
	right: 0px;
}

.galery-prev, .galery-nex {
	line-height: 0;
	z-index: 5;
	position: absolute;
	top: 50%;
	display: flex;
	width: 10%;
	height: 100%;
	padding: 0;
	-webkit-transform: translate(0,-50%);
	-ms-transform: translate(0,-50%);
	transform: translate(0,-50%);
	border: none;
	outline: 0;
	align-items: center;
}

.galery-nex i,
.galery-prev i {
	color: #fff;
	/*
	color: rgba(220, 218, 218, 0.81);
	text-shadow: 0px 0px 8px rgba(0, 0, 0, 0.89);
	*/
	font-size: 55px;
}

.resultadoPropiedad {
	border-bottom: none;
	margin: 0 0 15px 0 !important;
	padding-bottom: 30px;
}

.resultadoPropiedad > .row > .detalles {
	height: 100%;
}

.resultadoPropiedad .row {
	min-height: 154px;
}

.resultadoPropiedad hr {
	margin-bottom: 0;
}

.precio{
	font-size: 2em;
	font-weight: 600;
}

.descripcion .servicios>div{
	min-height: 50px;
}

@media only screen and (max-width: 450px) {
	.resultadoPropiedad h3 {
		font-size: 19px;
		margin-top: 5px !important;
	}

	.precio {
		font-size: 1.5em;
		font-weight: 500;
	}

	.resultadoPropiedad .row {
		min-height: auto;
	}
}


.descripcion {
	/*margin-top: 12%;*/
}

.servicios {
	height: auto;
}

.servicios img {
	display:block;
	margin:0 auto 0 auto;
	cursor: auto;
}

.servicios p {
	font-size: 11px;
	margin-top: 3px;
	font-weight: 500;
}

.servicios i {
	font-size: 32px;
	color: gray;
}


img:hover {
	opacity: 1 !important;
}

</style>
@endpush

@push('js')
<script>
	initSlick()

	function initSlick() {
		$('.fotos-miniatura').slick({
			centerPadding:'0px',
			lazyLoad: 'ondemand',
			mobileFirst: true,
			dots: false,
			infinite: true,
			prevArrow: '<a href="" class="galery-prev"><i class="fa fa-angle-left"></i></a>',
			nextArrow: '<a href="" class="galery-nex"><i class="fa fa-angle-right"></i></a>',
		});
	}

	$( document ).ready(function() {
		$("#ex2").slider();
		$("#ex2").on("slide", function(slideEvt) {
				var value = slideEvt.value;
				var minimo = value[0];
				var maximo = value[1];
				$(".precio_minimo_visible").empty().append(minimo);
				$(".precio_maximo_visible").empty().append(maximo);
				$("#precio_minimo").val(minimo);
				$("#precio_maximo").val(maximo);

			}).on("slideStop", function(slideEvt) {
				busqueda_avanzada();
			});
		});

	function busqueda_avanzada(page = "") {
		var data_to_send = {};
		data_to_send['localidad'] = $("#localidad").val();
		data_to_send['pais'] = $("#pais").val();
		data_to_send['fecha_entrada'] = $("#fecha_entrada").val();
		data_to_send['fecha_salida'] = $("#fecha_salida").val();
		data_to_send['total_adultos'] = $("#total_adultos").val();
		data_to_send['total_ninos'] = $("#total_ninos").val();
		data_to_send['tipo_propiedades_id'] = $("#tipo_propiedades_id").val();

		data_to_send['precio_minimo'] = $("#precio_minimo").val();
		data_to_send['precio_maximo'] = $("#precio_maximo").val();


		data_to_send['page'] = page;
		data_to_send['reserva_inmediata'] = $("#reserva_inmediata").val();

		var token = $('input[name=_token]').val();
		var route = $('.busquedaAvanzadaRoute').attr('href');
		var route = window.location.href;

		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN' : token },
			type: "GET",
			data: data_to_send,
			success: function(result){
				$("#lista_propiedades").html(result.html);
				inicializar_readmore();
				initSlick()
			}
		});
	}


	function inicializar_readmore()
	{

		$('.descripcion').readmore({
			afterToggle: function(trigger, element, expanded)
			{
				if(!expanded)
				{
					$('html, body').animate({scrollTop: element.offset().top}, {duration: 100});
				} else {
					var mapa = $(element).children(".mapa_propiedad");
					if(mapa.attr("mapa_generado") == 0)
					{
						var id = mapa.attr('id');
						var latitud = parseFloat(mapa.attr('latitud'));
						var longitud = parseFloat(mapa.attr('longitud'));

						var marcadores = [{
							name: 'descripcion',
							location_latitude: latitud,
							location_longitude: longitud,
						}];
						var ubicacion = { lat : latitud, lng : longitud };

						mapaUbicacionPropiedad(marcadores, ubicacion, id);

						mapa.attr("mapa_generado", 1);
					}
				}
			}
		});
	}

	$(document).on("click",".pagination li a",function(e){
		e.preventDefault();
		block('#lista_propiedades')

		var url = $(this).attr("href");
		var params = url.split("?")[1].split("&");
		var parts = params[0].split("=");
		var page = parts[1];

		busqueda_avanzada(page);
		$('html, body').animate({ scrollTop: 0 }, 'fast');

	});

</script>
@endpush
