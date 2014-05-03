<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />
		<title>Recarga de Apretaste!</title>
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<!--[if lte IE 7]><script src="js/IE8.js" type="text/javascript"></script><![endif]-->
		<!--[if lt IE 7]><link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/><![endif]-->
		<link rel="stylesheet" href="../static/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../static/bootstrap/css/bootstrap-theme.min.css">
		<?php /*
		<script src="../static/bootstrap/js/bootstrap.min.js"></script>
		*/?>
		<style type="text/css">
			.control-label{
				text-align: left !important; 
			}
			h1{
				font-size: 25px;
				text-transform: uppercase;
				color: green;
			}
			select{
				height: 34px;
				width: 100%;
				border: 1px solid #ccc;
				padding: 0px 5px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
				-khtml-border-radius: 3px;
				border-radius: 3px;
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
				<!-- payment form -->
				<div class="col-xs-12 col-sm-8 col-md-8">

					<form action="" method="POST" id="payment-form" class="form-horizontal" role="form">
						<h1 style="margin-top: 0px;">Personal</h1>
						<p>Escriba su correo electr&oacute;nico (para mandarle un recibo) y escoja la cantidad a recargar.</p>

						<div class="form-group">
							<label for="youremail" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">Email</label>
							<div class="col-xs-12 col-sm-9 col-sm-10 col-sm-10">
								<input type="email" class="form-control" id="youremail" placeholder="Su correo electr&oacute;nico">
							</div>
						</div>

						<div class="form-group">
							<label for="amount" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">Cantidad</label>
							<div class="col-xs-12 col-sm-9 col-sm-10 col-sm-10">
								<select id="amount" class="dropdown" class="form-control">
									<option value="5">$5 (Aprox 30 SMS)</option>
									<option value="10" selected>$10 (Aprox 60 SMS)</option>
									<option value="15">$15 (Aprox 90 SMS)</option>
									<option value="20">$20 (Aprox 120 SMS)</option>
									<option value="25">$25 (prox 150 SMS)</option>
									<option value="30">$30 (Aprox 180 SMS)</option>
								</select>
							</div>
						</div>
						
						<hr/>
					
						<h1>Cuenta a recargar</h1>
						<p>Escriba el correo electr&oacute;nico de la persona a recargar.</p>

						<div class="form-group">
							<label for="user" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">Email</label>
							<div class="col-xs-12 col-sm-9 col-sm-10 col-sm-10">
								<input type="email" class="form-control" id="user" placeholder="Email a recargar">
							</div>
						</div>

						<hr/>
						
						<h1>Tarjeta de Cr&eacute;dito</h1>
						<p>Entre la informaci&oacute;n de su tarjeta de cr&eacute;dito. Si no sabe como hacerlo o tiene dudas, escribanos a <a href="mailto:soporte@apretaste.com">soporte@apretaste.com</a> y le ayudaremos al momento</p>

						<div class="form-group">
							<label for="ccname" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">Nombre</label>
							<div class="col-xs-12 col-sm-9 col-sm-10 col-sm-10">
								<input type="text" class="form-control" id="ccname" placeholder="Nombre en la tarjeta">
							</div>
						</div>
						<div class="form-group">
							<label for="ccnumber" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">N&uacute;mero</label>
							<div class="col-xs-12 col-sm-9 col-sm-10 col-sm-10">
								<input type="text" size="20" maxlength="20" data-stripe="number" class="form-control" id="ccnumber" placeholder="N&uacute;mero en la tarjeta">
							</div>
						</div>  
	  					<div class="form-group">
							<label for="name" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">CVV</label>
							<div class="col-xs-6 col-sm-3 col-sm-3 col-sm-3">
								<input type="text" size="4" maxlength="4" data-stripe="cvc" class="form-control" id="name" placeholder="CVV">
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="hidden-xs col-sm-3 col-md-2 col-lg-2 control-label">Expiraci&oacute;n</label>
							<div class="col-xs-6 col-sm-3 col-sm-3 col-sm-3">
								<input type="text" size="2" maxlength="2" data-stripe="exp-month" class="form-control" id="ccmonth" placeholder="MM">
							</div>
							<div class="col-xs-6 col-sm-3 col-sm-3 col-sm-3">
								<input type="text" size="4" maxlength="4" data-stripe="exp-year" class="form-control" id="ccyear" placeholder="YYYY">
							</div>	
						</div>
						
						<hr/>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10 text-center">
								<button type="submit" class="btn btn-primary btn-lg">Recargar</button>
							</div>
						</div>
						 
						
					</form>
				</div>
				
				<!-- explanation of how to pay -->
	  			<div class="col-xs-12 col-sm-4 col-md-4">
	  				<p><b>Gracias por usar Apretaste!</b></p>
	  				<br/>
	  				<p><span class="badge">1</span> Empiece por escribir su correo electr&oacute;nico para que podamos mandarle un recibo, as&iacute; como la cantidad a agregar a Apretaste.</p>
	  				<p><span class="badge">2</span> Escriba el correo electr&oacute;nico de la persona a recargar, si esa persona es usted puede que sea el anterior. No esta seguro(a) de la direcci&oacute;n? No se preocupe, le advertiremos si la escribe incorrectamente.</p>
	  				<p><span class="badge">3</span> Inserte los detalles de su tarjeta de cr&eacute;dito y pague. No se preocupe, le devolveremos su dinero si cambia de idea. Solo d&iacute;ganos y le devolveremos al momento todo el credito que no halla usado, sin hacer preguntas.</p>
	  				<hr/>
	  				<p class="text-center">Si tiene dificultades recargando, o dudas, escribanos a <a href="mailto:soporte@apretaste.com">soporte@apretaste.com</a> y le ayudaremos al momento.</p>
	  			</div>
			</div>
		</div>
	</body>
</html>

