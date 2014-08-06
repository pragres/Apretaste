<?php

Apretaste::connect();

$data = array();
$data['msg-type'] = "msg-ok";

if (isset($_POST['btnAdd'])) {
	$word = $_POST['word'];
	$sym = $_POST['synonym'];
	$word = str_replace("'", "''", $word);
	$sym = str_replace("'", "''", $sym);
	
	$r = Apretaste::query("SELECT * FROM synonym WHERE (word = '$word' AND synonym = '$sym') OR (word = '$sym' AND synonym = '$word');");
	
	if (! $r or ! isset($r[0])) {
		Apretaste::query("INSERT INTO synonym (word,synonym) values('$word','$sym');");
		$data['msg'] = "The synonym of '" . $word . "' was inserted";
	} else {
		$data['msg'] = "The '" . $word . "' synonym already exists.";
		$data['msg-type'] = "msg-error";
	}
}

if (isset($_POST['delete'])) {
	Apretaste::query("DELETE FROM synonym WHERE id = '{$_POST['delete']}';");
	$data['msg'] = "The synonym was deleted";
}

$data['synonyms'] = Apretaste::query("SELECT * from synonym;");