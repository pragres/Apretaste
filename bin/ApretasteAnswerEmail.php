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
	function __construct($config, $to, $servers, $data, $send = false, $verbose = false, $debug = false, $msg_id = null){
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
		if (isset($send))
			$this->send_answer($config['reply_to']);
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
	function send_answer($xfrom = null){
		$froms = array_keys($this->servers);
		
		if (trim($this->to) == '')
			return false;
		
		$mailboxescount = ApretasteMailboxes::getMailboxesCount();
		
		$sended = false;
		$i = 0;
		do {
			$i ++;
			
			if ($i > $mailboxescount) {
				echo "\n [FATAL] ---------------------------------\n";
				echo "[FATAL] No more servers!\n";
				echo "\n [FATAL] ---------------------------------\n";
				break;
			}
			
			do {
				$from = ApretasteMailboxes::getBestMailbox($this->to, $xfrom);
				
				if (! isset($this->servers[$from]))
					ApretasteMailboxes::deleteMailBox($from);
				else
					break;
			} while ( ! isset($this->servers[$from]) );
			
			$this->headers = array(
					"From" => "Apretaste! <$from>",
					"To" => $this->to
			);
			
			echo "[INFO] $i Trying send answer with $from \n";
			
			$this->config['reply_to'] = $from;
			
			// Build message one time
			
			if ($i == 1)
				$this->_buildMessage();
			
			echo $this->verbose ? "conecting to " . $from . " (" . $this->servers[$from]['host'] . ":" . $this->servers[$from]['port'] . ")\n" : "";
			
			$smtp_server = Mail::factory('smtp', $this->servers[$from]);
			
			if (get_class($smtp_server) != "Mail_smtp")
				die("Wrong mail driver");
			
			else if (get_class($smtp_server) == 'PEAR_Error') {}
			
			echo $this->verbose ? "delivering to " . $this->to . "\n" : "";
			
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
			
			echo $this->verbose ? "Send email \n" : "";
			
			$result = $smtp_server->send($this->to, $this->headers, $this->message->getMessageBody());
			
			if ($result !== true) {
				ob_start();
				echo "<h1>Error sending email from $from to {$this->to} </h1>\n";
				echo "<h2>The message will be send from PHP</h2>\n";
				echo "<br/>\n";
				
				//echo "Result = " . serialize($result);
				
				$serv = $this->servers[$from];
				
				echo "From: " . $serv['host'] . "<br/>";
				echo "<br/>\n";
				echo "To: " . $this->to . "<br/>\n";
				echo "Headers: <br/>\n";
				
				echo div::asThis($this->headers);
				
				echo "<br/>\n";
				
				// echo "Trying with other server ...\n";
				
				$message = ob_get_contents();
				
				ob_end_clean();
				
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: soporte@apretaste.com \r\n";
				$headers .= "Reply-To: soporte@apretaste.com \r\n";
				$headers .= 'X-Mailer: PHP/' . phpversion();
				
				mail('soporte@apretaste.com', "Error sending from $from to {$this->to}", $message, $headers);
				
				ApretasteMailboxes::saveShipmentError($from,'');
			} else
				$sended = true;
		} while ( $sended == false );
		
		if (! $sended) {
			
			echo "[INFO] Sending with PHP...\n";
			
			$hheaders = '';
			$hheaders .= "From: anuncios@apretaste.com \r\n";
			$hheaders .= "Reply-To: anuncios@apretaste.com \r\n";
			$hheaders .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
			
			foreach ( $this->headers as $key => $value )
				$hheaders .= $key . ': ' . $value . "\r\n";
			
			$subject = 'Apretaste!';
			
			if (isset($this->headers->subject))
				$subject = $this->headers->subject;
			if (isset($this->headers->Subject))
				$subject = $this->headers->Subject;
			
			$r = mail($this->to, $subject, $this->message->getMessageBody(), $hheaders);
			
			if ($r == false)
				return false;
			
			$from = 'anuncios@apretaste.com';
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
	function _buildMessage($build_plain = false, $build_html = true){
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
			
			$tpl_title = $plain_body->__memory['AnswerSubject'];
			
			$pbody = ApretasteView::htmlToText($plain_body->__src);
			
			while ( strpos($pbody, "\n\n") !== false )
				$pbody = str_replace("\n\n", "\n", $pbody);
			
			while ( strpos($pbody, "--") !== false )
				$pbody = str_replace("--", "", $pbody);
			
			$this->message->setTXTBody(utf8_decode($pbody));
		}
		
		if ($build_html) {
			echo "building " . $this->type . " html message\n";
			
			$data['content'] = $tpl_html;
			$data['builder'] = 'html';
			
			$html_body = new ApretasteView("../tpl/alone/answer", $data);
			
			$html_body->parse();
			
			$tpl_title = $html_body->__memory['AnswerSubject'];
			
			$this->message->setHTMLBody($html_body->__src);
			
			$data['images'][] = array(
					"type" => "image/jpg",
					"content" => file_get_contents("../web/static/apretaste.png"),
					"name" => "apretaste.logo.jpg",
					"id" => "logo"
			);
			
			if ($data) {
				if (isset($data['images']))
					if (is_array($data['images']))
						foreach ( $data['images'] as $image ) {
							if ($image['type'] == 'image/' || $image['type'] == '')
								$image['type'] = 'image/jpeg';
							$this->message->addHTMLImage($file = $image['content'], $c_type = $image['type'], $isfile = false, $name = $image['name'], $content_id = $image['id']);
						}
			}
		}
		
		echo "Adding email headers...\n";
		// $this->message->setTXTBody('');
		$this->addHeaders($this->message->headers());
		
		$subject = new ApretasteView('{strip}{txt}{% styles %}' . $tpl_title . '{/txt}{/strip}', $data);
		
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
