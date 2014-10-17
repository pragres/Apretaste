<?php
$data['results'] = false;
$data['query_title'] = 'Results';

$data['query'] = '';

if (isset($_POST['btnAdd'])) {
	$title = post('edtTitle');
	$query = post('edtQuery');
	$params = post('edtParams');
	
	$title = str_replace("'", "''", $title);
	$query = str_replace("'", "''", $query);
	$params = str_replace("'", "''", $params);
	
	$user_login = $_SESSION['user'];
	
	q("INSERT INTO queries(title, query, params,user_login) VALUES ('$title','$query','$params','$user_login');");
}

if (isset($_GET['run'])) {
	$id_query = $_GET['run'];
	$_POST['btnRun'] = true;
	$r = q("select * from queries where id = '$id_query'");
	$query = $r[0]['query'];
	$query = new div($query, $_POST);
	$query = "$query";
	
	$data['query_title'] = $r[0]['title'];
	$data['query_id'] = $id_query;
	$params = div::jsonDecode($r[0]['params']);
	$data['params'] = $params;
	$_POST['edtQuery'] = $query;
}

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
		), '', $query);
		
		$data['results'] = @q($query);
		$e = pg_last_error(Apretaste::$db);
		if ($e) {
			$data['msg'] = $e;
			$data['msg-type'] = 'danger';
		}
		
		$data['query'] = $query;
	}
} else {
	$data['queries'] = q('select id,title,params from queries');
}  
