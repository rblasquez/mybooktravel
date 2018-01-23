@extends('emails.layout')

@section('content')
@include('emails.partials.banner_random')

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
												Recuperacion de Contraseña
											</td>
										</tr>
										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Está recibiendo este correo electrónico porque recibimos una solicitud de reinicio de su contraseña para su cuenta.
											</td>
										</tr>
										<tr><td height="20" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td></tr>
										
										<tr>
											<td align="center">
												<table cellspacing="0" cellpadding="0" border="0" align="center">
													<tbody>
														<tr>
															<td align="center" style="display:block; padding: 16px 0px;width: 400px; -webkit-text-size-adjust:none;">
																<a href="{{ route('password.reset', $token) }}" style="padding: 16px 80px;background: #0ec8db;color: #fff;font-size: 17px; text-decoration: none;">Recuperar contraseña</a>
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