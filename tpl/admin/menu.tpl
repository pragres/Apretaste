<br/>

{= menu:[
	{page: "dashboard", title: "Dashboard"},
	{page: "config", title: "Configurations"},
	{page: "users", title: "Users"},
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
	{page: "agency", title: "Agency"}
	
] 
=}

[$menu]<a class = "tab {?( "{$div.get.page}"=="{$page}" )?} tab-active {/?}" href="?path=admin&page={$page}">{$title}</a>[/$menu]