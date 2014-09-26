{= title: Recharge confirmation =}
{= pagewidth: 640 =}

{% layout %}

{{blocks
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">User</h3>
		</div>
		<div class="panel-body">
			<img src="data:image/jpeg;base64,{$author.picture}" width="200">
			?$author.name Name: <b>{$author.name}</b> <br/>$author.name?
			Email: {$author.email}<br/>
			?$author.sex Sex: {$author.sex} <br/>$author.sex?
			?$author.state State/Province: <b>{$author.state}</b> <br/>$author.state?
			?$author.city City: <b>{$author.city}</b> <br/>$author.city?
			?$author.town Town: {$author.town} <br/>$author.town?
		</div>
	</div>
blocks}}

{{page
	<label style="float:left;">Amount: <b>$</b></label><span title ="Click to change" id="showAmount" style="cursor:pointer;" onclick="$('#changeAmount').show(); $(this).hide();"><b>{#div.post.edtAmount:2.#}</b> &nbsp; <small>(click to change)</small></span> 
	<span style="display:none;" id="changeAmount">
	<input onchange="$('#edtAmount').val($(this).val()); $('#showAmount').html('<b>'+$(this).val()+'</b>'); " value="{$div.post.edtAmount}" class="number form-control" style="width: 50px;float:left;">
	<a onclick="$('#changeAmount').hide(); $('#showAmount').show();" class="btn btn-success">Ok</a>
	</span>
	</b>
	<hr/>
	<form action="index.php?path=admin&page=agency_recharge" method="post">
		<input value="{$div.post.edtEmail}" name="edtEmail" type="hidden">
		<input value="{$div.post.edtAmount}" name="edtAmount" type="hidden" id = "edtAmount">
		<input value="{$div.post.edtCustomer}" name="edtCustomer" type="hidden">
		<input value="Confirm" name="btnRecharge" class="btn btn-default" type="submit">
		<a class="btn btn-default" href="index.php?path=admin&page=agency_customer&id={$div.post.edtCustomer}">Cancel</a>
	</form>
page}}

{% agency_footer %}