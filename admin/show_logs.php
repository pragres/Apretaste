<?php
function tail($fname, $count = 1) {
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

if (isset ( $_GET ['ajax'] )) {
	$fname = get ( 'fname' );
	// session_start ();
	echo tail ( "../log/$fname.log" );
	return true;
}
