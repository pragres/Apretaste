{= title: "Service usage" =}
{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}
{= year_color: ["", "#ff9886","#7a6fbf"] =}
{= div.literals: ['s'] =}	

{% layout %}

{{onload 
	showMessagesByCommand(); 
onload}}

{{blocks
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> Messages/Command
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Actions
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="#" onclick="showMessagesByCommand();">Refresh</a></li>
					<li><a href="#" onclick="zoomMessagesByCommand();">Zoom</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="flot-chart">
			<div class="flot-chart-content" id="messages_by_command-chart" style="height: 300px;"></div>
		</div>
		
	</div>
</div>
blocks}}

{{page
<div class="panel panel-default"> 
	<div class="panel-heading">
		<h3 class="panel-title">Message by month</h3> 
	</div> 
	<div class="panel-body">
		
<table class="table table-hover">
	<tr>
		<th></th>
		<?
			foreach ($months as $value)
				echo "<th>{$value}</th>";
		?>
	</tr>
	<?
		foreach ($msg_by_command as $command => $data) {
			
			echo '<tr><td align="right"><b>' . $command . '</b></td>';
			
			$i = 0;
			foreach ($data as $__key => $value){
				$i++;
				$bg = '';
				if ($i == date("m") * 1) $bg = 'background:#c2edc6;';
				echo '<td align="center" style="'.$bg.'">' . ($value < 1 ? '&nbsp;' : $value) . '</td>';
			}
			
			echo '</tr>';
		}
	?>
</table>
</div>
</div>
page}}

<script type="text/javascript">
{ignore}
function showMessagesByCommand(id, labels, legend){
	if (!isset(id)) id = "messages_by_command-chart";
	if (!isset(labels)) labels = true;
	if (!isset(legend)) legend = false;
	
	var data = {/ignore}{json:pie_data}{ignore};
    var plotObj = $.plot($("#"+id), data, {
		legend: {
			show: legend
		},
        series: {
            pie: {
                show: true,
				radius: 0.8,
				label: {
					show: labels,
					threshold: 0.1
				}
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: true
        }
    });
}

function zoomMessagesByCommand(){
	$("#messages_by_command-modal").modal('show');
	showMessagesByCommand('messages_by_command-chart-zoom', true, true);
}
{/ignore}
</script>

<div class="modal fade" id="messages_by_command-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog" style="width:600px;"> 
		<div class="modal-content"> 
			<form role="form" action="index.php?path=admin&page=config_add_agency" method="post">
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="myModalLabel">Messages by command</h4>
				</div>
				<div class="modal-body"> 
					<div class="flot-chart">
						<div class="flot-chart-content" id="messages_by_command-chart-zoom" style="width: 500px;height: 400px;"></div>
					</div>
				</div> 
				<div class="modal-footer"> 
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
				</div> 
			</form>
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>