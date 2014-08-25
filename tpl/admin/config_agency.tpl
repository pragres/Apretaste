{= title: Agencies =}
{= path: "index.php?path=admin&page=config_agency" =}
{= pagewidth: 1024 =}
{% layout %}
{{page

	{% config_panel %}
		
	<div class = "box">
		<table width="100%">
		<tr>
			<td valign="top">
				<h2>Adjust percents</h2>
				<form action = ""  method = "post">
				Sold: <br><input class = "number"  type="text" name = "edtProfit" ?$edtProfit value = "{$edtProfit}" $edtProfit?> (# {$edtProfit} * 100:2. #)% <br><br>
				Residual: <br><input  class = "number"  type="text" name = "edtResidualProfit" ?$edtResidualProfit value = "{$edtResidualProfit}" $edtResidualProfit?> (# {$edtResidualProfit} * 100:2. #)%<br><br>
				<input type = "submit" class="submit"  value = "Update" name = "btnUpdateAgency">
				</form>
			</td>
			<td valign="top">
			?$agency_percents
				<select name="cboAgencyPercents">
					[$agency_percents]
					<option value="{$id}">{$name} ((# {$profit_percent} *100:2. #)% | (# {$residual_percent}*100:2.#)%)</option>
					[/$agency_percents]
				</select><br/><br/>
				<input class="number" name="edtAgencyProfitPercent">
				<input class="number" name="edtAgencyResidualPercent">
				<input class="submit" type="submit" name="btnUpdateAgencyPercents" value="Update">
			$agency_percents?
			</td>
		</tr></table>
		
		<h2>Agencies</h2>
		<table class="tabla" width="100%">
			<tr><th>Name</th><th>Phone</th><th>Credit</th><th>Sold</th><th>Residuals</th><th>Owe</th></tr>
		?$agencies
			[$agencies]
			<tr><td>{$name}</td><td>{$phone}</td><td>${#credit_line:2.#}</td><td align="right">${#sold:2.#}</td><td align="right">${#residual:2.#}</td><td align="right">${#owe:2.#}</td></tr>
			[/$agencies]
		$agencies?
		</table>
			
		
	</div>
page}}