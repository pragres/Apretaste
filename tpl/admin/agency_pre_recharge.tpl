{= title: Recharge the credit of the user =}
{% layout %}
{{page
	<h2>User information</h2>
	<table>
	<tr><td valign ="top">
	<img src="data:image/jpeg;base64,{$author.picture}" width="200">
	</td>
	<td valign="top">
	?$author.name Name: <b>{$author.name}</b> $author.name?<br/>
	Email: {$author.email}<br/>
	?$author.sex Sex: {$author.sex} $author.sex?<br/>
	?$author.state State/Province: <b>{$author.state}</b> $author.state?<br/>
	?$author.city City: <b>{$author.city}</b> $author.city?<br/>
	?$author.town Town: {$author.town} $author.town?<br/>
	</td></tr></table>
	<h2>Recharge details</h2>
	Amount: ${#div.post.edtAmount:2.#}
	<form action="index.php?path=admin&page=agency_recharge" method="post">
		<input value="{$div.post.edtEmail}" name="edtEmail" type="hidden">
		<input value="{$div.post.edtAmount}" name="edtAmount" type="hidden">
		<input value="{$div.post.edtCustomer}" name="edtCustomer" type="hidden">
		<input value="Confirm" name="btnRecharge" class="submit" type="submit">
		<a href="index.php?path=admin&page=agency_customer&id={$div.post.edtCustomer}">Cancel</a>
	</form>
page}}