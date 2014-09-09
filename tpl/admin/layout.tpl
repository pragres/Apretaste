{= space10: <div class="space_10">&nbsp;</div> =}
{= space15: <div class="space_15" style="margin-bottom: 15px;">&nbsp;</div> =}
{= space30: <div class="space_30" style="margin-bottom: 30px;">&nbsp;</div> =}
{= separatorLinks: <span class="separador-links" style="color: #A03E3B;">&nbsp;|&nbsp;</span> =}
{= hr: <hr style="border:1px solid #D0D0D0; margin:0px;"/> =}
{= h1: <div class="header_1"><font size="5" face="Arial" color="#52B439"><b> =}
{= _h1: </b></font><hr style="border:1px solid #D0D0D0; margin:0px;"/><font size="1" color="white"><div>&nbsp;</div></font></div> =}
{= h2: <div class="header_2"><font size="4" face="Arial" color="#52B439"><b> =}
{= _h2: </b></font><hr style="border:1px solid #D0D0D0; margin:0px;"/><font size="1" color="white"><div>&nbsp;</div></font></div> =}
{= p: <div class="paragraph" style="text-align: justify;"><div style="color:#444444;"> =}
{= _p: </div><font size="2" color="white"><div>&nbsp;</div></font></div> =}
{= br: <font class="space_small" size="2" color="white"><div>&nbsp;</div></font> =}
{= br2: <font class="space_medium" size="5" color="white"><div>&nbsp;</div></font> =}
{= br3: <font class="space_big" size="7" color="white"><div>&nbsp;</div></font> =}
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
	        
        			if ((keyCode < 48 || keyCode > 60) && keyCode != 8 && keyCode != 190 && keyCode != 39 && keyCode != 37 && keyCode != 46 && keyCode != 9
        			&& (keyCode < 96 || keyCode >105) && keyCode != 110 && keyCode != 13) 
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
		<style type="text/css">
		{ignore}
		@media only screen and (max-width: 600px) {
			#container {
				width: 100%;
			}
		}
		
		@media only screen and (max-width: 480px) {
			.button {
				display: block !important;
			}
			.button a {
				display: block !important;
				font-size: 18px !important; width 100% !important;
				max-width: 600px !important;
			}
			.section {
				width: 100%;
				margin: 2px 0px;
				display: block;
			}
			.phone-block {
				display: block;
			}
		}
		{/ignore}
		</style>
	</head>
<body>
	<div class="top-bar">
		<a href = "index.php?path=admin">Apretaste! - {$title}</a>
		?$div.session.user 
			?$user
			[[user 
			?$picture<img style= "float:right;" src="data:image/jpeg;base64,{$picture}" width="50"> 
			 $picture? 
			 user]]
			$user?
			<a style= "float:right; margin-top:-5x; margin-right: 10px;font-size:13px;" href="?path=admin&page=logout">Logout</a> 
		<br/>
		{% menu %}
		$div.session.user?
	</div>
	<div id = "page" ?$pagewidth style="margin:0 auto;width:{$pagewidth}px;" $pagewidth?>
		(( page ))
	</div>
</body>
</html>