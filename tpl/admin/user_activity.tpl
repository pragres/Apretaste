{= title: '<span class="glyphicon glyphicon-user"></span> User activity' =}
{= path: "?q=user_activity" =}

{% layout %}

{{blocks
?$client
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">{$client.email}</h3>
		</div>
		<div class="panel-body">
			<img src="data:image/jpeg;base64,{$author.picture}"><br/>
			<span style="color: green; font-size: 18px;font-weight:bold;">${#client.credit:2.#}</span><br/>

			[[author
				?$name Name: <b>{$name}</b> $name?<br/>
				?$birthdate Cumplea&ntilde;os: <b>{$birthdate}</b> <br/> $birthdate?
				?$age Edad: <b>{$age} a&ntilde;os</b> <br/> $age?
				?$ocupation Ocupaci&oacute;n: <b>{$ocupation}</b> <br/> $ocupation?
				?$state Provincia/Estado: <b>{$state}</b> <br/> $state?
				?$city Municipio/Ciudad: <b>{$city}</b> <br/> $city?
				?$town Localidad/Reparto/Pueblo: <b>{$town}</b> <br/> $town?
				?$sex Sexo: <b>{$sex}</b> <br/> $sex?
				?$school_level Nivel de escolaridad: <b>{$school_level}</b> <br/> $school_level?
				?$sentimental Situaci&oacute;n sentimental: <b>{$sentimental}</b> <br/> $sentimental?
				?$hair Pelo: <b>{$hair}</b> <br/> $hair?
				?$skin Piel: <b>{$skin}</b> <br/> $skin?
				?$eyes Ojos: <b>{$eyes}</b> <br/> $eyes?
				?$interest Intereses: <b>{$interest}</b> <br/> $interest?
				?$friends <fieldset style="max-height: 200px;overflow:auto;"><legend>Friends</legend>
				[$friends]{$xname} (<a href="index.php?path=admin&page=user_activity&user={$xemail}">{$xemail}</a>)<br/>[/$friends]
				</fieldset>
				$friends?
			author]]
		</div>
	</div>
$client?

{%% form-block: {
	id: "frmSearchUser",
	action: "index.php",
	method: "get",
	title: "Search an user",
	modal: $div.get.user,
	fields: [
		{
			type: "hidden",
			id: "q",
			value: "user_activity"
		},{
			type: "text",
			id: "user",
			value: $div.get.user
		}
	],
	submit: {
		name: "btnShow",
		caption: "Search"
	}
} %%}

blocks}}
{{page
?$client

	{%% table: {
		data: $client.messages,
		title: "<span class="glyphicon glyphicon-envelope"></span> Last messages",
		hideColumns: {author: true, extra_data: true, xmailer: true, email_client: true, command: true, subject: true, moment: true, answer_sender: true, answer_type: true, answers: true, answer_subject: true, announcement: true,addressee:true},
		headers: {
			id: "Message",
			answer_date: "Answer"
		},
		wrappers: {
			id: '<a href="?path=admin&page=message&id={$id}">{$id}</a> - {$moment:0,16}<br/>
			<b>{$command}:</b>{$subject} ?$announcement <br/><a href="?q=ad&id={$announcement}" title="View the related ad"><span class="glyphicon glyphicon-bullhorn"></span></a>$announcement?',
			answer_date: '{$answer_date:0,16} - {$answer_sender} - {?( {$answers} > 1 )?} {$answers} answers {/?}<br/>
			<b>{$answer_type}:</b> {$answer_subject}'
		}	
	} %%}
				
?$client.ads
	<h2>Ads</h2>
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
			<h2>Subscribes</h2>
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
			 <h2>Other answers</h2>
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