{= title: "New users" =}
{% layout %}

<!--{ begin }-->
{{onload 
	showNewUsers(); 
onload}}
<!--{ end }-->

{{headerdown
<!--{ begin }-->
<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> Number of emails received for first time in the history.
	</div>
	<div class="panel-body">
		<div id="new-users-chart"></div>
		<p>Total number of users in Apretaste: <b>{$total_users}</b></p>
	</div>
</div>
<!--{ end }-->
headerdown}}
<!--{ begin }-->
<script type="text/javascript">
{ignore}
function showNewUsers(){
	 Morris.Bar({
		element: 'new-users-chart',
		data: {/ignore}{json:new_users}{ignore},
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: [{/ignore}'(# {$current_year} - 1 #)', '{$current_year}'{ignore}],
		/*hideHover: 'auto',*/
		resize: true
	});
}
{/ignore}
</script>
<!--{ end }-->