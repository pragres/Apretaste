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
	static function getUser(){
		if (isset($_SESSION['user'])) {
			$u = $_SESSION['user'];
			$r = Apretaste::query("SELECT * FROM users WHERE user_login='$u';");
			if (isset($r[0]))
				return $r[0];
		}
		return false;
	}
	
	/**
	 * Run the app
	 *
	 * @return boolean
	 */
	static function Run(){
		Apretaste::connect();
		
		if (isset($_GET['page'])) {
			$url = $_GET['page'];
			
			if (! self::verifyLogin() && $url != 'auth') {
				header("Location: index.php?path=admin");
			}
			
			$user = self::getUser();
			if ($user['user_role'] == 'investor' && $url != 'logout') {
				$url = 'dashboard';
			}
			
			eval('self::page_' . $url . '();');
		} elseif (isset($_GET['chart'])) {
			
			$url = $_GET['chart'];
			
			if (! self::verifyLogin() && $url != 'auth') {
				header("Location: index.php?path=admin");
			}
			
			include "../charts/$url.img.php";
		} else {
			if (self::verifyLogin()) {
				header("Location: index.php?path=admin&page=dashboard");
				// echo new div("../tpl/admin/index");
			} else
				echo new div("../tpl/admin/auth", array(
						"error" => ! self::$login_result,
						"user" => self::getUser()
				));
		}
	}
	
	// Pages
	static function page_hour_activity(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$date = $_GET['date'];
		$hour = $_GET['hour'];
		
		$data = array();
		$data['date'] = $date;
		$data['hour'] = $hour;
		$data['user'] = self::getUser();
		
		$sql = "SELECT id,moment, extract_email(author) as author, command, extra_data, 
		(select count(*) from answer where message.id=answer.message) as answers,
		(select send_date from answer where message.id=answer.message limit 1) as answer_date,
		(select extract_email(sender) from answer where message.id=answer.message limit 1) as answer_sender,
		(select subject from answer where message.id=answer.message limit 1) as answer_subject,
		(select type from answer where message.id=answer.message limit 1) as answer_type
		FROM message WHERE moment::date = '$date' and extract(hour from moment) = $hour;";
		
		$data['messages'] = Apretaste::query($sql);
		
		if (is_array($data['messages']))
			foreach ( $data['messages'] as $k => $v ) {
				$e = unserialize($v['extra_data']);
				$data['messages'][$k]['subject'] = $e['headers']->subject;
			}
		
		$sql = "SELECT * FROM answer WHERE send_date::date = '$date' AND extract(hour from send_date) = $hour;";
		
		$data['answers'] = Apretaste::query($sql);
		
		echo new div("../tpl/admin/hour_activity.tpl", $data);
	}
	
	/**
	 * User acivity
	 */
	static function page_user_activity(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$user = false;
		$data = array();
		
		if (isset($_GET['user'])) {
			
			$_GET['user'] = Apretaste::extractEmailAddress($_GET['user']);
			
			$user = array();
			$user['email'] = strtolower($_GET['user']);
			
			// credit
			$user['credit'] = ApretasteMoney::getCreditOf($_GET['user']);
			
			// messages
			$user['messages'] = Apretaste::query("SELECT *,
					(select count(*) from answer where message.id=answer.message) as answers ,
					(select send_date from answer where message.id=answer.message limit 1) as answer_date,
					(select extract_email(sender) from answer where message.id=answer.message limit 1) as answer_sender,
					(select subject from answer where message.id=answer.message limit 1) as answer_subject,
					(select type from answer where message.id=answer.message limit 1) as answer_type
					FROM message WHERE extract_email(author) = '{$user['email']}' order by moment desc limit 20;");
			
			if (is_array($user['messages']))
				foreach ( $user['messages'] as $k => $v ) {
					$e = @unserialize($v['extra_data']);
					if (isset($e['headers']->subject))
						$user['messages'][$k]['subject'] = $e['headers']->subject;
				}
				
				// ads
			
			$user['ads'] = Apretaste::query("SELECT * FROM announcement WHERE extract_email(author) = '{$_GET['user']}';");
			
			// subscribes
			$user['subscribes'] = Apretaste::getSubscribesOf($_GET['user']);
			
			// answers
			$user['answers'] = Apretaste::query("SELECT * FROM answer WHERE extract_email(receiver) = '{$_GET['user']}' order by send_date desc limit 20;");
		}
		
		$data['client'] = $user;
		$data['user'] = self::getUser();
		echo new div("../tpl/admin/user_activity.tpl", $data);
	}
	static function page_message(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$id = $_GET['id'];
		
		$data = array();
		$data['user'] = self::getUser();
		$data['message'] = Apretaste::query("SELECT * FROM message WHERE id = '$id';");
		$data['message'] = $data['message'][0];
		$headers = unserialize($data['message']['extra_data']);
		$headers = get_object_vars($headers['headers']);
		
		foreach ( $headers as $h => $v ) {
			if (is_scalar($v))
				$data['message']['header-' . $h] = "$v";
			else
				$data['message']['header-' . $h] = json_encode($v);
		}
		
		$headers = unserialize($data['message']['extra_data']);
		
		unset($headers['headers']);
		
		foreach ( $headers as $h => $v ) {
			
			if (is_scalar($v))
				$data['message'][$h] = "$v";
			else
				$data['message'][$h] = json_encode($v);
		}
		
		unset($data['message']['extra_data']);
		
		echo new div("../tpl/admin/message.tpl", $data);
	}
	static function page_admin(){
		self::page_home();
	}
	/**
	 * Home page
	 */
	static function page_home(){
		if (! self::verifyLogin())
			die('Access denied');
		
		self::page_dashboard();
	}
	
	/**
	 * Accusations page
	 */
	static function page_accusations(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['msg-type'] = 'msg-ok';
		
		if (isset($_POST['delete'])) {
			$id = $_POST['delete'];
			Apretaste::query("DELETE FROM accusation WHERE id = '$id';");
			$data['msg'] = "Accusation was been deleted";
		}
		
		if (isset($_POST['proccess'])) {
			$id = $_POST['proccess'];
			Apretaste::query("UPDATE accusation SET proccessed = true WHERE id = '$id';");
			$data['msg'] = "Accusation was been proccessed";
		}
		
		$data['accusations'] = Apretaste::query("SELECT id, fa::date, announcement, author, get_ad_title(announcement) as title, reason, get_ad_author(announcement) as accused FROM accusation where proccessed = false order by fa;");
		$data['user'] = self::getUser();
		
		echo new div("../tpl/admin/accusations.tpl", $data);
	}
	
	/**
	 * Authentication page
	 */
	static function page_auth(){
		$user = post('user');
		$pass = post('pass');
		$login = post('login');
		$user = pg_escape_string($user);
		
		$procede = true;
		
		self::$login_result = false;
		
		if ($procede) {
			if (! is_null($login)) {
				$u = Apretaste::query("SELECT * FROM users WHERE user_login = '$user';");
				if (isset($u[0])) {
					$u = $u[0];
					if ($u['user_pass'] == md5($pass)) {
						$_SESSION['user'] = $u['user_login'];
						self::$login_result = true;
					}
				}
			}
		}
		
		if (self::$login_result)
			header("Location: index.php?path=admin&page=admin");
		else
			header("Location: index.php?path=admin");
	}
	
	/**
	 * Configuration page
	 */
	static function page_config(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['msg-type'] = "msg-ok";
		
		// Proccess options
		if (isset($_GET['o'])) {
			switch ($_GET['o']) {
				case "del_kw_bl" :
					
					$kw = $_GET['data'];
					Apretaste::query("update word set black = false where word = '$kw';");
					$data['msg'] = "Deleted the black keyword $kw";
					break;
				case "del_whitelist" :
					Apretaste::delWhiteList($_GET['data']);
					break;
				case "del_blacklist" :
					Apretaste::delBlackList($_GET['data']);
					break;
			}
		}
		
		// Proccess posts
		if (isset($_POST['btnAddBlackKeyword'])) {
			$kw = $_POST['edtNewBlackKeyword'];
			if (trim($kw) != "") {
				$data['msg'] = "Added the black keyword $kw";
				Apretaste::query("update word set black = true where word = '$kw';");
			} else {
				$data['msg'] = "Please enter a valid black keyword";
				$data['msg-type'] = "msg-error";
			}
		}
		
		if (isset($_POST['btnAddWhiteList'])) {
			Apretaste::addWhiteList($_POST['edtNewWhiteList']);
			$data['msg'] = "Email address has been saved to whitelist";
		}
		
		if (isset($_POST['btnAddBlackList'])) {
			Apretaste::addBlackList($_POST['edtNewBlackList']);
			$data['msg'] = "Email address has been saved to blacklist";
		}
		
		if (isset($_POST['btnUpdateConfig'])) {
			Apretaste::setConfiguration("price_regexp", $_POST['edtPriceRegExp']);
			Apretaste::setConfiguration("phones_regexp", $_POST['edtPhonesRegExp']);
			Apretaste::setConfiguration("enable_history", isset($_POST['chkEnableHistorial']));
			Apretaste::setConfiguration("outbox.max", intval($_POST['edtOutboxmax']));
			Apretaste::setConfiguration("sms_free", isset($_POST['chkSmsFree']));
			$data['msg'] = "The configuration was been saved";
		}
		
		$data['chkEnableHistorial'] = Apretaste::getConfiguration("enable_history");
		$data['chkSmsFree'] = Apretaste::getConfiguration("sms_free");
		$data['edtPriceRegExp'] = Apretaste::getConfiguration("price_regexp");
		$data['edtPhonesRegExp'] = Apretaste::getConfiguration("phones_regexp");
		$data['edtOutboxmax'] = Apretaste::getConfiguration("outbox.max");
		
		// Load data
		$data['kwblacklist'] = Apretaste::getBlackWords();
		$data['whitelist'] = Apretaste::getEmailWhiteList();
		$data['blacklist'] = Apretaste::getEmailBlackList();
		
		$data['user'] = self::getUser();
		// Show page
		echo new div("../tpl/admin/config", $data);
	}
	
	/**
	 * Dictionary page
	 */
	static function page_dictionary(){
		if (! self::verifyLogin())
			die('Access denied');
		
		Apretaste::connect();
		
		$data = array();
		$data['msg-type'] = "msg-ok";
		
		if (isset($_POST['btnAdd'])) {
			$word = $_POST['word'];
			$sym = $_POST['synonym'];
			$word = str_replace("'", "''", $word);
			$sym = str_replace("'", "''", $sym);
			
			$r = Apretaste::query("SELECT * FROM synonym WHERE (word = '$word' AND synonym = '$sym') OR (word = '$sym' AND synonym = '$word');");
			
			if (! $r or ! isset($r[0])) {
				Apretaste::query("INSERT INTO synonym (word,synonym) values('$word','$sym');");
				$data['msg'] = "The synonym of '" . $word . "' was inserted";
			} else {
				$data['msg'] = "The '" . $word . "' synonym already exists.";
				$data['msg-type'] = "msg-error";
			}
		}
		
		if (isset($_POST['delete'])) {
			Apretaste::query("DELETE FROM synonym WHERE id = '{$_POST['delete']}';");
			$data['msg'] = "The synonym was deleted";
		}
		
		$data['synonyms'] = Apretaste::query("SELECT * from synonym;");
		
		$data['user'] = self::getUser();
		
		echo new div("../tpl/admin/synonyms", $data);
	}
	
	/**
	 * Logout page
	 */
	static function page_logout(){
		if (isset($_SESSION['user']))
			unset($_SESSION['user']);
		
		header("Location: index.php?path=admin");
	}
	
	/**
	 * Statistics page
	 */
	static function page_dashboard(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['user'] = self::getUser();
		$current_year = intval(date("Y"));
		$current_month = intval(date("m"));
		
		// subscribes
		
		$r = Apretaste::query("select count(*) as cant from subscribe;");
		
		$data['subscribes_count'] = $r[0]['cant'];
		
		// messages metrics
		$data['total_internal'] = ApretasteAnalitics::getTotalInternalActiveAds();
		$data['total_external'] = ApretasteAnalitics::getTotalExternalActiveAds();
		$data['total_messages'] = ApretasteAnalitics::getTotalOfMessages();
		$data['historial_internal'] = ApretasteAnalitics::getHistoricalInternalAds();
		$data['historial_external'] = ApretasteAnalitics::getHistoricalExternalAds();
		$data['total_visits'] = ApretasteAnalitics::getTotalOfVisits();
		$data['email_servers'] = ApretasteAnalitics::getEmailServers(20);
		
		$r = ApretasteAnalitics::getMessagesByCommand(null, false);
		
		$msg_by_command = array();
		foreach ( $r as $x ) {
			if (! isset($msg_by_command[$x['command']])) {
				$msg_by_command[$x['command']] = array();
				for($i = 1; $i <= 12; $i ++)
					$msg_by_command[$x['command']][$i] = 0;
			}
			$msg_by_command[$x['command']][$x['mes']] = $x['cant'];
		}
		
		$data['msg_by_command'] = $msg_by_command;
		
		// $data['popular_phrases'] = ApretasteAnalitics::getPopularPhrases(10);
		// $data['popular_terms'] = ApretasteAnalitics::getPopularKeywords(10);
		
		$r = Apretaste::query("SELECT min(moment)::date as first_day, max(moment)::date as last_day,  extract(days from max(moment) - min(moment)) as difference FROM message;");
		
		$data['first_day'] = $r[0]['first_day'];
		$data['last_day'] = $r[0]['last_day'];
		$data['days_online'] = $r[0]['difference'];
		
		$data['messages_by_day'] = 0;
		$data['messages_by_week'] = 0;
		$data['messages_by_hour'] = 0;
		$data['messages_by_minute'] = 0;
		
		if ($data['days_online'] > 0) {
			$data['messages_by_day'] = number_format($data['total_messages'] / $data['days_online'], 2);
			$data['messages_by_week'] = number_format($data['messages_by_day'] * 7, 2);
			$data['messages_by_hour'] = number_format($data['messages_by_day'] / 24, 2);
			$data['messages_by_minute'] = number_format($data['messages_by_hour'] / 60, 2);
		}
		
		// New users
		$newusers = array();
		
		for($year = $current_year - 1; $year <= $current_year; $year ++) {
			$newusers[$year] = array();
			for($month = 1; $month <= 12; $month ++) {
				$newusers[$year][$month] = ApretasteAnalitics::getCountOfNewUsers($year, $month);
			}
		}
		
		$data['newusers'] = $newusers;
		
		// Access by month
		$access_by_month = array();
		
		for($year = $current_year - 1; $year <= $current_year; $year ++) {
			$access_by_month[$year] = array();
			for($month = 1; $month <= 12; $month ++) {
				$access_by_month[$year][$month] = 0;
			}
		}
		
		$r = ApretasteAnalitics::getAccesByMonth();
		
		foreach ( $r as $x ) {
			$access_by_month[$x['ano']][$x['mes']] = $x['total'];
		}
		
		$data['access_by_month'] = $access_by_month;
		
		// Access by day
		$atm = ApretasteAnalitics::getAccessIn($current_year, $current_month);
		
		$atmx = array();
		$last_day = 0;
		if (is_array($atm))
			foreach ( $atm as $atmy ) {
				$atmx[$atmy['day']] = $atmy;
				$last_day = $atmy['day'];
			}
		
		for($i = 1; $i <= $last_day; $i ++) {
			if (! isset($atmx[$i]))
				$atmx[$i] = 0;
		}
		
		$data['access_this_month'] = $atm;
		
		// Access by hour
		$lastdays = 20;
		
		$access_by_hour = array();
		
		for($i = 0; $i <= 23; $i ++) {
			$access_by_hour[$i] = array();
			for($j = 1; $j <= $lastdays; $j ++)
				$access_by_hour[$i][$j] = 0;
		}
		
		$r = ApretasteAnalitics::getAccessByHour($lastdays);
		
		foreach ( $r as $rx ) {
			$access_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
		}
		$sql = "
			SELECT 
				q::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
				q::date as date,
				extract(day from q) as dia, 
				extract(dow from q) as wdia 
			FROM generate_series(current_date - " . ($lastdays - 1) . ", current_date, '1 day') as q;";
		
		$r = Apretaste::query($sql);
		
		$wdias = array(
				'Su',
				'Mo',
				'Tu',
				'We',
				'Tr',
				'Fr',
				'Sa'
		);
		
		foreach ( $r as $row ) {
			$ah[$row['orden']] = $row;
			$ah[$row['orden']]['wdia'] = $wdias[$ah[$row['orden']]['wdia']];
		}
		
		$data['access_by_hour'] = $access_by_hour;
		
		// Answer by hour
		
		$answer_by_hour = array();
		
		for($i = 0; $i <= 23; $i ++) {
			$answer_by_hour[$i] = array();
			for($j = 1; $j <= $lastdays; $j ++)
				$answer_by_hour[$i][$j] = 0;
		}
		
		$r = ApretasteAnalitics::getAnswerByHour($lastdays);
		
		foreach ( $r as $rx ) {
			$answer_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
		}
		
		$sql = "
		SELECT
			q::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
			extract(day from q) as dia,
				extract(dow from q) as wdia
			FROM generate_series(current_date - " . ($lastdays - 1) . ", current_date, '1 day') as q;";
		
		$r = Apretaste::query($sql);
		
		$wdias = array(
				'Su',
				'Mo',
				'Tu',
				'We',
				'Tr',
				'Fr',
				'Sa'
		);
		
		foreach ( $r as $row ) {
			$ans[$row['orden']] = $row;
			$ans[$row['orden']]['wdia'] = $wdias[$ans[$row['orden']]['wdia']];
		}
		
		$data['answer_by_hour'] = $answer_by_hour;
		
		$data['ah'] = $ah;
		$data['ans'] = $ah;
		$data['lastdays'] = $lastdays;
		
		// Best users
		$data['best_users'] = array();
		
		$r = ApretasteAnalitics::getBestUsers();
		
		$data['best_users'] = $r;
		
		// Last message
		$r = Apretaste::query("SELECT * FROM message WHERE moment = (SELECT max(moment) FROM message);");
		$r = $r[0];
		
		$r['extra_data'] = @unserialize($r['extra_data']);
		$r['author'] = str_replace("From: ", "", iconv_mime_decode("From: {$r['author']}", ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "ISO-8859-1"));
		$r['author'] = htmlentities($r['author']);
		$r['author_email'] = Apretaste::extractEmailAddress($r['author']);
		
		$data['last_msg'] = $r;
		
		// Last messages
		$r = Apretaste::query("SELECT * FROM message order by moment desc limit 20;");
		foreach ( $r as $k => $v ) {
			$r[$k]['author'] = str_replace("From: ", "", iconv_mime_decode("From: {$r[$k]['author']}", ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "ISO-8859-1"));
			$r[$k]['author'] = htmlentities($r[$k]['author']);
			$r[$k]['author_email'] = Apretaste::extractEmailAddress($r[$k]['author']);
		}
		$data['last_msgs'] = $r;
		
		// Linker
		$r = Apretaste::query("SELECT extract(month from send_date::date) as mes, count(*) as total FROM linker WHERE extract(year from send_date::date) = extract(year from current_date) group by mes;");
		
		$data['linker'] = array();
		for($i = 0; $i < 12; $i ++)
			$data['linker'][] = array(
					'mes' => $i + 1,
					'total' => 0
			);
		
		if (is_array($r))
			foreach ( $r as $v )
				$data['linker'][$v['mes'] - 1] = array(
						'mes' => $v['mes'],
						'total' => $v['total']
				);
			
			// Nanotitles
		$r = Apretaste::query("SELECT w1 || ' ' || w2 || ' ' ||  w3 || ' ' || w4  as nanotitle, popularity
		from nanotitles 
		where levels > 2
		order by popularity desc limit 20");
		
		$data['nanotitles'] = $r;
		
		// engagement and bounce
		
		$r = ApretasteAnalitics::getEngagementAndBounce();
		
		$engagement = array();
		
		for($j = $current_year - 1; $j <= $current_year; $j ++) {
			$engagement[$j] = array();
			for($i = 1; $i <= 12; $i ++) {
				$engagement[$j][$i] = array(
						"total" => 0,
						"engagement" => 0,
						"engagement_percent" => 0,
						"bounce_rate" => 0,
						"bounce_rate_percent" => 0
				);
			}
		}
		
		foreach ( $r as $row ) {
			$engagement[$row['year']][$row['month']] = $row;
		}
		
		$data['engagement'] = $engagement;
		$data['current_year'] = $current_year;
		$data['current_month'] = $current_month;
		
		// Sources of traffic
		$data['sources_of_traffic'] = ApretasteAnalitics::getBestUsers(true);
		
		/*
		 * $r = Apretaste::query("SELECT servidor,mes,cant FROM source_of_traffic WHERE ano = extract(year from current_date);"); foreach ( $r as $x ) { if (! isset($data['sources_of_traffic'][$x['servidor']])) { $data['sources_of_traffic'][$x['servidor']] = array(); for($i = 1; $i <= 12; $i ++) $data['sources_of_traffic'][$x['servidor']][$i] = 0; } $data['sources_of_traffic'][$x['servidor']][$x['mes']] = $x['cant']; }
		 */
		$data['user'] = self::getUser();
		
		// Popular phrases
		$data['popular_phrases'] = ApretasteAnalitics::getPopularPhrases(20, null, null, true);
		
		// Total users
		$r = Apretaste::query("SELECT count(*) as total from (SELECT extract_email(author) as xauthor FROM message GROUP by xauthor) as subq;");
		
		$data['total_users'] = $r[0]['total'];
		
		echo new div("../tpl/admin/dashboard", $data);
	}
	
	/**
	 * Tips page
	 */
	static function page_tips(){
		if (! self::verifyLogin())
			die('Access denied');
		
		Apretaste::connect();
		
		$data = array();
		$data['msg-type'] = "msg-ok";
		
		if (isset($_POST['btnAddTip'])) {
			$tip = $_POST['tipText'];
			$tip = str_replace("'", "''", $tip);
			Apretaste::query("INSERT INTO tip (tip) values('$tip');");
			$data['msg'] = "The tip '" . substr($tip, 0, 30) . "' was inserted";
		}
		
		if (isset($_POST['delete'])) {
			Apretaste::query("DELETE FROM tip WHERE id = '{$_POST['delete']}';");
			$data['msg'] = "The tip was deleted";
		}
		
		$data['tips'] = Apretaste::query("SELECT * from tip;");
		$data['user'] = self::getUser();
		echo new div("../tpl/admin/tips", $data);
	}
	
	/**
	 * Users page
	 */
	static function page_users(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['msg-type'] = "msg-ok";
		
		$submit = post('btnAddUser');
		
		if (! is_null($submit)) {
			$login = post('user_login');
			$pass = post('user_pass');
			$role = post('user_role');
			
			Apretaste::query("INSERT INTO users (user_login,user_pass, user_role) VALUES ('$login',md5('$pass'),'$role');");
			
			// $user = new UsersEntity(array("user_login" => $login, "user_pass" => $pass));
			$data['msg'] = "The user $login was inserted successfull.";
		}
		
		$delete = get('delete');
		
		if (! is_null($delete)) {
			Apretaste::query("DELETE FROM users WHERE user_login='$delete';");
			$data['msg'] = "The user $delete was deleted successfull.";
		}
		
		$users = Apretaste::query("SELECT * FROM users;");
		$data['users'] = $users;
		$data['user'] = self::getUser();
		echo new div("../tpl/admin/users", $data);
	}
	static function page_address_list(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$nourish = get('nourish');
		if (! is_null($nourish)) {
			Apretaste::nourishAddressList();
			header("Location: index.php?path=admin&page=address_list");
			exit();
		}
		$submit = post('btnAdd');
		
		$download = post('btnDownload');
		$download1 = get('download');
		
		$filter = get('filter');
		if (! is_null($download) || ! is_null($download1)) {
			$file_name = 'apretaste-addresses-' . str_replace(array(
					'@',
					'.'
			), '-', $filter) . '-' . date("Ymdhis") . ".txt";
			
			$file_name = str_replace("--", "-", $file_name);
			
			$sql = "SELECT email FROM address_list " . (is_null($filter) ? "" : "WHERE matchEmail(email,'$filter') OR matchEmail(source,'$filter')");
			
			$list = Apretaste::query($sql);
			
			$listtext = '';
			if (is_array($list))
				foreach ( $list as $l ) {
					$listtext .= $l['email'] . "\r\n";
				}
			
			$headers = array(
					'Content-type: force-download',
					'Content-disposition: attachment; filename="' . $file_name . '"',
					'Content-Type: text/plain; name="' . $file_name . '"',
					'Content-Transfer-Encoding: binary',
					'Pragma: no-cache',
					'Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
					'Expires: 0',
					'Accept-Ranges: bytes'
			);
			
			foreach ( $headers as $h )
				header($h);
			
			echo $listtext;
			exit();
		}
		
		$data = array();
		
		if (! is_null($submit)) {
			$address = post('address');
			$source = 'apretaste.admin';
			$address = Apretaste::addToAddressList($address, $source);
			$data['msg-type'] = 'msg-ok';
			$data['msg'] = 'The address was inserted';
			$data['addinserted'] = $address;
		}
		
		$data['user'] = self::getUser();
		
		$r = Apretaste::query("SELECT count(*) as total from address_list");
		$data['total_address'] = $r[0]['total'];
		
		$data['providers'] = Apretaste::query("Select provider, total, case when provider ~* '.cu' then 1 else 0 end as national from (
		SELECT get_email_domain(email) as provider, count(*) as total 
		from address_list group by provider order by total desc) as subq;");
		
		echo new div("../tpl/admin/address_list", $data);
	}
	
	/**
	 * Admin page for manage subscribes
	 */
	static function page_subscribes(){
		if (! self::verifyLogin())
			die('Access denied');
		
		Apretaste::cleanSubscribes();
		
		$data = array();
		$data['user'] = self::getUser();
		
		$data['subscribes'] = Apretaste::query("SELECT id,email,phrase,fa::date as moment,last_alert::date as last_alert FROM subscribe order by email,phrase;");
		
		echo new div("../tpl/admin/subscribes", $data);
	}
	static function page_mailboxes(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		
		if (isset($_POST['btnAdd'])) {
			$mailbox = $_POST['mailbox'];
			ApretasteMailboxes::createMailbox($mailbox);
		}
		
		if (isset($_POST['btnAddPattern'])) {
			$from = $_POST['from_pattern'];
			$to = $_POST['to_pattern'];
			ApretasteMailboxes::addRestriction($from, $to);
		}
		
		if (isset($_GET['del_rest'])) {
			ApretasteMailboxes::deleteRestriction($_GET['del_rest']);
		}
		
		if (isset($_GET['delete'])) {
			ApretasteMailboxes::deleteMailBox($_GET['delete']);
		}
		
		$data['mbuse'] = Apretaste::query("select mailboxes.mailbox as servidor, 
		count(*) as cant
		from message inner join mailboxes on
		lower(extract_email(addressee)) ~* mailboxes.mailbox 
		group by servidor
		order by cant desc;");
		
		$data['restrictions'] = ApretasteMailboxes::getRestrictions();
		$data['mailboxes'] = ApretasteMailboxes::getMailBoxes();
		$data['user'] = self::getUser();
		echo new div("../tpl/admin/mailboxes.tpl", $data);
	}
	static function page_sms(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['user'] = self::getUser();
		$data['lastdays'] = 20;
		
		// National
		$lastdays = 20;
		
		$access_by_hour = array();
		
		for($i = 0; $i <= 23; $i ++) {
			$access_by_hour[$i] = array();
			for($j = 1; $j <= $lastdays; $j ++)
				$access_by_hour[$i][$j] = 0;
		}
		
		$r = ApretasteAnalitics::getSMSByHour($lastdays);
		
		if (is_array($r))
			foreach ( $r as $rx ) {
				$access_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
			}
		
		$sql = "
		SELECT
		q::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
		q::date as date,
				extract(day from q) as dia,
				extract(dow from q) as wdia
			FROM generate_series(current_date - " . ($lastdays - 1) . ", current_date, '1 day') as q;";
		
		$r = Apretaste::query($sql);
		
		$wdias = array(
				'Su',
				'Mo',
				'Tu',
				'We',
				'Tr',
				'Fr',
				'Sa'
		);
		
		$ah = array();
		
		foreach ( $r as $row ) {
			$ah[$row['orden']] = $row;
			$ah[$row['orden']]['wdia'] = $wdias[$ah[$row['orden']]['wdia']];
		}
		
		$data['access_by_hour'] = $access_by_hour;
		$data['ah'] = $ah;
		
		// International
		$answer_by_hour = array();
		
		for($i = 0; $i <= 23; $i ++) {
			$answer_by_hour[$i] = array();
			for($j = 1; $j <= $lastdays; $j ++)
				$answer_by_hour[$i][$j] = 0;
		}
		
		$r = ApretasteAnalitics::getSMSByHour($lastdays, false);
		
		if (is_array($r))
			foreach ( $r as $rx ) {
				$answer_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
			}
		
		$sql = "
		SELECT
		q::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
		extract(day from q) as dia,
				extract(dow from q) as wdia
			FROM generate_series(current_date - " . ($lastdays - 1) . ", current_date, '1 day') as q;";
		
		$r = Apretaste::query($sql);
		
		$wdias = array(
				'Su',
				'Mo',
				'Tu',
				'We',
				'Tr',
				'Fr',
				'Sa'
		);
		
		foreach ( $r as $row ) {
			$ans[$row['orden']] = $row;
			$ans[$row['orden']]['wdia'] = $wdias[$ans[$row['orden']]['wdia']];
		}
		
		$data['answer_by_hour'] = $answer_by_hour;
		
		$data['ah'] = $ah;
		$data['ans'] = $ah;
		$data['lastdays'] = $lastdays;
		
		$data['servers'] = Apretaste::query("
		select get_email_domain(extract_email(author)) as servidor, count(*) as cant
		from message
		where command = 'sms'
		group by servidor
		order by cant desc
		limit 20;");
		
		echo new div("../tpl/admin/sms.tpl", $data);
	}
	static function page_ad(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['user'] = self::getUser();
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			
			$data['ad'] = Apretaste::getAnnouncement($id);
			if ($data['ad'] != APRETASTE_ANNOUNCEMENT_NOTFOUND) {
				$data['ad']['image'] = false; // '<img width="200" src="data:' . $data['ad']['image_type'] . ';base64,' . $data['ad']['image'] . '">';
			} else {
				$data['ad'] = false;
				$data['notfound'] = true;
			}
		} else
			$data['ad'] = false;
		
		echo new div("../tpl/admin/ad.tpl", $data);
	}
	static public function page_raffles(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['user'] = self::getUser();
		
		if (isset($_GET['delete'])) {
			$_GET['delete'] = str_replace("'", "''", $_GET['delete']);
			Apretaste::query("DELETE FROM raffles where id = '{$_GET['delete']}';");
		}
		
		if (isset($_GET['addraffle'])) {
			$desc = str_replace("'", "''", $_POST['description']);
			$df = $_POST['date_from'];
			$dt = $_POST['date_to'];
			
			if (trim("{$_FILES['image']['tmp_name']}") != "")
				if (isset($_FILES['image']))
					$image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
			
			Apretaste::query("INSERT INTO raffles (description, date_from, date_to, image)
					VALUES ('$desc', '$df', '$dt', '$image');");
		}
		
		$data['raffles'] = Apretaste::query("SELECT * FROM xraffles");
		
		echo new div("../tpl/admin/raffles.tpl", $data);
	}
	static public function page_dispatchers(){
		if (! self::verifyLogin())
			die('Access denied');
		
		$data = array();
		$data['user'] = self::getUser();
		
		if (isset($_POST['btnAddDispatcher'])) {
			ApretasteMoney::addDispatcher($_POST['edtEmail'], $_POST['edtName'], $_POST['edtContact']);
		}
		
		if (isset($_GET['delete'])) {
			ApretasteMoney::delDispatcher($_GET['delete']);
		}
		
		if (isset($_GET['sales'])) {
			
			$data['email'] = $_GET['sales'];
			
			if (isset($_GET['pdf'])) {
				
				include "../lib/fpdf17/fpdf.php";
				
				$pdf = new ApretastePDF();
				$pdf->addPage('P', 'letter');
				
				$cards = ApretasteMoney::getSaleCards($_GET['pdf']);
				
				$i = 0;
				$x = 0;
				$y = - 55;
				$pdf->AddFont('ErasITC-Bold', '', 'ERASBD.php');
				
				foreach ( $cards as $k => $card ) {
					$i ++;
					
					if ($i % 2 == 0)
						$x = 108;
					else
						$x = 0;
					
					if ($i % 2 != 0)
						$y += 55;
					
					$pdf->Rotate(0);
					$pdf->Image('../tpl/admin/recharge_card.tpl.png', $x, $y, -300);
					
					$pdf->SetFont('ErasITC-Bold', '', 68);
					$pdf->SetTextColor(200, 200, 200);
					
					$pdf->Text(44 + $x, 25 + $y, '$' . $card['amount']);
					
					$pdf->SetFont('ErasITC-Bold', '', 13);
					$pdf->SetTextColor(200, 0, 10);
					
					$pdf->Rotate(90);
					$code = $card['code'];
					$code = substr($code, 0, 4) . '-' . substr($code, 4, 4) . '-' . substr($code, 8, 4);
					$pdf->Text(- 27 - $y, 100 + $x, $code);
					
					if ($i % 10 == 0 && isset($cards[$k + 1])) {
						$pdf->addPage('P', 'letter');
						$x = 0;
						$y = - 55;
					}
				}
				
				$pdf->Output("Apretaste - Recharge's Cards - " . date("Y-m-d h-i-s") . ".pdf", 'D');
				
				return true;
			}
			
			if (isset($_GET['cards'])) {
				
				$data['cards'] = ApretasteMoney::getSaleCards($_GET['cards']);
				$data['sale'] = $_GET['cards'];
				echo new div("../tpl/admin/recharge_cards.tpl", $data);
				return true;
			}
			
			if (isset($_POST['btnAddSale'])) {
				ApretasteMoney::addRechargeCardSale($_GET['sales'], $_POST['edtQuantity'], $_POST['edtSalePrice'], $_POST['edtCardPrice']);
			}
			
			if (isset($_GET['delete'])) {
				ApretasteMoney::delSale($_GET['delete']);
			}
			
			$data['sales'] = ApretasteMoney::getRechargeCardSalesOf($_GET['sales']);
			
			echo new div("../tpl/admin/recharge_card_sales.tpl", $data);
			return true;
		}
		
		$data['dispatchers'] = ApretasteMoney::getDispatchers();
		
		echo new div("../tpl/admin/dispatchers.tpl", $data);
	}
}
