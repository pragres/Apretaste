<?php

$data['msg-type'] = 'msg-ok';

if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	Apretaste::query("DELETE FROM accusation WHERE id = '$id';");
	$data['msg'] = "Accusation was been deleted";
}

if (isset($_GET['proccess'])) {
	$id = $_GET['proccess'];
	Apretaste::query("UPDATE accusation SET proccessed = true WHERE id = '$id';");
	$data['msg'] = "Accusation was been proccessed";
}

$data['accusations'] = Apretaste::query("SELECT id, fa::date, announcement, author, get_ad_title(announcement) as title, reason, get_ad_author(announcement) as accused FROM accusation where proccessed = false order by fa;");