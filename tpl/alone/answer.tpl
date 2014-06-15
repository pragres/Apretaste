{strip} 

<!--{ Apretaste Template's layout }-->

<!--{ template vars }-->

{% styles %}

{= space10: <div class="space_10">&nbsp;</div> =}
{= space15: <div class="space_15" style="margin-bottom: 15px;">&nbsp;</div> =}
{= space30: <div class="space_30" style="margin-bottom: 30px;">&nbsp;</div> =}
{= separatorLinks: <span class="separador-links" style="color: #A03E3B;">&nbsp;|&nbsp;</span> =}
{= hr: <hr style="border:1px solid #D0D0D0; margin:0px;"/> =}
{= h1: <div class="header_1"><font size="5" face="Arial" color="#52B439"><b> =}
{= _h1: </b></font><hr style="border:1px solid #D0D0D0; margin:0px;"/><font size="1" color="white"><div>&nbsp;</div></font></div> =}
{= h2: <div class="header_2"><font size="4" face="Arial" color="#52B439"><b> =}
{= _h2: </b></font><hr style="border:1px solid #D0D0D0; margin:0px;"/><font size="1" color="white"><div>&nbsp;</div></font></div> =}
{= p: <div class="paragraph"><div style="color:#444444;"> =}
{= _p: </div><font size="2" color="white"><div>&nbsp;</div></font></div> =}
{= br: <font class="space_small" size="2" color="white"><div>&nbsp;</div></font> =}
{= br2: <font class="space_medium" size="5" color="white"><div>&nbsp;</div></font> =}
{= br3: <font class="space_big" size="7" color="white"><div>&nbsp;</div></font> =}


{= commands: {
		sudoku: {cmd: "SUDOKU", desc: "Resolver un Sudoku", rel:["joke", "invite"]},
		help: {cmd: "AYUDA", desc: "Ayuda", rel:["invite"]},
		state: {cmd: "ESTADO", desc: "Mi estado", rel:["invite"]},
		invite: {cmd: "INVITAR", desc: "Invitar a un amigo", rel: ["search", "invite"]},
		search: {cmd: "BUSCAR", desc: "Buscar anuncios", rel: ["searchfull","invite"]},
		searchfull: {cmd: "BUSCARTODO", desc: "Buscar m&aacute;s anuncios", rel: ["search","invite"]},
		joke: {cmd: "CHISTE", desc: "Leer un chiste", rel:["sudoku","invite"]},
		article: {cmd: "ARTICULO", desc: "Buscar en la enciclopedia", rel: ["invite"]},
		weather: {cmd: "CLIMA", desc: "El tiempo en Cuba", rel: ["invite"]},
		insert: {cmd: "PUBLICAR", desc: "Publicar un anuncio", rel: ["state", "update","search","searchfull", "exclusion", "invite"]},
		update: {cmd: "CAMBIAR", desc: "Cambiar su anuncio", rel: ["insert","search","searchfull", "invite"]},
		translate: {cmd: "TRADUCIR", desc: "Traducir textos", rel: ["article", "invite"]},
		exclusion: {cmd: "EXCLUYEME", desc: "Exluirme de los servicios de Apretaste!", rel: ["invite"]},
		delete: {cmd: "QUITAR", desc: "Quitar un anuncio", rel: ["invite"]},
		get: {cmd: "ANUNCIO", desc: "Obtener un anuncio", rel: ["invite"]},
		subscribe: {cmd: "ALERTA", desc: "Alertas de anuncios por correo", rel: ["unsubscribe", "search", "invite"]},
		unsubscribe: {cmd: "DETENER", desc: "Detener alerta por correo", rel: ["subscribe", "invite"]},
		spam: {cmd: "DENUNCIAR", desc: "Denunciar un anuncio", rel: ["invite"]},
		invite: {cmd: "INVITAR", desc: "Invitar a un amigo a Apretaste!", rel: ["invite"]},
		addresses: {cmd: "BUZONES", desc: "Buzones de Apretaste!", rel: ["invite"]},
		terms: {cmd: "TERMINOS", desc: "T&eacute;rminos de uso", rel: ["invite"]}	,
		google: {cmd: "GOOGLE", desc: "Buscar con Google", rel: ["invite"]}	,
		services: {cmd: "SERVICIOS", desc: "Servicios de Apretaste!", rel: ["invite"]}	,
		sms: {cmd: "SMS", desc: "Enviar un SMS", rel:["invite", "sms"]},
		linker: {cmd: "ANUNCIOS", desc: "Anuncios", rel:["insert","search","subscribe"]},
		recharge: {cmd: "RECARGA", desc: "Recargar su cr&eacute;dito", rel:["state"]},
		map: {cmd: "MAPA", desc: "Mapas", rel:["weather","article"]},
		raffle: {cmd: "RIFA", desc: "Rifas", rel:["invite"]}
	}
=}

<!--{ The layout }-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		?$title <title>{$title}</title> $title?
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<style type="text/css">
		@media only screen and (max-width: 600px) {
			#container {
				width: 100%;
			}
		}
		
		@media only screen and (max-width: 480px) {
			.button {
				display: block !important;
			}
			.button a {
				display: block !important;
				font-size: 18px !important; width 100% !important;
				max-width: 600px !important;
			}
			.section {
				width: 100%;
				margin: 2px 0px;
				display: block;
			}
			.phone-block {
				display: block;
			}
		}
		</style>
	</head>
	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="font-family: Arial;">
		<center>
			<table id="container" border="0" cellpadding="0" cellspacing="0"
				border="0" valign="top" align="center" width="600">
	
				!$as_plain_text
				<!--{ links }-->
	
				<tr>
					<td align="right" bgcolor="#D0D0D0" style="padding: 5px;">
						<small>
								<a href="mailto:{$reply_to}?subject=AYUDA">Ayuda</a> 
								{$separatorLinks}
								<a href="mailto:{$reply_to}?subject=INVITAR escribe aqui el email de tu amigo">Invitar</a>
								{$separatorLinks}
								<a href="mailto:{$reply_to}?subject=SERVICIOS">M&aacute;s servicios</a>
						</small>
					</td>
				</tr>
	
				<!--{ logo & title }-->
				<tr>
					<td bgcolor="#F2F2F2" align="center" valign="middle">
						{$space10}
						<table border="0">
							<tr>
								<td class="phone-block" style="margin-right: 20px;">
									<img width="200" src="cid:logo" alt="Apretaste!" /> 
								</td>
								?$command
								<td class="phone-block" align="center">
									<font size="6" face="Tahoma" color="#A03E3B"><b>{$commands.{$command}.cmd}</b></font>
								</td>
								$command?
							</tr>
						</table>
						{$space10}
					</td>
				</tr>
				$as_plain_text!
				
				<tr>
					?$msg
					<td align="left">
					{% user_message %}
					</td>
					$msg?
				</tr>
				
				<!--information-->
				?$information
				<tr>
					<td align="left" style="padding: 0px 5px;">
						<div class="note" style="color: gray;">
							<small>{$information}</small>
						</div>
					</td>
				</tr>
				$information?
	
				<tr>
					<td align="left" style="padding: 0px 5px;">
						{% content %}
					</td>
				</tr>
				
				!$as_plain_text
				
				?$command
				<!--services related-->
				<tr>
					<td align="left" style="padding: 0px 5px;">
						{$space30} 
						<!--{ START related }-->
						[$commands.{$command}.rel]
						<nobr>
							<a href="mailto:{$reply_to}?subject={$commands.{$value}.cmd}">{$commands.{$value}.desc}</a>
						</nobr> 
						!$_is_last {$separatorLinks} $_is_last!
						[/$commands.{$command}.rel]
						<!--{ END related }--> 
					</td>
				</tr>
				$command?
				
				<!--{ footer }-->
				<tr>
					<td align="center">
						{$space15}
						<hr style="border: 1px solid #A03E3B;" />
						<p>
							<small>
							Escriba dudas e ideas a <a href="mailto:soporte@apretaste.com">soporte@apretaste.com</a>. Lea nuestros <a href="mailto:{$reply_to}?subject=TERMINOS">T&eacute;rminos de uso</a>.<br/> 
							<a href="#">Apretaste!</a> pertenece a <a href="pragres.com">Pragres Corporation</a> &copy; Copyright 2014
							</small>
						</p>
					</td>
				</tr>
				$as_plain_text!
			</table>
		</center>
	</body>
</html>
{/strip}
