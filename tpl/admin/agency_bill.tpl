{= path: "?q=agency_bill" =}
{= title: '<span class="glyphicon glyphicon-list-alt"></span> My bill' =}
{= pagewidth: 1024 =}

{% layout %}
<!--{ begin }-->
{{blocks
	<div class="panel panel-success" style="width: {$width}; margin: auto;">
		<div class="panel-heading">
			<h3 class="panel-title">{$agency.name}</h3>
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

?$weeks
	{{page
		
		{%% table: {
			id: "tableBillDetails",
			data: $weeks,
			title: '<span class="glyphicon glyphicon-list"></span> Details',
			hideColumns: {agency: true, month:true, payment: true, owe_cumul:true},
			headers: {year: "Date", soles: "Sales"},
			simple: true,
			wrappers: {
				year: '{$months.{$month}}, {$year}',
				amount: '${#amount:2.#}',
				profit: '${#profit:2.#}',
				residuals: '${#residuals:2.#}',
				owe: '${#owe:2.#}'			
			},
			footer: '<b>${#sum:weeks-owe:2.#}</b> owes - <b>${#sum:weeks-residuals:2.0#}</b> residuals = <b>${#agency.owe:2.#}</b> current owe',
			div: {
				clear_locations: false
			}
		} %%}
		
		<br/>
		<a href="{$path}&download=bill?$div.get.zoom&zoom={$div.get.zoom}$div.get.zoom?" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Download as PDF</a>
	page}}

	{{tableBillDetails-title-right
	<div class="pull-right">
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu pull-right" role="menu">
				<li><a href="{$path}&zoom=day"><span class="glyphicon glyphicon-zoom-in"></span> Day view</a>
				</li>
				<li><a href="{$path}&zoom=week"><span class="glyphicon glyphicon-zoom-out"></span> Week view</a>
				</li>
			</ul>
		</div>
	</div>
	tableBillDetails-title-right}}
$weeks?
<!--{ end }-->