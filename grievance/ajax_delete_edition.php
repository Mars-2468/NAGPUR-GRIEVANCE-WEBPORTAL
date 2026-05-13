<?php 
require "config.php";
ini_set('display_errors',0);
require_once('connection.php');
$conn=getconnection();
include('prepare_connection.php');
if(isset($_REQUEST['id']) && isset($_REQUEST['edition_no']))
	{
	

		$edition_no=htmlspecialchars(strip_tags($_REQUEST['id']));
	            $sql ="select edition_no from add_content where edition_no=? and ulbid=?";
				$query=$conn->prepare($sql);
				$query->bind_param("is",$edition_no,$_SESSION['ulbid']);
				$query->execute();
				$rs=$query->get_result();
				$nr= $rs->num_rows;

	if($nr > 0)
	{
	echo 0;
	}
	else
	{
	 
		$id=strip_tags($_REQUEST['id']);
	            $sql ="DELETE FROM add_edition WHERE id=? and ulbid=?";
				$query=$conn->prepare($sql);
				$query->bind_param("is",$id,htmlspecialchars(strip_tags($_SESSION['ulbid'])));
				$query->execute();
				if($query->execute())
				{
		        echo 1;
		        }
		        else
		        {
		        echo 2;
		        }
		
		
	}	
		$sql->close();
		
           
	
}
?> 