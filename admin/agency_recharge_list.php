<?php 

$user = ApretasteAdmin::getUser();

$date = get('date',date('Y-m-d')); 
$hour = get('hour',date('H'));
$data['date'] = $date;
$data['hour'] = $hour;
$offset = 0;

$data['recharges'] = Apretaste::query("
			SELECT 
			moment::date as date,
			agency_customer.full_name as customer_name,
			agency_customer.email as customer_email,
			agency_recharge.email as user_email,
			agency_recharge.amount as amount,
			agency_customer.id as customer_id
			FROM agency_recharge inner join agency_customer on agency_customer.id = agency_recharge.customer 
			WHERE user_login = '{$user['user_login']}'
			and moment::date = '$date' and extract(hour from moment) = $hour
			OFFSET $offset LIMIT 30;");

$r = Apretaste::query("SELECT count(*) as total FROM agency_recharge WHERE user_login = '{$user['user_login']}';");
$data['total'] = $r[0]['total'];