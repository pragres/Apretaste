{= title: Cards of <i>{$dispatcher.email}</i> =}
{= path: "index.php?path=admin&page=dispatchers_cards&sales={$dispatcher.email}&cards={$sale}" =}

{% layout %}

{{blocks
	{%% dispatcher_block: $dispatcher %%}
blocks}}

{{page
<a href="index.php?path=admin&page=dispatchers_card_sales&sales={$dispatcher.email}">&lt;&lt; Sales</a><br/>

{%% table: {
	data: $cards,
	hideColumns: {profit_percent: true, sale: true},
	headers: {
		recharge_date: "Recharge date"
	},
	wrappers: {
		code: '{$code:0,4}&nbsp;{$code:4,4}&nbsp;{$code:8,4}&nbsp;',
		amount: '${#amount:2.#}',
		email: '?$email <a href="index.php?path=admin&page=user_activity&user={$email}">{$email}</a> @else@ - still - $email?',
		recharge_date: '?$recharge_date {$recharge_date} @else@ - still -$recharge_date?'
	},
	footer: 'Total amount: <b>$(# {$sum:cards-amount} :2.#)</b>'
} %%}

page}}