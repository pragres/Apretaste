{= path: "index.php?q=show_logs&fname=cron" =}
{= title: "Robot Logs" =}

{% layout %}

{{headerdown
{ignore}
<!--{ <script src="static/jquery-1.8.2.min.js"></script> }--> 
<script src="static/jquery-timing.min.js"></script>
<script>
$(function() {
	$.repeat(1000, function() {
		if ($('#chkShow').attr('checked')=='checked') {
			$.get('?q=show_logs&ajax&fname=cron', function(data) {
				if ($('#lastline').val() != data){
					$('#lastline').val(data);
					$('#tail').append(data);
					$('#tail').scrollTop(600);
				}
			});
		}
	});
});
</script>
{/ignore}
<input type="hidden" id="lastline">
<input type="checkbox" id = "chkShow"> Show
<pre
	style="overflow:auto; width: 1024px; height: 500px; background: black; color: white; padding: 5px;"
	id="tail">Starting up...</pre>
headerdown}}