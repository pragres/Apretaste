<?php
function cmd_recharge($robot, $from, $argument, $body = '', $images = array()){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
	$robot->log("Recharge credit for $from with $argument card");
	
	$argument = trim($argument);
	
	// Remove ugly chars
	
	$n = '';
	$l = strlen($argument);
	for($i = 0; $i < $l; $i ++)
		if (strpos('1234567890', $argument[$i]) !== false)
			$n .= $argument[$i];
	
	$argument = $n;
	
	$code = $argument;
	
	$r = Apretaste::query("SELECT * FROM recharge_card WHERE code = '$code' AND email is null;");
	
	$from = strtolower($from);
	
	$credit = ApretasteMoney::getCreditOf($from);
	
	if (isset($r[0]))
		if ($r[0]['code'] == $argument) {
			
			if (! Apretaste::isSimulator()) {
				Apretaste::query("UPDATE recharge_card SET email = '$from', recharge_date = now() WHERE code = '$code';");
				
				$newcredit = ApretasteMoney::getCreditOf($from);
			} else
				$newcredit = $credit + 1;
			
			if ($newcredit > $credit) {
				return array(
						"answer_type" => "recharge_successfull",
						"amount" => $r[0]['amount'],
						"from" => $from
				);
			}
			
			return array(
					"answer_type" => "recharge_fail",
					"command" => "recharge",
					"code" => $code,
					"from" => $from
			);
		}
	
	return array(
			"answer_type" => "recharge_card_wrong",
			"command" => "recharge",
			"code" => $code,
			"from" => $from
	);
}
