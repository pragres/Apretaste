{= title: "VIP users" =}

{= div.literals: ['s'] =}	

{% layout %}
{{headerdown
<div class="panel panel-default">
	<div class="panel-heading">
		Users who send more emails a month </div> 
		<div class="panel-body"> 
		<table class="table">
			<tr>
				<?
					if (is_array($best_users)) foreach($best_users as $m => $v){
						echo '<td width="33%" valign="top"><strong>'.$months[$m-1].'</strong><br/><hr/>';
						if (is_array($v)) foreach($v as $x){
							echo "<a href=\"?path=admin&page=user_activity&user={$x['xauthor']}\">{$x['xauthor']}</a> - {$x['messages']}<br/>";
						}
						echo '</td>';
					}
				?>
			</tr>
		</table>
	</div> 
</div>
headerdown}}