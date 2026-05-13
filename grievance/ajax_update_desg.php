<?php 
require "config.php";
require_once('connection.php');
$conn=getconnection();

 if (!preg_match("/^[0-9]+$/", $_REQUEST['emp_id'])) 
   {
       die('Invalid Data Passed To Department..!');
   }
   
    if (!preg_match("/^[0-9]+$/", $_REQUEST['id'])) 
   {
       die('Invalid Data Passed To Department..!');
   }
   
if(isset($_REQUEST['emp_id']) && isset($_REQUEST['desg_id']) && isset($_REQUEST['id']))
	{
	
        /*old code 16-05-24 $sql="UPDATE emp_desg_map SET dept_id= ? , desg_id= ? WHERE emp_id=? and id=?";
	    $query=$conn->prepare($sql);
	  
        $dept_id=$_REQUEST['dept_id'];
        $desg_id=$_REQUEST['desg_id'];
        $emp_id=$_REQUEST['emp_id'];
        $id=$_REQUEST['id'];
        $query->bind_param("iiii",$dept_id,$desg_id,$emp_id,$id);
        $query->execute();
        $rs=$query->get_result();
		if($rs)
		{
		echo 'Updated Successfully..!';
		}
		else
		{
		echo 'Unable To Update, Try Again..!';
		}*/
	
	  $sql="UPDATE emp_desg_map SET dept_id= ? , desg_id= ? WHERE emp_id=? and id=?";
	  $query=$conn->prepare($sql);
	  
        $dept_id=$_REQUEST['dept_id'];
        $desg_id=$_REQUEST['desg_id'];
        $emp_id=$_REQUEST['emp_id'];
        $id=$_REQUEST['id'];
        $query->bind_param("iiii",$dept_id,$desg_id,$emp_id,$id);
        //$query->execute();
        //$rs=$query->get_result();

        //echo $sql;
		if($query->execute())
		{
		    echo 'Updated Successfully..!';
		}
		else
		{
		    echo 'Unable To Update, Try Again..!';
		}
		
		
		
   $query->close();         
	
}
?> 