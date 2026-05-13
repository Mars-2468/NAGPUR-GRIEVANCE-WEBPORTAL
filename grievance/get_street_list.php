<?php

	require "config.php";
	if(isset($_REQUEST['ward_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();

	       $sql ="select street_id,street_desc from street_mst where ulbid='250' and ward_id=?";
	       $ward_id = htmlspecialchars(strip_tags($_REQUEST['ward_id']));
	       $query1 = $conn->prepare($sql);
		   $query1->bind_param("i",$ward_id); 
		   $query1->execute();
		   $rs=$query1->get_result();
	       
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	      
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['street_id']; ?>"><?php echo $row['street_desc']; ?></option>
		       <?php
		       }
	
		
		$conn->close();
	}
?>