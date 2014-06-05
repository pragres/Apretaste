<?php

/**
 * Apretaste!com Model
 *
 * @author rafa <rafa@pragres.com>
 */
define("APRETASTE_INVITATION_REPEATED", "APRETASTE_INVITATION_REPEATED");
define("APRETASTE_INVITATION_UNNECESASARY", "APRETASTE_INVITATION_UNNECESASARY");
define("APRETASTE_INVITATION_SUCCESSFULL", "APRETASTE_INVITATION_SUCCESSFULL");
define("APRETASTE_INVITATION_STUPID", "APRETASTE_INVITATION_STUPID");
define("APRETASTE_INVITATION_GUEST_MISSING", "APRETASTE_INVITATION_GUEST_MISSING");
define("APRETASTE_SUBSCRIBE_SUCCESSFULL", "APRETASTE_SUBSCRIBE_SUCCESSFULL");
define("APRETASTE_SUBSCRIBE_UNKNOWN", "APRETASTE_SUBSCRIBE_UNKNOWN");
define("APRETASTE_ANNOUNCEMENT_NOTFOUND", "APRETASTE_ANNOUNCEMENT_NOTFOUND");
define("APRETASTE_INSERT_FAIL", "APRETASTE_INSERT_FAIL");
define("APRETASTE_UPDATE_TICKET_INVALID", "APRETASTE_UPDATE_TICKET_INVALID");
define("APRETASTE_ANNOUNCEMENT_DUPLICATED", "APRETASTE_ANNOUNCEMENT_DUPLICATED");
define("APRETASTE_SUBSCRIBE_DUPLICATED", "APRETASTE_SUBSCRIBE_DUPLICATED");
define("APRETASTE_ACCUSATION_DUPLICATED", "APRETASTE_ACCUSATION_DUPLICATED");
define("APRETASTE_ACCUSATION_SUCCESSFULL", "APRETASTE_ACCUSATION_SUCCESSFULL");
define("APRETASTE_COMMENT_SUCCESSFULL", "APRETASTE_COMMENT_SUCCESSFULL");
define("APRETASTE_MAX_WORD_LENGTH", 60);
class Apretaste {
	static $db = null;
	static $config = null;
	static $robot = null;
	static $price_regexp = null;
	static $phones_regexp = null;
	static $configuration = array();
	static function loadSetup(){
		if (is_null(self::$config))
			self::$config = parse_ini_file("../etc/apretaste.ini", true, INI_SCANNER_RAW);
	}
	
	/**
	 * Connect to database server
	 */
	static function connect(){
		self::loadSetup();
		
		if (is_null(self::$db)) {
			self::$db = @pg_connect(self::$config['database']);
			if (! self::$db) {
				$robot = new ApretasteEmailRobot($autostart = false, $verbose = true);
				Apretaste::$robot = &$robot;
				$data = array(
						'command' => 'error',
						'answer_type' => 'error',
						"from" => "anuncios@apretaste.com",
						"guest" => "rrodriguezramirez@gmail.com",
						"title" => "Servidor de bases de datos caido"
				);
				
				$config = array();
				
				foreach ( self::$robot->config_answer as $configx ) {
					$config = $configx;
					break;
				}
				
				// $answerMail = new ApretasteAnswerEmail($config, "rrodriguezramirez@gmail.com", self::$robot->smtp_servers, $data, true, true, false);
				return false;
			}
			return true;
		}
	}
	
	/**
	 * Logger
	 *
	 * @param string $message
	 * @param string $type
	 */
	static function log($message, $type = "ERROR", $rotate_time = false){
		$current_dir = getcwd();
		$d = dirname(__FILE__);
		chdir($d);
		
		$fn = "../log/$type.log";
		
		if (file_exists($fn)) {
			if ($rotate_time !== false) {
				if (time() - filectime($fn) >= $rotate_time) {
					file_put_contents($fn, "THE LOGS WAS ROTATED - " . date("Y-m-d h:i:s"));
				}
			}
		}
		
		$f = fopen($fn, "a");
		chdir($current_dir);
		fputs($f, date("Y-m-d h:i:s") . " - " . $message);
		fclose($f);
	}
	
	/**
	 * Database SQL query
	 *
	 * @param string $sql
	 * @return array
	 */
	static function query($sql, &$error = null){
		if (stripos($sql, 'vacuum') === false)
			$sql = 'set time zone -4;' . $sql;
		self::connect();
		$r = pg_query(self::$db, self::utf8Encode($sql));
		$s = pg_last_error(self::$db);
		// echo "[SQL] $sql \n";
		$error = $s;
		if (trim("$s") !== "")
			self::log("$sql -> $s\n", "SQL-ERRORS", 80000);
		return pg_fetch_all($r);
	}
	
	/**
	 * Get configuration value
	 *
	 * @param string $variable
	 * @return mixed
	 */
	static function getConfiguration($variable, $default = null){
		if (! isset(self::$configuration[$variable])) {
			self::$configuration[$variable] = $default;
			$r = self::query("select value from configuration where variable = '$variable';");
			if ($r)
				self::$configuration[$variable] = unserialize($r[0]['value']);
			else if (is_null($default))
				self::setConfiguration($variable, $default);
		}
		return self::$configuration[$variable];
	}
	
	/**
	 * Set configuration value
	 *
	 * @param string $variable
	 * @param mixed $value
	 */
	static function setConfiguration($variable, $value){
		$r = self::query("select value from configuration where variable = '$variable';");
		
		$value = serialize($value);
		if (! $r) {
			self::query("insert into configuration (variable, value) values ('$variable','$value');");
		} else {
			$r = self::query("update configuration set value = '$value' where variable = '$variable';");
		}
	}
	
	/**
	 * Extract prices from a text
	 *
	 * @param string $text
	 * @return array
	 */
	static function getPricesFrom($text){
		
		// trying the cases 17.000 20.500 etc... 20 000
		for($i = 0; $i < 10; $i ++) {
			$text = str_replace(".{$i}00", "{$i}00", $text);
			$text = str_replace(",{$i}00", "{$i}00", $text);
			$text = str_replace(" {$i}00", "{$i}00", $text);
		}
		
		if (is_null(self::$price_regexp))
			self::$price_regexp = self::getConfiguration("price_regexp");
		$regexp = self::$price_regexp;
		
		$regexp = str_replace("\\\\", "\\", $regexp);
		
		preg_match_all('/(\$?([0-9]+)\.?(\d{0,2}))\s*(pesos)?\s*(cuc)?\s*(mn)?\s*(cup)?/xi', $text, $matches);
		
		// preg_match_all($regexp, $text, $matches);
		
		$prices = array();
		
		foreach ( $matches[0] as $price ) {
			$price = trim($price);
			if (! is_numeric($price)) {
				
				if (stripos($price, "cuc"))
					$m = "CUC";
				elseif (stripos($price, "peso") || stripos($price, "mn") || stripos($price, "cup"))
					$m = "CUP";
				else
					$m = "\$";
				
				$prices[] = array(
						"value" => trim(str_ireplace(array(
								'$',
								'cuc',
								'pesos',
								'cup',
								'mn'
						), '', $price)),
						"currency" => $m
				);
			}
		}
		
		return $prices;
	}
	
	/**
	 * Check email address
	 *
	 * @param string $email
	 * @return boolean
	 */
	static function checkEmailAddress($email){
		// /^\w[-.\w]*@(\w[-._\w]*\.[a-zA-Z]{2,}.*)$/
		// ^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$
		$whitelist = self::getEmailWhiteList();
		foreach ( $whitelist as $k => $v )
			if ($v == "*") {
				unset($whitelist[$k]);
				break;
			}
		if (self::matchEmailPlus($email, $whitelist) == true)
			return true;
		$blacklist = self::getEmailBlackList();
		if (self::matchEmailPlus($email, $blacklist) == true)
			return false;
		if (preg_match_all("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email, $matches))
			return true;
		return false;
	}
	
	/**
	 * Extract phones from a text
	 *
	 * @param string $text
	 * @return string
	 */
	static function getPhonesFrom($text){
		$text = str_replace("\n", "", $text);
		$text = str_replace("\r", "", $text);
		
		$phones = array();
		if (is_null(self::$phones_regexp))
			self::$phones_regexp = self::getConfiguration("phones_regexp");
		$regexp = self::$phones_regexp;
		
		$regexp = str_replace("\\\\", "\\", $regexp);
		
		preg_match_all('/(\(?\+?\d{1,3}\)?\-?)?\d{3}-{0,}\d{2}-{0,}\d{0,2}/x', $text, $matches);
		
		// preg_match_all($regexp, $text, $matches);
		if (! is_null($matches))
			$phones = array_merge($phones, $matches);
		else
			$phones = array();
		
		$valid_phones = array();
		$cells = array();
		
		if (isset($phones[0]))
			foreach ( $phones[0] as $key => $p ) {
				
				$p = str_replace("-", "", $p);
				
				$l = strlen($p);
				if ($l < 7)
					continue;
				if (strpos($p, "00000") !== false)
					continue;
				
				if ($l == 6 && $p[0] == "0")
					continue;
				
				if ($l == 8 && $p[0] == "5")
					$p = "0" . $p;
				
				if ($l == 8 && $p[0] != "0")
					continue;
				
				$chk = md5($p);
				$p = str_replace("(53)5", "05", $p);
				
				$p = str_replace("(07)", "07", $p);
				$p = str_replace("7)", "07", $p);
				$p = str_replace(")", "", $p);
				$p = str_replace("(", "", $p);
				$p = str_replace("+", "", $p);
				
				if (substr($p, 0, 3) == "535")
					$p = "5" . substr($p, 3);
				
				$l = strlen($p);
				
				if (substr($p, 0, 2) == "05" && $l == 9) {
					$p = "5" . substr($p, 2);
					$cells[$p] = $p;
				} elseif (substr($p, 0, 3) == "535" && $l == 10) {
					$p = substr($p, 2);
					$cells[$p] = $p;
				} else {
					if (substr($p, 0, 2) == '53' && $l == 10)
						$p = substr($p, 2);
					$valid_phones[$p] = $p;
				}
			}
		
		$phones = array_merge($cells, $valid_phones);
		$phones = implode(", ", $phones);
		
		while ( strpos($phones, "--") )
			$phones = str_replace("--", "-", $phones);
		while ( strpos($phones, ", -,") )
			$phones = str_replace(", -,", ", ", $phones);
		while ( strpos($phones, ", ,") )
			$phones = str_replace(", ,", ", ", $phones);
		while ( strpos($phones, "-") )
			$phones = str_replace("-", "", $phones);
		
		return $phones;
	}
	
	/**
	 * Raw title
	 *
	 * @param string $title
	 * @return string
	 */
	static function rawTitle($title){
		while ( strpos($title, "  ") !== false )
			$title = str_replace("  ", " ", $title);
		$title = strtolower($title);
		$title = trim($title);
		$title = str_replace(" ", "-", $title);
		$chars = "abcdefghijklmnopqrstuvwxyz1234567890-";
		$l = strlen($title);
		$ntitle = "";
		for($i = 0; $i < $l; $i ++)
			if (strpos($chars, $title[$i]) !== false)
				$ntitle .= $title[$i];
			else
				$ntitle .= "-";
		return $ntitle;
	}
	
	/**
	 * Get announcement
	 *
	 * @param string $id
	 * @return array
	 */
	static function getAnnouncement($id){
		$r = self::query("SELECT *, post_date + interval '" . self::$config['announce_timelife'] . " days' as expire FROM announcement WHERE id = '$id'");
		
		if (! $r)
			return APRETASTE_ANNOUNCEMENT_NOTFOUND;
		
		$c = self::query("SELECT author, body FROM comment WHERE announcement = '$id';");
		
		$r = $r[0];
		
		$r['title'] = self::repairUTF8($r['title']);
		$r['title-raw'] = self::rawTitle($r['title']);
		$r['body'] = self::repairUTF8($r['body']);
		$r['title'] = str_replace("\n", " ", $r['title']);
		$r['title'] = str_replace("\r", " ", $r['title']);
		$r['title'] = str_replace("\r\n", " ", $r['title']);
		$r['title'] = str_replace("\n\r", " ", $r['title']);
		$r['title'] = strtolower($r['title']);
		$r['title'] = self::cleanTextJunk($r['title']);
		$r['body'] = self::cleanText($r['body']);
		
		$r['title'] = str_replace('<br />', ' ', $r['title']);
		$r['title'] = str_replace('<br/>', ' ', $r['title']);
		
		$r['emails'] = self::getAddressFrom($r['title'] . ' ' . $r['body']);
		$r['body'] = self::convertEmailToLinks($r['body'], $r['emails']);
		
		$r['image_type'] = str_replace("image/", "", $r['image_type']);
		if ($r['image_type'] == '')
			$r['image_type'] = 'jpeg';
		
		$r['image'] = self::resizeImage($r['image'], 300);
		
		$r['price'] = $r['price'] * 1;
		
		// Fix price
		if ($r['price'] == 0) {
			$prices = self::getPricesFrom($r['title'] . ' ' . $r['body'] . ' ');
			if (isset($prices[0])) {
				$sql = "update announcement set price = '{$prices[0]['value']}', currency = '{$prices[0]['currency']}' where id = '{$r['id']}';";
				self::query($sql);
				$r['price'] = $prices[0]['value'];
				$r['currency'] = $prices[0]['currency'];
			}
		}
		
		// Fix phones
		if (trim($r['phones']) == "") {
			$phones = self::getPhonesFrom($r['title'] . ' ' . $r['body'] . ' ');
			if (trim($phones) != "") {
				$sql = "update announcement set phones = '$phones' where id = '{$r['id']}';";
				self::query($sql);
				$r['phones'] = $phones;
			}
		}
		
		if (trim($r['phones']) !== "") {
			$phones = explode(",", $r['phones']);
			$r['phones'] = array();
			foreach ( $phones as $phone )
				$r['phones'][] = trim($phone);
		} else
			$r['phones'] = false;
		
		if (is_array($c))
			$r['comments'] = $c;
		else
			$r['comments'] = array();
		
		return $r;
	}
	
	/**
	 * Add visit
	 *
	 * @param string $id
	 * @param string $visitor
	 * @param string $ip
	 */
	static function addVisit($id, $visitor = null, $ip = null){
		$r = self::getAnnouncement($id);
		if (is_null($visitor) || (! is_null($visitor) && $visitor != $r['author'])) {
			if (is_null($visitor)) {
				self::query("INSERT INTO visit (announcement, ip) VALUES ('$id','$ip');");
			} else
				self::query("INSERT INTO visit (announcement, visitor) VALUES ('$id','$visitor');");
		}
	}
	
	/**
	 * Return true if the word exists in the vocabulary or in the ads
	 *
	 * @param string $w
	 * @param boolean $strict
	 * @return boolean
	 */
	static function existsWord($w, $strict = false){
		$r = self::query("SELECT * from vocabulary where word = '$w';");
		if ($r)
			return true;
		
		if ($strict == false) {
			$r = self::query("SELECT * from word where word = '$w' and length(word) > 3;");
			if ($r)
				return true;
		}
		return false;
	}
	
	/**
	 * White words
	 *
	 * @param string $s
	 * @return string
	 */
	static function getWhiteWords($s){
		$words = explode(" ", $s);
		
		$query = "";
		
		foreach ( $words as $word ) {
			$word = trim($word);
			$no = false;
			if ($word != "+" && $word != "-") {
				$r = self::query("SELECT * FROM word WHERE word = '$word' AND black = true;");
				if ($r)
					if (isset($r[0]))
						if ($r[0]['word'] == $word) {
							$no = true;
						}
			}
			if (! $no) {
				$query .= $word . " ";
			}
		}
		return $query;
	}
	
	/**
	 * Replace $count occurrences of the search string with the replacement string
	 *
	 * @param string $from
	 * @param string $to
	 * @param string $str
	 * @param integer $count
	 * @return string
	 */
	static function strReplace($from, $to, $str, $count = null){
		if ($from == "")
			return $str;
		if (is_null($count))
			$count = strlen($str);
		
		$pos = 0;
		$lfrom = strlen($from);
		for($i = 1; $i <= $count; $i ++) {
			if ($pos > strlen($str))
				break;
			$p = strpos($str, $from, $pos);
			if ($p === false)
				break;
			$pos = $p + 1;
			$str = substr($str, 0, $p) . $to . substr($str, $p + $lfrom);
		}
		
		return $str;
	}
	
	/**
	 * Quizas quiso decir
	 *
	 * @param string $query
	 * @return string
	 */
	static function didYouMean($query){
		$query = strtolower($query);
		$query = self::depura($query, "abcdefghijklmnopqrstuvwxyz1234567890+- @._");
		$words = explode(" ", $query);
		$newquery = array();
		
		foreach ( $words as $word ) {
			if (trim($word) == "")
				continue;
			if (self::existsWord($word, true)) {
				$newquery[] = $word;
				continue;
			}
			
			$cambios = array(
					"b,v",
					"v,b",
					"s,c",
					"s,x",
					"c,s",
					"c,p",
					"z,s",
					"s,z",
					"j,g",
					"g,j",
					"c,k",
					"k,c",
					"n,m",
					"m,n",
					"r,l",
					"l,r",
					"r,rr",
					"ll,y",
					"y,ll",
					"es,s",
					"ge,gue",
					"ao,ado",
					"t,tt",
					"dn,nd",
					"gi,gui",
					"ion,on",
					"on,ion",
					"np,mp",
					"nb,mb"
			);
			
			// h antes de vocal si vocal es primera
			$cambio = false;
			if (strpos("aeiou", $word[0]) !== false) {
				$w = "h$word";
				if (self::existsWord($w, true)) {
					$cambio = true;
					$newquery[] = $w;
				}
			}
			
			if ($cambio == false)
				foreach ( $cambios as $camb ) {
					$camb = explode(",", $camb);
					$l1 = $camb[0];
					$l2 = $camb[1];
					if (strpos($word, $l1) !== false && strpos($word, $l1) != strpos($word, $l2)) {
						$stop = false;
						for($c = 1; $c < 3; $c ++) {
							$w = self::strReplace($l1, $l2, $word, $c);
							if (self::existsWord($w)) {
								$cambio = true;
								$newquery[] = $w;
								$stop = true;
								break;
							}
						}
						if ($stop)
							break;
					}
				}
			
			if ($cambio == false)
				$newquery[] = $word;
		}
		
		$newquery = implode(" ", $newquery);
		
		if (trim($query) == trim($newquery)) {
			foreach ( $words as $w ) {
				$r = self::query("SELECT * FROM synonym WHERE word = '$w' OR synonym = '$w'
				OR substring(word from 1 for " . strlen($w) . ") = '$w'
				OR substring(synonym from 1 for " . strlen($w) . ") = '$w'
				ORDER BY length(word) + length(synonym) DESC;");
				
				if ($r)
					if (isset($r[0])) {
						foreach ( $r as $sym ) {
							if (strpos($newquery, $sym['word']) !== false) {
								$newquery = str_replace($sym['word'], $sym['synonym'], $newquery);
							} elseif (strpos($newquery, $sym['synonym']) !== false) {
								$newquery = str_replace($sym['synonym'], $sym['word'], $newquery);
							}
						}
					}
			}
		}
		
		return $newquery;
	}
	
	/**
	 * Reparar frase de busqueda
	 *
	 * @param string $frase
	 * @return string
	 */
	static function repairFrase($frase){
		$frase = str_replace("+", "[AND]", $frase);
		$frase = urldecode($frase);
		$frase = str_replace("[AND]", "+", $frase);
		$frase = self::utf8Encode($frase);
		$frase = str_replace("\\", "", $frase);
		$frase = str_ireplace(array(
				"'",
				";",
				"(",
				")",
				"--"
		), "", $frase);
		return $frase;
	}
	
	/**
	 * Repair UTF8 string
	 *
	 * @param string $text
	 * @return Ambigous <string, mixed>
	 */
	static function repairUTF8($text){
		if (self::isUTF8($text))
			$text = utf8_decode($text);
		
		$text = html_entity_decode($text, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
		$text = htmlentities($text);
		
		$tildes = array(
				'&aacute;' => '[a]',
				'&eacute;' => '[e]',
				'&iacute;' => '[i]',
				'&oacute;' => '[o]',
				'&uacute;' => '[u]',
				'&Aacute;' => '[A]',
				'&Eacute;' => '[E]',
				'&Iacute;' => '[I]',
				'&Oacute;' => '[O]',
				'&Uacute;' => '[U]',
				'&ntilde;' => '[n]',
				'&Ntilde;' => '[N]'
		);
		
		foreach ( $tildes as $s => $r )
			$text = str_replace($s, $r, $text);
		
		$text = html_entity_decode($text, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
		
		foreach ( $tildes as $s => $r ) {
			$text = str_replace($r, $s, $text);
		}
		
		return $text;
	}
	
	/**
	 * Return a valid FTS phrase for PgSQL
	 *
	 * @param string $phrase
	 * @return string
	 */
	static function getFTSPhrase($phrase){
		
		$phrase = str_replace("+", " + ", $phrase);
		$phrase = str_replace("-", " - ", $phrase);
		$phrase = str_replace("&", " ", $phrase);
		$phrase = str_replace("|", " ", $phrase);
		while ( strpos($phrase, "  ") !== false )
			$phrase = str_replace("  ", " ", $phrase);
		
		$arr = explode(" ", trim($phrase));
		
		$phrase = "";
		
		$symbol = false;
		
		foreach ( $arr as $word ) {
			$word = trim($word);
			
			if ($word == "+") {
				$symbol = true;
				$word = " & ";
			} else if ($word == "-") {
				$symbol = true;
				$word = ($phrase == "" ? "" : "& ") . " !";
			} else if ($word == "" && ! $symbol && $phrase != "") {
				$word = " |";
				$symbol = false;
			} else {
				$symbol = false;
			}
			
			if ($symbol == false && $phrase != "") {
				$phrase .= " | ";
			} else {
				$phrase .= " ";
			}
			
			$phrase .= strtolower(trim($word));
		}
		
		$phrase = str_replace("! ", "!", $phrase);
		$phrase = str_replace("& |", "&", $phrase);
		while ( strpos($phrase, "  ") !== false )
			$phrase = str_replace("  ", " ", $phrase);
		while ( strpos($phrase, "& &") !== false )
			$phrase = str_replace("& &", "&", $phrase);
		while ( strpos($phrase, "| |") !== false )
			$phrase = str_replace("| |", "|", $phrase);
		while ( strpos($phrase, "| !|") !== false )
			$phrase = str_replace("| !|", "|", $phrase);
		while ( strpos($phrase, "& !&") !== false )
			$phrase = str_replace("& !&", "&", $phrase);
		while ( strpos($phrase, "| !&") !== false )
			$phrase = str_replace("| !&", "|", $phrase);
		while ( strpos($phrase, "!| ") !== false )
			$phrase = str_replace("!| ", "!", $phrase);
		
		$phrase = trim($phrase);
		
		if (isset($phrase[0]))
			if ($phrase[0] == "&" || $phrase[0] == "|")
				$phrase = trim(substr($phrase, 1));
		
		return $phrase;
	}
	static function priorizaSustantivo($query, $preposicion){
		$p = strpos($query, " $preposicion ");
		$ll = strlen($preposicion) + 2;
		if ($p !== false) {
			if ($p + $ll < strlen($query)) {
				$ss = substr($query, $p + $ll) . " ";
				$kk = strpos($ss, " ");
				$w = substr($ss, 0, $kk);
				$query = $w . " " . substr($query, 0, $p /* + $ll */);
			}
		}
		return $query;
	}
	
	/**
	 * Interpretar frase de busqueda
	 *
	 * @param string $query
	 * @return string
	 */
	static function interpretaFrase($query){
		$query = self::priorizaSustantivo($query, "para");
		$query = self::priorizaSustantivo($query, "con");
		$query = self::priorizaSustantivo($query, "sin");
		if (stripos($query, "vendo") !== false) {
			$query = str_replace("vendo", "", $query);
			$query .= "+vendo";
		}
		if (stripos($query, "compro") !== false) {
			$query = str_replace("compro", "", $query);
			$query .= "+compro";
		}
		return $query;
	}
	
	/**
	 * Highlight text
	 *
	 * @param string $parr
	 * @param array $words
	 * @param integer $width
	 * @param string $tgi
	 * @param string $tgf
	 *
	 * @return string
	 */
	static function highlight($parr, $words, $width = 200, $tgi = "<strong>", $tgf = "</strong>"){
		$h = "";
		$l = strlen($parr);
		$fin = 0;
		foreach ( $words as $w ) {
			if ($h != "" && $w != "")
				if (strpos($h, $w) !== false) {
					$h = str_ireplace(" " . $w . " ", " $tgi{$w}$tgf ", $h);
					$h = str_ireplace(" " . $w . ",", " $tgi{$w}$tgf,", $h);
					$h = str_ireplace(" " . $w . ".", " $tgi{$w}$tgf.", $h);
					$h = str_ireplace(" " . $w . "s ", " $tgi{$w}s$tgf ", $h);
					$h = str_ireplace(" " . $w . "s,", " $tgi{$w}s$tgf,", $h);
					$h = str_ireplace(" " . $w . "s.", " $tgi{$w}s$tgf.", $h);
					$h = str_ireplace(" " . $w . "es ", " $tgi{$w}es$tgf ", $h);
					$h = str_ireplace(" " . $w . "es,", " $tgi{$w}es$tgf,", $h);
					$h = str_ireplace(" " . $w . "es.", " $tgi{$w}es$tgf.", $h);
					continue;
				}
			if (trim($w) == "")
				continue;
			if ($w == "+" || $w == "-")
				continue;
			$p = stripos($parr, $w, $fin);
			if ($p !== false) {
				$ini = $p - $width;
				if ($ini < 0)
					$ini = 0;
				$fin = $p + $width;
				if ($fin > $l)
					$fin = $l - 1;
				$h .= ($ini > 0 ? "..." : "") . substr($parr, $ini, $fin - $ini + 1) . "...";
				$h = str_ireplace(" " . $w . " ", " $tgi{$w}$tgf ", $h);
				$h = str_ireplace(" " . $w . ",", " $tgi{$w}$tgf,", $h);
				$h = str_ireplace(" " . $w . ".", " $tgi{$w}$tgf.", $h);
				$h = str_ireplace(" " . $w . "s ", " $tgi{$w}s$tgf ", $h);
				$h = str_ireplace(" " . $w . "s,", " $tgi{$w}s$tgf,", $h);
				$h = str_ireplace(" " . $w . "s.", " $tgi{$w}s$tgf.", $h);
				$h = str_ireplace(" " . $w . "es ", " $tgi{$w}es$tgf ", $h);
				$h = str_ireplace(" " . $w . "es,", " $tgi{$w}es$tgf,", $h);
				$h = str_ireplace(" " . $w . "es.", " $tgi{$w}es$tgf.", $h);
			}
		}
		
		if (trim($h) == "")
			return $parr;
		return $h;
	}
	
	/**
	 * Related phrases
	 *
	 * @param string $phrase
	 * @return array
	 */
	static function getRelatedPhrases($phrase = '', $didyoumean = false){
		$phrase = self::depura($phrase, ' abcdefghijklmnopqrstuvwxyz1234567890@.-_');
		
		$arr = self::query("select *
		                    from last_searchs_detail 
		                    where similar_text_percent(phrase,'$phrase')>0.5 and phrase != '$phrase'
		                    order by popularity desc 
		                    limit 5;");
		
		if (! is_array($arr))
			$arr = array();
		if ($didyoumean !== false) {
			$arr2 = self::getRelatedPhrases($didyoumean, false);
			if (! is_array($arr2))
				$arr2 = array();
			$arr = array_merge($arr, $arr2);
		}
		$rp = array();
		foreach ( $arr as $item )
			if ($item['phrase'] != $phrase) {
				$item['price_range'] = "";
				
				if ("{$item['pricemin']}" == "")
					$pmin = false;
				else
					$pmin = $item['pricemin'];
				if ("{$item['pricemax']}" == "")
					$pmax = false;
				else
					$pmax = $item['pricemax'];
				if ($pmin !== false && $pmax !== false) {
					$item['price_range'] = $pmin . '..' . $pmax;
					$item['pricemin'] = $pmin;
					$item['pricemax'] = $pmax;
				} elseif ($pmin !== false && $pmax === false) {
					$item['price_range'] = ' > ' . $pmin;
					$item['pricemin'] = $pmin;
					$item['pricemax'] = "";
				} elseif ($pmin === false && $pmax !== false) {
					$item['price_range'] = ' < ' . $pmax;
					$item['pricemin'] = "";
					$item['pricemax'] = $pmax;
				} else {
					$item['pricemin'] = "";
					$item['pricemax'] = "";
				}
				
				$rp[$item['phrase']] = $item;
			}
		if (count($rp) == 0)
			return false;
		return $rp;
	}
	
	/**
	 * Preparing the phrase
	 *
	 * @param string $phrase
	 * @return string
	 */
	static function preparePhrase($phrase){
		$symbols = array(
				"++" => "plusplus"
		);
		
		$phrase = self::utf8Encode($phrase);
		
		foreach ( $symbols as $symbol => $repl )
			$phrase = str_replace($symbol, $repl, $phrase);
		
		$phrase = self::interpretaFrase($phrase);
		
		$phrase = strtolower(self::repairFrase($phrase));
		
		$s = self::depura($phrase, "abcdefghijklmnopqrstuvwxyz1234567890 +-@._");
		
		$s = str_replace("+", " + ", $s);
		$s = str_replace("-", " - ", $s);
		$s = str_replace("  ", " ", $s);
		
		return $s;
	}
	
	/**
	 * Check if email address is correct
	 *
	 * @param string $email
	 * @return boolean
	 */
	static function checkAddress($email){
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		
		if (preg_match($regex, $email))
			return true;
		
		return false;
	}
	
	/**
	 * Extract email addresses from the text
	 *
	 * @param string $text
	 * @return array
	 */
	static public function getAddressFrom($text){
		$chars = '1234567890abcdefghijklmnopqrstuvwxyz._-@ ';
		
		$text = strtolower($text);
		
		// Cleanning the text
		for($i = 0; $i < 256; $i ++) {
			if (stripos($chars, chr($i)) === false) {
				$text = str_replace(chr($i), ' ', $text);
			}
		}
		
		$text = " $text ";
		
		$text = str_replace(". ", " ", $text);
		$text = str_replace(" .", " ", $text);
		$text = str_replace("- ", " ", $text);
		$text = str_replace("_ ", " ", $text);
		
		$text = trim($text);
		
		$words = explode(' ', $text);
		
		$addresses = array();
		foreach ( $words as $word ) {
			if (self::checkAddress($word)) {
				$addresses[] = $word;
			}
		}
		
		return $addresses;
	}
	/**
	 * Add a list of email addresses
	 *
	 * @param mixed $text
	 * @param string $source
	 */
	static public function addToAddressList($text, $source){
		$address = array();
		if (! is_array($text)) {
			$text = "$text";
			$address = Apretaste::getAddressFrom($text);
		} else
			$address = $text;
		
		$naddress = array();
		foreach ( $address as $addr ) {
			$addr = strtolower($addr);
			if (Apretaste::checkAddress($addr)) {
				$naddress[$addr] = $addr;
			}
		}
		
		$address = $naddress;
		
		foreach ( $address as $addr ) {
			self::query("
					INSERT INTO address_list (email, source)
					SELECT '$addr' as email, '$source' as source
					WHERE NOT EXISTS(SELECT * FROM address_list WHERE email = '$addr');");
		}
		
		return $address;
	}
	
	/**
	 * Convert to links the email addresses in the text
	 *
	 * @param string $text
	 * @param string $addresses
	 * @return string
	 */
	static function convertEmailToLinks($text, $addresses = null){
		if (is_null($addresses))
			$addresses = self::getAddressFrom($text);
		
		foreach ( $addresses as $address ) {
			$text = str_ireplace($address, '<a href="mailto:' . $address . '">' . $address . '</a>', $text);
		}
		
		return $text;
	}
	
	/**
	 * Repair acutes
	 *
	 * @param unknown $text
	 * @return string
	 */
	static function reparaTildes($text){
		$text = htmlentities($text, ENT_COMPAT | ENT_HTML401, 'UTF-8', false);
		$text = str_replace('&', '', $text);
		$text = str_replace('tilde;', '', $text);
		$text = str_replace('acute;', '', $text);
		$text = html_entity_decode($text, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
		return $text;
	}
	
	/**
	 * Search
	 *
	 * @param string $query
	 * @param integer $limit
	 * @param integer $offset
	 * @param boolean $stats
	 * @param string $email
	 * @param string $ad
	 * @param array $filter
	 * @return array
	 */
	static function search($query, $limit = 20, $offset = 0, $stats = true, $email = '', $ad = null, $filter = array()){
		if (intval($limit) < 1)
			$limit = 10;
		$orisha = $query;
		
		$pricing = array();
		
		$query = self::reparaTildes($query);
		
		$search = true;
		$ip = self::getClientIPAddress();
		$dwords = array();
		$words = array();
		$original = self::depura($orisha, ' abcdefghijklmnopqrstuvwxyz1234567890@.-_');
		
		$filtersql = "";
		if (isset($filter['photo']))
			$filtersql = " AND image is not null AND image <> ''";
		if (isset($filter['phone']))
			$filtersql .= " AND phones is not null and phones <> ''";
		if (isset($filter['price-min']) || isset($filter['price-max'])) {
			if (! isset($filter['price-min']) && isset($filter['price-max'])) {
				$filtersql .= " AND price <= {$filter['price-max']}";
			} elseif (! isset($filter['price-max']) && isset($filter['price-min'])) {
				$filtersql .= " AND price >= {$filter['price-min']} ";
			} elseif (isset($filter['price-max']) && isset($filter['price-min'])) {
				$filtersql .= " AND (price >= {$filter['price-min']} AND price <={$filter['price-max']})";
			}
		}
		
		if (self::checkAddress(trim($query))) {
			$query = trim($query);
			$r = self::query("SELECT count(*) as total FROM announcement WHERE title || ' ' || body ~* '$query'");
			if ($r[0]['total'] > 0) {
				$total = $r[0]['total'];
				$sql = "select announcement.id,
                    announcement.price,
                    announcement.title,
                    announcement.author,
                    announcement.body,
                    announcement.post_date,
                    announcement.hits,
                    announcement.image,
                    announcement.image_type,
                    announcement.image_name,
                    announcement.currency,
                    announcement.phones,
                    100 AS rank_title,
                    100 AS rank_body,
                    price is not null and price > 0 as have_price,
                    phones is not null and phones <> '' as have_phones
                    from announcement
                    WHERE title || ' ' || body ~* '$query'
                    $filtersql
                    ORDER BY
                    announcement.post_date DESC
                    offset $offset
                    limit $limit;";
				
				$results = self::query($sql);
				$search = false;
			}
		}
		
		if ($search) {
			
			if (trim($query) == "")
				return array(
						"results" => array(),
						"total" => 0,
						"dwords" => array(),
						"offset" => 0,
						"ads_of_author" => false
				);
			
			$symbols = array(
					"++" => "plusplus"
			);
			$s = self::preparePhrase($query);
			$words = explode(" ", $s);
			$query = "";
			
			foreach ( $words as $word ) {
				$word = trim($word);
				$no = false;
				if ($word != "+" && $word != "-") {
					$r = self::query("SELECT * FROM word WHERE word = '$word' AND black = true;");
					if ($r)
						if (isset($r[0]))
							if ($r[0]['word'] == $word) {
								$no = true;
							}
				}
				if (! $no) {
					$query .= $word . " ";
				}
			}
			
			// $synoms = array();
			$qq = $query;
			$words = explode(" ", trim($query));
			$wws = $words;
			foreach ( $wws as $w ) {
				if ($word != "+" && $word != "-") {
					$r = self::query("SELECT * FROM synonym WHERE word = '$w' OR synonym = '$w'
                OR substring(word from 1 for " . strlen($w) . ") = '$w'
                OR substring(synonym from 1 for " . strlen($w) . ") = '$w'
                ORDER BY length(word) + length(synonym) DESC;");
					
					if ($r)
						if (isset($r[0])) {
							foreach ( $r as $sym ) {
								if (strpos($qq, $sym['word']) !== false) {
									$words[] = $sym['synonym'];
									$qq = str_replace($sym['word'], "", $qq);
								} elseif (strpos($qq, $sym['synonym']) !== false) {
									$words[] = $sym['word'];
									$qq = str_replace($sym['synonym'], "", $qq);
								}
							}
						}
				}
			}
			
			$array = "'" . implode("','", $words) . "'";
			
			$array = str_replace(",'+',", ",", $array);
			$array = str_replace(",'-',", ",", $array);
			
			$query = self::getFTSPhrase($query);
			
			foreach ( $symbols as $symbol => $repl )
				$query = str_replace($repl, $symbol, $query);
			
			$query = trim($query);
			if (substr($query, strlen($query) - 1, 1) == "&")
				$query = substr($query, 0, strlen($query) - 1);
			
			if (trim($query) == "")
				return array(
						"results" => array(),
						"total" => 0,
						"dwords" => array(),
						"offset" => 0,
						"ads_of_author" => false
				);
			
			$ftitle = "coalesce(title,'')";
			$fbody = "coalesce(body,'')";
			$ftitlebody = "coalesce(title,'') || ' ' || coalesce(body,'')";
			
			$table_temp = "search_" . uniqid();
			
			$sql = "
			SELECT * INTO $table_temp FROM (
				SELECT 	id as ida, distinctive_word as dw,
					node_rank_by_phrase($ftitle, array[$array])::float4 as rank_title,
					node_rank_by_phrase($fbody, array[$array])::float4 as rank_body,
					case when coalesce(price,0) = 0 then 1 else 0 end as have_price,
					node_rank_by_phrase($ftitle, array[$array])::float4 * 0.90 
						+ node_rank_by_phrase($fbody, array[$array])::float4 * 0.10 as rank_global,
					case when coalesce(phones,'') <> '' then 0 else 1 end as have_phones,
					not external_id is null as is_external	
				FROM 
					announcement, 
					to_tsquery('$query') query 
				WHERE 
					" . (! is_null($ad) ? "id = '$ad' AND" : "") . "
					query @@ to_tsvector('english',$ftitlebody)
				$filtersql
			) AS subq 
			WHERE rank_global > 0";
			
			// echo $sql;
			
			self::query($sql);
			
			$r = self::query("select count(*) as cant from $table_temp;");
			
			$total = $r[0]['cant'];
			
			$sql = "
			select announcement.id,
	            announcement.price,
	            announcement.title,
	            announcement.author,
	            announcement.body,
	            announcement.post_date,
	            announcement.hits,
	            announcement.image,
	            announcement.image_type,
	            announcement.image_name,
	            announcement.currency,
	            announcement.phones,
	            announcement.external_id,
	            $table_temp.rank_title,
	            $table_temp.rank_body,
	            $table_temp.have_price,
	            $table_temp.have_phones,
	            $table_temp.rank_global,
	            $table_temp.is_external
            from announcement
	            inner join $table_temp on announcement.id = $table_temp.ida
            ORDER BY
	            (is_external and rank_title > 0),
	            $table_temp.rank_title DESC,
	            $table_temp.rank_body DESC,
	            $table_temp.rank_global DESC,
	            $table_temp.have_price,
	            $table_temp.have_phones,
	            announcement.post_date,
	            announcement.hits DESC
            offset $offset
            limit $limit;";
			
			// file_put_contents("sql.log", $sql."\n");
			
			$results = self::query($sql);
			
			$ids = array();
			
			if (is_array($results))
				foreach ( $results as $res )
					$ids[] = $res['id'];
			
			$sql = "select dw from $table_temp
	            where dw is not null and dw <> '" . implode("' and dw <> '", $words) . "'
	            and ida <> '" . implode("' and ida <> '", $ids) . "'
	            group by dw,rank_title,rank_body,have_price,have_phones
	            ORDER BY
	            rank_title DESC,
	            rank_body DESC,
	            have_price,
	            have_phones,
	            length(dw) desc
            limit 40";
			
			$rw = self::query($sql);
			
			if (is_array($rw))
				foreach ( $rw as $rec )
					$dwords[$rec['dw']] = $rec['dw'];
			
			$temp = $dwords;
			$dwords = array();
			foreach ( $temp as $word )
				$dwords[] = $word;
				
				// all ads
			$subq = "
			SELECT nano_titulo(announcement.title) as nanotitle, count(*) as cant
			FROM announcement
			inner join $table_temp 
			on announcement.id = $table_temp.ida 
			group by nanotitle";
			
			$allads = array(); // self::query($subq);
			                   
			// pricing
			$subq = "
			SELECT announcement.price 
			FROM announcement
			inner join $table_temp 
			on announcement.id = $table_temp.ida
			WHERE price is not null 
				AND rank_title > 0.2
			AND price > 0 AND price < 999999 ";
			
			// Precios altos
			$sql = "SELECT * FROM ($subq) as subq ORDER BY price DESC LIMIT 20;";
			$paltos = self::query($sql);
			
			$npaltos = array();
			if (is_array($paltos))
				foreach ( $paltos as $k => $p ) {
					$yes = true;
					if (strlen($p['price']) > 2) {
						for($ii = 1; $ii <= 9; $ii ++) {
							if ("{$p['price']}" == str_repeat("$ii", strlen("{$p['price']}")))
								$yes = false;
						}
					}
					if ($yes)
						$npaltos[] = $p;
				}
			
			$paltos = $npaltos;
			
			// Precios bajos
			$sql = "SELECT * FROM ($subq) as subq ORDER BY price LIMIT 20;";
			$pbajos = self::query($sql);
			
			// Precios populares
			$sql = "SELECT price, count(*) as cant FROM ($subq) as subq GROUP BY price ORDER BY cant desc LIMIT 20;";
			$ppop = self::query($sql);
			
			$showpricing = false;
			
			for($i = 0; $i < 10; $i ++) {
				$pricing[$i] = array();
				if (isset($paltos[$i])) {
					$pricing[$i][0] = $paltos[$i]['price'];
					$showpricing = true;
				} else
					$pricing[$i][0] = '';
				if (isset($pbajos[$i])) {
					$pricing[$i][1] = $pbajos[$i]['price'];
					$showpricing = true;
				} else
					$pricing[$i][1] = '';
				if (isset($ppop[$i])) {
					$pricing[$i][2] = $ppop[$i]['price'];
					$showpricing = true;
				} else
					$pricing[$i][2] = '';
			}
			
			if (! $showpricing)
				$pricing = false;
				
				// var_dump($pricing);
			
			self::query("drop table $table_temp;");
		}
		
		if (is_array($results)) {
			$sql = "UPDATE announcement SET appears = appears + 1 WHERE ";
			$yacota = false;
			foreach ( $results as $k => $v ) {
				$results[$k]['title'] = self::repairUTF8($results[$k]['title']);
				$results[$k]['title-raw'] = self::rawTitle($results[$k]['title']);
				$results[$k]['body'] = self::repairUTF8($results[$k]['body']);
				$results[$k]['title'] = str_replace("\n", " ", $results[$k]['title']);
				$results[$k]['title'] = str_replace("\r", " ", $results[$k]['title']);
				$results[$k]['title'] = str_replace("\r\n", " ", $results[$k]['title']);
				$results[$k]['title'] = str_replace("\n\r", " ", $results[$k]['title']);
				$results[$k]['title'] = strtolower($results[$k]['title']);
				$results[$k]['title'] = self::cleanTextJunk($results[$k]['title']);
				$results[$k]['body'] = self::cleanTextJunk($results[$k]['body']);
				$results[$k]['price'] = $results[$k]['price'] * 1;
				$results[$k]['cota'] = false;
				
				$rank_global = $results[$k]['rank_global'] * 1;
				$rank_title = $results[$k]['rank_title'] * 1;
				
				if (($rank_title == 0 && $rank_global < 0.3) || $rank_global < 0.4) {
					if (! $yacota) {
						$results[$k]['cota'] = true;
						$yacota = true;
					}
				}
				
				if (isset($v['image']))
					if ("{$v['image']}" != '') {
						$results[$k]['image'] = self::resizeImage($v['image'], 100);
					}
				
				$sql .= "id = '{$v['id']}' OR ";
				
				if ($results[$k]['phones'] != "") {
					$phones = explode(",", $results[$k]['phones']);
					$results[$k]['phones'] = array();
					foreach ( $phones as $phone )
						$results[$k]['phones'][] = trim($phone);
				} else
					$results[$k]['phones'] = false;
				
				$results[$k]['body'] = self::highlight($results[$k]['body'], $words);
				$results[$k]['body'] = str_replace(array(
						"<br>",
						"<br/>",
						"<br />"
				), " ", $results[$k]['body']);
				$results[$k]['body'] = str_replace(array(
						"<p align=\"justify\">",
						"<p>",
						"</p>"
				), " ", $results[$k]['body']);
				$results[$k]['body'] = str_replace(array(
						"\n",
						"\n\r"
				), " ", $results[$k]['body']);
				$results[$k]['emails'] = self::getAddressFrom($results[$k]['title'] . ' ' . $results[$k]['body']);
				$results[$k]['body'] = self::convertEmailToLinks($results[$k]['body'], $results[$k]['emails']);
			}
			
			$sql .= " FALSE;";
			
			Apretaste::query($sql);
		}
		
		if ($stats == true) {
			if (isset($filter['price-min']))
				$pricemin = $filter['price-min'];
			else
				$pricemin = 'null';
			if (isset($filter['price-max']))
				$pricemax = $filter['price-max'];
			else
				$pricemax = 'null';
			$withphoto = 'false';
			$withphone = 'false';
			if (isset($filter['photo']))
				if ($filter['photo'] === true || $filter['photo'] == 'on')
					$withphoto = 'true';
			if (isset($filter['phone']))
				if ($filter['phone'] === true || $filter['phone'] == 'on')
					$withphone = 'true';
			$total = intval($total);
			$sql = "INSERT INTO search_history (phrase, email, host, results, pricemin, pricemax, with_photo, with_phone) VALUES ('$original', '$email', '$ip', $total, $pricemin, $pricemax, $withphoto, $withphone);";
			self::query($sql);
		}
		
		$recommended = false;
		if ($search)
			$recommended = self::generateRecommendedPhrases($original, 30);
		
		return array(
				"results" => $results,
				"total" => $total,
				"dwords" => $dwords,
				"offset" => $offset,
				"ads_of_author" => ! $search,
				"pricing" => $pricing,
				"recommended_phrases" => $recommended,
				"allads" => $allads
		);
	}
	
	/**
	 * Resize image
	 *
	 * @param base64 $image
	 * @param integer $width
	 * @return base64
	 */
	static function resizeImage($image, $width = 100){
		if (sizeof($image) <= 100)
			return $image;
		
		$fname = uniqid("image-", true);
		$folder = "../tmp";
		if (file_exists("/tmp"))
			$folder = "/tmp";
		file_put_contents("$folder/$fname", base64_decode($image));
		$im = new rpImageThumb("$folder/$fname");
		if ($im->width >= $width)
			$im->resize($width, "width");
		ob_start();
		$im->show();
		$rimage = base64_encode(ob_get_contents());
		if (is_null($rimage) || $rimage == '' || $rimage === false)
			$rimage = $image;
		ob_end_clean();
		unlink("$folder/$fname");
		return $rimage;
	}
	
	/**
	 * Prevent the injections
	 *
	 * @param string $str
	 * @return string
	 */
	static function preventInjections($str){
		/*
		 * if(!get_magic_quotes_gpc()) { $str = addslashes($str); }
		 */
		$str = strip_tags(htmlspecialchars($str));
		return $str;
	}
	static function uniq(){
		$chars = "abcdefghijklmnopqrstuvwxyz1234567890";
		$u = "";
		$l = strlen($chars) - 1;
		for($i = 0; $i < 14; $i ++)
			$u .= $chars[mt_rand(0, $l)];
		return strtoupper($u);
	}
	
	/**
	 * Insert announcement
	 *
	 * @param string $from
	 * @param string $title
	 * @param string $body
	 * @param string $image
	 */
	static function insert($from, $title, $body, $images = array(), $price = 0, $phones = null, $author_name = null, $external_id = null, $external_source = null, $currency = "CUC", $update = false, $ticket = false){
		$title = str_replace("\n", " ", $title);
		$title = str_replace("\r", " ", $title);
		$title = str_replace("\r\n", " ", $title);
		$title = str_replace("\n\r", " ", $title);
		
		$body = str_replace(array(
				"<br>",
				"</br>",
				"</p>"
		), "\n", $body);
		
		$body = preg_replace('{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', "", $body);
		$body = str_replace('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">', '', $body);
		
		$body = self::preventInjections($body);
		$title = self::preventInjections($title);
		
		$max_title_length = self::getConfiguration("max_title_length", 100);
		$max_body_length = self::getConfiguration("max_body_length", 7 * 1024);
		
		$title = substr($title, 0, $max_title_length) . (strlen($title) > $max_title_length ? "..." : "");
		$body = substr($body, 0, $max_body_length) . (strlen($body) > $max_body_length ? "(...)" : "");
		
		if (is_null($phones))
			$phones = self::getPhonesFrom($title || ' ' || $body);
		
		do {
			$checksum = md5($body);
			$body = str_replace("\n\n", "\n", $body);
		} while ( $checksum != md5($body) );
		
		$body = trim($body);
		
		$price = $price * 1;
		$phones = str_replace("'", "''", $phones);
		
		if (is_null($author_name))
			$author_name = '';
		$author_name = str_replace("'", "''", $author_name);
		
		$image = '';
		$image_type = '';
		$image_name = '';
		if (is_array($images))
			if (isset($images[0])) {
				$image = $images[0]['content'];
				$image_type = $images[0]['type'];
				$image_name = $images[0]['name'];
			}
		
		$image_type = str_replace("image/", "", $image_type);
		
		if ($update == false)
			$ticket = self::uniq();
		$fa = date("Y-m-d");
		
		if (! $update) {
			$id = self::uniq();
		} else {
			$sql = "select id from announcement where ticket = '$ticket' AND author = '$from';";
			$r = self::query($sql);
			if (! is_array($r))
				return APRETASTE_INSERT_FAIL;
			
			$id = $r[0]['id'];
			$ad = self::getAnnouncement($id);
			if (is_null($external_id))
				$external_id = $ad['external_id'];
			if (is_null($external_source))
				$external_source = $ad['external_source'];
		}
		
		$title = str_replace("''", "'", $title);
		$title = str_replace("'", "''", $title);
		
		$body = str_replace("''", "'", $body);
		$body = str_replace("'", "''", $body);
		
		if ($image == '')
			$image = 'null';
		else
			$image = "'$image'";
		if ($image_type == '')
			$image_type = 'null';
		else
			$image_type = "'$image_type'";
		if ($image_name == '')
			$image_name = 'null';
		else
			$image_name = "'$image_name'";
		
		if (is_null($external_id))
			$external_id = 'null';
		else
			$external_id = "'$external_id'";
		if (is_null($external_source))
			$external_source = 'null';
		else
			$external_source = "'$external_source'";
		
		$error = "";
		if (! $update) {
			
			$r = self::query("INSERT INTO announcement (id, title, author, body, post_date, ticket, image, image_type,
                    image_name, price, phones, author_name, external_id, external_source, currency)
                    VALUES ('$id', '$title','$from', '$body', '$fa', '$ticket', $image, $image_type,
                    $image_name, $price,'$phones','$author_name', $external_id,$external_source,
                    '$currency');", $error);
			
			if (trim($error) != "") {
				if (stripos($error, "ANNOUNCEMENT DUPLICATED") !== false)
					return APRETASTE_ANNOUNCEMENT_DUPLICATED;
			}
		} else {
			$sql = "UPDATE announcement SET
							title = '$title', 
							body = '$body', 
							post_date = CURRENT_DATE,";
			
			if ($image != 'null')
				$sql .= "image = $image,
										image_type = $image_type, 
										image_name = $image_name,";
			$sql .= "price = $price,
					phones = '$phones', 
					author_name = '$author_name',";
			
			if ($external_id != 'null')
				$sql .= "external_id = $external_id,
					external_source = $external_source,";
			
			$sql .= "
					currency = '$currency'
					WHERE id = '$id' and author = '$from';";
			
			$r = self::query($sql, $error);
		}
		
		// Rollback transaction
		$item = self::getAnnouncement($id);
		if ($item === APRETASTE_ANNOUNCEMENT_NOTFOUND) {
			return APRETASTE_INSERT_FAIL;
		}
		
		Apretaste::query("update announcement set distinctive_word = get_best_representation(split_keywords(title || ' ' || body)), distinctive_word_date = current_date where id = '$id';");
		
		// esta llamada se retira por un trigger en la db
		// self::outbox($id, $from);
		
		$r = self::linker($id, $from);
		
		if ($external_id == 'null')
			self::saveAuthor($from, array(
					'phones' => $phones,
					'historical_ads' => 'historical_ads + 1'
			));
		
		$xphones = self::getPhonesFrom($title . ' ' . $body);
		$xemails = self::getAddressFrom($title . ' ' . $body);
		$contact_info = ! (trim($xphones) == '' && ! isset($xemails[0]) && trim($phones) == '');
		
		return array(
				'id' => $id,
				'ticket' => $ticket,
				'post_date' => $fa,
				'search_results' => $r['results'],
				'oferta' => $r['oferta'],
				'contact_info' => $contact_info
		);
	}
	
	/**
	 * Clean the subcribes data
	 */
	static function cleanSubscribes(){
		self::query("DELETE FROM subscribe WHERE phrase is null;");
		self::query("DELETE FROM subscribe WHERE trim(phrase) = '';");
		self::query("UPDATE subscribe SET phrase = lower(phrase);");
		self::query("UPDATE subscribe SET phrase = replace(phrase,'frase_a_buscar:','');");
		self::query("UPDATE subscribe SET phrase = replace(phrase,'frase a buscar ','');");
		self::query("UPDATE subscribe SET phrase = replace(replace(phrase,'buscar ',''),',','');");
	}
	
	/**
	 * Outbox subscribe
	 *
	 * @param string $ad
	 */
	static function outbox($ad, $email){
		if (self::isExcluded($email))
			return false;
		
		echo "[INFO] " . date("Y-m-d h:i:s") . " - Analyzing $ad of $email for outbox\n";
		
		self::cleanSubscribes();
		
		$subs = self::query("SELECT * FROM subscribe WHERE email <> '$email';");
		if ($subs) {
			foreach ( $subs as $sub ) {
				// echo "[INFO] " . date("Y-m-d h:i:s") . " - Searching $ad: {$sub['phrase']}\n";
				
				// $s = self::search($sub['phrase'], 1, 0, false, '', $ad);
				
				// only FTS, more fast
				$sql = "SELECT plainto_tsquery('" . str_replace("'", "''", $sub['phrase']) . "') @@ to_tsvector(title || ' ' || body) as result FROM announcement WHERE id = '$ad';";
				
				$s = self::query($sql);
				$s = $s[0];
				
				if ($s['result'] == 't') {
					// $s = $s['results'];
					// if (isset($s[0])) {
					// if ($s[0]['id'] == $ad) {
					// if ($s[0]['rank_title'] * 1 > 0) {
					$r = self::query("SELECT * FROM outbox WHERE announcement = '$ad' AND email = '{$sub['email']}'");
					if (! $r)
						self::query("INSERT INTO outbox(announcement, subscribe, email) VALUES ('$ad','{$sub['id']}','{$sub['email']}');");
					// }
					// }
				}
			}
		}
	}
	
	/**
	 * Check announcement duplicate
	 *
	 * @param string $title
	 * @param string $body
	 * @param string $author
	 * @return boolean
	 */
	static function checkDuplicate($title, $body, $author){
		$hist = self::getConfiguration("enable_history");
		self::setConfiguration("enable_history", false);
		$title = str_replace("'", "''", $title);
		$body = str_replace("'", "''", $title);
		$author = str_replace("'", "''", $title);
		
		/*
		 * $r = self::query(" SELECT * FROM announcement WHERE similar_text_percent(lower(depura(title)), lower(depura('$title'))) >= 0.99 AND similar_text_percent(lower(depura(body)),lower(depura('$body'))) >= 0.99 AND author = '$author';");
		 */
		// if ($r) return true;
		// return false;
		
		$r = self::query("SELECT depura('$title') as d;");
		$title = strtolower($r[0]['d']);
		
		$r = self::query("SELECT depura('$body') as d;");
		$body = strtolower($r[0]['d']);
		
		self::query("
		DELETE FROM announcement 
		WHERE lower(depura(title)) = '$title'
		AND author = '$author';");
		
		self::query("
		DELETE FROM announcement 
		WHERE (similar_text_percent(lower(depura(title)), '$title') >= 0.95 
		OR similar_text_percent(lower(depura(body)), '$body') >= 0.95)
		AND author = '$author';");
		
		self::setConfiguration("enable_history", $hist);
		return false;
	}
	
	/**
	 * Delete announcement
	 *
	 * @param string $from
	 * @param string $ticket
	 * @return mixed
	 */
	static function delete($from, $ticket){
		$ticket = str_replace(array(
				"'",
				" "
		), "", $ticket);
		$r = self::query("SELECT * FROM announcement WHERE ticket = '$ticket' AND author = '$from'");
		
		if ($r) {
			self::query("DELETE FROM announcement WHERE id = '{$r[0]['id']}';");
			return $r[0];
		}
		
		return APRETASTE_ANNOUNCEMENT_NOTFOUND;
	}
	
	/**
	 * Return the announcements of author
	 *
	 * @param string $author
	 * @return array
	 */
	static function getAnnouncementsOf($author){
		$r = self::query("SELECT id FROM announcement WHERE author = '$author';");
		$result = array();
		if (is_array($r))
			foreach ( $r as $item ) {
				$result[] = self::getAnnouncement($item['id']);
			}
		return $result;
	}
	
	/**
	 * Subscribe
	 *
	 * @param string $from
	 * @param string $phrase
	 * @return mixed
	 */
	static function subscribe($from, $phrase){
		Apretaste::cleanSubscribes();
		
		$phrase = str_replace("'", "''", $phrase);
		$phrase = trim(strtolower($phrase));
		$r = self::query("SELECT * FROM subscribe WHERE email = '$from' AND phrase = '$phrase';");
		if (! $r) {
			$id = uniqid();
			self::query("INSERT INTO subscribe (id, email, phrase) VALUES ('$id', '$from', '$phrase');");
			return $id;
		}
		return APRETASTE_SUBSCRIBE_DUPLICATED;
	}
	
	/**
	 * Return the subscribes of author
	 *
	 * @param string $email
	 * @return array
	 */
	static function getSubscribesOf($email){
		$r = self::query("SELECT * FROM subscribe WHERE extract_email(email) = extract_email('$email');");
		return $r;
	}
	
	/**
	 * Envio de alerta segun subscripciones
	 *
	 * @param mail_robot $robot
	 */
	static function shipment(&$robot){
		
		// connect to database
		self::connect();
		
		$max = self::getConfiguration("outbox.max");
		
		if (is_null($max)) {
			self::setConfiguration("outbox.max", 20);
			$max = 20;
		}
		
		// get receivers
		$receivers = self::query("SELECT email FROM outbox GROUP BY email LIMIT $max;");
		
		$answers = array();
		
		if ($receivers) {
			
			if (is_array($receivers))
				foreach ( $receivers as $r ) {
					
					$ads = self::query("SELECT * FROM outbox inner join subscribe on subscribe.id = outbox.subscribe WHERE outbox.email = '{$r['email']}'");
					
					if (! $ads)
						continue;
					if (! is_array($ads))
						continue;
					
					$data = array(
							'command' => 'search',
							'answer_type' => 'search_results',
							'query' => '',
							'search_results' => array(),
							"showminimal" => true,
							"compactmode" => true,
							"alerta" => true,
							"title" => "Alertas por correo ",
							'pricing' => array(),
							'allads' => array()
					);
					
					foreach ( $ads as $adx ) {
						$ad = self::getAnnouncement($adx['announcement']);
						self::query("DELETE FROM outbox WHERE announcement = '{$adx['announcement']}';");
						$ad['tax'] = $adx['phrase'];
						$data['search_results'][] = $ad;
					}
					
					$results = $data['search_results'];
					foreach ( $results as $k => $v ) {
						$results[$k]['title'] = htmlentities(utf8_decode($results[$k]['title']));
						$results[$k]['title-raw'] = self::rawTitle($results[$k]['title']);
						$results[$k]['body'] = htmlentities(utf8_decode($results[$k]['body']));
						$results[$k]['title'] = str_replace("\n", " ", $results[$k]['title']);
						$results[$k]['title'] = str_replace("\r", " ", $results[$k]['title']);
						$results[$k]['title'] = str_replace("\r\n", " ", $results[$k]['title']);
						$results[$k]['title'] = str_replace("\n\r", " ", $results[$k]['title']);
						$results[$k]['title'] = strtolower($results[$k]['title']);
						$results[$k]['title'] = self::cleanTextJunk($results[$k]['title']);
						$results[$k]['body'] = self::cleanTextJunk($results[$k]['body']);
						$results[$k]['price'] = $results[$k]['price'] * 1;
						
						// Analyzing images
						if (isset($v['image']))
							if ("{$v['image']}" != '') {
								$results[$k]['image'] = self::resizeImage($v['image'], 100);
							}
						
						$item = $v;
						if (isset($item['image'])) {
							if ("{$item['image']}" != '') {
								
								if (isset($item['image_type']))
									$item['image_type'] = str_replace("image/", "", $item['image_type']);
								
								if (! isset($data['images']))
									$data['images'] = array();
								
								$data['images'][] = array(
										"type" => "image/{$item['image_type']}",
										"content" => base64_decode($item['image']),
										"name" => $item['image_name'],
										"id" => $item['id']
								);
								$data['search_results'][$k]['image'] = true;
							} else {
								$data['search_results'][$k]['image'] = false;
							}
						} else {
							$data['search_results'][$k]['image'] = false;
						}
						
						// Phones
						if ($results[$k]['phones'] != "") {
							$phones = array();
							if (! is_array($results[$k]['phones']))
								$phones = explode(",", $results[$k]['phones']);
							
							$results[$k]['phones'] = array();
							
							if (is_array($phones))
								foreach ( $phones as $phone )
									$results[$k]['phones'][] = trim($phone);
						} else
							$results[$k]['phones'] = false;
							
							// Other stuff
							// $results[$k]['body'] = self::highlight($results[$k]['body'], $words);
						$results[$k]['body'] = str_replace(array(
								"<br>",
								"<br/>",
								"<br />"
						), " ", $results[$k]['body']);
						$results[$k]['body'] = str_replace(array(
								"<p align=\"justify\">",
								"<p>",
								"</p>"
						), " ", $results[$k]['body']);
						$results[$k]['body'] = str_replace(array(
								"\n",
								"\n\r"
						), " ", $results[$k]['body']);
						$results[$k]['emails'] = self::getAddressFrom($results[$k]['title'] . ' ' . $results[$k]['body']);
						$results[$k]['body'] = self::convertEmailToLinks($results[$k]['body'], $results[$k]['emails']);
					}
					
					$data['search_results'] = $results;
					
					echo "[INFO] Alert shipment to {$r['email']}\n";
					
					$data['image_src'] = 'cid:{$id}';
					
					if (! self::isExcluded($r['email'])) {
						
						$config = array();
						
						foreach ( self::$robot->config_answer as $configx ) {
							$config = $configx;
							break;
						}
						
						$data['images'] = array(); // TODO: no images?
						
						if (isset($data['search_results'][0])) {
							
							if (! isset($answers[$r['email']]))
								$answers[$r['email']] = $data;
							else
								$answers[$r['email']]['search_results'] = array_merge($answers[$r['email']]['search_results'], $data['search_results']);
						}
					}
				}
				
				// send answers
			foreach ( $answers as $email => $data ) {
				$answerMail = new ApretasteAnswerEmail($config, $email, $robot->smtp_servers, $data, true, false, false);
			}
		}
		/*
		 * // Load the outbox $outbox = self::query("SELECT * FROM outbox inner join subscribe on subscribe.id = outbox.subscribe order by outbox.fa desc;"); $r = self::query("SELECT count(*) as cant FROM outbox inner join announcement on outbox.announcement = announcement.id;"); $pass = false; if (intval($r[0]['cant']) > 0) $pass = true; if ($outbox) { if (count($outbox) >= $max || $pass) { // Preparing the shipments $shipments = array(); foreach ( $outbox as $ob ) { if (! isset($shipments[$ob['email']])) $shipments[$ob['email']] = array( "resutls" => array(), "query" => $ob['phrase'], "subscribe" => $ob['id'] ); $ad = self::getAnnouncement($ob['announcement']); if (! is_null($ad) && $ad != false && $ad != APRETASTE_ANNOUNCEMENT_NOTFOUND) $shipments[$ob['email']]['results'][] = $ad; self::query("DELETE FROM outbox where announcement = '{$ob['announcement']}' AND email = '{$ob['email']}';"); } // Sending... foreach ( $shipments as $email => $shp ) { $data = array( 'command' => 'search', 'answer_type' => 'search_results', 'query' => $shp['query'], 'search_results' => $shp['results'], "showminimal" => false, "alerta" => true, "title" => "Alerta por correo: " . $shp['query'], "subscribe" => $shp['subscribe'] ); echo "[INFO] Alert shipment {$shp['query']} to $email\n"; $data['image_src'] = 'cid:{$id}'; if (! self::isExcluded($email)) { $config = array(); foreach ( self::$robot->config_answer as $configx ) { $config = $configx; break; } $answerMail = new ApretasteAnswerEmail($config, $email, $robot->smtp_servers, $data, true, false, false); } } } }
		 */
	}
	
	/**
	 * Accusations
	 *
	 * @param string $from
	 * @param string $reason
	 * @param string $announcement
	 * @return mixed
	 */
	static function accusation($from, $reason, $announcement){
		$a = Apretaste::getAnnouncement($announcement);
		
		if ($a == APRETASTE_ANNOUNCEMENT_NOTFOUND || $a === false)
			return APRETASTE_ANNOUNCEMENT_NOTFOUND;
		
		$r = self::query("SELECT * FROM accusation where author = '$from' and reason = '$reason' and announcement = '$announcement';");
		
		if ($r)
			return APRETASTE_ACCUSATION_DUPLICATED;
		
		self::query("insert into accusation (author, reason, announcement) values ('$from','$reason','$announcement');");
		
		return APRETASTE_ACCUSATION_SUCCESSFULL;
	}
	
	/**
	 * Invitation
	 *
	 * @param string $from
	 * @param string $guest
	 * @return string constant
	 */
	static function invite($from, $guest){
		$from = trim($from);
		
		$guest = trim($guest);
		
		if ($guest == '')
			return APRETASTE_INVITATION_GUEST_MISSING;
		
		if ($from == $guest)
			return APRETASTE_INVITATION_STUPID;
		
		$r = self::query("SELECT * FROM invitation where author = '$from' and guest = '$guest';");
		if ($r)
			return APRETASTE_INVITATION_REPEATED;
		
		$r = self::query("SELECT * FROM invitation where guest = '$from' and author = '$guest';");
		if ($r)
			return APRETASTE_INVITATION_UNNECESASARY;
		
		$r = self::query("SELECT * FROM announcement where author = '$guest' and (external_id is null or external_id = '');");
		if ($r)
			return APRETASTE_INVITATION_UNNECESASARY;
		
		$r = self::query("SELECT * FROM historial where author = '$guest' and (external_id is null or external_id = '');");
		if ($r)
			return APRETASTE_INVITATION_UNNECESASARY;
		
		$r = self::query("SELECT * from invitation where author = '$from' and guest = '$guest';");
		if (! $r)
			self::query("INSERT INTO invitation (author, guest, processed) VALUES ('$from','$guest', true);");
		
		$data = array(
				'command' => 'invite',
				'answer_type' => 'invite',
				"from" => $guest,
				"guest" => $guest,
				"author" => $from,
				"title" => "Bienvenido a Apretaste!com"
		);
		
		/*
		 * $data['images'] = self::getResImages(array( "buscar.png", "help.png" ));
		 */
		
		$config = array();
		
		foreach ( self::$robot->config_answer as $configx ) {
			$config = $configx;
			break;
		}
		
		$answerMail = new ApretasteAnswerEmail($config, $guest, self::$robot->smtp_servers, $data, true, true, false);
		
		return APRETASTE_INVITATION_SUCCESSFULL;
	}
	
	/**
	 * Return the images located in apretaste/common/images
	 *
	 * @return array
	 */
	static function getResImages($filter = array()){
		$images = array();
		$dir = scandir("../web/static");
		$fc = count($filter);
		
		foreach ( $filter as $f )
			$filter[$f] = $f;
		
		foreach ( $dir as $entry ) {
			if (strpos($entry, ".jpg") !== false || strpos($entry, ".png") !== false) {
				if (isset($filter[trim($entry)]) || $fc < 1) {
					$images[] = array(
							"type" => "image/" . (strpos($entry, ".png") !== false ? "png" : "jpg"),
							"content" => file_get_contents("../web/static/$entry"),
							"name" => $entry,
							"id" => str_replace(".png", "", str_replace(".jpg", "", $entry))
					);
				}
			}
		}
		return $images;
	}
	
	/**
	 * Extract email address from header FROM (without user name)
	 *
	 * @param string $email
	 * @return string
	 */
	static function extractEmailAddress($email){
		$p1 = strpos($email, '<');
		$p2 = strpos($email, '>');
		
		if ($p2 > $p1 && $p2 !== false && $p1 !== false)
			$email = substr($email, $p1 + 1, $p2 - $p1 - 1);
		
		return $email;
	}
	
	/**
	 * Save the message log
	 *
	 * @param array $message
	 * @param mixed $result
	 */
	static function message($message, $result){
		$command = 'unknown';
		if (isset($result['command']))
			$command = $result['command'];
		
		$author = $message['headers']->fromaddress;
		
		// Checking white list
		
		if (self::matchEmailPlus(self::extractEmailAddress($author), self::getEmailWhiteList())) {
			echo "[INFO] Message not saved because author $author is in the white list\n";
			return true;
		}
		
		// Save the message
		
		$to = $message['headers']->toaddress;
		if (isset($result['id']))
			$announcement = "'{$result['id']}'";
		else
			$announcement = "null";
		
		unset($message['headers']->Date);
		unset($message['headers']->Subject);
		unset($message['headers']->Subject);
		unset($message['textbody']);
		unset($message['htmlbody']);
		unset($message['images']);
		
		$extra_data = serialize($message);
		
		$id = strtoupper(uniqid());
		$extra_data = str_replace("'", "''", $extra_data);
		self::query("INSERT INTO message (id, command, author, addressee, announcement, extra_data, answer_type) VALUES
		 ('$id', '$command','$author','$to',$announcement,'$extra_data','{$result['answer_type']}');");
		
		return $id;
	}
	
	/**
	 * Comment
	 *
	 * @param string $from
	 * @param string $id
	 * @param string $body
	 * @return mixed
	 */
	static function comment($from, $id, $body){
		$body = str_replace("'", "''", $body);
		
		$r = self::getAnnouncement($id);
		
		if ($r) {
			self::query("INSERT INTO comment (author, body, announcement) VALUES ('$from','$body','$id');");
			return APRETASTE_COMMENT_SUCCESSFULL;
		}
		
		return APRETASTE_ANNOUNCEMENT_NOTFOUND;
	}
	
	/**
	 * Unsubscribe
	 *
	 * @param string $from
	 * @param string $sub
	 * @return mixed
	 */
	static function unsubscribe($from, $sub){
		$r = self::query("SELECT * FROM subscribe WHERE email = '$from' AND id = '$sub';");
		if (! $r)
			return APRETASTE_SUBSCRIBE_UNKNOWN;
		self::query("DELETE FROM subscribe WHERE email = '$from' AND id = '$sub';");
		return $r[0];
	}
	static function checkExternalAnnouncement($id, $source){
		$r = self::query("SELECT * FROM announcement WHERE external_id = '$id' AND external_source = '$source';");
		if ($r)
			return true;
		return false;
	}
	static function checkEncoding($string, $string_encoding){
		$fs = $string_encoding == 'UTF-8' ? 'UTF-32' : $string_encoding;
		$ts = $string_encoding == 'UTF-32' ? 'UTF-8' : $string_encoding;
		return $string === mb_convert_encoding(mb_convert_encoding($string, $fs, $ts), $ts, $fs);
	}
	static function utf8Encode($data, $encoding = 'utf-8'){
		if (! self::checkEncoding($data, "utf-8"))
			return utf8_encode($data);
		return $data;
	}
	static function utf8Decode($data){
		if (mb_check_encoding($data, "UTF-8")) {
			return utf8_decode($data);
		}
		return $data;
	}
	static function propFiles($path){
		$properties = new stdClass();
		if (file_exists($path)) {
			$f = null;
			$f = fopen($path, "r");
			while ( ! feof($f) ) {
				$s = trim(fgets($f));
				if ($s != "")
					if (substr($s, 0, 1) != "#") {
						$prop = substr($s, 0, strpos($s, "="));
						$prop = trim($prop);
						$value = trim(substr($s, strpos($s, "=") + 1));
						$p = strpos($prop, "[");
						$p2 = strpos($prop, "]");
						if ($p > 0 && $p < strlen($prop) + 2 && $p2 > $p) {
							$narr = substr($prop, 0, $p);
							$index = substr($prop, $p + 1, $p2 - $p - 1);
							eval('if (!isset($properties->' . $narr . ')) $properties->' . $narr . '= array();');
							if ($index != "")
								eval('$properties->' . $narr . '[\'' . trim($index) . '\'] = ' . $value . ';');
							else
								eval('$properties->' . $narr . '[] = ' . $value . ';');
						} else
							eval('$properties->' . $prop . '=' . $value . ';');
					}
			}
		}
		return $properties;
	}
	
	/**
	 * Return the email whitelist
	 *
	 * @return array
	 */
	static function getEmailWhiteList(){
		$r = self::query("SELECT * FROM email_whitelist;");
		$result = array();
		if ($r) {
			foreach ( $r as $row )
				$result[] = $row['email'];
		}
		return $result;
	}
	
	/**
	 * Return the email blacklist
	 *
	 * @return array
	 */
	static function getEmailBlackList(){
		$r = self::query("SELECT * FROM email_blacklist;");
		$result = array();
		if ($r) {
			foreach ( $r as $row )
				$result[] = $row['email'];
		}
		return $result;
	}
	
	/**
	 * Match email with pattern
	 *
	 * @param string $email
	 * @param string $pattern
	 * @return boolean
	 */
	static function matchEmail($email, $pattern){
		$email = strtolower($email);
		
		$pattern = strtolower($pattern);
		
		$pattern = str_replace("*", "", $pattern);
		
		$email = self::extractEmailAddress($email);
		
		if (strlen($email) < strlen($pattern))
			return false;
		
		if (substr($email, 0, strlen($pattern)) == $pattern)
			return true;
		
		if (substr($email, strlen($email) - strlen($pattern)) == $pattern)
			return true;
		
		if ($email == $pattern)
			return true;
		
		if (strpos($email, "<$pattern>") !== false)
			return true;
		
		return false;
	}
	
	/**
	 * Macth email with some patterns
	 *
	 * @param string $email
	 * @param array $pattern_list
	 * @return boolean
	 */
	static function matchEmailPlus($email, $pattern_list = array()){
		foreach ( $pattern_list as $pattern )
			if (self::matchEmail($email, $pattern))
				return true;
		return false;
	}
	static function delBlackList($email){
		self::query("DELETE FROM email_blacklist WHERE email = '$email';");
	}
	static function addBlackList($email){
		$email = str_replace("'", "", $email);
		$r = self::query("SELECT * FROM email_blacklist WHERE email = '$email';");
		if (! $r) {
			self::query("INSERT INTO email_blacklist VALUES ('$email');");
		}
	}
	static function delWhiteList($email){
		self::query("DELETE FROM email_whitelist WHERE email = '$email';");
	}
	static function addWhiteList($email){
		$email = str_replace("'", "", $email);
		$r = self::query("SELECT * FROM email_whitelist WHERE email = '$email';");
		if (! $r) {
			self::query("INSERT INTO email_whitelist VALUES ('$email');");
		}
	}
	
	/**
	 * Obtener la direccion IP del cliente
	 *
	 * @return string
	 */
	static function getClientIPAddress(){
		if (! isset($_SERVER))
			$_SERVER = $HTTP_SERVER_VARS;
		$ip = '127.0.0.1';
		if (isset($_SERVER['REMOTE_ADDR']))
			$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']))
			$ip = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
		return $ip;
	}
	
	/**
	 * Clean a string
	 *
	 * @param string $dato
	 * @param string $ch
	 * @return unknown
	 */
	static function depura($dato, $ch = ' abcdefghijklmnopqrstuvwxyz1234567890'){
		$dato = self::reparaTildes($dato);
		$dato = trim($dato);
		
		if ($dato == "")
			return $dato;
		$dato = str_split($dato);
		
		$result = '';
		
		foreach ( $dato as $c )
			if (strpos($ch, $c) !== false)
				$result .= $c;
			else
				$result .= ' ';
		
		while ( strpos($result, "  ") !== false )
			$result = str_replace("  ", " ", $result);
		return $result;
	}
	static function htmlToText($document){
		// $document should contain an HTML document.
		// This will remove HTML tags, javascript sections
		// and white space. It will also convert some
		// common HTML entities to their text equivalent.
		$search = array(
				'@<script[^>]*?>.*?</script>@si', // Strip out javascript
				'@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
				'@([\r\n])[\s]+@', // Strip out white space
				'@&(quot|#34);@i', // Replace HTML entities
				'@&(amp|#38);@i',
				'@&(lt|#60);@i',
				'@&(gt|#62);@i',
				'@&(nbsp|#160);@i',
				'@&(iexcl|#161);@i',
				'@&(cent|#162);@i',
				'@&(pound|#163);@i',
				'@&(copy|#169);@i',
				'@&#(\d+);@e'
		); // evaluate as php
		
		$replace = array(
				'',
				'',
				'\1',
				'"',
				'&',
				'<',
				'>',
				' ',
				chr(161),
				chr(162),
				chr(163),
				chr(169),
				'chr(\1)'
		);
		
		$text = preg_replace($search, $replace, $document);
		return $text;
	}
	static function replaceRecursive($from, $to, $s){
		if ($from == $to)
			return $s;
		$p = 0;
		do {
			$p = strpos($s, $from, $p);
			if ($p !== false)
				$s = str_replace($from, $to, $s);
		} while ( $p !== false );
		
		return $s;
	}
	static function cleanTextJunk($text, $ps = false, $align = "justify"){
		$text = self::cleanText($text);
		
		$alpha = "abcdefghijklmnopqrstuvwxyz1234567890., ";
		$save = array(
				'&aacute;',
				'&eacute;',
				'&iacute;',
				'&oacute;',
				'&uacute;',
				'&Aacute;',
				'&Eacute;',
				'&Iacute;',
				'&Oacute;',
				'&Uacute;',
				'&Ntilde;',
				'&ntilde;'
		);
		
		$restore = array();
		foreach ( $save as $sav ) {
			$kk = uniqid();
			$text = str_replace($sav, '{' . $kk . '}', $text);
			$restore[$kk] = $sav;
		}
		
		$abreviaturas = array(
				"c/" => "con",
				"c/u" => "cada uno",
				" ton " => " toneladas ",
				"ton " => " tonelada ",
				" tlf:" => ", tel&eacute;fono ",
				" telf:" => ", tel&eacute;fono ",
				" telef:" => ", tel&eacute;fono ",
				"*" => " * ",
				" kb" => "kb",
				" gb" => "gb"
		);
		
		foreach ( $abreviaturas as $abv => $repl )
			$text = str_ireplace($abv, $repl, $text);
		
		$text = mb_convert_encoding($text, 'UTF-8', 'ASCII,UTF-8,ISO-8859-1');
		
		if (substr($text, 0, 3) == pack("CCC", 0xEF, 0xBB, 0xBF))
			$text = substr($text, 3);
		
		$text = htmlspecialchars_decode($text);
		
		$text = str_replace("\n\r", "\n", $text);
		$text = str_replace("\r", "\n", $text);
		$text = str_replace("\n\n", "\n", $text);
		$text = str_replace("\n\n", "\n", $text);
		$text = str_replace("\n\n", "\n", $text);
		$text = str_replace("\n\n", "\n", $text);
		$text = str_replace("=\n", " ", $text);
		$text = str_replace("= \n", " ", $text);
		$text = str_replace("  ", " ", $text);
		$text = str_replace(",,", ", ", $text);
		$text = self::replaceRecursive("  ", " ", $text);
		$text = str_replace(" ,", ",", $text);
		$text = str_replace(" ;", ";", $text);
		$text = str_replace(" :", ":", $text);
		$text = str_replace(" .", ".", $text);
		$text = str_replace(",", ", ", $text);
		$text = self::replaceRecursive("....", "", $text);
		$text = self::replaceRecursive("ss", "s", $text);
		$text = self::replaceRecursive("ooo", "o", $text);
		$text = self::replaceRecursive("nn", "n", $text);
		$text = self::replaceRecursive("aa", "a", $text);
		$text = self::replaceRecursive("!!", "!", $text);
		$text = str_replace("!", "! ", $text);
		$text = str_replace("\n", "\n\n", $text);
		$text = self::replaceRecursive("!!", "!", $text);
		$text = self::replaceRecursive("* *", "", $text);
		$text = self::replaceRecursive("\\", "", $text);
		$text = self::replaceRecursive("***", "", $text);
		$text = self::replaceRecursive("**", "*", $text);
		$text = self::replaceRecursive("  ", " ", $text);
		$text = self::replaceRecursive(" !", "!", $text);
		$text = self::replaceRecursive("+++", "++", $text);
		if (strlen($text) > 100)
			$text = str_replace("----------", "\n", $text);
		$text = self::replaceRecursive("---", "", $text);
		$text = self::replaceRecursive("--", "", $text);
		$text = self::replaceRecursive("(*&*)", "", $text);
		$text = self::replaceRecursive("(*&amp;*)", "", $text);
		$text = self::replaceRecursive("___", "_", $text);
		$text = self::replaceRecursive("\n\n\n", "\n\n", $text);
		$text = self::replaceRecursive("==", "  ", $text);
		$text = self::replaceRecursive("::", " ", $text);
		$text = self::replaceRecursive(". . ", "..", $text);
		$text = self::replaceRecursive(")))", "))", $text);
		$text = self::replaceRecursive("(((", "((", $text);
		$text = str_replace("((", "", $text);
		$text = str_replace("))", "", $text);
		$text = str_replace("(", " (", $text);
		$text = str_replace(")", ") ", $text);
		$text = str_replace(" ,", ",", $text);
		$text = str_replace(" ;", ";", $text);
		$text = str_replace(" :", ":", $text);
		$text = str_replace(" .", ".", $text);
		$text = str_replace(",", ", ", $text);
		$text = self::replaceRecursive("  ", " ", $text);
		$text = self::replaceRecursive(", ,", ", ", $text);
		
		$words = explode(" ", $text);
		
		$text = "";
		
		foreach ( $words as $word ) {
			
			while ( strlen($word) > APRETASTE_MAX_WORD_LENGTH ) {
				$word = substr($word, 0, APRETASTE_MAX_WORD_LENGTH);
				$text .= $word . " ";
			}
			
			if (($word == strtoupper($word) && (strlen($word) > 3 || strlen($word) < 2)) || array_search($word, array(
					"EN",
					"DE",
					"LA",
					"EL",
					"TU",
					"YO",
					"MI",
					"DEL",
					"SE",
					"SI",
					"NO"
			)) !== false)
				$word = strtolower($word);
			
			$text .= $word . " ";
		}
		
		$text = str_replace(";-)", "", $text);
		
		while ( stripos($alpha, $text[0]) === false && trim($text) != "" ) {
			$text = substr($text, 1);
		}
		
		// ... primera letra de la oracion en mayuscula
		$p = 0;
		$l = strlen($text);
		do {
			if ($p + 1 > $l)
				break;
			$p = strpos($text, ". ", $p + 1);
			if ($p !== false && $p < strlen($text) - 3) {
				if ($text[$p + 2] >= 'a' && $text[$p + 2] <= 'z')
					$text = substr($text, 0, $p) . ". " . strtoupper($text[$p + 2]) . substr($text, $p + 3);
			}
		} while ( $p !== false );
		
		$text = ucfirst(trim($text));
		
		foreach ( $restore as $kk => $restor ) {
			$text = str_replace('{' . $kk . '}', $restor, $text);
		}
		
		return $text;
	}
	
	/**
	 * Clean a text
	 *
	 * @param string $text
	 * @return string
	 */
	static function cleanText($text, $ps = false, $align = "justify"){
		$text = "$text";
		if (! self::isUTF8($text))
			$text = utf8_encode($text);
		
		$text = quoted_printable_decode($text);
		$text = strip_tags($text);
		$text = html_entity_decode($text, ENT_COMPAT, 'UTF-8');
		$text = htmlentities($text, ENT_COMPAT, 'UTF-8');
		
		return $text;
	}
	
	/**
	 * User linker
	 *
	 * @param string $id
	 */
	static function linker($id, $author){
		$a = self::getAnnouncement($id);
		$query = null;
		
		$kws = array(
				array(
						"vendo",
						"vende",
						"venta",
						"vendemos",
						"ofrezco",
						"ofrece",
						"ofrecemos",
						"oferta",
						"doy",
						"se da",
						"damos",
						"cambio"
				),
				array(
						"compro",
						"compra",
						"compra",
						"compramos",
						"necesito",
						"necesita",
						"necesitamos",
						"necesidad",
						"busco",
						"se busca",
						"buscamos",
						"cambio"
				)
		);
		
		// Building the query from the title
		$q = self::depura(html_entity_decode(strtolower($a['title']), ENT_COMPAT | ENT_HTML401, 'ISO-8859-1'));
		
		// Detecting ad type...
		$ksv = array();
		$ksvx = array();
		$ksc = array();
		$kscx = array();
		
		$oferta = "oferta";
		
		foreach ( $kws[0] as $k => $item )
			if (strpos($q, $item) !== false) {
				$ksv[] = $item;
				$ksvx[] = $kws[1][$k];
			}
		
		foreach ( $kws[1] as $k => $item )
			if (strpos($q, $item) !== false) {
				$ksc[] = $item;
				$kscx[] = $kws[0][$k];
			}
		
		$default_oferta = false;
		if (count($ksv) > 0) {
			$query = str_replace($ksv, "", $q);
			$query .= " compro " . implode(" ", $ksvx);
		} elseif (count($ksc) > 0) {
			$query = str_replace($ksc, "", $q);
			$query .= " vendo " . implode(" ", $kscx);
			$oferta = "necesidad";
		} else {
			$query = $q;
			$default_oferta = true;
		}
		
		if (! is_null($query)) {
			$query = trim($query);
			$words = explode(" ", $query);
			
			$nwords = array();
			foreach ( $words as $i => $word ) {
				
				if (strlen($word) < 2)
					continue;
				
				if (isset($nwords[$word]))
					continue;
				
				if (is_numeric($word))
					continue;
				
				$nwords[$word] = $word;
				if ($i > 5)
					break;
			}
			
			if ($default_oferta)
				$nwords['compro'] = 'compro';
			
			$query = implode(" ", $nwords);
			
			$r = self::search($query, 10, 0, false);
			$results = array();
			
			if (is_array($r['results']))
				foreach ( $r['results'] as $k => $rr ) {
					if ($rr['id'] != $id && $rr['author'] != $a['author']) {
						if (trim($rr['image']) != '')
							$rr['image'] = true;
						else
							$rr['image'] = false;
						$results[] = $rr;
					}
				}
			
			if (count($results) > 0) {
				$nresults = array();
				foreach ( $results as $result ) {
					
					if ($result['rank_title'] * 1 > 0) {
						$e = self::query("SELECT announcement as id from linker WHERE announcement = '{$result['id']}' AND email='$author'");
						
						if (isset($e[0]))
							if (isset($e[0]['id']))
								if ($e[0]['id'] == $result['id'])
									continue;
						
						self::query("INSERT INTO linker (announcement, email) VALUES ('{$result['id']}','$author');");
						$nresults[] = $result;
					}
				}
				if (count($nresults) > 0)
					return array(
							"results" => $nresults,
							"oferta" => $oferta
					);
			}
		}
		
		return false;
	}
	
	/**
	 * Return a random tip
	 *
	 * @return array
	 */
	static function randomTip(){
		$r = self::query("SELECT count(*) as cant FROM tip;");
		$cant = $r[0]['cant'];
		if ($cant > 0) {
			$idx = mt_rand(0, $cant - 1);
			
			$tip = self::query("SELECT * from tip offset $idx limit 1");
			return str_replace('\"', '"', $tip[0]);
		}
		return false;
	}
	static function exclusion($from){
		self::incorporate($from);
		Apretaste::query("INSERT INTO exclusion (email) VALUES ('$from');");
		return true;
	}
	static function incorporate($from){
		Apretaste::query("DELETE FROM exclusion WHERE email='$from';");
	}
	static function isExcluded($from){
		$r = self::query("SELECT * FROM exclusion WHERE email='$from';");
		if ($r)
			if (isset($r[0]))
				if (isset($r[0]['email']))
					if ($r[0]['email'] == $from)
						return true;
		return false;
	}
	
	/**
	 * Save answer log
	 *
	 * @param array $headers
	 * @param string $type
	 */
	static function saveAnswer($headers, $type, $msg_id = null){
		$subject = '';
		$from = '';
		$to = '';
		
		foreach ( $headers as $h => $v ) {
			if (strtolower($h) == 'from')
				$from = $v;
			if (strtolower($h) == 'subject')
				$subject = $v;
			if (strtolower($h) == 'to')
				$to = $v;
		}
		
		if (self::matchEmailPlus(self::extractEmailAddress($to), self::getEmailWhiteList())) {
			echo "[INFO] Answer not saved because author $to is in the white list\n";
			return true;
		}
		
		if ($from != '' && $to != '') {
			$subject = str_replace("'", "''", $subject);
			$sql = "INSERT INTO answer (sender, receiver, subject, type, message) VALUES ('$from','$to','$subject','$type', '$msg_id');";
			self::query($sql);
		}
	}
	
	/**
	 * Save author information
	 *
	 * @param string $email
	 * @param array $data
	 */
	static function saveAuthor($email, $data){
		$email = strtolower($email);
		$email = trim($email);
		
		if (self::checkAddress($email)) {
			
			self::connect();
			
			$r = self::query("SELECT count(*) as total FROM authors WHERE email = '$email';");
			
			if ($r[0]['total'] * 1 < 1) {
				self::query("INSERT INTO authors (email) VALUES ('$email');");
			}
			
			foreach ( $data as $key => $value ) {
				$where = ' TRUE ';
				if ($key == 'phones')
					$where .= " AND (phones is null)";
				
				if (($key == 'historical_ads' || $key == 'historical_msgs' || $key == 'historical_searchs') and trim($value) !== '') {
					$sql = "UPDATE authors SET $key = $value WHERE email = '$email' AND ($where);";
				} else {
					$sql = "UPDATE authors SET $key = '$value' WHERE email = '$email' AND ($where);";
				}
				self::query($sql);
			}
			
			// Save mailing list
			
			/*
			 * @self::sendPost("http://hosted.comm100.com/Newsletter/FormSubscribe.aspx?siteId=145342&version=2&IfVerified=False&languageId=1", array( "singlemailinglistid" => 681, "hiddenButtonText" => "Subscribe", "hiddenEmail" => "Email", "Email" => $email ));
			 */
		}
	}
	static function getAuthor($email){
		$r = self::query("SELECT * FROM author WHERE author = '$email';");
		
		if (! isset($r[0]))
			return array(
					"email" => $email,
					"linker" => false,
					"verified" => false,
					"public" => false,
					"historical_ads" => 0,
					"historical_searchs" => 0,
					"historical_msgs" => 0
			);
		
		return $r[0];
	}
	static function generateRecommendedPhrases($phrase, $limit = 20){
		$original = $phrase;
		$phrase = addslashes($phrase);
		$r = self::query("SELECT nano_titulo('$phrase') as x;");
		$phrase = $r[0]['x'];
		
		$sql = "
            select
            *
            from (
                select
                subq.nanotitle,
                subq.percent
                from (
                        select  w1 || ' ' || w2 || ' ' || w3 || ' ' || w4 as nanotitle,
                                similar_text_percent('$phrase', w1 || ' ' || w2 || ' ' || w3 || ' ' || w4) as percent
                        from nanotitles
                        where 
                        w1 || ' ' || w2 || ' ' || w3 || ' ' || w4 <> '$phrase'
                        AND
                        w1 || ' ' || w2 || ' ' || w3 || ' ' || w4 ~* '$phrase'
                     ) as subq
                where subq.percent >= 0.4
                order by subq.percent desc
                limit $limit
                ) as subq2
            order by nanotitle;";
		
		$r = self::query($sql);
		
		$result = array();
		
		if (is_array($r))
			foreach ( $r as $f ) {
				if (trim(strtolower($f['nanotitle'])) != trim(strtolower($original)))
					$result[] = $f['nanotitle'];
			}
		return $result;
	}
	static function query_queue($query){
		$query = str_replace("'", "''", $query);
		self::query("INSERT INTO query_queue (query) VALUES ('$query');");
	}
	static function getBlackWords(){
		$rr = Apretaste::query("select word from word where black = true;");
		$r = array();
		if (is_array($rr))
			foreach ( $rr as $row )
				$r[] = $row["word"];
		return $r;
	}
	static function mimeDecode($text){
		$text = trim($text);
		$nt = "";
		$arr = explode(" ", $text);
		foreach ( $arr as $item )
			$nt .= iconv_mime_decode($item, ICONV_MIME_DECODE_CONTINUE_ON_ERROR) . " ";
		return trim($nt);
	}
	static function sendPost($url, $fields){
		foreach ( $fields as $key => $value ) {
			$fields[$key] = urlencode($key);
		}
		$fields_string = '';
		foreach ( $fields as $key => $value ) {
			$fields_string .= $key . '=' . $value . '&';
		}
		
		rtrim($fields_string, '&');
		
		// open connection
		$ch = @curl_init();
		
		// set the url, number of POST vars, POST data
		@curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_POST, count($fields));
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		
		// execute post
		$result = @curl_exec($ch);
		
		// close connection
		@curl_close($ch);
	}
	
	/**
	 * Nurture address list from several sources
	 */
	static function nourishAddressList(){
		self::connect();
		
		// From messages
		
		$sql = "insert into address_list (email, source)
		select * from (
			select lower(extract_email(author)) as email, 'apretaste.public.messages' as source
			from message
			group by email,source
			) as subq
		where not exists(select * from address_list where address_list.email = lower(subq.email));";
		
		self::query($sql);
		
		// From internal ads
		$sql = "insert into address_list (email, source)
		select * from (
			select lower(extract_email(author)) as email, 'apretaste.public.announcement' as source 
			from announcement 
			where external_id is null 
			group by email,source
		) as subq
		where not exists(select * from address_list where address_list.email = lower(subq.email));";
		
		self::query($sql);
		
		// From external ads
		
		$sql = "insert into address_list (email, source)	
		select email::text, source::text from (
			select lower(extract_email(author)) as email, 'apretaste.public.external_ads'::text as source
			from announcement
			where not external_id is null and not author ~* 'in.revolico.net'
		) as subq
		WHERE
		not exists(select * from address_list where address_list.email::text = lower(email::text))
		group by email,source";
		
		self::query($sql);
		
		// From invitations
		// authors
		$sql = "insert into address_list (email, source)
		select * from (
			select lower(extract_email(author)) as email, 'apretaste.public.invitation' as source 
			from invitation 
			group by email,source
			) as subq
		where not exists(select * from address_list where address_list.email = lower(subq.email));";
		
		self::query($sql);
		
		// guests
		$sql = "insert into address_list (email, source)
		select * from (
			select lower(extract_email(guest)) as email, 'apretaste.public.guests' as source
			from invitation
			group by email,source
			) as subq
		where not exists(select * from address_list where address_list.email = lower(subq.email));";
		
		self::query($sql);
		
		// From authors
		
		$sql = "insert into address_list (email, source)
		select * from (
			select lower(extract_email(email)) as email, 'apretaste.public.authors' as source
			from authors
			group by email,source
			) as subq
		where not exists(select * from address_list where address_list.email = lower(subq.email));";
		
		self::query($sql);
		
		// Cleanning
		self::query("delete from address_list where email ~* 'in.revolico.net'");
	}
	static function isCli(){
		return div::isCli();
	}
	static function isUTF8($string){
		if (function_exists("mb_check_encoding") && is_callable("mb_check_encoding")) {
			return mb_check_encoding($string, 'UTF8');
		}
		
		return preg_match('%^(?:
          [\x09\x0A\x0D\x20-\x7E]            # ASCII
        | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
        |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
        |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
        |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    	)*$%xs', $string);
	}
	/**
	 * Search in google
	 *
	 * @param string $query
	 */
	static function google($query){
		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=" . urlencode($query);
		
		$body = file_get_contents($url);
		$results = json_decode($body);
		return $results->responseData->results;
	}
	static function getUserStats($email){
		$stats = array();
		
		$email = strtolower($email);
		$email = self::extractEmailAddress($email);
		
		// Total messages
		$r = self::query("SELECT count(*) as total from message where lower(extract_email(author))='$email' or author = '$email' or extract_email(author) = '$email';");
		$stats['messages'] = $r[0]['total'] * 1;
		
		// Total messages by command
		$r = self::query("SELECT command, count(*) as total from message where lower(extract_email(author))='$email' group by command order by total desc;");
		$stats['messages_by_command'] = $r;
		
		// Total answers
		$r = self::query("SELECT count(*) as total from answer where lower(extract_email(receiver))='$email';");
		$stats['answers'] = $r[0]['total'];
		
		// Total answers by type
		$r = self::query("SELECT type, count(*) as total from answer where lower(extract_email(receiver))='$email' group by type order by total desc;");
		$stats['answers_by_type'] = $r;
		
		return $stats;
	}
	
	/**
	 * Send email
	 *
	 * @param string $to
	 * @param array $data
	 */
	static function sendEmail($to, $data){
		$robot = new ApretasteEmailRobot($autostart = false, $verbose = false);
		
		Apretaste::$robot = &$robot;
		
		$config = array();
		
		foreach ( self::$robot->config_answer as $configx ) {
			$config = $configx;
			break;
		}
		
		$answerMail = new ApretasteAnswerEmail($config, $to, self::$robot->smtp_servers, $data, true, true, false);
	}
}