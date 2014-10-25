{= path: "?q=config_agency_bill&agency={$div.get.agency}" =}
{= title: <span class="glyphicon glyphicon-list-alt"></span> Agency bill =}
{= pagewidth: 1024 =}

{% layout %}

{% agency_bill: {
	from: '<!--{ begin }-->',
	to: '<!--{ end }-->'
} %}