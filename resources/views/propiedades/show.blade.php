@extends('layouts.app')

@section('content')
	<section class="container profileContent">
		<div class="row">
			<div id="reser">


			</div>

			<a href="whatsapp://send?text={{ route('propiedad.show', $propiedad->id) }}" data-action="share/whatsapp/share">Eviar por WhatsApp</a>
			<br>
			<a href="{{ url('https://api.whatsapp.com/send?phone=56987676444&amp;text=Contacta%20con%20mybooktravel') }}" target="_blank" rel="opener">Contacta con nosotros</a>
		</div>
	</section>
	<a href="{{ route('calcular.noches', $propiedad->id) }}" class="hide ruta_fechas"></a>
	<a class="hide urlPropiedad" href="{{ route('propiedad.show', $propiedad->id) }}"></a>
@endsection

@push('css')
	<style>
	.priceBox .input-daterange div
	{
		width: 50% !important;
	}
	span.aviso {
		font-size: .8em;
		display: block;
	}

	.strikethrough {
		position: relative;
	}
	.strikethrough:before {
		position: absolute;
		content: "";
		left: 0;
		top: 50%;
		right: 0;
		border-top: 1px solid;
		border-color: inherit;

		-webkit-transform:rotate(-50deg);
		-moz-transform:rotate(-50deg);
		-ms-transform:rotate(-50deg);
		-o-transform:rotate(-50deg);
		transform:rotate(-50deg);
	}

	.priceBox .date-picker-wrapper.no-shortcuts.has-gap.single-month,
	.priceBox .date-picker-wrapper.no-shortcuts.no-gap.single-month {
		z-index: 0;
		width: 90%;
	}
	.priceBox .date-picker-wrapper .month-wrapper table {
		width: 100%;
	}

</style>
@endpush

@push('js')
	<script type="text/javascript">
		let reservas 	= {!! json_encode($reservas) !!}
		let total_inquilinos = {{ $propiedad->detalles->capacidad }}
		let dias_minimos = {{ ($propiedad->administracion->noches_minimas) ?? 1 }}

		let checkin_default = '{{ $request->fecha_entrada ?? '' }}';
		let checkout_default = '{{ $request->fecha_salida ?? '' }}';
		let adultos_default = '{{ $request->total_adultos ?? 1 }}';

		const dateRangePicker = {
			format: 'DD-MM-YYYY',
			language: 'es',
			startOfWeek: 'monday',
			startDate: moment(),
			autoClose: true,
			singleDate : true,
			showShortcuts: false,
			singleMonth: true,
			showTopbar: false,
			inline:true,
			container: '',
			alwaysOpen:true,
			beforeShowDay: function(t)
			{
				var curr_date = moment(t).format().substring(0,10);
				var valid = !(reservas.indexOf(curr_date) >- 1);
				var _class = valid ? '' : 'strikethrough';
				var _tooltip = valid ? '' : 'Día ocupado';
				return [valid,_class,_tooltip];
			}
		}


		calcular();

		function inicializar() {

			$('.date').unmask();
			$('#codigo_promocional').mask('AAAA-AAAA-AAAA-AAAA-AAAA', {
				translation: {
					'A': {pattern: /[a-zA-Z0-9]/},
				},
				onKeyPress: function(cep, event, currentField, options){
					//this.value=this.value.toUpperCase()
				},
				onComplete: function(cp) {
					calcular();
				},
			});
			$('.btn-checkin, .btn-checkout, .btn-codigo-promocional').off('click');

			$('.btn-checkin').on('click', function(event) {
				$('#checkInContainer').collapse('toggle');
			});

			$('.btn-checkout').on('click', function(event) {
				$('#checkOutContainer').collapse('toggle');
			});

			$('#checkInContainer').on('show.bs.collapse', function () {
				$('#checkOutContainer').collapse('hide');
			});

			$('#checkOutContainer').on('show.bs.collapse', function () {
				$('#checkInContainer').collapse('hide');
			});

			dateRangePicker.container = '.checkInSelect';
			$('.btn-checkin').dateRangePicker(dateRangePicker)
			.bind('datepicker-change',function(event,obj) {

				let date = moment(obj.value, "DD-MM-YYYY").add(dias_minimos, 'days').format('DD-MM-YYYY');
				let elemento =  $('.btn-checkout')

				elemento.data('dateRangePicker').destroy();
				dateRangePicker.container = '.checkOutSelect';
				dateRangePicker.startDate = date;
				elemento.dateRangePicker(dateRangePicker);

				elemento.data('dateRangePicker').setStart(date);

				$('.btn-checkin').html(obj.value)
				$('#fechas_reservas #fecha_ini').val(obj.value)
				$('#checkInContainer').collapse('toggle')
				$('#checkInContainer').on('hidden.bs.collapse', function () {
					$('#checkOutContainer').collapse('show');
				});
				checkin_default = obj.value;
			});

			dateRangePicker.container = '.checkOutSelect';
			$('.btn-checkout').dateRangePicker(dateRangePicker)
			.bind('datepicker-change',function(event,obj) {
				$('.btn-checkout').html(obj.value)
				$('#fechas_reservas #fecha_fin').val(obj.value)
				$('#checkOutContainer').collapse('hide')


				if ($('#fechas_reservas .form-control#checkin').val() != '') {
					calcular()
					changeUrlParam()
				}
				checkout_default = obj.value;
			});

			$('.valorXnoche, .priceBox').unblock();
		}


		async function calcular()
		{
			block('.valorXnoche, .priceBox');

			let ruta;
			let serialize = {
				fecha_ini: $('#fecha_ini').val() != '' ? $('#fecha_ini').val() : checkin_default,
				fecha_fin: $('#fecha_fin').val() != '' ? $('#fecha_fin').val() : checkin_default,
				total_adultos: $('#total_adultos').val() != '' ? $('#total_adultos').val() : adultos_default,
				codigo_promocional: $('#codigo_promocional').val() != '' ? $('#codigo_promocional').val() : '',
				_token: '{{ csrf_token() }}'
			}

			if ($('.ruta_fechas').length > 0) {
				ruta = $('.ruta_fechas').prop('href');
				const ajaxValor = $.ajax({
					url: ruta,
					type: 'GET',
					dataType: 'html',
					data: serialize,
				});

				await ajaxValor.done(function(data) {
					$.when($('#reser').html(data)).then(inicializar());
				})

				await ajaxValor.fail(function() {
					swal({
						title: "Disculpa",
						text: "Lo sentimos, ha ocurrido un error, intente nuevamente",
						icon: "warning",
					}).then((value) => {
						inicializar()
					})
				})
			}
		}

		function changeUrlParam() {
			var url = $('.urlPropiedad').attr('href');
			url += '?fecha_entrada=' + $('#fechas_reservas #fecha_ini').val();
			url += '&fecha_salida=' + $('#fechas_reservas #fecha_fin').val();
			url += '&total_adultos=' + $('.priceBox .huespedes #total_adultos').val();
			url += '&total_ninos=0';

			window.history.replaceState('', '', url);
		}


	</script>
@endpush
