{= *AnswerSubject: $title =}
?$missing_text
	No nos envi&oacute; el texto a traducir.
@else@
	{$h1}Traducci&oacute;n directa:{$_h1}

	{$p}<b>Texto traducido ({$blto}):</b>{$br}{br:textto}{$_p}
	
	?$meanings
		{$h2}Significados{$_h2}
		{$meanings}
	$meanings?

	{$h1}Traducci&oacute;n interactiva:{$_h1}
	{$p}<b>Texto traducido ({$blto}):</b>{$br}{$richtextto}{$_p}
	{$p}<b>Texto original ({$blfrom}):</b>{$br}{$richtextfrom}{$_p}

	{$h2}Variantes de traducci&oacute;n{$_h2}
	{$variants}
$missing_text?