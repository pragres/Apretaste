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
		<div class="panel panel-default"> 
			<div class="panel-heading">Number of emails received and sent every hour (last {$lastdays} days)</div> 
			<div class="panel-body">
				<table style="margin-left:10px;">
					<tr>
						<th></th>
						<?
							$totals_by_day = array();
							$totals_by_day_a = array();
							for ($i = 1; $i <= $lastdays; $i++) {
								echo '<th width="80" style="font-size: 10px;">' . $ah[$i]['wdia']. '</th>';
								$totals_by_day[$i] = 0;
								$totals_by_day_a[$i] = 0;
							}					
						?>
					</tr>
					<tr>
						<th></th>
						<?
							for ($i = 1; $i <= $lastdays; $i++) {
								echo '<th width="80" style="font-size: 10px;">' . $ah[$i]['dia'] . '</th>';
							}
						?>
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
								if ($value >= 15) $bg = '#67d368';
								if ($value >= 30) {$bg = '#1b6923'; $cl = 'white';}
								
								if ($X==0) $X='-';
								if ($Y==0) $Y='-';
								if ($X == 0 && $Y == 0)
									echo '<td width="80" style="border-left: 1px solid #eeeeee; border-top: 1px solid #eeeeee;">&nbsp;</td>';
								else
									echo '<td width="80" align="center" style="border-left: 1px solid #eeeeee; border-top: 1px solid #eeeeee;font-size:10px;background:' . $bg . '; color: '.$cl.';"><a style="color:black;" href="?path=admin&page=hour_activity&hour='.$_key.'&date='.$ah[$__key]['date'].'"><b>' . $X . "/" . $Y.'</b></a></td>';
							}
							echo '</tr>';
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
								echo '<th width="80" style="font-size: 10px;border-left: 1px solid #eeeeee;border-top: 1px solid #eeeeee;"><b>' . $x . '/'. $y .'</b></th>';
							}
						?>
					</tr>
				</table>
			</div> 
		</div>
		
		
headerdown}}
{{page	
		
		
page}}