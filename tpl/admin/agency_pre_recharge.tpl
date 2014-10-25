{= title: Recharge confirmation =}
{= pagewidth: 640 =}

{% layout %}

?$limitcredit
	{{headerdown 

	<a href="index.php?path=admin&page=agency_customer&id={$div.post.edtCustomer}"> &lt; &lt; Go back</a>  
	headerdown}}
@else@
	{{blocks
		
	<img src="data:image/jpeg;base64,{$author.picture}" width="200">
		
	blocks}}

	{{page
		?$author.name Name: <b>{$author.name}</b> <br/>$author.name?
		Email: <b>{$author.email}</b><br/>
		?$author.sex Sex: {$author.sex} <br/>$author.sex?
		?$author.state State/Province: <b>{$author.state}</b> <br/>$author.state?
		?$author.city City: <b>{$author.city}</b> <br/>$author.city?
		?$author.town Town: {$author.town} <br/>$author.town?
		?$author.credit Current credit: <b>${#author.credit:2.#}</b> <br/>$author.credit?
		<br/>
		Amount: <b>${#div.post.edtAmount:2.#}</b> 		
		<hr/>
		<form action="index.php?path=admin&page=agency_recharge" method="post">
			<input value="{$hash}" name="hash" type="hidden">
			<input value="{$div.post.edtEmail}" name="edtEmail" type="hidden">
			<input value="{$div.post.edtAmount}" name="edtAmount" type="hidden" id = "edtAmount">
			<input value="{$div.post.edtCustomer}" name="edtCustomer" type="hidden">
			<label id="progress" style="display: none;">Recharging...<br/><img src="static/progress.gif"></label>
			<input id ="btnRecharge" onclick="$(this).hide();$('#btnCancel').hide();$('#progress').show();" value="Confirm" name="btnRecharge" class="btn btn-default" type="submit">
			<a id ="btnCancel" class="btn btn-default" href="index.php?path=admin&page=agency_customer&id={$div.post.edtCustomer}">Cancel</a>
		</form>
	page}}
$limitcredit?
{% agency_footer %}