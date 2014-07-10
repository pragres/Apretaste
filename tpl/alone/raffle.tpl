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
	<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:anuncios@apretaste.com?subject=INVITAR escriba aqui las direcciones email de sus amigos">
	<label style="margin: 5px;">Invitar y Ganar Tickets!</label>
	</a></td></tr></table>
	{$br}
	{$p}
		Usted tiene hasta ahora un total de <b>{$total_tickets} tickets</b><br/>
		Para contar los tickets que ha ganado puede <a href="mailto:anuncios@apretaste.com?subject=ESTADO">revisar su estado en Apretaste!</a>.
	{$_p}
	<font size="15" color="green">&iexcl;Buena suerte!</font>
</center>
