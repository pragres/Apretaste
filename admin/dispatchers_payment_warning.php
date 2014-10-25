<?php
$email = get('dispatcher');

if (! is_null($email)) {
	$data['dispatcher'] = ApretasteMoney::getDispatcher($email, 60);
	$data['payment_warning'] = ApretasteMoney::getPaymentWarning($email);
	
	if (isset($_GET['pdf'])) {
		
		$html = new ApretasteView("../tpl/admin/dispatchers_payment_warning.pdf.tpl", $data['payment_warning']);
		$html = "$html";
		
		include "../lib/mpdf/mpdf.php";
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		
		$mpdf->Output("Apretaste - Aviso de pago - " . date("Y-m-d h-i-s") . ".pdf", 'D');
		
		return true;
	}
}