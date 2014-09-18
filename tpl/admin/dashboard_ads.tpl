{= title: "Details of the Classified Service" =}

{% layout %}

{{page

			?$popular_phrases
				<p style="color:gray;">Phrases more frequently searched</p>
				<table width="100%">
				<tr>
				<td valign="top">
					<img width="600" style="float:left;" src="index.php?path=admin&chart=popular_phrases">
				</td>
				<td valign="top">
					<table class="tabla">
						<tr><th>Phrase</th><th>Uses</th></tr>
					[$popular_phrases]
						<tr><td>{$s}</td><td><b>{$n}</b></td></tr>
					[/$popular_phrases]
					</table>
				</td>
				</tr></table>
			$popular_phrases?
		</div>
		<br/>
		
			<h3>Numbers of Ads</h3>
			<table width="80%" class="tabla">
				<tr>
					<td valign="top">
						<table style = "font-size: 12px;" width="100%">
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
					</td>
				</tr>
			</table>
			<p>Number of users receiving alerts: <b>{$subscribes_count}</b></p>
			<p>Number of emails sent by the linker: ?$linker [$linker] {$months.{$_index}} = <b>{$total}</b> [/$linker] $linker?</p>
		
page}}