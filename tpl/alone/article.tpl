{= *AnswerSubject: $title =}
<hr/>
?$article_body
	!$showimages
		<p style="{$font};color:red;">
		Este art&iacute;culo es demasiado grande para ser enviado por email. Apretaste ha eliminado 
		las im&aacute;genes para hacer posible que personas con conexiones limitadas lo reciban.
		</p>
		<hr/>
	$showimages!
	{$h1}{$title}{$_h1}
	{$article_body}
@else@
	{$p}No se encontraron art&iacute;culos para <b>{$query}</b>{$_p}
$article_body?
{$hr}