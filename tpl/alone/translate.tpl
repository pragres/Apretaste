{= *AnswerSubject: $title =}
?$missing_text
	No nos envi&oacute; el texto a traducir.
@else@
	{$h1}Traducci&oacute;n directa:{$_h1}

	?$toobig 
	{$p}El texto original ha sido cortado por ser demasiado grande (>100Kb){$_p}
	$toobig?
	
	{$p}<b>Texto traducido ({$blto}):</b>{$br}{br:textto}{$_p}
	{$p}<b>Texto original ({$blto}):</b>{$br}{br:textfrom}{$_p}
	
	?$meanings
		{$h2}Significados{$_h2}
		{$meanings}
	$meanings?

	{$h1}Traducci&oacute;n interactiva:{$_h1}
	{$p}Pase el mouse sobre las palabras para ver variantes de traducci&oacute;n.{$_p}
	{$p}<b>Texto traducido ({$blto}):</b>{$br}{$richtextto}{$_p}
	{$p}<b>Texto original ({$blfrom}):</b>{$br}{$richtextfrom}{$_p}

$missing_text?