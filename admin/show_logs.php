<?php
function tail($fname, $count = 10) {
	$line = '';
	
	$f = fopen ( $fname, 'r' );
	$cursor = - 1;
	for($i = 0; $i < $count; $i ++) {
		fseek ( $f, $cursor, SEEK_END );
		$char = fgetc ( $f );
		
		/**
		 * Trim trailing newline chars of the file
		 */
		while ( $char === "\n" || $char === "\r" ) {
			fseek ( $f, $cursor --, SEEK_END );
			$char = fgetc ( $f );
		}
		
		/**
		 * Read until the start of file or first newline char
		 */
		while ( $char !== false && $char !== "\n" && $char !== "\r" ) {
			/**
			 * Prepend the new char
			 */
			$line = $char . $line;
			fseek ( $f, $cursor --, SEEK_END );
			$char = fgetc ( $f );
		}
		
		$line = "\n" . $line;
	}
	// $line = str_replace("\n\n","\n",$line);
	return trim ( $line ) . "\n\r";
}

$fname = get ( 'fname' );

if (isset ( $_GET ['ajax'] )) {
	// session_start ();
	echo tail ( "../log/$fname.log" );
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
		if ($('#chkShow').attr('checked')=='checked') {
			$.get('?q=show_logs&ajax&fname=<?php echo $fname; ?>', function(data) {
				$('#tail').html(data);
			});
		}
	});
});
</script>
</head>
<body>
	<input type="checkbox" id = "chkShow"> Show
	<pre
		style="width: 1024px; height: 500px; background: black; color: white; padding: 5px;"
		id="tail">Starting up...</pre>
</body>
</html>
