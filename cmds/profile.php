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
	
	$max_length_continue_value = 1000;
	
	$argument = trim($argument);
	
	if (Apretaste::checkAddress($argument) || Apretaste::isDevelopmentMode())
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
			),
			"about" => array(
					"acerca de",
					"acerca de mi",
					"sobre mi"
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
			),
			"about" => "#continue"
	);
	
	$updated = false;
	
	if ($email == $from) {
		$body = Apretaste::strip_html_tags($body);
		$body = quoted_printable_decode($body);
		$lines = explode("\n", $body);
		
		$profile = array();
		
		$continue_value = false;
		$continue_prop = false;
		
		foreach ( $lines as $idx => $line ) {
			$line = trim($line);
			if (strlen($line) > 3) {
				
				$robot->log("...profile line #$idx: $line ");
				
				$p = strpos($line, ":");
				$p1 = strpos($line, "=");
				
				if ($p !== false && $p1 !== false) {
					if ($p1 < $p)
						$p = $p1;
				} elseif ($p === false && $p1 !== false)
					$p = $p1;
				elseif ($p === false) {
					$p = strlen($line);
					$line = $line .= ' ';
				}
				
				$prop = substr($line, 0, $p);
				$value = substr($line, $p + 1);
				
				if ($value === false)
					$value = '';
				
				$prop = trim(strtolower($prop));
				$prop = Apretaste::replaceRecursive("  ", " ", $prop);
				
				$value = trim($value);
				
				if ($continue_prop !== false) {
					
					if (! isset($profile[$continue_prop]))
						$profile[$continue_prop] = '';
					
					if (! isset($profile[$continue_prop][$max_length_continue_value])) {
						
						$proced = true;
						
						$robot->log("..continue value at line #$idx");
						
						foreach ( $val as $kk => $vv ) {
							if ($prop == 'quitar foto' || $vv == $prop) {
								$proced = false;
								$continue_prop = false;
								break;
							}
						}
						
						if ($proced) {
							$prop = $properties[$continue_prop][0];
							$value = $profile[$continue_prop] . "\n" . $line;
						}
						
					} else
						$continue_prop = false;
				}
				
				
				
				foreach ( $properties as $key => $val ) {
					foreach ( $val as $kk => $vv ) {
						
						if ($prop == 'quitar foto') {
							$profile['picture'] = null;
						}
						
						if ($vv == $prop) {
							
							$robot->log("Updating profile's property $key = $value");
							
							if (isset($options[$key])) {
								$os = $options[$key];
								if (is_array($os)) {
									
									$value = trim(strtolower($value));
									
									if ($value == '')
										$value = null;
									else if (array_search($value, $os) === false)
										break;
								} else if ($os == '#date') {
									$value = trim(strtolower($value));
									
									if ($value == '')
										$value = null;
									else {
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
									}
								} else if ($os == 1) {
									$value = trim($value);
									$arr = explode(" ", $value);
									$value = $arr[0];
								} else if ($os == "#continue") {
									$continue_prop = $key;
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
		
		if (! Apretaste::isSimulator()) {
			Apretaste::saveProfile($email, $profile);
		}
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
			$img = base64_decode(Apretaste::resizeImage($profile['picture'], 150));
			
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