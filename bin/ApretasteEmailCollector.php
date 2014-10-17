<?php
include "../lib/PEAR/mimeDecode.php";
class ApretasteEmailCollector {
	function __construct($servers, $verbose = false, $debug = false){
		$this->servers = $servers;
		$this->verbose = $verbose;
		$this->debug = $debug;
		$this->emails = array();
		$addresses = array_keys($this->servers);
		foreach ( $addresses as $address ) {
			$email = explode('@', $address);
			$this->emails[] = array(
					'mailbox' => $email[0],
					'host' => $email[1]
			);
		}
	}
	function get($callback){
		foreach ( $this->servers as $address => $server ) {
			echo $this->verbose ? "[INFO] Reading inbox from $address (" . $server['mailbox'] . ")\n" : "";
			$this->_getInbox($server, $callback, $address);
		}
	}
	
	/**
	 * Mime decode
	 *
	 * @param string $text
	 * @return string
	 */
	function mimeDecode($text){
		$id = uniqid();
		$text = str_replace("\n", $id, $text);
		$text = trim($text);
		
		$nt = "";
		$arr = explode(" ", $text);
		foreach ( $arr as $item )
			$nt .= iconv_mime_decode($item, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8') . " ";
		
		$nt = str_replace($id, "\n", $nt);
		return trim($nt);
	}
	
	/**
	 *
	 * @param unknown $server
	 * @param unknown $callback
	 * @param unknown $address
	 * @return boolean
	 */
	function _getInbox($server, $callback, $address){
		$try = 0;
		$maxtry = 3;
		
		do {
			$try ++;
			echo "[INFO] " . date("Y-m-d h:i:s") . " Trying to connect to inbox -  try = $try\n";
			$this->imap = imap_open($mailbox = $server['mailbox'], $username = $server['username'], $password = $server['password']);
		} while ( $this->imap === false && $try < $maxtry );
		
		if ($this->imap === false) {
			
			unset($this->imap);
			
			echo "[ERROR] Error al conectar al servidor IMAP {$server['mailbox']}\n";
			
			$message = '';
			
			ob_start();
			echo "<h1>Errores al conectar al servidor IMAP {$server['mailbox']} despu&eacute;s de $try intentos</h1>\n";
			$errors = imap_errors();
			foreach ( $errors as $k => $error )
				echo ($k + 1) . " - $error<br/>\n";
			$message = ob_get_contents();
			ob_end_clean();
			
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: soporte@apretaste.com \r\n";
			$headers .= "Reply-To: soporte@apretaste.com \r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			
			$this->log("Notificando al soporte tecnico");
			
			mail('soporte@apretaste.com', "Errores al conectar al servidor IMAP {$server['mailbox']}", $message, $headers);
			
			return false;
		}
		
		$this->log("Expunge IMAP connection");
		imap_expunge($this->imap);
		
		imap_sort($this->imap, SORTARRIVAL, 1);
		
		$status = imap_status($this->imap, $server['mailbox'], $options = SA_MESSAGES);
		
		$max_time = Apretaste::getConfiguration("cron_max_time", 120);
		
		$t1 = microtime(true);
		
		$this->log($status->messages . " messages to process");
		
		if ($status->messages > 0)
			for($message_number_iterator = 1; $message_number_iterator <= $status->messages; $message_number_iterator ++) {
				
				$t2 = microtime(true);
				
				if ($t2 - $t1 > $max_time) {
					$this->log("[INFO] Stoping the collector by time limit: max_time = $max_time and timmer = " . $t2 - $t1);
					$this->log("[INFO] --> $message_number_iterator of {$status->messages} messages was processed");
					break;
				}
				
				$headers = imap_headerinfo($this->imap, $message_number_iterator);
				
				// var_dump($headers);
				
				if (isset($headers->Deleted))
					if ($headers->Deleted == 'D') {
						$this->log("Ignore message #$message_number_iterator marked for deletion: {$headers->subject}");
						continue;
					}
				
				if (! isset($headers->subject))
					$headers->subject = '';
				
				$headers->subject = $this->mimeDecode($headers->subject);
				
				// var_dump($headers);
				
				/*
				 * if (isset($headers->reply_toaddress)) $from = $headers->reply_toaddress; else
				 */
				
				$from = $headers->from[0]->mailbox . "@";
				if (isset($headers->from[0]->host))
					$from .= $headers->from[0]->host;
				
				$t = trim($headers->subject);
				$t = str_ireplace("fwd:", "", $t);
				$t = str_ireplace("re:", "", $t);
				$t = str_ireplace("rv:", "", $t);
				
				$headers->subject = trim($t);
				
				if (isset($headers->message_id)) {
					echo "[INFO} Message-ID: " . $headers->message_id . "\n";
					
					if (strpos($headers->message_id, '@') !== false) {
						
						if (isset($headers->from[0]->host)) {
							$host = $headers->from[0]->host;
							
							$msgid = Apretaste::extractEmailAddress($headers->message_id);
							$msgid = substr($msgid, strpos($msgid, '@') + 1);
							
							if ($host != $msgid) {
								echo "[INFO] host $host are not equal to $msgid message ID, mmmm...\n";
								if (strpos($host, $msgid) === false && strpos($msgid, $host) === false) {
									echo "[INFO] host is not inside msgid, and msgid is not inside host, mmmm...\n";
									
									$other = Apretaste::query("SELECT extra_data FROM message WHERE author ~* '@$host' AND extract_email(author) <> extract_email('$from') limit 1;");
									if (isset($other[0])) {
										$other = @unserialize($other[0]['extra_data']);
										if (isset($other['headers']->message_id)) {
											$msgid2 = $other['headers']->message_id;
											$msgid2 = str_replace(">", "", substr($msgid2, strpos($msgid2, '@') + 1));
											echo "[INFO] Checking $msgid = $msgid2 as the ID user by other similar users \n";
											if ($msgid != $msgid2) {
												$other = Apretaste::query("SELECT extra_data FROM message WHERE extract_email(author) = extract_email('$from') order by moment limit 1;");
												if (isset($other[0])) {
													$other = @unserialize($other[0]['extra_data']);
													if (isset($other['headers']->message_id)) {
														$msgid2 = $other['headers']->message_id;
														$msgid2 = str_replace(">", "", substr($msgid2, strpos($msgid2, '@') + 1));
														echo "[INFO] Checking $msgid = $msgid2 as the first ID used\n";
														if ($msgid != $msgid2) {
															echo "[WARN] _______________________ Suspicious message !!!\n";
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				
				$body_structure = imap_fetchstructure($this->imap, $message_number_iterator);
				
				$textBody = false;
				$htmlBody = false;
				$images = array();
				$otherstuff = array();
				$ugly_mail = true;
				
				if ($body_structure->type == 0 && $body_structure->ifsubtype) // Text message and specified
					if (mb_strtolower($body_structure->subtype) == 'plain') { // Plain text message
						$textBody = imap_body($this->imap, $message_number_iterator); // The whole text is the message
						
						echo $this->verbose ? "message $message_number_iterator is plain\n" : "";
						$ugly_mail = false;
					}
				
				if ($body_structure->type == 1 && $body_structure->ifsubtype) {
					$decoder = new Mail_mimeDecode(imap_fetchheader($this->imap, $message_number_iterator) . "\n\n" . imap_body($this->imap, $message_number_iterator));
					$structured = $decoder->decode($param = array(
							'include_bodies' => true
					));
					$result = $this->_findTheParts($structured, $textBody, $htmlBody, $images, $otherstuff);
					echo $this->verbose ? "message $message_number_iterator is MIME\n" : "";
					$ugly_mail = false;
				}
				
				if ($ugly_mail) {
					$otherstuff[] = imap_body($this->imap, $message_number_iterator);
					echo $this->verbose ? "message $message_number_iterator is ugly\n" : "";
				}
				
				if ($this->_badFrom($headers = $headers) || $this->_postMaster($headers = $headers, $textBody = $textBody, $htmlBody = $htmlBody, $images = $images, $otherstuff = $otherstuff)) {
					echo $this->verbose ? "message $message_number_iterator not valid\n" : "";
					imap_delete($this->imap, $message_number_iterator);
					Apretaste::saveUglyEmail($from, $headers->subject, $headers, $htmlBody == '' ? $textBody : $htmlBody, 'ugly');
					continue;
				}
				
				/*
				 * if (! Apretaste::isUTF8($textBody)) { echo "textBody = $textBody = ".htmlentities($textBody)."\n"; echo $this->verbose ? "textBody is not utf8, converting now \n" : ""; $textBody = iconv('ISO-8859-1', 'UTF-8', $textBody); //$textBody = ApretasteEncoding::toUTF8($textBody); echo "textBody = $textBody = ".htmlentities($textBody, ENT_QUOTES | ENT_IGNORE, "UTF-8")."\n"; } if (! Apretaste::isUTF8($htmlBody)){ echo $this->verbose ? "htmlBody is not utf8 \n" : ""; $textBody = ApretasteEncoding::toUTF8($htmlBody); }
				 */
				echo $this->verbose ? "[INFO] mime decoding... \n" : "";
				
				// echo "textBody = $textBody\n";
				
				if (trim($textBody) == '' && trim($htmlBody) == '') {
					if (isset($otherstuff[0])) {
						$textBody = strip_tags($otherstuff[0]);
						$htmlBody = $textBody;
					}
				}
				
				$textBody = $this->mimeDecode($textBody);
				$htmlBody = $this->mimeDecode($htmlBody);
				
				$this->log("Mark for deletion the message $message_number_iterator");
				imap_delete($this->imap, $message_number_iterator);
				
				// Check invitation rebate
				echo $this->verbose ? "[INFO] Check invitation rebate ... \n" : "";
				$rebate = Apretaste::checkInvitationRebate($from, $headers->subject, $htmlBody == '' ? $textBody : $htmlBody);
				
				if ($rebate !== false) {
					echo $this->verbose ? "[INFO] INVITATION FAIL: Send email invitation_fail to the author... \n" : "";
					$rebate['answer_type'] = 'invitation_fail';
					Apretaste::sendEmail($rebate['author'], $rebate);
					Apretaste::saveUglyEmail($from, $headers->subject, $headers, $htmlBody == '' ? $textBody : $htmlBody, 'invitation_fail');
					continue;
				}
				
				// Prevent Mail Delivery System
				echo $this->verbose ? "[INFO] Prevent Mail Delivery System ... \n" : "";
				if (stripos($headers->subject, 'delivery') !== false || strpos($headers->subject, 'Undeliverable') !== false || stripos($from, 'MAILER-DAEMON') !== false || stripos($headers->subject, 'Rejected:') === 0) {
					echo $this->verbose ? "[INFO] ignore Mail Delivery System from {$from}\n" : "";
					Apretaste::saveUglyEmail($from, $headers->subject, $headers, $htmlBody == '' ? $textBody : $htmlBody);
					continue;
				}
				
				// Checking black and white list
				echo $this->verbose ? "[INFO] Checking black and white list ... \n" : "";
				$blacklist = Apretaste::getEmailBlackList();
				$whitelist = Apretaste::getEmailWhiteList();
				
				if ((Apretaste::matchEmailPlus($from, $blacklist) == true && Apretaste::matchEmailPlus($from, $whitelist) == false)) {
					imap_delete($this->imap, $message_number_iterator);
					$this->log("Ignore email address {$from}");
					Apretaste::saveUglyEmail($from, $headers->subject, $headers, $htmlBody == '' ? $textBody : $htmlBody, 'black_list');
					continue;
				}
				
				if ($headers->subject == '')
					$headers->subject = 'AYUDA';
				
				$textBody = str_replace("\r\n", "\n", $textBody);
				$htmlBody = str_replace("\r\n", "\n", $htmlBody);
				
				$textBody = str_replace("\n\r", "\n", $textBody);
				$htmlBody = str_replace("\n\r", "\n", $htmlBody);
				
				if (strpos($textBody, "--\n") !== false) {
					$textBody = substr($textBody, 0, strpos($textBody, "--\n"));
				}
				
				if (strpos($htmlBody, "--\n") !== false) {
					$htmlBody = substr($htmlBody, 0, strpos($htmlBody, "--\n"));
				}
				
				// Important fix for mobile devices (like as Samsung)
				$this->log("Detecting base64 encoded body");
				
				/*
				 * if (ApretasteEncoding::is_base64_encoded($textBody)) $textBody = base64_decode($textBody); if (ApretasteEncoding::is_base64_encoded($htmlBody)) $htmlBody = base64_decode($htmlBody);
				 */
				
				// Call to callback
				$this->log("Callback the message $message_number_iterator");
				
				if (strpos($from, '@nauta.cu')) {
					$textBody = ApretasteEncoding::base64Decode($textBody);
					$htmlBody = ApretasteEncoding::base64Decode($htmlBody);
				}
				
				$cutbody = array(
						"--\n",
						"-- \n",
						"=0A--=0A",
						"__________ ",
						": : CUBAMOTRICIDAD",
						"-----Mensaje original-----",
						"50 Aniversario de la Cujae",
						"Nunca digas nunca di mejor: gracias permiso",
						"---------- Mensaje reenviado ----------"
				);
				
				foreach ( $cutbody as $cut ) {
					$p = strpos($textBody, $cut);
					
					if ($p !== false)
						$textBody = substr($textBody, 0, $p);
					
					$p = strpos($htmlBody, $cut);
					
					if ($p !== false)
						$htmlBody = substr($htmlBody, 0, $p);
				}
				
				Apretaste::addToAddressList($textBody . ' ' . $htmlBody, 'apretaste.bodies');
				
				$callback($headers, $textBody, $htmlBody, $images, $otherstuff, $address);
			}
		
		$this->log("Expunge IMAP connection");
		imap_expunge($this->imap);
		$this->log("Close IMAP connection");
		imap_close($this->imap);
		
		unset($this->imap);
	}
	
	/**
	 * Echo message
	 * @param unknown $text
	 */
	function log($text){
		echo $this->verbose ? "[INFO] " . date("Y-m-d h:i:s") . " - " . $text . "\n" : "";
	}
	function _badFrom($headers){
		if (is_array($headers))
			foreach ( $headers->from as $from )
				foreach ( $this->emails as $email )
					if ($from->mailbox == $email['mailbox'] && $from->host == $email['host'])
						return true;
					else
						return true;
		return false;
	}
	function _postMaster($headers, $textBody, $htmlBody, $images, $otherstuff){
		return false;
	}
	function _findTheParts($part, &$textBody, &$htmlBody, &$images, &$otherstuff){
		$classified = false;
		if (isset($part->body)) {
			if (mb_strtolower($part->ctype_primary) == 'text' && mb_strtolower($part->ctype_secondary) == 'plain') {
				$textBody = $part->body;
				$classified = true;
			}
			
			if (mb_strtolower($part->ctype_primary) == 'text' && mb_strtolower($part->ctype_secondary) == 'html') {
				$htmlBody = $part->body;
				$classified = true;
			}
			if (mb_strtolower($part->ctype_primary) == 'image') {
				$images[] = array(
						"content" => $part->body,
						"type" => $part->ctype_secondary,
						"name" => $part->ctype_parameters['name']
				);
				$classified = true;
			}
			if (! $classified)
				$otherstuff[] = $part->body;
		}
		if (isset($part->parts))
			foreach ( $part->parts as $part )
				$this->_findTheParts($part, $textBody, $htmlBody, $images, $otherstuff);
	}
}
