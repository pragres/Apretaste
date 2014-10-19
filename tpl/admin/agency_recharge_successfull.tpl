{= title: Recharge success =}
{= path: ?q=agency_recharge_successfull&email={$author.email}&customer={$div.get.customer} =}
{% layout %}

{{blocks
	<img src="data:image/jpeg;base64,{$author.picture}" width="200"><br/>
blocks}}

{{page 
<a href="index.php?q=agency_customer&id={$customer}"><span class="glyphicon glyphicon-arrow-left"></span> Back to customer's page</a>
<br/>
<br/>
?$author.name Name: <b>{$author.name}</b> <br/>$author.name?
Email: <b>{$author.email}</b><br/>
?$author.credit Current credit: <b>${#author.credit:2.#}</b> <br/>$author.credit?
page}}

{{footer
{% agency_footer %}
footer}}