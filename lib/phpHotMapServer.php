<?php

/**
 * Server instance
 *
 * @author Rafael Rodriguez Ramirez
 * @version 1.0
 */

define("PHP_HOT_MAP_ACCESS_DENIED_HOST", "PHP_HOT_MAP_ACCESS_DENIED_HOST");
define("PHP_HOT_MAP_ACCESS_DENIED_USER", "PHP_HOT_MAP_ACCESS_DENIED_USER");
define("PHP_HOT_MAP_LOGIN_SUCCESSFUL", "PHP_HOT_MAP_LOGIN_SUCCESSFUL");
define("PHP_HOT_MAP_LOGIN_FAILED", "PHP_HOT_MAP_LOGIN_FAILED");
define("PHP_HOT_MAP_LOGOUT_SUCCESSFUL", "PHP_HOT_MAP_LOGOUT_SUCCESSFUL");
define("PHP_HOT_MAP_METHOD_EXECUTED", "PHP_HOT_MAP_METHOD_EXECUTED");
define("PHP_HOT_MAP_METHOD_NOT_EXISTS", "PHP_HOT_MAP_METHOD_NOT_EXISTS");

/*
 How to use?

$server = new phpHotMapServer();  // Server instance
$server->addMethod("getEnterprise", "reu");  // Add public method
$server->addMethod("Company::getEmployees", true); // Add private method
$server->addData("Company", array("name" => "My Company", "phone" => "(444)-485758")); // Add some data
$server->go();
*/

class phpHotMapServer {

	private $methods = array();
	private $data = array();

	/**
	 * Add data
	 *
	 * @param string $var
	 * @param mixed $value
	*/
	public function addData($var, $value){
		$this->data[$var] = $value;
	}

	/**
	 * Register method
	 *
	 * @param string $name
	 * @param mixed $params
	 * @param boolean $params_complex
	 * @param boolean $security
	 * @param array $hosts
	 */
	public function addMethod($name, $params = array(), $params_complex = false, $security = false, $hosts = array(), $include = null, $namespace = null) {

		if ($params == '') $params = array();
		$params = !is_array($params) ? explode(",", $params): $params;

		foreach ($params as $key => $param){
			$params[$key] = trim($param);
		}

		$m = array(
				"security" => $security,
				"hosts" => $hosts,
				"name" => $name,
				"params" => $params,
				"params_complex" => $params_complex,
				"include" => $include,
				"namespace" => $namespace
		);

		$this->methods[$name] = $m;
		if ($namespace != '' && !is_null($namespace)) $this->methods[$namespace] = $m;
	}

	/**
	 * Publish methods: send a json to browser
	 *
	 */
	private function publish() {

		echo "{\n";
		$j = 0;
		$clases = array();
		foreach ($this->methods as $key => $m) {
			$namespace = false;
			if (isset($m['namespace'])) if ($m['namespace']!='') if (!is_null($m['namespace'])) $namespace = $m['namespace'];

			if (strpos($key, "::") !== false && $namespace === false) {
				$arr = explode("::", $key);

				if (!isset($clases[$arr[0]])){
					$clases[$arr[0]] = $arr[0] . ": {\n";
				}
				else{
					$clases[$arr[0]] .= ",";
				}

				if ($m['params_complex'] == true) {
					$clases[$arr[0]] .= ($namespace!==false?"'$namespace'":"{$arr[1]}").": function(params){\n";
				} else {
					$clases[$arr[0]] .= ($namespace!==false?"'$namespace'":"{$arr[1]}").": function(";

					$i = 0;
					foreach ($m['params'] as $p) {
						if ($i++ > 0)
							$clases[$arr[0]] .= ",";
						$clases[$arr[0]] .= "$p";
					}

					$clases[$arr[0]] .= "){\n   var params = {};";
					foreach ($m['params'] as $p) {
						$clases[$arr[0]] .= "params.$p = $p;";
					}
				}
				$clases[$arr[0]] .= "\n   return phpHotMap.call(this.__server, '{$arr[0]}::{$arr[1]}',params);}";
			} else {

				echo $j++ > 0? ", ":"";

				if ($m['params_complex'] == true) {
					echo ($namespace!==false?"'$namespace'":"$key").": function(params){\n";
				} else {
					echo ($namespace!==false?"'$namespace'":"$key").": function(";

					$i = 0;
					foreach ($m['params'] as $p) {
						echo $i++ > 0? ",":"";
						echo "$p";
					}

					echo ($i>0?", ":"")."async){\n   var params = {};";
					foreach ($m['params'] as $p) {
						echo "params.$p = $p;";
					}
				}
				echo "\n    return phpHotMap.call(this.__server, '$key',params);\n }\n";
			}
		}

		$i = 0;
		$data = $this->data;
		foreach ($clases as $key => $c){
			echo $i == 0 && $j > 0?",":"";
			echo $i > 0?",":"";
			echo "$c";
			if (isset($data[$key])){
				$js = json_encode($data[$key]);
				if (substr($js,0,1)=="{"){
					$js = substr($js,1,strlen($js)-2);
				}
				echo ",$js}";
				unset($data[$key]);
			} else
				echo "}";
		}

		$k = 0;
		foreach ($data as $var => $value){
			echo $k == 0 && $i>0?",":"";
			echo $k > 0?",":"";
			echo $var.": " .json_encode($value);
		}

		echo " }";

	}

	/**
	 * Execute a method
	 *
	 * @param string $method
	 */
	private function execute($method){

		if (!isset($this->methods[$method]))
			return PHP_HOT_MAP_METHOD_NOT_EXISTS;
			
		// Execute hook before
		if (function_exists("phpHotMap_before")){
			phpHotMap_before($method);
		}

		// Execute method
		$result = null;

		if (isset($this->methods[$method])) {
			$method = $this->methods[$method];

			ob_start();
			if (isset($method['include'])){
				$include = $method['include'];
				if (!is_null($include)){
					if (is_string($include)){
						include_once($include);
					} elseif (is_array($include)) foreach($include as $inc) include_once $inc;
				}
			}
			ob_end_clean();

			$instruction = "{$method['name']}(";

			$i = 0;
			foreach ($method['params'] as $p) {
				$instruction .= $i++ > 0?", ":"";
				if (isset($_POST[$p])){
					$instruction .= '$_POST["' . $p . '"]';
				}
				else{
					$instruction .= "null";
				}
			}
			$instruction .= ");";
			eval('$result = ' . $instruction);
		}

		// Execute hook after
		if (function_exists("phpHotMap_after")){
			phpHotMap_after($method);
		}

		echo json_encode($result);
	}

	/**
	 * Login, logout, publish methods or execute a method
	 *
	 * @return boolean
	 */
	public function go() {

		// Client need login?
		if (isset($_GET['login'])){
			if (isset($_GET['password'])){
				$r = phpHotMap::login($_GET['login'],$_GET['password']);
				$r = $r === true? PHP_HOT_MAP_LOGIN_SUCCESSFUL: PHP_HOT_MAP_LOGIN_FAILED;
				echo $r;
				return $r;
			}
		}

		// Client need logout?
		if (isset($_GET['logout'])){
			phpHotMap::logout();
			return PHP_HOT_MAP_LOGOUT_SUCCESSFUL;
		}

		// Client need execute a specific method?
		if (isset($_GET['execute'])){
			$method = $_GET['execute'];

			if (!isset($this->methods[$method])){
				return PHP_HOT_MAP_METHOD_NOT_EXISTS;
			}

			// Check host
			$ip = phpHotMap::getClientIPAddress();
			$hosts = $this->methods[$method]['hosts'];

			foreach($hosts as $host){
				$from = $host['from'];
				$to = $hots['to'];
				$v = phpHotMap::checkRangeIP($from,$to,$ip);
				if ($v === false){
					echo "PHP_HOT_MAP_ACCESS_DENIED_HOST";
					return PHP_HOT_MAP_ACCESS_DENIED_HOST;
				}
			}

			$namespace ='';
			if (isset($this->methods[$method]['namespace'])) $namespace = $this->methods[$method]['namespace'];

			$r = phpHotMap::checkMethodAccess($method, $namespace);

			/*
			 a     b     !a || b
			-------------------
			t     t        t
			t     f        f
			f     f        t
			f     t        t
			*/

			if (!$this->methods[$method]['security'] || $r){
				$this->execute($method);
				return PHP_HOT_MAP_METHOD_EXECUTED;
			}
			echo "PHP_HOT_MAP_ACCESS_DENIED_USER";
			return PHP_HOT_MAP_ACCESS_DENIED_USER;
		}

		// Then client need publish!

		$this->publish();
		return PHP_HOT_MAP_METHOD_EXECUTED;
	}

}