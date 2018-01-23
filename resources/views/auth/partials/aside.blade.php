<div class="col-md-3 col-xs-12 profileMenu">

	<div class="row">
		@if (Request::is('perfil') || Request::is('editar-perfil'))
		<div class="col-md-12 col-xs-4">

			<a href="" data-toggle="modal" data-target="#avatar-modal">
				<figure>
					@if (Auth::user()->imagen)
					<img id="userAvatar" src="{{ Storage::cloud('minio')->url('user_img/'.Auth::user()->imagen) }}">
					@else
					<img id="userAvatar" src="{{ asset('img/user.jpg') }}">
					@endif
				</figure>
			</a>
		</div>
		@endif
		@php
		$tamanio = (Request::is('perfil') || Request::is('perfil/*')) ? 'col-md-8 col-xs-8 menuPerfilUp' : 'col-md-8 col-xs-12' ;
		@endphp

		<div class="{{ $tamanio }}">
			<div class="hidden-lg hidden-sm hidden-md">
				<select autofocus onChange="window.location.href=this.value">
					<option>MENÚ DE PERFIL</option>
					<option value="{{ route('propiedad.create') }}">Publicar Alojamiento</option>
					<option value="{{ route('propiedad.index') }}">Mis Alojamientos</option>
					<option value="{{ route('reserva.index') }}">Mis Reservas</option>
					@if (Auth::user()->tipo_usuario == 'A')
					<option value="{{ route('pagos.listado') }}">Confirmar pagos</option>
					@endif
				</select>

				@if (Request::is('perfil'))
				<div class="col-xs-6 menuPerfilUp">
					<button class="editaBtn" onclick="window.location.href='{{ route('perfil.editar') }}'">Edita tu perfil</button>
				</div>
				@endif

			</div>
		</div>
	</div>

	<div class="row">
		<nav class="perfilMenu col-md-12 hidden-xs">
			<ul>
				<li>
					<a href="{{ (Request::is('perfil')) ? route('perfil.editar') : route('perfil.index') }}" class="">
						{{ Request::is('perfil') ? 'Editar mi perfil' : 'Mi Perfil' }}
					</a>
				</li>
				<li><a href="{{ route('propiedad.index') }}" class="{{ (Request::is('propiedad')) ? 'curriente' : '' }}">Mis Alojamientos</a></li>
				<li><a href="{{ route('reserva.index') }}" class="{{ (Request::is('reserva')) ? 'curriente' : '' }}">Mis Reservas</a></li>
				@if (Auth::user()->tipo_usuario == 'A')
				<li><a href="{{ route('pagos.listado') }}" class="{{ (Request::is('pagos/aprobar')) ? 'curriente' : '' }}">Confirmar pagos</a></li>
				@endif
				<li class="publicaBtnPerfil"><a href="{{ route('propiedad.create') }}">Publicar Alojamiento</a></li>
			</ul>
		</nav>
	</div>
</div>


<div id="crop-avatar">
	<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				{!! Form::open(['route' => 'perfil.avatar', 'class' => 'avatar-form']) !!}
				<div class="modal-header">
					<h4 class="modal-title" id="avatar-modal-label">Cambia tu imagen de perfil</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="avatar-body">

							<div class="row">
								<div class="col-md-12">
									<div class="avatar-wrapper"></div>
								</div>
							</div>
							<div class="row aploudin">
								<div class="row">
									<div class="avatar-upload col-md-6">
										{!! Form::hidden('avatar_src', null, ['class' => 'avatar-src']) !!}
										{!! Form::hidden('avatar_data', null, ['class' => 'avatar-data']) !!}
										<input type="file" name="avatar_file" id="avatarInput" class="inputfile"  />
										<label for="avatarInput">Escoge una imgen <i class="fa fa-upload" aria-hidden="true"></i></label>
									</div>
									<div class="col-md-6 text-right avatar-botones">
										<div class="btn-group">
											<button type="button" class="rotateLeft" data-method="rotate" data-option="-90" title="Rota la imagen a -90 grados">
												<i class="fa fa-undo" aria-hidden="true"></i>
											</button>
										</div>
										<div class="btn-group">
											<button type="button" class="rotateRight" data-method="rotate" data-option="90" title="Rota la imagen a 90 grados">
												<i class="fa fa-repeat" aria-hidden="true"></i>
											</button>
										</div>
									</div>
									<div class="" id="miCanvas"></div>
									<div class="col-md-12 avatar-mensajes"></div>
								</div>
							</div>

							<div class="row avatar-btns text-right avatar-botones">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<button type="submit" class="avatar-save">Subir</button>
										</div>
										<div class="col-md-6">
											<button type="button" class="cerrarPic" data-dismiss="modal">Cancelar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>

@push('js')
@if (Request::is('perfil') || Request::is('editar-perfil'))
{!! Html::script('js/perfil-img.js') !!}
@endif
@endpush
