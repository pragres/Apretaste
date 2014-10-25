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
							echo '<div class="panel panel-success" style="float: left; margin-right: 5px; width: 32%;">
								<div class="panel-heading">'.$months[$m].'</div> <ul class="list-group">';
					
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