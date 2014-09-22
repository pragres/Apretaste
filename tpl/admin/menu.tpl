{= menu:{
	dashboard: {
		caption: "<i class="fa fa-dashboard fa-fw"></i>Dashboard",
		icon: false,
		submenu: {
			dashboard: "Home",
			sep1: "-",
			dashboard_visitors: 'Visitors',
			dashboard_unique_visitors: 'Unique visitors',
			dashboard_new_users: 'New users',
			dashboard_engagement: 'Engagement level',
			dashboard_bouncerate: 'Bounce rate',
			dashboard_source_of_traffic: 'Source of traffic',
			dashboard_service_usage: 'Service usage',
			dashboard_vip: 'VIP users'			
		}
	},
	service: {
		caption: 'Services',
		icon: 'globe',
		submenu: {
			dashboard_ads: 'Classified service',
			sms: 'SMS' 
		}
	},
	config: {
		caption: "Configurations",
		icon: "adjust",
		submenu: {
			config: "General options",
			sep1: "-",
			config_keywords: "Black list for keywords",
			config_whiteblack: "Black and white lists",
			config_agency: "Agencies",
			sep2: "-",
			mailboxes: "Mailboxes"
		}
	},	
	users: {
		caption: 'People',
		icon: "user",
		submenu: {
			users: "Admin users",
			user_activity: "User activity",
			address_list: "Address list"
		}
	},	
	ad: "Ads",
	raffles: "Raffles",
	dispatchers: {
		caption: "Dispatchers",
		submenu: {
			dispatchers: "List of dispatchers",
			dispatchers_reports: "{ico}chart_curve{/ico}&nbsp;Reports",
			dispatchers_payments: "{ico}money{/ico}&nbsp;Payments"
		}
	},
	robot: "Simulator",
	agency: "Agency",
	logout: "Logout"
} =}

<ul class="nav navbar-nav"> 
[$menu]
	
	?$user.perms.access_to.{$_key}
		{= access: true =}
	@else@
		{?( "{$user.user_role}" == "admin" )?}
			{= access: true =}
		@else@
			{= access: false =}
		{/?}
	$user.perms.access_to.{$_key}?
	
	{?( strpos("{$div.get.page}","{$_key}") === 0 )?} 
		{= active: 'active' =}
	@else@
		{= active: '' =}
	{/?}
	
	?$access
		?$submenu
			<li class=" dropdown {$active}" role="presentation">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					?$icon <span class="glyphicon glyphicon-{$icon}"></span> $icon? {$caption}<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				[$submenu]
					{?( '{$value}' == "-" )?}
						<li class="divider"></li>
					@else@
						<li><a href="?path=admin&page={$_key}">{$value}</a></li>
					{/?}
				[/$submenu]
				</ul>
			</li> 
		@else@
			<li class="{$active}" role="presentation">
				<a href="?path=admin&page={$_key}">{$value}</a>
			</li>
		$submenu?
	$access?
[/$menu]
</ul>