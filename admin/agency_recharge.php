<?php

/**
 * Apretaste! Recharge credit of user by agency
 *
 * @author rafa
 * @version 1.0
 */
$hash = post('hash');

if ($_SESSION['agency_recharge_hash'] == $hash) {
	
	unset($_SESSION['agency_recharge_hash']);
	
	$email = post("edtEmail");
	
	$author = Apretaste::getAuthor($email);
	$data['success'] = false;
	
	if (! is_null($email)) {
		
		$amount = post("edtAmount");
		$customer = post('edtCustomer');
		
		$u = q("SELECT agency FROM users WHERE user_login = '{$data['user']['user_login']}';");
		
		$agency = $u[0]['agency'];
		
		$procede = ApretasteMoney::checkCreditLine($agency, $amount);
		
		if ($procede === true) {
			
			$procede = ApretasteMoney::checkPaymentTimelimit($agency);
			
			if ($procede === false) {
				header("Location: ?q=agency_recharge_timelimit&customer=$customer");
				exit();
			} else {
				
				if (trim($agency) == '')
					$agency = 'null';
				else
					$agency = "'$agency'";
				
				$r = q("INSERT INTO agency_recharge (user_login, customer, email, amount, agency)
				VALUES ('{$data['user']['user_login']}','{$customer}','{$email}','{$amount}',$agency)
				RETURNING id;");
				
				$id = $r[0]['id'];
				
				$customer = ApretasteAdmin::getAgencyCustomer($customer);
				
				$credit = ApretasteMoney::getCreditOf($email);
				
				// Send email to the customer
				ob_start();
				
				Apretaste::sendEmail($customer['email'], array(
						"answer_type" => "recharge_thankyou",
						"recharge_angecy" => true,
						"customer" => $customer,
						"amount" => $amount,
						"author" => $author,
						"newcredit" => $credit,
						"user_email" => $email
				), true);
				
				ApretasteAdmin::log(ob_get_contents());
				
				ob_end_clean();
				
				if (! Apretaste::isUser($email)) {
					Apretaste::invite($customer['email'], $email, true, true);
				}
				
				/* Send email to the user */
				
				ob_start();
				
				Apretaste::sendEmail($email, array(
						"answer_type" => "recharge_successfull",
						"recharge_agency" => true,
						"customer" => $customer,
						"amount" => $amount,
						"author" => $author,
						"newcredit" => $credit
				), true);
				
				ApretasteAdmin::log(ob_get_contents());
				
				ob_end_clean();
				
				header("Location: ?q=agency_recharge_successfull&transaction=$id&email=$email&customer=" . $customer['id']);
				exit();
			}
		} else {
			header("Location: ?q=agency_recharge_exceeds&email=$email&owe={$procede['owe']}&max_amount={$procede['max_amount']}&customer=" . $customer['id']);
			exit();
		}
	} else {
		$data['msg'] = "The user's email was required";
		$data['msg-type'] = "danger";
	}
} else {
	$customer = post('edtCustomer');
	header("Location: index.php?q=agency_customer&customer=" . $customer);
	exit();
}
