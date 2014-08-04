{= title: "Agency's customer" =}

{% layout %}
{{page 

	<h2>Customer details</h2>
	ID: {$customer.id}<br/>
	Full name: {$customer.full_name}<br/>
	Email: <a href="mailto:{$customer.email}">{$customer.email}</a><br/>
	Phone: {$customer.phone}<br/>
	Date registered: {$customer.date_registered}<br/>
	
	<h2>Contacts</h2>
	
	[$customer.contacts]
		?$_is_first
			<table class="table">
			<tr><th>Name</th><th>Email</th><th>Recharge</th></tr>
		$_is_first?
		
		<tr>
			<td valign="center"><img src="data:image/jpeg;base64,{$picture}" width="50"></td>
			<td valign="center">{$name}</td>
			<td valign="center">{$email}</td>
			<td  valign="center">
			<form action="index.php?path=admin&page=agency_recharge" method="POST">
			<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
		<input type="hidden" value ="{$email}" name="edtEmail">
		<input size="2" class="number" name="edtAmount" value ="">
		<input name="btnRecharge" type="submit" value="Recharge" class="submit">
		</form></td><tr>
		
		?$_is_last
		</table>
		$_is_last?
	@empty@
		No contacts
	[/$customer.contacts]
<br/>
	<fieldset>
	<legend>Recharge credit of an user</legend>
		<form action="index.php?path=admin&page=agency_recharge" method="post">
		<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
		Email: <br/><input class="text" name="edtEmail"><br/>
		Amount: <br/>$<input class="number" name="edtAmount"><br/>
		<input type="submit" name="btnRecharge" value = "Recharge" class="submit">
		</form>
	</fielset>
page}}