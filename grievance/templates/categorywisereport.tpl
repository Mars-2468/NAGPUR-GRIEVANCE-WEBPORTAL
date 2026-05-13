{include file='header.tpl'}
{literal}

<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">

    	
<style>
    
    table tr:nth-child(odd) {
 background-color: #f1f1f1;
}
table tr:nth-child(even) {
 background-color: #ffffff;
}
table.dataTable thead th, table.dataTable thead td {

padding:0px;
}





	
.wrapper1, .wrapper2{
	width: 100%;
	border: none 0px RED;
overflow-x: scroll;
	}
.wrapper1{
	height: 20px;
	margin: auto;
	}
.wrapper2{
	height: 800px; 
	}
.div3 {
	width:1380px;
	height: 20px;
	}
.div4 {
	width:1300px; 
	height: 800px;
	background-color: #ffff;
}

</style> 


<script>
$(document).ready(function()
{
    var catid = $("#catid").val();
    $("#loading").css('display','block');
    
    $.post('ajaxCategorywisereport.php',{catid:catid},function(data)
    {
        $("#loading").css('display','none');
        $("#result").html(data);
    });
    
    
});

function searchCatdata()
{
    var catid = $("#catid").val();
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    
    $("#loading").css('display','block');
    
    $.post('ajaxCategorywisereport.php',{catid:catid,fromdate:fromdate,todate:todate},function(data)
    {
        $("#loading").css('display','none');
        $("#result").html(data);
    });
}

</script>


    	
<script>
$(function(){
    $(".wrapper1").scroll(function(){
        $(".wrapper2")
            .scrollLeft($(".wrapper1").scrollLeft());
    });
    $(".wrapper2").scroll(function(){
        $(".wrapper1")
            .scrollLeft($(".wrapper2").scrollLeft());
    });
});
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
	
		$.post('ajax_del_ward.php',{ward_id:ward_id},function(data)
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
<script>
function get_dists(rdmaid)
{
	$.post('ajax_getdists2.php',{rdmaid:rdmaid},function(data)
	{
		$("#distid").html(data);
	});
}


function get_ulbs(distid)
{
	$.post('ajax_getulbs2.php',{distid:distid},function(data)
	{
		$("#ulbid").html(data);
	});
}

</script>
{/literal}

<!---

<form action="past3report.php" method="POST">
  <div>
<div class="col-md-3">
<div class="form-group">
  <label  for="selectbasic">Select Region</label>
  <div>
    <select id="regionid" name="regionid" class="form-control" onchange="get_dists(this.value)">
     <option value="">---select---</option>
     {html_options options=$region_list selected=$region_id_sel}
    </select>
  </div>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
  <label for="selectbasic">Select District</label>
  <div>
    <select id="distid" name="distid" class="form-control" onchange="get_ulbs(this.value)">
      <option value="">---select---</option>
      {html_options options=$dist_list selected=$dist_id_sel}
      
      
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
      {html_options options=$ulb_list selected=$ulbid_id_sel}
      
    </select>
  </div>
</div>
</div>

<div class="form-group">
<input style="margin-top:25px;" type="submit" name="search1" value="Search" class="btn btn-success">
</div>
</div>
  
  </form>
  
  --->
  
  
    <select id="catid">
        <option value="">--- select Category---</option>
        {html_options options=$catList selected=$selCatid}
    </select>
    
    From Date: <input type="text" name="fromdate" id="fromdate" class="datepicker" autocomplete="off">
    To Date: <input type="text" name="todate" id="todate" class="datepicker" autocomplete="off">
    <input type="submit" name="cat_id" value="GetData" onclick="searchCatdata()" >
    
  
  
  <div id="loading" style="display:none; text-align:center;">
			   <!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
			    <h4>Please Wait.. </h4>
			    
			</div>
			<span id="result"></span>
			
			
			
	

{include file='footer_print.tpl'}


{include file='footer.tpl'}

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
$(document).ready(function()
{
    $( ".datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true});
});

</script>

