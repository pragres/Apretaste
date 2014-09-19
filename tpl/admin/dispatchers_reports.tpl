{= path: "index.php?path=admin&page=dispatchers_reports" =}
{= title: "Dispatchers's reports" =}
{% layout %}
{{blocks
<div class="panel panel-success" style="width: {$width}; margin: auto;">
	<div class="panel-heading">
		<h3 class="panel-title">Recharges by price</h3>
	</div>
	<div class="panel-body">
	<img src="index.php?path=admin&chart=dispatchers_recharges_by_card_price" style="margin-left:-140px;margin-top: -70px;">
	</div>
</div>
blocks}}
{{page

	<h2>Recharges by card price (this month)</h2>
		
	{= crosstable[]: {
		dispatchers: "<i>{$count:crosstable-dispatcher} dispatchers</i>",
		total3: "<b>{$sum:crosstable-3}</b>",
		total5: "<b>{$sum:crosstable-5}</b>",
		total10: "<b>{$sum:crosstable-10}</b>",
		total_recharges: "<b>{$sum:crosstable-total}</b>"
	} =}
	
	
	{%% table: {
		data: $crosstable,
		wrappers: {
			dispatcher: '<a href='index.php?path=admin&page=user_activity&user={$value}'>{$value}</a>',
			'*': '<center>{$value}</center>'
		},
		width: "100%"
	} %%}
	
	<br/>
	<h2>Recharges by day (this month)</h2>

	{= recharges_by_day[]: {
			summary: "<b>Total</b>",
			total_recharges: "",
			total_amount: ""
		}
	=}
	
	{%% table: {
		id: 'recharges_by_day',
		data: $recharges_by_day,
		wrappers: {
			'*': '<center>{$value}</center>',
			recharges: '<div style="height: 20px; background: green; color: white; padding: 2px; width: (# {$value} / {$max:recharges_by_day-recharges} * 100 #)px;">{$value}</div>',
			amount: '<div style="text-align: right; width:100%;">${#value:2.#}</div>',
			total_amount: '<div style="text-align: right; width:100%;font-weight:bold;">${#sum:recharges_by_day-amount:2.#}</div>',
			total_recharges: '<center><b>{$sum:recharges_by_day-recharges}</b></center>'
		},
		width: "100%"
	} %%}
	
	{$br}
	<h2>Recharges by month (quantity)</h2>
	<img src="index.php?path=admin&chart=dispatchers_recharges_by_month"  width="100%" height="70%">
	
	{$br}
	<h2>Recharges by month (amount)</h2>
	<img src="index.php?path=admin&chart=dispatchers_recharges_by_month_amount" width="100%" height="70%">
	
page}}