{= title: "Unique visitors" =}
{% layout %}
<!--{ begin }-->
{{onload 
	showUniqueVisitors(); 
onload}}
<!--{ end }-->
{{headerdown
<!--{ begin }-->
<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>Number of unique emails received
	</div>
	<div class="panel-body">
		<div id="unique-visitors-chart"></div>
	</div>
</div>
<!--{ end }-->
headerdown}}
<!--{ begin }-->
<script type="text/javascript">
{ignore}
function showUniqueVisitors(){

	 Morris.Line({
		element: 'unique-visitors-chart',
		data: {/ignore}{json:unique_visitors}{ignore},
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