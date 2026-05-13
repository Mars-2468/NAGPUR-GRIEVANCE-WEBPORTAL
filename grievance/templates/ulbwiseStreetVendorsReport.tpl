{include file='header.tpl'}
{literal}


<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
    	<!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /><!-- Data Table CSS -->
    	

    	
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
    $("#loading").css('display','block');
    
    $.post('ajax_streetvenodrs_summery.php',{},function(data)
    {
        $("#loading").css('display','none');
        $("#result").html(data);
    });
    
    
});

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


  
  
  <div id="loading" style="display:none; text-align:center;">
			   <!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
			    <h4>Please Wait.. </h4>
			    
			</div>
			<span id="result"></span>
			
			
			
	

{include file='footer_print.tpl'}


{include file='footer.tpl'}

