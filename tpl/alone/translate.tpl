{= *AnswerSubject: $title =}
?$missing_text
	No nos envi&oacute; el texto a traducir.
@else@
<p>

<h2 style="{$font}">{$title}</h2>

<p  style="{$font};">
<b>Texto traducido ({$blto}):</b><br/>
{br:textto}
</p>

<p  style="{$font}">
<b>Texto original ({$blfrom}):</b><br/>
{br:textfrom}
</p>

?$meanings
<hr/>
<h2 style="{$font}">Significados</h2>
{$meanings}
$meanings?
<hr/>
<h2 style="{$font}">Interactivo</h2>
<p style="{$font}">
<b>Texto traducido ({$blto}):</b><br/>
{$richtextto}
</p>
<p style="{$font}">
<b>Texto original ({$blfrom}):</b><br/>
{$richtextfrom}
</p>
<h2 style="{$font}">Variantes de traducci&oacute;n</h2>
{$variants}
$missing_text?