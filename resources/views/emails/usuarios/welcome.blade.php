@extends('emails.layout')

@section('content')
<table bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
	<tbody>
		<tr>
			<td valign="top" align="left"><a href="#"><img src="{{ $message->embed('img/mail/main_banner_'.rand(1,8).'.jpg') }}" class="emailImage" alt="Main banner" border="0" width="600" height="320"></a></td>
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
										<tr>
											<td align="center">
												<img src="{{ $message->embed('img/mail/logo_small.jpg') }}" width="58" alt="Image">
											</td>
										</tr>
										<tr><td height="10" style="font-size:10px; mso-line-height-rule:exactly; line-height:10px;">&nbsp;</td></tr>
										<tr>
											<td class="font_fix" style="font-size:27px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: Maven Pro, sans-serif;" align="center">
												<strong style="font-size:17px; text-transform:uppercase;">¡Bienvenido!</strong>
												<br>{{ $usuario->nombres }} {{ $usuario->apellidos }}
											</td>
										</tr>
										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: Maven Pro, sans-serif;" align="center">
												¡Ya eres parte de nuestra comunidad! y todos queremos saber mas de ti...
												<br><br>
												Completa los datos de tu perfil, no saltes los detalles, cuéntale a todos lo que te gusta, mejora tu visibilidad y aumenta la confianza de quienes quieren ponerse en contacto contigo.
											</td>
										</tr>
										<tr>
											<td height="80" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td>
										</tr>
										
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



<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width" bgcolor="#f9f9f9">
	<tbody>
		<tr>
			<td align="center">	
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
					<tbody>
						<tr>
							<td class="font_fix" align="center" bgcolor="#0ec8db" style="color:#ffffff;font-weight:bold; font-family: 'Montserrat', sans-serif; font-size:18px; text-transform:uppercase; padding-top:10px; padding-bottom:10px">- Algo más -</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
					<tbody>
						<tr><td height="30">&nbsp;</td></tr>
					</tbody>
				</table>	
				<table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width" bgcolor="#f9f9f9">
					<tbody>
						<tr>
							<td align="left">
								<table width="253" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
									<tbody>
										<tr>
											<td align="center">
												<table width="253" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="center" valign="top"><a href="#"><img src="{{ $message->embed('img/mail/icon_2.jpg') }}" alt="Image" width="92" height="92" border="0" style="display:block"></a><br></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" class="font_fix" style="font-size:16px; color:#333333;font-family: Maven Pro, sans-serif; line-height:18px">
												<a href="{{ route('informacion', 'contacto') }}" style="text-transform:uppercase; color:#0ec8db; font-weight:bold; text-decoration: none;">
													¡Contáctanos!
												</a>
											</td>
										</tr>
										<tr>
											<td height="26" align="center"><img src="{{ $message->embed('img/mail/green_line.jpg') }}" width="30" height="2" alt="Image"></td>
										</tr>
										<tr>
											<td style="font-size:13px;mso-line-height-rule:exactly; line-height:16px; color:#333; font-weight:normal; font-family: Maven Pro, sans-serif;" align="center">
												Servicio de atención al cliente 24/7 los 365 días del año.
											</td>
										</tr>	
										<tr>
											<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
										</tr>

									</tbody>
								</table>
								<table align="left" cellspacing="0" width="35" cellpadding="0" border="0" class="full-width">
									<tbody>
										<tr>
											<td height="35" width="35" style="font-size: 0;border-collapse:collapse;font-size: 35px; line-height: 35px;">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table width="253" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
									<tbody>
										<tr>
											<td align="center">
												<table width="253" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="center" valign="top"><a href="#"><img src="{{ $message->embed('img/mail/icon_3.jpg') }}" alt="Image" width="92" height="92" border="0" style="display:block"></a><br></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" class="font_fix" style="font-size:16px; color:#333333;font-family: Maven Pro, sans-serif; line-height:18px">
												<a href="{{ url('/') }}" style="text-transform:uppercase; color:#0ec8db; font-weight:bold; text-decoration: none;">
													¡Reserva!
												</a>
											</td>
										</tr>
										<tr>
											<td height="26" align="center"><img src="{{ $message->embed('img/mail/green_line.jpg') }}" width="30" height="2" alt="Image"></td>
										</tr>
										<tr>
											<td style="font-size:13px;mso-line-height-rule:exactly; line-height:16px; color:#333; font-weight:normal; font-family: Maven Pro, sans-serif;" align="center">
												¡Reserva fácil y seguro! Hazlo en línea o través de nuestros contactos telefónicos.
											</td>
										</tr>	
										<tr>
											<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
										</tr>

									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
					<tbody>
						<tr>
							<td height="30">&nbsp;</td>
						</tr>
					</tbody>
				</table>	
				<table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width" bgcolor="#f9f9f9">
					<tbody>
						<tr>
							<td align="left">
								<table width="253" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
									<tbody>
										<tr>
											<td align="center">
												<table width="253" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="center" valign="top"><a href="#"><img src="{{ $message->embed('img/mail/icon_1.jpg') }}" alt="Image" width="92" height="92" border="0" style="display:block"></a><br></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td class="font_fix" align="center" style="font-size:16px; color:#333333;font-family: Maven Pro, sans-serif; line-height:18px">
												<a href="{{ route('propiedad.create') }}" style="text-transform:uppercase;color:#0ec8db; font-weight:bold; text-decoration: none;">
													¡Publica ahora!
												</a>
											</td>
										</tr>
										<tr>
											<td height="26" align="center"><img src="{{ $message->embed('img/mail/green_line.jpg') }}" width="30" height="2" alt="Image"></td>
										</tr>
										<tr>
											<td style="font-size:13px;mso-line-height-rule:exactly; line-height:16px; color:#333; font-weight:normal; font-family: Maven Pro, sans-serif;" align="center">
												Publicar tu alojamiento es gratuito y no caduca.
											</td>
										</tr>	
										<tr>
											<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table align="left" cellspacing="0" width="35" cellpadding="0" border="0" class="full-width">
									<tbody>
										<tr>
											<td height="35" width="35" style="font-size: 0;border-collapse:collapse;font-size: 35px; line-height: 35px;">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table width="253" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
									<tbody>
										<tr>
											<td align="center">
												<table width="253" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="center" valign="top"><a href="#"><img src="{{ $message->embed('img/mail/icon_4.jpg') }}" alt="Image" width="92" height="92" border="0" style="display:block"></a><br></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" class="font_fix" style="font-size:16px; color:#333333;font-family: Maven Pro, sans-serif; line-height:18px">
												<a href="{{ url('/') }}" style="text-transform:uppercase; color:#0ec8db; font-weight:bold; text-decoration: none;">
													!Internacional!
												</a>
											</td>
										</tr>
										<tr>
											<td height="26" align="center"><img src="{{ $message->embed('img/mail/green_line.jpg') }}" width="30" height="2" alt="Image"></td>
										</tr>
										<tr>
											<td style="font-size:13px;mso-line-height-rule:exactly; line-height:16px; color:#333; font-weight:normal; font-family: Maven Pro, sans-serif;" align="center">
												Tenemos presencia en todo Chile y Argentina
											</td>
										</tr>	

										<tr>
											<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
										</tr>

									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
					<tbody>
						<tr>
							<td height="30">&nbsp;</td>
						</tr>
					</tbody>
				</table>	
			</td>
		</tr>
	</tbody>
</table>
@endsection