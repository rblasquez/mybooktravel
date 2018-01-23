var Validador = (function () {

	//private methods
	var general = (function () {
		return {
			start:function()
			{

				$("input").on("keydown",function(event){
					// console.log("permitida: "+teclaPermitida(event.key));//si no esta devuelve -1
				});

				$('.entero_positivo').on("keydown",function(event){
					return Validador.especifico.enteroPositivo(event.key) || Validador.especifico.teclaPermitida(event.key);
				});especifico

				$('[maxlength]').on("keydown",function(event){
					var length = $(this).val() ? ($(this).val()).length : 0;
					var maxlength = $(this).attr('maxlength');
					// console.log(event.key);
					if( length >= maxlength && !teclaPermitida(event.key) )
					{
						return false;
					}
				});

				$('.minusculas').on("keyup",function(event){
					this.value = this.value.toLowerCase();
				});

				$('[type=number][min][max]').on("keyup",function(event){
					// console.clear();
					// console.log('campo con max y min');
					var min = $(this).attr('min') ? parseInt($(this).attr('min')) : 0;
					var max = $(this).attr('max') ? parseInt($(this).attr('max')) : 1;
					var value = $(this).val() ? parseInt($(this).val()) : 0;

					if(value < min || value > max)
					{
						// console.log('previno');
						var new_value = $(this).val();
						if(value < min)new_value = "";
						else
						{
							// console.log('else');
							while(parseInt(new_value) > max)
							{
								// console.log('while');
								new_value = new_value.substring(0, new_value.length - 1);
							}
						}
						$(this).val(new_value);
						// return false;
					}
				});


			}
		}
	}());

	var especifico = (function () {
		return {
			teclaPermitida:function(tecla_pulsada)
			{
				var teclas_permitidas = ["Backspace", "Delete", "Tab", "ArrowDown", "ArrowUp", "ArrowRight", "ArrowLeft"];
				return teclas_permitidas.indexOf(tecla_pulsada) == -1 ? false : true;
			},
			enteroPositivo:function(tecla_pulsada)
			{
				var regex = /[^\d*]/;
				var entero_positivo = !regex.test(tecla_pulsada);
				return entero_positivo;
			}
		}
	}());

	//public methods
	return {
		general:general,
		especifico:especifico
	}

}());
