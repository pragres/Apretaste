<?php

if (isset($_POST['btnAddDispatcher'])) {
	ApretasteMoney::addDispatcher($_POST['edtEmail'], $_POST['edtName'], $_POST['edtContact']);
}

if (isset($_GET['delete'])) {
	ApretasteMoney::delDispatcher($_GET['delete']);
}

if (isset($_GET['sales'])) {
	
	$data['email'] = $_GET['sales'];
	
	if (isset($_GET['pdf'])) {
		
		include "../lib/fpdf17/fpdf.php";
		
		$pdf = new ApretastePDF();
		$pdf->addPage('P', 'letter');
		
		$cards = ApretasteMoney::getSaleCards($_GET['pdf']);
		
		$i = 0;
		$x = 0;
		$y = - 55;
		$pdf->AddFont('ErasITC-Bold', '', 'ERASBD.php');
		
		foreach ( $cards as $k => $card ) {
			$i ++;
			
			if ($i % 2 == 0)
				$x = 108;
			else
				$x = 0;
			
			if ($i % 2 != 0)
				$y += 55;
			
			$pdf->Rotate(0);
			$pdf->Image('../tpl/admin/recharge_card.tpl.png', $x, $y, - 300);
			
			$pdf->SetFont('ErasITC-Bold', '', 68);
			$pdf->SetTextColor(200, 200, 200);
			
			$pdf->Text(44 + $x, 25 + $y, '$' . $card['amount']);
			
			$pdf->SetFont('ErasITC-Bold', '', 13);
			$pdf->SetTextColor(200, 0, 10);
			
			$pdf->Rotate(90);
			$code = $card['code'];
			$code = substr($code, 0, 4) . '-' . substr($code, 4, 4) . '-' . substr($code, 8, 4);
			$pdf->Text(- 27 - $y, 100 + $x, $code);
			
			if ($i % 10 == 0 && isset($cards[$k + 1])) {
				$pdf->addPage('P', 'letter');
				$x = 0;
				$y = - 55;
			}
		}
		
		$pdf->Output("Apretaste - Recharge's Cards - " . date("Y-m-d h-i-s") . ".pdf", 'D');
		
		return true;
	}
	
	if (isset($_GET['cards'])) {
		
		$data['cards'] = ApretasteMoney::getSaleCards($_GET['cards']);
		$data['sale'] = $_GET['cards'];
		echo new div("../tpl/admin/recharge_cards.tpl", $data);
		exit();
	}
	
	if (isset($_POST['btnAddSale'])) {
		ApretasteMoney::addRechargeCardSale($_GET['sales'], $_POST['edtQuantity'], $_POST['edtSalePrice'], $_POST['edtCardPrice']);
	}
	
	if (isset($_GET['delete'])) {
		ApretasteMoney::delSale($_GET['delete']);
	}
	
	$data['sales'] = ApretasteMoney::getRechargeCardSalesOf($_GET['sales']);
	
	echo new div("../tpl/admin/recharge_card_sales.tpl", $data);
	exit();
}

$data['dispatchers'] = ApretasteMoney::getDispatchers();