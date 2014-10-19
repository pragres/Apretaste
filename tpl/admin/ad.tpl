{= title: Ad details =}
{= div.get.id: "" =}
{= path: "?q=ad" =}
{= pagewidth: 750 =}
{% layout %}

{{blocks

{%% form-block: {
	action: 'ad',
	method: 'get',
	fields:[
		{
			type: "hidden",
			id: "path",
			value: "admin"
		},{
			type: "hidden",
			id: "page",
			value: "ad"
		},{
			type: "text",
			label: "Type the ad ID",
			id: "id",
			value: $div.get.id
		}
	],
	submit: {
		caption: "Show",
		name: "btnShowAd"		 
	}
} %%}
blocks}}

{{page

		?$ad		
		[[ad
		{% ../alone/anuncio.tpl %}
		ad]] 
		<h1>Author</h1>
		<img src="data:image/jpeg;base64,{$ad.author-details.picture}" style="float:left;margin:5px;">
		{$ad.author-details.name}<br/>
		<a href="?path=admin&page=user_activity&user={$ad.author}">{html:ad.author}</a>

		@else@
			?$notfound
			<h1>Ad not found</h1>
			$notfound? 
		$ad?
page}}