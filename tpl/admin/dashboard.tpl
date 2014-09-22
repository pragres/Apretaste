<!--{
	Apretaste!com - Stats page
	@author rafa <rafa@pragres.com>
	@version 1.0
	@note This template use macros for best performance 
}-->

<!--{ auxiliary vars }-->
{= year_color: ["", "#ff9886","#7a6fbf"] =}
{= div.literals: ['s'] =}	
{= title: Access by hour =} 				

{% layout %}	

{{headerdown		
		<div class="panel panel-success"> 
			<div class="panel-heading">Number of emails received and sent every hour (last {$lastdays} days)</div> 
			<div class="panel-body">
				<table style="margin-left:10px;" class="table table-hover table-responsive">
					<tr>
						<th></th>
						<?
							$totals_by_day = array();
							$totals_by_day_a = array();
							for ($i = 1; $i <= $lastdays; $i++) {
								echo '<th width="80">' . $ah[$i]['wdia']. '</th>';
								$totals_by_day[$i] = 0;
								$totals_by_day_a[$i] = 0;
							}					
						?>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<?
							for ($i = 1; $i <= $lastdays; $i++) {
								echo '<th width="80">' . $ah[$i]['dia'] . '</th>';
							}
						?>
						<th></th>
					</tr>
					<?
					
						foreach ($access_by_hour as $_key => $hour_data) {
							echo '<tr><td align="right" valing="center" style="font-size: 10px; color:gray;"><b>' . $_key . 'h</b></td>';
							foreach ($hour_data as $__key => $value) {
								
								$value = intval($value);
								$X = $value;
								if (isset($answer_by_hour[$_key][$__key]))
									$Y = intval($answer_by_hour[$_key][$__key]);
								else
									$Y = 0;
								
								if (isset($totals_by_day[$__key])) $totals_by_day[$__key] += $X;
								if (isset($totals_by_day_a[$__key])) $totals_by_day_a[$__key] += $Y;
								
								$bg = 'white';
								$cl = 'black';
								
								if ($value > 0)	$bg = '#c2edc6';
								if ($value >= 100) $bg = '#67d368';
								if ($value >= 200) {$bg = '#1b6923'; $cl = 'white';}
								
								if ($X==0) $X='-';
								if ($Y==0) $Y='-';
								if ($X == 0 && $Y == 0)
									echo '<td width="80" style="border-left: 1px solid #eeeeee;">&nbsp;</td>';
								else
									//echo '<td width="80" align="center"><div class="btn-group"><a href="?path=admin&page=hour_activity&hour='.$_key.'&date='.$ah[$__key]['date'].'"><b>' . $X . "/" . $Y.'</b></a></div></td>';
								echo '<td width="80" align="center" valign="center" style="font-size:11px;background:' . $bg . '; color: '.$cl.';"><a style="color:black;" href="?path=admin&page=hour_activity&hour='.$_key.'&date='.$ah[$__key]['date'].'"><b>' . $X . "/" . $Y.'</b></a></td>';
									
							}
							echo '<td align="right" valing="center" style="font-size: 10px; color:gray;"><b>' . $_key . 'h</b></td></tr>';
						}
					?>
					<tr>
						<td></td>
						<?
							for ($i = 1; $i <= $lastdays; $i++) {
								$x = $totals_by_day[$i];
								$y = $totals_by_day_a[$i];
								if ($x < 1)	$x = '-';
								if ($y < 1)	$y = '-';
								echo '<th align="center" valign="center" width="80" style="font-size: 10px;border-left: 1px solid #eeeeee;border-top: 1px solid #eeeeee;"><b>' . $x . '/'. $y .'</b></th>';
							}
						?>
						<td></td>
					</tr>
				</table>
			</div> 
		</div>
		
		
headerdown}}
{{page	
		<h2>Visitors</h2>
		
		{% dashboard_visitors: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h2>Unique visitors</h2>
		
		{% dashboard_unique_visitors: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h2>New users</h2>
		
		{% dashboard_new_users: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h2>Engagement level</h2>
		
		{% dashboard_engagement: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h2>Bounce rate</h2>
		
		{% dashboard_bouncerate: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		

page}}

{{blocks
<h2>Source of traffic</h2>
blocks}}

{% dashboard_source_of_traffic: {
	from: "<!--{ begin }-->",
	to: "<!--{ end }-->"
} %}

{{blocks
<h2>Service usage</h2>
blocks}}

{% dashboard_service_usage: {
	from: "<!--{ begin }-->",
	to: "<!--{ end }-->"
} %}

{{source_of_traffic_panel_actions
	<a class="btn btn-default" href="index.php?path=admin&page=dashboard_source_of_traffic"><span class="glyphicon glyphicon-folder-open" title="Details"></span></a>
source_of_traffic_panel_actions}}
{{service_usage_panel_actions
	<a class="btn btn-default" href="index.php?path=admin&page=dashboard_service_usage"><span class="glyphicon glyphicon-folder-open" title="Details"></span></a>
service_usage_panel_actions}}

{{blocks
{% dashboard_vip: {
	from: "<!--{ begin }-->",
	to: "<!--{ end }-->"
} %}
blocks}}