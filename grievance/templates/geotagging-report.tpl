{include file='header.tpl'}
{literal}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  	
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/manage_wards.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>	

<script>
function fill(ward_id,ward_desc)
{
	document.manage_wards.ward_id.value=ward_id;
	document.manage_wards.ward_desc.value=ward_desc;
} 






function delete_ward(ward_id)
{
	
	if(confirm('Do You really want to delete this record'))
	{
	    var csrf_token=$("#csrf_token").val();
		$.post('ajax_del_ward.php',{ward_id:ward_id,csrf_token:csrf_token},function(data)
		{
		   
		    
		if(data==1)
		{
		alert('Ward deleted successfully');
		window.location='manage_wards.php';
		}
		else if(data==0)
		{
		alert('Unable to delete , Try again');
		}
		else if(data==2)
		{
		alert('Ward is mapped with employees You cannot delete this ward');
		}
		else if(data==3)
		{
		    alert('Invalid token');
		}
		else if(data==4)
		{
		    alert('csrf error');
		}
		
		});
	}

} 

function validateForm()
{
	var ward_desc=document.manage_wards.ward_desc.value;		
	if(ward_desc=='')
	{
		alert("Please Enter Ward No / Description");
		return false;
	}

	return true;
}
</script>

{/literal}




 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar blue">
                  <h4 style="width: 89%;line-height: 34px;"><span>Geotagging Report <span>	</h4><a href="geotagging-reportmap1.php" target="_blank" class="btn btn-danger" name="save"><i class="fa fa-map" aria-hidden="true"></i> MapView</a>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
			<form  method="post" action="geotagging-report.php" name="manage_wards"  class="form-horizontal" >
			 <input type="hidden" name="token" value="{$token_id}" />
			<input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token"/>
		 	<input type='hidden' name='ward_id' value='0'>
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					 
					
					<div class="row justify-content-center">
					<div class="col-md-3">
					    <div class="form-group1">
                          <label  >Type:</label>{$search.type1}
                          <select class="form-control" name="type" required id="dropdown_change">
                               <option value="">-select-</option>
                              	{foreach from=$geotagging  item=row}
							         <option value='{$row.Id}'  >{$row.Description}</option>
							   {/foreach}
						  </select>
                        </div>
					</div>
					
    				 <div class="col-md-3" style="display:none" id="sub_type" >
    					    <div class="form-group1">
                              <label  >Sub Type:</label>
                              <select class="form-control" name="subtype" id="subdrop">
    							        <option value="">-select-</option>
    							       {foreach from=$geotaggingsub  item=row}
							            <option value='{$row.Id}' >{$row.Description}</option>
							           {/foreach}
    							    </select>
                            </div>
    					</div>
    					 <div class="col-md-3" style=""  >
    					    <div class="form-group1">
                              <label  >Wards</label>
                              <select class="form-control" name="Wardno" >
    							        <option value="">-select-</option>
    							       {foreach from=$geowardlists  item=rows}
							            <option value='{$rows.ward_id}' {if ($search.Wardno)===($rows.ward_id)} selected  {/if}>{$rows.ward_desc}</option>
							           {/foreach}
    							    </select>
                            </div>
    					</div>
					<div class="col-md-3" style="">
                        <div class="form-group1">
                          <label class="" style="">From Date:</label>
                           <input type="text" class="phone-group form-control datepicker1"    id="date_picker1" autocomplete="off" name="f_date" value="{$search.f_date}">
                         
                        </div>
                        </div>      
                        
                        
                        <div class="col-md-3" style="">
                        <div class="form-group1">
                          <label class="" style="">To Date:</label>
                          
                          <input type="text" class="phone-group form-control datepicker1"  id="date_picker2"  autocomplete="off" name="t_date" value="{$search.t_date}">
                          
                        </div>
                        </div>
					</div>
					
				 
					
					<div class="form-actions fluid "><br>
						<div class="col-md-offset-5 col-md-2">
						<button type="submit" class="btn btn-info" name="save">Search</button>
					 
						 
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>


</div>

	{if !empty($datahead)} 
<div class="row" id="area" style="    height: 1000px; overflow: scroll;">
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>{$datahead}</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					{if !empty($IIHL)} 
					<!-- --------------  IIHL ----------------------	-->
					
					<table class="table table-striped table-bordered table-hover table-full-width dataTable" id="example" width="100%" aria-describedby="data-table_info"  width="100%">
                      <tbody>
                        <tr style="background-color:#0f4b76; color:#FFF;">
                          <td>Sl.No</td>
                          <td>House hold No</td>
                          <td>Area </td>
                          <td>Resident Name</td>
                          <td>Ward</td>
                          <td>Mobile No</td>
                          <td>Toilet (Yes / No)</td>
                          <td>Defecate location</td>
                          <td>Photo</td>
                          <td>longitude &amp; latitude</td>
                          <td>Date</td>
                          <td>Action</td>
                        </tr>
                        {$i=1}
                        {foreach from=$IIHL  item=IIHLS}
                        <tr>
                          <td>{$i++}</td>
                          
                          <td>{$IIHLS.HHno}
                          <input type="hidden" id="HHno{$IIHLS.Id}" value="{$IIHLS.HHno}"></td>
                          <td>{$IIHLS.Area}
                          <input type="hidden" id="Area{$IIHLS.Id}" value="{$IIHLS.Area}"></td></td>
                          <td>{$IIHLS.ResidentName}</td>
                          <td>{$IIHLS.Wardno}</td>
                          <td>{$IIHLS.MobileNo}
                          <input type="hidden" id="MobileNo{$IIHLS.Id}" value="{$IIHLS.MobileNo}"></td></td>
                          <td> {if !empty($IIHLS.HHToiletFacility)} {$IIHLS.HHToiletFacility} {/if}</td>
                          <td> {if !empty($IIHLS.YesOrNoValue)} {$IIHLS.YesOrNoValue} {/if}</td>
                         <!-- <td class="exclude"><a href="{$IIHLS.CaptureImagePath}" target="_blank"><img src="{$IIHLS.CaptureImagePath}" style="width:80px;height:80px"></a></td>-->
                        	 <td class="exclude">
                        	     {if !empty($IIHLS.CaptureImagePath)} 
                        	     <a href="{$IIHLS.CaptureImagePath}" target="_blank"><i class="fa fa-eye" aria-hidden="true">View</i></a>
                        	     
                        	     {/if}
                        	  </td> 
                          <td> {if !empty($IIHLS.latitude)} <a class="direction-link" target="_blank" href="//maps.google.com/maps?f=d&amp;daddr={$IIHLS.latitude},{$IIHLS.longitude}&amp;hl=en">{$IIHLS.latitude} & {$IIHLS.longitude}</a>{/if}</td>
                          <td> {if !empty($IIHLS.DateTime)} {$IIHLS.DateTime} {/if}</td>
                          <td>
                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal" OnClick="Ihhl({$IIHLS.Id});" data-whatever="@mdo">Edit</button>
                     
                        </td>
                        </tr>
                         {/foreach}
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>		
                    {/if}
					{if !empty($pub_com_othr)} 	
					<!-- --------------  Public & communinity toilets ----------------------	-->
								
					<table class="table table-striped table-bordered table-hover table-full-width" id='example' width="100%">
                      <tbody>
                        <tr style="background-color:#0f4b76; color:#FFF;">
                          <td>Sl.No</td>
                          <td>Area</td>
                          <td>Ward</td>
                          <td>Photo</td>
                          <td>Longitude &amp; Llatitude</td>
                          <td>Date</td>
                          <td>Action</td>
                        </tr>
                        {$i=1}
                        {foreach from=$pub_com_othr  item=pco}
                        <tr>
                          <td>{$i++}</td>
                          <td>{$pco.Area} <input type="hidden" id="pArea{$pco.Id}" value="{$pco.Area}"></td>
                          <td>{$pco.Wardno} </td>
                          
                         <!-- <td><a href="{$pco.CaptureImagePath}" target="_blank"><img src="{$pco.CaptureImagePath}" style="width:80px;height:80px"></a></td>-->
                          <td class="exclude"><a href="{$pco.CaptureImagePath}" target="_blank"><i class="fa fa-eye" aria-hidden="true">View</i></a></td> 
                         
                          <td> <a class="direction-link" target="_blank" href="//maps.google.com/maps?f=d&amp;daddr={$pco.latitude},{$pco.longitudes}&amp;hl=en">{$pco.Longitude}</a></td>
                          <td>{$pco.DateTime}</td>
                          <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalpu" OnClick="pu_cm_otr({$pco.Id});" data-whatever="@mdo">Edit</button></td>
                        </tr>
                         {/foreach}
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>		
                    {/if}
                    {if !empty($manhole)} 
                    <!-- --------------  Maintanance Holes ----------------------	-->
                    <table class="table table-striped table-bordered table-hover table-full-width" id='example' width="100%">
                      <tbody>
                        <tr style="background-color:#0f4b76; color:#FFF;">
                          <td>Sl.No</td>
                          <td>Area name</td>
                          <td>Ward</td>
                          <td>Unique Id</td>
                          <td>Condition</td>
                          <td>Length</td>
                          <td>Longitude &amp; Latitude</td>
                          <td>Photo</td>
                          <td>Date</td>
                          <td><p>Action</p></td>
                        </tr>
                        {$i=1}
                        {foreach from=$manhole  item=hole}
						 <tr>
                          <td>{$i++}</td>
                          <td>{$hole.Area} <input type="hidden" id="mArea{$hole.Id}" value="{$hole.Area}"></td>
                          <td>{$hole.Wardno}</td>
                          <td>{$hole.UniqueId} <input type="hidden" id="mUniqueId{$hole.Id}" value="{$hole.UniqueId}"></td>
                          <td>{$hole.ConditionValue}</td>
                          <td>{$hole.SewerLineLength} <input type="hidden" id="mLength{$hole.Id}" value="{$hole.SewerLineLength}"></td>
                          <td> <a class="direction-link" target="_blank" href="//maps.google.com/maps?f=d&amp;daddr={$hole.latitude},{$hole.longitudes}&amp;hl=en">{$hole.Longitude}</a>
                         </td>
                         <!-- <td><a href="{$hole.CaptureImagePath}" target="_blank"><img src="{$hole.CaptureImagePath}" style="width:80px;height:80px"></a></td>-->
                           <td class="exclude"><a href="{$hole.CaptureImagePath}" target="_blank"><i class="fa fa-eye" aria-hidden="true">View</i></a></td> 
                          <td>{$hole.DateTime}</td>
                          <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalm" OnClick="manhole({$hole.Id});" data-whatever="@mdo">Edit</button></td>
                     </tr>
                      {/foreach}
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                     {/if}
                    {if !empty($IEChodding)}
							
					<!-- --------------  IEC Hoardings ----------------------	-->	
					
					<table class="table table-striped table-bordered table-hover table-full-width" id='example' width="100%">
                      <tbody>
                        <tr style="background-color:#0f4b76; color:#FFF;">
                          <td>Sl.No</td>
                          <td>Area name</td>
                          <td>Ward</td>
                           <td>Unique Id</td>
                          <td>Slum unplanned</td>
                          <td>Longitude &amp; Latitude</td>
                          <td>Photo</td>
                          <td>Date</td>
                          <td><p>Action</p></td>
                        </tr>
                         {$i=1}
                        {foreach from=$IEChodding  item=hodding}
                        <tr>
                          <td>{$i++}</td>
                          <td>{$hodding.Area} <input type="hidden" id="iArea{$hodding.Id}" value="{$hodding.Area}"></td>
                          <td>{$hodding.Wardno}</td>
                            <td>{$hodding.UniqueId} </td>
                          <td>{$hodding.Slum_Unplanned_colony}</td>
                          <td>
                           <a class="direction-link" target="_blank" href="//maps.google.com/maps?f=d&amp;daddr={$hodding.latitude},{$hodding.longitudes}&amp;hl=en"> {$hodding.Longitude}</a>
                          
                          </td>
                         <!-- <td><a href="{$hodding.CaptureImagePath}" target="_blank"><img src="{$hodding.CaptureImagePath}" style="width:80px;height:80px"></a></td>-->
                          <td class="exclude"><a href="{$hodding.CaptureImagePath}" target="_blank"><i class="fa fa-eye" aria-hidden="true">View</i></a></td> 
                         <td>{$hodding.DateTime}</td>
                         <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModali" OnClick="IEChoading({$hodding.Id});" data-whatever="@mdo">Edit</button></td>
                   
                        </tr>
                        {/foreach}
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                           <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
					 {/if}
					  {if !empty($stromsdrain)}
							
					<!-- --------------  Sewers UGD ----------------------	-->	
					
					<table class="table table-striped table-bordered table-hover table-full-width" id='example' width="100%">
                      <tbody>
                        <tr style="background-color:#0f4b76; color:#FFF;">
                          <td>Sl.No</td>
                          <td>Area From</td>
                          <td>Area To</td>
                          <td>Ward</td>
                          <td>Length</td>
                          <td>Remarks</td>
                          <td>Longitude &amp; Latitude</td>
                          <td>Photo</td>
                          <td>Date</td>
                        <!--<td><p>Action</p></td>-->
                        </tr>
                         {$i=1}
                        {foreach from=$stromsdrain  item=drain}
                        <tr>
                          <td>{$i++}</td>
                          <td>{$drain.AreaFrom} <input type="hidden" id="iAreaf{$drain.Id}" value="{$drain.AreaFrom}"></td>
                          <td>{$drain.AreaTo} <input type="hidden" id="iAreat{$drain.Id}" value="{$drain.AreaTo}"></td>
                          <td>{$drain.Wardno}</td>
                          <td>{$drain.Length} </td>
                          <td>{$drain.Remarks}</td>
                          <td>
                           <a class="direction-link" target="_blank" href="//maps.google.com/maps?f=d&amp;daddr={$drain.latitude},{$drain.longitudes}&amp;hl=en"> {$drain.Longitude}</a>
                          
                          </td>
                         <!-- <td><a href="{$UGD.CaptureImagePath}" target="_blank"><img src="{$UGD.CaptureImagePath}" style="width:80px;height:80px"></a></td>-->
                          <td class="exclude"><a href="{$drain.CaptureImagePath}" target="_blank"><i class="fa fa-eye" aria-hidden="true">View</i></a></td> 
                         <td>{$drain.DateTime}</td>
                         <!--<td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModali11" OnClick="stromsdrain({$drain.Id});" data-whatever="@mdo">Edit</button></td>-->
                   
                        </tr>
                        {/foreach}
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                           <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
					 {/if}
					  {if !empty($SewersUGD)}
							
					<!-- --------------  Sewers UGD ----------------------	-->	
					
					<table class="table table-striped table-bordered table-hover table-full-width" id='example' width="100%">
                      <tbody>
                        <tr style="background-color:#0f4b76; color:#FFF;">
                          <td>Sl.No</td>
                          <td>Area From</td>
                          <td>Area To</td>
                          <td>Ward</td>
                          <td>Length</td>
                          <td>Remarks</td>
                          <td>Longitude &amp; Latitude</td>
                          <td>Photo</td>
                          <td>Date</td>
                          <!--<td><p>Action</p></td>-->
                        </tr>
                         {$i=1}
                        {foreach from=$SewersUGD  item=UGD}
                        <tr>
                          <td>{$i++}</td>
                          <td>{$UGD.AreaFrom} <input type="hidden" id="iAreaf{$UGD.Id}" value="{$UGD.AreaFrom}"></td>
                           <td>{$UGD.AreaTo} <input type="hidden" id="iAreat{$UGD.Id}" value="{$UGD.AreaTo}"></td>
                          <td>{$UGD.Wardno}</td>
                            <td>{$UGD.Length} </td>
                          <td>{$UGD.Remarks}</td>
                          <td>
                           <a class="direction-link" target="_blank" href="//maps.google.com/maps?f=d&amp;daddr={$UGD.latitude},{$UGD.longitudes}&amp;hl=en"> {$UGD.Longitude}</a>
                          
                          </td>
                         <!-- <td><a href="{$UGD.CaptureImagePath}" target="_blank"><img src="{$UGD.CaptureImagePath}" style="width:80px;height:80px"></a></td>-->
                          <td class="exclude"><a href="{$UGD.CaptureImagePath}" target="_blank"><i class="fa fa-eye" aria-hidden="true">View</i></a></td> 
                         <td>{$UGD.DateTime}</td>
                         <!--<td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModali11" OnClick="SewersUGD({$UGD.Id});" data-whatever="@mdo">Edit</button></td>-->
                   
                        </tr>
                        {/foreach}
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                           <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
					 {/if}
                  
				</div>
			</div>
		</div>
</div>

{literal}
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">
<script language='javascript'>
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
<script>

function print_div()
{
            var divContents = $("#area").html();
            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
}
</script>


{/literal}
<br><br>
<div align='center'>
    <form method="post" action="geotagging-export.php" target="_blank">
        <input type="hidden"name="type" value='{$search.type}'>
        <input type="hidden"name="subtype" value='{$search.subtype}'>
         <input type="hidden"name="Wardno" value='{$search.Wardno}'>
         <input type="hidden"name="f_date" value='{$search.f_date}'>
         <input type="hidden"name="t_date" value='{$search.t_date}'>
        <input type="hidden"name="ulb" value='{$search.suld}'>
    <input type="submit"  value="Export" class="btn btn-success">  
    	<input type='button' value='Print' onclick="print_div()" class="btn btn-danger">
    </form>


</div>

<br><br>


{include file='footer.tpl'}
{else}
   <div class="alert alert-danger text-center p-5 m-5" role="alert">
 {$nrcds}
</div>
   
{/if}
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{$datahead}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="geotaggingupdate.php" method="post">
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">House hold No:</label>
                                    <input type="text" class="form-control" name="HHno" id="4HHno" required>
                                    <input type="hidden" class="form-control" name="id" id="4id">
                                    <input type="hidden" class="form-control" name="Type" value="4">
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" name="Area" id="4Area" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Mobile No</label>
                                    <input type="text" class="form-control isnumber" name="MobileNo"   maxlength="10" id="4MobileNo" required>
                                  </div>
                                  
                                 <button type="submit" class="btn btn-primary">Update</button> 
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               
                              </div>
                            </div>
                          </div>
                        </div>
      <div class="modal fade" id="exampleModalpu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{$datahead}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="geotaggingupdate.php" method="post">
                                 
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" name="Area" id="5Area" required>
                                    <input type="hidden" class="form-control" name="id"  id="5id">
                                    <input type="hidden" class="form-control" name="Type" value="56">
                                  </div>
                              
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                              </div>
                            </div>
                          </div>
                        </div>
      <div class="modal fade" id="exampleModalm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{$datahead}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="geotaggingupdate.php" method="post">
                                 
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" name="Area" id="mArea" required>
                                    <input type="hidden" class="form-control" name="id" id="2id">
                                    <input type="hidden" class="form-control" name="Type" value="2">
                                  </div>
                                
                                     <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Sewer Line Length</label>
                                    <input type="text" class="form-control" name="Length" id="mLength">
                                   
                                  </div>
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                              </div>
                            </div>
                          </div>
                        </div>
      <div class="modal fade" id="exampleModali" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{$datahead}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="geotaggingupdate.php" method="post">
                                 
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label" >Area</label>
                                    <input type="text" class="form-control" name="Area" id="3Area" required>
                                    <input type="hidden" class="form-control" name="id"  id="3id">
                                    <input type="hidden" class="form-control" name="Type" value="3">
                                  </div>
                              
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                              </div>
                            </div>
                          </div>
                        </div>
    
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
    function Ihhl(id) {
        var HHno = $('#HHno'+id).val();
        var Area = $('#Area'+id).val();
        var MobileNo = $('#MobileNo'+id).val();
         $('#4id').val(id);
         $('#4HHno').val(HHno);
         $('#4Area').val(Area);
         $('#4MobileNo').val(MobileNo);
    }
    function pu_cm_otr(id) {
        var pArea = $('#pArea'+id).val();
         $('#5Area').val(pArea);
         $('#5id').val(id);
        
    }
    function manhole(id) {
        var mArea = $('#mArea'+id).val();
         var mUniqueId = $('#mUniqueId'+id).val();
          var mLength = $('#mLength'+id).val();
         $('#mArea').val(mArea);
          
         $('#mLength').val(mLength);
         $('#2id').val(id);
        
    }
    function IEChoading(id) {
        var iArea = $('#iArea'+id).val();
         $('#3Area').val(iArea);
         $('#3id').val(id);
        
    }
</script>
<script>
$(function() {
    $(".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true});
});
</script>
 <!--Start datepicker -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">     
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!--End datepicker -->
  <script>
$(document).ready(function() {
///////
var startDate;
var endDate;
 $( "#date_picker1" ).datepicker({
dateFormat: 'mm/dd/yy'
})
///////
///////
 $( "#date_picker2" ).datepicker({
dateFormat: 'mm/dd/yy'
});
///////
$('#date_picker1').change(function() {
startDate = $(this).datepicker('getDate');
$("#date_picker2").datepicker("option", "minDate", startDate );
})

///////
$('#date_picker2').change(function() {
endDate = $(this).datepicker('getDate');
$("#date_picker1").datepicker("option", "maxDate", endDate );
})
////////////////
})
</script> 
<script>
    $(document).ready(function(){
     $("#dropdown_change").change(function(){
         
        if($("#dropdown_change").val()==1){
            $("#sub_type").css("display", "block");  
            $('#subdrop').prop('required', true);
            $('#subdrop').val('');
           
        }else{
            $("#sub_type").css("display", "none"); 
            $('#subdrop').prop('required', false);
          
        }
   
     });
   });
      $(document).ready(function () {    
    
            $('.isnumber').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
               if($('.isnumber').val().length==0){
                if (String.fromCharCode(charCode).match(/[^6-9]/g)){    
    
                    return false;
                }
               }
               if($('.isnumber').val().length>1){
                if (String.fromCharCode(charCode).match(/[^0-9]/g)){    
    
                    return false;
                }
               }
    
            });    
    
        });
</script>
<script type="text/javascript">

 $(document).ready(function() {

 $('.mobile-valid').on('keypress', function(e) {

            var $this = $(this);
            var regex = new RegExp("^[1-9\b]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            // for 10 digit number only
            if ($this.val().length > 9) {
                e.preventDefault();
                return false;
            }
            if (e.charCode < 54 && e.charCode > 47) {
                if ($this.val().length == 0) {
                    e.preventDefault();
                    return false;
                } else {
                    return true;
                }
             }
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

   });
</script>