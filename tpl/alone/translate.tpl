{= *AnswerSubject: $title =}
?$missing_text
	No nos envi&oacute; el texto a traducir.
@else@
<p>

<h2 style="{$font}">Traducci&oacute;n:</h2>

<p  style="{$font}; padding: 5px; border: 1px solid gray;">
<b>Texto traducido ({$blto}):</b><br/>
{br:textto}
</p>

<p  style="{$font}">
<b>Texto original ({$blfrom}):</b><br/>
{br:textfrom}
</p>

<hr/>
?$meanings
<h2 style="{$font}">Significados</h2>
{$meanings}
$meanings?
<h2 style="{$font}">Texto interactivo</h2>
<p style="{$font}">
<b>Texto original ({$blfrom}):</b><br/>
{$richtextfrom}
</p>
<hr/>
<p style="{$font}">
<b>Texto traducido ({$blto}):</b><br/>
{$richtextto}
</p>
<h2 style="{$font}">Variantes de traducci&oacute;n</h2>
{$variants}
$missing_text?