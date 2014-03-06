<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Apretaste!com | Configurations</title>
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>

	{= path: "?o=" =}
<div id = "page">
	<h2><a href = "admin.php">Apretaste!com</a> - Administration tool</h2>
		{% menu %}
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
	<div class = "box">
		<h3>Keywords blacklist ?$kwblacklist ({$kwblacklist}) $kwblacklist?</h3>
		<form action = ""  method = "post">
		<table>
		?$kwblacklist
			[$kwblacklist]
				<tr><td>{$value}</td><td><a href = "index.php?path=admin&page=config&o=del_kw_bl&data={$value}">Delete</a></td></tr>
			[/$kwblacklist]
		$kwblacklist?
			<tr><td><input class = "edit" name = "edtNewBlackKeyword"></td><td><input type = "submit" value = "Add" name = "btnAddBlackKeyword"></td></tr>
		</table>
		</form>
	</div>
	<div class = "box">
		<h3>Whitelist ?$whitelist ({$whitelist}) $whitelist?</h3>
		<form action = ""  method = "post">
		<table>
		?$whitelist
			[$whitelist]
				<tr><td>{$value}</td><td><a href = "index.php?path=admin&page=config&o=del_whitelist&data={$value}">Delete</a></td></tr>
			[/$whitelist]
		$whitelist?
			<tr><td><input  class = "edit"  name = "edtNewWhiteList"></td><td><input type = "submit" value = "Add" name = "btnAddWhiteList"></td></tr>
		</table>
		</form>
	</div>
	<div class = "box">
		<h3>Blacklist ?$blacklist ({$blacklist}) $blacklist?</h3>
		<form action = ""  method = "post">
		<table>
		?$blacklist
			[$blacklist]
				<tr><td>{$value}</td><td><a href = "index.php?path=admin&page=config&o=del_blacklist&data={$value}">Delete</a></td></tr>
			[/$blacklist]
		$blacklist?
			<tr><td><input  class = "edit"  name = "edtNewBlackList"></td><td><input type = "submit" value = "Add" name = "btnAddBlackList"></td></tr>
		</table>
		</form>
	</div>
	<div class = "box">
		<h3>Configuration</h3>
		<form action = ""  method = "post">
		<input type = "checkbox" name = "chkEnableHistorial" ?$chkEnableHistorial checked $chkEnableHistorial?>Enable historial<br><br>
		Price RegExp: <br><input  class = "edit regexp" type="text" name = "edtPriceRegExp" ?$edtPriceRegExp value ="{$edtPriceRegExp}" $edtPriceRegExp?><br><br>
		Phones RegExp: <br><input  class = "edit regexp"  type="text" name = "edtPhonesRegExp" ?$edtPhonesRegExp value = "{$edtPhonesRegExp}" $edtPhonesRegExp?><br><br>
		Subscribes:<br>
		Outbox max messages: <input type ="text" name = "edtOutboxmax" ?$edtOutboxmax value = "{$edtOutboxmax}"><br>
		<input type = "submit" value = "Update" name = "btnUpdateConfig">
		</form>
	</div>
	</div>
</body>