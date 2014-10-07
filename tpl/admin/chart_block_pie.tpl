{{onload
show_{$id}();
onload}}

<div class="panel panel-success">
	<div class="panel-heading">
		{$title}
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-success" onclick="zoom_{$id}();"><span class="glyphicon glyphicon-zoom-in" title="Zoom"></span></button>
				<button type="button" class="btn btn-success" onclick="show_{$id}();"><span class="glyphicon glyphicon-refresh" title="Refresh"></span></button>
				(( {$id}_panel_actions ))
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="flot-chart">
			<div class="flot-chart-content" id="{$id}-chart" style="height: 300px;"></div>
		</div>
	</div>
</div>

<script type="text/javascript">

function show_{$id}(id, labels, legend){
	if (!isset(id)) id = "{$id}-chart";
	if (!isset(labels)) labels = true;
	if (!isset(legend)) legend = false;
	
	var data = {json:data}{ignore};
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
{/ignore}
function zoom_{$id}(){
	$("#{$id}-modal").modal('show');
	show_{$id}('{$id}-chart-zoom', true, true);
}
</script>

<div class="modal fade" id="{$id}-modal" tabindex="-1" role="dialog" aria-labelledby="{$id}-modal-label" aria-hidden="true"> 
	<div class="modal-dialog" style="width:600px;"> 
		<div class="modal-content"> 
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="{$id}-modal-label">{$title}</h4>
				</div>
				<div class="modal-body"> 
					<div class="flot-chart">
						<div class="flot-chart-content" id="{$id}-chart-zoom" style="width: 500px;height: 400px;"></div>
					</div>
				</div> 
				<div class="modal-footer"> 
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
				</div> 
		</div>
	</div>
</div>