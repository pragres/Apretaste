<?php

/**
 * Apretaste!com Profile Command
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
function cmd_profile($robot, $from, $argument, $body = '', $images = array()){
	$properties = array(
			"name" => array(
					"nombre"
			),
			"birthdate" => array(
					"fecha de nacimiento",
					"nacimiento",
					"fecha nacimiento"
			),
			"sex" => array(
					"sexo",
					"genero"
			),
			"ocupation" => array(
					"ocupacion",
					"trabajo",
					"profesion"
			),
			"country" => array(
					"pais"
			),
			"state" => array(
					"estado",
					"provincia"
			),
			"city" => array(
					"municipio",
					"ciudad"
			),
			"town" => array(
					"reparto",
					"localidad",
					"pueblo"
			),
			"sentimental" => array(
					"situacion sentimental",
					"estado civil"
			),
			"interest" => array(
					"interes",
					"interesado en"
			)
	);
	
	$body = strip_tags($body);
	
	$lines = explode("\n", $body);
	
	$profile = array();
	
	foreach ( $lines as $line ) {
		$line = trim($line);
		if (strlen($line) > 3) {
			$p = strpos($line, ":");
			if ($p !== false) {
				$prop = substr($line, 0, $p);
				$value = substr($line, $p + 1);
				
				$prop = trim(strtolower($prop));
				$prop = Apretaste::replaceRecursive("  ", " ", $prop);
				
				$value = trim($value);
				
				foreach ( $properties as $key => $val ) {
					foreach ( $val as $kk => $vv )
						if ($vv == $prop) {
							$profile[$key] = $value;
							break 2;
						}
				}
			}
		}
	}
	
	if (isset($images[0]))
		$profile['picture'] = $images[0]['content'];
	
	Apretaste::saveProfile($from, $profile);
	
	$profile = Apretaste::getAuthor($from);
	
	$data = array(
			"answer_type" => "profile_saved",
			"command" => "profile",
			"profile" => $profile,
			"title" => "Su perfil ha sido actualizado"
	);
	
	if (isset($profile['picture']))
		if ($profile['picture'] !== '') {
			$img = base64_decode($profile['picture']);
			// $img = Apretaste::convertImageToJpg($img);
			$img = base64_decode(Apretaste::resizeImage(base64_encode($img), 100));
			
			$data['images'] = array(
					
					array(
							"type" => "image/jpeg",
							"content" => $img,
							"name" => "$from.jpg",
							"id" => "profile_picture",
							"src" => "cid:profile_picture"
					)
			);
		}
	
	return $data;
}