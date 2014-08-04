<?php
$id = get('id');

$r = Apretaste::query("SELECT * FROM agency_customer WHERE id = '$id';");

$data['customer'] = $r[0];

$r = Apretaste::query("SELECT email FROM agency_recharge WHERE customer = '{$data['customer']['id']}' group by email;");

$arr = array();

if (is_array($r)) foreach ( $r as $row ) {
	$arr[] = Apretaste::getAuthor($row['email']);
}

$data['customer']['contacts'] = $arr;
