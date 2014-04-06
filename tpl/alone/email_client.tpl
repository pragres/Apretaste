<!--{ Componente ventana de redaccion de un cliente web }-->
<table style="font-family: Verdana; border: 1px solid gray; background:#eeeeee; " cellspacing="0" cellpadding="0">
	<tr style="background: navy;">
		<td style="padding: 5px;" align="left" colspan="2">
			<table width="397" cellspacing="0" cellpadding="0" style="margin: 0px;">
				<tr>
					<td style="font-family: Verdana; color:white; font-weight: bold;" width="300">{$wintitle}</td>
					<td width="25" align="right">
						<table cellpadding="0" cellspacing="0" style="font-family: Verdana; background: #cccccc; text-align: center; color: black;border: 1px solid gray;font-weight:bold; height: 24px; width: 24px;">
						<tr><td>X</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="50">
			<table cellspacing="0" cellpadding="3" style="font-family: Verdana; font-weight: bold;border: 1px solid gray; background: #cccccc; width: 70px;  text-align: center; height: 35px;">
			<tr><td>Enviar</td></tr>
			</table>
		</td>
		<td style="padding: 5px;" align="left">
			<table cellspacing="0" cellpadding="2" style="font-family: Verdana; font-weight: bold;border: 1px solid gray; background: #cccccc; width: 190px; text-align: center; height: 35px;">
			<tr><td>Adjuntar archivo</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="50">De:</td>
		<td align="left">
			<table cellspacing="0" cellpadding="0" style="font-family: Lucida console; margin: 5px;background: white; color:black; padding: 5px; border: 1px solid gray; width: 315px;">
			<tr><td>{$from}</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="50">Para:</td>
		<td align="left">
			<table cellspacing="0" cellpadding="0" style="font-family: Lucida console; margin: 5px;background: white; color:black; width:350px; padding: 5px; border: 1px solid gray;width: 315px;">
			<tr><td>{$reply_to}</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="50">Asunto:</td>
		<td align="left">
			<table cellspacing="0" cellpadding="0" style="font-family: Lucida console; margin: 5px; background: white; color:black; width:350px; padding: 5px; border: 1px solid gray;width: 315px;" type="text">
			<tr><td>{$asunto}</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" colspan="2">
			<table style="font-family: Lucida console; margin: 2px;background: white; color:black; height:160px; padding: 5px; border: 1px solid gray;width: 394px;">
			<tr><td style="height:170px;text-align: justify;" valign="top">{$cuerpo}</td></tr>
			</table>
		</td>
	</tr>
</table>