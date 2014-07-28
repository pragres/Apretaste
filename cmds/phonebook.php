<?php
function cmd_phonebook($robot, $from, $argument, $body = '', $images = array()){
	$body = trim($body);
	$body = explode("\n", $body);
	$from = strtolower(Apretaste::extractEmailAddress($from));
	
	echo "[INFO] Phonebook of $from \n";
	
	foreach ( $body as $line ) {
		$arr = false;
		if (strpos($line, "=")) {
			$arr = explode("=", $line, 2);
		} elseif (strpos($line, ":")) {
			$arr = explode(":", $line, 2);
		}
		
		if ($arr !== false) {
			$name = $arr[0];
			$phone = $arr[1];
			$name = trim($name);
			$phone = trim($phone);
			$phone = str_replace(array(
					" ",
					"-",
					"(",
					"+",
					"'"
			), "", $phone);
			$name = str_replace(array(
					"'"
			), "", $name);
			$name = strtolower($name);
			
			echo "[INFO] Update phonebook of $from - $name = $phone \n";
			
			$r = Apretaste::query("SELECT count(*) as total FROM phonebook WHERE email = '$from' and phone = '$phone';");
			if ($r[0]['total'] * 1 > 0) {
				Apretaste::query("UPDATE phonebook SET name = '$name' WHERE email = '$from' and phone = '$phone';");
			} else {
				$r = Apretaste::query("SELECT count(*) as total FROM phonebook WHERE email = '$from' and name = '$name';");
				if ($r[0]['total'] * 1 > 0) {
					Apretaste::query("UPDATE phonebook SET phone = '$phone' WHERE email = '$from' and name = '$name';");
				} else
					Apretaste::query("INSERT INTO phonebook (email, phone, name) VALUES ('$from','$phone','$name');");
			}
		}
	}
	
	$phonebook = Apretaste::query("SELECT phone,name FROM phonebook WHERE email = '$from' ORDER BY name;");
	
	return array(
			"answer_type" => "phonebook",
			"command" => "phonebook",
			"phonebook" => $phonebook
	);
}
