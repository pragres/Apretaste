{= *AnswerSubject: "Confirmar el pago de la compra" =}

{$h1}{$AnswerSubject}{$_h1}
{$p}Por motivos de seguridad y para evitar errores pedimos su confirmaci&oacute;n antes de rebajar su cr&eacute;dito. Si usted no desea comprar este art&iacute;culo, o si no reconoce esta transacci&oacute;n, ignore este mensaje y su cr&eacute;dito no ser&aacute; afectado.
{$br}{$br}
M&aacute;s abajo se detallan los datos de la compra.
{$_p}

?$sale
	<!--{ begin }-->
	Producto: <b>{$sale.title}</b>{$br}
	
	?$sale.picture
	<img src="cid:salepicture" width="100">{$br}
	$sale.picture?
		
	Precio: <b>${#sale.price:2.#}</b>{$br}
	
	{$p}Su cr&eacute;dito actual es de <b>${#credit:2.#}</b>. Despu&eacute;s de confirmar el pago quedar&aacute; en <b>$(# {$credit}-{$sale.price} :2.#)</b>.{$_p}
	<!--{ end }-->
$sale?

{$hr}
{$p}Por favor confirme su compra en los pr&oacute;ximos 30 minutos o ignoraremos esta transacci&oacute;n.{$_p}
{$br}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=PAGAR%20{$confirmation_code}">
<label style="margin: 5px;">Confirmar</label>
</a>
</td></tr></table>