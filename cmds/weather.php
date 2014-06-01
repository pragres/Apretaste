<?php

include_once "../lib/WeatherForecast.php";

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
	$argument = trim(strtolower($argument));
	
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
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $img,
									"name" => "Imagen del Satelite - WSI Corporation [" . date("Y-m-d h:i:s") . "].gif",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
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
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/jpeg",
									"content" => $last_goes,
									"name" => "Imagen del Satelite - GOES Project Science [" . date("Y-m-d h:i:s") . "].jpg",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
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
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $radar,
									"name" => "Imagen del radar[" . date("Y-m-d h:i:s") . "].gif",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
							)
					)
			);
			
			break;
		case 'temperatura':
			
			// Analisis de la temperatura del mar (NOAA/NHC)
			//http://www.nhc.noaa.gov/tafb/atl_anal.gif
			
			echo "[INFO] Download Temperature Image [composite] \n";
			$img = file_get_contents("http://www.nhc.noaa.gov/tafb/atl_anal.gif");
				
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "An&aacute;lisis de la temperatura del mar (NOAA/NHC) [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"climaimagen" => true,
					"images" => array(
							array(
								"type" => "image/gif",
								"content" => $img,
								"name" => "Imagen de temperatura [" . date("Y-m-d h:i:s") . "].gif",
								"id" => "climaimagen",
								"src" => "cid:climaimagen"
							)
					)
			);
				
			break;
		case 'superficie':
			//Analisis de superficie del Atlántico y el Caribe (NOAA/NHC)
			//http://dadecosurf.com/images/tanal.1.gif
			
			echo "[INFO] Download Surface Image [composite] \n";
			$img = file_get_contents("http://dadecosurf.com/images/tanal.1.gif");
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "An&aacute;lisis de superficie del Atl&aacute;ntico y el Caribe (NOAA/NHC) [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $img,
									"name" => "Analisis de superficie [" . date("Y-m-d h:i:s") . "].gif",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
							)
					)
			);
			
			break;
			
		case 'atlantico':
			//Analisis del estado del Atlántico (NOAA/NHC)
			//http://www.nhc.noaa.gov/tafb_latest/atlsea_latestBW.gif
			echo "[INFO] Download Atlantic Image [composite] \n";
			$img = file_get_contents("http://www.nhc.noaa.gov/tafb_latest/atlsea_latestBW.gif");
				
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "An&aacute;lisis del estado del Atl&aacute;ntico (NOAA/NHC) [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $img,
									"name" => "Analisis del estado del atlantico [" . date("Y-m-d h:i:s") . "].gif",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
							)
					)
			);
				
			break;
		
		case 'caribe':
			//Imagen del Caribe (Weather Channel)
			//http://image.weather.com/images/sat/caribsat_600x405.jpg
			echo "[INFO] Download Weather Channel Caribean Image [composite] \n";
			$img = file_get_contents("http://image.weather.com/images/sat/caribsat_600x405.jpg");
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Imagen del Caribe (Weather Channel) [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/gif",
									"content" => $img,
									"name" => "Imagen del Caribe (Weather Channel) [" . date("Y-m-d h:i:s") . "].gif",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
							)
					)
			);
			
			break;
			
		case 'sector':
		case 'sector visible':
				//Imagen del Sector Visible
				//http://www.goes.noaa.gov/GIFS/HUVS.JPG
				echo "[INFO] Download Visible Sector [composite] \n";
				$img = file_get_contents("http://www.goes.noaa.gov/GIFS/HUVS.JPG");
					
				return array(
						"answer_type" => "weather",
						"command" => "weather",
						"title" => "Imagen del Sector Visible [" . date("Y-m-d h:i:s") . "]",
						"compactmode" => true,
						"climaimagen" => true,
						"images" => array(
								array(
										"type" => "image/jpeg",
										"content" => $img,
										"name" => "Imagen del Sector Visible [" . date("Y-m-d h:i:s") . "].jpg",
										"id" => "climaimagen",
										"src" => "cid:climaimagen"
								)
						)
				);
					
				break;
				
		case 'infraroja':
			
		case 'infrarroja':
			//Imagen Infrarroja
			//http://www.goes.noaa.gov/GIFS/HUVS.JPG
			echo "[INFO] Download IR Image [composite] \n";
			$img = file_get_contents("http://www.goes.noaa.gov/GIFS/HUIR.JPG");
				
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Imagen Infrarroja [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"climaimagen" => true,
					"images" => array(
							array(
									"type" => "image/jpeg",
									"content" => $img,
									"name" => "Imagen Infrarroja [" . date("Y-m-d h:i:s") . "].jpg",
									"id" => "climaimagen",
									"src" => "cid:climaimagen"
							)
					)
			);
				
			break;
		case 'vapor de agua':
		case 'vapor':
				//Imagen de Vapor de Agua
				//http://www.goes.noaa.gov/GIFS/HUWV.JPG
				echo "[INFO] Download Vapor de Agua [composite] \n";
				$img = file_get_contents("http://www.goes.noaa.gov/GIFS/HUWV.JPG");
			
				return array(
						"answer_type" => "weather",
						"command" => "weather",
						"title" => "Imagen del Vapor de Agua [" . date("Y-m-d h:i:s") . "]",
						"compactmode" => true,
						"climaimagen" => true,
						"images" => array(
								array(
										"type" => "image/jpeg",
										"content" => $img,
										"name" => "Imagen del Vapor de Agua [" . date("Y-m-d h:i:s") . "].jpg",
										"id" => "climaimagen",
										"src" => "cid:climaimagen"
								)
						)
				);
			
				break;
		/*case 'presion superficial' :
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
			break;*/
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
					"Pinar del Rio",
					"Artemisa",
					"Batabano",
					"Varadero",
					"Matanzas",
					"Santa Clara",
					"Cienfuegos",
					"Sancti Spiritus",
					"Trinidad",
					"Camaguey",
					"Ciego de Avila",
					"Las Tunas",
					"Holguin",
					"Bayamo",
					"Santiago de Cuba",
					"Guantanamo"
			);
			
			$provincias = array();
			$images = array();
			
			foreach ( $places as $place ) {
				
				$robot->log("Getting weather information of $place");
				
				$r = cmd_weather_place($place);
				
				if ($r===false){
					$robot->log("The weather conditions were not found");
					continue;
				}
				
				$p = strpos($r->locality,', Cuba');
				if ($p !==false) $r->locality = substr($r->locality,0,$p);
				
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
				}
				
				$r->weather_now['weatherIcon'] = 'cid:'.$images[$imgsrc]['id'];
				
				if (is_object($r->weather_forecast)){
					$w = array();
					foreach($r->weather_forecast as $k=>$v) $w['v'.$k] = $v;
						$r->weather_forecast = $w;
				}
				
				foreach ( $r->weather_forecast as $k => $wf ) {
					
					$imgsrc = $wf['weatherIcon'];
					
					if (!isset($images[$imgsrc])){
						
						$path = $imgsrc;
						if (file_exists("../cache/".md5($imgsrc)))
							$path = "../cache/".md5($imgsrc);
						
						$robot->log("Downloading image $path");
						
						$content = @file_get_contents($path);
						
						file_put_contents("../cache/".md5($imgsrc), $content);
												
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
					}
					
					$r->weather_forecast[$k]['weatherIcon'] = 'cid:'.$images[$imgsrc]['id'];
				}
				
				$provincias[] = $r;
			}
			
			
			// Translate
			
			$weatherDesc = array(
				395 => 'Nieve moderada o fuerte en area con truenos',
				392 => 'Nieve moderada tormentosas',
				389 => 'Lluvia moderada o fuerte en area con truenos',
				386 => 'Intervalos de lluvias tormentosas',
				377 => 'Lluvias moderadas o fuerte de granizo',
				374 => 'Lluvias ligeras de granizos de hielo',
				371 => 'Nieve moderada o fuerte',
				368 => 'Lluvias ligeras',
				365 => 'Aguanieve moderada o fuerte',
				362 => 'Aguanieve ligera',
				359 => 'Torrencial lluvia',
				356 => 'Lluvia moderada o abundante',
				353 => 'Moderada o fuerte lluvia',
				350 => 'Granizos de hielo',
				338 => 'Fuertes nevadas',
				335 => 'Nubes y nieve pesada',
				332 => 'Nieve moderada',
				329 => 'Nubes y nieve moderada',
				326	=> 'Poca nieve',
				323	=> 'Nieve moderada',
				320	=> 'Aguanieve moderada o fuerte',
				317	=> 'Aguanieve',
				314	=> 'Lluvia moderada o fuerte de congelaci&oacute;n',
				311	=> 'Lluvia helada Luz',
				308	=> 'Fuertes lluvias',
				305	=> 'Lluvia ligera, a veces',
				302	=> 'Lluvia moderada',	
				299	=> 'Lluvia ligera, a veces',	
				296	=> 'Lluvia ligera',	
				293	=> 'Lluvia moderada irregular',	
				284	=> 'Llovizna de congelaci&oacute;n fuerte',	
				281	=> 'Llovizna helada',	
				266	=> 'Llovizna ligera ',	
				263	=> 'Llovizna moderada',
				260	=> 'Niebla de congelaci&oacute;n',
				248	=> 'Niebla',
				230	=> 'Ventisca',	
				227	=> 'Chubascos de nieve',
				200	=> 'Brotes de lluvia moderada',	
				185	=> 'Llovizna de congelación y nubes en las inmediaciones',
				182	=> 'Nubes y aguanieve en las inmediaciones',
				179	=> 'Nubes y nieve en las inmediaciones',
				176	=> 'Lluvia moderada en las inmediaciones',
				143	=> 'Neblina',
				122	=> 'Nublado',	
				119	=> 'Nublado',
				116	=> 'Parcialmente nublado',	
				113	=> 'Despejado'
			);
			
			/*foreach ($r->weather_forecast as $k=> $wf){
				 $r->weather_forecast[$k]->weatherDesc = 
			}*/
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "El clima en Cuba [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"climaimagen" => false,
					"images" => $images,
					"provincias" => $provincias,
					"i18n" => $weatherDesc
			);
			break;
	}
	
	// Revisar esta que ponen por el TV, viene del WSI Coporation
	// http://tiempo.cuba.cu/imprimir.php?opt=5
}

function cmd_weather_place($place){
	$weather = new WeatherForecast('93fvz526zx8uu26b59cpy9xf');
	$weather->setRequest($place, 'Cuba', 3);
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
			if (strlen(html_entity_decode($line,ENT_COMPAT | ENT_HTML401 , 'ISO-8859-1')) > 15)
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