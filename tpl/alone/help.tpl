{= *AnswerSubject: Ayuda de {$apretaste} =}
{$p}
	Apretaste <i>permite revisar servicios en Internet mediante el email</i>. Usando Apretaste 
	usted puede Vender o Comprar algo que necesite, consultar la Enciclopedia, Traducir documentos a 
	decenas de idiomas, ver el Estado del Tiempo o (entre otros) leer un Chiste; siempre usando su 
	correo electr&oacute;nico.
{$_p}

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">&#191;Quiere probar Apretaste? Siga esto pasos para usar nuestro servicio de Compra/Venta</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">BUSCAR televisor LCD</span></p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un email <br/> con televisores a la venta.</p><br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=BUSCAR televisor lcd&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
							<label style="margin: 5px;">Probar Compraventa Ahora</label>
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
{$br}


{$h1}Otros servicios bien populares{$_h1}
<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Traducci&oacute;n, para traducir documentos a una infinidad de idiomas</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">TRADUCIR A</span> seguido del idimoma a traducir</p>
			<p style="{$font}">3. En el cuerpo del mensaje escriba el texto a traducir, Apretaste! entender&accute; el idioma en que est&aacute;, no necesita especificarlo.</p> 
			<p style="{$font}">4. Haga clic en "Enviar".</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un email <br/> con el texto traducido.</p><br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=TRADUCIR A ingles&body=Este es un texto en espanol que pronto sera traducido al ingles">
							<label style="margin: 5px;">Probar Traducir Ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 [[_
        	 	{= wintitle: "Traducir" =}
	            {= asunto: "TRADUCIR A ingles" =}
	            {= cuerpo: "Este es un texto en espanol que pronto sera traducido al ingles" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
{$br}<hr/>

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Enciclopedia, para obtener informaci&oacute;n enciclop&eacute;dica</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">ARTICULO</span> seguido del nombre de una persona, lugar u obra famosa</p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un email <br/> con la informaci&oacute;n pedida.</p><br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=ARTICULO jose marti&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
							<label style="margin: 5px;">Probar Enciclopedia Ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 [[_
        	 	{= wintitle: "Usar la Enciclopedia" =}
	            {= asunto: "ARTICULO jose marti" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
{$br}<hr/>

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Mapa, ver mapa de alg&uacute;n barrio o fotos de estructuras famosas</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">MAPA</span> seguido una direcci&oacute;n o nombre de estructura famosa</p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un email <br/> con la informaci&oacute;n pedida.</p><br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=MAPA capitolio, Cuba&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
							<label style="margin: 5px;">Probar Mapa Ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 [[_
        	 	{= wintitle: "Consultar el mapa" =}
	            {= asunto: "MAPA capitolio, cuba" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
{$br}<hr/>

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Clima, consultar el estado del tiempo</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">CLIMA</span></p>
			<p style="{$font}">3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un email <br/> con el estado del tiempo.</p><br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=CLIMA&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
							<label style="margin: 5px;">Probar Clima Ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 [[_
        	 	{= wintitle: "Consultar el Clima" =}
	            {= asunto: "CLIMA" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
{$br}<hr/>

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">SMS, mandar SMS nacional o internacional mediante su email a precio reducido</h3>
			<p style="{$font}">1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a></p>
			<p style="{$font}">2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">SMS</span> seguido del numero de tel&eacute;fono que recibir&accute; el SMS</p>
			<p style="{$font}">3. En el cuerpo del mensaje escriba el texto a enviar</p> 
			<p style="{$font}">4. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.</p>
			<br/>
			<p align="center">En menos de 3 minutos recibir&aacute; un email de confirmaci&oacute;n y su contacto recibir&aacute; un SMS.</p>
			<p align="center">Para mandar un SMS internacioal, necesita escribir el c&oacute;digo del pa&iacute;s delante del n&uacute;mero. Puede <a href="mailto:{$reply_to}?subject=SMS CODIGOS">ver una lista de c&oacute;digos</a> aqu&iacute;.</p> 
			<p align="center">Para mandar SMS necesita cr&eacute;dito. Contacte a uno de nuestros vendedores enviando un email a <a href="mailto:credito@apretaste.com?subject=Hola, vivo en [PUEBLO O CIUDAD] y necesito credito, por favor contacteme a [EMAIL O TELEFONO]">credito@apretaste.com</a></p>
			<br/>

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=SMS 5xxxxxx&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
							<label style="margin: 5px;">Enviar un SMS</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 [[_
        	 	{= wintitle: "Consultar el Clima" =}
	            {= asunto: "CLIMA" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
{$br}


{$h1}Tenemos muchos m&aacute;s servicios{$_h1}
{$p}Brindamos muchos m&aacute;s servicios, y estamos orgullosos de decir que todos los meses incrementamos la lista, para el disfrute de nuestros usuarios. &#191;Cree que hay alg&uacute;n servicio que nos falta por agregar? &#191;Hay algo que quiera decirnos? Por favor escriba sus ideas a <a href="soporte@apretaste.com">soporte@apretaste.com</a> y las pondremos en consideraci&oacute;n.{$_p}
{$br}
<table align="center">
	<tr>
		<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
			<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=SERVICIOS&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
				<label style="margin: 5px;">Ver la lista completa de Servicios</label>
			</a>
		</td>
	</tr>
</table>
{$br}


{$h1}Invite a sus amigos y familia{$_h1}
<table>
	<tr>
		<td valign="top">
			{$p}Invite a sus amigos y familia a conocer Apretaste.{$_p}
			
			{$p}Env&iacute;e un email a <a style="color:green;" href="mailto:anuncios@apretaste.com">anuncios@apretaste.com</a> y en el asunto escriba la palabra <span style="color:green;">INVITAR</span> seguida de la direcci&oacute;n email de su amigo. En menos de 3 minutos le mandaremos un email de confirmaci&oacute;n.{$_p}
			
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
	            {= asunto: "INVITAR email@de.su.amigo.cu" =}
	            {= cuerpo: "" =}
	            {% email_client %}
             _]]
		</td>
	</tr>
</table>
{$br}
{$h1}Ejemplos de las servicios m&aacute;s usados{$_h1}
{% help_commands %}