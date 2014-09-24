<?php


$data['cards'] = ApretasteMoney::getSaleCards($_GET['cards']);
$data['sale'] = $_GET['cards'];
$data['dispatcher'] = ApretasteMoney::getDispatcher($_GET['dispatcher'], 100);

//var_dump($data);