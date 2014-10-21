{= path: index.php?path=admin&page=agency_bill =}
{= title: My bill =}
{= pagewidth: 1024 =}

{% layout %}
<!--{ begin }-->
{{blocks
	<div class="panel panel-success" style="width: {$width}; margin: auto;">
		<div class="panel-heading">
			<h3 class="panel-title">{$title}</h3>
		</div>
		<div class="panel-body">
			<p>Credit line: ${#agency.credit_line:2.#} <br/>
			Sold: ${#agency.sold:2.#} <br/>
			Owe: ${#agency.owe:2.#} <a href="index.php?path=admin&page=agency_help">{ico}help{/ico}</a></p>
			?$agency.owe <a href="#" class="button">Pay {#agency.owe:2.#} with PayPal</a> $agency.owe?
			<table width="100%"><tr><td width="49%"><hr/></td><td width="30">OR</td><td width="49%"><hr/></td></tr></table>
			<p align="center">Pay by check. Send your checks to Pragres Corporation, 3250 NW 13th Terr, Miami, Fl 33125</p>
		</div>
	</div>
blocks}}	
	
{{page
	
	{%% table: {
		data: $weeks,
		title: 'Details',
		hideColumns: {agency: true, month:true, payment: true, owe_cumul:true},
		headers: {year: "Date", soles: "Sales"},
		simple: true,
		wrappers: {
			year: '{$year}, {$month}',
			amount: '${#amount:2.#}',
			profit: '${#profit:2.#}',
			residuals: '${#residuals:2.#}',
			owe: '${#owe:2.#}'			
		}
	} %%}
page}}

<!--{ end }-->