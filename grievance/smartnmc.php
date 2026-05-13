<!DOCTYPE html>
<?php
require_once('connection.php');
include('prepare_connection.php');
$conn=getconnection();		
$sql = "SELECT *  FROM  smart_idea_box ORDER BY id DESC";
$rs= mysqli_query($conn,$sql);

?>
<html>
<head>



<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.g220-img {
    width: 100px;
    /* height: 82px; */
    position: absolute;
    right: 178px;
    top: 20px;
    background: white;
    border-radius: 8px;
    padding: 5px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button{
  padding:0px !important;
}

.table{
  font-size:14px !important;
}
.dataTables_filter label{
display: flex !important;
    margin-bottom: 15px!important; 
  } 
</style>

<title>::NMC Smart Box </title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
      <script src="js/modernizr.js"></script>
	  <!-- <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" /> -->
	  <!-- <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"> -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
</head>
<body>
<div class="g220">
      <a href="https://www.g20.org/en"><img src="images/g220.png" class="img-fluid g220-img" style=""></a>
      <img src="images/header-nmc.jpg" class="img-fluid" style="width:100%">
  </div> 
<center>
<div class="bg-success p-2 text-white mb-3"><h4>Smart Box List</h4></div>
</center>
<div class="container">
<table  id="data-table"  class="table table-bordered table-striped">
<thead>
  <tr class="table-info">
    <th>S.No</th>
    <th>Name</th>
    <th>Address</th>
    <th width="50%">Idea</th>
    <th width="10%">Date</th>
  </tr>
  </thead>
  <tbody>
  <?php $i=1; while($row = mysqli_fetch_assoc($rs)) { ?>

  <tr>
    <td align="center" class="text-center"><?php echo $i++; ?></td>
    <td><?php echo ucfirst($row['name'])?></td> 
    <td><?php echo $row['address'];?></td>
    <td><?php echo $row['idea_desc'];?></td>
    <td><?php echo date('d-m-Y',strtotime($row['ts'])) ?></td> 
   
  </tr>
  <?php } ?>
  </tbody>
</table>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"></script>



<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
	<script>
	// $(document).ready( function () {
	// 	$('#data-table').DataTable();
	// } );

	$(document).ready(function() {

		
		$('#data-table').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		} );
	} );
	</script>
	<script>
</html>

