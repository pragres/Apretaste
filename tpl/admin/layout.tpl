{strip}
{= months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] =}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste! ?$title {txt}{$title}{/txt} $title?</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<!--{ <link href="static/admin.css" rel="stylesheet"></link> }-->
		<script src="static/phpHotMap.js" type="text/javascript"></script>
		<script src="static/jquery.min.js" type="text/javascript"></script>
		<script src="static/jquery.cookie.js" type="text/javascript"></script>
		<link href="static/bootstrap/css/datepicker.css" rel="stylesheet"></link>
		<link href="static/timeline.css" rel="stylesheet">
		<link href="static/metisMenu/metisMenu.min.css" rel="stylesheet">
		<link href="static/morris.css" rel="stylesheet">
		<link href="static/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
		<link href="static/admin.css" rel="stylesheet"></link>
		<link href="static/dataTables.bootstrap.css" rel="stylesheet"></link>
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
		<script src="static/dataTables/jquery.dataTables.js"></script>
		<script src="static/dataTables/dataTables.bootstrap.js"></script>
		<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"></link>
		<link href="static/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"></link>
		<script type="text/javascript" src="static/bootstrap-window/bootstrap-window.min.js"></script>
		<link href="static/bootstrap-window/bootstrap-window.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="static/highlight.js"></script>
		<link rel="stylesheet" href="static/github.css"></link>

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
				
		{/ignore}
		</style>
		
		(( head ))
	</head>
	<body onload="(( onload ))">
	
		?$user
		<nav class="navbar navbar-default" role="navigation"> 
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button> 
				<a class="navbar-brand" style="padding: 5px;" href="{$path}">?$div.session.user 
			?$user
			[[user 
			?$picture
			<img src="data:image/jpeg;base64,{$picture}" height="40" style="margin: 0px;padding: 0px;"> 
			 $picture? 
			 user]]
			$user?
		$div.session.user? Apretaste!</a> 
			</div>
			<div class="collapse navbar-collapse" id="example-navbar-collapse">
				{$menu}
			</div>
		</nav>
		$user?
	
	<div class="container">
		<div class="row">
		(( headerup ))
		</div>
		<div class="row">
			<div class="col-md-12">
			?$title <h3>{$title}</h3> $title?
			</div>
		</div>
		<div class="row">
			?$msg
			<div class="col-md-12">
				<div class="alert alert-{$msg-type} alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button> 
					{$msg}
				</div>
			</div>
			$msg?
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
		<div class="row">
			<div class="col-md-12">
			(( footer ))
			</div>
		</div>
	</div>
	</body>
</html>
{/strip}