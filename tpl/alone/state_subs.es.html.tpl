?$subscribes
	<table width = "790" style="{$font}">
		<tr style = "font-weight: bold;">
			<th align="left">Identificador</th><th align="left">Fecha</th><th align="left">Frase de b&uacute;squeda</th><th></th>
		</tr>
		[$subscribes]
		<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
			<td width="150">{$id}</td>
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