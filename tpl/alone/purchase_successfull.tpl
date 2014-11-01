{= *AnswerSubject: "El pago fue realizado con &eacute;xito" =}

{$h1}{$AnswerSubject}{$_h1}

{$p}La compra fue efectuada con &eacute;xito. El producto comprado ser&aacute; entregado a usted por el 
vendedor y/o le llegar&aacute; por esta v&iacute;a en caso de ser un recurso digital (archivo).{$_p}

{$h2}Producto comprado{$_h2}

{% sale: {
	from: '<!--{ begin }-->',
	to: '<!--{ end }-->'
} %}

{$h2}Su cr&eacute;dito:{$_h2}
{$p}Su cr&eacute;dito actual es de <b>${#credit:2.#}</b>.{$_p}
{$hr}
{$br}