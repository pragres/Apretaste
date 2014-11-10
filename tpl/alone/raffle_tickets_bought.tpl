{= * AnswerSubject: "Tienes ahora nuevos tickets para la rifa!" =}

{$h1}{$AnswerSubject}{$_h1}

{$p}Usted ha comprado <b>{$count}</b> ticket(s) para la <a href="mailto:{$reply_to}?subject=RIFA">rifa en curso.</a>
{$br}{$br}
Ahora usted cuenta con un total de <b>{$tickets}</b> tickets.
{$_p}
{% raffle: {
	from: '<!--{ store_begin }-->',
	to: '<!--{ store_end }-->'
} %}
