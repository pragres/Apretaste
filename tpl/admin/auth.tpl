{= title: Apretaste! Administration =}
{% layout %}
{{page
	
	<form action = "index.php?path=admin&page=auth" method = "post">
	<p align="center">
		?$error <span id = "message" class = "msg-error" style="float:right;">Access denied</span><br/><br/> $error?
		User:
		<input class="text" name="user"><br/><br/>
		Pass:
		<input class="text" name="pass" type="password"><br/>
		<br/>
		<input style="float:none;" class="submit" type="submit" name="login" value="Login">
	</p>
	</form>
	
page}}