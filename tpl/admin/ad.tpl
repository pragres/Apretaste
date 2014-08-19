{= title: Ad details =}
{= div.get.id: "" =}
{= path: "?path=admin&page=ad" =}

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
		<h1><i>{$ad.title}</i> of <a href="?path=admin&page=user_activity&user={$ad.author}">{html:ad.author}</a></h1>
		<p>
			<table width="100%">
			<tr><td><img width="200" src="index.php?path=ad_image&id={$ad.id}&resized=200"></td>
			<td valign="top"><table>
			<tr><td width="250" align="right"><b>Body:</b></td><td> {$ad.body} </td></tr>
			<tr><td width="250" align="right"><b>Post date:</b></td><td> {$ad.post_date} </td></tr>
			</table>
			</td></tr>
			<!--{
			[$ad]
			<tr><td width="250" align="right"><b>{$_key}:</b></td>
			<td> {$value} </td></tr>
			[/$ad] }-->
			</table>
		</p>
		@else@
			?$notfound
			<h1>Ad not found</h1>
			$notfound? 
		$ad?
page}}