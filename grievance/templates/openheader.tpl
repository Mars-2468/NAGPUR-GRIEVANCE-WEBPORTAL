<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html lang="en">
{literal}

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  
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
    
    
 @media only screen and (max-width: 784px) {
  img {
   width:100%;
  }
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


<div class="content-liquid-full" style="margin-left:0;">
<div class="container">

  <!-- Header Bar Start -->
  


 

 
  <!-- Header Bar End -->