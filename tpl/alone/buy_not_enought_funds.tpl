{= *AnswerSubject: "Cr&eacute;dito insuficiente para efectuar la compra" =}

{$h1}{$AnswerSubject}{$_h1}

{$p}La compra no se puede efectuar porque usted no tiene cr&eacute;dito suficiente. Su cr&eacute;dito actual es de <b>${#credit:2.#}</b>. {$_p}

?$sale
{$h2}Producto que quizo comprar{$_h2}
{% buy_successfull: {
	from: '<!--{ begin }-->',
	to:  '<!--{ end }-->'
} %}
$sale?