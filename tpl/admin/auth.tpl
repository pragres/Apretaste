<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Administration</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
<body>
<div id = "auth">
<img src="static/apretaste.logo.gif">
	<form action = "index.php?path=admin&page=auth" method = "post">
		?$error <span id = "message" class = "msg-error" style="float:right;">Access denied</span><br/><br/> $error?
		User:<br/> 
		<input class="text" name="user"><br/>
		Password:<br/>
		<input class="text" name="pass" type="password"><br/>
		<!--{ captcha }-->
	<br/>
	<!--{ {$captcha} }-->
	<br/>
		<input class="submit" type="submit" name="login" value="Login">
	</form>
</div>
</body>