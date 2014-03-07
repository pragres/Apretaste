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
	function send_answer($from = null){
		$i = 0;
		$froms = array_keys($this->servers);
		$first = true;
		$ya = false;
		
		if (trim($this->to) == '')
			return false;
		do {
			
			if ($i > 0) {
				
				// No more servers for send
				if (! isset($froms[$i])) {
					echo "[FATAL] No more servers!?\n";
					break;
				}
				
				$from = $froms[$i];
			}
			
			echo "[INFO] $i Trying send answer with $from \n";
			
			if (is_null($from))
				
				$from = $this->from;
			if (! isset($this->servers[$from]))
				$from = $this->from;
			
			$this->config['reply_to'] = $from;
			
			if ($i == 0)
				$this->_buildMessage();
			
			echo $this->verbose ? "conecting to " . $from . " (" . $this->servers[$from]['host'] . ":" . $this->servers[$from]['port'] . ")\n" : "";
			
			$smtp_server = Mail::factory('smtp', $this->servers[$from]);
			
			if (get_class($smtp_server) != "Mail_smtp")
				die("Wrong mail driver");
			
			else if (get_class($smtp_server) == 'PEAR_Error') {}
			
			echo $this->verbose ? "delivering to " . $this->to . "\n" : "";
			
			// Checking black and white list
			
			$blacklist = Apretaste::getEmailBlackList();
			$whitelist = Apretaste::getEmailWhiteList();
			
			if ((Apretaste::matchEmailPlus($this->to, $blacklist) == true && Apretaste::matchEmailPlus($this->to, $whitelist) == false)) {
				imap_delete($this->imap, $message_number_iterator);
				echo $this->verbose ? "[INFO] ignore email address {$this->to}\n" : "";
				return false;
			}
			
			$message = '';
			ob_start();
			
			$result = $smtp_server->send($this->to, $this->headers, $this->message->getMessageBody());
			
			if ($result !== true) {
				if (! isset($froms[$i + 1])) {
					echo "<h1>Error sending email from SMTP server to {$this->to} </h1>\n";
					echo "<br/>\n";
					echo '$server = ';
					echo nl2br(var_export($this->servers[$from]), true);
					// echo "<br/>\n";
					/*
					 * echo '$result = '; echo nl2br(var_export($result), true);
					 */
					echo "<br/>\n";
					echo "To: " . $this->to . "<br/>\n";
					echo "Headers: <br/>\n";
					echo nl2br(var_export($this->headers), true);
					echo "<br/>\n";
					// echo "Trying with other server ...\n";
					$message = ob_get_contents();
					
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= "From: soporte@apretaste.com \r\n";
					$headers .= "Reply-To: soporte@apretaste.com \r\n";
					$headers .= 'X-Mailer: PHP/' . phpversion();
					
					mail('soporte@apretaste.com', "Error sending from $from to {$this->to}", $message, $headers);
					break;
				}
				
				$i ++;
				continue;
			}
			
			$ya = true;
			
			ob_end_clean();
			
			Apretaste::saveAnswer($this->headers, $this->type, $this->msg_id);
			
			echo $this->verbose ? "Send result: " . $result . "\n" : "";
			echo ($this->debug) ? $this->message->getHTMLBody() : "";
			echo ($this->debug) ? $this->message->getTXTBody() : "";
			
			$first = false;
			
			return true;
		} while ( ! $ya || ! isset($froms[$i + 1]) );
		
		return false;
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
		
		$language = 'es';
		
		$tpl_plain = "../tpl/alone/{$this->type}.{$language}.plain";
		$tpl_html = "../tpl/alone/{$this->type}.{$language}.html";
		$tpl_title = "../tpl/alone/{$this->type}.{$language}.title";
		
		if ($build_plain) {
			echo $this->debug ? "building " . $this->type . " text message\n" : "";
			$data['builder'] = 'plain';
			$plain_body = new div($tpl_plain, $data);
			$this->message->setTXTBody(utf8_decode($plain_body));
		}
		
		if ($build_html) {
			echo $this->debug ? "building " . $this->type . " html message\n" : "";
			$data['content'] = $tpl_html;
			$data['builder'] = 'html';
			
			// var_dump($data);
			// echo serialize($data);
			$html_body = new div("../tpl/alone/answer", $data);
			
			$this->message->setHTMLBody($html_body);
			$data['images'][] = array(
					"type" => "image/jpg",
					"content" => file_get_contents("../web/static/apretaste.logo.jpg"),
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
		
		$this->addHeaders($this->message->headers());
		
		$subject = new div($tpl_title, $data);
		$this->addHeaders(array(
				'Subject' => trim(html_entity_decode($subject))
		));
	}
}
