{include file='header.tpl'}

{literal}
<style>
  
table td, table th {
    width: 50px !important;
	 overflow-wrap: anywhere;
}
</style>
{/literal}

<div class="row" id="div_print">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<!-- <div class="title-bar blue"> -->
			<div class="title-bar success">
				<h4>EXISTING SMART IDEA DETAILS</h4>
			</div>
			<!-- Title Bart End -->
			<div class="inner no-radius table-responsive">
				<table class="table table-striped table-bordered table-hover table-full-width" id="data-table" >
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;text-align: center;">
							<th style="text-align: center;width:4px !important;">SR.NO</th>
							<th style="text-align: center;width:6px !important;">CITIZEN NAME</th>
							<th style="text-align: center;width:6px !important;">MOBILE NO</th>
							<th style="">EMAIL ID</th>
							<th style="">ADDRESS</th>
							<th style="">DESCRIPTION</th>
							<th style="text-align: center;width:6px !important;">CREATED ON</th>
							<!--<th>Delete</th>-->
						</tr>
					</thead>

					<tbody>
						{foreach from=$ideas_list item=row key=id}
							<tr align="center1">
								<td style="width:4px !important;text-align: center;">{counter} </td>
								<td style="text-align: center;width:6px !important;">{$row.name}- {$row.id} </td>
								<td style="text-align: center;width:6px !important;">{$row.mobile}</td>
								<td>{$row.email}</td>
								<td>{$row.address}</td>
								<td>{$row.idea_desc}</td>
								<td style="text-align: center;width:6px !important;">{$row.ts}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<br><br>

{include file='footer_print.tpl'}
{include file='footer.tpl'}