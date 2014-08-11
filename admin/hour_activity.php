<?php
$date = $_GET['date'];
$hour = $_GET['hour'];

$data['date'] = $date;
$data['hour'] = $hour;

$sql = "SELECT id,moment, extract_email(author) as author, command, extra_data,
(select count(*) from answer where message.id=answer.message) as answers,
(select send_date from answer where message.id=answer.message limit 1) as answer_date,
(select extract_email(sender) from answer where message.id=answer.message limit 1) as answer_sender,
(select subject from answer where message.id=answer.message limit 1) as answer_subject,
(select type from answer where message.id=answer.message limit 1) as answer_type
FROM message WHERE moment::date = '$date' and extract(hour from moment) = $hour;";

$data['messages'] = Apretaste::query($sql);

if (is_array($data['messages']))
	foreach ( $data['messages'] as $k => $v ) {
		$e = @unserialize($v['extra_data']);
		if (isset($e['headers']->subject))
			$data['messages'][$k]['subject'] = $e['headers']->subject;
		else
			$data['messages'][$k]['subject'] = '';
	}

$sql = "SELECT * FROM answer WHERE send_date::date = '$date' AND extract(hour from send_date) = $hour;";

$data['answers'] = Apretaste::query($sql);
