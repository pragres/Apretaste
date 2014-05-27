{= *AnswerSubject: $title =}
<hr/>
?$body
	!$showimages
		<p style="{$font};color:red;">
		Este art&iacute;culo es demasiado grande para ser enviado por email. Apretaste ha eliminado 
		las im&aacute;genes para hacer posible que personas con conexiones limitadas lo reciban.
		</p>
		<hr/>
	$showimages!
	{$h1}{$title}{$_h1}
	{$body}
@else@
	{$p}No se encontraron art&iacute;culos para <b>{$query}</b>{$_p}
$body?
{$hr}