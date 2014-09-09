{= title: Ad details =}
{= div.get.id: "" =}
{= path: "?path=admin&page=ad" =}
{= pagewidth: 750 =}
{% layout %}

{{page
		{% ad_panel %}
		<form method="get" action="index.php">
			<input type="hidden" name = "path" value="admin">
			<input type="hidden" name = "page" value="ad">
			Type the ad ID: <input class="text" name="id" value="{$div.get.id}">
			<input class="submit" type="submit" value = "Show" name = "btnShowAd">
		</form>
				
		?$ad		
		[[ad
		{% ../alone/anuncio.tpl %}
		ad]] 
		{$h1}Author{$_h1}
		<img src="data:image/jpeg;base64,{$ad.author-details.picture}" style="float:left;margin:5px;">
		{$ad.author-details.name}<br/>
		<a href="?path=admin&page=user_activity&user={$ad.author}">{html:ad.author}</a>

		@else@
			?$notfound
			<h1>Ad not found</h1>
			$notfound? 
		$ad?
page}}