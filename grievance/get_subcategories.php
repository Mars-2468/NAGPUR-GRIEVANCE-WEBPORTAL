<?php
require "config.php";
$str="0:::Select Sub Category";

	if(isset($_GET['cat_id']))
	{
	   
	    require_once('prepare_connection.php');
        $sql ="SELECT sub_cat_id,description FROM subcategory_mst WHERE cat_id=? ORDER BY description";
        $cat_id=$_GET['cat_id'];
        $query=$conn->prepare($sql);
        $query->bind_param("i",$cat_id);
        $query->execute();
	    $rs=$query->get_result();
        
        if($row = $rs->fetch_assoc())
        {
            do{
                $str.="___".$row['sub_cat_id'].":::".$row['description'];
            }while($row = $rs->fetch_assoc());
            
        }        
        echo $str;
        $query->close();
	}
?>