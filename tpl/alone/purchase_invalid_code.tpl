{= *AnswerSubject: "El pago no se pudo efectuar" =}
{$h1}{$AnswerSubject}{$_h1}
{$p}El pago no pudo ser efectuado por alguno de los siguientes motivos:{$_p}
<ul>
	<li>El n&uacute;mero del producto a comprar es incorrecto o el producto ya no se encuentra en la venta.</li>
	<li>Usted no es el mismo usuario que inici&oacute; la compra.</li>
	<li>Expir&oacute; el tiempo para confirmar.</li>
</ul>
{$p}Su cr&eacute;dito no ha sido afectado.{$_p}
?$sale
{$p}Usted puede intentar nuevamente <a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=COMPRAR%20{$sale.id}"><label style="margin: 5px;">Comprar {$sale.title}</label>
</a>
{$_p}
$sale?