{= path: "index.php?path=admin&page=dashboard_ads" =}
{= title: "Details of the Classified Service" =}

{% layout %}

{{blocks
	{%% chart_block_pie: {
		data: $popular_phrases_pie,
		id: "popular_phrases_pie",
		title: "Popular phrases",
		div: {
			clear_locations: false
		}
	} %%}
blocks}}

{{page
	?$popular_phrases
		{%% table: {
			title: "Phrases more frequently searched",
			data: $popular_phrases,
			headers: {s: "Phrase", n: "Uses"},
			simple: true
		} %%}
	$popular_phrases?
	<br/>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Numbers of Ads</h3>
		</div>
		
			<table style = "font-size: 12px;" width="100%" class="table table-hover">
				<tr>
					<td align="right">&nbsp;<strong>(# {$total_internal} + {$total_external} #)</strong></td>
					<td>active ads </td><td>=</td>
					<td align="right"><strong>{$total_internal}</strong></td>
					<td>internal ads</td><td>+</td>
					<td align="right"><strong>{$total_external}</strong></td>
					<td> external ads</td>
				</tr>
				<tr>
					<td align="right">+<strong>(# {$historial_internal} + {$historial_external} #)</strong></td>
					<td>historical ads</td>
					<td>=</td>
					<td align="right"><strong>{$historial_internal}</strong></td>
					<td>internal and historical ads</td>
					<td>+</td>
					<td align="right"><strong>{$historial_external}</strong></td>
					<td>external and historical ads</td>
				</tr>
				<tr>
					<td align="right" style="border-top: 1px solid black;">=<strong>(# {$total_internal} + {$total_external} + {$historial_internal} + {$historial_external} #)</strong></td>
					<td style="border-top: 1px solid black;">ads</td>
					<td>=</td>
					<td style="border-top: 1px solid black;" align="right">(# {$total_internal} + {$historial_internal} #)</td>
					<td style="border-top: 1px solid black;"> internal ads</td><td style="border-top: 1px solid black;">+</td>
					<td style="border-top: 1px solid black;" align="right">(# {$total_external} + {$historial_external} #)</td>
					<td style="border-top: 1px solid black;"> external</td>
				</tr>
			</table>
			<div class="panel-footer">
			{$subscribes_count} users receiving alerts <br/>
			</div>
	</div>
	<br/>
	?$linker
	{%% chart_bar: {
		id: "linker",
		data: $linker,
		title: "Number of emails sent by the linker" 
	} %%}
	$linker?
	
page}}