{= path: "index.php?path=admin&page=dispatchers_reports" =}
{= title: "Dispatchers's reports" =}
{= pagewidth: 700 =}
{% layout %}

{{page

	{% dispatchers_panel %}
	
	{$br}
	{$h1}Recharges by card price (this month){$_h1}
		
	{= crosstable[]: {
		dispatchers: "<i>{$count:crosstable-dispatcher} dispatchers</i>",
		total3: "<b>{$sum:crosstable-3}</b>",
		total5: "<b>{$sum:crosstable-5}</b>",
		total10: "<b>{$sum:crosstable-10}</b>",
		total_recharges: "<b>{$sum:crosstable-total}</b>"
	} =}
	
	{%% table: {
		data: "crosstable",
		wrappers: {
			dispatcher: '<a href='index.php?path=admin&page=user_activity&user={$value}'>{$value}</a>',
			'*': '<center>{$value}</center>'
		},
		width: "100%"
	} %%}
	
	{$br}
	{$h1}Recharges by day (this month){$_h1}

	{= recharges_by_day[]: {
			summary: "<b>Total</b>",
			total_recharges: "",
			total_amount: ""
		}
	=}
	
	{%% table: {
		id: 'recharges_by_day',
		data: 'recharges_by_day',
		wrappers: {
			'*': '<center>{$value}</center>',
			recharges: '<div style="height: 20px; background: green; color: white; padding: 2px; width: (# {$value} / {$max:recharges_by_day-recharges} * 100 #)px;">{$value}</div>',
			amount: '<div style="text-align: right; width:100%;">${#value:2.#}</div>',
			total_amount: '<div style="text-align: right; width:100%;font-weight:bold;">${#sum:recharges_by_day-amount:2.#}</div>',
			total_recharges: '<center><b>{$sum:recharges_by_day-recharges}</b></center>'
		},
		width: "100%"
	} %%}
	
page}}