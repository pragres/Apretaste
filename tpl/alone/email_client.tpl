<!--{ Componente ventana de redaccion de un cliente web }-->

{= ecw: 300 =} <!--{ email client width }-->

<table style="font-family: Verdana; border: 1px solid gray; background:#eeeeee; width:{$ecw}px;" cellspacing="0" cellpadding="0" width="{$ecw}">
	<tr style="background: navy;">
		<td style="padding: 5px;" align="left" colspan="3">
			<table width="{$ecw}" cellspacing="0" cellpadding="0" style="margin: 0px;">
				<tr>
					<td style="font-family: Verdana; color:white; font-weight: bold;" width="(# {$ecw} * 300/397 :0 #)">{$wintitle}</td>
					<!--{ <td width="(# {$ecw} * 25/397 :0 #)" align="right">
						<table cellpadding="0" cellspacing="0" style="font-family: Verdana; background: #cccccc; text-align: center; color: black;border: 1px solid gray;font-weight:bold; height: 24px; width: (# {$ecw} * 24/397 :0 #)px;">
						<tr><td>X</td></tr>
						</table>
					</td> }-->
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="50">
			<table cellspacing="0" cellpadding="3" style="font-family: Verdana; border: 1px solid gray; background: #cccccc; width: (# {$ecw} * 70/397 :0 #)px;  text-align: center; height: 35px;">
			<tr><td>Enviar</td></tr>
			</table>
		</td>
		<td style="padding: 5px;" align="left">
			<table cellspacing="0" cellpadding="2" style="font-family: Verdana; border: 1px solid gray; background: #cccccc; width: (# {$ecw} * 150 / 397 :0 #)px; text-align: center; height: 35px;">
			<tr><td>Adjuntar</td></tr>
			</table>
		</td>
		<td style="padding: 5px;" align="left">
			<table cellspacing="0" cellpadding="2" style="font-family: Verdana; border: 1px solid gray; background: #cccccc; width: (# {$ecw} * 150 / 397 :0 #)px; text-align: center; height: 35px;">
			<tr><td>Guardar</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="(# {$ecw} * 50/397 :0 #)">De:</td>
		<td align="left" colspan="2">
			<table cellspacing="0" cellpadding="0" style="font-family: Lucida console; margin: 5px;background: white; color:black; padding: 5px; border: 1px solid gray; width: (# {$ecw} * 315/397 :0 #)px;">
			<tr><td>{$from}</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="(# {$ecw} * 50/397 :0 #)">Para:</td>
		<td align="left" colspan="2">
			<table cellspacing="0" cellpadding="0" style="font-family: Lucida console; margin: 5px;background: white; color:black; width:350px; padding: 5px; border: 1px solid gray;width: (# {$ecw} * 315/397 :0 #)px;">
			<tr><td>{$reply_to}</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px;" align="right" width="(# {$ecw} * 50/397 :0 #)">Asunto:</td>
		<td align="left" colspan="2">
			<table cellspacing="0" cellpadding="0" style="font-family: Lucida console; margin: 5px; background: white; color:black;  padding: 5px; border: 1px solid gray;width: (# {$ecw} * 315/397 :0 #)px;" type="text">
			<tr><td>{$asunto}</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" style="padding: 5px; background: white; border: 1px solid gray; !$cuerpo height: 30px; $cuerpo! text-align: justify;"  colspan="3">			
			{$cuerpo}&nbsp;
		</td>
	</tr>
</table>