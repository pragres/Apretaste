{= *AnswerSubject: "Confirmar el pago de la compra" =}

{$h1}{$AnswerSubject}{$_h1}
{$p}Por motivos de seguridad y para evitar una equivocaci&oacute;n de su parte, exigimos que el pago de cada compra sea confirmado antes de rebajarle el precio de su cr&eacute;dito. M&aacute;s abajo se detallan los datos de la operaci&oacute;n a efectuar.{$_p}

?$sale
	{$h2}Producto a comprar:{$_h2}
	<!--{ begin }-->
	<b>{$sale.title}</b>{$br}
	
	?$sale.picture
	<img src="cid:salepicture" width="100">{$br}
	$sale.picture?
		
	Precio: <b>${#sale.price:2.#}</b>{$br}
	
	<a href="mailto:{$reply_to}?subject=VENTA%20{$sale.id}">Ver detalles</a>
	<!--{ end }-->
$sale?
{$br}
?$purchase
	{$h2}Datos de la solicitud:{$_h2}
	{$p}
	Fecha y hora: {$purchase.moment:0,19}{$br}
	C&oacute;digo de confirmaci&oacute;n: <b>{$confirmation_code}</b>{$br}
	{$_p}	
$purchase?
{$p}IMPORTANTE: <b>Usted tiene 30 minutos, posterior a la hora de solicitud, para confirmar su compra.</b>{$_p}
{$h2}Su cr&eacute;dito:{$_h2}
{$p}Su cr&eacute;dito actual es de <b>${#credit:2.#}</b>. Despu&eacute;s de confirmar el pago quedar&aacute; en <b>$(# {$credit}-{$sale.price} :2.#)</b>.{$_p}
{$hr}
{$br}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=PAGAR%20{$confirmation_code}">
<label style="margin: 5px;">Confirmar</label>
</a>
</td></tr></table>