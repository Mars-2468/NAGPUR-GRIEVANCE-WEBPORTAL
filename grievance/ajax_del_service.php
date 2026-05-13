<?php

	require "config.php";
	if(isset($_POST['cs_id']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		

		
		$sql ="select cs_id from emp_map where cs_id=? and ulbid=? and cs_type_id=?";
		$csid = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$cs_type_id = 2;
		$query=$conn->prepare($sql);
		$query->bind_param("isi",$csid,$ulbid,$cs_type_id);
		$query->execute();
		$nr= $query->num_rows;
		if($nr > 0 )
		{
		echo 2;
		}
		else
		{
		       $query->close();

		       $sql ="delete from category3_mst where cs_id=? and ulbid=?";
			   $csid = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
			   $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
			   
			   $query=$conn->prepare($sql);
		       $query->bind_param("is",$csid,$ulbid);
		       if($query->execute())
		       {
		       echo 1;
		       }
		       else
		       {
		       echo 0;
		       }
		   }
		   
		   
	    
	      
	      
	   $query->close(); 
	      
	}
?>