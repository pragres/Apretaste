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
			
			$f = date("Ymd").'1.gif';
			$img  = @file_get_contents("http://tiempo.cuba.cu/$f");
			
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
									"type" => "image/jpeg",
									"content" => $img,
									"name" => "Imagen del Satelite - WSI Corporation [" . date("Y-m-d h:i:s") . "].jpg",
									"id" => "wsi",
									"src" => "cid:wsi"
							)
					)
			);
			break;
		case 'nasa':
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
					"satelite" => true,
					"radar" => false,
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
			
			$pronostico_hoy = file_get_contents("http://www.met.inf.cu/Pronostico/pttn.txt");
			$pronostico_hoy = nl2br($pronostico_hoy);
			
			$pronostico_manana = file_get_contents("http://www.met.inf.cu/Pronostico/ptm.txt");
			$pronostico_manana = nl2br($pronostico_manana);
			
			
			// Getting rss
			$rss = file_get_contents('http://www.met.inf.cu/asp/genesis.asp?TB0=RSSFEED');
			
			$p1 = strpos($rss, 'Extendido del Tiempo por Ciudades</title>')-18;
			$p2 = strpos($rss, '<title>Estado de la');
			
			$rss = substr($rss, $p1, $p2-$p1);
			$rss = substr('<item>','<div>', $rss);
			$rss = substr('</item>','</div><br/><hr/>', $rss);
			$rss = substr('<description>','', $rss);
			$rss = substr('</description>','', $rss);
			$rss = substr('<title>','<h2>', $rss);
			$rss = substr('</title>','</h2>', $rss);
			$rss = substr('<![CDATA[','', $rss);
			$rss = substr(']]>','', $rss);
			
			return array(
					"answer_type" => "weather",
					"command" => "weather",
					"title" => "Tiempo en Cuba [" . date("Y-m-d h:i:s") . "]",
					"compactmode" => true,
					"satelite" => false,
					"radar" => false,
					"mapa" => false,
					"pronostico_hoy" => "$pronostico_hoy",
					"pronostico_manana" => "$pronostico_manana",
					"pronostico_extendido" => "$rss",
					"images" => array()
			);
			break;
	}
	
	// Revisar esta que ponen por el TV, viene del WSI Coporation
	// http://tiempo.cuba.cu/imprimir.php?opt=5
}