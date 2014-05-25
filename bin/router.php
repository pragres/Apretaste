<?php

/**
 * Apretaste!com
 */

date_default_timezone_set("America/New_York");

set_include_path("../;../lib/;../bin/;../tpl/;../lib/PEAR/");

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

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

div::logOn("../log/div.log");

// CLI Mode
if (div::isCli()) {
	$t1 = microtime(true);
	echo "[INFO] " . date("Y-m-d h:i:s") . " - Starting Apretaste!com cron job \n";
	$args = array();
	$first = true;
	foreach ( $_SERVER['argv'] as $arg ) {
		if ($first) {
			$first = false;
			continue;
		}
		$args[] = $arg;
	}
	
	ApretasteAlone::Run($args);
	
	echo "[INFO] " . date("Y-m-d h:i:s") . " - Finished Apretaste!com cron job \n";
	$t2 = microtime(true);
	echo "[INFO] Total execution time: " . number_format($t2 - $t1, 5) . " secs\n";
} else {
	// Web mode
	if (! isset($_GET['path']))
		$_GET['path'] = 'home';
	
	switch ($_GET['path']) {
		case "home" :
			ApretasteWeb::Run();
			break;
		case "execute" :
		case "server" :
			$server = new phpHotMapServer();
			$server->addMethod("ApretasteWeb::search", "phrase,pricemin,pricemax,photo,phone,offset");
			$server->addMethod("ApretasteWeb::getAd", "id");
			$server->addMethod("ApretasteWeb::didyoumean", "query");
			$server->addMethod("ApretasteWeb::help", "");
			$server->addMethod("ApretasteWeb::terms", "");
			$server->go();
			break;
		case "admin" :
			session_start();
			ApretasteAdmin::Run();
			break;
		case "ad_image" :
			Apretaste::connect();
			
			$id = $_GET['id'];
			
			if (! is_null($id)) {
				$r = Apretaste::query("SELECT image, image_name, image_type from announcement where id = '{$_GET['id']}';");
				if ($r) {
					if (trim("{$r[0]['image_type']}") == '')
						$r[0]['image_type'] = 'jpeg';
					if (substr($r[0]['image_type'], 0, 6) != "image/")
						$r[0]['image_type'] = "image/" . $r[0]['image_type'];
					
					header("Content-type: {$r[0]['image_type']}; name: {$r[0]['image_name']}");
					
					if (isset($_GET['resized'])) {
						$r[0]['image'] = Apretaste::resizeImage($r[0]['image'], $_GET['resized']);
					}
					echo base64_decode($r[0]['image']);
				}
			}
			break;
	}
}