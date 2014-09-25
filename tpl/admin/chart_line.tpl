{{onload 
	show_{$id}(); 
onload}}

<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;{$title}
	</div>
	<div class="panel-body">
		<div id="{$id}"></div>
	</div>
</div>

<script type="text/javascript">
function show_{$id}{ignore}(){
	 Morris.Line({
		element: '{/ignore}{$id}{ignore}',
		data: {/ignore}{json:data}{ignore},
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
