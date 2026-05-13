<?php

require_once('connection.php');
$conn=getconnection();

if(isset($_POST['submit']))
{
    $imei_no=strip_tags($_POST['imei_no']);
    
    $sql="delete from rating_mst where imei_no=?";
    $query = $conn->prepare($sql);
	$query->bind_param("s",$imei_no);
	
	
    if($query->execute())
    {
        echo "<script>alert('deleted successfully');</script>";
    }
    else
    {
        echo "<script>alert('unable to delete');</script>";
    }
}

$query->close();



?>

<!DOCTYPE html>
<html lang="en">
    
<head>
  <title>Delete Ratings</title>
  <meta charset="utf-5">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style>
#email

{
    width:253px;
}
</style>

<body>

<div class="container">
  <h2>Delete Ratings</h2>
  <br>
  <br>
  <form class="form-horizontal" action="rating_delete.php" method="post">
   
   <div class="col-md-6 col-md-offset-3">
    <div class="form-group">
    <label class="control-label col-sm-2" for="email">IMEI NO:</label>
    <div class="col-sm-4">
     <input type="text" class="form-control" id="email" placeholder="Enter imei" name="imei_no">
    </div>
  </div>
  
    <div class="col-md-3 col-md-offset-2">
   <button type="submit" name="submit" class="btn btn-primary">Submit</button>
   </div>
    </div>
  </form>
</div>

</body>
</html>
