<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html lang="en">
{literal}

<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>citizen services monitoring system</title>
      <link rel="stylesheet" type="text/css" href="css/styles.css"><!-- Tempalet Skeleton CSS -->
	  <link rel="stylesheet" type="text/css" href="assets/pickers/daterange-picker/daterangepicker-bs3.css"/>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
      <script src="js/modernizr.js"></script>
	  <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
	  <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	 <style>
	     .content-liquid-full {
	         margin:0px !important;

	 </style>
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
    
  .ui-datepicker-title {
      color:#000;
  } 
    
    

@media print { a[href]:after { content: none !important; } }
    
</style>
<script type="text/javascript" language="javascript" class="init">


$(document).ready(function() {
	$('#data-table').DataTable();
	
} );


	</script>
</head>
{/literal}
<body>

<section class="content">

  <!-- Sidebar Start -->
  
  <!-- Sidebar End -->


<div class="content-liquid-full">
<div class="container">

  <!-- Header Bar Start -->
  <div class="row header-bar m-b20" >
  
<!--<img src="{$banner}" class="img-responsive"/>-->
 <img src="http://municipalservices.in/images/boduppal-banner.png" class="img-responsive">
</div>

<ul class="breadcrumbs m-b20">
        {if $user_type eq 'U' || $user_type eq 'E'}
        <li><a href="ajax_dashboard.php"><i class="fa fa-home"></i></a></li>
        {else}
        <li><a href="ajax_dashboard.php"><i class="fa fa-home"></i></a></li>
        {/if}
       Welcome : {$uid}
       
       <li><a href="#"><i class="fa fa-user"></i></a></li> Users count : {$users_count}
 </ul>
 
 {assign var="url" value=""}
 {assign var="params" value=$smarty.get}
 {foreach from=$params item=row key=key}
    {assign var="url" value=$url|cat:$key|cat:"="|cat:$row|cat:'&'}
 {/foreach}
 {if $ulbid eq '208' || $ulbid=='210' || $ulbid=='3' || $ulb eq '208' || $ulb=='210' || $ulb=='3'}
  <form action="setULB.php" method="post">
<input type="hidden" name="url" value="{$smarty.server.SCRIPT_URI}?{$url}">
  <div class="row">
      <div class="col-md-4">
          <label for="village">Select Village :</label>
          <select name="ulbid"  class="form-control">
              <option value="">--select--</option>
              {html_options options=$villages selected=$ulbid}
          </select>
      </div>
      <div class="col-md-2" style="margin-top: 25px;">
          <input type="submit" value="Get Report" class="btn btn-success" name="setVillage">
      </div>
  </div>
  </form>
  </br></br>
  
  {/if}
 
  <!-- Header Bar End -->