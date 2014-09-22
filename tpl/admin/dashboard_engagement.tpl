{= title: "Engagement level" =}
{% layout %}
<!--{ begin }-->
{{onload 
	showEngagement(); 
onload}}
<!--{ end }-->
{{headerdown
<!--{ begin }-->
<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> Number of emails repeated more than three times a month.
	</div>
	<div class="panel-body">
		<div id="engagement-chart"></div>
	</div>
</div>
<!--{ end }-->
headerdown}}
<!--{ begin }-->
<script type="text/javascript">
{ignore}
function showEngagement(){
	 Morris.Bar({
		element: 'engagement-chart',
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
<!--{ end }-->