<?php
$nourish = get('nourish');

if (! is_null($nourish)) {
	Apretaste::nourishAddressList();
	header("Location: index.php?path=admin&page=address_list");
	exit();
}

$submit = post('btnAdd');

$download = post('btnDownload');
$download1 = get('download');

$filter = get('filter');
if (! is_null($download) || ! is_null($download1)) {
	$file_name = 'apretaste-addresses-' . str_replace(array(
			'@',
			'.'
	), '-', $filter) . '-' . date("Ymdhis") . ".txt";
	
	$file_name = str_replace("--", "-", $file_name);
	
	$sql = "SELECT email FROM address_list " . (is_null($filter) ? "" : "WHERE matchEmail(email,'$filter') OR matchEmail(source,'$filter')");
	
	$list = Apretaste::query($sql);
	
	$listtext = '';
	if (is_array($list))
		foreach ( $list as $l ) {
			$listtext .= $l['email'] . "\r\n";
		}
	
	$headers = array(
			'Content-type: force-download',
			'Content-disposition: attachment; filename="' . $file_name . '"',
			'Content-Type: text/plain; name="' . $file_name . '"',
			'Content-Transfer-Encoding: binary',
			'Pragma: no-cache',
			'Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
			'Expires: 0',
			'Accept-Ranges: bytes'
	);
	
	foreach ( $headers as $h )
		header($h);
	
	echo $listtext;
	exit();
}

if (! is_null($submit)) {
	$address = post('address');
	$source = 'apretaste.admin';
	$address = Apretaste::addToAddressList($address, $source);
	$data['msg-type'] = 'msg-ok';
	$data['msg'] = 'The address was inserted';
	$data['addinserted'] = $address;
}

if (isset($_POST['btnDropAddress'])) {
	Apretaste::dropEmailAddress($_POST['edtDropAddress']);
}

$r = Apretaste::query("SELECT count(*) as total from address_list");
$data['total_address'] = $r[0]['total'];

$data['providers'] = Apretaste::query("Select provider, total, case when provider ~* '.cu' then 1 else 0 end as national from (
		SELECT get_email_domain(email) as provider, count(*) as total
		from address_list group by provider order by total desc) as subq;");