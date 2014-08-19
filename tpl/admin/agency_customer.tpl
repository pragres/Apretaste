{= title: "Agency's customer" =}
{= path: "index.php?path=admin&page=agency_customer" =}
{= pagewidth: 1024 =}
{% layout %}

{{page 
	{% agency_panel %}
	<h1>Customer details</h1>
	
	<form action="{$path}&id={$customer.id}&update=true" method="POST">
		?$picture
		<img src="data:image/jpeg;base64,{$picture}" width="100"> 
		$picture?
		<input class="text" name="edtName" value="{$customer.full_name}"> 
		<input class="text" name="edtEmail" value = "{$customer.email}"> 
		<input class="text" name="edtPhone" value="{$customer.phone}" style="width:100px;">
		<input type="submit" class="submit" value = "Update" onclick="return confirm('Are you sure?');">
	</form>
	<h1>New contact: </h1>
		<form action="index.php?path=admin&page=agency_pre_recharge" method="post">
		<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
		Email: <br/><input class="text" name="edtEmail">
		Amount: $<input class="number float" name="edtAmount"><input type="submit" name="btnRecharge" value = "Recharge" class="submit">
		</form>
		
	?$customer.contacts
		<h1>Existing contacts</h1>
		<table class="tabla" width="100%">
		<tr><th>Photo</th><th>Name</th><th>Email</th><th>Credit</th><th>Recharge</th></tr>
		[$customer.contacts]
			<tr>
				<td width="10%" valign="center"><img src="data:image/jpeg;base64,{$picture}" width="50" height="50"></td>
				<td>?$name {$name} $name?&nbsp;</td>
				<td>{$email}</td>
				<td align="right">${#credit:2,0#}</td>
				<td>
					<form action="index.php?path=admin&page=agency_pre_recharge" method="POST">
						<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
						<input type="hidden" value ="{$email}" name="edtEmail">	
						$<input size="2" class="number float" name="edtAmount" value ="">
						<input name="btnRecharge" type="submit" value="Recharge" class="submit">
					</form>
				</td>
			</tr>
		[/$customer.contacts]
		</table>
		
	$customer.contacts?
	
	{% agency_footer %}
page}}