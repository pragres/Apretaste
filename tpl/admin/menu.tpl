{strip}
<!--{ Apretaste! admin menu }-->
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
			header_1: 'Classified service',
			dashboard_ads: 'Dashboard',
			ad: 'View an ad',
			accusations: 'Accusations',
			tips: 'Tips',
			dictionary: 'Dictionary',
			subscribes: 'Subscribes',
			ads_by_day: 'Ads by day',
			sep1: "-",
			sms: 'SMS',
			sep1: "-",
			raffles: "Raffles"
		}
	},
	config: {
		caption: "Setup",
		icon: "adjust",
		submenu: {
			config: "General options",
			sep1: "-",
			header_1: 'Classified service',
			config_keywords: "Black list for keywords",
			sep2: "-",
			mailboxes: "Mailboxes"
		}
	},	
	users: {
		caption: 'People',
		icon: "user",
		submenu: {
			header_1: "Admin page",
			users: "Admin users",
			users_roles: "Admin roles",
			sep1: "-",
			header_2: "Apretaste users",
			user_activity: "User activity",
			address_list: "Address list",
			config_whiteblack: "Black and white lists"
		}
	},
	dispatchers: {
		caption: 'Money',
		icon: "briefcase",
		submenu: {
			header_1: "Sellers",
			dispatchers: '<span class="glyphicon glyphicon-briefcase"></span> Browse sellers',
			dispatchers_reports: '<span class="glyphicon glyphicon-stats"></span>&nbsp;Reports',
			dispatchers_payments: '<i class="fa fa-money fa-fw"></i> Payments',
			sep3: "-",
			header_agencies: "Agencies",
			config_agency: "<span class="glyphicon glyphicon-shopping-cart"></span> Browse agencies",
			config_agency_payments: "<i class="fa fa-money fa-fw"></i> Payments",
		}
	},
	tools: {
		caption: "Tools",
		icon: "wrench",
		submenu: {
			robot: "<span class="glyphicon glyphicon-send"></span> Simulator",
			queries: "DB Query tool"
		}
	},
	agency: {
		caption: "Recharges",
		icon: "shopping-cart",
		submenu: {
			agency: '<span class="glyphicon glyphicon-search"></span> Search & Recharge',
			agency_recharge_list: '<span class="glyphicon glyphicon-th"></span> Recharges today',
			agency_reports: '<span class="glyphicon glyphicon-stats"></span> Reports',
			agency_bill: '<span class="glyphicon glyphicon-list"></span> My bill'
		}
	},
	logout: "Logout"
} =}
<ul class="nav navbar-nav"> 
[$menu]
	?$submenu
		?$user.perms.access_to.{$_key}
			<li class=" dropdown {$active}" role="presentation">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					?$icon <span class="glyphicon glyphicon-{$icon}"></span> $icon? {$caption}<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				[$submenu]
					{?( '{$value}' == "-" )?}
						<li class="divider"></li>
					@else@
						{?( strpos("{$_key}", "header_") === 0 )?}
							<li role="presentation" class="dropdown-header">{$value}</li>
						@else@
							<li><a href="?q={$_key}">{$value}</a></li>
						{/?}
					{/?}
				[/$submenu]
				</ul>
			</li> 
		$user.perms.access_to.{$_key}?
	@else@
		?$user.perms.access_to.{$_key}
			{?( strpos("{$div.get.page}","{$_key}") === 0 )?} 
				{= active: 'active' =}	
			@else@
				{= active: '' =}
			{/?}
			<li class="{$active}" role="presentation">
				<a href="?q={$_key}">{$value}</a>
			</li>
		$user.perms.access_to.{$_key}?
	$submenu?
	
[/$menu]
</ul>
{/strip}