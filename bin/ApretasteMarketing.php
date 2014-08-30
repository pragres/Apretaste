<?php

/**
 * Email Marketing
 *
 * @author rafa <rafa@pragres.com>
 *        
 */
class ApretasteMarketing {
	static public function addSubscriber($email){
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		$email = trim(strtolower($email));
		
		// By default, this sample code is designed to get the result from your
		// server (where Email It Email Marketing is installed) and to print out the result
		$url = $config['url'];
		
		$params = array(
				'api_user' => $config['username'],
				'api_pass' => $config['pass'],
				'api_key' => $config['api_key'],
				'api_action' => 'subscriber_add',
				'api_output' => 'serialize'
		);
		
		// here we define the data we are posting in order to perform an update
		$post = array(
				// 'id' => 0, // adds a new one
				// 'username' => $params['api_user'], // username cannot be changed!
				'email' => $email,
				'first_name' => 'FirstName',
				'last_name' => 'LastName',
				
				// any custom fields
				// 'field[345,0]' => 'field value', // where 345 is the field ID
				
				// assign to lists:
				'p[' . $config['list_id'] . ']' => $config['list_id'], // example list ID
				'status[' . $config['list_id'] . ']' => 1
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach ( $params as $key => $value )
			$query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// This section takes the input data and converts it to the proper format
		$data = "";
		foreach ( $post as $key => $value )
			$data .= $key . '=' . urlencode($value) . '&';
		$data = rtrim($data, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// This sample code uses the CURL library for php to establish a connection,
		// submit your request, and show (print out) the response.
		if (! function_exists('curl_init'))
			die('CURL not supported. (introduced in PHP 4.0.2)');
			
			// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ($params['api_output'] == 'json' && ! function_exists('json_decode')) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		
		// define a final API request - GET
		$api = $url . '/manage/eiapi.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
		                                                  // curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		
		$response = (string) curl_exec($request); // execute curl post and store results in $response
		
		curl_close($request); // close curl object
		
		if (! $response) {
			// die('Nothing was returned. Do you have a connection to Email Marketing server?');
			return false;
		}
		$result = unserialize($response);
		return $result;
	}
	static function getSubscriber($email){
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		$email = trim(strtolower($email));
		
		// By default, this sample code is designed to get the result from your
		// server (where Email It Email Marketing is installed) and to print out the result
		$url = $config['url'];
		
		$params = array(
				'api_user' => $config['username'],
				'api_pass' => $config['pass'],
				'api_key' => $config['api_key'],
				'api_action' => 'subscriber_view_email',
				'api_output' => 'serialize',
				'email' => $email
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach ( $params as $key => $value )
			$query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// This sample code uses the CURL library for php to establish a connection,
		// submit your request, and show (print out) the response.
		if (! function_exists('curl_init'))
			die('CURL not supported. (introduced in PHP 4.0.2)');
			
			// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ($params['api_output'] == 'json' && ! function_exists('json_decode')) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		
		// define a final API request - GET
		$api = $url . '/manage/eiapi.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		                                                  // curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		
		$response = (string) curl_exec($request); // execute curl fetch and store results in $response
		                                          
		// additional options may be required depending upon your server configuration
		                                          // you can find documentation on curl options at http://www.php.net/curl_setopt
		curl_close($request); // close curl object
		
		if (! $response) {
			// die('Nothing was returned. Do you have a connection to Email Marketing server?');
			return false;
		}
		
		$result = unserialize($response);
		
		return $result;
	}
	
	static public function delSubscriber($email){
		Apretaste::loadSetup();
		
		$config = Apretaste::$config['marketing'];
		$email = trim(strtolower($email));
		
		// By default, this sample code is designed to get the result from your
		// server (where Email It Email Marketing is installed) and to print out the result
		$url = $config['url'];
		
		$s = self::getSubscriber($email);
		
		$id = null;
		
		if (isset($s['id']))
			$id = $s['id'];
		else
			return false;
		
		$params = array(
				'api_user' => $config['username'],
				'api_pass' => $config['pass'],
				'api_key' => $config['api_key'],
				'api_action' => 'subscriber_delete',
				'api_output' => 'serialize',
				'id' => $id
		);
		
		// here we define the data we are posting in order to perform an update
		$post = array(
				// 'id' => 0, // adds a new one
				// 'username' => $params['api_user'], // username cannot be changed!
				'email' => $email,
				'first_name' => '',
				'last_name' => ''
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach ( $params as $key => $value )
			$query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// This sample code uses the CURL library for php to establish a connection,
		// submit your data, and show (print out) the response.
		if (! function_exists('curl_init'))
			die('CURL not supported. (introduced in PHP 4.0.2)');
			
			// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ($params['api_output'] == 'json' && ! function_exists('json_decode')) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		
		// define a final API request - GET
		$api = $url . '/manage/eiapi.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		                                                  // curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		
		$response = (string) curl_exec($request); // execute curl fetch and store results in $response
		                                          
		// additional options may be required depending upon your server configuration
		                                          // you can find documentation on curl options at http://www.php.net/curl_setopt
		curl_close($request); // close curl object
		
		if (! $response) {
			// die('Nothing was returned. Do you have a connection to Email Marketing server?');
			return false;
		}
		$result = unserialize($response);
		return $result;
	}
}