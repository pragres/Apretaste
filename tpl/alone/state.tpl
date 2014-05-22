{= *AnswerSubject: Su estado en {$apretaste} =}

<p align="justify" style="{$font}">A continuaci&oacute;n se muestra informaci&oacute;n sobre su estado en {$apretaste}, como es
la lista de sus anuncios y las alertas a las cuales Ud. est&aacute; subscrito. Este reporte puede cambiar durante
el tiempo, por lo que puede <a href = "mailto:{$reply_to}?subject=ESTADO&Haga clic en Enviar para obtener el reporte de su estado en {$apretaste}" style ="{$element-a}">solicitarlo nuevamente.</a></p>

<!--{
<h2 style="{$font}">Su cr&eacute;dito:</h2>

<p style="{$font}">Su cr&eacute;dito actual es de ${$credit} USD. Para recargar su cr&eacute;dito visite la web <a href="http://apretaste.com/recargar">http://apretaste.com/recargar</a>.
</p>
}-->
<h2 style="{$font}">Sus anuncios publicados</h2>
?$announcements
	<table width="790" style="{$font}">
		<tr style = "font-weight: bold;">
			<th align="left" width="150">Ticket</th>
			<th align="left">Fecha</th>
			<th align="left">T&iacute;tulo</th>
			<th align="left">Expira</th>
			<th align="left">Visitas</th>
			<th></th>
			<th></th>
		</tr>
		[$announcements]
		<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
			<td style="font-family: Courier;">{$ticket}</td>
			<td width = "60">{$post_date:8,2}/{$post_date:5,2}/{$post_date:4}</td>
			<td><a href="mailto:{$reply_to}?subject=ANUNCIO {$id}&body=Haga clic en Enviar para obtener el anuncio solicitado">{$title}</a></td>
			<td>?$expire {$expire:8,2}/{$expire:5,2}/{$expire:4} $expire?</td>
			<td align="center">?$visits {$visits} @else@ 0 $visits?</td>
			<td align="center" width = "60">
            <a href="mailto:{$reply_to}?subject=CAMBIAR {$ticket} {txt}{$title}{/txt}&body={txt}{$body}{/txt}">Cambiar</a>
			</td>
			<td align="center" width = "60">
				<a href="mailto:{$reply_to}?subject=QUITAR {$ticket}&body=Haga clic en Enviar para quitar el anuncio seleccionado">Quitar</a>
			</td>
		</tr>
		[/$announcements]
		<tr style = "font-weight: bold;{$font}">
			<td></td>
			<td>Total</td>
			<td>{$announcements}</td>
			<td></td>
			<td align="center">{$announcements-visits}</td>
			<td></td><td></td>
		</tr>
	</table>
@else@
	<p>Usted no tiene anuncios publicados.</p>
$announcements?

<h2 style="{$font}">Sus alertas por correo</h2>
?$subscribes
	<table style="{$font}">
		<tr style = "font-weight: bold;">
			<th align="left">Identificador</th><th align="left">Fecha</th><th align="left">Frase de b&uacute;squeda</th><th></th>
		</tr>
		[$subscribes]
		<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
			<td width="150" style="font-family: Courier;">{$id}</td>
			<td width = "70">{$fa:8,2}/{$fa:5,2}/{$fa:4}</td>
			<td><a href="mailto:{$reply_to}&subject=BUSCAR {$phrase}&body=Para buscar haga clic en Enviar">{$phrase}</a></td>
			<td width = "50"><a href = "mailto:{$reply_to}?subject=DETENER {$id}&body=Haga clic en Enviar para detener esta alerta">Detener</a></td>
		[/$subscribes]
		</tr>
		<tr style = "background: white; color: black; font-weight: bold;">
			<td>Total</td>
			<td>{$subscribes}</td>
			<td></td>
		</tr>
	</table>
@else@
	<p style="{$font}">Usted no est&aacute; subscrito a ninguna alerta.</p>
$subscribes?

<h2 style="{$font}">&Uacute;ltimos SMS enviados:</h2>
?$sms
<table>
	<table style="{$font}">
	<tr><th>Fecha</th><th>Tel&eacute;fono</th><th>Mensaje</th><th>Descuento</th></tr>
	[$sms]
	<tr><td>{$send_date}</td>
	<td>{$phone}</td>
	<td>{$message}</td>
	<td>${$discount} USD</td>
	</tr>
	[/$sms]
	</table>
@else@
<p style="{$font}">Usted no ha enviado SMS a trav&eacute;s de Apretaste!.</p>
$sms?

?$services
<h2 style="{$font}">Servicios que no ha utilizado</h2>
<ul>
[$services]
	<li>{$value}</li>
[/$services]
</ul>
<p style="{$font}">Para saber como utilizar estos servicios consulte <a href="mailto:{$reply_to}?subject=AYUDA">la Ayuda</a>.</p>
$services?

