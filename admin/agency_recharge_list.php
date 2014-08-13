<?php 

$user = ApretasteAdmin::getUser();

$offset = 0;

$data['recharges'] = Apretaste::query("
			SELECT 
			moment::date as date,
			agency_customer.full_name as customer_name,
			agency_customer.email as customer_email,
			agency_recharge.email as user_email,
			agency_recharge.amount as amount
			FROM agency_recharge inner join agency_customer on agency_customer.id = agency_recharge.customer 
			WHERE user_login = '{$user['user_login']}'
			OFFSET $offset LIMIT 30;");

$r = Apretaste::query("SELECT count(*) as total FROM agency_recharge WHERE user_login = '{$user['user_login']}';");
$data['total'] = $r[0]['total'];