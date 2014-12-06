<?php
include "../lib/PEAR/mime.php";
include "../lib/PEAR/Mail.php";
include "../lib/PEAR/Net/SMTP.php";
class ApretasteAnswerEmail {
	var $from;
	var $to;
	var $reply_to;
	var $servers;
	var $type;
	var $headers = array();
	var $data = array();
	var $buttons = array();
	var $ads = array();
	var $images = array();
	var $msg_id = null;
	var $via_horde = false;
	
	/**
	 * Constructor
	 *
	 * @param unknown_type $config
	 * @param unknown_type $to
	 * @param unknown_type $servers
	 * @param unknown_type $data
	 * @param unknown_type $send
	 * @param unknown_type $verbose
	 * @param unknown_type $debug
	 */
	function __construct($config, $to, $servers, $data, $send = false, $verbose = false, $debug = false, $msg_id = null, $save_on_fail = true, $async = false, $via_horde = false){
		$this->via_horde = $via_horde;
		
		if ($via_horde) {
			$send = true;
			$async = true;
		}
		
		$this->msg_id = $msg_id;
		$this->config = $config;
		$this->to = $to;
		$this->type = $data['answer_type'];
		$this->servers = $servers;
		$temp = array_keys($this->servers);
		$this->from = $temp[0];
		$this->headers = array(
				"From" => "Apretaste! <{$config['reply_to']}>",
				"To" => $to
		);
		$this->verbose = $verbose;
		$this->debug = $debug;
		$this->message = new Mail_Mime(array(
				"text_encoding" => "7bit",
				"html_encoding" => "7bit"
		));
		
		if (isset($data['headers']))
			$this->addHeaders($headers = $data['headers']);
		if (isset($data))
			$this->addData($moredata = $data);
		if (isset($data['images']))
			$this->addImages($data['images']);
		if ($send)
			$this->send_answer($config['reply_to'], $save_on_fail, $async);
	}
	function addHeaders($headers){
		$this->headers = array_merge($this->headers, $headers);
	}
	function addData($moredata){
		$this->data = array_merge($this->data, $moredata);
	}
	function aditionalButtons($aditional_buttons){
		$this->buttons = array_merge($aditional_buttons, $this->buttons);
	}
	function addImages($images){
		$this->images = array_merge($this->images, $images);
	}
	function send_answer($xfrom = null, $save_on_fail = true, $async = false){
		$froms = array_keys($this->servers);
		
		echo "[INFO] Froms: " . implode(", ", $froms) . "\n";
		
		if (trim($this->to) == '')
			return false;
		
		$this->to = Apretaste::extractEmailAddress($this->to);
		
		echo "[INFO] Sending to {$this->to}...\n";
		
		echo "[INFO] Getting mailboxes setup...\n";
		
		$mailboxescount = ApretasteMailboxes::getMailboxesCount();
		
		$sent = false;
		$i = 0;
		do {
			$i ++;
			
			if ($i > $mailboxescount) {
				echo "[FATAL] No more servers! The answer will be saved in outbox \n";
				break;
			}
			
			echo "[INFO] Get best mailbox \n";
			$last_best = null;
			do {
				$from = ApretasteMailboxes::getBestMailbox($this->to, $xfrom);
				
				if (is_null($from)) {
					echo "[FATAL] No mailboxes! Goto admin page NOW!....Trying solve the problem :( \n";
					q("UPDATE mailboxes SET last_error_date = null;");
					return false;
				}
				
				echo "[INFO] --- best mailbox: trying $from \n";
				
				if ($from == $last_best) {
					echo "[INFO] .... equal to last best.... try later...\n";
					return false;
				}
				
				if (! isset($this->servers[$from])) {
					echo "[FATAL] The mailbox $from is not configured yet\n";
					// ApretasteMailboxes::deleteMailBox($from);
				} else
					break;
				
				$last_best = $from;
			} while ( ! isset($this->servers[$from]) );
			
			echo "[INFO] Best mailbox = $from \n";
			
			$this->headers = array(
					"From" => "Apretaste! <$from>",
					"To" => $this->to
			);
			
			echo "[INFO] $i Trying send answer with $from \n";
			
			$this->config['reply_to'] = $from;
			
			// Build message one time
			if (! $async)
				$this->_buildMessage();
				
				// After build.... if it is async then break
			if ($async)
				break;
			
			echo $this->verbose ? "conecting to " . $from . " (" . $this->servers[$from]['host'] . ":" . $this->servers[$from]['port'] . ")\n" : "";
			
			$smtp_server = Mail::factory('smtp', $this->servers[$from]);
			
			if (get_class($smtp_server) != "Mail_smtp")
				die("Wrong mail driver");
			
			else if (get_class($smtp_server) == 'PEAR_Error') {
				echo "[ERROR] PEAR: " . $smtp_server->message . "\n";
			}
			
			echo $this->verbose ? "[INFO] Delivering to " . $this->to . "\n" : "";
			
			// Checking black and white list
			echo $this->verbose ? "getting black and white list\n" : "";
			$blacklist = Apretaste::getEmailBlackList();
			$whitelist = Apretaste::getEmailWhiteList();
			
			echo $this->verbose ? "checking address in black and white list\n" : "";
			if ((Apretaste::matchEmailPlus($this->to, $blacklist) == true && Apretaste::matchEmailPlus($this->to, $whitelist) == false)) {
				// imap_delete($this->imap, $message_number_iterator);
				echo $this->verbose ? "[INFO] ignore email address {$this->to}\n" : "";
				return false;
			}
			
			echo $this->verbose ? "All OK with this address\n" : "";
			
			$message = '';
			
			echo $this->verbose ? "Send email to {$this->to}\n" : "";
			
			// if ($i == 1)
			$messageBody = $this->message->getMessageBody();
			
			// Silent mode
			$ssend = true;
			
			if (isset($this->data['answer_dont_send']))
				if ($this->data['answer_dont_send'] == true)
					$ssend = false;
			
			if ($ssend === true)
				$result = $smtp_server->send($this->to, $this->headers, $messageBody);
			else {
				echo $this->verbose ? "SILENT MODE: The answer was not sent to {$this->to}\n" : "";
				$result = true;
			}
			
			if ($result !== true) {
				ApretasteMailboxes::saveShipmentError($from, '');
				/*
				 * ob_start(); echo "<h1>Error sending email from $from to {$this->to} </h1>\n"; echo "<br/>\n"; // echo "Result = " . serialize($result); $serv = $this->servers[$from]; echo "From: " . $serv['host'] . "<br/>"; echo "<br/>\n"; echo "To: " . $this->to . "<br/>\n"; echo "Headers: <br/>\n"; echo var_export($this->headers, true); echo "<br/>\n"; // echo "Trying with other server ...\n"; $message = ob_get_contents(); ob_end_clean(); $headers = 'MIME-Version: 1.0' . "\r\n"; $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; $headers .= "From: soporte@apretaste.com \r\n"; $headers .= "Reply-To: soporte@apretaste.com \r\n"; $headers .= 'X-Mailer: PHP/' . phpversion(); mail('soporte@apretaste.com', "Error sending from $from to {$this->to}", $message, $headers);
				 */
			} else
				$sent = true;
		} while ( $sent == false );
		
		if (! $sent) {
			if ($save_on_fail || $async) {
				echo "[INFO] Saving email in outbox for {$this->to}\n";
				Apretaste::query("INSERT INTO email_outbox (data) VALUES ('" . base64_encode(serialize($this)) . "');");
			}
			return false;
		}
		
		echo $this->verbose ? "Save answer\n" : "";
		
		ApretasteMailboxes::addShipment($from);
		
		Apretaste::saveAnswer($this->headers, $this->type, $this->msg_id);
		
		echo $this->verbose ? "Send result: " . $result . "\n" : "";
		echo ($this->debug) ? $this->message->getHTMLBody() : "";
		echo ($this->debug) ? $this->message->getTXTBody() : "";
		
		return true;
	}
	
	/**
	 * Build a message
	 *
	 * @param boolean $build_plain
	 * @param boolean $build_html
	 */
	function _buildMessage($build_plain = false, $build_html = true, $inline_images = false){
		$data = array(
				'buttons' => $this->buttons,
				'ads' => $this->ads,
				'images' => $this->images,
				'headers' => $this->headers
		);
		
		$data = array_merge($data, $this->config);
		$data = array_merge($data, $this->data);
		
		$tpl_plain = "{$this->type}";
		$tpl_html = "{$this->type}";
		
		$build_plain = false;
		
		if (isset($data['as_plain_text']))
			if ($data['as_plain_text'] == true) {
				$build_plain = true;
				$build_html = false;
			}
		
		$tpl_title = "{$this->type}.title";
		
		if ($build_plain) {
			
			echo "building " . $this->type . " text message\n";
			$data['builder'] = 'plain';
			$data['content'] = $tpl_plain;
			
			$plain_body = new ApretasteView("../tpl/alone/answer", $data);
			
			$plain_body->parse();
			
			if (isset($plain_body->__items['AnswerSubject'])) {
				$tpl_title = $plain_body->__items['AnswerSubject'];
			} else
				$tpl_title = "Respondiendo a su mensaje";
				
				/*
			 * else if (isset($data['subject'])) $tpl_title = $data['subject']; else if (isset($data['title'])) $tpl_title = $data['title'];
			 */
			
			$pbody = ApretasteView::htmlToText($plain_body->__src);
			
			while ( strpos($pbody, "\n\n") !== false )
				$pbody = str_replace("\n\n", "\n", $pbody);
			
			while ( strpos($pbody, "--") !== false )
				$pbody = str_replace("--", "", $pbody);
			
			$this->message->setTXTBody(utf8_decode($pbody));
		}
		
		if ($build_html) {
			echo "[INFO] Building " . $this->type . " html message\n";
			
			$data['content'] = $tpl_html;
			$data['builder'] = 'html';
			
			$html_body = new ApretasteView("../tpl/alone/answer", $data);
			
			$html_body->parse();
			
			if (isset($html_body->__items['AnswerSubject'])) {
				$tpl_title = $html_body->__items['AnswerSubject'];
			} else
				$tpl_title = "Respondiendo a su mensaje";
				
				/*
			 * if (isset($html_body->__memory['AnswerSubject'])) $tpl_title = $html_body->__memory['AnswerSubject']; else if (isset($data['subject'])) $tpl_title = $data['subject']; else if (isset($data['title'])) $tpl_title = $data['title'];
			 */
			
			echo "[INFO] Answer subject = " . $tpl_title . "\n";
			
			/*
			 * $data['images']['logo'] = array( "type" => "image/jpg", "content" => file_get_contents("../web/static/apretaste.png"), "name" => "apretaste.logo.jpg", "id" => "logo" );
			 */
			
			if ($data) {
				if (isset($data['images']))
					if (is_array($data['images'])) {
						$ya = array();
						$yabase64 = array();
						foreach ( $data['images'] as $image ) {
							if (isset($image['id'])) {
								if (! isset($ya[$image['id']])) {
									$md5 = md5(base64_encode($image['content']));
									if (! isset($yabase64[$md5])) {
										if ($image['type'] == 'image/' || $image['type'] == '')
											$image['type'] = 'image/jpeg';
										
										if ($inline_images) {
											$content = rtrim(chunk_split(base64_encode($image['content']), 76, "\r\n"));
											$html_body->__src = str_replace('cid:' . $image['id'], 'data:' . $image['type'] . ';base64,' . $content, $html_body->__src);
										} else
											$this->message->addHTMLImage($file = $image['content'], $c_type = $image['type'], $isfile = false, $name = $image['name'], $content_id = $image['id']);
										
										$yabase64[$md5] = true;
										$ya[$image['id']] = true;
									}
								}
							}
						}
					}
			}
			
			$this->message->setHTMLBody($html_body->__src);
		}
		
		echo "Adding email headers...\n";
		// $this->message->setTXTBody('');
		$this->addHeaders($this->message->headers());
		
		$subject = new ApretasteView('{= div.literals: ["msg.subject", "subject", "query", "body", "sharethis","bodysent","bodyextra"] =} {strip}{txt}{% styles %}' . $tpl_title . '{/txt}{/strip}', $data);
		
		$subject = ApretasteEncoding::UTF8FixWin1252Chars($subject);
		
		if (! Apretaste::isUTF8($subject)) {
			$subject = ApretasteEncoding::toUTF8($subject);
		}
		
		$subject = htmlentities($subject, ENT_COMPAT | ENT_HTML401, 'UTF-8', false);
		$subject = str_replace('&', '', $subject);
		$subject = str_replace('tilde;', '', $subject);
		$subject = str_replace('acute;', '', $subject);
		$subject = html_entity_decode($subject, ENT_COMPAT | ENT_HTML401, 'UTF-8');
		
		// $subject = html_entity_decode(htmlentities($subject, null, 'UTF-8', false));
		
		$this->addHeaders(array(
				'Subject' => $subject
		));
	}
}
