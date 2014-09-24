{= title: Card packs of <i>{$dispatcher.email}</i> =}
{= path: "index.php?path=admin&page=dispatchers_card_sales&sales={$email}" =}

{% layout %}

{{blocks
	{%% dispatcher_block: $dispatcher %%}
blocks}}

{{page
	<a href="index.php?path=admin&page=dispatchers">&lt;&lt; Dispatchers</a><br/>
	
	{%% table: {
		data: $sales,
		title: "Packages of cards",
		hideColumns: {dispatcher: true, sale_price: true, card_price: true},
		headers: {
			sale_date: "Date",
			id: "&nbsp;"
		},
		wrappers: {
			quantity: '<a href="index.php?path=admin&page=dispatchers_cards&dispatcher={$email}&cards={$id}">{$quantity} cards</a> * ${#card_price:2.#} = $(# {$quantity} * {$card_price} :2.#)',
			sale_date: '{$value:10}',
			id: '<a href="{$path}&pdf={$id}"><span class="glyphicon glyphicon-print"></span></a>&nbsp;<a href="{$path}&sale={$email}&delete={$id}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a></a>'
		}
	} %%}
	
	{%% form-block: {
		action: $path,
		id: "form-package-cards", 
		modal: true,
		title: "Add package of cards",
		width: 300,
		fields: [
			{
				id: "edtQuantity",
				type: "number",
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
page}}