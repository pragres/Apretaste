{= *AnswerSubject: Su anuncio '{$title:40}...' ha sido publicado satisfactoriamente =}

<p align="justify" style="{$font}">Su anuncio con t&iacute;tulo <strong>"{$title}"</strong> se ha publicado satisfactoriamente. A partir de ahora aparecer&aacute;
entre nuestros resultados de b&uacute;squeda. Le recomendamos que lea nuestros <a href="mailto:{$reply_to}?subject=TERMINOS&body=Ahora haga clic en Enviar">t&eacute;rminos de uso</a>
y aprenda adem&aacute;s las ventajas que tiene utilizar este servicio. Ahora se muestran algunos detalles de su anuncio. </p><br/>
<span>Fecha de publicaci&oacute;n: <b>{$post_date}</b> </span><br/><br/>
<span>Identificador del anuncio: <b>{$id}</b></span><br/><br/>
<span>Ticket del anuncio: <b>{$ticket}</b> (Esto es secreto, gu&aacute;rdelo y no lo comparta)</span><br/><br/>

!$contact_info
<p align="justify" style="{$font}; border: 1px solid gray; padding: 5px;"><b>IMPORTANTE: No hemos dectectado informaci&oacute;n de contacto en su anuncio, como pueden ser t&eacute;lefonos y/o direcciones de
correo electr&oacute;nico. Considere <a href="mailto:{$reply_to}?body={$body}&subject=CAMBIAR {$ticket} {$title}">cambiar su anuncio</a>.</b></p>
$contact_info!
<p align="justify" style="{$font}">Su anuncio se mantendr&aacute; publicado durante 30 d&iacute;as a partir de la fecha de publicaci&oacute;n. El identificador del anuncio
es un dato p&uacute;blico y ser&aacute; utilizado por usted y por otros para obtener todos los detalles de su anuncio. El ticket es un
identificador secreto que solo ser&aacute; posible utilizar por usted cuando desee
<a href="mailto:{$reply_to}?subject=QUITAR {$ticket}&body=Ahora haga clic en Enviar">QUITAR</a> o
<a href="mailto:{$reply_to}?subject=CAMBIAR {$ticket} {$title}&body={$body}">CAMBIAR</a> su anuncio.</p>
<span style="{$font};font-size:small; float: left;">
	<a href="mailto:{$reply_to}?subject=ANUNCIO {$id}">Ver el anuncio</a>{$splitter}
	<a href="mailto:{$reply_to}?subject=CAMBIAR {$ticket} {$title}&body={$body}">Cambiar el anuncio</a>{$splitter}
        <a href="mailto:{$reply_to}?subject=QUITAR {$ticket}">Quitar el anuncio</a>
	
</span>

?$search_results
<br><hr>
<p align="justify" style="{$font}">Los siguientes anuncios fueron encontrados pues guardan relaci&oacute;n con el suyo y pueden
ayudarle en su {$oferta}.</p>
{% search_results %}
<hr>
$search_results?