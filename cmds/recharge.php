<?php
function cmd_recharge($robot, $from, $argument, $body = '', $images = array()){
	$robot->log("Recharge credit for $from with $argument card");
	
	$argument = trim($argument);
	
	$code = str_replace("'", "''", $argument);
	
	$r = Apretaste::query("SELECT * FROM recharge_card WHERE code = '$code' AND email is null;");
	
	$from = strtolower($from);
	
	$credit = ApretasteMoney::getCreditOf($from);
	
	if (isset($r[0]))
		if ($r[0]['code'] == $argument) {
			
			Apretaste::query("UPDATE recharge_card SET email = '$from', recharge_date = now() WHERE code = '$code';");
			
			$newcredit = ApretasteMoney::getCreditOf($from);
			
			if ($newcredit > $credit) {
				return array(
						"answer_type" => "recharge_successfull",
						"amount" => $r[0]['amount'],
						"from" => $from
				);
			}
			
			return array(
				"answer_type" => "recharge_fail",
				"code" => $code,
				"from" => $from
			);
		}
	
	return array(
			"answer_type" => "recharge_card_wrong",
			"code" => $code,
			"from" => $from
	);
}
