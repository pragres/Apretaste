<?php

/**
 * Horde robot
 *
 * @author rafa
 * @version 1.0
 */
class ApretasteHordeRobot {
	static $robot = null;
	static function buildRobot(){
		if (is_null(self::$robot)) {
			$robot = new ApretasteEmailRobot(false, true, true);
			self::$robot = $robot;
		}
	}
	static function Run($account = "nauta"){
		$client = new ApretasteHordeClient($account);
		$inbox = $client->getInbox(10, false);
		
		Apretaste::connect();
		self::buildRobot();
		
		$robot = self::$robot;
		
		if ($inbox === false) {
			$robot->log('Connection to horde fail. Abort operations!');
			return false;
		}
		
		if (is_array($inbox))
			foreach ( $inbox as $message_number_iterator => $mail ) {
				
				$t = trim($mail->subject);
				$t = str_ireplace("fwd:", "", $t);
				$t = str_ireplace("re:", "", $t);
				$t = str_ireplace("rv:", "", $t);
				
				$mail->subject = trim($t);
				
				// Check invitation rebate
				$robot->log("Check invitation rebate ...");
				$rebate = Apretaste::checkInvitationRebate($mail->from, $mail->subject, $mail->body);
				
				if ($rebate !== false) {
					$robot->log("INVITATION FAIL: Send email invitation_fail to the author... ");
					$rebate['answer_type'] = 'invitation_fail';
					Apretaste::sendEmail($rebate['author'], $rebate);
					Apretaste::saveUglyEmail($mail->from, $mail->subject, $mail, $mail->body, 'invitation_fail');
					continue;
				}
				
				// Prevent Mail Delivery System
				$robot->log("Prevent Mail Delivery System ...");
				if (stripos($mail->subject, 'delivery') !== false || strpos($mail->subject, 'Undeliverable') !== false || stripos($mail->from, 'MAILER-DAEMON') !== false || stripos($mail->subject, 'Rejected:') === 0) {
					$robot->log("ignore Mail Delivery System from {$mail->from}");
					Apretaste::saveUglyEmail($mail->from, $mail->subject, $mail, $mail->body);
					continue;
				}
				
				$from = $mail->from;
				
				// Checking black and white list
				$robot->log("Checking black and white list ...");
				
				$blacklist = Apretaste::getEmailBlackList();
				$whitelist = Apretaste::getEmailWhiteList();
				
				if ((Apretaste::matchEmailPlus($from, $blacklist) == true && Apretaste::matchEmailPlus($from, $whitelist) == false)) {
					imap_delete($this->imap, $message_number_iterator);
					$robot->log("Ignore email address {$from}");
					Apretaste::saveUglyEmail($from, $mail->subject, $mail, $mail->body, 'black_list');
					continue;
				}
				
				$textBody = strip_tags($mail->body);
				$htmlBody = $mail->body;
				
				if ($mail->subject == '')
					$mail->subject = 'AYUDA';
				
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
				
				// Call to callback
				echo "[INFO] Callback the message $message_number_iterator \n";
				
				if (strpos($from, '@nauta.cu')) {
					$textBody = ApretasteEncoding::base64Decode($textBody);
					$htmlBody = ApretasteEncoding::base64Decode($htmlBody);
				}
				
				$cutbody = array(
						"--\n",
						"-- \n",
						"=0A--=0A",
						"-----Mensaje original-----",
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
				
				$images = array();
				$mail->fromaddress = "{$mail->from}";
				$otherstuff = array();
				$address = "{$mail->to}";
				
				// Async
				$call = $robot->callback;
				$headers = new stdClass();
				
				$xfrom = new stdClass();
				$xfrom->mailbox = $mail->from->getMailbox();
				$xfrom->host = $mail->from->getHost();
				$headers->from = array(
						$xfrom
				);
				$headers->fromaddress = "{$mail->from}";
				
				$udate = strtotime(date("Y-m-d"));
				$udate = @strtotime($mail->date);
				
				$xto = new stdClass();
				$xto->mailbox = $mail->to->getMailBox();
				$xto->host = $mail->to->getHost();
				$headers->to = array(
						$xto
				);
				
				$headers->toaddress = "{$mail->to}";
				
				$headers->From = "Apretaste! <{$headers->fromaddress}>";
				$headers->To = $headers->toaddress;
				
				$headers->reply_to = $headers->from;
				$headers->reply_toaddress = $headers->fromaddress;
				
				$headers->sender = $headers->from;
				$headers->senderaddress = $headers->fromaddress;
				
				$headers->date = date("D, d M Y h:i:s O", $udate);
				$headers->Date = $headers->date;
				$headers->subject = $mail->subject;
				$headers->Subject = $mail->subject;
				$headers->message_id = $mail->id;
				
				$headers->Recent = " ";
				$headers->Unseen = "U";
				$headers->Flagged = " ";
				$headers->Answered = " ";
				$headers->Deleted = " ";
				$headers->Draft = " ";
				$headers->Msgno = "   0";
				$headers->MailDate = date("d-M-Y h:i:s O", $udate);
				$headers->Size = $mail->size;
				$headers->udate = $udate;
				
				$ans = $call($headers, $textBody, $htmlBody, $images, $otherstuff, "anuncios@apretaste.com", true, true, true);
			}
		return true;
	}
	
	/**
	 * Send answer
	 *
	 * @param ApretasteAnswerEmail $ans
	 * @param string $account
	 */
	static function sendAnswer($ans, $account = 'nauta'){
		self::buildRobot();
		
		$robot = self::$robot;
		
		$client = new ApretasteHordeClient($account);
		$address = $client->hordeConfig->address;
		
		echo "[INFO] Trying send answer with $address \n";
		
		$ans->config['reply_to'] = $address;
		
		$robot->log("Login in horde...");
		
		// $r = $client->login();
		/*
		 * if ($r) $robot->log("Login successfull!"); else { $robot->log("Login fail!"); return false; }
		 */
		$robot->log("Preparing email...");
		
		$mail = new ApretasteHordeEmail();
		
		if (isset($ans->headers['message_id']))
			$mail->id = $ans->headers['message_id'];
		else
			$mail->id = $ans->msg_id;
		
		$mail->body = $ans->message->getHTMLBody();
		
		$headers = $ans->headers;
		
		if (is_object($headers))
			$headers = get_object_vars($headers);
		
		$d = date("Y-m-d h:i:s");
		
		if (isset($headers['MailDate']))
			$d = $headers['MailDate'];
		elseif (isset($headers['Date']))
			$d = $headers['Date'];
		elseif (isset($headers['date']))
			$d = $headers['date'];
		
		$t = strtotime($d);
		$d = date("d/m/Y", $t);
		
		$mail->date = $d;
		$mail->from = $client->hordeConfig->address;
		$mail->to = $ans->to;
		$mail->mailedBy = 'Horde';
		$mail->signedBy = '';
		$mail->size = 0;
		
		if (isset($headers['subject']))
			$mail->subject = $headers['subject'];
		elseif (isset($headers['Subject']))
			$mail->subject = $headers['Subject'];
		else
			$mail->subject = 'Respondiendo a su mensaje';
		
		$fromAddress = $mail->to;
		$fromName = '';
		$subject = $mail->subject;
		$msg = $mail->body;
		
		$robot->log("Answer subject: " . $subject);
		
		$robot->log("Execute cURL request...");
		
		$c = curl_init();
		
		curl_setopt($c, CURLOPT_HTTPHEADER, array(
				"Cache-Control: max-age=0",
				"Origin: " . $client->hordeConfig->originUrl,
				"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36",
				"Content-Type: application/x-www-form-urlencoded"
		));
		
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_COOKIEJAR, '../tmp/' . $client->account . 'cookie');
		curl_setopt($c, CURLOPT_COOKIEFILE, '../tmp/' . $client->account . 'cookie');
		
		// Login
		curl_setopt($c, CURLOPT_URL, $client->hordeConfig->baseUrl . "/login.php");
		curl_setopt($c, CURLOPT_POSTFIELDS, "app=&login_post=1&url=&anchor_string=&ie_version=&horde_user=apretaste&horde_pass=3Jd8VfFT&horde_select_view=mobile&new_lang=en_US");
		
		$response = curl_exec($c);
		
		if ($response === false)
			return false;
		
		echo $response;
		
		curl_setopt($c, CURLOPT_URL, "http://webmail.nauta.cu/horde/services/ajax.php/imp/sendMessage"); // $client->hordeConfig->baseUrl . "/imp/compose-mimp.php");
		                                                                                                 // curl_setopt($c, CURLOPT_POSTFIELDS, "composeCache=&to=" . $fromAddress . "&cc=&bcc=&subject=" . urldecode($subject) . "&html=" . urldecode($msg) . "&cc=&bcc=a=Send");
		curl_setopt($c, CURLOPT_POSTFIELDS, "composeCache=&to=" . $fromAddress . "&cc=&bcc=&subject=" . urldecode($subject) . "&html=" . urldecode($msg) . "&cc=&bcc=&priority=normal&last_identity=0&identity=0&message=" . urlencode($msg));
		
		sleep(rand(1, 5));
		
		$result = curl_exec($c);
		
		echo $result;
		
		if (strpos("$result", "403 Forbidden") !== false) {
			$robot->log('403 Forbidden!', 'FATAL');
			$result = false;
		}
		
		if ($result == false) {
			$robot->log('cURL operation fail!', 'FATAL');
			return false;
		}
		
		Apretaste::saveAnswer($headers, $ans->type, $ans->msg_id);
		
		$robot->log('Delete sent messages...');
		$client->deleteSentMessages();
		
		$robot->log('Purge deleted mails...');
		$client->purgeDeletedMails("U2VudA");
		
		$robot->log('Logout from horde...');
		$client->logout();
		
		return true;
	}
}