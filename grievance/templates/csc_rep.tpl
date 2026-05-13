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
<script>

function fun1(frontview,side_view,long_view,pic1,pic2)
{
$("#frontview").html('<img src=' + frontview +' width="200px" height="100px">');
$("#side_view").html('<img src=' + side_view +' width="200px" height="100px">');
$("#long_view").html('<img src=' + long_view +' width="200px" height="100px">');

$("#pic1").html(' <img src=' + pic1 +' width="200px" height="100px">');
$("#pic2").html(' <img src=' + pic2 +' width="200px" height="100px">');



$('#exampleModal').modal('show');
}
</script>


<!--<script>
function fun1(frontview,side_view,long_view,pic1,pic2)
{
$("#frontview").html('<table class="table"><tr><td>Front View :</td><td>Side View :</td></tr><tr><td><img src=' + frontview +' width="200px" height="100px"></td><td><img src=' + side_view +' width="200px" height="100px"></td></tr></table>');

$('#exampleModal').modal('show');

}
</script>-->






{/literal}

  <!-- Breadcrumbs Start -->

  <!-- Breadcrumbs End -->
  
  
  <!--   
  
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="table">
  <tr style="background-color:#24BABC; color:#000;">
    <td>Front View :</td>
    <td>Side View : </td>
    <td>Long View :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background-color:#24BABC; color:#000;">
    <td>Water Facility :</td>
    <td>Seating Facility : </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  
  -->
  
  
  <form action="csc_rep.php" method="POST">
  <div>
<div class="col-md-3">
<div class="form-group">
  <label  for="selectbasic">Select Region</label>
  <div>
    <select id="regionid" name="regionid" class="form-control" onChange="get_dists(this.value)" required>
     <option value="">---select---</option>
     {html_options options=$region_list selected=$preg}
    </select>
  </div>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
  <label for="selectbasic">Select District</label>
  <div>
    <select id="distid" name="distid" class="form-control" onChange="get_ulbs(this.value)">
      <option value="">---select---</option>
      {html_options options=$dist_list2 selected=$pdist}
      
      
    </select>
  </div>
</div>
</div>

<div class="col-md-3"> 
<div class="form-group">
  <label for="selectbasic">Select ULB</label>
  <div>
    <select id="ulbid" name="ulbid" class="form-control">
      <option value="">---select---</option>
      {html_options options=$ulb_list2 selected=$pulb}
      
    </select>
  </div>
</div>
</div>

<div class="form-group">
<input style="margin-top:25px;" type="submit" name="search1" value="Search" class="btn btn-success">
</div>
</div>
  
  </form>
  
  
  
  
  
  
  <div class="row" id="div_print">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>ULB Wise CSC Updation Report</h4>
                  
                </div>
                <!-- Title Bart End id="data-table"-->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="example">
									
										<thead>
		              <th>Name of ULB</th>
									            <th>CSC Status</th>
									            <th>Date Of Started / Expected Date of started</th>
									            <th>No.of Systems</th>
									            <th>No.of Printers</th>
									            <th>No.of Scanners</th>
									            <th>No.of Staff</th>
									            <th>Amenities</th>
									            <th>Photos</th>
									</thead>
									
									<tbody>
									
									{foreach from=$ulb_list1 key=ulbid item=row}
									<tr>
										
										<td>{$ulb_list[$ulbid]}</td>
										        <td>{$status_list[$data[$ulbid].established]}</td>
									            <td>{$data[$ulbid].date|date_format:"%d-%m-%Y"}</td>
									            <td>{$data[$ulbid].systems_provided}</td>
									            <td>{$data[$ulbid].printers_provided}</td>
									            <td>{$data[$ulbid].scanners_provided}</td>
									            <td>{$data[$ulbid].staff_deployed}</td>
									            <td>
									                <div style="width:200px;">
									                {if $data[$ulbid].news_facility eq '1'}
									                News Papers Stand,
									                {/if}
									                
									                {if $data[$ulbid].waiting_room eq '1'}
									                Air conditioned waiting room,
									                {/if}
									                
									                {if $data[$ulbid].printed_app eq '1'}
									                Printed Application forms ,
									                {/if}
									                
									                 {if $data[$ulbid].board_placed eq '1'}
									                Citizen charter Services Board ,
									                {/if}
									                
									                {if $data[$ulbid].toilet_facility eq '1'}
									                Toilet Facility  ,
									                {/if}
									                
									                {$data[$ulbid].other_facilities}
									                </div>
					                  </td>
									                
									            <td>
									                
									                <!--<a href="view_photos.php?id={$ulbid}">View Photos</a>-->
									                {if $data[$ulbid].front_view neq '' || $data[$ulbid].side_view neq '' || $data[$ulbid].long_view neq ''}
<a href="#" data-toggle="modal" data-target="#myModal" onClick="fun1('{$data[$ulbid].front_view}','{$data[$ulbid].side_view}','{$data[$ulbid].long_view}','{$data[$ulbid].pic}','{$data[$ulbid].pic2}')" >View Photos</a>
									                {else}
									                Files Not UPloaded
									                {/if}
					                  </td>
										
										
									</tr>
									{/foreach}
								
										
										
									</tbody>
				  </table>
								
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
       
      <!-- <span id="frontview"></span>
       <span id="side_view"></span>
       <span id="long_view"></span>
       
        <span id="pic1"></span>
        <span id="pic2"></span>
       -->
       
       <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="table">
  <tr style="background-color:#24BABC; color:#000;">
    <td>Front View :</td>
    <td>Side View : </td>
    <td>Long View :</td>
  </tr>
  <tr>
    <td><span id="frontview"></span></td>
    <td><span id="side_view"></span></td>
    <td><span id="long_view"></span></td>
  </tr>
  <tr style="background-color:#24BABC; color:#000;">
    <td>Water Facility :</td>
    <td>Seating Facility : </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span id="pic1"></span></td>
    <td><span id="pic2"></span></td>
    <td>&nbsp;</td>
  </tr>
</table>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
				</div>
			</div>
		</div>
</div>
{include file='footer_print.tpl'}

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
{include file='footer.tpl'}

				
					
			  


