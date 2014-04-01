<p align="justify" style="text-align:justify;{$font}">
Usted ha recibido este correo porque <b><a href="mailto:{$from}">{$from}</a></b> le ha invitado a descubrir 
Apretaste.
</p>
<p align="justify" style="text-align:justify;{$font}">
Apretaste <i>permite revisar servicios en Internet mediante el email</i>. Usando Apretaste usted puede Vender o Comprar algo que necesite, consultar la Enciclopedia, Traducir documentos a decenas de idiomas, ver el Estado del Tiempo o (entre otros) leer un Chiste; siempre usando su correo electr&oacute;nico.
</p>

<h3>Para usar el servicio de Compra/Venta</h3>
<p align="justify" style="text-align:justify;{$font}">Si usted quiere vender la cuna que us&oacute; su hijo, puede encontrar un comprador por email. Si necesita comprar un televisor, puede encontrar quien lo venda usando solamente el email.</p>

<table width="790" style="{$font}">
    <tr>
        <td valign="top">
        	<p align="justify" style="text-align:justify;{$font}">
			Siga los siguientes pasos para buscar un TV a la venta:
			</p>

			<p style="{$font}">1. Cree un correo nuevo. En la sección "Para" escriba: {$reply_to}</p>
			<p style="{$font}">2. En la sección "Asunto" escriba: <span style="color: green;">BUSCAR televisor LCD</span></p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ningun otro campo.</p>

			<p style="{$font}">En menos de 3 minutos recibirá un correo con televisores a la venta.</p> 
			<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
			<a href="mailto:{$reply_to}?subject=BUSCAR televisor LCD" style="{$font};color: white; text-decoration: none; font-weight: bold; padding: 10px; background:#5DBD00;">
			<label style="margin: 5px;">Probar Apretaste ahora</label>
			</a>
			</td></tr></table>
        </td>
        <td valign="top">
        	 [[_
        	 	{= wintitle: "Buscar anuncios" =}
	            {= asunto: "BUSCAR televisor lcd" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>

<br/>
<hr/>
<table width="790" style="{$font}">
    <tr>
		<td valign="top">
			<h3>Para consultar la Enciclopedia</h3>
			<p align="justify" style="text-align:justify;{$font}">Si necesita comprar algo, pero quiere tener más detalles antes de pagar; o necesita hacer una tarea, o sencillamente le gusta leer y aprender un poco de cada cosa, Apretaste pone todo el conocimiento de la raza humana al alcance de su email.</p>

			<p align="justify" style="text-align:justify;{$font}">
			Siga los siguientes pasos para leer la Enciclopedia:
			</p>

			<p style="{$font}">1. Cree un correo nuevo. En la sección "Para" escriba: {$reply_to}</p>
			<p style="{$font}">2. En la sección "Asunto" escriba: <span style="color: green;">ARTICULO jose marti</span></p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ningun otro campo.</p>

			<p style="{$font}">En menos de 3 minutos recibirá un correo con m&aacute;s detalles sobre el apóstol.</p> 
			<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
			<a href="mailto:{$reply_to}?subject=ARTICULO jose marti" style="{$font};color: white; text-decoration: none; font-weight: bold; padding: 10px; background:#5DBD00;">
			<label style="margin: 5px;">Leer la Enclopedia ahora</label>
			</a>
			</td></tr></table>
		</td>
        <td valign="top">
        	 [[_
        	 	{= wintitle: "Consultar la enciclopedia" =}
	            {= asunto: "ARTICULO jose marti" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
<br/>
<hr/>

<table width="790" style="{$font}">
    <tr>
		<td valign="top">
			<h3>Aprenda como usar el resto de nuestros servicios</h3>
			<p align="justify" style="text-align:justify;{$font}">
			Consultando la ayuda usted encontrar&aacute; much&iacute;sima m&aacute;s informaci&oacute;n sobre Apretaste, 
			adem&aacute;s de una lista de todos nuestros servicios y explicaci&oacute;n sobre su uso. ¿No le queda claro? 
			Escr&iacute;banos a <a href="soporte@apretaste.com">soporte@apretaste.com</a> y nosotros en persona le ayudaremos con sus dudas.
			</p>

			<p align="justify" style="text-align:justify;{$font}">
			Siga los siguientes pasos para consultar la Ayuda:
			</p>

			<p style="{$font}">1. Cree un correo nuevo. En la sección "Para" escriba: {$reply_to}</p>
			<p style="{$font}">2. En la sección "Asunto" escriba: <span style="color: green;">AYUDA</span></p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ningun otro campo.</p>

			<p style="{$font}">En menos de 3 minutos recibirá un correo con m&aacute;s informaci&oacute; sobre Apretaste.</p> 
			<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
			<a href="mailto:{$reply_to}?subject=AYUDA" style="{$font};color: white; text-decoration: none; font-weight: bold; padding: 10px; background:#5DBD00;">
			<label style="margin: 5px;">Leer la Ayuda ahora</label>
			</a>
			</td></tr></table>
		</td>
        <td valign="top">
        	 [[_
        	 	{= wintitle: "Consultar la Ayuda" =}
	            {= asunto: "AYUDA" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
<br/>
<hr/>

<table width="790" style="{$font}">
    <tr>
		<td valign="top">
			<h3>Invite a sus amigos y familia</h3>
			<p align="justify" style="text-align:justify;{$font}">
			Invite a sus amigos y familia a conocer Apretaste
			</p>

			<p align="justify" style="text-align:justify;{$font}">
			Envíe un email a anuncios@apretaste.com y en el asunto escriba INVITAR email@deSuAmigo.cu. En menos de 3 minutos le mandaremos un email de confirmación.
			Recuerde reemplazar email@deSuAmigo.cu por el correo electrónico de la persona que quiera invitar.
			</p>

			<p style="{$font}">En menos de 3 minutos recibirá un correo con m&aacute;s informaci&oacute; sobre Apretaste.</p> 
			<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
			<a href="mailto:{$reply_to}?subject=INVITAR escriba aqui el email de su amigo" style="{$font};color: white; text-decoration: none; font-weight: bold; padding: 10px; background:#5DBD00;">
			<label style="margin: 5px;">Invitar amigo ahora</label>
			</a>
			</td></tr></table>
		</td>
        <td valign="top">
        	 [[_
        	 	{= wintitle: "Invitar a un amigo" =}
	            {= asunto: "INVITAR email@deSuAmigo.cu" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
