@extends('emails.layout')
@section('content')
<table bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
	<tbody>
		<tr>
			<td valign="top" align="left">
				@if (count($propiedad->imagenes) > 0)
				<img class="emailImage" alt="Main banner" border="0" width="600" src="{{ Storage::cloud()->temporaryUrl($propiedad->imagenes->where('primaria', true)->first()['ruta'], \Carbon\Carbon::now()->addMinutes(30)) }}" alt="">
				@else
				<img class="emailImage" alt="Main banner" border="0" width="600" src="{{ $message->embed('img/mail/publicacion_banner.jpg') }}" alt="">
				@endif
			</td>
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
											<td class="font_fix" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Maven Pro', sans-serif;" align="center">
												¡Genial, tu anuncio ha sido publicado!
											</td>
										</tr>
										<tr><td height="40">&nbsp;</td></tr>
										<tr>
											<td class="font_fix" style="font-size:30px; mso-line-height-rule:exactly; line-height:20px; color:#555555; font-weight:bold; font-family: 'Maven Pro', sans-serif;" align="center">
												{{ $propiedad->nombre }}
											</td>
										</tr>

										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Has finalizado la publicación de tu propiedad, Puedes visualizarla en el siguiente enlace.
											</td>
										</tr>
										<tr><td height="20" style="font-size:20px; mso-line-height-rule:exactly; line-height:20px;">&nbsp;</td></tr>
										
										<tr>
											<td align="center">
												<table cellspacing="0" cellpadding="0" border="0" align="center">
													<tbody>
														<tr>
															<td align="center" style="display:block; padding: 16px 0px;width: 200px; -webkit-text-size-adjust:none;">
																<a href="{{ route('propiedad.detalle', $propiedad->id) }}" style="padding: 16px 31px;background: #0ec8db;color: #fff;font-size: 17px; text-decoration: none;">Ver publicación</a>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr><td height="20" style="line-height:20px; "></td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="left">
												<span style="text-transform:uppercase;color:#555555; font-weight:bold; text-decoration: none; display: block; margin-bottom: 25px">
													Recuerda:
												</span>

												<ol id="lista5">
													<li>Evita publicar tu anuncio sin fotografías.</li>
													<li>Publicar fotografías de calidad  aumenta la posibilidad de obtener mayor número de reservas.</li>
													<li>Completar todos los datos que describen tu alojamiento y la zona donde esta ubicado aumenta la confianza de quienes quieren contactarte.</li>
													<li>Toda fotografía con marca de agua, logotipo o referencia de otras marcas  y/o empresas, será borrada o sustituido dicho logo por el nuestro.</li>
												</ol>
											</td>
										</tr>
										<tr><td height="20">&nbsp;</td></tr>
										<tr>
											<td style="font-size:14px; mso-line-height-rule:exactly; line-height:18px; color:#95a5a6; font-weight:normal; font-family: 'Maven Pro', sans-serif;" align="center">
												Para garantizar la calidad de tu contenido conoce <strong><a href="{{ route('informacion', 'politicas') }}" style="color: #0ec8db">nuestras políticas</a></strong>
											</td>
										</tr>
										<tr><td height="20">&nbsp;</td></tr>
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


@push('css')
	<style>
		
    #lista5 {
        counter-reset: li; 
        list-style: none; 
        *list-style: decimal; 
        font: 15px 'trebuchet MS', 'lucida sans';
        padding: 0;
        margin-bottom: 4em;
        text-shadow: 0 1px 0 rgba(255,255,255,.5);
    }

    #lista5 ol {
        margin: 0 0 0 2em; 
    }

    #lista5 {
        list-style-type: none;
        list-style-type: decimal !ie;

        margin: 0;
        margin-left: 1em;
        padding: 0;

        counter-reset: li-counter;
    }

    #lista5 > li{
        position: relative;
        margin-bottom: 1.5em;
        padding: 1.5em 2em;
    }

    #lista5 > li:before {
        position: absolute;
        top: 0.2em;
        left: -0.5em;
        width: 1.2em;
        height: 1.2em;

        font-size: 2em;
        line-height: 1.2;
        font-weight: bold;
        text-align: center;
        color: #464646;
        background-color: #d0d0d0;
        border-radius: 100px;

        z-index: 99;
        overflow: hidden;

        content: counter(li-counter);
        counter-increment: li-counter;
    }
	</style>
@endpush
