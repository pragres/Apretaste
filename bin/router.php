<?php

/**
 * Apretaste!com
 */
require_once '../lib/PEAR/PEAR.php';
date_default_timezone_set("America/New_York");

set_include_path("../;../lib/;../bin/;../tpl/;../lib/PEAR/;../crawler/");

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

if (! defined('ENT_HTML401'))
	define('ENT_HTML401', 0);

define("ROOT", "../");
define("TEMP", "../tmp/");
define("FILES", "../");
if (! defined('PACKAGES'))
	define("PACKAGES", "./");
	
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

$conex = Apretaste::connect();

if (! $conex) {
	echo "[FATAL] Servidor de base de datos no responde, intentar mas tarde!\n";
	exit();
}

// CLI Mode
if (div::isCli()) {
	$t1 = microtime(true);
	
	Apretaste::loadSetup();
	
	if (! isset(Apretaste::$config['pause']))
		Apretaste::$config['pause'] = '0';
	
	if (Apretaste::$config['pause'] . "" == '0') {
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
	} else {
		echo "[INFO] " . date("Y-m-d h:i:s") . " - Apretaste is PAUSED! \n";
	}
	echo "[INFO] " . date("Y-m-d h:i:s") . " - Finished Apretaste!com cron job \n";
	$t2 = microtime(true);
	echo "[INFO] Total execution time: " . number_format($t2 - $t1, 5) . " secs\n";
} else {
	session_start();
	// Web mode
	if (! isset($_GET['path']))
		$_GET['path'] = 'home';
	
	$user = ApretasteAdmin::getUser();
	
	if ($user !== false) {
		$_GET['path'] = 'admin';
	}
	
	if (isset($_GET['q']))
		$_GET['page'] = $_GET['q'];
	
	switch ($_GET['path']) {
		case "login" :
			$user = get('user');
			if (Apretaste::checkEmailAddress($user)) {
				ApretasteWeb::login();
				ApretasteWeb::Run();
			} else {
				
				include "../admin/auth.php";
			}
			break;
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