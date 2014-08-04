<?php

if (isset($_GET['delete'])) {
	$_GET['delete'] = str_replace("'", "''", $_GET['delete']);
	Apretaste::query("DELETE FROM raffles where id = '{$_GET['delete']}';");
}

if (isset($_GET['addraffle'])) {
	$desc = str_replace("'", "''", $_POST['description']);
	$df = $_POST['date_from'];
	$dt = $_POST['date_to'];
	
	if (trim("{$_FILES['image']['tmp_name']}") != "")
		if (isset($_FILES['image']))
			$image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
	
	Apretaste::query("INSERT INTO raffles (description, date_from, date_to, image)
					VALUES ('$desc', '$df', '$dt', '$image');");
}

$data['raffles'] = Apretaste::query("SELECT * FROM xraffles");