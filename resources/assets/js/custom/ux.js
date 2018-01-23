
 // Add slideDown animation to Bootstrap dropdown when expanding.
  $('.dropdown').on('show.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown("fast");
  });

  // Add slideUp animation to Bootstrap dropdown when collapsing.
  $('.dropdown').on('hide.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast");
  });


// TOOL TIP

		$(document).ready(function(){
			
			$('[data-toggle="tooltip"]').tooltip(); 
		});

// Carrusel

$('.carousel').carousel({
  			interval: 3500
		});

// huespedesUp


	//$(".numbers-row").append('<div class="inc button_inc" style="width: 40px; height: 40px; border-radius: 50%">+</div>');
	//$(".numbers-row").append('<input type="text" value="1" id="adults_hotel" class="qty2 form-control required" name="adults_hotel">');
	//$(".numbers-row").append('<div class="dec button_inc" style="width: 40px; height: 40px; border-radius: 50%">-</div>');
	$(".button_inc").on("click", function () {

		var $button = $(this);
		var oldValue = $button.parent().find("input").val();

		if ($button.text() == "+") {
			var newVal = parseFloat(oldValue) + 1;
		} else {
            if (oldValue > 1) {
            	var newVal = parseFloat(oldValue) - 1;
            } else {
            	newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });


// RESERVAS BTN FOLLOWING

$(document).scroll(function () {
	
    var y = $(this).scrollTop();
    if (y > 5 && y < 900) {
        $('.resersBtn').slideDown();
    } else {
        $('.resersBtn').slideUp();
    }
});
$( ".resersBtn" ).click(function(e) {
	
	e.stopPropagation();
  	$( "#reser" ).css("paddingTop", "120px");
});

//  MAP show

$( ".verMapa" ).click(function() {
	
  	$(this).fadeOut("fast");
	$(".cerrarMapa").delay(300).fadeIn("fast");
	$(".elMapa").delay(300).slideDown("fast");
});

$( ".cerrarMapa" ).click(function() {
	
  	$(this).fadeOut("fast");
	$(".verMapa").delay(300).fadeIn("fast");
	$(".elMapa").delay(300).slideUp("fast");
});

//  Fechas show

$( "#fechasBtn" ).click(function(e) {
	e.stopPropagation();
  	$( ".fechasGroup" ).slideToggle( "fast", function() {
  });
});
$( "#closingFechas" ).click(function() {
  $(".fechasGroup").slideToggle( "fast", function() {
  });
});


//  huespedes show

$( "#huespedBtn" ).click(function(e) {
	e.stopPropagation();
  	$( ".huespedesGroup" ).slideToggle( "fast", function() {
  });
});
$( "#closingHuesped" ).click(function() {
  $( ".huespedesGroup" ).slideToggle( "fast", function() {
  });
});

// PARAR PROPAGACION HEADER BTNS

$('.fechasGroup, .huespedesGroup, .dropdown-menu').click(function(e){
    e.stopPropagation();
});
$(document).click(function(){
     $('.fechasGroup, .huespedesGroup, .dropdown-menu').slideUp();
});
$( "#fechasBtn" ).click(function(e) {
	e.stopPropagation();
  	$( ".huespedesGroup, .dropdown-menu" ).slideUp( "fast", function() {
  });
});
$( "#huespedBtn" ).click(function(e) {
	e.stopPropagation();
  	$( ".fechasGroup, .dropdown-menu" ).slideUp( "fast", function() {
  });
});
$( ".dropdown" ).click(function(e) {
  	$( ".fechasGroup, .huespedesGroup" ).slideUp( "fast", function() {
  });
});

// MENU SHOW XS

$( "#searchBtnMobile" ).click(function() {
	
});
$( "#barsMenu" ).click(function() {
	
	$(this).fadeOut(100);
	$("#closeMenu").delay(100).fadeIn(100);
  $( ".menuEquis" ).slideDown( "fast", function() {
  });
});
$( "#closeMenu" ).click(function() {
	
	$(this).fadeOut(100);
	$("#barsMenu").delay(100).fadeIn(100);
  $( ".menuEquis, .searchEquis" ).slideUp( "fast", function() {
  });
});
$( "#closeFilters" ).click(function() {
	
	$(this).fadeOut(100);
	$("#barsMenu").delay(100).fadeIn(100);
  $( ".menuEquis, .searchEquis, .filteringMobile" ).slideUp( "fast", function() {
  });
});

// SEARCH SHOW XS

$( "#searchBtnMobile" ).click(function() {
	
	$("#barsMenu, #closeFilters").fadeOut(100);
	$("#closeMenu").delay(100).fadeIn(100);
  	$( ".searchEquis" ).slideDown("fast");
	$( ".menuEquis, .filteringMobile" ).slideUp( "fast", function() {
  });
});

// FILTERS SHOW

$( "#filtering" ).click(function() {
	
  	$( ".filteringMobile" ).slideDown("fast");
	$("#closeFilters").delay(100).fadeIn(100);
	$("#barsMenu").fadeOut(100);
});


// HIDDEN INPUTS anotherMan

function showInputs()
		{
			// SERVICIOS ADD
			
			$(".checkAdicionales62").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".anotherMan").slideDown();
				} else if (this.checked){
					$(".anotherMan").slideUp();
				} 
			});
			$(".anfMbt").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".anfMbt2").slideDown();
				} else if (this.checked){
					$(".anfMbt2").slideUp();
				} 
			});
			
			$(".checkAdicionales61, .anfMbt").change(function(event) {
				event.preventDefault();
				$(".anotherMan").slideUp();
			});
			$(".checkAdicionales61, .checkAdicionales62").change(function(event) {
				event.preventDefault();
				$(".anfMbt2").slideUp();
			});
			
			$(".checkAdicionales").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput").slideDown();
				} else{
					$(".adicionalesInput").slideUp();
				}
			});
			$(".checkAdicionales5").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput5").slideDown();
				} else{
					$(".adicionalesInput5").slideUp();
				}
			});
			$(".checkAdicionales6").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput6").slideDown();
				} else{
					$(".adicionalesInput6").slideUp();
				}
			});
			$(".checkAdicionales7").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput7").slideDown();
				} else{
					$(".adicionalesInput7").slideUp();
				}
			});
			$(".checkAdicionales8").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput8").slideDown();
				} else{
					$(".adicionalesInput8").slideUp();
				}
			});
			$(".checkAdicionales9").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput9").slideDown();
				} else{
					$(".adicionalesInput9").slideUp();
				}
			});
			$(".checkAdicionales10").change(function(event) {
				event.preventDefault();
				if(this.checked) {
					$(".adicionalesInput10").slideDown();
				} else{
					$(".adicionalesInput10").slideUp();
				}
			});
			
			// TIPOS DE OFERTA
			
			$(".checkAdicionales11").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaOferta_1").slideDown();
				} else {
					$(".ayudaOferta").hide();
				} 
			});
			$(".checkAdicionales11").click(function() {
					$(".ayudaOferta, .ayudaOferta_2, .ayudaOferta_3").hide();
			});
			$(".checkAdicionales12").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaOferta_2").slideDown();
				} else {
					$(".ayudaOferta").hide();
				} 
			});
			$(".checkAdicionales12").click(function() {
					$(".ayudaOferta, .ayudaOferta_1, .ayudaOferta_3").hide();
			});
			$(".checkAdicionales13").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaOferta_3").slideDown();
				} else {
					$(".ayudaOferta").hide();
				} 
			});
			$(".checkAdicionales13").click(function() {
					$(".ayudaOferta, .ayudaOferta_1, .ayudaOferta_2").hide();
			});
			
			// GARANTÍA
			
			$(".checkAdicionales56").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaGarantia_1").slideDown();
				} else {
					$(".ayudaGarantia").hide();
				} 
			});
			$(".checkAdicionales56").click(function() {
					$(".ayudaGarantia, .ayudaGarantia_2, .ayudaGarantia_3").hide();
			});
			$(".checkAdicionales57").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaGarantia_2").slideDown();
				} else {
					$(".ayudaGarantia").hide();
				} 
			});
			$(".checkAdicionales57").click(function() {
					$(".ayudaGarantia, .ayudaGarantia_1, .ayudaGarantia_3").hide();
			});
			$(".checkAdicionales58").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaGarantia_3").slideDown();
				} else {
					$(".ayudaGarantia").hide();
				} 
			});
			$(".checkAdicionales58").click(function() {
					$(".ayudaGarantia, .ayudaGarantia_1, .ayudaGarantia_2").hide();
			});
			
			// METODO
			
			$(".checkAdicionales59").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaMetodo_1").slideDown();
				} else {
					$(".ayudaMetodo").hide();
				} 
			});
			$(".checkAdicionales59").click(function() {
					$(".ayudaMetodo, .ayudaMetodo_2").hide();
			});
			$(".checkAdicionales60").change(function(event) {
				event.preventDefault();
				if (this.checked){
					$(".ayudaMetodo_2").slideDown();
				} else {
					$(".ayudaMetodo").hide();
				} 
			});
			$(".checkAdicionales60").click(function() {
					$(".ayudaMetodo, .ayudaMetodo_1").hide();
			});
			

			
			// Agrupando checks

			// the selector will match all input controls of type :checkbox
			// and attach a click event handler 
			$("input:checkbox").on('click', function() {
			  // in the handler, 'this' refers to the box clicked on
				  var $box = $(this);
				  if ($box.is(":checked")) {
					// the name of the box is retrieved using the .attr() method
					// as it is assumed and expected to be immutable
					var group = "input:checkbox[name='" + $box.attr("name") + "']";
					// the checked state of the group/box on the other hand will change
					// and the current value is retrieved using .prop() method
					$(group).prop("checked", false);
					$box.prop("checked", true);
				  } else {
					$box.prop("checked", false);
				  }
			});	
		}

