@extends('administracion.layouts.modulo')

@section('contenedor_modulo')

  <div class="container">
    <div class="row">
      <div class="offset-md-10 col-md-2">
        <a class="btn btn-primary" href="{{route('cupon_descuento.create')}}" >Agregar</a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form id="form_cupon_descuento_list" method="post" action="{{route('cupon_descuento.list')}}" callback="$('#contenedor_lista').empty().append(result);" >

          @include('administracion.cupon_descuento.partials.titulo')

          <button type="submit" class="btn btn-primary">Buscar</button>

        </form>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-12" id="contenedor_lista">

      </div>
    </div>
  </div>

@endsection

@push('js')
  {!! JsValidator::formRequest('App\Http\Requests\Administracion\ListCuponDescuentoRequest', '#form_cupon_descuento_list'); !!}
  <script>CuponDescuento.index.start();</script>
@endpush
