{= path: index.php?path=admin&page=dispatchers_payment_warning&dispatcher={$div.get.dispatcher} =}
{= title: Payment warning for <i>{$div.get.dispatcher}</i> =}

{% layout %}

{{blocks
	{%% dispatcher_block: $dispatcher %%}
blocks}}

{{page
	

	{%% table: {
		data: $payment_warning.cards,
		hideColumns: {dispatcher: false, amount_cumul: true},
		headers: {
			user_email: "User"			
		},
		title: 'Recharges without payment from <b>{$payment_warning.from_date}</b> to <b>{$payment_warning.to_date}</b>',
		wrappers: {
			user_email: '<a href="index.php?path=admin&page=user_activity&user={$value}">{$value}</a>',
			price: '${#price:2.#}',
			code: '{$code:0,4} {$code:4,4} {$code:8,4}',
			owe: '${#owe:2.#}',
		},
		footer: "Total owe: ${#sum:payment_warning.cards-owe:2.#}"
	} %%}
page}}