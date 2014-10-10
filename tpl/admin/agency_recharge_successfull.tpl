{= title: Recharge success =}
{% layout %}

{{page
	<a href="index.php?path=admin&page=agency_customer&id={$customer}">&lt; &lt; Back to customer's page</a>
page}}

{{blocks
	<img src="data:image/jpeg;base64,{$author.picture}" width="200"><br/>
	?$author.name Name: <b>{$author.name}</b> <br/>$author.name?
	Email: {$author.email}<br/>
	?$author.credit Current credit: ${#author.credit:2.#} <br/>$author.credit?
blocks}}