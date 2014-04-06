<p align="justify" style="{$font}; text-align:justify;">
	Apretaste <i>permite revisar servicios en Internet mediante el email</i>. Usando Apretaste 
	usted puede Vender o Comprar algo que necesite, consultar la Enciclopedia, Traducir documentos a 
	decenas de idiomas, ver el Estado del Tiempo o (entre otros) leer un Chiste; siempre usando su 
	correo electr&oacute;nico.
</p>

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">&#191;Quiere probar Apretaste? Siga esto pasos para usar nuestro servicio de Compra/Venta</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">BUSCAR televisor LCD</span></p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un correo <br/> con televisores a la venta.</p><br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=BUSCAR televisor lcd">
							<label style="margin: 5px;">Probar Apretaste ahora</label>
						</a>
					</td>
				</tr>
			</table>
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

<hr/>

<h3 style="{$font}">Lista de servicios</h3>
{% help_commands_list.es.html.tpl %}
<hr/>

<h3>Invite a sus amigos y familia</h3>
<table>
	<tr>
		<td valign="top">
			<p style="{$font};" align="justify">Invite a sus amigos y familia a conocer Apretaste. </p>
			
			<p style="{$font};" align="justify">Env&iacute;e un email a <a style="color:green;" href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a> y en el asunto escriba <span style="color:green;">INVITAR email@deSuAmigo.cu</span>. En menos de 3 minutos le mandaremos un email de confirmaci&oacute;n.</p>
			
			<p style="{$font};" align="justify">Recuerde reemplazar <span style="color: green;">email@deSuAmigo.cu</span> por el correo electr&oacute;nico de la persona que quiera invitar.</p>
			
			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=INVITAR email@deSuAmigo.cu">
							<label style="margin: 5px;">Invitar amigo ahora</label>
						</a>
					</td>
				</tr>
			</table>
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
<hr/>

<h3 style="{$font}">Ejemplos de las servicios m&aacute;s usados</h3>
{% help_commands.es.html.tpl %}