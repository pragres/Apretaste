<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | {$title} </title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
		<script src="static/phpHotMap.js" type="text/javascript"></script>
<script src="static/jquery.min.js" type="text/javascript"></script>
<script src="static/jquery.cookie.js" type="text/javascript"></script>
<script type="text/javascript" src="static/apretaste.js"></script>
<script type="text/javascript" src="static/php_json.js"></script>
	</head>
<body>		

	<div class="top-bar">
		<a href = "index.php?path=admin">Apretaste! Administration Site</a>
		?$div.session.user 
		<a style= "float:right; margin-top:-5x; margin-right: 10px;" href="?path=admin&page=logout">Logout</a> 
		<br/>
		{% menu %}
		$div.session.user?
	</div>
	<div id = "page">
		(( page ))
	</div>
</body>
</html>