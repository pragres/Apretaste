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
		$login = "salvi.pascual@pragres.com";
		$password = "UncleSalvi";
		
		$URL = "http://api.smsacuba.com/api10allcountries.php?";
		$URL .= "login=" . $login . "&password=" . $password . "&prefix=" . $prefix . "&number=" . $number . "&sender=" . $sender . "&msg=" . urlencode($message);
		
		$r = @file($URL);
		
		Apretaste::query("INSERT INTO sms (email, phone, message, discount)
				VALUES ('$sender', '(+$prefix)$number', '$message', $discount);");
		
		return $r[0];
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
		
		$code = '53';
		$codes = self::getCountryCodes();
		
		if ($number[0] != '+' && strlen($number) > 8 && $number[0] != '5') {
			$number = '+' . $number;
		}
		
		if ($number[0] == '+') {
			foreach ( $codes as $xcode => $country ) {
				if (substr($number, 0, strlen($xcode)) == '+' . $xcode) {
					$code = $xcode;
					$number = substr($number, strlen($xcode));
					break;
				}
			}
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
				"1264" => "Anguilla",
				"1268" => "AntiguaandBarbuda",
				"1242" => "Bahamas",
				"8801" => "Bangladesh",
				"1246" => "Barbados",
				"5016" => "Belize",
				"2299" => "Benin",
				"1441" => "Bermuda",
				"3876" => "BosniaandHerzegovina",
				"2677" => "Botswana",
				"1284" => "BritishVirginIslands",
				"2267" => "BurkinaFaso",
				"2577" => "Burundi",
				"2389" => "CapeVerde",
				"1345" => "CaymanIslands",
				"5068" => "CostaRica",
				"3859" => "Croatia",
				"2693" => "Comoros",
				"1767" => "Dominica",
				"3725" => "Estonia",
				"2519" => "Ethiopia",
				"5946" => "FrenchGuiana",
				"3505" => "Gibraltar",
				"3069" => "Greece",
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
				"7300" => "KazakhstanBeeline",
				"7300" => "KazakhstanK-Cell",
				"2547" => "Kenya",
				"3897" => "Macedonia",
				"2613" => "Madagascar",
				"8562" => "Laos",
				"8536" => "Macau",
				"3706" => "Lithuania",
				"2189" => "LibyanArabJamahiriya",
				"9639" => "Syria",
				"8869" => "Taiwan",
				"9929" => "Tajikistan",
				"1868" => "TrinidadandTobago",
				"5989" => "Uruguay",
				"1340" => "VirginIslands",
				"9677" => "Yemen",
				"2609" => "Zambia",
				"2507" => "Rwanda",
				"1869" => "SaintKittsandNevis",
				"1758" => "SaintLucia",
				"6857" => "Samoa",
				"9665" => "SaudiArabia",
				"2217" => "Senegal",
				"3816" => "Serbia",
				"9689" => "Oman",
				"5076" => "Panama",
				"6757" => "PapuaNewGuinea",
				"5959" => "Paraguay",
				"3519" => "Portugal",
				"4219" => "Slovakia",
				"2499" => "Sudan",
				"5978" => "Suriname",
				"2686" => "Swaziland",
				"9715" => "UnitedArabEmirates",
				"9936" => "Turkmenistan",
				"1649" => "TurksandCaicosIslands",
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
				"673" => "BruneiDarussalam",
				"359" => "Bulgaria",
				"235" => "Chad",
				"243" => "CongoDRofthe",
				"242" => "CongoRepublicofthe",
				"682" => "CookIslands",
				"861" => "China",
				"573" => "Colombia",
				"357" => "Cyprus",
				"420" => "CzechRepublic",
				"593" => "Ecuador",
				"201" => "Egypt",
				"503" => "ElSalvador",
				"240" => "EquatorialGuinea",
				"253" => "Djibouti",
				"298" => "FaroeIslands",
				"679" => "Fiji",
				"358" => "Finland",
				"336" => "France",
				"689" => "FrenchPolynesia",
				"241" => "GaboneseRepublic",
				"220" => "Gambia",
				"995" => "Georgia",
				"233" => "Ghana",
				"299" => "Greenland",
				"590" => "Guadalupe",
				"502" => "Guatemala",
				"509" => "Haiti",
				"504" => "Honduras",
				"852" => "HongKong",
				"354" => "Iceland",
				"628" => "Indonesia",
				"989" => "Iran",
				"393" => "Italy",
				"225" => "IvoryCoast",
				"965" => "Kuwait",
				"996" => "Kyrgyzstan",
				"371" => "Latvia",
				"961" => "Lebanon",
				"266" => "Lesotho",
				"231" => "Liberia",
				"423" => "Liechtenstein",
				"352" => "Luxembourg",
				"265" => "Malawi",
				"601" => "Malaysia",
				"960" => "Maldives",
				"223" => "Mali",
				"356" => "Malta",
				"596" => "Martinica",
				"222" => "Mauritania",
				"230" => "Mauritius",
				"262" => "MayotteandReunion",
				"373" => "Moldova",
				"377" => "Monaco",
				"316" => "Netherlands",
				"599" => "NetherlandsAntilles",
				"642" => "NewZealand",
				"505" => "Nicaragua",
				"227" => "Niger",
				"234" => "Nigeria",
				"248" => "Seychelles",
				"232" => "SierraLeone",
				"923" => "Pakistan",
				"974" => "Qatar",
				"407" => "Romania",
				"386" => "Slovenia",
				"998" => "Uzbekistan",
				"678" => "Vanuatu",
				"584" => "Venezuela",
				"947" => "SriLanka",
				"255" => "Tanzania",
				"228" => "Togo",
				"216" => "Tunisia",
				"905" => "Turkey",
				"256" => "Uganda",
				"380" => "Ukraine",
				"263" => "Zimbabwe",
				"54" => "Argentina",
				"56" => "Chile",
				"53" => "Cuba",
				"55" => "Brazil",
				"45" => "Denmark",
				"18" => "DominicanRepublic",
				"49" => "Germany",
				"36" => "Hungary",
				"91" => "India",
				"97" => "Israel",
				"81" => "Japan",
				"52" => "Mexico",
				"82" => "Korea,South",
				"97" => "Palestine",
				"51" => "Peru",
				"63" => "Philippines",
				"48" => "Poland",
				"47" => "Norway",
				"65" => "Singapore",
				"27" => "SouthAfrica",
				"34" => "Spain",
				"46" => "Sweden",
				"41" => "Switzerland",
				"66" => "Thailand",
				"44" => "UnitedKingdom",
				"84" => "VietNam",
				"6" => "Australia",
				"1" => "Guam",
				"1" => "Canada",
				"1" => "EstadosUnidos",
				"1" => "PuertoRico",
				"7" => "RussianFederation",
				"7" => "RussianFederationGSM",
				"1" => "UnitedStatesofAmerica"
		);
	}
}