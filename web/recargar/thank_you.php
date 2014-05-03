<?php
	$email_user = $_GET['user'];
	$email_customer = $_GET['customer'];
	$amount = $_GET['amount'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />
		<title>Gracias por su recarga!</title>
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<!--[if lte IE 7]><script src="js/IE8.js" type="text/javascript"></script><![endif]-->
		<!--[if lt IE 7]><link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/><![endif]-->
		<link rel="stylesheet" href="../static/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../static/bootstrap/css/bootstrap-theme.min.css">
		<style type="text/css">
			h1{
				font-size: 25px;
				text-transform: uppercase;
				color: green;
			}
			.container{
				max-width: 600px;
			}
		</style>
	</head>

	<body id="index" class="home">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<img alt="Apretaste!" src="../static/apretaste.white.png" style="width:300px; margin:10px 0px;">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<h1 style="margin-top: 0px;">Gracias por su recarga!</h1>
					<p>La cuenta asociada con el correo electr&oacute;nico <b><?php echo $email_user; ?></b> ha sido recargada satisfactoriamente con <b><?php echo $amount; ?> USD</b>. Le hemos enviado un correo electr&oacute;nico de confirmaci&oacute;n a <?php echo $email_customer; ?> y otro correo electr&oacute;nico a la direcci&oacute;n del destinatario.</p>
					<p>Nuevamente:</p>
					<p><b>Gracias por usar Apretaste!</b></p>
				</div>
			</div>
		</div>
	</body>
</html>

