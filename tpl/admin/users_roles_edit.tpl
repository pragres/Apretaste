{= path: "index.php?path=admin&page=users_roles_edit&user_role={$div.get.user_role}" =}
{= title: Editing role '{$div.get.user_role}' =}
{= pagewidth: 640 =}
{% layout %}

{{page
	{% users_panel %}
	<form action="{$path}" method="post">
		Role: <br/>
		<input class = "text" name="edtRole" value="{$role.user_role}"><br/><br/>
		Default page:<br/>
		<select name="edtDefaultPage" class="text"><br/>
		[$pages]
			<option value="{$value}" {?( "{$value}" == "{$role.default_page}" )?} selected {/?}>{$value}</option>
		[/$pages]
		</select>
		<br/><br/>
		Access to: <br/>
		<div class="box" style="height: 200px;overflow:auto;width: 300px;">
		[$pages]
			<input type="checkbox" name="chkAccessTo[]" value="{$value}" class="checkbox" 
			{?( strpos(" {$role.access_to} "," {$value} ") !==false )?} checked {/?} > {$value}<br/>
		[/$pages]
		</div>
		<br/><br/>
		<input type="submit" name="btnEditRole" class="submit" value="Ok">
		<a class="button" href="index.php?path=admin&page=users_roles">Cancel</a>
	</form>
page}}