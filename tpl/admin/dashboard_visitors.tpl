{= title: "Visitors" =}
{% layout %}

<!--{ begin }-->
{{onload 
	showVisitors(); 
onload}}
<!--{ end }-->
{{headerdown
<!--{ begin }-->
<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>Number of emails received
	</div>
	<div class="panel-body">
		<div id="visitors-chart"></div>
	</div>
</div>
<!--{ end }-->
headerdown}}
<!--{ begin }-->
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
<!--{ end }-->