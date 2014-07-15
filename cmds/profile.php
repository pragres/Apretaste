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
	$email = $from;
	$from = strtolower($from);
	
	$argument = trim($argument);
	
	if (Apretaste::checkAddress($argument) || $argument == 'newuser@localhost')
		$email = strtolower($argument);
	
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
					"intereses",
					"interesado en"
			)
	);
	
	$updated = false;
	
	if ($email == $from) {
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
								
								switch ($key) {
									case 'sex' :
										$value = strtolower($value);
										$value = ($value[0] == 'm') ? "M" : "F";
										break;
								}
								$updated = true;
								
								$value = str_replace("'", "''", $value);
								
								$value = substr($value, 0, 100);
								
								$profile[$key] = $value;
								
								break 2;
							}
					}
				}
			}
		}
		
		if (isset($images[0])) {
			$profile['picture'] = $images[0]['content'];
			$updated = true;
		}
		
		Apretaste::saveProfile($email, $profile);
	}
	
	$profile = Apretaste::getAuthor($email);
	
	if (isset($profile['sex'])) {
		if ($profile['sex'] == '1' || $profile['sex'] == 'true' || $profile['sex'] == 't')
			$profile['sex'] = 'Masculino';
		elseif ($profile['sex'] == '0' || $profile['sex'] == 'false' || $profile['sex'] == 'f')
			$profile['sex'] = 'Femenino';
	} else
		$profile['sex'] = 'Indefinido';
	
	if (! isset($profile['cupid']))
		$profile['cupid'] = false;
	else
		$profile['cupid'] = ($profile['cupid'] == '1' || $profile['cupid'] == 'true' || $profile['cupid'] == 't');
	
	if ($updated)
		$data = array(
				"answer_type" => "profile_saved",
				"command" => "profile",
				"profile" => $profile,
				"title" => "Su perfil ha sido actualizado"
		);
	else
		$data = array(
				"answer_type" => "profile",
				"command" => "profile",
				"profile" => $profile,
				"title" => $email == $from ? "Su perfil en Apretaste!" : "Perfil de $email en Apretaste!"
		);
	
	if (isset($profile['picture']))
		if ($profile['picture'] !== '') {
			$img = base64_decode($profile['picture']);
			// $img = Apretaste::convertImageToJpg($img);
			$img = base64_decode(Apretaste::resizeImage(base64_encode($img), 80));
			
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
	$data['sharethis'] = 'PERFIL ' . $email;
	$data['email'] = $email;
	$data['from'] = $from;
	return $data;
}