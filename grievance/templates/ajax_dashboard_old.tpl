{include file='header.tpl'}

{literal}
<style>
.bash_heading{
	border-top: 1px solid #D5DDDF;
    text-align: left;
    padding: 10px !important;
    background-color: #fff;
	clear:both;
	font-weight:bold;
	font-size:16x;
	color:#000;
	}
	.geo_style a {
	    padding:6px;
	    color:blue !important;
	    font-size:18px !important;
	    font-weight:bold;
	}
</style>


<script>
$(document).ready(function()
{
    
    var user_type = $("#user_type").val();
    
   //alert(user_type);
    $("#loading").css('display','block');
    if(user_type == 'M')
    {
        $.post('ajax_complaint_mepmadashboard.php',{},function(data)
        {
          //alert(data);
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    else if(user_type == 'CS')
    {
        $.post('ajax_complaint_supervisordashboard.php',{},function(data)
        {
          //alert(data);
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    else if(user_type == 'C')
    {
        $.post('ajax_complaint_callcenterdashboard.php',{},function(data)
        {
          //alert(data);
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    else if(user_type == 'AG')
    {
        
        $.post('ajax_complaint_agentdashboard.php',{},function(data)
        {
          //alert(data);
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    else
    {
    
        $.post('ajax_complaint_dashboard_old.php',{},function(data)
        {
          //alert(data);
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    
    
});
function get_dists(rdmaid)
{
	$.post('ajax_getdists.php',{rdmaid:rdmaid},function(data)
	{
		$("#distid").html(data);
	});
}


function get_ulbs(distid)
{
	$.post('ajax_getulbs.php',{distid:distid},function(data)
	{
		$("#ulbid").html(data);
	});
}

function fun12(user_type,ulbid)
{
   
    
    $.post("ajax_reopened_report.php",{cat_id:0,user_type:user_type,ulbid:ulbid},function(data)
    {
        //alert(data);
        $("#result").html(data);
        $("#result").css('display','block');
        $("#tabsdata").css('display','none');
    });
}



function fun1(app_type_id)
{
   
    if(app_type_id==1)
    {
        $("#loading").css('display','block');
        $("#result").html('');
    $.post('ajax_complaint_dashboard_old.php',{},function(data)
    {
        $("#loading").css('display','none');
        $("#result").html(data);
    });
    }
    else if(app_type_id==2)
    {
        
        $("#loading").css('display','block');
        $("#result").html('');
        $.post('ajax_service_dashboard.php',{},function(data)
        {
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    else if(app_type_id==3)
    {
        
        $("#loading").css('display','block');
        $("#result").html('');
        $.post('ajax_originwisedashboard.php',{},function(data)
        {
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
    
    else if(app_type_id==4)
    {
        //alert();
        $("#loading").css('display','block');
        $("#result").html('');
        $.post('ajax_total_dashboard.php',{},function(data)
        {
            $("#loading").css('display','none');
            $("#result").html(data);
        });
    }
        
}


</script>







{/literal}

  <!-- Breadcrumbs Start -->

  <!-- Breadcrumbs End -->
  
  {if $user_type eq 'A' || $user_type eq 'U' || $user_type eq 'E' || $user_type eq 'R' || $user_type eq 'M' || $user_type eq 'CS' || $user_type eq 'C' || $user_type eq 'AG'}
  
 <!-- {if $ulb eq '208' || $ulb=='210' || $ulb=='3'}
  <form action="ajax_dashboard.php" method="post">
  <div class="row">
      <div class="col-md-4">
          <label for="village">Select Village :</label>
          <select name="ulbid"  class="form-control">
              <option value="">--select--</option>
              {html_options options=$villages selected=$ulb}
          </select>
      </div>
      <div class="col-md-2" style="margin-top: 25px;">
          <input type="submit" value="Get Report" class="btn btn-success" name="setVillage">
      </div>
  </div>
  </form>
  </br></br>
  
  {/if}-->
  <div class="row">
                
                <div>
                <div class="nav-tabs-custom">
			<ul class="navs nav-tabs panel-info" style="background-color: #ccf4ff;">
				<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" onclick="fun1('1')">Complaints</a></li>
				{if $uid neq 'mepma'}
				{if $user_type neq 'C' && $user_type neq 'AG' && $user_type neq 'CS'}
				<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false" onclick="fun1('2')">Services</a></li>
				<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false" onclick="fun1('3')">Origin Wise</a></li>
				<li class=""><a href="#" data-toggle="tab" aria-expanded="false" onclick="fun12('{$user_type}','{$ulb}')">Re-opened report</a></li>
				<li class=""><a href="old_dashboard.php">Old Dashboard</a></li>
				{/if}
				{/if}
				
				{if $uid eq 'mepma'}
				<li class="geo_style" style="float:right !important;"><a href="http://tsurbandashboard.in/ulb_basic_info.php?sub_cat_id=575" target="_blank">Geographical Dashboard</a></li>
				{/if}
				{if $user_type eq 'A'}
				
				<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false" onclick="fun1('4')">Total </a></li>
				
				{/if}
				
			</ul>
			<div id="loading" style="display:none; text-align:center;">
			   <!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
			    <h4>Please Wait.. </h4>
			    
			</div>
			<span id="result"></span>
			<input type="hidden" id="user_type" value="{$user_type}">
			
		
                
                
                
               
        
        {if $tanker_enable_status eq '1' && $user_type eq 'U'}
     
                     
                     <div class="boxed">
                         
                                 <!-- Title Bart Start -->
									<div class="title-bar blue">
									  <h4>Tanker Request Status</h4>
									  
									</div>
									<!-- Title Bart End -->
                                 <div class="inner no-radius" style="background-color:#F2F7FF;">
								
								<div class="col-md-12">
                                       <div class="col-sm-3">
                                                <section class="panel panel-box">
                                                    <div class="panel-top bg-success">
                                                        <div class="divider divider"></div>
                                                        <i class="size-h1"><img src="images/tanker_icon4.png"/></i>
                                                        <div class="divider divider"></div>
                                                    </div>
                                                    <div class="list-justified-container">
                                                        <ul class="list-justified text-center">
                                                            <li>
                                                                <p class="size-h1" style="color:#000;">{if $tankertot eq ''}0{else}{$tankertot}{/if}</p>
                                                                <p class="text-muted" style="color:#000;">Received</p>
                                                            </li>
                                                           
                                                        </ul>
                                                    </div>
                                                </section>
                                            </div>
                        
                        <div class="col-sm-3">
                            <section class="panel panel-box">
                                <div class="panel-top  bg-danger">
                                    <div class="divider divider"></div>
                                    <i class="size-h1"><img src="images/tanker_icon2.png"/></i>
                                    <div class="divider divider"></div>
                                </div>
                                <div class="list-justified-container">
                                    <ul class="list-justified text-center">
                                        <li>
                                            <p class="size-h1" style="color:#000;">{if $tankers_list[0] eq ''}0{else}{$tankers_list[0]}{/if}</p>
                                            <p class="text-muted" style="color:#000;">Pending</p>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-sm-3">
                            <section class="panel panel-box">
                                <div class="panel-top bg-lovender">
                                    <div class="divider divider"></div>
                                    <i class="size-h1"><img src="images/tanker_icon3.png"/></i>
                                    <div class="divider divider"></div>
                                </div>
                                <div class="list-justified-container">
                                    <ul class="list-justified text-center">
                                        <li>
                                            <p class="size-h1" style="color:#000;">{if $tankers_list[1] eq ''}0{else}{$tankers_list[1]}{/if}</p>
                                            <p class="text-muted" style="color:#000;" >Assigned</p>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-sm-3">
                            <section class="panel panel-box">
                                <div class="panel-top bg-vimeo">
                                    <div class="divider divider"></div>
                                    <i class="size-h1"><img src="images/tanker_icon.png"/></i>
                                    <div class="divider divider"></div>
                                </div>
                                <div class="list-justified-container">
                                    <ul class="list-justified text-center">
                                        <li>
                                            <p class="size-h1" style="color:#000;">{if $tankers_list[2] eq ''}0{else}{$tankers_list[2]}{/if}</p>
                                            <p class="text-muted" style="color:#000;">Completed</p>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        
                   </div>
								
								
								</div>
								
                     </div>
                     
                     
             
       
        {/if}
        
        
        
<!--<div class="">
						      <div class="boxed">
                                 <!-- Title Bart Start --
								<div class="title-bar white">
								  <h4>Service Mapping Report</h4>
								 
								</div>
								<!-- Title Bart End --
                                 <div class="inner no-radius">
										
					<table class="display table-bordered table-striped table-condensed cf" width="100%">
				<thead>
					<tr style="background-color:#2c3e50; color:#FFF;">
						<th>Sno</th>
						<th>Total</th>
						<th>Mapped</th>
						<th>Not Mapped</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Services</td>
						<td><a href='statistics.php?cs_type_id=2&code=0'>{$map.2.total_services}</a></td>
						<td><a href='statistics.php?cs_type_id=2&code=1'>{$map.2.total_services_mapped}</a></td>
						<td><a href='statistics.php?cs_type_id=2&code=2'>{$map.2.total_services_not_mapped}</a></td>
						
					</tr>
					<!--<tr>
						<td>Complaints</td>
						<td><a href='statistics.php?cs_type_id=1&code=0'>{$map.1.total_services}</a></td>
						<td><a href='statistics.php?cs_type_id=1&code=1'>{$map.1.total_services_mapped}</a></td>
						<td><a href='statistics.php?cs_type_id=1&code=2'>{$map.1.total_services_not_mapped}</a></td>
						
					</tr
				</tbody>
				
				</table>		
											
                               
                                 </div>
                              </div>
						   </div>-->
						   
						   
						    <!-- <div class="">
						      <div class="boxed">
                                 <!-- Title Bart Start --
								<div class="title-bar white">
								  <h4>Complaints Mapping Report</h4>
								 
								</div>
								<!-- Title Bart End
                                 <div class="inner no-radius">
										
					<table class="display table-bordered table-striped table-condensed cf" width="100%">
				<thead>
					<tr style="background-color:#2c3e50; color:#FFF;">
						<th>Sno</th>
						<th>Total</th>
						<th>Mapped</th>
						<th>Not Mapped</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Complaints</td>
						<td><a href='statistics.php?cs_type_id=1&code=0'>{$map.total_complaints}</a></td>
						<td><a href='statistics.php?cs_type_id=1&code=1'>{$map.total_complaints_mapped}</a></td>
						<td><a href='statistics.php?cs_type_id=1&code=2'>{$map.total_complaints_not_mapped}</a></td>
						
					</tr>
					<tr>
						<td>Complaints</td>
						<td><a href='statistics.php?cs_type_id=1&code=0'>{$map.1.total_services}</a></td>
						<td><a href='statistics.php?cs_type_id=1&code=1'>{$map.1.total_services_mapped}</a></td>
						<td><a href='statistics.php?cs_type_id=1&code=2'>{$map.1.total_services_not_mapped}</a></td>
						
					</tr
				</tbody>
				
				</table>		
											
                               
                                 </div>
                              </div>
						   </div>-->
        
        
        
        	{if $ulbid eq '052'}
		<div class="row">
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                            <a href="http://mckarimnagar.in/e-news/view.php" target="_blank"><img src="http://mckarimnagar.in/wp-content/uploads/2015/07/enewsletter.jpg" border="1"/></a></div>
										</section>
									</div>
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                           <a href="http://mckarimnagar.in/grievance/register_complaint.php" target="_blank"> <img src="http://mckarimnagar.in/wp-content/uploads/2015/08/grievence.jpg" border="1"/></a>
                                            </div>
										</section>
									</div>
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                           <a href="http://mckarimnagar.in/smart-cities-in-mckarimnagar/" target="_blank"> <img src="http://mckarimnagar.in/wp-content/uploads/2016/09/smart-city.jpg" border="1"/></a>
                                            </div>
										</section>
									</div>
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                           <a href="http://mckarimnagar.in/council/" target="_blank"> <img src="http://mckarimnagar.in/wp-content/uploads/2015/04/item41.jpg" border="1"/></a>
                                            </div>
										</section>
									</div>
								</div>
                                
                                
                                
                                <br>
<div class="row">
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                          <a href="http://125.16.9.166:8080/CDMA_TS_Dashboard/dashboard/assessmentTax.do" target="_blank">  <img src="http://siddipetmunicipality.in/wp-content/uploads/2016/06/img1.jpg" border="1"/></a>
                                            </div>
										</section>
									</div>
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                          <a href="http://125.16.9.166:8080/CDMA_TS_Dashboard/dashboard/vacantLandTaxlist.do" target="_blank"> <img src="http://siddipetmunicipality.in/wp-content/uploads/2016/06/img2.jpg" border="1"/></a>
                                            </div>
										</section>
									</div>
									<div class="col-lg-3">
										<section class="panel">
											<div class="">
                                       <a href="http://125.16.9.166:8080/CDMA_TS_Dashboard/meeSevaMutation/Certificate.do" target="_blank">   <img src="http://siddipetmunicipality.in/wp-content/uploads/2016/06/img3.jpg" border="1"/></a>
                                            </div>
										</section>
									</div>
									<div class="col-lg-3">
										
									</div>
								</div>
		{/if}
        
        
        
        
      
        
	
                    <br><br><br>
                    
                    
                    
  {/if}
  
  
  



<div id="myModal" class="modal fade mt-5">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Collect Property Tax</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
        <p>Now collect Property Tax from Citizen Service Center of your ULB. </p>
                          <div class="row p-3 justify-content-center" style="background-color:#8efaff; ">
                         Click on below link to collect and generate Report
                         <br>
                        <a href="https://cdma.cgg.gov.in/CDMA_ARBS" style="color:#105ce7;" target="_blank">https://cdma.cgg.gov.in/CDMA_ARBS</a>
                        </div>
                        <br>
                        For login information <br>
                        please call <strong> CGG Support number <span style="color:red;">04023120410</span></strong>
                    </div>
                </div>
            </div>
        </div>
  
  
  
  
{include file='footer.tpl'}




				
					
			  


