<br/>

{= menu:[
	{page: "dashboard", title: "Dashboard"},
	{page: "config", title: "Configurations"},
	{page: "mailboxes", title: "Mailboxes"},
	{page: "users", title: "People"},
	{page: "accusations", title: "Accusations"},
	{page: "tips", title: "Tips"},
	{page: "dictionary", title: "Dictionary"},
	{page: "address_list", title: "Address list"},
	{page: "user_activity", title: "User activity"},
	{page: "sms", title: "SMS"},
	{page: "subscribes", title: "Subscribres"},
	{page: "ad", title: "Ads"},
	{page: "raffles", title: "Raffles"},
	{page: "dispatchers", title: "Dispatchers"},
	{page: "robot", title: "Robot test"},
	{page: "agency", title: "Agency"}
	
] 
=}

[$menu]?$user.perms.access_to.{$page}<a class = "tab {?( strpos("{$div.get.page}","{$page}")===0 )?} tab-active {/?}" href="?path=admin&page={$page}">{$title}</a>$user.perms.access_to.{$page}?[/$menu]