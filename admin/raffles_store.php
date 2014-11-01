<?php
$store = ApretasteStore::getStore('raffle_tickets');

if ($store == false) {
	ApretasteStore::addStore('soporte@apretaste.com', 'Tickets para rifas!', 'Apretaste Store!', 'raffle_tickets');
	$store = ApretasteStore::getStore('raffle_tickets');
}

if (isset($_POST['btnAddSale'])) {
	$title = post('edtTitle');
	$desc = post('edtDescription');
	$price = post('edtPrice');
	$pic = '';
	$pic_type = '';
	ApretasteStore::addSale('soporte@apretaste.com', 'soporte@apretaste.com', $title, $desc, $price, 'Paquete de tickets para rifas', $pic, $pic_type, 'TICKETS COMPRADOS', 'raffle_tickets');
}

$data['sales'] = q("SELECT id,moment::date as date,title,price FROM store_sale WHERE store = 'raffle_tickets';");



