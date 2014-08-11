<?php
class ApretasteAnalitics {
	
	/**
	 * Return the total of internal and active ads
	 *
	 * @return long
	 */
	static function getTotalInternalActiveAds(){
		$r = Apretaste::query("SELECT COUNT(*) as cant FROM announcement where external_id is null;");
		if (isset($r[0]))
			return $r[0]['cant'];
		return 0;
	}
	
	/**
	 * Return the total of external and active ads
	 *
	 * @return long
	 */
	static function getTotalExternalActiveAds(){
		$r = Apretaste::query("SELECT COUNT(*) as cant FROM announcement where not external_id is null;");
		if ($r)
			return intval($r[0]['cant']);
		return 0;
	}
	
	/**
	 * Return the total of messages
	 *
	 * @return long
	 */
	static function getTotalOfMessages(){
		$r = Apretaste::query("SELECT COUNT(*) as cant FROM message;");
		if ($r)
			return intval($r[0]['cant']);
		return 0;
	}
	
	/**
	 * Return the total of historical and internal ads
	 *
	 * @return long
	 */
	static function getHistoricalInternalAds(){
		$r = Apretaste::query("SELECT COUNT(*) as cant FROM historial where external_id is null;");
		if ($r)
			return intval($r[0]['cant']);
		return 0;
	}
	
	/**
	 * Return the total of historical and external ads
	 *
	 * @return long
	 */
	static function getHistoricalExternalAds(){
		$r = Apretaste::query("SELECT COUNT(*) as cant FROM historial where not external_id is null;");
		if ($r)
			return intval($r[0]['cant']);
		return 0;
	}
	
	/**
	 * Return total of ads visits
	 *
	 * @return long
	 */
	static function getTotalOfVisits(){
		$r = Apretaste::query("SELECT count(*) as cant from visit");
		if ($r)
			return intval($r[0]['cant']);
		return 0;
	}
	
	/**
	 * Return a list of access by day
	 *
	 * @return unknown
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getAccessByDay($limit = 20){
		if ($limit == 0)
			$limit = "";
		else
			$limit = "LIMIT $limit";
		$r = Apretaste::query("SELECT * FROM access_by_day $limit;");
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Return a list of ads by day
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getAdsByDay($limit = 30){
		if ($limit == 0)
			$limit = "";
		else
			$limit = "LIMIT $limit";
		$r = Apretaste::query("SELECT post_date::date as dia, COUNT(*) as cant FROM announcement group by dia order by dia asc $limit;");
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Return a list of email servers
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getEmailServers($limit = 10){
		if ($limit == 0)
			$limit = "";
		else
			$limit = "LIMIT $limit";
		
		$r = Apretaste::query("SELECT * FROM email_server_use $limit;");
		
		$rr = Apretaste::query("SELECT sum(cant) as total FROM (select * from email_server_use) as subq;");
		
		$total = $rr[0]['total'];
		
		$rr = Apretaste::query("SELECT sum(cant) as total FROM (select * from email_server_use $limit) as subq;");
		
		$subtotal = $rr[0]['total'];
		
		$r[] = array(
				'servidor' => '[ohters]',
				'cant' => $total - $subtotal
		);
		
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Return a list of helps by day
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getHelpsByDay($limit = 30){
		if ($limit == 0)
			$limit = "";
		else
			$limit = "LIMIT $limit";
		$r = Apretaste::query("SELECT * FROM help_by_day $limit;");
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Return a list of inserts by day
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getInsertsByDay($limit = 30){
		if ($limit == 0)
			$limit = "";
		else
			$limit = "LIMIT $limit";
		$r = Apretaste::query("SELECT * FROM insert_by_day $limit;");
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Return a list of messages by command
	 *
	 * @return mixed
	 */
	static function getMessagesByCommand($year = null, $month = null, $limit = null){
		if (is_null($year))
			$year = intval(date('Y'));
		
		if (is_null($month))
			$month = intval(date('m'));
		
		$sql = "SELECT command, ";
		if ($month === false || $month > 0)
			$sql .= "mes,";
		$sql .= "sum(cant) as cant ";
		
		$sql .= "FROM messages_by_command WHERE ano = $year ";
		$sql .= ($month !== false && $month > 0 ? " AND mes = $month " : "");
		$sql .= " group by command";
		if ($month === false)
			$sql .= ", mes";
		$sql .= " order by cant desc";
		
		$total = 0;
		$subtotal = 0;
		if (! is_null($limit)) {
			
			if ($month !== false) {
				$r = Apretaste::query("SELECT sum(cant) as cant from ($sql) as subq;");
				$total = $r[0]['cant'];
			}
			
			$sql .= " limit $limit";
			if ($month !== false) {
				$r = Apretaste::query("SELECT sum(cant) as cant from ($sql) as subq;");
				$subtotal = $r[0]['cant'];
			}
		}
		
		$r = Apretaste::query($sql);
		
		if ($r) {
			if (! is_null($limit) && $month !== false) {
				$r[] = array(
						'command' => '[others]',
						'cant' => $total - $subtotal
				);
			}
			return $r;
		}
		
		return false;
	}
	
	/**
	 * Return a list of popular keywords
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getPopularKeywords($limit = 10){
		$r = array();
		
		$rr = Apretaste::query("SELECT word, popularity 
				FROM word where black = false order by popularity desc limit $limit");
		
		foreach ( $rr as $row )
			$r[] = array(
					's' => $row['word'],
					'n' => $row['popularity']
			);
		
		return $r;
	}
	
	/**
	 * Return a list of popular phrases
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getPopularPhrases($limit = 5, $year = null, $month = null, $onlyemail = false){
		if (is_null($year))
			$year = intval(date('Y'));
		
		if (is_null($month))
			$month = intval(date('m'));
		
		if ($onlyemail) {
			
			$sql = "select phrase as s, count(*) as n from ( 
						select trim(replace(replace(lower(phrase),'buscar ',''),'buscartodo','')) as phrase 
						from ( select substr(s1,strpos(s1,'\"')+1) as phrase 
							from ( select substr(s0, 0, strpos(s0, '\";s:')) as s1 
								from ( select substr(extra_data,strpos(extra_data,'s:7:\"subject\";') + 14) as s0 
									from message where (command = 'search' or command = 'searchfull') 
											and extract(year from moment::date) = $year 
											and extract(month from moment::date) = $month ) as subq2 
								) as subq ) 
							as subq1 
						where phrase <> '' 
							and phrase is not null 
						) as subq3 
					group by s order by n desc";
			
			$rr = Apretaste::query("SELECT sum(n) as total FROM ($sql) as subqx;");
			
			$total = $rr[0]['total'];
			
			$sql .= " limit $limit";
			
			$rr = Apretaste::query("SELECT sum(n) as total FROM ($sql) as subqx;");
			
			$subtotal = $rr[0]['total'];
			
			$r = Apretaste::query($sql);
			
			$r[] = array(
					's' => '[others]',
					'n' => $total - $subtotal
			);
			
			return $r;
		} else {
			$r = array();
			
			$rr = Apretaste::query("SELECT phrase, popularity FROM phrases order by popularity desc limit $limit");
			
			foreach ( $rr as $row )
				$r[] = array(
						's' => $row['phrase'],
						'n' => $row['popularity']
				);
			
			return $r;
		}
	}
	
	/**
	 * Return a list of searchs by day
	 *
	 * @param integer $limit
	 * @return mixed
	 */
	static function getSearchByDay($limit = 30){
		if ($limit == 0)
			$limit = "";
		else
			$limit = "LIMIT $limit";
		$r = Apretaste::query("SELECT * FROM search_by_day $limit;");
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Return a report of accusations by reason
	 *
	 * @return mixed
	 */
	static function getAccusationsByReason(){
		$r = Apretaste::query("SELECT * FROM accusation_by_reason;");
		if ($r)
			return $r;
		return false;
	}
	
	/**
	 * Count of new users of a month
	 *
	 * @param integer $year
	 * @param integer $month
	 */
	static function getCountOfNewUsers($year = null, $month = null){
		if (is_null($year))
			$year = intval(date('Y'));
		
		if (is_null($month))
			$month = intval(date('m'));
		
		$sql = "SELECT count(*) AS total
		FROM (
		    SELECT *
		    FROM (
				SELECT min(moment::date) as first_access,
				       extract_email(author) as author
				FROM message
				GROUP BY author
		    ) AS q1
		    WHERE extract(year from first_access) = $year and
				  extract(month from first_access) = $month
		) AS q2";
		
		$r = Apretaste::query($sql);
		return $r[0]['total'];
	}
	
	/**
	 * Count of old users of a month
	 *
	 * @param integer $year
	 * @param integer $month
	 */
	static function getCountOfOldUsers($year, $month){
		if (is_null($year))
			$year = intval(date('Y'));
		
		if (is_null($month))
			$month = intval(date('m'));
		
		$sql = "SELECT count(*) AS total
		FROM (
		    SELECT *
		    FROM (
			SELECT min(moment::date) as first_access,
			       extract_email(author) as author
			FROM message
			GROUP BY author
		    ) AS q1
		    WHERE 
				first_access < ($year || '-' || $month || '-01')::date
		) AS q2";
		
		$r = Apretaste::query($sql);
		return $r[0]['total'];
	}
	static function getAccessIn($year, $month){
		$sql = 'select extract(day from moment::date) as day, count(*) as total from message
		where extract(month from moment::date) = ' . $month . '
		and extract(year from moment::date) = ' . $year . '
		group by day
		order by day';
		
		$r = Apretaste::query($sql);
		
		return $r;
	}
	static function getAccessByHour($lastdays = 30){
		$sql = '
			select 
				moment::date - current_date + ' . ($lastdays - 1) . ' + 1 as orden,
				extract(day from moment::date) as dia, 
				extract(hour from moment) as hora, count(*) as total
			from message
			where moment::date >= current_date - ' . ($lastdays - 1) . '
			group by orden, dia, hora
			order by orden, dia, hora;';
		
		$r = Apretaste::query($sql);
		
		return $r;
	}
	
	static function getSMSByHour($lastdays = 30, $national = true){
		$sql = '
			select
				send_date::date - current_date + ' . ($lastdays - 1) . ' + 1 as orden,
				extract(day from send_date::date) as dia,
				extract(hour from send_date) as hora, count(*) as total
			from sms
			where send_date::date >= current_date - ' . ($lastdays - 1) . '
			'.($national?"and strpos(phone,'(+53)')>0":"and strpos(phone,'(+53)')=0").'
			group by orden, dia, hora
			order by orden, dia, hora;';

		$r = Apretaste::query($sql);
	
		return $r;
	}
	
	
	static function getAnswerByHour($lastdays = 30){
		$sql = '
			select
				send_date::date - current_date + ' . ($lastdays - 1) . ' + 1 as orden,
				extract(day from send_date::date) as dia,
				extract(hour from send_date) as hora, count(*) as total
			from answer
			where send_date::date >= current_date - ' . ($lastdays - 1) . '
			group by orden, dia, hora
			order by orden, dia, hora;';
		
		$r = Apretaste::query($sql);
		
		return $r;
	}
	static function getAccesByMonth(){
		$sql = '
			select extract(year from moment::date) as ano,
			extract(month from moment) as mes,
			count(*) as total
			from message
			where extract(year from moment::date) = extract(year from current_date)
			or extract(year from moment::date) = extract(year from current_date) - 1
			group by ano, mes
			order by ano, mes;';
		
		$r = Apretaste::query($sql);
		
		return $r;
	}
	static function getEngagementAndBounce(){
		$r = Apretaste::query("select * from engagement_and_bounce_month;");
		return $r;
	}
	static function getTotalUsersThisMonth($year = null, $month = null){
		if (is_null($year))
			$year = intval(date('Y'));
		
		if (is_null($month))
			$month = intval(date('m'));
		
		$sql = "select count(*) as total 
		from (select extract_email(author) as author from message 
		where extract(year from moment::date) = $year
		and extract(month from moment::date) = $month
		group by author) as subq";
		
		$r = Apretaste::query($sql);
		
		return $r[0]['total'] * 1;
	}
	static function getTotalUsersStats($year = null, $month = null){
		if (is_null($year))
			$year = intval(date('Y'));
		
		if (is_null($month))
			$month = intval(date('m'));
		
		$r = Apretaste::query("SELECT * FROM engagement_and_bounce_month WHERE year = $year AND month = $month");
		
		if (isset($r[0])) {
			$T = $r[0]['total'];
			$N = self::getCountOfNewUsers($year, $month);
			$R = self::getCountOfOldUsers($year, $month);
		}
	}
	static function getBestUsers($servers = false){
		$data = array();
		
		$current_month = intval(date("m"));
		$current_year = intval(date("Y"));
		
		$month = array();
		$year = array();
		$month[1] = $current_month - 2;
		$month[2] = $current_month - 1;
		$month[3] = $current_month;
		$year[1] = $current_year;
		$year[2] = $current_year;
		$year[3] = $current_year;
		
		if ($month[1] <= 0) {
			$month[1] = 12 + $month[1];
			$year[1] --;
		}
		
		if ($month[2] <= 0) {
			$month[2] = 12 + $month[2];
			$year[2] --;
		}
		
		for($i = 1; $i <= 3; $i ++) {
			$sql = "SELECT " . ($servers ? "get_email_domain(" : "") . "extract_email(author)" . ($servers ? ")" : "") . " as xauthor, count(*) as messages
				from message
				where extract(year from moment::date) = {$year[$i]} AND
				extract(month from moment::date) = {$month[$i]}
				group by xauthor
				order by messages desc
				limit 20";
			
			$r = Apretaste::query($sql);
			
			$data[$month[$i]] = $r;
		}
		
		return $data;
	}
}

