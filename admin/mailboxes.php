<?php
if (isset($_POST['btnAdd'])) {
	$mailbox = $_POST['mailbox'];
	ApretasteMailboxes::createMailbox($mailbox);
}

if (isset($_POST['btnAddPattern'])) {
	$from = $_POST['from_pattern'];
	$to = $_POST['to_pattern'];
	ApretasteMailboxes::addRestriction($from, $to);
}

if (isset($_GET['del_rest'])) {
	ApretasteMailboxes::deleteRestriction($_GET['del_rest']);
}

if (isset($_GET['delete'])) {
	ApretasteMailboxes::deleteMailBox($_GET['delete']);
}

$data['mbuse'] = Apretaste::query("select mailboxes.mailbox as servidor,
		count(*) as cant
		from message inner join mailboxes on
		lower(extract_email(addressee)) ~* mailboxes.mailbox
		group by servidor
		order by cant desc;");

$data['restrictions'] = ApretasteMailboxes::getRestrictions();
$data['mailboxes'] = ApretasteMailboxes::getMailBoxes();
