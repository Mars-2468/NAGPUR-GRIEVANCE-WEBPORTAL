{include file='boduppal_header.tpl'}

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
$(document).ready(function()
{
    $("#loading").css('display','block');
    
    $.post('ajax_boduppal_comp_dashboard.php',{},function(data)
    {
        $("#loading").css('display','none');
        $("#result").html(data);
    });
    
    
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
    $.post('ajax_boduppal_comp_dashboard.php',{},function(data)
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
  
  {if $user_type eq 'A' || $user_type eq 'U' || $user_type eq 'E' || $user_type eq 'R'}
  
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
				<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false" onclick="fun1('2')">Services</a></li>
				<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false" onclick="fun1('3')">Origin Wise</a></li>
				
				<li class=""><a href="#" data-toggle="tab" aria-expanded="false" onclick="fun12('{$user_type}','{$ulb}')">Re-opened report</a></li>
				
				
				{if $user_type eq 'A'}
				
				<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false" onclick="fun1('4')">Total </a></li>
				
				{/if}
				
			</ul>
			<div id="loading" style="display:none; text-align:center;">
			   <!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
			    <h4>Please Wait.. </h4>
			    
			</div>
			<span id="result"></span>
			
		
                
                
                
               
        
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
        
        
        
       
        
        
        
        	{if $ulbid eq '052'}
		
                                
                                
                               
		{/if}
        
        
        
        
      
        
	
                    <br><br><br>
                    
                    
                    
  {/if}
  
  
  
  
  
  
  
{include file='footer.tpl'}

				
					
			  


