<!--{
	Apretaste!com - Stats page
	@author rafa <rafa@pragres.com>
	@version 1.0
	@note This template use macros for best performance 
}-->

<!--{ auxiliary vars }-->
{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}
{= year_color: ["", "#ff9886","#7a6fbf"] =}
{= div.literals: ['s'] =}					
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
    <head>
		<title>Apretaste! | Dashboard</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"/>
    </head>
    <body>
	<div id ="page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=dashboard">Dashboard</a></h1>
	    {% menu %}
		
		<!--{ BEGIN Hourly access }-->
		<h2>Access by hour</h2>
		<p style="color:gray;">Number of emails received and sent every hour (last 20 days)</p>
		<table width="100%">
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
		<!--{ END Hourly access }-->
		
    	<h2 style="margin-top:50px;">Visitors</h2>
		<p style="color:gray;">Number of emails received</p>
		
		<img width="100%" height="50%"src="index.php?path=admin&chart=visitors">

		<h2 style="margin-top:50px;">Unique visitors </h2>
		<p style="color:gray;">Number of unique emails received</p>
		<img width="100%" height="50%"src="index.php?path=admin&chart=unique_visitors">
		
		
		<h2>New users </h2>
		<p style="color:gray;">Number of emails received for first time in the history</p>
		<img width="100%" height="50%"src="index.php?path=admin&chart=new_users">
		<p>Total number of users in Apretaste: <b>{$total_users}</b></p>
				
		<h2 style="margin-top:50px;">Engagement level</h2>
		<p style="color:gray;">Number of emails repeated more than three times a month.</p>
		<img width="100%" height="50%"src="index.php?path=admin&chart=engagement">
		
		<h2 style="margin-top:50px;">Bounce Rate</h2>
		<p style="color:gray;">Number of emails received only one time a month.</p>
		<img width="100%" height="50%"src="index.php?path=admin&chart=bounce_rate">
		
		<h2 style="margin-top:50px;">Services usage</h2>
		<p style="color:gray;">Services more used</p>
	    <img style="float:left;" src="index.php?path=admin&chart=messages_by_command&nocache=(# uniqid() #)">
	   
	   <table>
			<tr>
				<th></th>
				<?
					foreach ($months as $value)
						echo "<th>{$value}</th>";
				?>
			</tr>
			<?
				foreach ($msg_by_command as $command => $data) {
					
					echo '<tr><td width="150" align="right"><b>' . $command . '</b></td>';
					
					$i = 0;
					foreach ($data as $__key => $value){
						$i++;
						$bg = '';
						if ($i == date("m") * 1) $bg = 'background:#c2edc6;';
						echo '<td align="center" style="'.$bg.'border-left:1px solid #eeeedd;border-top:1px solid gray;">' . ($value < 1 ? '&nbsp;' : $value) . '</td>';
					}
					
					echo '</tr>';
				}
			?>
	    </table>
	    
		<h2 style="margin-top:50px;">Sources of traffic</h2>
		<p style="color:gray;">Email providers more used</p>
		<table width="100%">
			<tr>
				<td valign="top">
					<img src="index.php?path=admin&chart=email_servers" style="float:left;">
				</td>
				<td valign="top">
					<table width="100%">
						<tr>
							<?
								if (is_array($sources_of_traffic)){
									foreach($sources_of_traffic as $m => $v){
									
										echo '<td width="33%" valign="top"><strong>'.$months[$m-1].'</strong><br/><hr/>';
										if (is_array($v)) foreach($v as $x){
											echo "{$x['xauthor']} - <b>{$x['messages']}</b><br/>";
										}
										echo '</td>';
									}
								}
							?>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<h2 style="margin-top:50px">VIP Users</h2>
		<p style="color:gray;">Users who send more emails a month</p>
		<table width="100%">
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
		
		<!--{ <strong>Now = {/div.now:Y-m-d h:i:s/}</strong> | Messages = {$messages_by_week} by week | {$messages_by_day} by day | {$messages_by_hour} by hour| {$messages_by_minute} by minute | <strong>{$subscribes_count}</strong> subscribes | <strong>{$linker} linker links!</strong><br/> }-->
		<h2 style="margin-top:50px;">Details of the Classified Service</h2>
		<p style="color:gray;">Phrases more frequently searched</p>
		<table>
			<tr>
				<td valign="top" width="50%">
					<img src="index.php?path=admin&chart=popular_phrases">
				</td>
				<td valign="top">
					<table>
					[$popular_phrases]
						<tr><td>{$s}</td><td><b>{$n}</b></td></tr>
					[/$popular_phrases]
					</table>
				</td>
		</table>

		<p style="color:gray;" >Numbers of Ads</p>
		<table width="80%">
			<tr>
				<td valign="top">
					<table style = "font-size: 12px;" width="100%">
						<tr>
							<td align="right">&nbsp;<strong>(# {$total_internal} + {$total_external} #)</strong></td>
							<td>active ads </td><td>=</td>
							<td align="right"><strong>{$total_internal}</strong></td>
							<td>internal ads</td><td>+</td>
							<td align="right"><strong>{$total_external}</strong></td>
							<td> external ads</td>
						</tr>
						<tr>
							<td align="right">+<strong>(# {$historial_internal} + {$historial_external} #)</strong></td>
							<td>historical ads</td>
							<td>=</td>
							<td align="right"><strong>{$historial_internal}</strong></td>
							<td>internal and historical ads</td>
							<td>+</td>
							<td align="right"><strong>{$historial_external}</strong></td>
							<td>external and historical ads</td>
						</tr>
						<tr>
							<td align="right" style="border-top: 1px solid black;">=<strong>(# {$total_internal} + {$total_external} + {$historial_internal} + {$historial_external} #)</strong></td>
							<td style="border-top: 1px solid black;">ads</td>
							<td>=</td>
							<td style="border-top: 1px solid black;" align="right">(# {$total_internal} + {$historial_internal} #)</td>
							<td style="border-top: 1px solid black;"> internal ads</td><td style="border-top: 1px solid black;">+</td>
							<td style="border-top: 1px solid black;" align="right">(# {$total_external} + {$historial_external} #)</td>
							<td style="border-top: 1px solid black;"> external</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<p>Number of users receiving alerts: <b>{$subscribes_count}</b></p>
		<p>Number of emails sent by the linker: ?$linker [$linker] {$months.{$_index}} = <b>{$total}</b> [/$linker] $linker?</p>
	</div>
</body>