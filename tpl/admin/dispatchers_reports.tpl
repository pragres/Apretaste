{= path: "index.php?path=admin&page=dispatchers_reports" =}
{= title: "Dispatchers's reports" =}

{% layout %}

{{blocks

	{%% chart_block_pie: {
		id: "recharges_by_price",
		data: $recharges_by_price,
		title: "Recharges by price"
	} %%}

blocks}}

{{page

	{= crosstable[]: {
		dispatchers: "<i>{$count:crosstable-dispatcher} dispatchers</i>",
		total3: "<b>{$sum:crosstable-3}</b>",
		total5: "<b>{$sum:crosstable-5}</b>",
		total10: "<b>{$sum:crosstable-10}</b>",
		total_recharges: "<b>{$sum:crosstable-total}</b>"
	} =}
	
	
	{%% table: {
		data: $crosstable,
		title: "Recharges by card price (this month)",
		wrappers: {
			dispatcher: '<a href='index.php?path=admin&page=user_activity&user={$value}'>{$value}</a>',
			'*': '<center>{$value}</center>'
		},
		width: "100%"
	} %%}
	
	<br/>
	
	{= recharges_by_day[]: {
			summary: "<b>Total</b>",
			total_recharges: "",
			total_amount: ""
		}
	=}
	
	{%% table: {
		id: 'recharges_by_day',
		data: $recharges_by_day,
		title: 'Recharges by day (this month)',
		wrappers: {
			'*': '<center>{$value}</center>',
			recharges: '<div class="progress" style="margin-bottom: 0px;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="(# {$value} / {$max:recharges_by_day-recharges} * 100 #)" aria-valuemin="0" aria-valuemax="100" style="width: (# {$value} / {$max:recharges_by_day-recharges} * 100 #)%"><span>{$value}</span></div></div>',
			amount: '<div style="text-align: right; width:100%;">${#value:2.#}</div>',
			total_amount: '<div style="text-align: right; width:100%;font-weight:bold;">${#sum:recharges_by_day-amount:2.#}</div>',
			total_recharges: '<center><b>{$sum:recharges_by_day-recharges}</b></center>'
		},
		width: "100%"
	} %%}
	
	<br/>
	
	{%% chart_line: {
		id: "recharges_quantity_chart",
		data: $recharges_quantity,
		title: "Recharges by month (quantity)" 
	} %%}

	<br/>

	{%% chart_line: {
		id: "recharges_amount_chart",
		data: $recharges_amount,
		title: "Recharges by month (amount)" 
	} %%}
	
page}}