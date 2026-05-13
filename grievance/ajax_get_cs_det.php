<?php
require "config.php";
	if(isset($_POST['cs_id']))
	{
		
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['cs_id'])) // id
   {
       die('Invalid data passed to Department');
   }
		
	       $sql ="select * from category3_mst where cs_id=? and cs_type_id=? and ulbid=?";
		   $csid = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		   $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		   $cs_type_id = 2;
		   $query=$conn->prepare($sql);
		   $query->bind_param("iis",$csid,$cs_type_id,$ulbid);
		   $query->execute();
		   
	       $rs=$query->get_result();
	       $row = $rs->fetch_assoc();
	       echo $row['cutt_of_time'];
	       echo "::";
	       echo $row['app_fee'];
	       echo "::";
	       echo $row['fine_per_day'];
	       echo "::";
	       echo $row['comp_desc'];
	       echo "::";
	       echo $row['telugu_description'];
	       echo "::";
		   
	       $query->close();
	       $sql ="select doc_id from cs_doc_map where cs_id=?";
		   $cs_id = htmlspecialchars(strip_tags($_REQUEST['cs_id']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("i",$cs_id);
		   $query->execute();
		   
	       $rs=$query->get_result();
	      
	       while($row1 = $rs->fetch_assoc())
	       {
	      	$string1.=$row1['doc_id'];
	      	$string1.="-";
	       }
	      
	       echo $string1;
	       
	      $query->close();
	}
?>