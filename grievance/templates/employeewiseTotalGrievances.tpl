{include file='header.tpl'}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> Data Table CSS -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
	/* Your regular styles go here */

	.button-container {
		text-align: right;
		margin-top: 10px;
	}

	.button-container .btn {
		margin: 0 5px;
	}

	@media (max-width: 768px) {
		.button-container {
			text-align: center;
		}

		.button-container .btn {
			display: block;
			width: 80%;
			margin: 10px auto;
			max-width: 300px;
			/* Optional: to limit the button's width on larger mobile screens */
		}
	}

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

<script>
	function print_div() {
		var divContents = $("#area").html();
		var printWindow = window.open();
		printWindow.document.write(divContents);
		printWindow.document.close();
		printWindow.print();

	}
</script>
<br><br>
<div class="" style="margin-top: -45px;">


	<div class="boxed">
		<div class="title-bar blue">
			<h4></h4>
		</div>
		<div class="inner no-radius">

			<!-- <form method="GET" class="form-horizontal"> -->
			<form method="POST" class="form-horizontal">
				<input type="hidden" name="ulbid" value="{$ulbid}">
				<input type="hidden" name="app_type_id" value="{$app_type_id}">
				<input type="hidden" name="reference_no" value="{$reference_no}">
				<input type="hidden" name="f_date" value="{$fdate}">
				<input type="hidden" name="t_date" value="{$tdate}">
				<input type="hidden" name="status" value="{$status}">
				<input type="hidden" name="dept_id" value="{$dept_id}">

				<div class="col-md-4">
					<div class="form-group">
						<!-- <label class="control-label col-sm-6" for="usr">Reference No:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}" placeholder="Enter Reference No" autocomplete="off">
						</div> -->
						<label class="control-label col-sm-6" for="usr">Complaint Id:</label>
						<div class="col-sm-6">
							<input type="text" class="phone-group form-control demoInputBox" name="reference_no" value="{$reference_no}" placeholder="Enter Complaint Id" autocomplete="off">
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label col-sm-5" for="usr">From Date:</label>
						<div class="col-sm-7">
							<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
						</div>
					</div>
				</div>


				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label col-sm-5" for="usr">To Date:</label>
						<div class="col-sm-7">
							<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
						</div>
					</div>
				</div>

				{if $user_type eq 'E'}
				<div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<a href="all_empwise_report.php?active=tr-clmn" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div>
				{else}
				<div class="button-container">
					<input name="search" type="submit" class="btn btn-success" value="SEARCH">
					<a href="all_empwise_report_new.php" class="btn btn-warning" onclick="history.go(-1);">
						<i class="fa fa-backward"></i> Back
					</a>
				</div>
				{/if}

			</form>

			<!--17-06-2024 <div class="col-md-1" align="right"><input name="search" type="submit" class="btn btn-success" value="SEARCH"> </div>

			</form>
			{if $user_type eq 'E'}
				<div style="text-align:right;"><a href="all_empwise_report.php?active=tr-clmn" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>
			{else}
			/*not Open <div style="text-align:right;"><a href="rep_comp_dept_abs_comp.php?active=tr-clmn" class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</a></div> */
				<div style="text-align:right;"><a href="dept_empwise.php?app_type_id={$app_type_id}&dept_id={$dept_id}&status={$status}&f_date=&t_date=" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></div>
			{/if} -->
		</div>





		<div id="div_print" style="border:#999999 0px solid;">
			<!-- <CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</strong></CENTER> -->

			<!-- </br></br> -->


			<!-- <div style="width:100%;  margin-top:40px;"> -->
			<div style="width:100%;">
				<div id="area" class="table-responsive">
					<table width="100%" border="1" cellspacing="0" cellpadding="0" class="display table-bordered table-striped table-condensed cf" id="example">
						<caption style="caption-side:top; text-align:center;font-size:16px;">
							<b>
								{if $status eq '100' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN RECEIVED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '100' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE RECEIVED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '200' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN UNDER PROGRESS WITHIN SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '200' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE UNDER PROGRESS BEYOND SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '300' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN COMPLETED WITHIN SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '300' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE COMPLETED BEYOND SLA COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '400' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN REOPENED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								
								{elseif $status eq '400' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE REOPENED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								
								{elseif $status eq '401' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN REOPENED COMPLETED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								
								{elseif $status eq '401' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE REOPENED COMPLETED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								
								{elseif $status eq '402' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN REOPENED UNDER PROGRESS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
	
								{elseif $status eq '402' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE REOPENED UNDER PROGRESS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '500' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN TRANSFERED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '500' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE TRANSFERED COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '600' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN FINANCIAL IMPLICATIONS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '600' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE FINANCIAL IMPLICATIONS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{elseif $status eq '700' || $status eq '701' && $user_type eq 'U' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} ADMIN FINANCIAL IMPLICATIONS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>
								{elseif $status eq '700' || $status eq '701' && $user_type eq 'E' }
								<CENTER><strong>VIEW {if $app_type_id eq '1'} EMPLOYEE FINANCIAL IMPLICATIONS COMPLAINT {else} SERVICE {/if} DETAILS</strong></CENTER>

								{else}
								<CENTER><strong>VIEW {if $app_type_id eq '1'} COMPLAINT {else} SERVICE{/if} DETAILS</strong></CENTER>
								{/if}
							</b>
						</caption>
						<thead>
							<!--29-05-2024 <tr style="background-color:#2c3e50; color:#FFF;">
								<th align="center" valign="middle">S.No</th>
								<th align="center" valign="middle">REFERENCE No</th>
								<th align="center" valign="middle">NAME & MOBILE</th>
								<th align="center" valign="middle">ADDRESS</th>
								<th align="center" valign="middle">{if $app_type_id eq '1'} COMPLAINTS {else} SERVICE{/if} DETAILS</th>
								<th align="center" valign="middle">STATUS</th>
								<th align="center" valign="middle">RECEIVED DATE</th>-->
							<!--old not open <th align="center" valign="middle" colspan="2">ACTIONS</th> -->
							<!--<th align="center" valign="middle">ACTIONS</th>
							</tr> -->
							<tr style="background-color:#2c3e50; color:#FFF;">
								<th align="center" valign="middle" style="width: 50px; text-align: center; vertical-align: middle;">SR.No</th>
								<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">REFERENCE No</th>
								<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">NAME & MOBILE</th>
								<th align="center" valign="middle" style="width: 250px; text-align: center; vertical-align: middle;">ADDRESS</th>
								<th align="center" valign="middle" style="width: 200px; text-align: center; vertical-align: middle;">
									{if $app_type_id eq '1'}
									COMPLAINTS
									{else}
									SERVICE
									{/if} DETAILS
								</th>
								<th align="center" valign="middle" style="width: 100px; text-align: center; vertical-align: middle;">STATUS</th>
								<th align="center" valign="middle" style="width: 150px; text-align: center; vertical-align: middle;">RECEIVED DATE</th>
								<th align="center" valign="middle" style="width: 100px; text-align: center; vertical-align: middle;">ACTIONS</th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$data key=grievance_id item=row}
							<tr>
								<!-- <td align="center">{counter}</td> -->
								<td align='center'>{$sno++}</td>


								<!--<td>{$dept_list[$row.dept_id]}</td>-->
								<!--29-05-24 <td align='center'><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td> -->
								<td align='center'>
									<a href="view_comp_det_admin.php?grievance_id={$grievance_id}">
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
								<td align='center'>{$row.person_name} ({$row.mobile})</td>

								<td align='center'>{$row.hno},{$row.address}</td>

								<td align='center'>{if $app_type_id eq '2'}{$cs_list[$row.mcat3_id]}{else}{$cs_list[$row.cat3_id]}{/if}</td>

								<td align='center'>{$status_list[$row.grievance_status_id]}</td>
								<td align='center'>{$row.date_regd|date_format:"%d-%m-%Y %H:%M:%S"}</td>

								<td align='center'>
									{if $ulbid eq '207'}
									{if $row.app_type_id eq '2'}
									<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
									{else}
									<a href="receive_print_boduppal.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
									{/if}

									{else}
									{if $row.app_type_id eq '2'}
									<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
									{else}
									<a href="receive_print.php?gid={$grievance_id}&aptid={$row.app_type_id}" target="_blank">Receipt</a>
									{/if}
									{/if}

									{if $row.grievance_status_id eq '2'}
									<!--<form action="manage_comp_sel.php" method="post">
											<input type="hidden" name="grievance_id" value="{$grievance_id}">
											<input type="submit" name="update" value="Update" class="btn btn-primary btn-sm">
										</form>-->
									{/if}

								</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>






<!--<div align="right"><a href="#" ><button class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-backward"></i> Back</button></a></div>-->







<!-- <div style="width:100%; text-align:center">


	<form action="exporttoexcel.php" method="post">
		<input type="hidden" name="app_type_id" value="{$app_type_id}">
		<input type="hidden" name="emp_id" value="{$emp_id}">
		<input type="hidden" name="status" value="{$status}">
		<input type="hidden" name="dept_id" value="{$dept_id}">


		<input type="submit" name="excel" value="export All excel" class="btn btn-warning">
	</form>

</div> -->
<!--<center>
 	<input type="button" onclick="tableToExcel('example', 'Sheet')" value="Export to Excel" class="btn btn-success">
	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
</center>-->
{literal}
<style>
	div.pagination {
		padding: 3px;
		margin: 3px;
	}

	div.pagination a {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #AAAADD;

		text-decoration: none;
		/* no underline */
		color: #000099;
	}

	div.pagination a:hover,
	div.pagination a:active {
		border: 1px solid #000099;

		color: #000;
	}

	div.pagination span.current {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #000099;

		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}

	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;

		color: #DDD;
	}
</style>


{/literal}

<center>
	<div id="pagination" class="pagination" align="center">{$pagination}</div>
</center>
<br>
<div style="width:100%; text-align:center">
	<form action="exporttoexcel.php" method="post">
		<input type="hidden" name="app_type_id" value="{$app_type_id}">
		<input type="hidden" name="emp_id" value="{$emp_id}">
		<input type="hidden" name="status" value="{$status}">
		<input type="hidden" name="sla" value="{$sla}">
		<input type="hidden" name="dept_id" value="{$dept_id}">
		<input type="hidden" name="user_type" value="{$user_type}">
		<input type="submit" name="excel" value="Export To Excel" class="btn btn-success">
		<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
		<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
	</form><br>
</div>
{include file='footer.tpl'}


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

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
<script>
	$(function() {
		$(".datepicker").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
</script>