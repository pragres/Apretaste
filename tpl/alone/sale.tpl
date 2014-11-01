{= *AnswerSubject: "Venta: {$sale.title}" =}

{$h1}{$AnswerSubject}{$_h1}
<!--{ begin }-->
<b>{$sale.title}</b>{$br}
	
?$sale.picture
<img src="cid:salepicture" width="200">{$br}
$sale.picture?

?$sale.description
{$p}{$sale.description}{$_p}
$sale.description?

Precio: <b>${#sale.price:2.#}</b>{$br}

{$h2}Due&ntilde;o del producto:{$_h2}
<table>
	<tr>
		<td valign="top">
			<img src="cid:authorpicture" width="50">
		</td>
		<td valign="top">
			?$sale.author.name Nombre: {$sale.author.name}{$br} $sale.author.name?
			<a href="mailto:{$reply_to}?subject=PERFIL%20{$sale.author.email}" title="Ver el perfil">{$sale.author.email}</a> {$br}
		</td>
	</tr>
</table>
?$sale.deposit
	{$h2}Beneficiario:{$_h2}
	<table>
		<tr>
			<td valign="top">
				<img src="cid:depositpicture" width="50">
			</td>
			<td valign="top">
				?$sale.deposit.name Nombre: {$sale.deposit.name}{$br} $sale.deposit.name?
				<a href="mailto:{$reply_to}?subject=PERFIL%20{$sale.deposit.email}" title="Ver el perfil">{$sale.deposit.email}</a>{$br}
			</td>
		</tr>
	</table>
@else@
	{$p}NOTA: El due&ntilde;o es el beneficiario del cr&eacute;dito a cobrar.{$_p}
$sale.deposit?
<!--{ end }-->
{$hr}
{$br}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=COMPRAR%20{$sale.id}">
<label style="margin: 5px;">Comprar</label>
</a>
</td></tr></table>