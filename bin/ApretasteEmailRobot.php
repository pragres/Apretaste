<?php
/**
 * Apretaste!com Email Robot
 *
 * version 1.5
 */
class ApretasteEmailRobot {
	function __construct($autostart = true, $verbose = false, $debug = false){
		$this->verbose = $verbose;
		$this->debug = $debug;
		
		Apretaste::loadSetup();
		
		// Loading commands
		$commands = Apretaste::$config["commands"];
		
		$this->commands = $commands;
		
		// Sort commands by LENGTH
		foreach ( $commands as $cmd => $val ) {
			$commands[$cmd] = strlen($cmd);
		}
		
		arsort($commands);
		
		$cmds = array();
		
		foreach ( $commands as $key => $l ) {
			$cmds[$key] = $this->commands[$key];
		}
		
		$this->commands = $cmds;
		
		// Callback
		$clase = $this;
		
		$this->callback = function ($headers, $textBody = false, $htmlBody = false, $images = false, $otherstuff = false, $account = null, $send = true, $async = false, $via_horde = false, $force_log_message = false, &$message_id = null) use($clase){
			
			$rawCommand = array(
					'headers' => $headers,
					'textBody' => $textBody,
					'htmlBody' => $htmlBody,
					'images' => $images,
					'otherstuff' => $otherstuff
			);
			
			$command = $clase->_prepareCommand($rawCommand);
			if ($command['operation']) {
				
				$clase->log("Performing a " . $command['operation'] . " operation");
				
				$cmdpath = "../cmds/{$command['operation']}.php";
				$answer = array();
				
				$clase->account = $account;
				
				if (file_exists($cmdpath)) {
					include_once $cmdpath;
					$user_func = 'cmd_' . $command['operation'];
					$params = $command['parameters'];
					array_unshift($params, $clase);
					$command['parameters'] = $params;
					
					$answer = call_user_func_array($user_func, $command['parameters']);
					if (! isset($answer['command']))
						$answer['command'] = $command['operation'];
					if (! isset($answer['from']))
						$answer['from'] = $params[1];
					if (! isset($answer['answer_type']))
						$answer['answer_type'] = $command['operation'];
				}
			} else {
				echo $clase->verbose ? "retrieving documentation\n" : "";
				$answer = array(
						'answer_type' => $command['parameters'][0]
				);
			}
			
			if ($send || $force_log_message) 
				$msg_id = $clase->logger->log($rawCommand, $answer);
			else
				$msg_id = uniqid();
			
			// return via output/reference parameter
			$message_id = $msg_id;
			
			echo $clase->verbose ? "sending a " . $answer['answer_type'] . " type message\n" : "";
			
			if (is_null($account)) {
				foreach ( $clase->config_answer as $k => $v ) {
					$account = $k;
					break;
				}
			}
			
			if (! isset($answer['_answers'])) {
				$answer = array(
						'_answers' => array(
								$answer
						)
				);
			}
			
			$answerMail = array();
			
			foreach ( $answer['_answers'] as $ans ) {
				
				$d = date("Y-m-d h:i:s");
				
				if (isset($headers->MailDate))
					$d = $headers->MailDate;
				elseif (isset($headers->Date))
					$d = $headers->Date;
				elseif (isset($headers->date))
					$d = $headers->date;
				
				$t = strtotime($d);
				$d = date("d/m/Y", $t);
				
				$s = '';
				
				if (isset($headers->subject))
					$s = $headers->subject;
				elseif (isset($headers->Subject))
					$s = $headers->Subject;
				
				$s = htmlentities(quoted_printable_decode($s));
				
				echo "[INFO] Message subject = $s date = $d \n";
				
				$ans['msg'] = array(
						'date' => $d,
						'subject' => $s
				);
				
				$e = trim(strtolower(Apretaste::extractEmailAddress($rawCommand['headers']->fromaddress)));
				if ($send)
					Apretaste::query("UPDATE address_list SET source = 'apretaste.public.messages' WHERE email = '$e';");
				
				$to = $rawCommand['headers']->fromaddress;
				
				if (isset($ans['_to']))
					$to = $ans['_to'];
				
				if (isset($clase->config_answer[$account]))
					$config = $clase->config_answer[$account];
				else
					$config = $clase->config_answer['anuncios@apretaste.com'];
				
				$answerMail[] = new ApretasteAnswerEmail($config, $to, $servers = $clase->smtp_servers, $data = $ans, $send, $verbose = $clase->verbose, $debug = $clase->debug, $msg_id, true, $async, $via_horde);
			}
			
			return $answerMail;
		};
		
		$this->logger = new ApretasteEmailLogger($this->verbose, $this->debug);
		
		// Loading configuration
		
		$thesource = new DOMImplementation();
		$configuration = $thesource->createDocument();
		$configuration->load("../etc/configuration.xml");
		$configuration->validate();
		
		// SMTP servers
		$smtps = $configuration->documentElement->getElementsByTagName('smtp');
		$this->smtp_servers = array();
		for($i = 0; $i < $smtps->length; $i ++)
			if (mb_strtolower($smtps->item($i)->getAttribute('auth')) == 'false' || mb_strtolower($smtps->item($i)->getAttribute('auth')) == 'no')
				$this->smtp_servers[$smtps->item($i)->getAttribute('address')] = array(
						'host' => $smtps->item($i)->getAttribute('host'),
						'port' => $smtps->item($i)->getAttribute('port'),
						'auth' => false,
						'username' => "",
						'password' => ""
				);
			else
				$this->smtp_servers[$smtps->item($i)->getAttribute('address')] = array(
						'host' => $smtps->item($i)->getAttribute('host'),
						'port' => $smtps->item($i)->getAttribute('port'),
						'auth' => true,
						'username' => $smtps->item($i)->getAttribute('username'),
						'password' => $smtps->item($i)->getAttribute('password')
				);
		
		//echo "[INFO] Loaded SMTP configuration: " . implode(array_keys($this->smtp_servers)) . "\n";
		
		// IMAP servers
		$imaps = $configuration->documentElement->getElementsByTagName('imap');
		$this->imap_servers = array();
		for($i = 0; $i < $imaps->length; $i ++) {
			$enable = $imaps->item($i)->getAttribute('enable');
			if ("$enable" == "true") {
				$this->imap_servers[$imaps->item($i)->getAttribute('address')] = array(
						'mailbox' => $imaps->item($i)->getAttribute('mailbox'),
						'username' => $imaps->item($i)->getAttribute('username'),
						'password' => $imaps->item($i)->getAttribute('password')
				);
			}
		}
		
		// Answers configuration
		$configNodes = $configuration->documentElement->getElementsByTagName('config');
		$this->configs = array();
		
		for($i = 0; $i < $configNodes->length; $i ++) {
			if (! isset($this->config_answer[$configNodes->item($i)->getAttribute('for')]))
				$this->config_answer[$configNodes->item($i)->getAttribute('for')] = array();
			$this->config_answer[$configNodes->item($i)->getAttribute('for')][$configNodes->item($i)->getAttribute('name')] = $configNodes->item($i)->getAttribute('value');
		}
		
		if ($autostart)
			$this->start();
	}
	function start(){
		// Scan for new messages
		$this->collect = new ApretasteEmailCollector($this->imap_servers, $verbose = $this->verbose, $debug = $this->debug);
		$this->collect->get($callback = $this->callback);
	}
	function _prepareCommand($anounce){
		$subj = trim(urldecode($anounce['headers']->subject));
		
		$command = false;
		
		foreach ( $this->commands as $key => $command_name ) {
			
			if (substr(strtolower($subj), 0, strlen($key)) == strtolower($key)) {
				$command = array(
						substr($subj, 0, strlen($key)),
						trim(substr($subj, strlen($key)))
				);
				
				break;
			}
		}
		
		$command_name = mb_strtolower(trim($command[0]));
		
		if (count($command) == 2) {
			$argument = trim($command[1]);
			if (isset($argument[0]))
				if ($argument[0] == ':' || $argument[0] == ',')
					$argument = substr($argument, 1);
			$argument = trim($command[1]);
		} else
			$argument = false;
		
		$from = $anounce['headers']->from[0]->mailbox . '@' . $anounce['headers']->from[0]->host;
		$body = $anounce['textBody'] ? $anounce['textBody'] : $anounce['htmlBody'];
		
		if (array_key_exists($command_name, $this->commands)) {
			$actual_command = $this->commands[$command_name];
			
			if ($this->commands[$command_name] != "exclusion") {
				Apretaste::incorporate($from);
			}
			
			$parameters = array(
					$from,
					$argument,
					$body,
					$anounce['images']
			);
		} else {
			$actual_command = $this->commands[Apretaste::$config["default_command"]];
			$parameters = array(
					$from,
					$subj,
					$body,
					$anounce['images']
			);
		}
		
		return array(
				'operation' => $actual_command,
				'parameters' => $parameters
		);
	}
	
	/**
	 * Output log messages
	 *
	 * @param string $message
	 * @param string $level
	 */
	function log($message, $level = 'INFO'){
		if (! isset($level[3])) {
			$x = 4 - strlen($level);
			if ($x < 0)
				$x = 0;
			$level = str_repeat(' ', $x) . $level;
		}
		
		if (Apretaste::isCli())
			echo $this->verbose ? '[' . $level . '] ' . date("Y-m-d h:i:s") . "-" . $message . "\n" : '';
	}
}
