<?php

chdir("../");

date_default_timezone_set("America/New_York");

set_include_path("../;../lib/;../bin/;../tpl/;../lib/PEAR/");

// Autoload classes
function __autoload($class){
	if (file_exists("../bin/{$class}.php")) {
		include "../bin/{$class}.php";
	} elseif (file_exists("../lib/{$class}.php")) {
		include "../lib/{$class}.php";
	}
}

// Libs
include "../lib/independent.php";