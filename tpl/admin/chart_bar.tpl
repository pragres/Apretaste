{{onload
show_{$id}();
onload}}

<div class="panel panel-success">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> {$title}.
	</div>
	<div class="panel-body">
		<div id="{$id}-chart"></div>
	</div>
</div>

<script type="text/javascript">

function show_{$id}(){
	 Morris.Bar({
		element: '{$id}-chart',
		data: {json:data},
		xkey: 'y',
		ykeys: ['a', 'b'],
		?$labels
		labels: {json:labels},
		@else@
		labels: ['(# {$current_year} - 1 #)', '{$current_year}'],
		$labels?
		hideHover: 'auto',
		resize: true
	});
}
</script>