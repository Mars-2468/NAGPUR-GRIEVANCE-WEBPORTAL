{include file='header.tpl'}
{literal}

<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="actb.js"></script>
<script language="javascript" type="text/javascript" src="tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
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
			<div>List of ratingwise complaints</div>			
			<div style=""><a href="controlroom_feedback_report.php" class="btn btn-sm btn-warning pull-right">Back</a></div>	
		</div>
      
	</div>
    
	<div class="inner no-radius table-responsive">
    <div>
        <div>           
           
			<div id="area" class="container" style="margin-top: 15px;">
              
                {if isset($data)}
				
					
				<p>	
					<div class="row col-md-12">
						<div class="col-sm-6">
							<strong> <span style='color: red'> </span></strong>
						</div>
						<div class="col-sm-3"></div>
						<div class="col-sm-3 bg-success"><span class="" style="padding:5px">Total number of complaints : {$fb_status}</span> </div>
					</div>
				</p>
				
                <div class="table table-responsive">
                <table id="data-table" width="100%" border="1" cellpadding="0" cellspacing="0" class="table" style="font-size: 13px;">
                    <tr style="background-color: #3366CC; color: #FFF;">
                        <th align="center" valign="middle" scope="col" style="width: 40px;">S.No</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Complaint No</th>
                        <th align="center" valign="middle" scope="col" style="width: 120px;">Name & Mobile</th>
                        <th align="center" valign="middle" scope="col" style="width: 150px;">Address</th>
                        <th align="center" valign="middle" scope="col" style="width: 300px;"><div style="width: 300px;">Complaint Details</div></th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Rating</th>
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Feedback</th>  
						<th align="center" valign="middle" scope="col" style="width: 100px;">Feedback From</th>						
                        <th align="center" valign="middle" scope="col" style="width: 100px;">Status</th>                        
                    </tr>
                    {foreach from=$data key=grievance_id item=row}
                    <tr>
                        <td align="center" valign="middle" style="width: 40px;">{$pageNumber++}</td>
                        <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;"><a href="controlroom_view_comp_det.php?grievance_id={$grievance_id}&id={$ulbid}" style="color: #FF6600;">{$data[$row['grievance_id']]['grievance_id']}</a></td>
                        <td align="center" valign="middle" style="width: 120px; word-wrap: break-word;">{$data[$row['grievance_id']]['person_name']} ({$data[$row['grievance_id']]['mobile']})</td>
                        <td align="center" valign="middle" style="width: 150px; word-wrap: break-word;"><div style="width: 150px; padding: 0px 5px 0px 5px;">{$data[$row['grievance_id']]['hno']}, {$data[$row['grievance_id']]['address']}</div></td>
                        
						<td align="center" valign="middle" style="width: 300px; word-wrap: break-word; text-align: justify; padding: 0px 10px 0px 10px;">
                            <div style="width: 300px; word-wrap: break-word;">{if $data[$row['grievance_id']]['comp_desc'] eq ''}
								N/A.{elseif $data[$row['grievance_id']]['comp_desc'] neq ''}{$data[$row['grievance_id']]['comp_desc']}{/if}
                            </div>
                        </td> 
						<td align="center" valign="middle" style="width: 100px; word-wrap: break-word;">
							{if $data[$row['grievance_id']]['rating_no']!=0}
								{$data[$row['grievance_id']]['rating_no']}&nbsp;<i class="fa fa-star" style="color:#ff9900"></i>
							{/if}
						</td>
						
						 <td align="center" valign="middle" style="width: 40px;">
						    <div style="width: 300px; word-wrap: break-word;">
							{if $data[$row['grievance_id']] eq ''}
								-
							{elseif $data[$row['grievance_id']] neq ''}
								{$data[$row['grievance_id']]['comment_desc']}
							{/if}
                            </div>
						 </td>
						 <!-- <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;">
                           
                           {$grievance_status_list[$data[$row['grievance_id']]['grievance_status_id']]}
							
                        </td> -->
						
						   <td>{$user_list[$row.rating_given_by]}</td>
                        <td align="center" valign="middle" style="width: 100px; word-wrap: break-word;">
                           
                            {if $grievance_status_list[$data[$row['grievance_id']]['grievance_status_id']]|in_array:[3,6,8,9,12]  && $row.feedback_status eq 0}
								-
                            {else}
								{$grievance_status_list[$data[$row['grievance_id']]['grievance_status_id']]}
							{/if}
                        </td>
                   
                    </tr>
                    {/foreach}
                </table>
                </div>
                {/if}
                <div style="padding-left: 125px; padding-top: 25px; font-size: 11px;"></div>
            </div>
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
            <li><a href="?page={$pagination.current_page - 1}{$filter_query}">&laquo; Prev</a></li>
        {/if}

        <!-- First Page Button -->
        {if $start_page > 1}
            <li><a href="?page=1{$filter_query}">1</a></li>
            {if $start_page > 2}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
        {/if}

        <!-- Visible Page Numbers -->
        {section name=pages start=$start_page loop=$end_page}
            <li class="{if $pagination.current_page == $smarty.section.pages.index+1}active{/if}">
                <a href="?page={$smarty.section.pages.index+1}{$filter_query}">{$smarty.section.pages.index+1}</a>
            </li>
        {/section}

        <!-- Last Page Button -->
        {if $end_page < $pagination.total_pages}
            {if $end_page < $pagination.total_pages - 1}
                <li class="disabled"><a href="#">...</a></li>
            {/if}
            <li><a href="?page={$pagination.total_pages}{$filter_query}">{$pagination.total_pages}</a></li>
        {/if}

        <!-- Next Button -->
        {if $pagination.current_page < $pagination.total_pages}
            <li><a href="?page={$pagination.current_page + 1}{$filter_query}">Next &raquo;</a></li>
        {/if}
    </ul>
</nav>
<!-- option2 pagination end -->
		  {include file='footer_print.tpl'}
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
{/literal}
<div>
</div>

{include file='footer.tpl'}