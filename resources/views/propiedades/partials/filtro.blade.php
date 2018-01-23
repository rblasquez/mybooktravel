
<a href="#" id="filtering" class="visible-xs visible-sm filtering">
	<i class="fa fa-filter" aria-hidden="true"></i> Filtros
</a>

<div class="filteringMobile col-xs-12">
	<div class="row">
		<div class="col-xs-12">
			<h3>Tipo de Alojamiento</h3>
			<select id="tipo_alojamiento" id="tipo_alojamiento" onchange="$('#tipo_propiedades_id').val(this.value);busqueda_avanzada();" >
				@foreach( $tipos_propiedad as $key => $value )
				<option value="{{$key}}">{{$value}}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<h3>Precios</h3>

			<div><b class="precio_minimo_visible" >30.000</b> CLP</div>
			<input id="ex2" type="text" class="span2" value="" data-slider-min="10000" data-slider-max="300000" data-slider-step="5" data-slider-value="[20000,150000]"/>
			<div><b class="precio_maximo_visible" >50.000</b> CLP</div>

		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<h3>Reserva Inmediata</h3>
			<input type="checkbox" data-toggle="toggle" data-on="Sí" data-off="No" onchange="$('#reserva_inmediata').val(this.checked);busqueda_avanzada();">
		</div>
	</div>

	<div class="searchBtnMobile col-xs-12">
		<div class="col-xs-3" style="margin: 0"></div>
		<div class="col-xs-6">
			<button class="searchBtnEquis">Buscar</button>
		</div>
		<div class="col-xs-3"></div>
	</div>
</div>

<!-- FILTROS DESK -->
<div class="filtros col-md-12 hidden-xs hidden-sm">
	
	<div class="dropydown hide">
		<span>Fecha</span>
		<div class="dropydown-content">
			<div class="input-daterange input-group" id="datepicker">
				<input type="text" class="input-sm form-control" name="start" placeholder="Llegada" /><input type="text" class="input-sm form-control" name="end" placeholder="Salida" />
			</div>
		</div>
	</div>

	<div class="dropydown">
		<span>Tipo de Alojamiento</span>
		<div class="dropydown-content">
			@foreach($tipos_propiedad as $key => $value)
			<li onclick="$('#tipo_propiedades_id').val('{{$key}}');busqueda_avanzada();"  class="filtro_avanzado"  ><a href="#" >{{$value}}</a></li>				
			@endforeach
		</div>
	</div>

	<div class="dropydown">
		<span>Costos</span>
		<div class="dropydown-content">
			<li><a href="#" onclick="$('#precio_minimo').val('30000');$('#precio_maximo').val('50000');busqueda_avanzada();" class="filtro_avanzado"  >Entre $30.000 y $50.000</a></li>
			<li><a href="#" onclick="$('#precio_minimo').val('60000');$('#precio_maximo').val('100000');busqueda_avanzada();"  class="filtro_avanzado" >Entre $60.000 y $100.000</a></li>
			<li><a href="#" onclick="$('#precio_minimo').val('100000');$('#precio_maximo').val('150000');busqueda_avanzada();"  class="filtro_avanzado" >Entre $100.000 y $150.000</a></li>
		</div>
	</div>

	<div class="dropydown hide">
		<span>Huéspedes</span>
		<div class="dropydown-content">
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
		</div>
	</div>

	<div class="dropydown">
		<span>Reserva inmediata</span>
		<div class="dropydown-content">
			<li>
				<input type="checkbox" checked data-toggle="toggle" data-on="Sí" data-off="No" class="filtro_avanzado" onchange="$('#reserva_inmediata').val(this.checked);busqueda_avanzada();">
			</li>
		</div>
	</div>
	<a href="#" class="masterTooltip" title="¡Ayúdenme que no entiendo nada!"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
</div>

<input type="hidden" id="precio_minimo" name="precio_minimo" />
<input type="hidden" id="precio_maximo" name="precio_maximo"  />
<input type="hidden" id="tipo_propiedades_id" name="tipo_propiedades_id" />
<input type="hidden" name="reserva_inmediata" id="reserva_inmediata"  />
