{include file='header.tpl'}
{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css" media="all">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> Data Table CSS -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
	 body {
    
	  background-color:#E8E8E8 !important;
      /* Adjust margins as needed */
    }
</style>
<style>

.modal {
  display: none;
  position: fixed; 
  z-index: 1; 
  padding-top: 10px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4); 
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
<style>
.rating { 
width: 200px; 
margin-top: 10px;
padding: 4px 6px 0; 
height: 33px; 
overflow: hidden;
display: inline-block 
}
.rating-input { 
position: absolute; 
left: 0; 
display: none 
}
.rating-star { 
display: block; 
float: right; 
width: 17px; 
height: 17px; 
margin-top: 1px; 
margin-left: 0; 
background: url(images/starimg1.png) 0 0px;
cursor: pointer; 
}

.rating-star1 { 
display: block; 
float: right; 
width: 17px; 
height: 17px; 
margin-top: 1px; 
margin-left: 0; 
background: url(images/starimg.png) 0 0px;
cursor: pointer; 
}

.rating-star1:hover, .rating-star1:hover~.rating-star1, .rating-input:checked~.rating-star1 { 
background-position: 0 15px 
}
.rating-star:hover, .rating-star:hover~.rating-star, .rating-input:checked~.rating-star { 
background-position: 0 15px 
}

</style>

<style>
.erating { 
width: 200px; 
margin-top: 10px;
padding: 4px 6px 0; 
height: 33px; 
overflow: hidden; 
display: inline-block 
}
.erating-input { 
position: absolute; 
left: 0; 
display: none 
}
.erating-star { 
display: block; 
float: right; 
width: 17px; 
height: 17px; 
margin-top: 1px; 
margin-left: 0; 
background: url(images/starimg1.png) 0 0px 
}
 .erating-input:checked~.erating-star { 
background-position: 0 15px 
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
<script>
    $(document).ready(function() {
        $(".datepick").datepicker({
            maxDate: +2000,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });

    });
</script>
<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
{/literal}

<div class="">
	<form method="POST" action="" class="form-horizontal">
		<div class="boxed">
			
			<div class="inner no-radius" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important;">
				<div class="col-md-3" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Select department</label>
						<select class="select2 form-select" name="department_id">						
							{foreach from=$dept_list key=k item=v}
								{if $department_id == $k}
									<option value='{$k}' selected>{$v}</option>
								{else}  
									<option value='{$k}'>{$v}</option>
								{/if}
							{/foreach}							
						</select>
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">Grievance Id</label>
						<input type="text" class="form-control" name="ref_no" value="{$ref_no}" placeholder="enter grievance id" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">From Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="f_date" value="{$fdate}" placeholder="Select Date" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2" style="margin-right:15px;">
					<div class="form-group">
						<label class="control-label col-sm-12" style="text-align:left; padding-left:0px; margin-bottom:5px;">To Date:</label>
						<input type="text" class="phone-group form-control datepicker" name="t_date" value="{$tdate}" placeholder="Select Date" autocomplete="off">
					</div>
				</div>
				
				<div class="col-md-2">
					<div class="form-group" style="margin-top:31px;">
						<input name="search" type="submit" class="btn btn-success" value="Search">
					<a class="btn btn-dark" style="color:#FFF" href="">Reset</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="boxed">
	<div class="title-bar blue d-flex justify-content-between align-items-center">
		<h4>Remark/Rating Report on Completed Grievances</h4>
		<!-- <p class="m-0"><a href="ajax_dashboard.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p> -->
		<p class="m-0"><a href="reports.php" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a></p>
	</div>



	<div class="inner no-radius">
		<caption style="caption-side:top; text-align:center;font-size:16px;">
			<b>
				<CENTER><strong>REMARK/RATING REPORT ON COMPLETED GRIEVANCES</strong></CENTER>
			</b>
		</caption>
		<div style="color:red;text-align:center";><h3>{if isset($msg)}{$msg}{/if}</h3></div>		
		
				<div id="demo">
					
					<div >
					<div  id="area" class="table-responsive">
					<table id='example' cellpadding="3" cellspacing="0" border="1" class="display table-bordered table-striped table-condensed cf" width="100%">
						
						<thead>
							<tr style="background-color:#2c3e50;">
								<th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>S.No</font></th>
								<th  class="text-center" align='left' colspan="2"><font color='white'>Grievance</font></th>
								<th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>Department</font></th>
								<th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>Zone</font></th>
								<th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>Name & Mobile</font></th>
								
								<th  class="text-center" align='left' colspan='2'><font color='white'>Date</font></th>
							  
								<th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>Days Required</font></th>
								<!--<th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>Remark</font></th>
								 <th  class="text-center" align='left' rowspan='2' style='vertical-align:middle' ><font color='white'>Rating</font></th> -->
								
								<th  class="text-center" align='left' rowspan='2'><font color='white'>Action Taken</font></th> 
								<th  class="text-center" align='left' colspan='2'><font color='white'>Image</font></th> 
								{if $user_type eq 'U' or ($smarty.session.user_type eq 'E' and $smarty.session.hod_status eq 1) or ($smarty.session.user_type eq 'E' and $smarty.session.hod_status2 eq 1)}
									<th  class="text-center" align='left' colspan='3'><font color='white'>Feedback for Employee</font></th> 
								{elseif $smarty.session.user_type eq 'E'}
									<th  class="text-center" align='left' colspan='2'><font color='white'>Feedback</font></th> 
								{/if}
							</tr>
							<tr style="background-color:#2c3e50;">
								<th  class="text-center" align='left'><font color='white'>Id</font></th>
								<th  class="text-center" align='left'><font color='white'>Type</font></th>
								
								<th  class="text-center" align='left'><font color='white'>Recieved</font></th>
								<th  class="text-center" align='left'><font color='white'>Closing</font></th>
							  
							
								<th  class="text-center" align='left'><font color='white'>Before</font></th> 
								<th  class="text-center" align='left'><font color='white'>After</font></th>
								{if $user_type eq 'U'  or ($smarty.session.user_type eq 'E' and $smarty.session.hod_status eq 1)  or ($smarty.session.user_type eq 'E' and $smarty.session.hod_status2 eq 1)}
									<th  class="text-center" align='left'><font color='white'>Remarks</font></th> 
									<th  class="text-center" align='left'><font color='white'>Rating</font></th>
									<th  class="text-center" align='left'><font color='white'>Action</font></th>
								{elseif $smarty.session.user_type eq 'E'}
									<th  class="text-center" align='left' ><font color='white'>Remarks</font></th> 
									<th  class="text-center" align='left'><font color='white'>Rating</font></th>
								{/if}
							</tr>
						</thead>
						<tbody>
							
							
							
							{foreach from=$data key=grievance_id item=row}
							{if $row.dept_id!=0}
							<input type="hidden" name="app_type_id" value="{$row.app_type_id}">
							<input type="hidden" name="cs_id" value="{$row.cat3_id}">
							<tr>
								<td class="text-center">{counter}</td>

								{if $ulbid eq '207'}
									{if $row.app_type_id eq '2'}
										<td>{$row.grievance_id}</td>
									{else}
										<td><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
									{/if}
								{else}
									<td class="text-center"><a href="view_comp_det_admin.php?grievance_id={$grievance_id}">{$grievance_id}</a></td>
								{/if}
								
								<td>
									{if $row.app_type_id eq '2'}
										Citizen Charter Counter
									{else}
										{$cat_list[$row.cat3_id]}
									{/if}	
								</td>
								<td>
									{if $row.app_type_id eq '2'}
										Citizen Charter Counter
									{else}
										{$dept_list[$row.dept_id]}
									{/if}	
								</td>
									
								<td>{$ward_list[$row.ward_id]}</td>
								
								<td>{$row.person_name} ({$row.mobile})</td>
								
								{if $row.app_type_id eq '1'}
									<td >
									{$row.date_regd}
									</td>
								{else}
									<td >{$row.date_regd}</td>
								{/if}
								<td>{$row.disposed_date}</td>
								
								<td class="text-center">
									{$cut_of_days[$row.cat3_id]} days
								</td>
								<td class="text-center">
										{if strlen($row.disposal_remarks)<=20} {$row.disposal_remarks} {else} <span style="cursor:pointer;color:blue" title="{$row.disposal_remarks}" id="myBtn{$grievance_id}" onclick="myFun(this)"> {substr($row.disposal_remarks,0,20)}...more</span>{/if}
									
								</td>
								<!-- <td>Rating</td> -->
								<td class="text-center">{if !empty($row.previous) } <button class="btn btn-info" type="button" id="myBtn{counter}" onclick="myFun(this)" value={$row.previous}>View</button> {else} {'NA'} {/if}</td>
								<td class="text-center">{if !empty($row.after) } <button class="btn btn-success" type="button" id="myBtn{counter}" onclick="myFun(this)" value={$row.after}>View</button> {else} {'NA'} {/if}</td>
								
								{if $smarty.session.user_type eq 'U' or ($smarty.session.user_type eq 'E' and $smarty.session.hod_status eq 1) or ($smarty.session.user_type eq 'E' and $smarty.session.hod_status2 eq 1)}
								<form  method="POST" action="details_of_completed_grievance_report.php" id="form-id-{$grievance_id}" name="form_name{$grievance_id}">
									
									<td>
										<textarea rows="2" id="tarea{$grievance_id}" name="remarks[{$grievance_id}]">{$rating_list[$grievance_id]['feedback_desc']}</textarea>
									
									</td>
									
									<td class="text-center">	
										<input type="hidden" name="emp_details[{$grievance_id}][emp_id]" value="{$row.emp_id}" />
										<input type="hidden" name="emp_details[{$grievance_id}][dept_id]" value="{$row.dept_id}" />
						
											<div class="rating">
												<span>	
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-10" value="10" name="rating_list[{$grievance_id}]" {if $rating_list[$grievance_id]['rating_no']==10} checked {/if} >
													<label for="rating-input-{$grievance_id}-10" class="rating-star" title="10"></label>			
													
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-9" value="9" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==9} checked {/if} >
													<label for="rating-input-{$grievance_id}-9" class="rating-star" title="9"></label>			
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-8" value="8" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==8} checked {/if} >
													<label for="rating-input-{$grievance_id}-8" class="rating-star" title="8"></label>			
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-7" value="7" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==7} checked {/if} >
													<label for="rating-input-{$grievance_id}-7" class="rating-star" title="7"></label>			
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-6" value="6" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==6} checked {/if} >
													<label for="rating-input-{$grievance_id}-6" class="rating-star" title="6"></label>			
													
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-5" value="5" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==5} checked {/if} >
													<label for="rating-input-{$grievance_id}-5" class="rating-star" title="5"></label>			
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-4" value="4" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==4} checked {/if} >
													<label for="rating-input-{$grievance_id}-4" class="rating-star" title="4"></label>
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-3" value="3" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==3} checked {/if} >
													<label for="rating-input-{$grievance_id}-3" class="rating-star" title="3"></label>
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-2" value="2" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==2} checked {/if} >
													<label for="rating-input-{$grievance_id}-2" class="rating-star" title="2" ></label>
													<input type="radio" class="rating-input" id="rating-input-{$grievance_id}-1" value="1" name="rating_list[{$grievance_id}]"  {if $rating_list[$grievance_id]['rating_no']==1} checked {/if} >
													<label for="rating-input-{$grievance_id}-1" class="rating-star" title="1" ></label>
													<!-- <input type="radio" class="rating-input" id="rating-input-{$grievance_id}-0" value="0" name="rating_list[{$grievance_id}]"  >
													<label for="rating-input-{$grievance_id}-0" class="rating-star1" title="0" ></label> -->
												</span>											
											</div>	
																			
									</td>
									<td><button type="button" class="btn btn-success btn-sm" id="form-id-{$grievance_id}"  onclick="document.form_name{$grievance_id}.submit();" name="save" value="Save">Submit</button></td>
									</form>	
									
								{elseif $smarty.session.user_type eq 'E'}
									<td>
										{if strlen($rating_list[$grievance_id]['feedback_desc'])<=20} {$rating_list[$grievance_id]['feedback_desc']} {else} <span style="cursor:pointer;color:blue" title="{$rating_list[$grievance_id]['feedback_desc']}" id="myBtn{$grievance_id}" onclick="myFun(this)"> {substr($rating_list[$grievance_id]['feedback_desc'],0,20)}...more</span>{/if}
									</td>
									<td class="text-center">
										<div id="eform-id-{$grievance_id}" name="eform_name{$grievance_id}">
											<div class="erating">
												<span>	
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-10" value="10"  {if $rating_list[$grievance_id]['rating_no']==10} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-10" class="erating-star" title="10"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-9" value="9"  {if $rating_list[$grievance_id]['rating_no']==9} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-9" class="erating-star" title="9"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-8" value="8"  {if $rating_list[$grievance_id]['rating_no']==8} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-8" class="erating-star" title="8"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-7" value="7"  {if $rating_list[$grievance_id]['rating_no']==7} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-7" class="erating-star" title="7"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-6" value="6"  {if $rating_list[$grievance_id]['rating_no']==6} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-6" class="erating-star" title="6"></label>			
													
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-5" value="5"  {if $rating_list[$grievance_id]['rating_no']==5} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-5" class="erating-star" title="5"></label>			
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-4" value="4"  {if $rating_list[$grievance_id]['rating_no']==4} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-4" class="erating-star" title="4"></label>
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-3" value="3"  {if $rating_list[$grievance_id]['rating_no']==3} checked {/if} onclick="return false;">
													<label for="erating-input-{$grievance_id}-3" class="erating-star" title="3"></label>
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-2" value="2"  {if $rating_list[$grievance_id]['rating_no']==2} checked {/if} onclick="return false;" >
													<label for="erating-input-{$grievance_id}-2" class="erating-star" title="2" readonly></label>
													<input type="radio" class="erating-input" id="erating-input-{$grievance_id}-1" value="1"  {if $rating_list[$grievance_id]['rating_no']==1} checked {/if} onclick="return false;" >
													<label for="erating-input-{$grievance_id}-1" class="erating-star" title="1" readonly></label>
												</span>	
											</div>
										</div>
									</td>
								{/if}
								
								{/if}
							</tr>
							{/foreach}
							
							
							
						</tbody>
								<!--<tfoot>
									<td align='center' colspan="2"><strong>Total</strong></td>
									<td align='center'><strong>{$total}</strong></td>
									{foreach from=$ward_list item=row2 key=ward_id}
										<td align='center'><strong>{$tot_wards[$ward_id]['total']}</strong></td>
									{/foreach}
								</tfoot>-->
					</table>
					</div>
					
					</div>
				</div>
						
			
			<!-- Modal -->
			<div id="myModal" class="modal">

			  <div class="modal-content">
				<div class="justify-content-end">
					<span class="close">&times;</span>
				</div>
				<p id="cnt">data displaying</p>
			  </div>

			</div>
			
	
			
		</div>
		
	</div>

	<br>
	<div>
		<center>
			<form action="exporttoexcel.php" method="post">
				<input type="button" onclick="tableToExcel()" class="btn btn-success" value="Export to Excel" />
				<button type='button' class="btn btn-primary" id="download-pdf" onclick="exportTableToPDF('example', 'GrievanceReport')" value="Dashboard"></i> Export To PDF</button>
				<input type='button' value='Print' onclick="print_div()" class="btn btn-danger" />
			</form><br>
		</center>
	</div>



<br>

{include file='footer.tpl'}

{literal}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

<script>
	function submitForm(elem)
	{
	   document.getElementById("form").submit();
	}
</script>

<script>

	var modal = document.getElementById("myModal");
	var span = document.getElementsByClassName("close")[0];

	function myFun(elem) {
		var mybtn = document.getElementById(elem.id);
		var cnt = document.getElementById("cnt");
		var img1=mybtn.value;
		modal.style.display = "block";
		cnt.innerHTML="<img src="+img1+" alt='Image' style='width:100%;height:100%;'>";
	}

	span.onclick = function() {
	  modal.style.display = "none";
	}

	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}

</script>

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
	$(".num").keydown(function(event) {
		// Allow only backspace and delete
		if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
			// let it happen, don't do anything
		} else {
			// Ensure that it is a number and stop the keypress
			if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
				event.preventDefault();
			}
		}
	});
</script>

<script>
    $(function() {
        $(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });
</script>

<script>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> 
<script>
 /* function tableToExcel(tabname,sheetname) {
            // Get table data
            var table = document.getElementById("example");
            var data = [];

            // Loop through table rows and cells to build data array
            for (var i = 0, row; row = table.rows[i]; i++) {
                var rowData = [];
                for (var j = 0, col; col = row.cells[j]; j++) {
                    rowData.push(col.innerText);
                }
                data.push(rowData);
            }

            // Create a new workbook
            var wb = XLSX.utils.book_new();

            // Convert table data into a worksheet
            var ws = XLSX.utils.aoa_to_sheet(data);

            // Append worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, sheetname);

            // Custom file name for the Excel file
            var customFileName = tabname+".xlsx";

            // Export workbook to Excel file
            XLSX.writeFile(wb, customFileName);
        }*/
</script>
{/literal}