<?php
$user = ApretasteAdmin::getUser();

$date = get('date', date('Y-m-d'));
$hour = get('hour', false);
$data['date'] = $date;
$data['hour'] = $hour;
$offset = 0;

$data['recharges'] = q("
			SELECT 
			to_char(moment, 'DD/MM/YYYY HH12:MI PM') as date,
			agency_customer.full_name as customer_name,
			agency_customer.email as customer_email,
			agency_recharge.email as user_email,
			agency_recharge.amount as amount,
			agency_customer.id as customer_id
			FROM agency_recharge inner join agency_customer on agency_customer.id = agency_recharge.customer 
			WHERE user_login = '{$user['user_login']}'
			and moment::date = '$date' 
			" . ($hour !== false ? "and extract(hour from moment) = $hour" : "") . "
			OFFSET $offset LIMIT 30;");

$r = q("SELECT count(*) as total FROM agency_recharge WHERE user_login = '{$user['user_login']}';");

$data['total'] = $r[0]['total'];