<?php

/**
 * Email Marketing
 *
 * @author rafa <rafa@pragres.com>
 *        
 */
class ApretasteMarketing {
	
	/**
	 * Adding a subscriber
	 *
	 * @param string $email
	 * @param string $name
	 * @return boolean unknown
	 */
	static public function addSubscriber($email, $name = ''){
		$s = self::getSubscriber($email);
		
		if (isset($s->email)) {
			// Apretaste::log("$email exists. ID = {$s['id']} ...\n", "marketing");
			return true;
		}
		
		Apretaste::log("Adding $email ...\n", "marketing");
		
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		$email = trim(strtolower($email));
		
		$ML_Subscribers = new ML_Subscribers($config['api_key']);
		
		$subscriber = array(
				'email' => $email,
				'name' => $name
		);
		
		$subscriber = $ML_Subscribers->setId($config['list_id'])->add($subscriber, 1 /* set resubscribe to true*/ );
		$subscriber = json_decode($subscriber);
		
		return $subscriber;
	}
	
	/**
	 * Getting a subscribers's details
	 *
	 * @param unknown $email
	 * @return boolean mixed
	 */
	static function getSubscriber($email){
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		$email = trim(strtolower($email));
		
		$ML_Subscribers = new ML_Subscribers($config['api_key']);
		
		$response = $ML_Subscribers->get($email, true /*set true to get history*/ );
		
		$response = json_decode($response);
		
		if (! $response || ! is_object($response)) {
			// die('Nothing was returned. Do you have a connection to Email Marketing server?');
			return false;
		}
		
		return $response;
	}
	
	/**
	 * Deleting a subscriber
	 *
	 * @param string $email
	 * @return boolean mixed
	 */
	static public function delSubscriber($email){
		Apretaste::log("Delete $email ...\n", "marketing");
		
		$s = self::getSubscriber($email);
		
		if (! isset($s->email)) {
			Apretaste::log("... $email not exists. \n", "marketing");
			return false;
		}
		
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		
		$email = trim(strtolower($email));
		
		$ML_Subscribers = new ML_Subscribers($config['api_key']);
		
		$subscriber = json_decode($ML_Subscribers->unsubscribe($email));
		
		if (! $subscriber) {
			// die('Nothing was returned. Do you have a connection to Email Marketing server?');
			return false;
		}
		
		return $subscriber;
	}
	
	static function getAllLists(){
		
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		$ML_Lists = new ML_Lists( $config['api_key'] );
		$lists = $ML_Lists->getAll( );
		$lists = json_decode($lists);
		return $lists;
		
	}
}