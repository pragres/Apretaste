<?php 

$data['crosstable'] = q("SELECT dispatcher, \"3\", \"5\", \"10\", total FROM dispatchers_recharges_cross order by total desc;");
$data['recharges_by_day'] = q("SELECT dia as day, total as recharges, amount FROM dispatchers_recharges_by_day ORDER BY dia");


$current_year = intval(date("Y"));
$current_month = intval(date("m"));

$months = array(
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec"
);


$r = q('select year as ano, month as mes, * from dispatchers_recharges_by_month
			where year = extract(year from current_date)
			or year = extract(year from current_date) - 1
			order by year, month;');

$visitors = array();

for($i = 1; $i <= 12; $i ++) {
	$visitors[$i - 1] = array(
			"period" => $current_year.'-'.$i,
			"last" => 0,
			"current" => 0
	);
}

foreach ( $r as $row ) {
	$prop = "last";
	if ($row['ano'] == $current_year)
		$prop = "current";
	$visitors[$row['mes'] - 1][$prop] = intval($row['total']);
}

$data['recharges_quantity'] = $visitors;

$r = q('select year as ano, month as mes, * from dispatchers_recharges_by_month
			where year = extract(year from current_date)
			or year = extract(year from current_date) - 1
			order by year, month;');

$visitors = array();

for($i = 1; $i <= 12; $i ++) {
	$visitors[$i - 1] = array(
			"period" => $current_year.'-'.$i,
			"last" => 0,
			"current" => 0
	);
}

foreach ( $r as $row ) {
	$prop = "last";
	if ($row['ano'] == $current_year)
		$prop = "current";
	$visitors[$row['mes'] - 1][$prop] = intval($row['total']);
}

$data['recharges_amount'] = $visitors;

$r = q("select '3$' as s, sum(\"3\") as n from dispatchers_recharges_cross
	union select '5$' as s, sum(\"5\") as n from dispatchers_recharges_cross
	union select '10$' as s, sum(\"10\") as n from dispatchers_recharges_cross;");

$data['recharges_by_price'] = array();

foreach ( $r as $s ) {
	$data['recharges_by_price'][] = array(
			'label' => $s['s'] . "({$s['n']})",
			'data' => $s['n'] * 1
	);
}

$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

