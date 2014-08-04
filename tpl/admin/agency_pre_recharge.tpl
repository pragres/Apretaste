{= title: Recharge the credit of the user =}
{% layout %}
{{page
	<h2>User information</h2>
	<img src="data:image/jpeg;base64,{$picture}" width="200">
	Name: {$author.name}<br/>
	Email: {$author.email}<br/>
	
	<h2>Recharge details</h2>
	Amount: ${#div.post.edtAmount:2.#}
	<form action="index.php?path=admin&page=agency_recharge">
		<input value="{$div.post.edtEmail}" name="edtEmail">
		<input value="{$div.post.edtAmount}" name="edtAmount">
		<input value="{$div.post.edtCustomer}" name="edtCustomer">
		<input value="Confirm" name="btnRecharge" class="submit" type="submit">
	</form>
page}}