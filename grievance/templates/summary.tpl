{include file='header.tpl'}
{literal}

<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all">


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
    function searchData()
    {
        var fromDate = $("#fromDate").val();
        var toDate = $("#toDate").val();
        
        $("#loading").css('display','block');
    
    $.post('ajax_summary.php',{fromDate:fromDate,toDate:toDate},function(data)
    {
        $("#loading").css('display','none');
        $("#result").html(data);
        $("#result2").html(data);
    });
        
        
    }
</script>

<script>
$(document).ready(function()
{
    $("#loading").css('display','block');
    
    $.post('ajax_summary.php',{},function(data)
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



<div class="row">
    <div class="col-md-12">
        From Date<input type="text" name="fromDate" id="fromDate" class="datepicker">
        To Date<input type="text" name="toDate" id="toDate" class="datepicker">
        <input type="button" value="Search Data" class="btn btn-success" onclick="searchData()">
    </div>
</div>
<br>
  
  
  
  
  <div id="loading" style="display:none; text-align:center;">
			   <!-- <div style="text-align:center;"><img src="images/loading.gif"/></div>-->
			    <h4>Please Wait.. </h4>
			    
			</div>
			<span id="result"></span>
			
			
			</div>
			
			
			
	<center></center><button id="btnExport" onclick="fnExcelReport();" class="btn btn-success"> EXPORT </button></center>




{include file='footer.tpl'}

<script>
function fnExcelReport()
{
$('#example a').replaceWith(function() {
    return this.childNodes;
});
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('example'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script>




<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
    $( ".datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true});
});
</script>
