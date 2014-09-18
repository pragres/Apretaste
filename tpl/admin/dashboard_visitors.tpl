{= title: "Visitors" =}
{% layout %}

{{onload 
	showVisitors(); 
onload}}

{{headerdown

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>Number of emails received
	</div>
	<div class="panel-body">
		<div id="visitors-chart"></div>
	</div>
</div>
headerdown}}

<script type="text/javascript">
{ignore}
function showVisitors(){

	 Morris.Line({
		element: 'visitors-chart',
		data: {/ignore}{json:visitors}{ignore},
		xkey: 'period',
		ykeys: ['last', 'current'],
		labels: [{/ignore}'(# {$current_year} - 1 #)', '{$current_year}'{ignore}],
		pointSize: 2,
		hideHover: 'auto',
		smooth: false,
		resize: true
	});
}
{/ignore}
</script>