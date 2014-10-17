<?php

/**
 * Horde's configuration
 *
 * @author Carlos
 *        
 */
class ApretasteHordeConfig {
	public $user;
	public $pass;
	public $baseUrl;
	public $originUrl;
	public $inboxPath;
	public $outBoxPath;
	public $successPath;
	public $address;
	
	/**
	 * Constructor
	 *
	 * @param string $account
	 */
	function __construct($account = "nauta"){
		$ini_data = parse_ini_file("../etc/horde.ini", true, INI_SCANNER_RAW);
		if (isset($ini_data[$account])) {
			
			$this->user = $ini_data[$account]["user"];
			$this->pass = $ini_data[$account]["pass"];
			$this->baseUrl = $ini_data[$account]["horde_url"];
			$this->originUrl = $ini_data[$account]["horde_origin"];
			$this->inboxPath = $ini_data[$account]["inbox_path"];
			$this->outBoxPath = $ini_data[$account]["outbox_path"];
			$this->successPath = $ini_data[$account]["success_path"];
			$this->address = $ini_data[$account]["address"];
			
			rpFileSystem::mkdir($this->inboxPath);
			rpFileSystem::mkdir($this->outBoxPath);
			rpFileSystem::mkdir($this->successPath);
		}
	}
}