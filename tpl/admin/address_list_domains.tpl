{= path: "index.php?path=admin&page=address_list_domains =}
{= title: "Popular domains" =}

{% layout %}

{{page
	{% address_list_panel %}
	
	{$h1}Popular domains{$_h1}

	<table id="domains" class="tabla" width="100%">
		<tr>
		<?
		
		foreach ($providers as $i=>$p){
			echo '<td>';
			echo '<a href="index.php?path=admin&page=address_list&download=true&filter=@'.$p['provider'].'">'.$p['provider'].'</a>';
			echo '<b>('.$p['total'].')</b></td>';
			if (($i+1) % 5 == 0)
				echo '</tr><tr>';
		}
		?>
	</tr>
	</table>
page}}