<?php
$id = $_GET['id'];

$data['message'] = Apretaste::query("SELECT * FROM message WHERE id = '$id';");
$data['message'] = $data['message'][0];

$headers = unserialize($data['message']['extra_data']);

if (isset($headers['headers'])) {
	$headers = get_object_vars($headers['headers']);
	
	foreach ( $headers as $h => $v ) {
		if (is_scalar($v))
			$data['message']['header-' . $h] = "$v";
		else
			$data['message']['header-' . $h] = json_encode($v);
	}
	
	$headers = unserialize($data['message']['extra_data']);
	
	unset($headers['headers']);
	
	foreach ( $headers as $h => $v ) {
		
		if (is_scalar($v))
			$data['message'][$h] = "$v";
		else
			$data['message'][$h] = json_encode($v);
	}
	
	unset($data['message']['extra_data']);
}
		