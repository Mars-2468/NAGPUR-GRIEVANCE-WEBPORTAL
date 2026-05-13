<?php 
require "config.php";
require_once('connection.php');
$conn=getconnection();
if(isset($_SESSION['uid']))
	{

	 $sql="DELETE FROM tanker_mst WHERE tanker_id=?";
	 $query=$conn->prepare($sql);
	 $id = strip_tags($_POST['tanker_id']);
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