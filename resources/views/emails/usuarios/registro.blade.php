@extends('emails.layout')
@section('content')
<table bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
	<tbody>
		<tr>
			<td valign="top" align="left"><a href="#"><img src="{{ $message->embed('img/mail/main_banner_'.rand(2, 8).'.jpg') }}" class="emailImage" alt="Main banner" border="0" width="600" height="320"></a></td>
		</tr>
	</tbody>
</table>
<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width">
	<tbody>
		<tr>	
			<td align="center">																										

				<table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
					<tbody>
						<tr>
							<td align="center">
								<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" class="full-width">
									<tbody>
										<tr><td height="30">&nbsp;</td></tr>
										<tr><td align="center"><img src="{{ $message->embed('img/mail/logo_small.jpg') }}" width="58" alt="Image"></td></tr>
										<tr><td height="10" style="font-size:10px; mso-line-height-rule:exactly; line-height:10px;">&nbsp;</td></tr>
										<tr>
											<td class="font_fix" style="font-size:27px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Maven Pro', sans-serif;" align="center">
												¡Hola, {{ $usuario->nombres }} {{ $usuario->apellidos }}!
											</td>
										</tr>
										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Estas a solo un paso de activar tu cuenta, verifica tu correo.
												<br><br>
												Haz click en el boton del enlace y conoce la nueva forma de publicar o buscar hospedajes en el destino que deseas.
											</td>
										</tr>
										<tr><td height="20" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td></tr>
										
										<tr>
											<td align="center">
												<table cellspacing="0" cellpadding="0" border="0" align="center">
													<tbody>
														<tr>
															<td align="center" style="display:block; padding: 16px 0px;width: 200px; -webkit-text-size-adjust:none;">
															<a href="{{ route('finalizar', [$usuario->id, csrf_token()]) }}" style="padding: 16px 31px;background: #0ec8db;color: #fff;font-size: 17px; text-decoration: none;">Finalizar Registro</a>
														</td>
														</tr>
													</tbody>

												</table>
											</td>
										</tr>
										<tr><td height="90">&nbsp;</td></tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
@endsection