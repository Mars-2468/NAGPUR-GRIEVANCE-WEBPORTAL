{include file='header.tpl'}
{literal}

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="actb.js"></script>
<script language="javascript" type="text/javascript" src="tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script language="javascript">
    function get_comp_det(grievance_id) {

        document.forms["manage_comp_det"].submit();
    }
    function get_comp_det_emp(grievance_id) {

        document.forms["manage_comp_det_emp"].submit();
    }

    function fun1(app_type_id) {
        $.post('ajax_get_search_cat3ids.php', {
            app_type_id: app_type_id
        }, function(data) {
            $("#cat3_id").html(data);
        });
    }
</script>
{/literal}


<div class="boxed">

			<div class="row" style="background-color: #e3f6f5; ">
				
				<div style="background-color: #0066CC; color: #FFF; padding: 5px; font-size: 15px;display:flex; justify-content:space-between;align-items:center">
					<div>Search Complaint</div>			
					<div style=""><a href="ajax_dashboard.php" class="btn btn-warning">Back</a></div>	
				</div>
			  
			</div>
			
       
           
			<div id="area" class="container" style="margin-top: 15px;">
                
				<div class="panel panel-info" style="margin-top: 15px;">
                    
					<div class="panel-heading"  style="">					
						<div>Check Status</div>					
					</div>
					
                    <div class="panel-body">
                        <form name="check_comp_status" method="GET" action="" onSubmit="return validateForm();">
                            <input type="hidden" name="ulbid" value="{$ulbid}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Name</label>
                                    <input type="text" name="person_name" id="person_name" value="{$person_name}" class="form-control"/>
                                </div>
                                <div class="col-md-3">
                                    <label>Mobile No</label>
                                    <input type="text" name="mobile" value="{$mobile}" class="form-control"/>
                                </div>
                                <div class="col-md-3">
                                    <label>Period From</label>
                                    <input type="text" name="from_date" id="from_date" value="{$from_date}"  readonly class="datepick form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Period To</label>
                                    <input type="text" name="to_date" id="to_date" value="{$to_date}" readonly class="datepick form-control">
                                </div>
                                <div class="col-md-3" style="margin-top: 10px;">
                                    <label>Reference No</label>
                                    <input type="text" name="grievance_id" value="{$grievance_id}" class="form-control">
                                </div>
                                <div class="col-md-3" style="margin-top: 10px;">
                                    <label>Status</label>
                                    <select name="grievance_status_id" id="grievance_status_id" value="{$grievance_status_id}" class="form-control">
                                        <option value=''>-All-</option>
                                        {html_options options=$grievance_status_list  selected=$grievance_status_id}
                                    </select>
                                </div> 
								<div class="col-md-3" style="margin-top: 10px;">
                                    <label>Rating</label>
                                    <select name="rating_num" id="rating_num" value="{$rating_num}" class="form-control">
                                        <option value=''>-All-</option>
                                        {html_options options=$ratings_list  selected=$rating_num}
                                    </select>
                                </div>
								<div class="col-md-3" style="margin-top: 10px;">
                                    <label>Feedback Status</label>
                                    <select name="feedback_status" id="feedback_status" value="{$feedback_status}" class="form-control">
                                        <option value='-1'>-All-</option>
                                        {html_options options=$feedback_status_list  selected=$feedback_status}
                                    </select>
                                </div>	
								<div class="col-md-3" style="margin-top: 10px;">
                                    <label>Feedback Given By</label>
                                    <select name="feedback_sentby" id="feedback_sentby" value="{$feedback_sentby}" class="form-control">
                                        <option value='-1'>-All-</option>
                                        {html_options options=$feedback_sentby_list  selected=$feedback_sentby}
                                    </select>
                                </div>
								<div class="row" style="padding-bottom:12px;">
									<div class="col-md-12 d-flex text-center" style="margin-top: 32px;">
										<input style="padding:8px 20px;margin-right:12px" type="reset" name="reset" id="reset" value="Reset" class="print_btn btn btn-danger"/>
										<input style="padding:8px 20px" type="submit" name="search" id="search" value="Search" class="excel_btn btn btn-success"/>
									</div>
								</div>
							</div>
                        </form>
					</div>

                </div>
				
            </div>
       
            {if isset($data)}
				<p style="margin-bottom:60px;">
				<a href="controlroom_feedback_report.php" class="btn btn-sm btn-warning pull-right">Report</a>
				</p>
					
				<p>	
					<div class="row col-md-12">
						<div class="col-sm-6">
							<strong> <span style='color: red'>*Please give feedback to all completed grievances to register new grievance </span></strong>
						</div>
						<div class="col-sm-3 bg-danger"><span class="" style="padding:5px">Total number of complaints : {$total_rows}</span> </div>
						<div class="col-sm-3 bg-success"><span class="" style="padding:5px">Total Feedback Completed : {$fb_status}</span></div>
					</div>
				</p>
				
                <div class="table table-responsive">
                <table id="CallCenterTable" width="100%" border="1" cellpadding="0" cellspacing="0" class="table" style="font-size: 13px;">
                    <tr style="background-color: #3366CC; color: #FFF;">
                        <th align="center" valign="middle" scope="col" style="width: 40px;">S.No</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Complaint No</th>
                        <th align="center" valign="middle" scope="col" style="width: 120px;">Name & Mobile</th>
                        <th align="center" valign="middle" scope="col" style="width: 150px;">Zone</th>
                        <th align="center" valign="middle" scope="col" style="width: 150px;">Ward</th>
                        <th align="center" valign="middle" scope="col" style="width: 300px;"><div style="width: 300px;">Complaint Details</div></th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Rating</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Feedback</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Feedback From</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Status</th>
                    </tr>
                    {foreach from=$data key=grievance_id item=row}
                    <tr>
                        <td align="center" valign="middle" style="width: 40px;">{$pageNumber++}</td>
                        <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;"><a href="controlroom_view_comp_det.php?grievance_id={$grievance_id}&id={$ulbid}" style="color: #FF6600;">{$grievance_id}</a></td>
                        <td align="center" valign="middle" style="width: 120px; word-wrap: break-word;">{$row.person_name} ({$row.mobile})</td>
                        <td align="center" valign="middle" style="width: 150px; word-wrap: break-word;"><div style="width: 150px; padding: 0px 5px 0px 5px;">{$row.ward_desc}</div></td>
                        <td align="center" valign="middle" style="width: 150px; word-wrap: break-word;"><div style="width: 150px; padding: 0px 5px 0px 5px;">{$row.street_desc}</div></td>
                        
						<td align="center" valign="middle" style="width: 300px; word-wrap: break-word; text-align: justify; padding: 0px 10px 0px 10px;">
                            <div style="width: 300px; word-wrap: break-word;">{if $row.comp_desc eq ''}
								N/A.{elseif $row.comp_desc neq ''}{$row.comp_desc}{/if}
                            </div>
                        </td> 
						<td align="center" valign="middle" style="width: 100px; word-wrap: break-word;">
							{if $feedback_list[$grievance_id]['rating_no']!=0}
								{$feedback_list[$grievance_id]['rating_no']}&nbsp;<i class="fa fa-star" style="color:#ff9900"></i>
							{/if}
						</td>
						
						 <td align="center" valign="middle" style="width: 40px;">
						    <div style="width: 300px; word-wrap: break-word;">
							{if $feedback_list[$grievance_id] eq ''}
								-
							{elseif $feedback_list[$grievance_id] neq ''}
								{$feedback_list[$grievance_id]['comment_desc']}
							{/if}
                            </div>
						 </td>
						 <td>
						 {if $row.rating_given_ref eq 'citizen'}
						 {'citizen'}
						 {else}
						 {$user_list[$row.rating_given_by]}
						 {/if}
						 </td>
                       
                        <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;">
                           
                            {if $row.grievance_status_id|in_array:['3','6','8','9','12']  && $row.feedback_status eq 0}
								<a href="controlroom_feedback.php?id=250&grievance_id={$grievance_id}" class="excel_btn btn btn-success">FeedBack</a>
                            {else}
								{$grievance_status_list[$row.grievance_status_id]}
							{/if}
                        </td>
                    </tr>
                    {/foreach}
                </table>
				
                </div>
            {/if}
        
		<div style="padding-left: 125px; padding-top: 25px; font-size: 11px;"></div>
		
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
            <li><a href="?ulbid=250&page={$pagination.current_page - 1}{$filter_query}">&laquo; Prev</a></li>
        {/if}

        <!-- First Page Button -->
        {if $start_page > 1}
            <li><a href="?ulbid=250&page=1{$filter_query}">1</a></li>
            {if $start_page > 2}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
        {/if}

        <!-- Visible Page Numbers -->
        {section name=pages start=$start_page loop=$end_page}
            <li class="{if $pagination.current_page == $smarty.section.pages.index+1}active{/if}">
                <a href="?ulbid=250&page={$smarty.section.pages.index+1}{$filter_query}">{$smarty.section.pages.index+1}</a>
            </li>
        {/section}

        <!-- Last Page Button -->
        {if $end_page < $pagination.total_pages}
            {if $end_page < $pagination.total_pages - 1}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
            <li><a href="?ulbid=250&page={$pagination.total_pages}{$filter_query}">{$pagination.total_pages}</a></li>
        {/if}

        <!-- Next Button -->
        {if $pagination.current_page < $pagination.total_pages}
            <li><a href="?ulbid=250&page={$pagination.current_page + 1}{$filter_query}">Next &raquo;</a></li>
        {/if}
    </ul>
</nav>
<!-- option2 pagination end -->













	</div>
	 

</div>
		
		
		
		
    </div>
    <br />
    <br />
    <br />
    <script language="javascript" type="text/javascript">
        function get_streets(ward_id) {
            var select = document.getElementById("street_id");
            select.options.length = 0;
            if (window.XMLHttpRequest)
                xmlhttp = new XMLHttpRequest();
            else
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var strArray = xmlhttp.responseText.split("___");
                    var j = strArray.length;
                    for (i = 0; i < j; i++) {
                        var optArray = strArray[i].split(":::");
                        if (optArray[0] == '0')
                            select.options[select.options.length] = new Option('All', '%');
                        else
                            select.options[select.options.length] = new Option(optArray[1], optArray[0]);
                    }
                }
            }
            xmlhttp.open("GET", "get_streets.php?ward_id=" + ward_id, true);
            xmlhttp.send();
        }
        function validateForm() {
            var mobile = document.controlroom_check_comp_status.mobile.value;
            var patt = /^[7-9]\d{9}$|^$/;
            if (!patt.test(mobile)) {
                alert("Please Enter Valid Mobile No");
                return false;
            }
            return true;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        $(function () {
            var dates = $("#from_date, #to_date").datepicker({
				dateFormat: 'yy-mm-dd',
				minDate: '2024-09-01',
				changeMonth: true,
				changeYear: true
            });
        });
      
    </script>

	</div>
      {include file='footer_cust_fields_print.tpl'}
</div>

<strong></strong><br />

{literal}
<script language="javascript" type="text/javascript">
    var table2_Props = {
        col_0: "none",
        col_1: "select",
        col_3: "select",
        col_5: "select",
        col_6: "none",
        display_all_text: " [ Show all ] ",
        sort_select: true,
        paging: true,
        paging_length: 6,
        alternate_rows: true
    };
    setFilterGrid("example", table2_Props);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
      document.getElementById("exportBtn").addEventListener("click", function () {
        // Get the table and specify the columns to export (0-based index)
        const table = document.getElementById("CallCenterTable");
        const selectedColumns = [0,1, 2, 3,4,6,7,8,9]; // Export "Name", "Email", and "City"

        // Extract data for the selected columns
        const rows = [];
        for (let i = 0; i < table.rows.length; i++) {
            const row = [];
            selectedColumns.forEach((colIndex) => {
                row.push(table.rows[i].cells[colIndex].innerText);
            });
            rows.push(row);
        }

        // Create a workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows);

        // Auto-adjust column widths
        const colWidths = rows[0].map((_, colIndex) => {
            const maxWidth = rows.reduce((max, row) => Math.max(max, row[colIndex].length), 0);
            return { wch: maxWidth + 2 }; // Add padding
        });
        worksheet["!cols"] = colWidths;

        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Custom Table");

        // Export to Excel
        XLSX.writeFile(workbook, "CallCenterTable.xlsx");
    });
</script>
{/literal}

{include file='footer.tpl'}