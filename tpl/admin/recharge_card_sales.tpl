{= title: Recharge Card Sales =}
{= path: "index.php?path=admin&page=dispatchers&sales={$email}" =}
{% layout %}
{{page
			<a href="index.php?path=admin&page=dispatchers">&lt;&lt; Dispatchers</a><br/>
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
		
			<form action="{$path}" method="post">
			Quantity of cards: <input class="edit" name="edtQuantity"> 
			Card price: <input class="edit"  name="edtCardPrice"> 
			Package price: <input class="edit" name="edtSalePrice"> 
			<input type="submit" name="btnAddSale" value="Add sale">
			</form>
page}}