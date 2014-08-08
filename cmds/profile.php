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
					"fecha nacimiento",
					"cumpleanos"
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
			),
			"cupid" => array(
					"busco pareja",
					"cupido"
			),
			"hair" => array(
					"pelo",
					"color de pelo",
					"color_pelo"
			),
			"skin" => array(
					"piel",
					"color de piel",
					"color_piel"
			),
			"eyes" => array(
					"ojos",
					"color de ojos",
					"color_ojos",
					"color de los ojos"
			),
			"school_level" => array(
					"nivel escolar",
					"nivel de escolaridad"
			)
	);
	
	$options = array(
			"name" => "*",
			"birthdate" => "#date",
			"sex" => array(
					"masculino",
					"femenino",
					"m",
					"f",
					"desconocido"
			),
			"ocupation" => "*",
			"country" => "*",
			"state" => "*",
			"city" => "*",
			"town" => "*",
			"sentimental" => array(
					"casado",
					"soltero",
					"divorciado",
					'viudo',
					'comprometido',
					'otro',
					'casada',
					'soltera',
					'divorciada',
					'viuda',
					'comprometida'
			),
			"interest" => '*',
			"cupid" => array(
					"si",
					"no"
			),
			"hair" => array(
					'rubio',
					'trigueno',
					'moreno',
					'negro',
					'blanco',
					'otro',
					'rojo'
			),
			"skin" => array(
					"blanca",
					"negra",
					"amarilla",
					"mestiza",
					"india",
					"otra"
			),
			"eyes" => array(
					"verde",
					"azul",
					"pardo",
					"negro",
					"otro",
					"verdes",
					"azules",
					"pardos",
					"negros",
					"otros"
			),
			"school_level" => array(
					'secundaria',
					'tecnico',
					'tecnico medio',
					'universidad',
					'universitario',
					'master',
					'doctor',
					'otro',
					'superior',
					'media',
					'primaria'
			)
	);
	
	$updated = false;
	
	if ($email == $from) {
		$body = strip_tags($body);
		$body = quoted_printable_decode($body);
		$lines = explode("\n", $body);
		
		$profile = array();
		foreach ( $lines as $line ) {
			$line = trim($line);
			if (strlen($line) > 3) {
				$p = strpos($line, ":");
				$p1 = strpos($line, "=");
				
				if ($p !== false && $p1 !== false)
					if ($p1 < $p)
						$p = $p1;
				
				if ($p === false && $p1 !== false)
					$p = $p1;
				
				if ($p !== false) {
					$prop = substr($line, 0, $p);
					$value = substr($line, $p + 1);
					
					$prop = trim(strtolower($prop));
					$prop = Apretaste::replaceRecursive("  ", " ", $prop);
					
					$value = trim($value);
					
					foreach ( $properties as $key => $val ) {
						foreach ( $val as $kk => $vv )
							if ($vv == $prop) {
								
								if (isset($options[$key])) {
									$os = $options[$key];
									if (is_array($os)) {
										$value = trim(strtolower($value));
										if (array_search($value, $os) === false)
											break;
									} else if ($os == '#date') {
										$value = trim(strtolower($value));
										
										if (strpos($value, '/') !== false) {
											$arr = explode("/", $value);
											if (isset($arr[2])) {
												$value = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
											}
										}
										
										$date = strtotime($value);
										
										if ($date == - 1 || $date === false)
											break;
										
										$value = date("Y-m-d", $date);
									} else if ($os == 1) {
										$value = trim($value);
										$arr = explode(" ", $value);
										$value = $arr[0];
									}
								}
								
								switch ($key) {
									case 'sex' :
										$value = strtolower($value);
										$value = ($value[0] == 'm') ? "M" : "F";
										break;
									case 'cupid' :
										$value = strtolower($value);
										$value = $value[0] == 's' ? "true" : "false";
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
		
		if (! Apretaste::isSimulator())
			Apretaste::saveProfile($email, $profile);
	}
	
	$profile = Apretaste::getAuthor($email);
	
	if ($updated)
		$data = array(
				"answer_type" => "profile_saved",
				"command" => "profile",
				"title" => "Su perfil ha sido actualizado"
		);
	else {
		if ($email == $from) {
			include_once "../cmds/state.php";
			$data = cmd_state($robot, $from, $argument, $body, $images);
		} else
			$data = array(
					"answer_type" => "profile",
					"command" => "profile",
					"title" => $email == $from ? "Su perfil en Apretaste!" : "Perfil de $email en Apretaste!"
			);
	}
	
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
	
	foreach ( $profile as $k => $v ) {
		
		if ($k != 'picture' && $k != 'birthdate' && $k != 'sex' && $k != 'email')
			
			if (is_string($v)) {
				$v = quoted_printable_decode($v);
				$profile[$k] = ucfirst($v);
			}
	}
	
	$data['sharethis'] = 'PERFIL ' . $email;
	$data['email'] = $email;
	$data['from'] = $from;
	$data = array_merge($data, $profile);
	
	return $data;
}