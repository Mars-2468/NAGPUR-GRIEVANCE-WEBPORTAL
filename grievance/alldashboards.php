<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html lang="en">


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
$(document).ready(function()
{
    //myVar = setInterval("fun2()", 30000);
    fun2();
});
function fun2()
{
    window.location="https://municipalservices.in/cdmaopendashboard.php";
    setInterval("fun3()", 30000);
}

function fun3()
{
    window.location="https://municipalservices.in/cdmaopenservicdashboard.php";
    setInterval("fun2()", 30000);
}
</script>