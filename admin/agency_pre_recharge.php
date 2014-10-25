<?php
$data['hash'] = md5(uniqid());
$_SESSION['agency_recharge_hash'] = $data['hash'];

$amount = post("edtAmount");
$amount = $amount * 1;

if ($amount < 0)
	$amount = 0;

$chk = ApretasteMoney::checkCreditLine($data['user']['agency'], $amount);

if ($chk !== true) {
	$data['msg'] = 'This recharge exceeds the credit limit of your agency. Your agency must pay the debt of <b>${#owe:2.#}</b> to recharge over <b>${#max_amount:2.#}</b>.';
	$data['msg-type'] = 'danger';
	$data['owe'] = $chk['owe'];
	$data['max_amount'] = $chk['max_amount'];
	$data['limitcredit'] = true;
} else {
	
	$chk = ApretasteMoney::checkPaymentTimelimit($data['user']['agency']);
	
	if ($chk === false) {
		$data['msg'] = 'You need pay your owe before continue the recharge. Please see <a href="?q=agency_bill">your bill</a> for more details.';
		$data['msg-type'] = 'danger';
		$data['limitcredit'] = true;
	} else {
		$email = post("edtEmail");
		$user = Apretaste::getAuthor($email);
		$user['credit'] = ApretasteMoney::getCreditOf($email);
		$user['picture'] = Apretaste::resizeImage($user['picture'], 200);
		$agency = ApretasteAdmin::getAgency($data['user']['agency']);
		
		$customer = post('edtCustomer');
		
		$data['author'] = $user;
		$data['limitcredit'] = false;
	}
}