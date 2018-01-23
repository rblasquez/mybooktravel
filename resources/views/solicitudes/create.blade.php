{!! Form::open() !!}
{!! Form::label('nombres', '') !!}
{!! Form::text('nombres', null) !!}
<br><br>
{!! Form::label('apellidos', '') !!}
{!! Form::text('apellidos', null) !!}
<br><br>
{!! Form::label('email', '') !!}
{!! Form::email('email', null) !!}
<br><br>
{!! Form::label('telefono', '') !!}
{!! Form::tel('telefono', null) !!}
<br><br>
<hr>

{!! Form::label('origen', 'Pais / Ciudad de Origen') !!}
{!! Form::text('origen', null) !!}
<br><br>
{!! Form::label('destino', '') !!}
{!! Form::select('destino', [
    'viña|-75.242455|-32.69845564' => 'Viña del mar'
], null) !!}
<br><br>
{!! Form::label('cantidad', 'Cantidad de personas') !!}
{!! Form::number('cantidad', null) !!}
<br><br>
{{--
{!! Form::label('adultos', '') !!}
{!! Form::number('adultos', null) !!}
<br><br>
{!! Form::label('ninios', 'Niños') !!}
{!! Form::number('ninios', null) !!}
<br><br>
--}}
{!! Form::label('fecha_llegada', '') !!}
{!! Form::date('fecha_llegada', null) !!}
<br><br>
{!! Form::label('fecha_salida', '') !!}
{!! Form::date('fecha_salida', null) !!}
<br><br>
{!! Form::label('precio_max', '') !!}
{!! Form::number('precio_max', null) !!}
<br><br>
{!! Form::label('precio_min', '') !!}
{!! Form::number('precio_min', null) !!}
<br><br>
{!! Form::label('estacionamientos', '') !!}
{!! Form::select('estacionamientos', [], null) !!}
<br><br>
{!! Form::label('tipo ', '') !!}
{!! Form::radio('tipo', 'casa', true) !!} Casa
{!! Form::radio('tipo', 'departamento', true) !!} Departamento
{!! Form::radio('tipo', 'cabaña', true) !!} Cabaña
{!! Form::radio('tipo', 'todos', true) !!} Todos
<br><br>

{!! Form::submit('Enviar') !!}
{!! Form::close() !!}
