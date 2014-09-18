{= title: Recharge Cards =}
{= path: "index.php?path=admin&page=dispatchers&sales={$email}&cards={$sale}" =}
{% layout %}
{{page
			<a href="index.php?path=admin&page=dispatchers&sales={$email}">&lt;&lt; Sales</a><br/>
			<table class="tabla" width="100%">
				<tr><th>Code</th><th>Amount</th><th>User</th><th>Recharge date</th></tr>
			[$cards]
			<tr>
			<td align="center">{$code:0,4}&nbsp;{$code:4,4}&nbsp;{$code:8,4}&nbsp;</td>
			<td align="center">${#amount:2.#}</td>
			<td align="center">?$email <a href="index.php?path=admin&page=user_activity&user={$email}">{$email}</a> @else@ - still - $email?</td>
			<td align="center">?$recharge_date {$recharge_date} @else@ - still -$recharge_date?</td>
			</tr>
			[/$cards]
			<tr ><td align="right">Total</td>
			<td  align="center" style="border-top:2px solid gray;padding-top:3px;">$(# {$sum:cards-amount} :2.#)</td></tr>
			</table>
			
page}}