<hr/>
?$body
	!$showimages
		<p style="{$font};color:red;">
		Este arti&iacute;culo es demasiado grande para ser enviado por email. Apretaste ha eliminado 
		las im&aacute;genes para hacer posible que personas con conexiones limitadas lo reciban.
		</p>
		<hr/>
	$showimages!
	<h1 style="{$element-h1};{$font}">{$title}</h1>
	{$body}
@else@
	<p style="{$font}">No se encontraron art&iacute;culos para <b>{$query}</b></p>
$body?
<hr/>