{include file='corp_header.tpl'}

{literal}

<style>
	.bash_heading {
		border-top: 1px solid #D5DDDF;
		text-align: left;
		padding: 10px !important;
		background-color: #fff;
		clear: both;
		font-weight: bold;
		font-size: 16x;
		color: #000;
	}
</style>

<script>
	function get_dists(rdmaid) {
		$.post('ajax_getdists.php', {
			rdmaid: rdmaid
		}, function(data) {
			$("#distid").html(data);
		});
	}


	function get_ulbs(distid) {
		$.post('ajax_getulbs.php', {
			distid: distid
		}, function(data) {
			$("#ulbid").html(data);
		});
	}
</script>

{/literal}

<!-- Breadcrumbs Start -->

<!-- Breadcrumbs End -->




<!--
  
  <form action="cdma_ulbwise_report1.php" method="POST">
      <input type="hidden" name="app_type_id" value="{$app_type_id}">
  <div>
<div class="col-md-3">
<div class="form-group">
    
  <label  for="selectbasic">Select status</label>
  <div>
    <select id="status" name="status" class="form-control" >
     <option value="">---select---</option>
     {html_options options=$status_desc selected=$status}
    </select>
  </div>
</div>
</div>



<div class="form-group">
<input style="margin-top:25px;" type="submit" name="search1" value="Search" class="btn btn-success">
</div>
</div>
  
  </form>
  -->

<div class="row" id="div_print">
	<div class="col-lg-12">
		<div class="boxed">
			<!-- Title Bart Start -->
			<div class="title-bar white d-flex justify-content-between align-items-center">
				<h4>ORIGIN WISE REPORT</h4>
				
				<a href="ajax_corp_dashboard.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
					
			</div>
			<!-- Title Bart End id="data-table"-->
			<div class="inner no-radius table-responsive">
				<input type="hidden" name="ulbid" value="{$ulbid}">
				<input type="hidden" name="app_type_id" value="{$app_type_id}">
				<input type="hidden" name="origin_id" value="{$origin_id}">
				<table class="display table-bordered table-striped table-condensed cf" id="data-table">
					<thead>
						<tr style="background-color:#2c3e50; color:#FFF;">
							<td>SR.No</td>
							<td></td>
							<!--<td  align="center">{$apptypes[$app_type_id]} ({$status_desc[$status]})</td>-->
							<td>TOTAL COUNT</td>
						</tr>






					</thead>

					<tbody>

						{foreach from=$ulb_list key=ulbid item=row}
						<tr align="center">
							<td valign="middle">{counter}</td>
							<td valign="middle">{$ulb_list[$ulbid]}</td>
							<td valign="middle">{if $data[$ulbid].count neq ''}<a href="corp_cat_origin.php?ulbid={$ulbid}&app_type_id={$app_type_id}&originid={$origin_id}" target="_blank">{$data[$ulbid].count} </a>{else}-{/if}</td>

							<!--15-06-2024 <td><a href="corp_cat_origin.php?ulbid={$ulbid}&originid={$origin_id}" target="_blank">{$data[$ulbid].count}</a></td> -->
						</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr style="background-color:#b5f2ea;" align="center">
							<td colspan="2"><b>Total</b></td>
							<td><b>{if $tot eq ''} 0 {else}{$tot}{/if}</b></td>
						</tr>
					</tfoot>


				</table>
			</div>
		</div>
	</div>
</div>
{include file='footer_print.tpl'}
{include file='corp_footer.tpl'}