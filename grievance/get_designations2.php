<?php

	require "config.php";
	if(isset($_REQUEST['dept_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();

	       $sql ="select desg_id,desg_desc from desg_mst where dept_id=?";
	       $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
	       $query1 = $conn->prepare($sql);
		   $query1->bind_param("i",$dept_id); 
		   $query1->execute();
		   $rs=$query1->get_result();
	       
	       ?>
	       <option value="0">---Select----</option>
	       <?php
	       
	      
		       while($row = $rs->fetch_assoc())
		       {
		       ?>
		       <option value="<?php echo $row['desg_id']; ?>"><?php echo $row['desg_desc']; ?></option>
		       <?php
		       }
	
		
		$conn->close();
	}
?>