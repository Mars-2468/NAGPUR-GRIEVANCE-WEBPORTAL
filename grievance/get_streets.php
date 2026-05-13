<?php
require "config.php";
$str="0:::Select Ward";

	if(isset($_GET['ward_id']))
	{
	   
	    require_once('prepare_connection.php');
        $sql ="SELECT street_id,street_desc FROM street_mst WHERE ulbid='250' and ward_id=? ORDER BY street_desc";
        $ward_id=$_GET['ward_id'];
        $query=$conn->prepare($sql);
        $query->bind_param("i",$ward_id);
        $query->execute();
	    $rs=$query->get_result();
        
        if($row = $rs->fetch_assoc())
        {
            do{
                $str.="___".$row['street_id'].":::".$row['street_desc'];
            }while($row = $rs->fetch_assoc());
            
        }
        
        echo $str;
        $query->close();
	}
?>