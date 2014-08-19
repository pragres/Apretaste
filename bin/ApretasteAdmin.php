<?php
/**
 * Apretaste administration page
 *
 * @author rafa
 *        
 */
class ApretasteAdmin {
	static $login_result = true;
	
	/**
	 * Verify the user login
	 * @return boolean
	 */
	static function verifyLogin(){
		if (! isset($_SESSION['user']))
			return false;
		return true;
	}
	
	/**
	 * Return information of current admin
	 *
	 * @return array/boolean
	 */
	static function getUser(){
		if (isset($_SESSION['user'])) {
			$u = $_SESSION['user'];
			$r = Apretaste::query("SELECT * FROM users WHERE user_login='$u';");
			if (isset($r[0])) {
				$k = Apretaste::query("SELECT * FROM users_perms WHERE user_role ='{$r[0]['user_role']}';");
				
				$k = $k[0];
				if ($r[0]['user_role'] == 'admin' || $r[0]['user_role'] == 'administrator') {
					$dir = scandir("../admin/");
					$s = implode(" ", $dir);
					$s = str_replace(".php", "", $s);
					$s = str_replace(".", "", $s);
					$s = trim($s);
					$k['access_to'] = $s;
				}
				
				$k['access_to'] = explode(" ", trim(strtolower($k['access_to'])));
				
				foreach ( $k['access_to'] as $key => $value ) {
					$k['access_to'][trim($value)] = true;
				}
				$r[0]['perms'] = $k;
				
				$p = Apretaste::getAuthor($r[0]['email'], true, 50);
				//var_dump($p);
				$p = array_merge($p, $r[0]);
				
				return $p;
			}
		}
		return false;
	}
	static function saveUserAction(){
		$u = self::getUser();
		if ($u !== false) {
			
			$get = json_encode($_GET);
			$post = json_encode($_POST);
			
			$get = str_replace("'", "''", $get);
			$post = str_replace("'", "''", $post);
			/*
			 * $get = str_replace('"', '\"', $get); $post = str_replace('"', '\"', $post);
			 */
			
			$sql = "INSERT INTO users_actions (user_login, get, post) 
		VALUES ('{$u['user_login']}','" . $get . "','" . $post . "');";
			Apretaste::query($sql);
		}
	}
	
	/**
	 * Run the app
	 *
	 * @return boolean
	 */
	static function Run(){
		Apretaste::connect();
		div::enableSystemVar("div.session");
		if (isset($_GET['page'])) {
			$url = $_GET['page'];
			
			if (! self::verifyLogin() && $url != 'auth') {
				header("Location: index.php?path=admin");
			}
			
			$user = self::getUser();
			if ($user['user_role'] == 'investor' && $url != 'logout') {
				$url = 'dashboard';
			}
			
			self::saveUserAction();
			
			if (file_exists("../admin/$url.php")) {
				
				if ($url != 'auth' && $url != 'logout')
					if (! ApretasteAdmin::verifyLogin())
						die('Access denied');
				
				$data = array();
				
				$data['user'] = ApretasteAdmin::getUser();
				
				include "../admin/$url.php";
				
				$tpl = "../tpl/admin/{$url}.tpl";
				
				if (! self::checkAccess($url))
					die('Access denied');
				
				if (! file_exists($tpl))
					$tpl = 'auth';
				
				echo new div($tpl, $data);
			} else
				eval('self::page_' . $url . '();');
		} elseif (isset($_GET['chart'])) {
			
			$url = $_GET['chart'];
			
			if (! self::verifyLogin() && $url != 'auth') {
				header("Location: index.php?path=admin");
			}
			
			include "../charts/$url.img.php";
		} else {
			if (self::verifyLogin()) {
				header("Location: index.php?path=admin&page=" . self::getDefaultPage());
				// echo new div("../tpl/admin/index");
			} else
				echo new div("../tpl/admin/auth", array(
						"error" => ! self::$login_result,
						"user" => self::getUser()
				));
		}
	}
	
	/**
	 * Check access to the page
	 *
	 * @param string $page
	 * @return boolean
	 */
	static public function checkAccess($page){
		Apretaste::connect();
		
		$user = self::getUser();
		
		if ($user['user_role'] == 'admin' || $user['user_role'] == 'administrator')
			return true;
		
		$r = Apretaste::query("SELECT access_to FROM users_perms WHERE user_role ='{$user['user_role']}';");
		
		if (isset($r[0])) {
			$perms = $r[0]['access_to'];
			$perms = trim(strtolower($perms));
			$perms = explode(" ", $perms);
			foreach ( $perms as $perm ) {
				if (trim($perm) == $page)
					return true;
			}
		}
		
		return false;
	}
	static public function getDefaultPage(){
		Apretaste::connect();
		
		$user = self::getUser();
		
		$r = Apretaste::query("SELECT default_page FROM users_perms WHERE user_role ='{$user['user_role']}';");
		
		if (isset($r[0]))
			return $r[0]['default_page'];
		
		return 'dashboard';
	}
	
	/**
	 * Return a agency's customer
	 *
	 * @param string $id
	 * @return array
	 */
	static public function getAgencyCustomer($id){
		Apretaste::connect();
		
		$customer = array();
		
		$r = Apretaste::query("SELECT id, full_name, to_char(date_registered, 'DD/MM/YYYY HH12:MI PM') as date_registered, email, phone FROM agency_customer WHERE id = '$id';");
		
		if (! isset($r[0]))
			return false;
		
		$customer = $r[0];
		
		$r = Apretaste::query("SELECT email FROM agency_recharge WHERE customer = '{$customer['id']}' group by email;");
		
		$arr = array();
		
		if (is_array($r))
			foreach ( $r as $row ) {
				$a = Apretaste::getAuthor($row['email']);
				if (isset($a['picture']))
					if ($a['picture'] != '')
						$a['picture'] = Apretaste::resizeImage($a['picture'], 50);
				$a['credit'] = ApretasteMoney::getCreditOf($row['email']);
				$arr[] = $a;
			}
		
		$customer['contacts'] = $arr;
		
		$profile = Apretaste::getAuthor($customer['email']);
		
		if (isset($profile['picture']))
			if ($profile['picture'] != '')
				$profile['picture'] = Apretaste::resizeImage($profile['picture'], 100);
		
		$customer = array_merge($profile, $customer);
		
		return $customer;
	}
	static function getAgencies(){
		return q("SELECT * FROM agency");
	}
}
