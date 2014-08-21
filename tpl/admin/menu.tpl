<br/>

{= menu:{
	dashboard: "Dashboard",
	config: "Configurations",
	mailboxes: "Mailboxes",
	users: "People",
	address_list: "Address list",
	user_activity: "User activity",
	sms: "SMS",
	ad: "Ads",
	raffles: "Raffles",
	dispatchers: "Dispatchers",
	robot: "Robot test",
	agency: "Agency"	
} =}

<?
foreach($menu as $key => $value) 
	if (isset($user['perms']['access_to'][$key]) || $user['user_role'] == 'admin')
		echo '<a class = "tab'.($div['get']['page']==$key?' tab-active ':'').' " href="?path=admin&page='.$key.'">'.$value.'</a>';
?>
