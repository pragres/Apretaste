{= title: "Sources of traffic" =}
{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}
{= year_color: ["", "#ff9886","#7a6fbf"] =}
{= div.literals: ['s'] =}	

{% layout %}

{{onload 
	showSourcesOfTraffic(); 
onload}}

{{blocks
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> Sources
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="zoomSourcesOfTraffic();"><span class="glyphicon glyphicon-zoom-in" title="Zoom"></span></button>
				<button type="button" class="btn btn-default" onclick="showSourcesOfTraffic();"><span class="glyphicon glyphicon-refresh" title="Refresh"></span></button>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="flot-chart">
			<div class="flot-chart-content" id="sources_of_traffic-chart" style="height: 300px;"></div>
		</div>
		
	</div>
</div>
blocks}}

{{page
<div class="panel panel-default"> 
	<div class="panel-heading">
		<h3 class="panel-title">Email providers more used</h3> 
	</div> 
	<div class="panel-body">	
		<table class="table">
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
	</div>
</div>
page}}

<script type="text/javascript">
{ignore}
function showSourcesOfTraffic(id, labels, legend){
	if (!isset(id)) id = "sources_of_traffic-chart";
	if (!isset(labels)) labels = true;
	if (!isset(legend)) legend = false;
	
	var data = {/ignore}{json:pie_data}{ignore};
    var plotObj = $.plot($("#" + id), data, {
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

function zoomSourcesOfTraffic(){
	$("#sources_of_traffic-modal").modal('show');
	showSourcesOfTraffic('sources_of_traffic-chart-zoom', true, true);
}
{/ignore}
</script>

<div class="modal fade" id="sources_of_traffic-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog" style="width:600px;"> 
		<div class="modal-content"> 
			<form role="form" action="index.php?path=admin&page=config_add_agency" method="post">
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="myModalLabel">Source of traffic</h4>
				</div>
				<div class="modal-body"> 
					<div class="flot-chart">
						<div class="flot-chart-content" id="sources_of_traffic-chart-zoom" style="width: 500px;height: 400px;"></div>
					</div>
				</div> 
				<div class="modal-footer"> 
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
				</div> 
			</form>
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>