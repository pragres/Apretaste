<?php

/**
 * Apretaste!com Administration
 *
 * Dispatchers
 */



if (isset($_POST['btnAddDispatcher'])) {
	$r = ApretasteMoney::addDispatcher($_POST['edtEmail'], $_POST['edtName'], $_POST['edtContact']);
	
	if ($r == false) {
		$data['msg'] = 'The dispatcher <b>' . $_POST['edtEmail'] . '</b> already exists';
		$data['msg-type'] = 'danger';
	} else {
		$data['msg'] = 'The dispatcher <b>' . $_POST['edtEmail'] . '</b> was inserted successfull';
		$data['msg-type'] = 'info';
	}
}

if (isset($_GET['delete'])) {
	ApretasteMoney::delDispatcher($_GET['delete']);
}

$data['dispatchers'] = array();

$r = ApretasteMoney::getDispatchers();

foreach ( $r as $row ) {
	$data['dispatchers'][] = array(
			"picture" => $row['picture'],
			"email" => $row['email'],
			"name" => $row['name'],
			"contact" => $row['contact'],
			"cards" => $row['sales'],
			"total_sold" => $row['total_sold'],
			"profit" => $row['profit'],
			"owe" => $row['owe'] < 0 ? 0 : $row['owe'],
			"options" => $row['email']
	);
}

