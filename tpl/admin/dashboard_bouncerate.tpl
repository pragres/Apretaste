{= title: "Bounce rate" =}
{% layout %}

{{onload 
	showBounceRate(); 
onload}}

{{headerdown

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>Number of emails received only one time a month.
	</div>
	<div class="panel-body">
		<div id="morris-bar-chart"></div>
	</div>
</div>
headerdown}}

<script type="text/javascript">
{ignore}
function showBounceRate(){
	 Morris.Bar({
		element: 'morris-bar-chart',
		data: {/ignore}{json:engagement}{ignore},
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: [{/ignore}'(# {$current_year} - 1 #)', '{$current_year}'{ignore}],
		hideHover: 'auto',
		resize: true
	});
}
{/ignore}
</script>