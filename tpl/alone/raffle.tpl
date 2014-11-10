{= *AnswerSubject: $title =}
{= mes: {
	m01 : 'Enero',
	m02 : 'Febrero',
	m03 : 'Marzo',
	m04 : 'Abril',
	m05 : 'Mayo',
	m06 : 'Junio',
	m07 : 'Julio',
	m08 : 'Agosto',
	m09 : 'Septiembre',
	m10 : 'Octubre',
	m11 : 'Noviembre',
	m12 : 'Diciembre'
 }
=}

{$h1}{$AnswerSubject}{$_h1}
{$p}Gracias por participar en la Rifa de Apretaste! Creemos en el poder de la amistad, por lo que siempre premiamos a los usuarios que invitan a sus amigos y familia a disfrutar de Apretaste!{$_p}
{$p}Por cada persona que invites y empiece a usar Apretaste! te ganar&aacute;s un ticket. El <b>(# {$date_to:8,2} #) de {$mes.m{$date_to:5,2}} del {$date_to:0,4}</b> pondremos todos los tickets en un 
bombo y enviaremos un email con la lista de ganadores. Como en todas las rifas, mientras m&aacute;s tickets tengas, m&aacute;s oportunidades de ganar. &iquest;Est&aacute;s listo para llevarte un premio?{$_p}
<img width="100%" src="cid:raffle_image"/>
{$br}
{$p}{$description}{$_p}
{$br}
<center>
	<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
	<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=INVITAR escriba aqui las direcciones email de sus amigos">
	<label style="margin: 5px;">Invitar y Ganar Tickets!</label>
	</a></td></tr></table>
	{$br}
	{$p}
		Usted tiene hasta ahora un total de <b>{$total_tickets} tickets</b>{$br}{$br}
		Para contar los tickets que ha ganado puede <a href="mailto:{$reply_to}?subject=ESTADO">revisar su estado en Apretaste!</a>.
	{$_p}
	
</center>
<!--{ store_begin }-->
?$store
{$br}
{$h1}Venta de tickets{$_h1}
<table width="100%" align="center">
	<tr>
		<? $cellwidth = intval(100/count($store)); ?>
		[$store]
			<td align="center" valign="top" style="border: 1px solid gray;padding: 5px;" width="{$cellwidth}%">
				<b>{$title}</b><br/>
				<font color="green">${#price:2.#}</font><br/>
				<a href="mailto:{$reply_to}?subject=COMPRAR%20{$id}&body=Haga%20clic%20en%20Enviar%20para%20comenzar%20la compra">Comprar</a>
			</td>
		[/$store]
	</tr>
</table>{$br}
{$p}<b>Necesita comprar cr&eacute;dito?</b> Env&iacute;e un email a <a href="mailto:credito@apretaste.com?SUBJECT=Hola,%20necesito%20credtio&BODY=Vivo%20en...Llamame al...">credito@apretaste.com</a>. El vendedor m&aacute;s cercano a usted lo contactar&aacute; inmediatamente.{$_p}
$store?
<center>
<font size="15" color="green">&iexcl;Buena suerte!</font>
</center>
<!--{ store_end }-->