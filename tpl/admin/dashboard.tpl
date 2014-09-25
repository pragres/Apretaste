<!--{
	Apretaste - Dashboard
	@author rafa <rafa@pragres.com>
	@version 1.0
	@note This template use macros for best performance 
}-->

<!--{ auxiliary vars }-->
{= year_color: ["", "#ff9886","#7a6fbf"] =}
{= div.literals: ['s'] =}	
{= title: "Dashboard" =} 				
{= current_visitors: {$visitors.(# {$current_month} - 1 #).current} =}
<?
	if ($current_month == 1){
		$last_visitors = $visitors[11]['last'];
	} else 
		$last_visitors = $visitors[$current_month - 2]['current'];
	
	if ($last_visitors > 0)
		$goal_completation = $current_visitors / $last_visitors * 100;
	else 
		$goal_completation = 0;
		
	$real_goal_completation = number_format($goal_completation,2) * 1;
	
	if ($goal_completation > 100) 
		$goal_completation = 100;
		
	$goal_completation = number_format($goal_completation,2) * 1;
?>
{% layout %}	

{{headerdown	

		<!-- /.row -->
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-comments fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{$current_visitors}</div>
								<div>Visitors</div>
							</div>
						</div>
					</div>
					<a href="index.php?path=admin&page=dashboard_visitors">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-user fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{$unique_visitors.(# {$current_month} - 1 #).current}</div>
								<div>Unique visitors</div>
							</div>
						</div>
					</div>
					<a href="index.php?path=admin&page=dashboard_unique_visitors">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-users fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{$new_users.(# {$current_month} - 1 #).b}</div>
								<div>New users</div>
							</div>
						</div>
					</div>
					<a href="index.php?path=admin&page=dashboard_new_users">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-thumbs-o-up fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{$engagement.(# {$current_month} - 1 #).b}<small>%</small>/{$bouncerate.(# {$current_month} - 1 #).b}<small>%</small></div>
								<div>Engagement / Bounce rate</div>
							</div>
						</div>
					</div>
					<a href="index.php?path=admin&page=dashboard_new_users">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-6">
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$goal_completation}" aria-valuemin="0" aria-valuemax="100" style="width: {$goal_completation}%;"> <span style="font-fize:24px;">{$real_goal_completation}% </span> 
				</div>
			</div>
		</div>
		<h3>Access by hour</h3>		
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
		<h3>Visitors</h3>
		
		{% dashboard_visitors: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h3>Unique visitors</h3>
		
		{% dashboard_unique_visitors: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h3>New users</h3>
		
		{% dashboard_new_users: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h3>Engagement level</h3>
		
		{% dashboard_engagement: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h3>Bounce rate</h3>
		
		{% dashboard_bouncerate: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}
		
		<h3>VIP users</h3>
		{% dashboard_vip: {
			from: "<!--{ begin }-->",
			to: "<!--{ end }-->"
		} %}

page}}



{{blocks

{%% chart_block_pie: {
	data: $source_of_traffic_data,
	id: "source_of_traffic",
	title: "Source of traffic"
} %%}

{%% chart_block_pie: {
	data: $service_usage_data,
	id: "service_usage",
	title: "Service usage"
} %%}

blocks}}

{{source_of_traffic_panel_actions
	<a class="btn btn-success" href="index.php?path=admin&page=dashboard_source_of_traffic"><span class="glyphicon glyphicon-folder-open" title="Details"></span></a>
source_of_traffic_panel_actions}}

{{service_usage_panel_actions
	<a class="btn btn-success" href="index.php?path=admin&page=dashboard_service_usage"><span class="glyphicon glyphicon-folder-open" title="Details"></span></a>
service_usage_panel_actions}}

