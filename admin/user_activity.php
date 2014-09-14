<?php

$user = false;

if (isset($_GET['user'])) {
	
	$_GET['user'] = Apretaste::extractEmailAddress($_GET['user']);
	
	$user = array();
	$user['email'] = strtolower($_GET['user']);
	
	// credit
	$user['credit'] = ApretasteMoney::getCreditOf($_GET['user']);
	
	// messages
	$user['messages'] = Apretaste::query("SELECT *,
					(select count(*) from answer where message.id=answer.message) as answers ,
					(select send_date from answer where message.id=answer.message limit 1) as answer_date,
					(select extract_email(sender) from answer where message.id=answer.message limit 1) as answer_sender,
					(select subject from answer where message.id=answer.message limit 1) as answer_subject,
					(select type from answer where message.id=answer.message limit 1) as answer_type
					FROM message WHERE extract_email(author) = '{$user['email']}' order by moment desc limit 20;");
	
	if (is_array($user['messages']))
		foreach ( $user['messages'] as $k => $v ) {
			$e = @unserialize($v['extra_data']);
			if (isset($e['headers']->subject))
				$user['messages'][$k]['subject'] = $e['headers']->subject;
		}
		
		// ads
	
	$user['ads'] = Apretaste::query("SELECT * FROM announcement WHERE extract_email(author) = '{$_GET['user']}';");
	
	// subscribes
	$user['subscribes'] = Apretaste::getSubscribesOf($_GET['user']);
	
	// answers
	$user['answers'] = Apretaste::query("SELECT extract_email(sender) as xsender,* FROM answer WHERE extract_email(receiver) = '{$_GET['user']}' and (message is null or message = '') order by send_date desc limit 20;");
	
	$data['author'] = Apretaste::getAuthor($_GET['user'],true,100);
}

$data['client'] = $user;
