<?php
$fname = get ( 'fname' );

if (isset ( $_GET ['ajax'] )) {
	session_start ();
	$handle = fopen ( "../log/$fname.log", 'r' );
	if (isset ( $_SESSION ['offset'] )) {
		$data = stream_get_contents ( $handle, - 1, $_SESSION ['offset'] );
		echo nl2br ( $data );
	} else {
		fseek ( $handle, 0, SEEK_END );
		$_SESSION ['offset'] = ftell ( $handle );
	}
	exit ();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script
	src="http://creativecouple.github.com/jquery-timing/jquery-timing.min.js"></script>
<script>
$(function() {
$.repeat(1000, function() {
$.get('?q=show_logs&ajax&fname=<?php echo $fname; ?>', function(data) {
$('#tail').append(data);
});
});
});
</script>
</head>
<body>
	<div id="tail">Starting up...</div>
</body>
</html>
