<!--{
	Apretaste!com - Stats page
	@author rafa <rafa@pragres.com>
	@version 1.0
	@note This template use macros for best performance 
}-->

<!--{ auxiliary vars }-->
{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}
{= year_color: ["", "#ff9886","#7a6fbf"] =}
					
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
    <head>
		<title>Apretaste!com | Statistics</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"/>
    </head>
    <body>
	<div id = "page">
	    <h1><a href = "?page=admin">Apretaste!com</a> - <a href="?page=stats">Statistics</a></h1>
		{% menu %}
		<strong>Now = {/div.now:Y-m-d h:i:s/}</strong> | Messages = {$messages_by_week} by week | {$messages_by_day} by day | {$messages_by_hour} by hour| {$messages_by_minute} by minute | <strong>{$subscribes_count}</strong> subscribes | <strong>{$linker} linker links!</strong><br/>
		<hr/>
		<table width="100%">
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
					<div style = "padding: 5px; background: #eeeeee; -moz-border-radius: 5px;">{$total_messages} received email messages in {$days_online} days from {$first_day} to {$last_day} | {$total_visits} visits to ads</div>
				</td>
				<td valign="top" style="border:1px solid gray;padding: 5px;">
					<b>Last message</b><br/>
					<span>Date: {$last_msg.moment}<span><br/>
					<span>From: <a href="mailto:{$last_msg.author_email}"><span>{$last_msg.author}</a><br/>
					<span>To: <a href="mailto:{$last_msg.addressee}"><span>{$last_msg.addressee}</a><br/>
					<span>Command: <b>{$last_msg.command}</b><span><br/>
				</td>
			</tr>
		</table>

	    <hr/>

		<!--{ BEGIN Hourly access }-->
		<h2>Hourly access</h2>
		<p class="label">Number of emails received and sent every hour (last 20 days)</p>
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
						$Y = intval($answer_by_hour[$_key][$__key]);
						
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
							echo '<td width="80" align="center" style="border-left: 1px solid #eeeeee; border-top: 1px solid #eeeeee;font-size:10px;background:' . $bg . '; color: '.$cl.';"><b>' . $X . "/" . $Y.'</b></td>';
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
	    <hr/>
		<!--{ END Hourly access }-->

		<!--{ legend }-->
		<div style="background: {$year_color.2}; padding: 3px; display: table-cell; float:right;">{$current_year}</div>
		<div style="background: {$year_color.1}; padding: 3px; display: table-cell; float:right;">(# {$current_year} - 1 #)</div>
		
				
		<!--{ BEGIN Visitors }-->
    	<h2>Visitors</h2>
		<p style="color:gray;" align="right">Number of emails received</p>
		
		<table width="100%">
			<tr>		
				<?			
					for ($i = 1; $i<=12; $i++) {
						echo '<td valign="bottom" style="border-right: 1px dashed gray;"><table width="100%" cellpadding="0" cellspacing="0"><tr>';
						$j = 0;
						foreach ($access_by_month as $_key => $year) {
							$j++; 
							echo '<td align="center" width="50%" valign="bottom"><div style="height:'.($year[$i]/10).'px;width:25px;background:'.$year_color[$j].';font-size: 10px;font-weight:bold;">';
							echo '</div>';
							echo '<span style="font-size: 10px;">'.$year[$i].'</span>';
							echo '</td>';
						}
						echo '</tr></table>';
						echo '</td>';			    
					}
				?>
			</tr>
			<tr>
				<? foreach ($months as $value) echo "<th>{$value}</th>"; ?>
			</tr>
    	</table>
		<!--{ END Visitors }-->
					
		<!--{ BEGIN Unique visitors }-->
		<h2>Unique visitors (new users by month/beginners)</h2>
		<p style="color:gray;" align="right">Number of emails received for first time in the history</p>
		<table width="100%">
			<tr>		
			<?			
				for ($i = 1; $i<=12; $i++) {
					echo '<td valign="bottom" style="border-right: 1px dashed gray;"><table width="100%" cellpadding="0" cellspacing="0"><tr>';
					$j = 0;
					foreach ($newusers as $_key => $year) {
						$j++; 
						echo '<td align="center" width="50%" valign="bottom"><div style="height:'.($year[$i]/10).'px;width:25px;background:'.$year_color[$j].';font-size: 10px;font-weight:bold;">';
						echo '</div>';
						echo '<span style="font-size: 10px;">'.$year[$i].'</span>';
						echo '</td>';
					}
					echo '</tr></table>';
					echo '</td>';			    
				}
			?>
			</tr>
			<tr>
				<? foreach ($months as $value) echo "<th>{$value}</th>"; ?>
			</tr>
    	</table>
		<hr/>
		<!--{ END Unique visitors }-->
		
		<!--{ BEGIN Engagement }-->
		
		<h2>Engagement level</h2>
		
		<p style="color:gray;" align="right">Number of emails repeated more than three times a month.</p>
		<table width="100%">
			<tr>		
				<?					
					for ($i = 1; $i<=12; $i++) {
						echo '<td valign="bottom" style="border-right: 1px dashed gray;"><table width="100%" cellpadding="0" cellspacing="0"><tr>';
						$j = 0;
						foreach ($engagement as $_key => $year) {
							$j++; 
							echo '<td align="center" width="50%" valign="bottom"><div style="height:'.$year[$i]['engagement_percent'].'px;width:25px;background:'.$year_color[$j].';font-size: 10px;font-weight:bold;">';
							if ($year[$i]['engagement_percent']>0) echo number_format($year[$i]['engagement_percent'],0).'%';
							echo '</div>';
							echo '<span style="font-size: 10px;">'.$year[$i]['engagement'].'</span>';
							echo '</td>';
						}
						echo '</tr></table>';
						echo '</td>';			    
					}
				?>
			</tr>
			<tr>
				<? 
					foreach ($months as $value) 
						echo "<th>{$value}</th>"; 
				?>
			</tr>
    	</table>
      	<!--{ END Engagement }-->
		
		<!--{ BEGIN Bounce rate }-->
		<h2>Bounce Rate</h2>
		<p style="color:gray;" align="right">Number of people who send only one email within one hour</p>
		<table width="100%">
			<tr>		
				<?			
					for ($i = 1; $i<=12; $i++) {
						echo '<td valign="bottom" style="border-right: 1px dashed gray;"><table width="100%" cellpadding="0" cellspacing="0"><tr>';
						$j = 0;
						foreach ($engagement as $_key => $year) {
							$j++; 
							echo '<td align="center" width="50%" valign="bottom"><div style="height:'.$year[$i]['bounce_rate_percent'].'px;width:25px;background:'.$year_color[$j].';font-size: 10px;font-weight:bold;">';
							if ($year[$i]['bounce_rate_percent']>0) echo number_format($year[$i]['bounce_rate_percent'],0).'%';
							echo '</div>';
							echo '<span style="font-size: 10px;">'.$year[$i]['bounce_rate'].'</span>';
							echo '</td>';
						}
						echo '</tr></table>';
						echo '</td>';			    
					}
				?>
			</tr>
			<tr>
				<? 
					foreach ($months as $value) 
						echo "<th>{$value}</th>"; 
				?>
			</tr>
    	</table>
    	<hr/>
    	
		<!--{ END Bounce rate}-->
		
	    <h2>Landing pages</h2>
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
	    
	    <hr/>
	    
	    <table>
			<tr>
				<td valign="top" width="50%">
					<h2>Best keywords </h2>
					<img src="index.php?path=admin&chart=popular_phrases">
				</td>
				<td valign="top">
					<h2>Sources of traffic</h2>
					<img src="index.php?path=admin&chart=email_servers" style="float:right;">
				</td>
			</tr>
		</table>
	    
	    <hr/>
		<table width="100%">
			<tr>
				<td valign="top" width="50%">
					<h2>Best users this year</h2>
					[$best_users]
					<a href="mailto:{$author}">{$author}</a> - {$messages} messages<br/>
					[/$best_users]
				</td>
				<td valign="top">
					<h2>Best nanotitles</h2>
					<table>
						<tr>
							<th>Nanotitle</th>
							<th>Ads</th>
						</tr>
						[$nanotitles]
						<tr>
							<td>{$nanotitle}</td>
							<td> <b> {$popularity} </b> </td>
						</tr>
						[/$nanotitles]
					</table>
				</td>
			</tr>
		</table>
		<hr/>
		<h2>Last received messages</h2>
		<table width="100%">
			<tr>
				<th>Date</th>
				<th>From</th>
				<th>To</th>
				<th>Command</th>
				<th>Answer type</th>
			</tr>
			[$last_msgs]
			<tr>
				<td align="center" style="border-bottom: 1px solid gray;">{$moment:0,16}</td>
				<td align="center" style="border-bottom: 1px solid gray;"><a href="mailto:{$author_email}">{$author}</a></td>
				<td align="center" style="border-bottom: 1px solid gray;">{$addressee}</td>
				<td align="center" style="border-bottom: 1px solid gray;">{$command}</td>
				<td align="center" style="border-bottom: 1px solid gray;">{$answer_type}</td>
			</tr>
			[/$last_msgs]
		</table>
	</div>
</body>