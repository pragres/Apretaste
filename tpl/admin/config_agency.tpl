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
				<form action="" method="post">
				<select name="cboAgencyPercents">
					[$agency_percents]
					<option value="{$id}">{$name} ((# {$profit_percent} *100:2. #)% | (# {$residual_percent}*100:2.#)%)</option>
					[/$agency_percents]
				</select><br/><br/>
				<input class="number" name="edtAgencyProfitPercent">
				<input class="number" name="edtAgencyResidualPercent">
				<input class="submit" type="submit" name="btnUpdateAgencyPercents" value="Update">
				</form>
			$agency_percents?
			</td>
		</tr></table>
		
		<h2>Agencies</h2>
		
		<table class="tabla" width="100%">
			<tr>
				<th><a href="{$path}&orderby=name">Name</a></th>
				<th><a href="{$path}&orderby=phone">Phone</a></th>
				<th><a href="{$path}&orderby=credit_line">Credit</a></th>
				<th><a href="{$path}&orderby=sold">Sold</a></th>
				<th><a href="{$path}&orderby=residual">Residuals</a></th>
				<th><a href="{$path}&orderby=owe">Owe</a></th></tr>
		?$agencies
			[$agencies]
			<tr><td>{$name}</td><td>{$phone}</td><td>${#credit_line:2.#}</td><td align="right">${#sold:2.#}</td><td align="right">${#residual:2.#}</td><td align="right">${#owe:2.#}</td></tr>
			[/$agencies]
		$agencies?
		</table>
		<br/>
		<a class="button" href="index.php?path=admin&page=config_add_agency">New agency</a>		
	</div>
page}}