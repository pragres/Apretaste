<?php

// Sources of traffic
$data['sources_of_traffic'] = ApretasteAnalitics::getBestUsers(true);

$limit = 4;

$sql = "SELECT get_email_domain(extract_email(message.author)) AS servidor,
    count(*) AS cant
   FROM message
  WHERE date_part('year'::text, message.moment::date) = date_part('year'::text, 'now'::text::date)
  GROUP BY get_email_domain(extract_email(message.author))
  ORDER BY count(*) DESC
		";

$rr = q("SELECT sum(cant) as total FROM ($sql) as subq;");

$total = $rr[0]['total'];

$rr = q("SELECT sum(cant) as total FROM ($sql limit $limit) as subq;");

$subtotal = $rr[0]['total'];

$sql .= " limit $limit";

$servers = q($sql);

$servers[] = array(
		'servidor' => '[ohters]',
		'cant' => $total - $subtotal
);

$data['source_of_traffic_data'] = array();

foreach ( $servers as $s ) {
	$data['source_of_traffic_data'][] = array(
			'label' => $s['servidor'] . "({$s['cant']})",
			'data' => $s['cant'] * 1
	);
}
