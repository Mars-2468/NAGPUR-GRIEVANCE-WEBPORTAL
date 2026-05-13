<?php
require "config.php";
$str="0:::Select Designation";

	if(isset($_GET['dept_id']))
	{
	   
	    require_once('prepare_connection.php');
        $sql ="SELECT desg_id,desg_desc FROM desg_mst WHERE dept_id=? ORDER BY desg_desc";
        $dept_id=$_GET['dept_id'];
        $query=$conn->prepare($sql);
        $query->bind_param("i",$dept_id);
        $query->execute();
	    $rs=$query->get_result();
        
        if($row = $rs->fetch_assoc())
        {
            do{
                $str.="___".$row['desg_id'].":::".$row['desg_desc'];
            }while($row = $rs->fetch_assoc());
            
        }
        
        echo $str;
        $query->close();
	}
?>