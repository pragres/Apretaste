{= title: Agency's configuration =}
{= path: "index.php?path=admin&page=config_agency" =}
{% layout %}
{{page

	{% config_panel %}
		
	<div class = "box">
		<table width="100%">
		<tr>
			<td valign="top">
				<h2>Global</h2>
				<form action = ""  method = "post">
				Profit: <br><input class = "number"  type="text" name = "edtProfit" ?$edtProfit value = "{$edtProfit}" $edtProfit?> (# {$edtProfit} * 100:2. #)% <br><br>
				Residual profit: <br><input  class = "number"  type="text" name = "edtResidualProfit" ?$edtResidualProfit value = "{$edtResidualProfit}" $edtResidualProfit?> (# {$edtResidualProfit} * 100:2. #)%<br><br>
				<input type = "submit" class="submit"  value = "Update" name = "btnUpdateAgency">
				</form>
			</td>
			<td valign="top">
				<h2>Specific</h2>
				<table class="tabla" width="100%">
					<tr><th>Date</th><th>Agent</th><th>Profit</th><th>Profit type</th><th></th></tr>
					?$profits
					[$profits]
					<tr><td>{$moment}</td><td>{$user_login}</td><td>(# {$profit}*100:2.#)%</td><td>{$type}</td><td><a href="index.php?path=admin&page=config&delete_profit={$id}" onclick="return confirm('Are you sure?');">delete</a></td></tr>
					[/$profits]
					$profits?
					<form action="" method="post">
					<tr>
						<td align="right"><i>New profit's configuration</i></td>
						<td>
						<select class="text" name="edtUserLogin">
							?$agents
							[$agents]
								<option value="{$user_login}">{$user_login}</option>
							[/$agents]
							$agents?
						</select>
						</td>
						<td><input class="number" name="edtProfit"></td>
						<td><select class="text" name="edtType">
							<option value="normal">Normal</option>
							<option value="residual">Residual</option>
						</select></td>
						<td><input type="submit" name="btnAddProfit" value="Add"></td>
					</tr>	
					</form>
				</table>
			</td>
		</tr></table>
	</div>
page}}