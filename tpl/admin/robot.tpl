{= title: Robot test =}
{= path: "index.php?path=admin&page=robot" =}
{% layout %}
<table width="100%">
<tr><td valign="top">
<h2>Email client</h2>
<form action="{$path}" method="post">
	From: <br/>
	<input class="text" name="from" ?$div.post.from value ="{$div.post.from}" $div.post.from? ><br/>
	Subject: <br/>
	<input class="text" name="subject" ?$div.post.subject value ="{$div.post.subject}" $div.post.subject?><br/>
	Body: <br/>
	<textarea name="body" rows="20" cols="50"></textarea><br/>
	<input type="submit" class="submit" value ="Send" name="btnSend">
</form>
 </td><td valign="top" align="center">
 ?$responses
  <h2>HTML Responses</h2>
 [$responses]
 	{$responseHTML}
 	<br/>
 	<hr/>
 @empty@
 No response
 [/$responses]
 $responses?
  </td></tr></table>
  
  ?$logs
<h2>Logs</h2>
<pre style="background:black;color:white;font-family:Lucida Console;">
{$logs}
</pre>
$logs?