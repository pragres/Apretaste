{= title: List of recharges =}
{= path: index.php?path=admin&page=agency_recharge_list =}

{% layout %}
{= pagewidth: 900 =}
{{page
{% agency_panel %}
	<h1>Recharges of {$date} ?$hour at {$hour}h $hour?</h1>
	<table width="100%" class="tabla">
		<tr><th>Date</th><th>Customer</th><th>User</th><th>Amount</th><th>Recharge again</th></tr>
	?$recharges
		[$recharges]
		<tr><td>{$date}</td><td><a href="index.php?path=admin&page=agency_customer&id={$customer_id}">{$customer_name} ({$customer_email})</a></td><td>{$user_email}</td><td align="right">${#amount:2.#}</td>
		<td>
		<form action="index.php?path=admin&page=agency_pre_recharge" method="POST">
			<input type="hidden" value = "{$customer_id}" name="edtCustomer">
			<input type="hidden" value ="{$user_email}" name="edtEmail">	
			$<input size="2" class="number float" name="edtAmount" value ="{$amount}">
			<input name="btnRecharge" type="submit" value="Recharge" class="submit">
		</form>
		</td>
		</tr>
		
		[/$recharges]
	$recharges?
	<tr><th colspan="2" align="right">Total</th>
	<th align="right">{$recharges-user_email}</th>
	<th align="right">${#sum:recharges-amount:2.#}</th></tr>
	</table>
{% agency_footer %}
page}}
