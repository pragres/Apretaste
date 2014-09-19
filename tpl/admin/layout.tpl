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
{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste! ?$title {$title} $title?</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<!--{ <link href="static/admin.css" rel="stylesheet"></link> }-->
		<script src="static/phpHotMap.js" type="text/javascript"></script>
		<script src="static/jquery.min.js" type="text/javascript"></script>
		<script src="static/jquery.cookie.js" type="text/javascript"></script>
		<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"></link>
		<link href="static/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"></link>
		<link href="static/bootstrap/css/datepicker.css" rel="stylesheet"></link>
		<link href="static/timeline.css" rel="stylesheet">
		<link href="static/metisMenu/metisMenu.min.css" rel="stylesheet">
		<link href="static/morris.css" rel="stylesheet">
		<link href="static/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
		<script type="text/javascript" src="static/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="static/bootstrap/js/bootstrap-modal.js"></script>
		<script type="text/javascript" src="static/bootstrap/js/bootstrap-tooltip.js"></script>
		<script type="text/javascript" src="static/bootstrap/js/bootstrap-popover.js"></script>
		<script type="text/javascript" src="static/bootstrap/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="static/metisMenu/metisMenu.min.js"></script>
		<script type="text/javascript" src="static/flot/excanvas.min.js"></script>
		<script type="text/javascript" src="static/flot/jquery.flot.js"></script>
		<script type="text/javascript" src="static/flot/jquery.flot.pie.js"></script>
		<script type="text/javascript" src="static/flot/jquery.flot.resize.js"></script>
		<script type="text/javascript" src="static/flot/jquery.flot.tooltip.min.js"></script>
		<script type="text/javascript" src="static/morris/raphael.min.js"></script>
		<script type="text/javascript" src="static/morris/morris.min.js"></script>
		<script type="text/javascript" src="static/php_json.js"></script>
		<script type="text/javascript" src="static/php_string.js"></script>
		<script type="text/javascript">
			{ignore}
			function isset(v) {
				return typeof v !== 'undefined';
			}
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
		.flot-chart-content {
			width: 100%;
			height: 100%;
		}

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
		
		body{
			margin-top: 50px;
		}
		
		{/ignore}
		</style>
		
		(( head ))
	</head>
<body onload="(( onload ))">
		?$user
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation"> 
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button> 
				<a class="navbar-brand" href="index.php?path=admin">Apretaste!</a> 
			</div>
			<div class="collapse navbar-collapse" id="example-navbar-collapse">
			?$menu
				{$menu}
			@else@
				{% menu %}
			$menu?
			</div>
		</nav>
		$user?
		
	<div class="top-bar">
		?$div.session.user 
			?$user
			[[user 
			?$picture
			<img style= "z-index: 9999; position: fixed; right: 5px; top: 5px;" src="data:image/jpeg;base64,{$picture}" height="40"> 
			 $picture? 
			 user]]
			$user?
		$div.session.user?
	</div>
	
	<div class="container">
		<div class="row">
		(( headerup ))
		</div>
		<div class="row">
			
			<div class="col-md-12">
			?$title <h1>{$title}</h1> $title?
			</div>
			
		</div>
		<div class="row">
		(( headerdown ))
		</div>
		<div class="row">
			<div class="col-md-3">
			(( blocks ))
			</div>
			<div class="col-md-9">
			(( page ))
			</div>
		</div>
	</div>
	</body>
</html>