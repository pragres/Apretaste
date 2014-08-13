{= title: List of recharges =}
{= path: index.php?path=admin&page=agency_recharge_list =}

{% layout %}
{= pagewidth: 900 =}
{{page
	<table width="100%" class="tabla">
		<tr><th>Date</th><th>Customer</th><th>User</th><th>Amount</th></tr>
	?$recharges
		[$recharges]
		<tr><td>{$date}</td><td>{$customer_name} ({$customer_email})</td><td>{$user_email}</td><td align="right">${#amount:2.#}</td>
		[/$recharges]
	$recharges?
	</table>
page}}
