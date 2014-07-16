{= *AnswerSubject: Su estado en {$apretaste} =}

{$p}
A continuaci&oacute;n se muestra un reporte con informaci&oacute;n detallada de su estado en {$apretaste}, como puede ser su cr&eacute;dito,
la lista de sus anuncios y las alertas a las cuales Ud. est&aacute; subscrito, etc. Si lo desea puede <a href = "mailto:{$reply_to}?subject=ESTADO&Haga clic en Enviar para obtener el reporte de su estado
 en {$apretaste}" style ="{$element-a}">solicitarlo nuevamente</a> para obtenerlo actualizado.
{$_p}

{%% profile.tpl %%}

{$h2}Su cr&eacute;dito:{$_h2}
{$p}
Su cr&eacute;dito actual es de <b>${#credit:2.#}</b>. 
<!--{ Para recargar su cr&eacute;dito visite la web <a href="http://apretaste.com/recargar">http://apretaste.com/recargar</a>. }-->
{$_p}

?$announcements
{$h2}Sus anuncios publicados{$_h2}
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
	{$h2}Sus anuncios publicados{$_h2}
	{$p}Usted no tiene anuncios publicados en Apretaste!{$_p}
$announcements?

?$subscribes
{$h2}Sus alertas por correo{$_h2}
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
	{$h2}Sus alertas por correo{$_h2}
	{$p}Usted no est&aacute; subscrito(a) a ninguna alerta{$_p}
$subscribes?

{$br}
?$sms
{$h2}&Uacute;ltimos SMS enviados:{$_h2}
<table>
	<table style="{$font}">
	<tr><th>Fecha</th><th>Tel&eacute;fono</th><th>Mensaje</th><th>Descuento</th></tr>
	[$sms]
	<tr><td>{$send_date:0,16}</td>
	<td>{$phone}</td>
	<td>{$message}</td>
	<td>${$discount} USD</td>
	</tr>
	[/$sms]
	</table>
$sms?

{$br}
?$services
{$h2}Servicios que no ha utilizado{$_h2}
<ul>
[$services]
	<li>{$value}</li>
[/$services]
</ul>
{$p}Para saber como utilizar estos servicios consulte <a href="mailto:{$reply_to}?subject=AYUDA">la Ayuda</a>.{$_p}
$services?

{$h2}Rifa{$_h2}
{$p}Usted tiene <b>{$tickets}</b> tickets para nuestra <a href="mailto:{$reply_to}?subject=RIFA">rifa en curso</a>.{$_p}
