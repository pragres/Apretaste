<?php
Apretaste::connect();

$limit = 4;

$sql = "
		SELECT get_email_domain(extract_email(message.author)) AS servidor, 
    count(*) AS cant
   FROM message
  WHERE date_part('year'::text, message.moment::date) = date_part('year'::text, 'now'::text::date)
  GROUP BY get_email_domain(extract_email(message.author))
  ORDER BY count(*) DESC 
		";

$rr = Apretaste::query("SELECT sum(cant) as total FROM ($sql) as subq;");

$total = $rr[0]['total'];

$rr = Apretaste::query("SELECT sum(cant) as total FROM ($sql limit $limit) as subq;");

$subtotal = $rr[0]['total'];

$sql .= " limit $limit";
$servers = Apretaste::query($sql);

$servers[] = array(
		'servidor' => '[ohters]',
		'cant' => $total - $subtotal
);

$labels = array();
$points = array();

foreach ( $servers as $s ) {
	$labels[] = $s['servidor'] . "({$s['cant']})";
	$points[] = $s['cant'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Email servers", true, true);

// End of file