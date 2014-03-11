{% logohtml %}
<br/>
?$content
{% content %}
$content?
<br/>
<font size="2" style="{$font}">
	<a href="mailto:{$reply_to}?subject=BUSCAR &body={$body_search}" title="Realiza una nueva b&uacute;squeda">Iniciar nueva b&uacute;squeda</a>
	{$splitter}
	<a href="mailto:{$reply_to}?subject=PUBLICAR Titulo del anuncio&body={$body_insert}">Publicar un anuncio</a>
	{$splitter}
	<a href="mailto:{$reply_to}?subject=INVITAR direccion@de.correo.de.su.amigo&body=Escriba en el asunto el correo electr&oacute;nico de su amigo despu&eacute;s de la palabra INVITAR" title="Env&iacute;a un correo a un amigo coment&aacute;ndole sobre nuestro servicio e invit&aacute;ndole a usarlo">Invitar a un amigo</a>
</font>
<br/><br/><hr style="border:1px dashed #5DBD00;"/>	
<font size="2" style="{$font}">
	<p>Escr&iacute;banos sus dudas, opiniones y sugerencias a <a href="mailto:soporte@apretaste.com?subject=Escriba en el asunto su inquietud o sugerencia, o motivo por el cual nos escribe&body=Explique en el cuerpo del mensaje, detalladamente lo que necesita o sugiere.">soporte@apretaste.com</a>. 
	{?( '{$answer_type}' != 'terms' )?}
            Lea nuestros <a href="mailto:{$reply_to}?subject=TERMINOS&body=Ahora haga clic en Enviar">T&eacute;rminos de uso</a>. <br/>
    {/?}
</font>