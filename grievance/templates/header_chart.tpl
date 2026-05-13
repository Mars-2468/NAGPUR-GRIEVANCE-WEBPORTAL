<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html lang="en">
{literal}

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <meta name="description" content="REGISTER COMPLAINT / SERVICE,  Trade License , Water tax payment , Dharani Citizen Registration , e-office , Swachta App Statistics, Application Management, E-News, App Masters, Council ,
Social Connect, Important Contacts, Media Coverage, Notifications, Smart Ideas Box, Citizen buddy,  Online Water Tap Application , Online Trade Application, Online Advertisement Application, Property Tax Self Assessment, Property Tax Calculator, Municipal Council"/>
      <link rel="icon" href="http://localhost:8081/grievance/images/G20.png" type="image/x-icon">
	  <title>Grievance Redressal System </title>
      <link rel="stylesheet" type="text/css" href="css//styles.css"><!-- Tempalet Skeleton CSS -->
	  <link rel="stylesheet" type="text/css" href="assets/pickers/daterange-picker/daterangepicker-bs3.css"/>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
      <script src="js/modernizr.js"></script>
       <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	  <!--<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />-->
	  <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
	 <!--<link rel="stylesheet" href="https://municipalservices.in/aurangabad/fonts.css" >-->
<!----print and export to excel---->
<script language="javascript">
function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}
</script>
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

  
<style>
	    .sidebar .menu li a{
	        text-decoration:none !important;
	    }
	</style>
<style>
    
  .ui-datepicker-title {
      color:#000;
  } 
  
  .header-bar{
      padding-top:0px !important;
  }
    
  .fa-android:before {
      font-family: 'FontAwesome'!important;
  }  
 @media only screen and (max-width: 784px) {
  img {
   width:100%;
  }
}   
    
    
    
    

@media print { a[href]:after { content: none !important; } }
    
</style>
<script type="text/javascript" language="javascript" class="init">


$(document).ready(function() {
	//$('#data-table').DataTable();
	
} );


	</script>
</head>
{/literal}
<body>

<section class="content">

  <!-- Sidebar Start -->
  <div class="sidebar">

  <!-- Logo Start 
  <a href="dashboard.php">
    <div class="logo-container" >
	  <img src="{$logo}" class="img-responsive"/>
    </div>
  </a>-->
  <!-- Logo End -->

  <!-- Sidebar User Profile Start -->
 <!-- <div class="sidebar-profile">
    <div class="user-avatar">
      <img src="images/avatar.jpg" alt="John Doe" />
    </div>
    <div class="user-infos">
      <a href="profile.html">John Doe</a>
    </div>
  </div>-->

  <div class="responsive-menu">
    <a href="#"><i class="fa fa-bars"></i></a>
  </div>
  <!-- Sidebar User Profile End -->

  <!-- Menu Start -->
  
  <ul class="menu"><!-- dpms.php-->
  	
  	 		{if $user_type eq 'U'}
    	
    	
    	
    
    	<!--<li class=" pink"><a href="https://municipalservices.in/images/usermanual.pdf" target="_blank" style="height:auto;line-height:normal;display:flex;align-items:center;"><span class="menu-icon"></span><span class="menu-text" style="height:auto;line-height:normal;display:flex;align-items:center;"><img src="images/new-icon.gif"><strong style="margin-left:5px;"> User Manual </strong> </span></a></li>-->

    	{/if}
    	
    	
    	
    	
    	{if $user_type eq 'E' || $user_type eq 'U'}
    	<li class=" pink"><a href="ajax_dashboard.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Dashboard</span></a></li>
    	{else if $user_type eq 'D'}
    	<li class=" pink"><a href="department_dashboard.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Dashboard</span></a></li>
    	{else}
    	
    	<li class=" pink">{if $uid eq 'Boduppal'}<a href="ajax_dashboard.php">{else}<a href="ajax_dashboard.php">{/if}<span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Dashboard</span></a></li>
    	
    	{/if}
    	{if $user_type eq 'U'}
    	{if $ulbid eq '095'}
    	    <li class=" pink"><a href="underground_drinage_form.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Under Ground Drinage Application</span></a></li>
    	    <li class=" pink"><a href="underground_drinage_report.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Drinage App. Report</span></a></li>
        	{/if}
    	 {/if}
    	{if $user_type eq 'U'}
      <!--<li class=" pink">{if $uid eq 'Boduppal'}<a href="swapp_dashboard.php">{else}<a href="swapp_dashboard.php">{/if}<span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Swachta App Statistics</span></a></li>-->
      {/if}
      {if $uid eq 'admin'}
      <li class=" pink"><a href="sw_statistics_ulb.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Swachta Complaints Availability</span></a></li>
      {/if}
      
    	
    	{foreach from=$services item=row key=service_type}
        	 <li class="parent marine">
        		<a href='#'>
        		<span class="menu-icon"><i class="icon-large {$main_icons[$service_type].main_icon}"></i></span>
        		<span class="menu-text">{$service_type}</span></a>
        		</a>
        		<ul class="child">
        		<li class="nav-header"></li>
        			{foreach from=$row item=service_name key=service_id}
        			  {if $service_id neq 'category3_mst'}
        		  	<li><a href="{$service_id}.php"><span>{$service_name}</span></a></li>
        		  	  {/if}
        			{/foreach}
        		</ul>
        	</li>
  	    {/foreach}
  	
  	{if $hod_status eq '1'}
  	
  	<!--<li class=" pink"><a href="hod_rep.php"><span class="menu-icon"><i class="fa fa-power-off"></i></span><span class="menu-text">Level3 report</span></a></li>-->
  	{/if}
  	{if $hod_status2 eq '1'}
  	
  	<!--<li class=" pink"><a href="hod_rep2.php"><span class="menu-icon"><i class="fa fa-power-off"></i></span><span class="menu-text">HOD report</span></a></li>-->
  	{/if}
    	{if $user_type eq 'U'}
    
        
    
    	
    	{/if}
    	
    	{if $user_type eq 'C'}
    	
    	<li class=" pink"><a href="createsupervisor.php"><span class="menu-icon"><i class="fa fa fa-cog"></i></span><span class="menu-text">Create Supervisor</span></a></li>
    	<li class=" pink"><a href="createagent.php"><span class="menu-icon"><i class="fa fa-tachometer"></i></span><span class="menu-text">Create Agent</span></a></li>
    	
    	{/if}
    	
    	{if $user_type eq 'AG'}
    	
    	<li class=" pink"><a href="create_enquiry.php"><span class="menu-icon"><i class="fa fa-list-alt"></i></span><span class="menu-text">Enquiry List</span></a></li>
    	<li class=" pink"><a href="create_grievance.php"><span class="menu-icon"><i class="fa fa-list-alt"></i></span><span class="menu-text">New Grievance</span></a></li>
    	<li class=" pink"><a href="search_grievance.php"><span class="menu-icon"><i class="fa fa fa-file"></i></span><span class="menu-text">Search Grievance</span></a></li>
    	<li class=" pink"><a href="enquirey_report.php"><span class="menu-icon"><i class="fa fa fa-file"></i></span><span class="menu-text">Enquiry Report</span></a></li>
    	
    	
    	{/if}
    		
    	{if $user_type eq 'A'}
    	    	<li class=" pink"><a href="mergeDepartments.php"><span class="menu-icon"><i class="fa fa fa-file"></i></span><span class="menu-text">Merge Departments</span></a></li>
    	    	<li class=" pink"><a href="mergeDesignations.php"><span class="menu-icon"><i class="fa fa fa-file"></i></span><span class="menu-text">Merge Designations</span></a></li>

    	{/if}
    	
	<li class=" pink"><a href="logout.php"><span class="menu-icon"><i class="fa fa-power-off"></i></span><span class="menu-text">Logout</span></a></li>				
  </ul>
  <!-- Menu End 
<div style="color:#0054a6;">Powered by - VMax</div>-->





</div>
  <!-- Sidebar End -->


<div class="content-liquid-full">
<div class="container">

  <!-- Header Bar Start -->
  <div class="row header-bar m-b20" style="display:flex;flex-wrap:wrap;align-items-center;">
  <div class="col-md-6">
<img src="{$banner}" />
</div>
<div class="col-md-6">
 {if $uid eq 'mepma'}
 <img src="images/mepma_Street.png" style="margin-left:auto;" >
 {/if}
 </div>
</div>

<ul class="breadcrumbs m-b20">
        {if $user_type eq 'U' || $user_type eq 'E'}
        <li><a href="ajax_dashboard.php"><i class="fa fa-home"></i></a></li>
        {else}
        <li><a href="ajax_dashboard.php"><i class="fa fa-home"></i></a></li>
        {/if}
       Welcome : {$username} {$smarty.session.user_name}
       
       
 </ul>
 
 
 
 
  <!-- Header Bar End -->