{= title: "VIP users" =}

{= div.literals: ['s'] =}	

{% layout %}
{{headerdown
<!--{ begin }-->
<div class="panel panel-success panel-responsive">
	<div class="panel-heading">
		<span class="glyphicon glyphicon-user" title="Zoom"></span> Users who send more emails a month 
	</div> 
	<div class="panel-body"> 
		
				<?
					if (is_array($best_users)) 
						foreach($best_users as $m => $v){
							echo '<div class="panel panel-success" <!--{ end }--> style="float: left; margin-right: 5px; width: 32%;" <!--{ begin }-->>
								<div class="panel-heading">'.$months[$m-1].'</div> <ul class="list-group">';
					
						//echo '<td width="33%" valign="top"><strong>'.$months[$m-1].'</strong><br/><hr/>';
						if (is_array($v)) foreach($v as $x){
							echo "<li class=\"list-group-item\"><a href=\"?path=admin&page=user_activity&user={$x['xauthor']}\">{$x['xauthor']}</a> - {$x['messages']}</li>";
						}
						echo '</ul></div>';
					}
				?>
			
	</div> 
</div>
<!--{ end }-->
headerdown}}