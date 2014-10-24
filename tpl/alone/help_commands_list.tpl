{$p}
La tabla a continuaci&oacute;n muestra como interactuar con las diferentes opciones de Apretaste!. 
Si tiene dudas de c&oacute;mo utilizar algunos de los siguientes servicios, escr&iacute;banos a <a href="mailto:soporte@apretaste.com">soporte@apretaste.com</a> y con gusto le explicaremos.
{$_p}
<table cellpadding="5" style="{$font}">
	<tr>
		<th width = "33%">Asunto del correo</th>
        <th>Cuerpo del correo</th>
		<th width = "40%">Breve explicaci&oacute;n de la opci&oacute;n</th>
	</tr>
	
	<!--{ ----------------------------------------------------------------- }-->
	<tr><td colspan="3" align="center" style="font-size: 24px;"><b>Compra/Venta</b></td></tr>
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
	
	<!--{ ----------------------------------------------------------------- }-->
	<tr><td colspan="3"  align="center" style="font-size: 24px;"><b>Entretenimiento y juegos</b></td></tr>
	<tr>
		<td valign="top">
                <strong>CHISTE</strong>
                </td>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve un chiste</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>SUDOKU</strong>
                </td>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve un SUDOKU para jugar. Puede responderlo en el mismo correo o imprimirlo si desea.</td>
	</tr>
	
	<!--{ ----------------------------------------------------------------- }-->
	<tr><td colspan="3"  align="center" style="font-size: 24px;"><b>Acad&eacute;micos</b></td></tr>
	<tr>
		<td valign="top">
                <strong>ARTICULO frase de b&uacute;squeda</strong>
                </td>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Busca el art&iacute;culo m&aacute;s relevante en Wikipedia.org seg&uacute;n la frase de b&uacute;squeda puesta en el asunto del correo.</td>
	</tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <b>TRADUCIR</b> idioma-del-texto<i>(opcional)</i> idioma-a-obtener<i>(opcional)</i>
                </td>
                <td valign="top">
                    Texto a traducir
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Traduce un texto a un idioma dado. <ul>
		<li>Si se omiten ambos idiomas,	se detecta el idioma del texto autom&aacute;ticamente y se traduce al espa&ntilde;ol. Si el idioma detectado es el espa&ntilde;ol, se traduce al ingl&eacute;s.</li> 
		<li>Si se especifica un solo idioma, se detecta el del texto y se traduce a ese idioma. </li>
		<li>Si se especifican los dos idiomas, entonces el primer idioma es el del texto y el segundo el que se desea obtener.</li>
		</ul></td>
	</tr>
	<tr>
		<td valign="top">
                <b>MAPA</b> tipo<i>(opcional)</i> profundidad<i>(opcional)</i> localizaci&oacute;n (obligatorio) <br/>
                Ejemplos:<br/><br/>
                Dirección: <br/><a href="mailto:{$reply_to}?subject=MAPA 1600 Amphitheatre Parkway Mountain View CA">MAPA 1600 Amphitheatre Parkway Mountain View CA</a><br/><br/>
				Buscar en las inmediaciones: <br/><a href="mailto:{$reply_to}?subject=MAPA cafetería cerca de central park">MAPA cafetería cerca de central park</a><br/><br/>
				Lugar: <br/><a href="mailto:{$reply_to}?subject=MAPA Aeropuerto de Madrid">MAPA Aeropuerto de Madrid</a><br/><br/>
				Accidente geográfico: <br/><a href="mailto:{$reply_to}?subject=MAPA Monte Everest, Nepal">MAPA Monte Everest, Nepal</a><br/><br/>
				Coordenadas: <br/><a href="mailto:{$reply_to}?subject=MAPA 82 21 22.08 W,23 8 40.69 N">MAPA 82 21 22.08 W,23 8 40.69 N</a><br/><br/>
                </td>
                <td valign="top">
                   - en blanco - 
                </td>
		<td valign="top" style="text-align:justify;" align="justify">
		<p>Devuelve una imagen con el mapa de la localizaci&oacute;n especificada en el asunto. Los <b>tipos de mapas</b> son: 
		<ul>
			<li><i>fisico</i>: imagen satelital <a href="mailto:{$reply_to}?subject=MAPA fisico habana">(ejemplo)</a></li>
			<li><i>politico</i>: calles y lugares <a href="mailto:{$reply_to}?subject=MAPA politico vedado,habana">(ejemplo)</a></li>
			<li><i>terreno</i>: calles con delimitaciones de los terrenos <a href="mailto:{$reply_to}?subject=MAPA terreno capitolio,habana">(ejemplo)</a></li>
			<li><i>hibrido</i>: mezcla entre fisico y politico <a href="mailto:{$reply_to}?subject=MAPA 12x capitolio, habana">(ejemplo)</a></li>
		</ul>
		<p>Por defecto el mapa devuelto es de tipo h&iacute;brido.</p>
		<p>La <b>profundidad</b> se especifica con un n&uacute;mero entre 1 y 20 seguido de una x, por ejemplo 1x, 2x o 20x. Mientras 
		m&aacute;s grande sea el n&uacute;mero, m&aacute;s cerca del nivel del mar se ver&aacute; el mapa.</p>
		<p>La <b>localizaci&oacute;n</b> puede ser de 2 tipos:</p>
		<ul>
			<li><i>Coordenadas</i>: Se especifican la longitud y la latitud separados por una coma. Los formatos aceptados para las coordenadas son:			
			<ul>
    			<li>Grados, minutos y segundos (DMS): <b>MAPA 82 21 22.08 W,23 8 40.69 N</b></li>
    			<li>Grados y minutos decimales (DMM): <b>MAPA 82 21.368 W,23 8.678 N</b><a href="mailto:{$reply_to}?subject=MAPA 82 21.368 W,23 8.678 N">(ejemplo)</a></li>
    			<!--{ <li>Grados decimales (DDD): <b>MAPA -82.356133,23.144636</b><a href="mailto:{$reply_to}?subject=MAPA -82.356133,23.144636">(ejemplo)</a></li> }-->
			</ul>
		
			<!--{ <p>También puede convertir de una notación a otra. Por ejemplo:</p>

			<ul>
			<li>De DMS a DMM: grado (minuto + segundo/60)</li>
			<li>De DMS a DDD: (grado + minuto / 60 + segundo / 3600)</li>
			</ul>
			}-->
			</li>
			<li><i>Descriptiva</i>: dirección, ciudad, pa&iacute;s o lugar conocido. Por ejemplo: <i>Capitolio, Habana, Cuba</i>. Tambi&eacute;n puedes usar el t&eacute;rmino "cerca" para buscar una categor&iacute;a de lugares 
		cerca de una ubicaci&oacute;n. Por ejemplo, "cafeter&iacute;a cerca del parque del Retiro" devolver&aacute; 
		sitios para tomar un caf&eacute; cerca del parque.</li>
		</ul>
		
		</td>
	</tr>
	
	<!--{ ----------------------------------------------------------------- }-->
	<tr><td colspan="3" align="center" style="font-size: 24px;"><b>Comunicaciones</b></td></tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
                <strong>SMS</strong> [codigo del pais][numero de celular]<br/>
                </td>
                <td valign="top">
                    Texto del mensaje
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Env&iacute;a un SMS al n&uacute;mero 
		de celular especificado en el asunto. El c&oacute;digo del pa&iacute;s debe ir delante del 
		n&uacute;mero de celular. El c&oacute;digo por defecto es el de Cuba +53. Por ejemplo: Cuba es +535#######, Espa&ntilde;a +34#########..., USA +1###########..., etc.</td>
	</tr>
	<tr>
		<td valign="top">
                <strong>SMS</strong> CODIGOS<br/>
                </td>
                <td valign="top">
                    - en blanco -
                </td>
		<td valign="top" style="text-align:justify;" align="justify">Devuelve la lista de los c&oacute;digos de cada pa&iacute;s para enviar SMS. </td>
	</tr>
	<!--{ ----------------------------------------------------------------- }-->
	<tr><td colspan="3" align="center" style="font-size: 24px;"><b>Estar informado</b></td></tr>
	<tr style="background:#eeeeee;">
		<td valign="top">
			<strong>CLIMA</strong>
		</td>
        <td valign="top">
                    ciudad, pais
        </td>
		<td valign="top" style="text-align:justify;" align="justify">
		Devuelve el estado del tiempo y el pron&oacute;stico para los pr&oacute;ximos d&iacute;as, por defecto de Cuba si no se especifica la ciudad.
		Trate de poner el nombre de la ciudad en Ingl&eacute;s. Por ejemplo "Moscu" es una ciudad en Colombia, y "Moscow" es una ciudad en Rusia.
		Tambien permite ver las im&aacute;genes de sat&eacutelites, de radares y de servicios internacionales de meteorolog&iacute;a.</td>
	</tr>
	
	<!--{ ----------------------------------------------------------------- }-->
	<tr><td colspan="3" align="center" style="font-size: 24px;"><b>Otros servicios</b></td></tr>
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