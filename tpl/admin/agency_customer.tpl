{= title: "Agency's customer" =}
{= path: "index.php?path=admin&page=agency_customer" =}
{% layout %}
{{page 
	<table><tr><td valign="top">	
	<form action="{$path}&id={$customer.id}&update=true" method="POST">
	
	<fieldset>
	<legend>Customer details</legend>
	Date registered: <b>{$customer.date_registered}</b><br/>
	Full name: <br/><input class="text" name="edtName" value="{$customer.full_name}"><br/>
	Email: <br/><input class="text" name="edtEmail" value = "{$customer.email}"><br/>
	Phone: <br/><input class="text" name="edtPhone" value="{$customer.phone}"><br/><br/>
	<input type="submit" class="submit" value = "Update" onclick="return confirm('Are you sure?');">
	</fieldset>
	</form>
	</fieldset>
	</td><td valign="top">
	<fieldset>
	<legend>Contacts</legend>
	[$customer.contacts]
		?$_is_first
			<table class="table" width="100%">
		$_is_first?
		?$_is_odd <tr> $_is_odd?
			<td width="10%" valign="center"><img src="data:image/jpeg;base64,{$picture}" width="50"></td>
			<td width="40%" valign="center">{$name}<br/>{$email}<br/>
				<form action="index.php?path=admin&page=agency_pre_recharge" method="POST">
					<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
					<input type="hidden" value ="{$email}" name="edtEmail">
					$<input size="2" class="number" name="edtAmount" value ="">
					<input name="btnRecharge" type="submit" value="Recharge" class="submit">
				</form>
			</td>
		?$_is_even </tr> $_is_even?
		
		?$_is_last
		{?( {$customer.contacts} % 2 != 0 )?} </tr> {/?}
		</table>
		$_is_last?
	@empty@
		No contacts
	[/$customer.contacts]
	</fieldset>
	<fieldset>
	<legend>Recharge credit of new contact: </legend>
		<form action="index.php?path=admin&page=agency_pre_recharge" method="post">
		<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
		Email: <br/><input class="text" name="edtEmail">
		Amount: $<input class="number" name="edtAmount"><input type="submit" name="btnRecharge" value = "Recharge" class="submit">
		</form>
	</fielset>
</td></tr></table>
page}}