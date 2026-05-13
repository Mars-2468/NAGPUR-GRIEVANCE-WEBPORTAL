{include file='header.tpl'}
{literal}

<style>
	.activ_column {
		background-color: #7ac18a;
		color: white !important;
	}

	.activ_column a {
		/*background-color: #54B435;*/
		color: #FFF !important;
		/*text-shadow: 0 0 3px #FFFF;*/
		text-decoration: underline #1C82AD;
	}

	a {
		color: blue;
		text-decoration: underline;
	}

	/* Your regular styles go here */

	@media print {

		/* Set the page to landscape mode */
		@page {
			size: landscape;
		}

		/* Additional print styles if needed */
		body {
			font-size: 12pt;
			margin: 1cm;
			/* Adjust margins as needed */
		}
	}
</style>

<script language='javascript'>
	var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,',
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
			base64 = function(s) {
				return window.btoa(unescape(encodeURIComponent(s)))
			},
			format = function(s, c) {
				return s.replace(/{(\w+)}/g, function(m, p) {
					return c[p];
				})
			}
		return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {
				worksheet: name || 'Worksheet',
				table: table.innerHTML
			}
			window.location.href = uri + base64(format(template, ctx))
		}
	})()
</script>
<script>
	function print_div() {
		var divContents = $("#area").html();
		var printWindow = window.open();
		printWindow.document.write(divContents);
		printWindow.document.close();
		printWindow.print();
	}
</script>

{/literal}



<!--<div class="" style="margin-top: -45px;">
	<form method="POST" class="form-horizontal">


		<div class="boxed">

			<div class="title-bar blue"></div>
			<div class="inner no-radius">
				<!--{if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>

						<select name="ulbid" class="form-control">
							<option value="">--select--</option>
							{html_options options=$villages selected=$ulb}
						</select>

					</div>
				</div>
				{/if}-
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>

						<input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">

					</div>
				</div>


				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>

						<input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">

					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					</div>
				</div>


			</div>


		</div>


	</form>
</div>-->

<!--<div style="text-align:right;"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>-->

<div class="" style="margin-top: -45px;">
	<form method="POST" class="form-horizontal">
		<div class="boxed">
			<div class="title-bar blue"></div>
			<div class="inner no-radius">
			
				{if !empty($errors)}
					{foreach $errors as $error}
						<p style="color:red;">{$error}</p>
					{/foreach}
				{/if}
				
				<!-- {if $ulb eq '208' || $ulb eq '210' || $ulb eq '3'}
					<div class="col-md-3" style="margin-right:15px;">
						<div class="form-group">
							<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">Village:</label>

							<select name="ulbid" class="form-control">
								<option value="">--select--</option>
								{html_options options=$villages selected=$ulb}
							</select>

						</div>
					</div>
					{/if} -->
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>

						<input type="text" class="phone-group form-control datepicker" name="f_date" id="f_date" value="{$fdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
						<div style="font-size:10px;color:red;" id="f_dateX"></div>
					</div>
				</div>


				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-5" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>

						<input type="text" class="phone-group form-control datepicker" name="t_date" id="t_date" value="{$tdate}" placeholder="Select Date" data-type="date" onchange="funInputFielTypes(this)" autocomplete="off">
						<div style="font-size:10px;color:red;" id="t_dateX"></div>
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="SEARCH" id="submitBtn" disabled>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="boxed">


	<div class="title-bar blue d-flex align-items-center justify-content-between mb-3">
		<h4>Grievance Analysis Department Zone Wise</h4>
		<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
		<p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
	</div>

	<div class="inner no-radius">
		<div id="area" class="table-responsive">
			<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
				<caption style="caption-side:top; text-align:center;font-size:16px;">
					<b>
						<CENTER><strong>VIEW GRIEVANCE ANALYSIS DEPARTMENT ZONE WISE DETAILS</strong></CENTER>
					</b>
				</caption>

				<thead>
					<tr style="background-color:#2c3e50; color:#FFF;">
						<th align='center' rowspan='2'> Sr No. </th>

						<th align='center' rowspan='2'> Department </th>

						{foreach from=$ward_list item=row key=$ward_id}
						<th colspan='5' align='center'>
							<center> {$row.ward_desc} </center>
						</th>
						{/foreach}



					</tr>
					<tr style="background-color:#2c3e50; color:#FFF;">

						{foreach from=$ward_list item=row key=$ward_id}

						<th> Received </th>
						<th> Resolved </th>
						<th> Pending </th>
						<th> Resolved Within SLA </th>
						<th> Resolved Beyond SLA </th>

						{/foreach}

					</tr>

					{assign var ="completed" value="0"}
					{assign var ="pending" value="0"}
					{assign var ="received" value="0"}
					{assign var ="tot_received" value=[]}
					{assign var ="tot_resolved" value=[]}
					{assign var ="tot_pending" value=[]}
					{assign var ="resolved_sla" value=[]}
					{assign var ="resolved_beyond_sla" value=[]}


					{assign var="tot_received.3" value="0"}
					{assign var="tot_received.4" value="0"}
					{assign var="tot_received.5" value="0"}
					{assign var="tot_received.30" value="0"}
					{assign var="tot_received.29" value="0"}
					{assign var="tot_received.26" value="0"}
					{assign var="tot_received.27" value="0"}
					{assign var="tot_received.28" value="0"}
					{assign var="tot_received.31" value="0"}
					{assign var="tot_received.32" value="0"}

					{assign var="tot_resolved.3" value="0"}
					{assign var="tot_resolved.4" value="0"}
					{assign var="tot_resolved.5" value="0"}
					{assign var="tot_resolved.30" value="0"}
					{assign var="tot_resolved.29" value="0"}
					{assign var="tot_resolved.26" value="0"}
					{assign var="tot_resolved.27" value="0"}
					{assign var="tot_resolved.28" value="0"}
					{assign var="tot_resolved.31" value="0"}
					{assign var="tot_resolved.32" value="0"}

					{assign var="tot_pending.3" value="0"}
					{assign var="tot_pending.4" value="0"}
					{assign var="tot_pending.5" value="0"}
					{assign var="tot_pending.30" value="0"}
					{assign var="tot_pending.29" value="0"}
					{assign var="tot_pending.26" value="0"}
					{assign var="tot_pending.27" value="0"}
					{assign var="tot_pending.28" value="0"}
					{assign var="tot_pending.31" value="0"}
					{assign var="tot_pending.32" value="0"}

					{assign var="resolved_sla.3" value="0"}
					{assign var="resolved_sla.4" value="0"}
					{assign var="resolved_sla.5" value="0"}
					{assign var="resolved_sla.30" value="0"}
					{assign var="resolved_sla.29" value="0"}
					{assign var="resolved_sla.26" value="0"}
					{assign var="resolved_sla.27" value="0"}
					{assign var="resolved_sla.28" value="0"}
					{assign var="resolved_sla.31" value="0"}
					{assign var="resolved_sla.32" value="0"}

					{assign var="resolved_beyond_sla.3" value="0"}
					{assign var="resolved_beyond_sla.4" value="0"}
					{assign var="resolved_beyond_sla.5" value="0"}
					{assign var="resolved_beyond_sla.30" value="0"}
					{assign var="resolved_beyond_sla.29" value="0"}
					{assign var="resolved_beyond_sla.26" value="0"}
					{assign var="resolved_beyond_sla.27" value="0"}
					{assign var="resolved_beyond_sla.28" value="0"}
					{assign var="resolved_beyond_sla.31" value="0"}
					{assign var="resolved_beyond_sla.32" value="0"}

					{foreach from=$dept_list key=dept_id item=row}

						<tr>
							<td align='center'>{counter}</td>
							<td align='center'><a href="dept_empwise.php?app_type_id=1&dept_id={$dept_id}&status=0&f_date={$fdate}&t_date={$tdate}">{$dept_list[$dept_id]}</a></td>
							{foreach from=$ward_list item=row2 key=ward_id}

							{$completed = $data_list[$dept_id][$ward_id]['completed']+$data_list[$dept_id][$ward_id]['completed_be_sla']+$data_list[$dept_id][$ward_id]['fin']+$data_list[$dept_id][$ward_id]['rejected']}
							{$pending = $data_list[$dept_id][$ward_id]['pending_be']+$data_list[$dept_id][$ward_id]['pending']}
							{$received = $completed+$pending}
							{$tot_received[$ward_id] = $tot_received[$ward_id]+$received}
							{$tot_resolved[$ward_id] = $tot_resolved[$ward_id]+$completed}
							{$tot_pending[$ward_id] = $tot_pending[$ward_id]+$pending}
							{$resolved_sla[$ward_id] = $resolved_sla[$ward_id]+$data_list[$dept_id][$ward_id]['completed']}
							{$resolved_beyond_sla[$ward_id] = $resolved_beyond_sla[$ward_id]+$data_list[$dept_id][$ward_id]['completed_be_sla']}

							<!-- <td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=all"> {$received} </a></td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=received">{$completed} </a></td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=pending">{$pending}</a> </td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=resloved_insla">{$data_list[$dept_id][$ward_id]['completed']} </a> </td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=resloved_beyondsla">{$data_list[$dept_id][$ward_id]['completed_be_sla']} </a></td> -->

							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=0"> {$received} </a></td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=20">{$completed} </a></td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=21">{$pending}</a> </td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=22">{$data_list[$dept_id][$ward_id]['completed']} </a> </td>
							<td align='center'> <a href="grievance_analysis_dept_zone_inner_rep.php?dept_id={$dept_id}&zone_id={$ward_id}&status=23">{$data_list[$dept_id][$ward_id]['completed_be_sla']} </a></td>
							{/foreach}
						</tr>
					{/foreach}

				</thead>
				{if $user_type eq 'U'}
				<tfoot>
					<td align='center' colspan='2'><strong>Total</strong></td>
					{foreach from=$ward_list item=row2 key=ward_id}
					<!-- <td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot_received[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=total_all">{$tot_received[$ward_id]}</a>{else}{$tot_received[$ward_id]}{/if}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot_resolved[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=total_resolved">{$tot_resolved[$ward_id]}</a>{else}{$tot_resolved[$ward_id]}{/if}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot_pending[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=total_pending">{$tot_pending[$ward_id]}</a>{else}{$tot_pending[$ward_id]}{/if}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $resolved_sla[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=total_comp_insla">{$resolved_sla[$ward_id]}</a>{else}{$resolved_sla[$ward_id]}{/if}</td> -->

					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot_received[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=100">{$tot_received[$ward_id]}</a>{else}{$tot_received[$ward_id]}{/if}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot_resolved[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=108">{$tot_resolved[$ward_id]}</a>{else}{$tot_resolved[$ward_id]}{/if}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $tot_pending[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=800">{$tot_pending[$ward_id]}</a>{else}{$tot_pending[$ward_id]}{/if}</td>
					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}">{if $resolved_sla[$ward_id] gt 0}<a href="grievance_analysis_dept_zone_inner_rep.php?zone_id={$ward_id}&status=400">{$resolved_sla[$ward_id]}</a>{else}{$resolved_sla[$ward_id]}{/if}</td>

					<td align='center' class="{if $active_class eq 'tr-clm3qclmn'}activ_column{/if}"><strong>{if $resolved_beyond_sla[$ward_id] gt 0}{$resolved_beyond_sla[$ward_id]}{else}{$resolved_beyond_sla[$ward_id]}{/if}</strong></td>
					{/foreach}
				</tfoot>
				<!-- @endif -->
				{else}
				<!-- @if($user_type eq 'E') -->


				<!-- @endif -->
				{/if}
			</table>
		</div>

		<br>
		<div>
			<center>
				<form action="exporttoexcel.php" method="post">
					<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export To Excel" class="btn btn-success" />
					<!-- <button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button> -->
					<input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
				</form><br>
			</center>
		</div>


	</div>
</div>




<br>



{include file='footer_print.tpl'}
<div style="background-image:url(images/search_bg_2.jpg); height:28px;"></div>
{include file='footer.tpl'}


<script>
	function exportTableToPDF(TableId, ReportName) {
		// Create a new jsPDF instance
		const doc = new jsPDF('landscape');
		doc.setFontSize(10);

		// Add a heading to the PDF
		//const captionText = document.querySelector('#' + TableId + ' caption').textContent;
		const captionElement = document.querySelector('#' + TableId + ' caption');
		const captionText = captionElement ? captionElement.textContent : "";

		const cleanedCaptionText = captionText.replace(/\s+/g, ' ').trim();
		const pageWidth = doc.internal.pageSize.width;
		const textWidth = doc.getStringUnitWidth(cleanedCaptionText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
		const x = (pageWidth - textWidth) / 2;
		doc.text(cleanedCaptionText, x, 15);

		// Generate the table from the HTML table with the specified TableId
		const table = document.getElementById(TableId);

		doc.autoTable({
			html: '#' + TableId,
			showFoot: "lastPage",
			styles: {
				lineColor: [0, 0, 0],
				fontSize: 8,
				textColor: [0, 0, 0]
			},
			headStyles: {
				fillColor: [173, 216, 230],
				lineWidth: 0.5,
				fontStyle: 'bold',
				halign: 'center',
				cellPadding: 1,
			},
			bodyStyles: {
				lineWidth: 0.5,
				halign: 'center',
				cellPadding: 1,
				alignment: 'center',
			},
			footStyles: {
				fillColor: [173, 216, 230],
				lineWidth: 0.5,
				halign: 'center',
				cellPadding: 1,
				alignment: 'center',
			},

			rowStyles: {
				lineColor: [0, 0, 0],
			},
			margin: {
				top: 20
			},
			didDrawPage: function(data) {
				// Modify the fill color of the footer on the last page
				if (typeof data.table !== "undefined" && data.pageNumber === data.table.finalYPage) {
					doc.setFillColor(255, 255, 255);
					doc.setTextColor(0, 0, 0);
					doc.rect(data.settings.margin.left, doc.internal.pageSize.height - 20, doc.internal.pageSize.width - data.settings.margin.left - data.settings.margin.right, 10, 'F');
				}
			},
		});

		doc.save(ReportName + '.pdf');
	}
</script>
