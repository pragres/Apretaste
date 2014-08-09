{= title: Robot test =}
{= path: "index.php?path=admin&page=robot" =}
{% layout %}
 ?$responses
  <h2>HTML Responses ({$responses})</h2>
 [$responses]
 	<h3>Response #{$_order}</h3>
 	To: <b><a href="index.php?path=admin&page=user_actitivy&user={$to}">{$to}</a><br/>
 	{$responseHTML}
 	<br/>
 	<hr/>
 @empty@
 No response
 [/$responses]
 $responses?
 
?$logs
<h2>Logs</h2>
<div style="background:black;color:white;font-family:Lucida Console;padding:5px;">
{br:logs}
</div>
$logs?
 
<h2>Email client</h2>
<form action="{$path}" method="post">
<fieldset style ="margin:0 auto; width: 500px">
	<legend>Email client</legend>
	From: <br/>
	<input class="text" name="from" ?$div.post.from value ="{$div.post.from}" $div.post.from? ><br/>
	Subject: <br/>
	<input class="text" name="subject" ?$div.post.subject value ="{$div.post.subject}" $div.post.subject?><br/>
	Body: <br/>
	<textarea style="border: 1px solid gray;" name="body" rows="20" cols="40"></textarea><br/>
	<input type="submit" class="submit" value ="Send" name="btnSend">
</fieldset>
</form>