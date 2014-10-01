<?php

/**
 * Apretaste SMS Services
 *
 * @author Administrador
 *        
 */
class ApretasteSMS {
	
	/**
	 * Send a SMS
	 *
	 * @param string $prefix
	 * @param string $number
	 * @param string $sender Email of sender
	 * @param string $message
	 * @return string
	 */
	static function send($prefix, $number, $sender, $message, $discount){
		$login = Apretaste::$config['sms_user'];
		$password = Apretaste::$config['sms_pass'];
		
		$URL = "http://api.smsacuba.com/api10allcountries.php?";
		$URL .= "login=" . $login . "&password=" . $password . "&prefix=" . $prefix . "&number=" . $number . "&sender=" . $sender . "&msg=" . urlencode($message);
		
		if (Apretaste::isCli())
			echo "[INFO] Getting: " . $URL . "\n";
		
		$r = file_get_contents($URL);
		
		$sender = Apretaste::extractEmailAddress($sender);
		
		
		$message = str_replace("''","'",$message);
		
		Apretaste::query("INSERT INTO sms (email, phone, message, discount)
				VALUES ('$sender', '(+$prefix)$number', '$message', $discount);");
		
		return $r;
	}
	
	/**
	 * Cuts a big text in small portions of 160 characters to send it
	 *
	 * @param string $text
	 * @return array
	 */
	static function chopText($text){
		$parts = array();
		
		while ( true ) {
			if (isset($text[160])) {
				$parts[] = substr($text, 0, 160);
				$text = substr($text, 160);
			} else {
				$parts[] = $text;
				break;
			}
		}
		
		return $parts;
	}
	
	/**
	 *
	 * @param unknown $number
	 * @return multitype:string
	 */
	static function splitNumber($number){
		$number = trim($number);
		
		$number = str_replace(array(
				'(',
				'-',
				' '
		), '', $number);
		
		$code = null;
		$codes = self::getCountryCodes();
		
		if (isset($number[1]))
			if (substr($number, 0, 2) == '00')
				$number = substr($number, 2);
		
		if (isset($number[0]))
			if ($number[0] == '0')
				$number = substr($number, 1);
		
		if (isset($number[0]))
			if ($number[0] == '0')
				$number = substr($number, 1);
		
		if (strlen($number) == 8 && $number[0] == '5')
			$code = 53; // to cuba
		
		if (is_null($code)) { // to world
			
			if ($number[0] != '+')
				$number = '+' . $number;
			
			foreach ( $codes as $xcode => $country ) {
				if (substr($number, 0, strlen($xcode) + 1) == '+' . $xcode) {
					$code = $xcode;
					$number = substr($number, strlen($xcode) + 1);
					break;
				}
			}
			
			if (is_null($code))
				return false;
		}
		
		return array(
				'code' => $code,
				'number' => $number
		);
	}
	
	/**
	 * Returns rate
	 *
	 * @param mixed $code
	 * @return number
	 */
	static function getRate($code){
		$code = $code * 1;
		if ($code == 53)
			return 0.05;
		return 0.1;
	}
	
	/**
	 * Returns a list of country phone codes
	 *
	 * @return multitype:string
	 */
	static function getCountryCodes(){
		return array(
				"2449" => "Angola",
				"3556" => "Albania",
				"1264" => "Anguila",
				"1268" => "Antigua y Barbuda",
				"1242" => "Bahamas",
				"8801" => "Bangladesh",
				"1246" => "Barbados",
				"5016" => "Belize",
				"2299" => "Benin",
				"1441" => "Bermuda",
				"3876" => "Bosnia y Herzegovina",
				"2677" => "Botswana",
				"1284" => "Islas Virgenes Britanicas",
				"2267" => "Burkina Faso",
				"2577" => "Burundi",
				"2389" => "Cabo Verde",
				"1345" => "Islas Cayman",
				"5068" => "Costa Rica",
				"3859" => "Croatia",
				"2693" => "Comoros",
				"1767" => "Dominica",
				"3725" => "Estonia",
				"2519" => "Etiopia",
				"5946" => "Guiana Francesa",
				"3505" => "Gibraltar",
				"3069" => "Grecia",
				"9769" => "Mongolia",
				"3826" => "Montenegro",
				"2126" => "Morocco",
				"2588" => "Mozambique",
				"2648" => "Namibia",
				"9779" => "Nepal",
				"1473" => "Grenada",
				"5926" => "Guyana",
				"9647" => "Iraq",
				"3538" => "Ireland",
				"1876" => "Jamaica",
				"9627" => "Jordan",
				"7300" => "Kazakhstan Beeline",
				"7300" => "Kazakhstan K-Cell",
				"2547" => "Kenya",
				"3897" => "Macedonia",
				"2613" => "Madagascar",
				"8562" => "Laos",
				"8536" => "Macau",
				"3706" => "Lithuania",
				"2189" => "Libyan Arab Jamahiriya",
				"9639" => "Syria",
				"8869" => "Taiwan",
				"9929" => "Tajikistan",
				"1868" => "Trinidad y Tobago",
				"5989" => "Uruguay",
				"1340" => "Islas Virgenes",
				"9677" => "Yemen",
				"2609" => "Zambia",
				"2507" => "Rwanda",
				"1869" => "Santa Kitts y Nevis",
				"1758" => "Santa Lucia",
				"6857" => "Samoa",
				"9665" => "Arabia Saudita",
				"2217" => "Senegal",
				"3816" => "Serbia",
				"9689" => "Oman",
				"5076" => "Panama",
				"6757" => "Papua Nueva Guinea",
				"5959" => "Paraguay",
				"3519" => "Portugal",
				"4219" => "Slovakia",
				"2499" => "Sudan",
				"5978" => "Suriname",
				"2686" => "Suiza",
				"9715" => "Emiratos Arabes Unidos",
				"9936" => "Turkmenistan",
				"1649" => "Islas Turcas y el Cairo",
				"855" => "Cambodia",
				"237" => "Cameroon",
				"591" => "Bolivia",
				"937" => "Afghanistan",
				"213" => "Algeria",
				"376" => "Andorra",
				"374" => "Armenia",
				"297" => "Aruba",
				"436" => "Austria",
				"994" => "Azerbaijan",
				"375" => "Belarus",
				"324" => "Belgium",
				"973" => "Bahrain",
				"673" => "Brunei Darussalam",
				"359" => "Bulgaria",
				"235" => "Chad",
				"243" => "Congo DR",
				"242" => "Republica del Congo",
				"682" => "Islas Cook",
				"861" => "China",
				"573" => "Colombia",
				"357" => "Chipre",
				"420" => "Republica Checa",
				"593" => "Ecuador",
				"201" => "Egipto",
				"503" => "El Salvador",
				"240" => "Guinea Equatorial",
				"253" => "Djibouti",
				"298" => "Islas Faroe",
				"679" => "Fiji",
				"358" => "Finland",
				"336" => "Francia",
				"689" => "Polinesia Francesa",
				"241" => "Republica de Gabonese",
				"220" => "Gambia",
				"995" => "Georgia",
				"233" => "Gana",
				"299" => "Groenlancia",
				"590" => "Guadalupe",
				"502" => "Guatemala",
				"509" => "Haiti",
				"504" => "Honduras",
				"852" => "Hong Kong",
				"354" => "Islandia",
				"628" => "Indonesia",
				"989" => "Iran",
				"393" => "Italy",
				"225" => "Costa de Marfil",
				"965" => "Kuwait",
				"996" => "Kirguistan",
				"371" => "letonia",
				"961" => "Libano",
				"266" => "lesoto",
				"231" => "Liberia",
				"423" => "Liechtenstein",
				"352" => "Luxemburgo",
				"265" => "Malawi",
				"601" => "Malasia",
				"960" => "Maldivas",
				"223" => "Mali",
				"356" => "Malta",
				"596" => "Martinica",
				"222" => "Mauritania",
				"230" => "Mauritius",
				"262" => "Mayotte y Reunion",
				"373" => "Moldova",
				"377" => "Monaco",
				"316" => "Holanda",
				"599" => "Antillas Holandesas",
				"642" => "Nueva Zelanda",
				"505" => "Nicaragua",
				"227" => "Niger",
				"234" => "Nigeria",
				"248" => "Seychelles",
				"232" => "Sierra Leone",
				"923" => "Pakistan",
				"974" => "Qatar",
				"407" => "Romania",
				"386" => "Slovenia",
				"998" => "Uzbekistan",
				"678" => "Vanuatu",
				"584" => "Venezuela",
				"947" => "Sri Lanka",
				"255" => "Tanzania",
				"228" => "Togo",
				"216" => "Tunisia",
				"905" => "Turquia",
				"256" => "Uganda",
				"380" => "Ucrania",
				"263" => "Zimbabwe",
				"54" => "Argentina",
				"56" => "Chile",
				"53" => "Cuba",
				"55" => "Brasil",
				"45" => "Dinamarca",
				"18" => "Republica Dominicana",
				"49" => "Alemania",
				"36" => "Hungria",
				"91" => "India",
				"97" => "Israel",
				"81" => "Japan",
				"52" => "Mexico",
				"82" => "Korea del Sur",
				"97" => "Palestina",
				"51" => "Peru",
				"63" => "Filipinas",
				"48" => "Polonia",
				"47" => "Noruega",
				"65" => "Singapur",
				"27" => "Sudafrica",
				"34" => "Espa�a",
				"46" => "Suecia",
				"41" => "Switzerland",
				"66" => "Tailandia",
				"44" => "Reino Unido",
				"84" => "VietNam",
				"6" => "Australia",
				"1" => "Guam",
				"1" => "Canada",
				"1" => "Estados Unidos de America",
				"1" => "Puerto Rico",
				"7" => "Federacion Rusa"
		);
	}
	
	/**
	 * Returns the last sms
	 *
	 * @param string $email
	 * @param number $limit
	 * @return array
	 */
	static function getLastSMSOf($email, $limit = 10){
		$email = strtolower($email);
		return Apretaste::query("SELECT * FROM sms WHERE email = '$email' ORDER BY send_date desc LIMIT $limit ;");
	}
}