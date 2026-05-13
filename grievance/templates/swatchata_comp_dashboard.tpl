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
</style>
<script>
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

</script>






{/literal}

  <!-- Breadcrumbs Start -->

  <!-- Breadcrumbs End -->
  
  {if $user_type eq 'A' || $user_type eq 'U' || $user_type eq 'E' || $user_type eq 'R'}
  
  
  
  
<br>
  
  
  
  
  
  
  
  
                  
                  
                  
                    
                
                <div class="row">
                
                <div>
                <div class="nav-tabs-custom">
			<ul class="navs nav-tabs panel-info" style="background-color: #ccf4ff;">
				<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Complaints</a></li>
				<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Services</a></li>
				<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Origin Wise</a></li>
				
				
			</ul>
			
		<div class="tab-content" style="background-color: #F2F7FF;">
			<div class="tab-pane active" id="tab_1">
			   
				<div class="">
			<div class="boxed">
                <!-- Title Bart Start -->
                <!-- <h4>Total Number of Complaints</h4>-->
               <div class="bash_heading row  m-b20"> Total Number of Complaints  </div> 
                <!-- Title Bart End -->
                <div >
				
                <div class="row dashboard-stats">
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-cloud-download text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"> {if $data[1].total_received eq ''}0{else}{if $user_type == 'A' || $user_type == 'E'}<a href="cdma_ulbwise_report.php?status=0&app_type_id=1">{$data[1].total_received}</a>{else}<a href="services.php?aptid=1&status=0&user_type={$user_type}&sla=0">{$data[1].total_received}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Received</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-minus-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <!--<p class="size-h1 no-margin countdown_first">{if $data[1].pendingforapproval eq ''}0{else}<a href="pending_approval.php?grievance_status_id=1&aptid=1">{$data[1].pendingforapproval}</a>{/if}</p>-->
                                    <p class="size-h1 no-margin countdown_first">{if $data[1].pendingforapproval eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=1&app_type_id=1">{$data[1].pendingforapproval}</a>{else}<a href="view_pending_approval.php?app_type_id=1">{$data[1].pendingforapproval}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Pending for Approval</span></p>
                                </div>
                            </section>
                        </div>
                        {assign var="pending_beyond_sla" value=6}
                        {assign var="pending_within_sla" value=$data[1].pending_within_sla + $data[1].pending_beyond_sla - 6}
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-check-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[1].resolved_within_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=2&app_type_id=1">{$data[1].resolved_within_sla}</a>{else}<a href="services.php?aptid=1&status=3&sla=1&user_type={$user_type}">{$data[1].resolved_within_sla}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed with in SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa text-large stat-icon "><img src="images/Beyond-icon.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[1].resolved_beyond_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=3&app_type_id=1">{$data[1].resolved_beyond_sla}</a>{else}<a href="services.php?aptid=1&status=3&sla=2&user_type={$user_type}">{$data[1].resolved_beyond_sla}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Completed Beyond SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-refresh text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[1].pending_within_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=4&app_type_id=1">{$data[1].pending_within_sla}</a>{else}{if $uid == 'Boduppal' || $uid == 'boduppal'}{$pending_within_sla}{else}<a href="services.php?aptid=1&status=2&sla=1&user_type={$user_type}">{$data[1].pending_within_sla}</a>{/if}{/if}{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress with in SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-vimeo">
                                    <i class="fa text-large stat-icon"><img src="images/under-pro.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[1].pending_beyond_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=5&app_type_id=1">{$data[1].pending_beyond_sla}</a>{else}{if $uid == 'Boduppal' || $uid == 'boduppal'}{$pending_beyond_sla}{else}<a href="services.php?aptid=1&status=2&sla=2&user_type={$user_type}">{$data[1].pending_beyond_sla}</a>{/if}{/if}{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Under Progress Beyond SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                         <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-inr text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[1].fin_implication eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=6&app_type_id=1">{$data[1].fin_implication}</a>{else}<a href="services.php?aptid=1&status=500&user_type={$user_type}">{$data[1].fin_implication}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Financial Implication</span></p>
                                </div>
                            </section>
                        </div>
                        
                         <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
                                    <i class="fa fa-envelope text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $feedback_count eq ''}0{else}<a href="smart_idea.php">{$feedback_count}</a>{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Feedback</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        

                            
                    </div>
                
                
                
				</div>
			</div>
		</div>
				
				
			</div><!-- /.tab-pane -->
			
			
			<div class="tab-pane" id="tab_2">
				 <div class="">           
                              
                
			<div class="boxed">
                <!-- Title Bart Start 
                 <h4>Total Number of Service Requests</h4>-->
               <div class="bash_heading row  m-b20"> Total Number of Service Requests  </div> 
                <!-- Title Bart End -->
                <div >
				
                <div class="row dashboard-stats">
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-cloud-download text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].total_received eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=0&app_type_id=2">{$data[2].total_received}</a>{else}<a href="services.php?aptid=2&status=0&user_type={$user_type}&sla=0">{$data[2].total_received}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Received</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-minus-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].pendingforapproval eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=1&app_type_id=2">{$data[2].pendingforapproval}</a>{else}<a href="view_pending_approval.php?app_type_id=2">{$data[2].pendingforapproval}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Pending for Approval</span></p>
                                </div>
                            </section>
                        </div>
                        {assign var="pending_beyond_sla" value=2}
                        {assign var="pending_within_sla" value=$data[2].pending_within_sla + $data[2].pending_beyond_sla -2}
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-check-circle text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].resolved_within_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=2&app_type_id=2">{$data[2].resolved_within_sla}</a>{else}<a href="services.php?aptid=2&status=3&sla=1&user_type={$user_type}">{$data[2].resolved_within_sla}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Completed with in SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa text-large stat-icon "><img src="images/Beyond-icon.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].resolved_beyond_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=3&app_type_id=2">{$data[2].resolved_beyond_sla}</a>{else}<a href="services.php?aptid=2&status=3&sla=2&user_type={$user_type}">{$data[2].resolved_beyond_sla}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Completed Beyond SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-instagram">
                                    <i class="fa fa-refresh text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].pending_within_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=4&app_type_id=2">{$data[2].pending_within_sla}</a>{else}{if $uid == 'Boduppal' || $uid == 'boduppal'}{$pending_within_sla}{else}<a href="services.php?aptid=2&status=2&sla=1&user_type={$user_type}">{$data[2].pending_within_sla}</a>{/if}{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Under Progress with in SLA</span></p>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-vimeo">
                                    <i class="fa text-large stat-icon "><img src="images/under-pro.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].pending_beyond_sla eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=5&app_type_id=2">{$data[2].pending_beyond_sla}</a>{else}{if $uid == 'Boduppal' || $uid == 'boduppal'}{$pending_beyond_sla}{else}<a href="services.php?aptid=2&status=2&sla=2&user_type={$user_type}">{$data[2].pending_beyond_sla}</a>{/if}{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Under Progress Beyond SLA</span></p>
                                </div>
                            </section>
                        </div>
						
						
						 <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa text-large stat-icon "><img src="images/under-pro.png"/></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first">{if $data[2].fin_implication eq ''}0{else}{if $user_type eq 'A'}<a href="cdma_ulbwise_report.php?status=6&app_type_id=2">{$data[2].fin_implication}</a>{else}<a href="services.php?aptid=2&status=500&user_type={$user_type}">{$data[2].fin_implication}</a>{/if}{/if}</p>
                                    <p class="text-muted no-margin "><span style="color:#000;">Financial Implication</span></p>
                                </div>
                            </section>
                        </div>
                        
                        
                        
                        
                        
                        

                            
                    </div>
                
                
                
				</div>
			</div>
		</div>
			</div><!-- /.tab-pane -->
			
			<div class="tab-pane" id="tab_3">
				<div class="">
		<div class="boxed">
                <!-- Title Bart Start -->
                <!-- <h4>Total Number of Complaints</h4>-->
               <div class="bash_heading row  m-b20"> Complaints Origin wise report  </div> 
                <!-- Title Bart End -->
                <div >
				
				 <div class="row dashboard-stats">
                        <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-success">
                                    <i class="fa fa-cloud-download text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"> {if $data[1].total_received eq ''}0{else}<a href="services.php?aptid=1&status=0&user_type={$user_type}">{$data[1].total_received}</a>{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Over all</span></p>
                                </div>
                            </section>
                        </div> 
						
						
						 <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-lovender">
                                    <i class="fa fa-globe text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"> {if $origin_rep[0].count eq ''}0{else}<a href="cat_origin.php?originid=0">{$origin_rep[0].count}</a>{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Website</span></p>
                                </div>
                            </section>
                        </div>
						
						 <div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-info">
                                    <i class="fa fa-phone-square text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"> {if $origin_rep[2].count eq ''}0{else}<a href="cat_origin.php?originid=2">{$origin_rep[2].count}</a>{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Telephone</span></p>
                                </div>
                            </section>
                        </div>
						
						<div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-vimeo">
                                    <i class="fa fa-desktop text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"> {if $origin_rep[3].count eq ''}0{else}<a href="cat_origin.php?originid=3">{$origin_rep[3].count + $origin_rep[1].count}</a>{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">Counter</span></p>
                                </div>
                            </section>
                        </div>
						
						<div class="col-md-4 col-sm-6">
                            <section class="panel panel-box">
                                <div class="panel-left panel-icon bg-danger">
                                    <i class="fa fa-android text-large stat-icon "></i>
                                </div>
                                <div class="panel-right panel-icon bg-reverse">
                                    <p class="size-h1 no-margin countdown_first"> {if $origin_rep[4].count eq ''}0{else}<a href="cat_origin.php?originid=4">{$origin_rep[4].count}</a>{/if}</p>
                                    <p class="text-muted no-margin"><span style="color:#000;">App</span></p>
                                </div>
                            </section>
                        </div>
						
						
						
				
				</div>
		</div>
			</div><!-- /.tab-pane -->
		</div><!-- /.tab-content -->
	</div>
                
      </div>
                
   </div>
                
                
                
               
        
        {if $tanker_enable_status eq '1'}
     
                     
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
        
        
        
        <div class="">
						      <div class="boxed">
                                 <!-- Title Bart Start -->
								<div class="title-bar white">
								  <h4>Service Mapping Report</h4>
								 
								</div>
								<!-- Title Bart End -->
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
						
					</tr>-->
				</tbody>
				
				</table>		
											
                               
                                 </div>
                              </div>
						   </div>
        
        
        
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
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
{include file='footer.tpl'}

				
					
			  


