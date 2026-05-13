<?php 
require "config.php";
require_once('connection.php');
$conn=getconnection();
include('prepare_connection.php');
if(isset($_SESSION['uid']))
	{

	 //$sql="DELETE FROM notification_mst WHERE id=".strip_tags($_POST['id']);
      $sql ='DELETE FROM notification_mst WHERE id=?';
	  $query=$conn->prepare($sql);
	  $id=strip_tags($_POST['id']);
	  $query->bind_param("i",$id);  
	  
	if($query->execute())	
		{
		?>
		<div style="width:100%; padding:10px; background:green; color:#fff;">Record Deleted successfully</div>
		<?php
              
	    }
	    
    }
$conn->close();
?> 
