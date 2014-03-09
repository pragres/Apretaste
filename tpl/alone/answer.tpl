{strip}
	{% styles %}
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
		<body style="{$element-body};">
			<table width="800" align="center" cellspacing="0" cellpadding="0" style="background: white;">
				<tr>
					<td>
					?$compactmode
						{% compact %}
					@else@
						<table width ="800" cellspacing="0" cellpadding="0" style ="margin-bottom: 5px;{$font}">
							<tr>
								<td width="30%" align="left">
									<a href="http://apretaste.com" style="border:0px;">
									<img style="margin: 0px 0px 10px 20px;border:0px;" alt="{$apretaste}" src="{$logo}"/>
									</a>
								</td>
								<td align = "right" valign="top" style="{$font}">
									<a style="{$element-a}" href="mailto:{$reply_to}?subject=PUBLICAR Titulo del anuncio&body={$body_insert}" title="Abre un nuevo correo listo para publicar un nuevo anuncio">Publicar un anuncio</a><br/>
									
									?$query 
										{= qalerta: $query =} 
									@else@ 
										{= qalerta: "" =} 
									$query?
									
									<a style="{$element-a}" href="mailto:{$reply_to}?subject=BUSCAR &body={$body_search}" title="Realiza una nueva b&uacute;squeda">Nueva b&uacute;squeda</a>
																
									{?( "{$answer_type}" != "help" )?}
											{$splitter}<a style="{$element-a}" href="mailto:{$reply_to}?subject=BUSCARTODO&body=Escriba en el asunto una frase de b&uacute;squeda despu&eacute;s de la palabra BUSCARTODO" title="Buscar m&aacute;s resultados">Buscar todo</a>
									{/?}			
									!$alerta {?( "{$answer_type}" != "show_announcement" && "{$answer_type}" != "state" && "{$answer_type}" != "help" )?} {$splitter}<a style="{$element-a}" href="mailto:{$reply_to}?subject=ALERTA {$qalerta}&body=Defina su frase de busqueda en el asunto de este mensaje. Luego haga clic en Enviar para obtener los resultados." title="Env&iacute;a diariamente correos con nuevos anuncios acerca de esta b&uacute;squeda">Crear alerta</a>{/?}$alerta!<br/>
									<a style="{$element-a}" href="mailto:{$reply_to}?subject=INVITAR direccion@de.correo.de.su.amigo&body=Escriba en el asunto el correo electr&oacute;nico de su amigo despu&eacute;s de la palabra INVITAR" title="Env&iacute;a un correo a un amigo coment&aacute;ndole sobre nuestro servicio e invit&aacute;ndole a usarlo">Invitar a un amigo</a>
									{?( "{$answer_type}" != "state" )?}
										{$splitter}<a style="{$element-a}" href="mailto:{$reply_to}?subject=ESTADO&body=Haga clic en el Enviar para consultar su estado." title="Conocer que anuncios tiene Ud. publicado, a cu&aacute;les alertas est&aacute; subscrito, etc..">Ver mi estado</a>
									{/?}
									
									{?( "{$answer_type}" != "help" )?}
										{$splitter}<a style="{$element-a}" href="mailto:{$reply_to}?subject=AYUDA " title="Env&iacute;a un correo de ayuda sobre como usar el sistema">Ayuda</a><br/>
									{/?}
									
								</td>
							</tr>
						</table>
						<!--body-->
						<table style="" width="800" cellspacing="0" cellpadding="0">
							<tr style="height: 35px;">
								<!--{ title }-->
								<td colspan="2" bgcolor="#5DBD00" style="color:black; padding-top: 10px; padding-bottom: 4px;">									
									?$title
										<h3 style = "{$element-h1}; margin-top: 5px; margin-bottom: 5px;{$font}">{$title}</h3>
									$title?
								</td>
							</tr>
							<!--{ main section }-->
							<tr>
								<td valign="top" style="padding: 5px; border-left: 3px solid #5DBD00;border-right: 3px solid #5DBD00;">
									<table cellpadding="0" cellspacing="0" style="margin-left: 5px;{$font}" width="775"><tr><td>
									?$content
										{% content %}
									$content?
									
									
									</td></tr></table>
								</td>
							</tr>
				
							<!--{ another sections }-->
						{% sections %}
						
						<!--{ footer section }-->
						{% footer %}
						
						</table>
					$compactmode?
					</td>
				</tr>
			</table>
			{% credentials %}
		</body>
	</html>
{/strip}