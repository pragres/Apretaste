<?php
if (file_exists("../index.php"))
	chdir("../");

date_default_timezone_set("America/New_York");

set_include_path("../;../lib/;../bin/;../tpl/;../lib/PEAR/;../lib/Stripe/");

// Autoload classes
function __autoload($class){
	if (file_exists("../bin/{$class}.php")) {
		include "../bin/{$class}.php";
	} elseif (file_exists("../lib/{$class}.php")) {
		include "../lib/{$class}.php";
	} elseif (file_exists("../crawler/{$class}.php")) {
		include "../crawler/{$class}.php";
	}
}
function monthNumber($spanish){
	$monthes = array(
			'enero' => 1,
			'febrero' => 2,
			'marzo' => 3,
			'abril' => 4,
			'mayo' => 5,
			'junio' => 6,
			'julio' => 7,
			'agosto' => 8,
			'septiembre' => 9,
			'octubre' => 10,
			'noviembre' => 11,
			'diciembre' => 12
	);
	return $monthes[strtolower($spanish)];
}

// Libs
include "../lib/independent.php";