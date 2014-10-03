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
			ads_by_day: 'Ads by day',
			sep1: "-",
			sms: 'SMS',
			sep1: "-",
			raffles: "Raffles"
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
			sep3: "-",
			header_agencies: "Agencies",
			config_agency: "Browse agencies",
			config_agency_payments: "Payments",
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
	dispatchers: {
		caption: "Dispatchers",
		icon: "briefcase",
		submenu: {
			dispatchers: "List of dispatchers",
			dispatchers_reports: "{ico}chart_curve{/ico}&nbsp;Reports",
			dispatchers_payments: "{ico}money{/ico}&nbsp;Payments"
		}
	},
	tools: {
		caption: "Tools",
		icon: "wrench",
		submenu: {
			robot: "<span class="glyphicon glyphicon-send"></span> Simulator"
		}
	},
	agency: {
		caption: "Agency",
		icon: "shopping-cart",
		submenu: {
			agency: "<span class="glyphicon glyphicon-search"></span> Search customer",
			agency_recharge_list: "<span class="glyphicon glyphicon-usd"></span> Recharges today",
			agency_reports: "<span class="glyphicon glyphicon-signal"></span> Reports",
			agency_bill: "My bill"
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
							<li><a href="?path=admin&page={$_key}">{$value}</a></li>
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
				<a href="?path=admin&page={$_key}">{$value}</a>
			</li>
		$user.perms.access_to.{$_key}?
	$submenu?
	
[/$menu]
</ul>
{/strip}