{= title: Reports =}
{= path: index.php?path=admin&page=agency_reports =}
{= pagewidth: 1024 =}

{% layout %}

{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}
{= year_color: ["", "#ff9886","#7a6fbf"] =}
{{headerdown

<div class="panel panel-success" style="width: {$width}; margin: auto;">
	<div class="panel-heading">
		<h3 class="panel-title">Recharges by hour: <i>Number of recharges every hour (last {$lastdays} days)</i></h3>
	</div>
	<div class="panel-body">

	<p style="color:gray;">Number of recharges every hour (last {$lastdays} days)</p>
	<table width="100%" class="table table-hover">
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
		
			foreach ($sales_by_hour as $_key => $hour_data) {
				echo '<tr><td align="right" valing="center" style="font-size: 10px; color:gray;"><b>' . $_key . 'h</b></td>';
				foreach ($hour_data as $__key => $value) {
					
					$value = intval($value);
					$X = $value;
					if (isset($amount_by_hour[$_key][$__key]))
						$Y = intval($amount_by_hour[$_key][$__key]);
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
						echo '<td width="80" align="center" style="border-left: 1px solid #eeeeee; border-top: 1px solid #eeeeee;font-size:10px;background:' . $bg . '; color: '.$cl.';"><a style="color:black;" href="?path=admin&page=agency_recharge_list&hour='.$_key.'&date='.$ah[$__key]['date'].'"><b>' . $X . "/" . number_format($Y,2).'</b></a></td>';
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
	<br/>
	{%% chart_line: {
		id: "salescount",
		data: $salescount,
		title: "Recharges by month" 
	} %%}
	<br/>
	{%% chart_line: {
		id: "salesamount",
		data: $salesamount,
		title: "Amount by month" 
	} %%}
	<br/>
	{%% chart_line: {
		id: "residuals",
		data: $residuals,
		title: "Residuals by month" 
	} %%}
		
headerdown}}