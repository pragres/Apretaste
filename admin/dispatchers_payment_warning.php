<?php
$email = get('dispatcher');
$datefrom = null;
$dateto = null;

if (isset($_GET['datefrom']))
	$datefrom = $_GET['datefrom'];
if (isset($_GET['dateto']))
	$dateto = $_GET['dateto'];

if (! is_null($email)) {
	$data['dispatcher'] = ApretasteMoney::getDispatcher($email, 60);
	$data['payment_warning'] = ApretasteMoney::getPaymentWarning($email, $datefrom, $dateto);
	
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