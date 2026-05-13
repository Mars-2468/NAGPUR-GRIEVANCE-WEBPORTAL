<?php 
require "config.php";
	function get_ulb_info()
	{
		require_once('connection.php');
		$conn=getconnection();	
		$sql1="select * from ulb_info where ulbid=?";
		 $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		        $query1 = $conn->prepare($sql1);
		        $query1->bind_param("s",$ulbid); 
		        
	            
		
		
		if($query1->execute())
		{
		    $rs=$query1->get_result();
		    
			$row1 = $rs->fetch_assoc();
			$ulb_info['ulb_name']=$row1['ulb_name'];
			$ulb_info['myemail']=$row1['myemail'];
			$ulb_info['workingkey']=$row1['workingkey'];
			$ulb_info['sender']=$row1['sender'];
			$ulb_info['url']=$row1['url'];
			$ulb_info['path_php']=$row1['path_php'];
		}
		return $ulb_info;
		$conn->close();
	}
?> 