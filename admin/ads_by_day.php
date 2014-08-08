<?php

// Ads by day
$sql = "select fecha,
sum(externo) as externos,
sum(interno) as internos,
(select count(*) from (
	SELECT author 
	FROM announcement 
	where post_date::date = fecha 
	group by author) as subqq
) as authors,
(select count(*) from message where moment::date = fecha) as messages,
(select count(*) from message where moment::date = fecha and command = 'insert') as insert_messages,
(select count(*) from message where moment::date = fecha and command = 'delete') as delete_messages,
(select count(*) from message where moment::date = fecha and command = 'update') as update_messages,
(select count(*) from message where moment::date = fecha and command = 'search' or command = 'searchfull') as search_messages,
(select count(*) from message where moment::date = fecha and command = 'get') as get_messages,
(select count(*) from (	
	select extract_email(author) as author
	FROM message 
	WHERE moment::date = fecha
		AND (command = 'insert' OR  command = 'update' OR command = 'delete' OR command = 'search' OR command = 'searchfull' OR command = 'get')     
	GROUP BY author) as subq1) as remittent
from (
		select post_date::date as fecha,
		(select case when external_id is null then 0 else 1 end) as externo,
		(select case when external_id is null then 1 else 0 end) as interno
		from announcement) as subq
group by fecha
order by fecha desc";

$r = Apretaste::query($sql);
if (! is_array($r))
	$r = array();
$data['ads_by_day'] = $r;