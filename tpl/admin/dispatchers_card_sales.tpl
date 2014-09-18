{= title: Recharge Card Sales =}
{= path: "index.php?path=admin&page=dispatchers&sales={$email}" =}
{% layout %}
{{blocks
	{%% dispatcher_block: {
		email: $dispatcher.email,
		name: $dispatcher.name,
		picture: $dispatcher.picture
	} %%}
	
	{%% form-block: {
		action: $path,
		title: "Add package of cards",
		fields: [
			{
				id: "edtQuantity",
				type: "text",
				class: "number",
				label: "Quantity of cards"
			},{
				id: "edtCardPrice",
				type: "text",
				class: "number",
				label: "Card price"
			}
		],
		submit: {
			name: "btnAddSale",
			caption: "Add sale"
		}
	} %%}
blocks}}

{{page
			<a href="index.php?path=admin&page=dispatchers">&lt;&lt; Dispatchers</a><br/>
			
			{%% table: {
				data: $sales,
				title: "Packages of cards",
				hideColumns: {dispatcher: true, sale_price: true, card_price: true, cards: true},
				headers: {
					sale_date: "Date",
					id: "&nbsp;"
				},
				wrappers: {
					quantity: '<a href="{$path}&cards={$id}">{$quantity} cards</a> * ${#card_price:2.#} = $(# {$quantity} * {$card_price} :2.#) <a href="{$path}&pdf={$id}"><span class="glyphicon glyphicon-print"></span></a>',
					sale_date: '{$value:10}',
					id: '<a href="{$path}&sale={$email}&delete={$id}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a>'
				}
			} %%}
				<!--{
			<table class="tabla" width="100%">
				<tr><th>Date</th><th>Quantity/Pricing</th><th>Package price</th></tr>
			[$sales]
			<tr><td>{$sale_date}</td><td><a href="{$path}&cards={$id}">{$quantity} cards</a> * ${#card_price:2.#} = $(# {$quantity} * {$card_price} :2.#)</td><td>{$sale_price}</td>
			<td><a href="{$path}&pdf={$id}">PDF</a></td>
			<td><a href="{$path}&sale={$email}&delete={$id}" onclick="return confirm('Are you sure?');">delete</a></td>
			</tr>
			[/$sales]
			</table>
			<hr>
		}-->
			
page}}