{= title: "User activity" =}
{= path: "?path=admin&page=user_activity" =}
{% layout %}
{{page
{$h1}Search user{$_h1}
<form method="get" action="index.php">
	<input type="hidden" name = "path" value="admin">
	<input type="hidden" name = "page" value="user_activity">
	?$div.get.user
	<input class="text" name="user" value="{$div.get.user}">
	@else@
	<input class="text" name="user" value="">
	$div.get.user?
	<input style="padding:5px; border: 1px solid gray; cursor: pointer;" type="submit" value = "Search" name = "btnShowUser">
</form> 

		?$client
			{$h1}{$client.email}{$_h1}
			
			<table width="100%">
	<tr><td valign ="top" align="center">
	<img src="data:image/jpeg;base64,{$author.picture}"><br/>
	<span style="color: green; font-size: 26px;font-weight:bold;">${#client.credit:2.#}</span>
	</td>
	<td valign="top">
	[[author
		?$name Name: <b>{$name}</b> $name?<br/>
		?$birthdate {$p}Cumplea&ntilde;os: <b>{$birthdate}</b> {$_p} $birthdate?
		?$age {$p}Edad: <b>{$age} a&ntilde;os</b> {$_p} $age?
		?$ocupation {$p}Ocupaci&oacute;n: <b>{$ocupation}</b> {$_p} $ocupation?
		?$state {$p}Provincia/Estado: <b>{$state}</b> {$_p} $state?
		?$city {$p}Municipio/Ciudad: <b>{$city}</b> {$_p} $city?
		?$town {$p}Localidad/Reparto/Pueblo: <b>{$town}</b> {$_p} $town?
		?$sex {$p}Sexo: <b>{$sex}</b> {$_p} $sex?
		?$school_level {$p}Nivel de escolaridad: <b>{$school_level}</b> {$_p} $school_level?
		?$sentimental {$p}Situaci&oacute;n sentimental: <b>{$sentimental}</b> {$_p} $sentimental?
		?$hair {$p}Pelo: <b>{$hair}</b> {$_p} $hair?
		?$skin {$p}Piel: <b>{$skin}</b> {$_p} $skin?
		?$eyes {$p}Ojos: <b>{$eyes}</b> {$_p} $eyes?
		?$interest {$p}Intereses: <b>{$interest}</b> {$_p} $interest?
		?$friends <fieldset><legend>Friends</legend>
		[$friends]{$xname} (<a href="index.php?path=admin&page=user_activity&user={$xemail}">{$xemail}</a>)<br/>[/$friends]
		</fieldset>
		$friends?
	author]]
	</td>
	<td>
	<img src="index.php?path=admin&chart=user_messages_by_command&email={$author.email}" style="float:right;margin-top: -100px;">
	</td>
	</tr></table>

?$client.messages	
	{$h1}Last messages{$_h1}
	<table class="tabla">
	<tr><th>Message</th><th>Answer</th></tr>
	[$client.messages]
	<tr>
		<td>
			<a href="?path=admin&page=message&id={$id}">{$id}</a> - {$moment:0,16}<br/>
			<b>{$command}:</b>{$subject}
		</td>
		<td>
			{$answer_date:0,16} - {$answer_sender} - {?( {$answers} > 1 )?} {$answers} answers {/?}<br/>
			<b>{$answer_type}:</b> {$answer_subject}
		</td>
	</tr>
	[/$client.messages]
	</table>
$client.messages?
			
?$client.ads
	{$h1}Ads{$_h1}
	<table width="100%" class="tabla">
	<tr><th width="200">ID</th><th>Title</th><th>Post date</th><th>Image</th></tr>
	[$client.ads]
		<tr><td style="font-family:Courier"><a href="?path=admin&page=ad&id={$id}">{$id}</a></td>
		<td>{$title}</td>
		<td>{$post_date}</td>
		<td>?$image Yes @else@ No $image?</td>
		</tr>
	[/$client.ads]
	</table>
$client.ads?
			 
			 
			 ?$client.subscribes
			 {$h1}Subscribes{$_h1}
			 	<table width="100%" class="tabla">	
			 	<tr><th width="200">ID</th><th>Phrase</th><th>Last shipment</th></tr>
			 	[$client.subscribes]
			 	<tr><td style="font-family:Courier">{$id}</td>
			 	<td>{$phrase}</td>
			 	<td>{$last_alert:0.16}</td>
			 	</tr>
			 	[/$client.subscribes]
			 	</table>
			 $client.subscribes?
			 
			 ?$client.answers
			 {$h1}Other answers{$_h1}
			 	<table width="100%" class="tabla"><tr><th>ID</th><th>Moment</th><th>Sender</th><th>Type</th><th>Subject</th><th>Message</th>
			</tr>
			 	[$client.answers]
			 	<tr><td>{$id}</td>
			<td>{$send_date:0,16}</td>
			<td>{$xsender}</a></td>
			<td align="center">{$type}</td>
			<td align="center">{$subject}</td>
			<td><a href="?path=admin&page=message&id={$id}">{$message}</a></td>
			</tr>
			 	[/$client.answers]
			 	</table>
			 $client.answers? 
		$client? 
page}}