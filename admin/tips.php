<?php

Apretaste::connect();

$data = array();
$data['msg-type'] = "msg-ok";

if (isset($_POST['btnAddTip'])) {
	$tip = $_POST['tipText'];
	$tip = str_replace("'", "''", $tip);
	Apretaste::query("INSERT INTO tip (tip) values('$tip');");
	$data['msg'] = "The tip '" . substr($tip, 0, 30) . "' was inserted";
}

if (isset($_POST['delete'])) {
	Apretaste::query("DELETE FROM tip WHERE id = '{$_POST['delete']}';");
	$data['msg'] = "The tip was deleted";
}

$data['tips'] = Apretaste::query("SELECT * from tip;");
