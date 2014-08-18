{= title: "Agency's customer" =}
{= path: "index.php?path=admin&page=agency_customer" =}

{% layout %}

{{page 
	{% agency_panel %}
	<h1>Customer details</h1>
	
	<form action="{$path}&id={$customer.id}&update=true" method="POST">
		?$picture
		<img src="data:image/jpeg;base64,{$picture}" width="100"> 
		$picture?
		<input class="text" name="edtName" value="{$customer.full_name}"> <input class="text" name="edtEmail" value = "{$customer.email}"> <input class="text" name="edtPhone" value="{$customer.phone}">
		<input type="submit" class="submit" value = "Update" onclick="return confirm('Are you sure?');">
	</form>
	
	

	<h1>New contact: </h1>
		<form action="index.php?path=admin&page=agency_pre_recharge" method="post">
		<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
		Email: <br/><input class="text" name="edtEmail">
		Amount: $<input class="number float" name="edtAmount"><input type="submit" name="btnRecharge" value = "Recharge" class="submit">
		</form>
		
	<h1>Existing contacts</h1>
	[$customer.contacts]
		?$_is_first
			<table class="table" width="100%">
		$_is_first?
		?$_is_odd <tr> $_is_odd?
			<td width="10%" valign="center"><img src="data:image/jpeg;base64,{$picture}" width="50"></td>
			<td width="40%" valign="center">
				{?( "{$name}" != "{$email}" )?}
					{$name}
				{/?}
				<br/>{$email}<br/>
				<form action="index.php?path=admin&page=agency_pre_recharge" method="POST">
					<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
					<input type="hidden" value ="{$email}" name="edtEmail">
					Current credit: {#credit:2,0#}<br/>
					$<input size="2" class="number float" name="edtAmount" value ="">
					
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
{% agency_footer %}
page}}