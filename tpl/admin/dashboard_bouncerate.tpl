{= title: "Bounce rate" =}
{% layout %}
<!--{ begin }-->
{{onload 
	showBounceRate(); 
onload}}
<!--{ end }-->
{{headerdown
<!--{ begin }-->
<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>Number of emails received only one time a month.
	</div>
	<div class="panel-body">
		<div id="bouncerate-chart"></div>
	</div>
</div>
<!--{ end }-->
headerdown}}
<!--{ begin }-->
<script type="text/javascript">
{ignore}
function showBounceRate(){
	 Morris.Bar({
		element: 'bouncerate-chart',
		data: {/ignore}{json:bouncerate}{ignore},
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