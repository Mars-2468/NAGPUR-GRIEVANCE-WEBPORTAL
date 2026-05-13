<html>
    <head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet"  href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );
} );
</script>

</head>
<?php
//echo "Notifications";

include('conn.php');
	mysqli_query($con,'SET character_set_results=utf8');        
mysqli_query($con,'SET names=utf8');        
mysqli_query($con,'SET character_set_client=utf8');        
mysqli_query($con,'SET character_set_connection=utf8');
mysqli_query($con,'SET collation_connection=utf8_general_ci');
$ulbid=$_REQUEST['ulbid'];
$query="select * from notification_mst where ulbid='$ulbid' order by ts DESC";
//	$query="select * from notification_mst where ulbid='".$_REQUEST['ulbid']."' order by ts DESC";
				  $resource=mysqli_query($con,$query);
                 
?>
<div class="inner no-radius">
<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">


<thead>

<tr style="background-color:#aefffa; color:#000;">

<td ><span style="font-family: georgia, palatino; font-size: 12pt;"><strong><span style="color: #000000;">Sno</span></strong></span></td>
<td ><span style="font-family: georgia, palatino; font-size: 12pt;"><strong><span style="color: #000000;">Date</span></strong></span></td>
<td ><span style="font-family: georgia, palatino; font-size: 12pt;"><strong><span style="color: #000000;">Image</span></strong></span></td>


<td ><span style="font-family: georgia, palatino; font-size: 12pt;"><strong><span style="color: #000000;">Title</span></strong></span></td>
<td ><span style="font-family: georgia, palatino; font-size: 12pt;"><strong><span style="color: #000000;">Description</span></strong></span></td>

</tr><tbody>
</thead>
<?php
		$i=1;
while($row=mysqli_fetch_array($resource))
	{ 

?>
			
<tr>
<td align="center"><?php echo $i;?></td>
	<td align="center"><?php echo $row['date'];?></td>
	<td align="center">
	    
	<img src="<?php echo $row['photo']?>" alt="" width="70px" height="70px"></td>

	<td align="center"><?php echo $row['title'];?></td>

	<td align="center"><?php echo $row['description'];?></td>
	</tr>
	<?php $i++;} ?>
        </tbody>
    </table>
    </div>