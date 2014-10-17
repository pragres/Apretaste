<?php

/**
 * Email address entity
 *
 * @author Carlos
 * @version 1.0
 */
class ApretasteEmailAddress {
	
	public $email;
	public $name;
	
	/**
	 * Constructor 
	 * @param string $email
	 * @param string $name
	 */
	function __construct($email, $name){
		$this->email = $email;
		$this->name = $name;
	}
}