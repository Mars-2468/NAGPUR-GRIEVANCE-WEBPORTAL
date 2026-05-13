{include file='corp_header.tpl'}

<div id="div_print" style="border:#999999 0px solid; ">
	<input type="hidden" name="ulbid" value="{$ulbid}">
	<input type="hidden" name="app_type_id" value="{$app_type_id}">
	<input type="hidden" name="origin_id" value="{$origin_id}">
	<input type="hidden" name="status" value="{$status}">
	<!--17-06-2024 <CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER> -->

	<!--17-06-2024 <div class="cap_font" style="text-align:center;padding-top: 5px;padding-bottom: 5px;font-size:16px;">
		<caption style="caption-side:top;text-align:center;padding-top: 5px;padding-bottom: 5px;font-size:16px;">
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
				<!--17-06-2024 <tr style="background-color:#2c3e50; color:#FFF;">
					<th align="center" valign="middle">S.No</th>
					<th align="center" valign="middle">Mode Of Application</th>
					<th align="center" valign="middle">{if $app_type_id eq '1'} Category {else} Department{/if}</th>
					<th align="center" valign="middle">Reference No</th>
					<th align="center" valign="middle">Name & Mobile</th>
					<th align="center" valign="middle">Adress</th>
					<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} Details</th>
					<th align="center" valign="middle">Status</th>
					<th align="center" valign="middle">Actions</th>
				</tr> -->
				<tr style="background-color:#2c3e50; color:#FFF;">
					<th align="center" valign="middle" style="width: 50px; text-align: center; vertical-align: middle;">SR.No</th>
					<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">MODE OF APPLICATION</th>
					<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">{if $app_type_id eq '1'} CATEGORY {else} DEPARTMENT{/if}</th>
					<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">REFERENCE NO</th>
					{if $origin_id eq '8' }<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">Garden Name</th>{/if}
					<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">NAME & MOBILE</th>
					<th align="center" valign="middle" style="width: 350px; text-align: center; vertical-align: middle;">ADDRESS</th>
					<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</th>
					<th align="center" valign="middle" style="width: 100px; text-align: center; vertical-align: middle;">STATUS</th>
					<th align="center" valign="middle" style="width: 100px; text-align: center; vertical-align: middle;">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$data key=grievance_id item=row}
				<tr align="center">
					<td>{$pageNumber++}</td>
					{if $origin_id eq '0'}
					<td>{$origin_list['1']}</td>
					{else}
					<td>{$origin_list[$origin_id]}</td>
					{/if}

					{if $row.app_type_id eq '1'}
					<td><label title="{$row.comp_desc}">{$cs_list[$row.cat3_id]}</label></td>
					{else}
					<td><label title="{$row.comp_desc}">{$dept_list[$row.dept_id]}</label></td>
					{/if}
					<!--<td>{$dept_list[$row.dept_id]}</td>-->
					<!-- <td align="center"><a href="corp_origin_view_comp_det_admin.php?grievance_id={$grievance_id}" target="_blank">{$grievance_id}</a></td> -->
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">
						<a href="corp_origin_view_comp_det_admin.php?grievance_id={$grievance_id}" target="_blank">
							{if {$row.grievance_origin_id} eq '1'}
							<b style="margin-right: 1px;">Web - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '2'}
							<b style="margin-right: 1px;">Phone - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '3'}
							<b style="margin-right: 1px;">Counter - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '4'}
							<b style="margin-right: 1px;">App - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '5'}
							<b style="margin-right: 1px;">WhatsApp - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '6'}
							<b style="margin-right: 1px;">Facebook - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '7'}
							<b style="margin-right: 1px;">EBC - </b>{$grievance_id}
							{elseif {$row.grievance_origin_id} eq '8'}
							<b style="margin-right: 1px;">Garden - </b>{$grievance_id}
							{else}
							{$grievance_id}
							{/if}
						</a>
					</td>
					{if $origin_id eq '8' }<td>{$row.park_name}</td>{/if}
					<td>{$row.person_name} ({$row.mobile})</td>

					<td>{$row.hno},{$row.address}</td>
					<td>{$cs_list[$row.cat3_id]}</td>
					<td>{$grievance_status_list[$row.grievance_status_id]}</td>
					<td>
						{if $ulbid eq '207'}
						{if $row.app_type_id eq '2'}
						<a href="corp_receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
						{else}
						<a href="corp_receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
						{/if}
						{else}
						{if $row.app_type_id eq '2'}
						<a href="corp_receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
						{else}
						<a href="corp_receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Reeceipt</a>
						{/if}
						{/if}
					</td>
				</tr>
				{/foreach}
			</tbody>

		</table>
	</div>


<!-- option2 pagination start -->
<nav>
    <ul class="pagination">
        {assign var="start_page" value=$pagination.current_page - $pagination.range}
        {assign var="end_page" value=$pagination.current_page + $pagination.range}
        {assign var="start_page" value=max(1, $start_page)}
        {assign var="end_page" value=min($pagination.total_pages, $end_page)}

        <!-- Previous Button -->
        {if $pagination.current_page > 1}
            <li><a href="?ulbid=250&originid={$origin_id}&status={$status}&page={$pagination.current_page - 1}">&laquo; Prev</a></li>
        {/if}

        <!-- First Page Button -->
        {if $start_page > 1}
            <li><a href="?ulbid=250&originid={$origin_id}&status={$status}&page=1">1</a></li>
            {if $start_page > 2}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
        {/if}

        <!-- Visible Page Numbers -->
        {section name=pages start=$start_page loop=$end_page}
            <li class="{if $pagination.current_page == $smarty.section.pages.index+1}active{/if}">
                <a href="?ulbid=250&originid={$origin_id}&status={$status}&page={$smarty.section.pages.index+1}">{$smarty.section.pages.index+1}</a>
            </li>
        {/section}
        <!-- Last Page Button -->
        {if $end_page < $pagination.total_pages}
            {if $end_page < $pagination.total_pages - 1}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
            <li><a href="?ulbid=250&originid={$origin_id}&status={$status}&page={$pagination.total_pages}">{$pagination.total_pages}</a></li>
        {/if}

        <!-- Next Button -->
        {if $pagination.current_page < $pagination.total_pages}
            <li><a href="?ulbid=250&originid={$origin_id}&status={$status}&page={$pagination.current_page + 1}">Next &raquo;</a></li>
        {/if}
    </ul>
</nav>
<!-- option2 pagination end -->

</div>
{include file='footer_print.tpl'}
<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->
<br>
{literal}

<script language="javascript" type="text/javascript">
	var table2_Props = {
		col_0: "none",
		col_1: "none",
		col_2: "none",
		col_3: "none",
		col_4: "none",
		col_5: "none",
		col_6: "none",
		col_7: "none",
		display_all_text: " [ Show all ] ",
		sort_select: true,
		paging: true,
		paging_length: 5,
		alternate_rows: false
	};
	setFilterGrid("example", table2_Props);
</script>





{/literal}
{include file='corp_footer.tpl'}