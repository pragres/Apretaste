<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | {$title} </title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
		<script src="static/phpHotMap.js" type="text/javascript"></script>
		<script src="static/jquery.min.js" type="text/javascript"></script>
		<script src="static/jquery.cookie.js" type="text/javascript"></script>
		<script type="text/javascript" src="static/php_json.js"></script>
		<script type="text/javascript" src="static/php_string.js"></script>
		<script type="text/javascript">
			{ignore}
			$(function(){
				$(".number").keydown(function(e){
        			var value = e.value;
        			var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
	        
        			if ((keyCode < 48 || keyCode > 60) && keyCode != 8 && keyCode != 190 && keyCode != 39 && keyCode != 37 && keyCode != 46 && keyCode != 9) 
            			return false;
        
        			if (strpos(value, '.') != false && keyCode == 190) 
            			return false;
        
        			return true;
    			});
    		{/ignore}
    		
    		(( jquery ))
    		
    		{ignore}		
			});
    		{/ignore}
		</script>
	</head>
<body>
	<div class="top-bar">
		<a href = "index.php?path=admin">Apretaste! - {$title}</a>
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