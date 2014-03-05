<p align="justify" style="{$font}; text-align: justify;">
De manera general, usted siempre enviar&aacute; un correo con una orden y el sistema le devolver&aacute; la respuesta de su petici&oacute;n por la misma v&iacute;a, como
si estuviese intercambiando correos con otra persona. Para su facilidad, existen dos comportamientos b&aacute;sicos del servicio:<br/><br/>
1. Si usted env&iacute;a <a href="mailto:{$reply_to}">un correo en blanco</a> (sin asunto ni cuerpo), se le devolver&aacute; esta ayuda. <br/><br/>
2. Si usted env&iacute;a un correo sin ninguna de las palabras claves al inicio del asunto, se tomar&aacute; el asunto como una frase de b&uacute;squeda y se le devolver&aacute;n los resultados.
</p>
<p align = "justify" style="{$font}">La tabla a continuaci&oacute;n muestra como interactuar con las diferentes opciones de Apretaste!com. 
Env&iacute;e sus correos a <a href ="mailto:{$reply_to}">{$reply_to}</a>.</p>
<table width="790" cellpadding="5" style="{$font}">
	<tr>
		<th width = "33%">Asunto del correo</th>
        <th>Cuerpo del correo</th>
		<th width = "40%">Breve explicaci&oacute;n de la opci&oacute;n</th>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>PUBLICAR</strong> T&iacute;tulo del anuncio.<br/>
                </td>
                <td valign="top">
                Descripci&oacute;n de su anuncio, especificando detalles del producto o servicio que brinda o solicita.
                Opcionalmente una imagen de su anuncio, como adjunto del correo, que no sobrepase los 300Kb de tama&ntilde;o.
                </td>
				<td valign="top" style="text-align:justify;" align="justify">Publique un nuevo anuncio usando como t&iacute;tulo el
				especificado en el asunto del correo y como descripci&oacute;n el cuerpo del mensaje.
				Retorna un correo de confirmaci&oacute;n conteniendo el identificador y el ticket del
				anuncio. El ticket es un c&oacute;digo secreto para que usted en otro momento pueda borrar o modificar su anuncio.</td>
	</tr>
	<tr>
		<td valign="top">
                <strong>ANUNCIO</strong> identificador del anuncio
                </td>
                <td valign="top">
                 - en blanco -
                </td>
				<td valign="top" align="justify">Devuelve todos los datos del anuncio cuyo identificador es escrito en el asunto.</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>QUITAR</strong> ticket de su anuncio
                </td>
                <td valign="top">
                 - en blanco -
                </td>
				<td valign="top" style="text-align:justify;" align="justify">Quita su anuncio cuyo ticket corresponda con el contenido del asunto. El
                ticket es secreto y no debe compartirse.</td>
	</tr>
	<tr>
		<td valign="top">
                <strong>CAMBIAR</strong> ticket de su anuncio NUEVO TITULO
                </td>
                <td valign="top">
                Nueva descripci&oacute;n de su anuncio. Opcionalmente una nueva imagen de su anuncio que no sobrepase los 300Kb de tama&ntilde;o
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Modifica el anuncio cuyo ticket corresponda con el
		asunto. El ticket de un anuncio puede encontrarse al consultar su ESTADO.
		El mismo es secreto y no debe compartirse.</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>BUSCAR</strong> frase de b&uacute;squeda
                </td>
                <td valign="top">
                - en blanco -
                </td>
				<td valign="top" style="text-align:justify;" align="justify">Devuelve un correo con los diez primeros resultados m&aacute;s
				relevantes a la frase buscada acompa&ntilde;ados de una imagen,
				informaci&oacute;n de contacto y descripci&oacute;n corta.
				</td>
				
	</tr>
	<tr>
		<td valign="top">
                <strong>BUSCARTODO</strong> frase de b&uacute;squeda
                </td>
                <td valign="top">
                - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve un correo con los 50 primeros resultados m&aacute;s
		relevantes a la frase buscada. Dicho correo no contendr&aacute; imagenes ni descripci&oacute;n, solo el t&iacute;tulo y la
		informaci&oacute;n de contacto</td>		
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                 <strong>ALERTA</strong> frase de b&uacute;squeda<br/>
                </td>
                <td valign="top">
                - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Le suscribe a la opci&oacute;n de b&uacute;squedas
		autom&aacute;ticas, alertando por correo de nuevos anuncios publicados que coincidan con la frase de b&uacute;squeda dada.
        La frase de b&uacute;squeda puede ser la direcci&oacute;n de correo electr&oacute;nico de otro usuario.</td>
	</tr>
	<tr>
		<td valign="top">
                <strong>DETENER</strong> identificador de alerta
                </td>
                <td valign="top">
                - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Detener la subscripci&oacute;n de una alerta por correo. El identificador
		de la alerta puede conocerlo consultando <a href="mailto:{$reply_to}&subject=ESTADO&body=Ahora haga clic en Enviar">su estado</a>.</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>ESTADO</strong>
                </td>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve un reporte con la lista de sus anuncios, las alertas por correo a las cuales Ud. est&aacute; subscrito,
		entre otras informaciones, junto a algunas estad&iacute;sticas de sus anuncios.</td>
	</tr>
	<tr>
		<td valign="top">
                <strong>INVITAR</strong> direcci&oacute;n email de su amigo<br/>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Invita a su amigo cuya direcci&oacute;n de correo
		corresponda con el asunto. Apretaste!com le enviar&aacute; un correo de bienvenida a su amigo y le
                notificar&aacute; que usted lo ha invitado.</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>AYUDA</strong>
                </td>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve un correo con la ayuda del servicio,
                con explicaciones de c&oacute;mo usar las distintas opciones del servicio.</td>
	</tr>
	<tr>
		<td valign="top">
                <strong>EXCLUYEME</strong>
                </td>
                <td valign="top">
                - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Excluir su direcci&oacute;n de correo electr&oacute;nico de los servicios de Apretaste!com. Para
		ser incorporado nuevamente, basta con seguir utilizando el servicio.</td>
	</tr>
        <tr style="background:#eeeeee;">
		<td valign="top">
                <strong>BUZONES</strong>
                </td>
                <td valign="top">
                - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve la lista de buzones de correo electr&oacute;nico activos a los cuales usted puede escribir para utilizar Apretaste!com.</td>
	</tr>
</table>