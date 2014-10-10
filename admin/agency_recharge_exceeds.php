<?php
$data['msg'] = 'This recharge exceeds the credit limit of your agency. Your agency must pay the debt of <b>${#owe:2.#}</b> to recharge over <b>${#max_amount:2.#}</b>.';
$data['msg-type'] = 'danger';
$data['owe'] = get('owe');
$data['max_amount'] = get('max_amount');
	