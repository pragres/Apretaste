{= *AnswerSubject: Su anuncio '{$title:40}...' ha sido publicado satisfactoriamente =}
{$h1}{$AnswerSubject}{$_h1}
{$p}Su anuncio se mantendr&aacute; p&uacute;blico durante 30 d&iacute;as. A partir de ahora aparecer&aacute;
entre nuestros resultados de b&uacute;squeda. Le recomendamos que lea nuestros <a href="mailto:{$reply_to}?subject=TERMINOS&body=Ahora haga clic en Enviar">t&eacute;rminos de uso</a>
y aprenda adem&aacute;s las ventajas que tiene utilizar este servicio.{$_p}

{$h2}Detalles del anuncio{$_h2}
<span>Fecha de publicaci&oacute;n: <b>{$post_date}</b> </span>{$br}
<span>Identificador del anuncio: <b>{$id}</b></span>{$br}
<span>Ticket del anuncio: <b>{$ticket}</b> <i>(Esto es secreto, gu&aacute;rdelo y no lo comparta)</i></span>{$br}

{$p}El <i>identificador</i> del anuncio
es un dato p&uacute;blico y ser&aacute; utilizado por usted y por otros para obtener todos los detalles de su anuncio. 
El <i>ticket</i> es un identificador secreto que solo ser&aacute; posible utilizar por usted cuando desee <b>quitar</b> o
<b>cambiar</b> su anuncio.{$_p}

!$contact_info
{$h2}Importante{$_h2}
{$p}No hemos dectectado informaci&oacute;n de contacto en su anuncio, como pueden ser t&eacute;lefonos y/o direcciones de
correo electr&oacute;nico. Considere cambiar su anuncio.{$_p}
$contact_info!

<a href="mailto:{$reply_to}?subject=ANUNCIO%20{$id}">Ver el anuncio</a>{$separatorLinks}
<a href="mailto:{$reply_to}?subject=CAMBIAR%20{$ticket}%20{&&title}&body={&&body}">Cambiar el anuncio</a>{$separatorLinks}
<a href="mailto:{$reply_to}?subject=QUITAR%20{$ticket}">Quitar el anuncio</a>	


?$search_results
<br><hr>
<p align="justify" style="{$font}">Los siguientes anuncios fueron encontrados pues guardan relaci&oacute;n con el suyo y pueden
ayudarle en su {$oferta}.</p>
{% search_results %}
<hr>
$search_results?