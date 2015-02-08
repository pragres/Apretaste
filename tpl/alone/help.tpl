{= *AnswerSubject: Ayuda de {$apretaste} =}
{$h1}{$AnswerSubject}{$_h1}
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
			{$p}1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:{$reply_to}">{$reply_to}</a>{$_p}
			{$p}2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">BUSCAR televisor LCD</span>{$_p}
			{$p}3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.{$_p}
			{$br}
			<p align="center">En menos de 3 minutos recibir&aacute; un email con televisores a la venta.</p>
			{$br}

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=BUSCAR televisor lcd&body=Envie este email tal y como esta, nosotros lo escribimos por usted">
							<label style="margin: 5px;">Probar Compra/Venta Ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 {%% email_client: {
        	 	wintitle: "Buscar anuncios",
	            asunto: "BUSCAR televisor lcd"
	         } %%}
		</td>
	</tr>
</table>
{$br}


{$h1}Otros servicios bien populares{$_h1}
<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Traducci&oacute;n, para traducir documentos a una infinidad de idiomas</h3>
			{$p}1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:{$reply_to}">{$reply_to}</a>{$_p}
			{$p}2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">TRADUCIR </span> seguido del idimoma a traducir{$_p}
			{$p}3. En el cuerpo del mensaje escriba el texto a traducir, Apretaste! entender&aacute; el idioma en que est&aacute;, no necesita especificarlo.{$_p}
			{$p}4. Haga clic en "Enviar".{$_p}
			{$br}
			<p align="center">En menos de 3 minutos recibir&aacute; un email con el texto traducido.</p>{$br}

			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=TRADUCIR ingles&body=Este es un texto en espanol que pronto sera traducido al ingles">
							<label style="margin: 5px;">Probar Traducir Ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
        	 {%% email_client: {
        	 	wintitle: "Traducir",
	            asunto: "TRADUCIR ingles",
	            cuerpo: "Este es un texto en espanol que pronto sera traducido al ingles"
	         } %%}
		</td>
	</tr>
</table>
{$br}<hr/>{$br}

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Enciclopedia, para obtener informaci&oacute;n enciclop&eacute;dica</h3>
			{$p}1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:{$reply_to}">{$reply_to}</a>{$_p}
			{$p}2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">ARTICULO</span> seguido del nombre de una persona, lugar u obra famosa{$_p}
			{$p}3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.{$_p}
			{$br}
			<p align="center">En menos de 3 minutos recibir&aacute; un email con la informaci&oacute;n pedida.</p>{$br}

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
			{%% email_client: {
        	 	wintitle: "Usar la Enciclopedia",
	            asunto: "ARTICULO jose marti"
	         } %%}
		</td>
	</tr>
</table>
{$br}<hr/>{$br}

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Mapa, ver mapa de alg&uacute;n barrio o fotos de estructuras famosas</h3>
			{$p}1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:{$reply_to}">{$reply_to}</a>{$_p}
			{$p}2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">MAPA</span> seguido una direcci&oacute;n o nombre de estructura famosa{$_p}
			{$p}3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.{$_p}
			{$br}
			<p align="center">En menos de 3 minutos recibir&aacute; un email con la informaci&oacute;n pedida.</p>{$br}

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
			{%% email_client: {
        	 	wintitle: "Consultar el mapa",
	            asunto: "MAPA capitolio, cuba"
	         } %%}
		</td>
	</tr>
</table>
{$br}<hr/>{$br}

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">Clima, consultar el estado del tiempo</h3>
			{$p}1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:{$reply_to}">{$reply_to}</a>{$_p}
			{$p}2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">CLIMA</span>{$_p}
			{$p}3. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.{$_p}
			{$br}
			<p align="center">En menos de 3 minutos recibir&aacute; un email con el estado del tiempo.</p>{$br}

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
			{%% email_client: {
        	 	wintitle: "Consultar el Clima",
	            asunto: "CLIMA"
	         } %%}
		</td>
	</tr>
</table>
{$br}<hr/>{$br}

<table>
	<tr>
		<td valign="top">
			<h3 style="{$font}">SMS, mandar SMS nacional o internacional mediante su email a precio reducido</h3>
			{$p}1. Cree un correo nuevo. En la secci&oacute;n "Para" escriba: <a href="mailto:{$reply_to}">{$reply_to}</a>{$_p}
			{$p}2. En la secci&oacute;n "Asunto" escriba: <span style="color:green;">SMS</span> seguido del numero de tel&eacute;fono que recibir&aacute; el SMS{$_p}
			{$p}3. En el cuerpo del mensaje escriba el texto a enviar{$_p} 
			{$p}4. Haga clic en "Enviar", no necesita llenar ning&uacute;n otro campo.{$_p}
			<p align="center">En menos de 3 minutos recibir&aacute; un email de confirmaci&oacute;n y su contacto recibir&aacute; un SMS.</p>
			<p align="center">Para mandar un SMS internacional, necesita escribir el c&oacute;digo del pa&iacute;s delante del n&uacute;mero. Puede <a href="mailto:{$reply_to}?subject=SMS CODIGOS">ver una lista de c&oacute;digos aqu&iacute;</a>.</p>
			<p align="center">Para mandar SMS necesita cr&eacute;dito. Contacte a uno de nuestros vendedores enviando un email a <a href="mailto:credito@apretaste.com?subject=Hola,%20vivo%20en%20[PUEBLO%20O%20CIUDAD]%20y%20necesito credito,%20por%20favor%20contacteme%20a%20[EMAIL%20O%20TELEFONO]">credito@apretaste.com</a></p>
			
			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=SMS 5xxxxxx&body=Cambie 5xxxxxx en el asunto por el numero de su contacto, cambie este texto por algo que quiera decirle, y envie este email">
							<label style="margin: 5px;">Enviar un SMS</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" width="250">
			{%% email_client: {
        	 	wintitle: "Enviar un SMS",
	            asunto: "SMS 53336666",
				cuerpo: "Este es un mensaje SMS que ser&aacute; enviado a 53336666"
	         } %%}
			 {$br}
			 {%% email_client: {
        	 	wintitle: "C&oacute;digos de los pa&iacute;ses",
	            asunto: "SMS CODIGOS"
	         } %%}
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
{$br}{$br}

{$h1}Invite a sus amigos y familia{$_h1}
<table>
	<tr>
		<td valign="top">
			{$p}Invite a sus amigos y familia a conocer Apretaste.{$_p}
			{$p}Env&iacute;e un email a <a style="color:green;" href="mailto:{$reply_to}">{$reply_to}</a> y en el asunto escriba la palabra <span style="color:green;">INVITAR</span> seguida de la direcci&oacute;n email de su amigo.{$_p}
			{$br}
			{$br}
			{$p}En menos de 3 minutos le mandaremos un email de confirmaci&oacute;n.{$_p}
			
			<table align="center">
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=INVITAR email@deSuAmigo.cu">
							<label style="margin: 5px;">Invitar a un amigo ahora</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
			{%% email_client: {
        	 	wintitle: "Invitar a un amigo",
	            asunto: "INVITAR email@desuamigo.cu"
	         } %%}
		</td>
	</tr>
</table>