<!--{ another sections }-->
?$sections_groups
	[$sections_groups]
		?${$value}
			[${$value}]
				?$content
					<tr style="height: 35px;">
						<td bgcolor="#5DBD00" style = "color:black; padding-top: 4px; padding-bottom: 4px;">
							<h3 style = "{$element-h1}; margin-top: 5px; margin-bottom: 5px;{$font}">{$title}</h3>
						</td>
					</tr>
					<tr>
						<td style = "border-left: 3px solid #5DBD00;border-right: 3px solid #5DBD00;">
							<table style="{$font};margin-left:10px; margin-top: 5px; margin-bottom: 5px;"><tr><td style="margin:5px;">{$content}</td></tr></table>
						</td>
					</tr>
				$content?
			[/${$value}]
		${$value}?
	[/$sections_groups]
$sections_groups?

