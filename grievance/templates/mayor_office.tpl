{include file='header.tpl'}
<style>
	/* Your regular styles go here */

	@media (max-width: 768px) {

		.cap_font center {
			font-size: 11px;
		}
	}
</style>

<div id="div_print" class="cap_font" style="border:#999999 0px solid;">
	<input type="hidden" name="ulbid" value="{$ulbid}">
	<input type="hidden" name="app_type_id" value="{$app_type_id}">
	<input type="hidden" name="origin_id" value="{$origin_id}">
	<input type="hidden" name="status" value="{$status}">
	<!--15-06-2024 <CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER> -->
	<!--15-06-2024 <div class="cap_font" style="text-align:center;padding-top: 5px;padding-bottom: 5px;font-size:16px;">
		<caption style="caption-side:top;">
			<b>
				{if $origin_id eq '0' }
				<CENTER><strong>VIEW {if $app_type_id eq '1'} FROM ALL SOURCES COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
				{elseif $origin_id eq '2'}
				<CENTER><strong>VIEW {if $app_type_id eq '1'} RECEIVED VIA CALL COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

				{elseif $origin_id eq '3'}
				<CENTER><strong>VIEW {if $app_type_id eq '1'} CFC CENTERS/ZONE OFFICES/ HEAD OFFICE COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

				{elseif $origin_id eq '4'}
				<CENTER><strong>VIEW {if $app_type_id eq '1'} APP MY NAGPUR MOBILE APPLICATION COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

				{elseif $origin_id eq '7'}
				<CENTER><strong>VIEW {if $app_type_id eq '1'} ENDORSED BY COMMISSIONER ACCEPTED/COMMITTED BY COMMISSIONER COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>


				{elseif $origin_id eq '8'}
				<CENTER><strong>VIEW {if $app_type_id eq '1'} GARDEN COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

				{else}
				<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINT {else} SERVICE{/if} DETAILS</strong></CENTER>
				{/if}
			</b>
		</caption>
	</div> -->

	<ul class="navs nav-tabs panel-info" style="background-color: #ccf4ff;">
		<!--<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Category Wise</a></li>
		<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Date Wise</a></li>
		<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">ULB wise</a></li>-->
	</ul>


	<div class="tab-content">
		<div class="tab-pane" id="tab_3">
			<!--<table class="table table-striped table-bordered table-hover table-full-width"  id="data-table" width="100%">
				<thead>
					
					<tr style="background-color:#2c3e50; color:#FFF;">
						<th>S.No</th>
						<th>Ulbname</th>
						{foreach from=$status_list item=row key=status_id}
						<th>{$status_list[$status_id]}</th>
						{/foreach}
						
					
					</tr>
				</thead>
				<tbody>			
					{foreach from=$ulb_list item=row key=ulbid_id}
						<tr>
							<td>{counter}</td>
							<td>{$ulb_list[$ulbid_id]}</td>
							{foreach from=$status_list item=row2 key=status_id}
							<td>{$data5[$ulbid_id][$status_id].count}</td>
							{/foreach}
							
							
		
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">Total</td>
							{foreach from=$status_list item=row2 key=status_id}
						<td>{$data5[$status_id].total}</td>
						{/foreach}
					</tr>
				</tfoot>
			</table>-->
		</div>

		<div class="tab-pane active table-responsive">

			<table width="97%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="data-table">
				<caption style="caption-side:top;text-align:center;padding-top: 10px;padding-bottom: 10px;font-size:16px;">
					<b>
						{if $origin_id eq '0' }
						<CENTER><strong>VIEW {if $app_type_id eq '1'} FROM ALL SOURCES COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
						{elseif $origin_id eq '2'}
						<CENTER><strong>VIEW {if $app_type_id eq '1'} RECEIVED VIA CALL COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

						{elseif $origin_id eq '3'}
						<CENTER><strong>VIEW {if $app_type_id eq '1'} CFC CENTERS/ZONE OFFICES/ HEAD OFFICE COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

						{elseif $origin_id eq '4'}
						<CENTER><strong>VIEW {if $app_type_id eq '1'} APP MY NAGPUR MOBILE APPLICATION COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

						{elseif $origin_id eq '7'}
						<CENTER><strong>VIEW {if $app_type_id eq '1'} ENDORSED BY COMMISSIONER ACCEPTED/COMMITTED BY COMMISSIONER COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>


						{elseif $origin_id eq '8'}
						<CENTER><strong>VIEW {if $app_type_id eq '1'} GARDEN COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

						{else}
						<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINT {else} SERVICE{/if} DETAILS</strong></CENTER>
						{/if}
					</b>
				</caption>
				<thead>
					<tr style="background-color:#2c3e50; color:#FFF;">
						<!--15-05-2024 <th align="center" valign="middle">SR.No</th>
						<th align="center" valign="middle">Category</th>
						<th align="center" valign="middle">Pending for Approval</th>
						<th align="center" valign="middle">Under progress</th>
						<th align="center" valign="middle">completed</th>
						<th align="center" valign="middle">Total</th> -->

						<th align="center" valign="middle" style="width: 50px; text-align: center; vertical-align: middle;">SR.No</th>
						<th align="center" valign="middle" style="width: 400px; text-align: center; vertical-align: middle;">CATEGORY</th>
						<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">PENDING FOR APPROVAL</th>
						<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">UNDER PROGRESS</th>
						<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">COMPLETED</th>
						<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">TOTAL</th>
					</tr>
				</thead>
				{assign var="i" value="1"}
				{foreach from=$cs_list key=cs_id item=row}
				<tr>
					<td align="center" valign="middle">{$i}</td>
					<td>{$cs_list[$cs_id]}</td>
					<td align="center" valign="middle">{if $data2[$cs_id].pendingforapproval neq ''}<a href="origin.php?ulbid={$ulbid}&originid={$origin_id}&cat3_id={$cs_id}&grievance_status_id=1" target="_blank">{$data2[$cs_id].pendingforapproval} </a>{else}-{/if}</td>
					<td align="center" valign="middle">{if $data2[$cs_id].pending neq ''}<a href="origin.php?ulbid={$ulbid}&originid={$origin_id}&cat3_id={$cs_id}&grievance_status_id=2" target="_blank">{$data2[$cs_id].pending} </a>{else}-{/if}</td>
					<td align="center" valign="middle">{if $data2[$cs_id].completed neq ''}<a href="origin.php?ulbid={$ulbid}&originid={$origin_id}&cat3_id={$cs_id}&grievance_status_id=3" target="_blank">{$data2[$cs_id].completed} </a>{else}-{/if}</td>
					<td align="center">{if $data2[$cs_id].pendingforapproval+$data2[$cs_id].pending+$data2[$cs_id].completed neq ''}{$data2[$cs_id].pendingforapproval+$data2[$cs_id].pending+$data2[$cs_id].completed}{else}-{/if}</td>

					<!--15-06-2024 <td align="center" valign="middle"><a href="origin.php?ulbid={$ulbid}&originid={$origin_id}&cat3_id={$cs_id}&grievance_status_id=1" target="_blank">{if $data2[$cs_id].pendingforapproval eq ''} - {else}{$data2[$cs_id].pendingforapproval}{/if}</a></td>
					<td align="center" valign="middle"><a href="origin.php?ulbid={$ulbid}&originid={$origin_id}&cat3_id={$cs_id}&grievance_status_id=2" target="_blank">{if $data2[$cs_id].pending eq ''} - {else}{$data2[$cs_id].pending}{/if}</a></td>
					<td align="center" valign="middle"><a href="origin.php?ulbid={$ulbid}&originid={$origin_id}&cat3_id={$cs_id}&grievance_status_id=3" target="_blank">{if $data2[$cs_id].completed eq ''} - {else}{$data2[$cs_id].completed}{/if}</a></td>
					<td align="center">{$data2[$cs_id].pendingforapproval+$data2[$cs_id].pending+$data2[$cs_id].completed}</td> -->

				</tr>
				{assign var="i" value=$i+1}
				{/foreach}

				<tr>
					<td colspan="2" align="center"><strong>Total</strong></td>	
					<td align="center" class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}" valign="middle"><strong>{if $data2.pendingforapproval eq ''} 0 {else}<a href="Totalorigin_mayor.php?ulbid={$ulbid}&originid={$origin_id}&status=100" target="_blank">{$data2.pendingforapproval}</a>{/if}</strong></td>
					<td align="center" class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}" valign="middle"><strong>{if $data2.pending eq ''} 0 {else}<a href="Totalorigin_mayor.php?ulbid={$ulbid}&originid={$origin_id}&status=200" target="_blank">{$data2.pending} </a>{/if}</strong></td>
					<td align="center" class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}" valign="middle"><strong>{if $data2.completed eq ''} 0 {else}<a href="Totalorigin_mayor.php?ulbid={$ulbid}&originid={$origin_id}&status=300" target="_blank">{$data2.completed} </a>{/if}</strong></td>
					<td align="center" class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}" valign="middle"><strong>{if $data2.total eq ''} 0 {else}<a href="Totalorigin_mayor.php?ulbid={$ulbid}&originid={$origin_id}&status=400" target="_blank">{$data2.total} </a>{/if}</strong></td>
				</tr>
				
			</table>
		</div>

	

	</div>


</div>
{include file='footer_print.tpl'}

<br>
{include file='footer.tpl'}