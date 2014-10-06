<?php
$data['results'] = false;

$data['query'] = '';

if (isset($_POST['btnRun'])) {
	$query = post('edtQuery');
	
	$wquery = strtolower(Apretaste::replaceRecursive("  ", " ", $query));
	
	if (div::atLeastOneString($wquery, array(
			"drop database",
			"drop table"
	))) {
		$data['msg'] = "Invalid query";
		$data['msg-type'] = 'danger';
	} else {
		
		$query = str_ireplace(array(
				"drop database",
				"delete from",
				"insert into"
		));
		
		$data['results'] = @q($query);
		$e = pg_last_error(Apretaste::$db);
		if ($e) {
			$data['msg'] = $e;
			$data['msg-type'] = 'danger';
		}
		
		$data['query'] = $query;
	}
}