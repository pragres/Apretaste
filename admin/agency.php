<?php
$phrase = post('edtSearch', '');
$phrase = str_replace("'", "''", $phrase);

$r = array();

if (strlen(trim($phrase)) >= 3) {
	
	$data['searchresults'] = array();
	
	$sql = "
	SELECT id, full_name, email, phone, date_registered, to_char(last_recharge, 'DD/MM/YYYY HH12:MI PM') as last_recharge
	FROM (
	SELECT *, strpos(email || ' ' || full_name || ' ' || phone, '$phrase') AS pos,
	(select max(moment)
	FROM agency_recharge
	WHERE agency_customer.id = agency_recharge.customer) as last_recharge
	FROM agency_customer
	) AS subq
	WHERE pos > 0
	ORDER BY pos
	LIMIT 20;";
	
	$r = Apretaste::query($sql);
	if (isset($r[0])) {
		
		foreach ( $r as $k => $v ) {
			$r[$k] = array_merge(Apretaste::getAuthor($v['email'], false, 50), $v);
		}
	} else {
		$data['msg'] = 'Customers for <b>' . $phrase . '</b> not found';
		$data['msg-type'] = 'danger';
	}
}

if (! isset($_POST['edtSearch'])) {
	$r = q("
	SELECT id, full_name, email, phone, date_registered, to_char(last_recharge, 'DD/MM/YYYY HH12:MI PM') as last_recharge
	FROM (
	SELECT *,
		(select max(moment)	FROM agency_recharge WHERE agency_customer.id = agency_recharge.customer) as last_recharge 
	FROM agency_customer) AS subq
	order by (select count(*) FROM agency_recharge WHERE subq.id = agency_recharge.customer) desc		
	LIMIT 20;");
}

if (is_array($r))
	foreach ( $r as $k => $v ) {
		$r[$k] = array_merge(Apretaste::getAuthor($v['email'], false, 50), $v);
		$r[$k] = array(
				'id' => $r[$k]['id'],
				'picture' => $r[$k]['picture'],
				'full_name' => $r[$k]['full_name'],
				'email' => $r[$k]['email'],
				'phone' => $r[$k]['phone'],
				'date_registered' => $r[$k]['date_registered'],
				'last_recharge' => $r[$k]['last_recharge']
		);
	}

$data['searchresults'] = $r;