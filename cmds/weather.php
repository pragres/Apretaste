<?php

/**
 * Apretaste!com Weather Command
 *
 * @author salvi <salvi@pragres.com>
 * @author rafa <rafa@pragres.com>
 * @version 2.0
 *         
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_weather($robot, $from, $argument, $body = '', $images = array()){
	$agument = trim(strtolower($argument));
	
	switch ($argument) {
		case 'satelite' :
			echo "[INFO] Download last Satellite WSI Image \n";
			
			$f = date("Ymd") . '1.gif';
			$url = "http://tiempo.cuba.cu/images/$f";
			$robot->log("Downloading $url");
			
			$img = @file_get_contents($url);
			
			if ($img === false) {
				$f = date("Ymd", time() - 60 * 60 * 24) . '1.gif';
				$url = "http://tiempo.cuba.cu/images/$f";
				$robot->log("Downloading $url");
				
				$img = @file_get_contents($url);
				
				if ($img === false) {
					$f = date("Ymd", time() - 60 * 60 * 24 * 2) . '1.gif';
					$url = "http://tiempo.cuba.cu/images/$f";
					$robot->log("Downloading $url");
					
					$img = @file_get_contents($url);
				}
			}
			
			$img = Apretaste::resizeImage($img, 700);
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Tiempo en Cuba: Imagen del sat&eacute;lite WSI Corporation [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"pronostico_hoy" => false,
					"pronostico_manana" => false,
					"pronostico_extendido" => false,
					"mapa" => false,
					"satelite" => true,
					"nasa" => false,
					"radar" => false,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $img,
									"name" => "Imagen del Satelite - WSI Corporation [" . date("Y-m-d h:i:s") . "].gif",
									"id" => "wsi",
									"src" => "cid:wsi"
							)
					)
			);
			break;
		case 'nasa' :
			echo "[INFO] Download last Satellite NASA Image from GOES Project Science \n";
			
			$last_goes = file_get_contents("http://goes.gsfc.nasa.gov/goescolor/goeseast/hurricane2/color_med/latest.jpg");
			$last_goes = Apretaste::resizeImage($last_goes, 700);
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Tiempo en Cuba: Imagen del sat&eacute;lite de la NASA[" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"pronostico_hoy" => false,
					"pronostico_manana" => false,
					"pronostico_extendido" => false,
					"mapa" => false,
					"satelite" => false,
					"radar" => false,
					"nasa" => true,
					"images" => array(
							array(
									"type" => "image/jpeg",
									"content" => $last_goes,
									"name" => "Imagen del Satelite - GOES Project Science [" . date("Y-m-d h:i:s") . "].jpg",
									"id" => "goes",
									"src" => "cid:goes"
							)
					)
			);
			
			break;
		case 'radar' :
			
			echo "[INFO] Download last Cuban Radar Image [composite] \n";
			$radar = file_get_contents("http://www.met.inf.cu/Radar/NacComp200Km.gif");
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Tiempo en Cuba: Imagen del radar [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"pronostico_hoy" => false,
					"pronostico_manana" => false,
					"pronostico_extendido" => false,
					"mapa" => false,
					"satelite" => false,
					"radar" => true,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $radar,
									"name" => "Imagen del [" . date("Y-m-d h:i:s") . "]radar.gif",
									"id" => "radar",
									"src" => "cid:radar"
							)
					)
			);
			
			break;
		case 'presion superficial' :
		case 'mapa' :
			echo "[INFO] Download Mapa Presion Superficial\n";
			
			$pronostico = file_get_contents("http://www.met.inf.cu/Pronostico/tv18.jpg");
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Tiempo en Cuba: Presi&oacute;n superficial [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"pronostico_hoy" => false,
					"pronostico_manana" => false,
					"pronostico_extendido" => false,
					"mapa" => true,
					"satelite" => false,
					"radar" => false,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $pronostico,
									"name" => "Pronostico.jpg",
									"id" => "pronostico",
									"src" => "cid:pronostico"
							)
					)
			);
			break;
		default :
			
			/*$pronostico_hoy = @file_get_contents("http://www.met.inf.cu/Pronostico/pttn.txt");
			$pronostico_hoy = cmd_weather_clean_txt($pronostico_hoy);
			
			$pronostico_manana = @file_get_contents("http://www.met.inf.cu/Pronostico/ptm.txt");
			$pronostico_manana = cmd_weather_clean_txt($pronostico_manana);
			
			// Getting rss
			$rss = file_get_contents('http://www.met.inf.cu/asp/genesis.asp?TB0=RSSFEED');
			
			$p1 = strpos($rss, 'Extendido del Tiempo por Ciudades</title>') - 18;
			$p2 = strpos($rss, '<title>Estado de la');
			
			$rss = substr($rss, $p1, $p2 - $p1);
			$rss = str_replace('<item>', '<div>', $rss);
			$rss = str_replace('</item>', '</div><br/>', $rss);
			$rss = str_replace('<description>', '', $rss);
			$rss = str_replace('</description>', '', $rss);
			$rss = str_replace('<title>', '<h2>', $rss);
			$rss = str_replace('</title>', '</h2>', $rss);
			$rss = str_replace('<![CDATA[', '', $rss);
			$rss = str_replace(']]>', '', $rss);
			*/
			// clima por provincias
			
			$places = array(
					"La Habana",
					"Pinar del Rio"
			);
			
			$provincias = array();
			$images = array();
			
			foreach ( $places as $place ) {
				
				$robot->log("Getting weather information of $place");
				
				$r = cmd_weather_place($place);
				var_dump($r);
				$imgsrc = $r->weather_now['weatherIcon'];
				
				if (!isset($images[$imgsrc])){
					$robot->log("Downloading image $imgsrc");
					
					$content = @file_get_contents($imgsrc);
					
					$name = explode("/",$imgsrc);
					$name = $name[count($name)-1];
					$id = uniqid();
					
					$images[$imgsrc] = array(
							"type" => "image/png",
							"content" => $content,
							"name" => $name,
							"id" => $id,
							"src" => "cid:$id"
					);
					$r->weather_now['weatherIcon'] = 'cid:'.$id;
				}
				
				
				
				foreach ( $r->weather_forecast as $k => $wf ) {
					
					$imgsrc = $wf['weatherIcon'];
					
					if (!isset($images[$imgsrc])){
						
						$robot->log("Downloading image $imgsrc");
						
						$content = @file_get_contents($imgsrc);
						
						$name = explode("/",$imgsrc);
						$name = $name[count($name)-1];
						$id = uniqid();
						
						$images[$imgsrc] = array(
								"type" => "image/png",
								"content" => $content,
								"name" => $name,
								"id" => $id,
								"src" => "cid:$id"
						);
						
						$r->weather_forecast[$k]->weatherIcon = 'cid:'.$id;
					}
				}
				
				$provincias[] = $r;
			}
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "El clima en Cuba [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"satelite" => false,
					"radar" => false,
					"mapa" => false,
					/*"pronostico_hoy" => "$pronostico_hoy",
					"pronostico_manana" => "$pronostico_manana",
					"pronostico_extendido" => "$rss",*/
					"images" => $images,
					"provincias" => $provincias
			);
			break;
	}
	
	// Revisar esta que ponen por el TV, viene del WSI Coporation
	// http://tiempo.cuba.cu/imprimir.php?opt=5
}
function cmd_weather_place($place){
	include "../lib/WeatherForecast.php";
	$weather = new WeatherForecast('93fvz526zx8uu26b59cpy9xf');
	$weather->setRequest($place, 'Cuba', 5);
	$weather->setUSMetric(false);
	return $weather->getLocalWeather();
}
function cmd_weather_clean_txt($text){
	$lines = explode("\n", $text);
	$i = 0;
	
	$text = '';
	
	foreach ( $lines as $line ) {
		$i ++;
		
		if ($i > 3) {
			if (substr($line, 0, 1) == '"')
				continue;
			if (substr($line, - 3, 2) == '".')
				continue;
			$line = trim($line);
			$line = htmlentities($line);
			if ($i == 4)
				$line = '<h2 style="{$font}">' . $line . '</h2><p align="justify" style="{$font}">';
			if (substr($line, 0, 3) == '...')
				$line = "<i>$line</i>";
			if (strlen(html_entity_decode($line)) > 15)
				$text .= $line . ' '; // .'<br/>';
			if (trim($line) == '')
				$text .= '<br/><br/>';
		}
	}
	$text .= "</p>\n";
	$text = str_replace("<br/><br/><br/><br/>", "<br/><br/>", $text);
	$text = str_replace("<br/><br/><br/>", "<br/><br/>", $text);
	$text = str_replace("<br/>", "<br/>\n", $text);
	return $text;
}