<?php

if (isset($_GET['deactivate'])){
    $code = $_GET['deactivate'];
    $sale = $_GET['cards'];

    q("DELETE FROM recharge_card WHERE code = '$code';");
    q("UPDATE recharge_card_sale SET quantity = quantity - 1 WHERE id =  '$sale';");

    $data['msg'] = "The card $code was deactivated";
    $data['msg-type'] = "success";
}

$data['cards'] = ApretasteMoney::getSaleCards($_GET['cards']);
$data['sale'] = $_GET['cards'];
$data['dispatcher'] = ApretasteMoney::getDispatcher($_GET['dispatcher'], 100);

//var_dump($data);