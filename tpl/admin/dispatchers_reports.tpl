{= path: "index.php?path=admin&page=dispatchers_reports" =}
{= title: "Dispatchers's reports" =}
{= pagewidth: 700 =}
{% layout %}

{{page

	{% dispatchers_panel %}
	
	{$h1}Recharges by card price{$_h1}
	
	{%% table: {
		data: "crosstable",
		wrappers: {
			dispatcher: '<a href='index.php?path=admin&page=user_activity&user={$value}'>{$value}</a>',
			3: '<center>{$value}</center>',
			5: '<center>{$value}</center>',
			10: '<center>{$value}</center>',
			total: '<center>{$value}</center>'
		}
	} %%}
	
	{$h1}Recharges by day (this month){$_h1}
	{%% table: {
		data: 'recharges_by_day',
		wrappers: {
			total: '<div style="height: 20px; background: green; color: white; padding: 2px; width: (# {$value} / {$max:recharges_by_day-total} * 100 #)px;">{$value}</div>',
			amount: '${#value:2.#}'			
		}
	} %%}
page}}