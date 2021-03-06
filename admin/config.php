<?php
$data['msg-type'] = "msg-ok";

if (isset($_POST['btnUpdateConfig'])) {
	Apretaste::setConfiguration("price_regexp", $_POST['edtPriceRegExp']);
	Apretaste::setConfiguration("phones_regexp", $_POST['edtPhonesRegExp']);
	Apretaste::setConfiguration("enable_history", isset($_POST['chkEnableHistorial']));
	Apretaste::setConfiguration("outbox.max", intval($_POST['edtOutboxmax']));
	Apretaste::setConfiguration("sms_free", isset($_POST['chkSmsFree']));
	Apretaste::setConfiguration("agency_payment_timelimit", $_POST['edtAgencyPaymentTimelimit']);
	$data['msg'] = "The configuration was been saved";
	$data['msg-type'] = 'success';
}

// Load data
$data['chkEnableHistorial'] = Apretaste::getConfiguration("enable_history");
$data['chkSmsFree'] = Apretaste::getConfiguration("sms_free");
$data['edtPriceRegExp'] = Apretaste::getConfiguration("price_regexp");
$data['edtPhonesRegExp'] = Apretaste::getConfiguration("phones_regexp");
$data['edtOutboxmax'] = Apretaste::getConfiguration("outbox.max");
$data['edtAgencyPaymentTimelimit'] = Apretaste::getConfiguration("agency_payment_timelimit");
