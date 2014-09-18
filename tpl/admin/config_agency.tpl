{= title: Agencies =}
{= path: "index.php?path=admin&page=config_agency" =}
{% layout %}

{{blocks
	{%% form-block: {
		action: "config_agency",
		title: "Adjust percents",
		fields: [
			{
				id: "edtProfit",
				value: "{$edtProfit}",
				label: "Sold",
				type: "text",
				class: "number"	,
				placeholder: "Type the sold %"				
			},{
				id: "edtResidualProfit",
				value: "{$edtResidualProfit}",
				type: "text",
				label: "Residual",
				class: "number",
				placeholder: "Type the residual %" 
			}
		],
		submit: {
			name: "Update agency",
			caption: "Update" 
		}
	} %%}
	<br/>
	{%% form-block: {
		action: "config_agency",
		title: "Agency percents",
		fields: [
			{
				id: "cboAgencyPercents",
				label: "Agency",
				type: "select",
				options: "agency_percents",
				value: '{$id}', 
				text: '{$name} ((# {$profit_percent} *100:2. #)% | (# {$residual_percent}*100:2.#)%)' 
			},
			{
				id: "edtAgencyProfitPercent",
				label: "Sold",
				type: "text",
				class: "number",
				placeholder: "Type the sold %",
				help: "The profit percent to give by agency"
			},{
				id: "edtAgencyResidualPercent",
				type: "text",
				label: "Residual",
				class: "number",
				placeholder: "Type the residual %" 
			}
		],
		submit: {
			name: "btnUpdateAgencyPercents",
			caption: "Update"
		}
	} %%}
blocks}}

{{page
	<div class="panel panel-success" style="width: 90%; margin: auto;">
	<div class="panel-heading"> <h3 class="panel-title">Agencies</h3>
	</div> 
	<div class="panel-body">
	<div class="table-responsive">
	<table class="table table-hover">
	<tr>
	<th><a href="{$path}&orderby=name">Name</a></th>
	<th><a href="{$path}&orderby=phone">Phone</a></th>
	<th><a href="{$path}&orderby=credit_line">Credit</a></th>
	<th><a href="{$path}&orderby=sold">Sold</a></th>
	<th><a href="{$path}&orderby=residual">Residuals</a></th>
	<th><a href="{$path}&orderby=owe">Owe</a></th></tr>
	?$agencies
	[$agencies]
	<tr><td>{$name}</td><td>{$phone}</td><td>${#credit_line:2.#}</td><td align="right">${#sold:2.#}</td><td align="right">${#residual:2.#}</td><td align="right">${#owe:2.#}</td></tr>
	[/$agencies]
	$agencies?
	</table>
	</div>
	<button class="btn btn-primary btn-lg" onclick="$('#myModal').modal('show');">New agency</button> 
	</div>
	</div>		
page}}
<!-- Modal --> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<form role="form" action="index.php?path=admin&page=config_add_agency" method="post">
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="myModalLabel">Add new agency</h4>
				</div>
				<div class="modal-body"> 
					
					Name: <br/>
					<input class= "text" name="edtName"><br/>
					Phone: <br/>
					<input class="text" name="edtPhone"><br/>
					Credit line: <br/>
					<input class="number" name="edtCreditLine"><br/>
					Address: <br/>
					<input class="text" name="edtAddress"><br/>
					<fieldset>
						<legend>Adjust percents</legend>
						Sold: <input class="number" name="edtProfitPercent"> Residual: <input class="number" name="edtResidualPercent">
					</fieldset>
				</div> 
				<div class="modal-footer"> 
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel </button> 
					<input type="submit" class="btn btn-primary" name="btnAddAgency" value="Add"> 
				</div> 
			</form>
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>