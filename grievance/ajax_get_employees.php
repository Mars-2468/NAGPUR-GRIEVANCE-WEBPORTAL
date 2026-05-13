<?php
require "config.php";
	if(isset($_POST['dept_id']))
	{
		$list1="";
		$list2="";
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		 if (!preg_match("/^[0-9]+$/", $_REQUEST['dept_id'])) 
   {
       die('Invalid data passed to Department');
   }
   
    if (!preg_match("/^[0-9]+$/", $_REQUEST['desg_id'])) 
   {
       die('Invalid data passed to Department');
   }

	       $sql ="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and emp_desg=? and ulbid=?";
		   $dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
		   $emp_desg = htmlspecialchars(strip_tags($_REQUEST['desg_id']));
		   $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		   
		   
		   $query=$conn->prepare($sql);
		   $query->bind_param("iis",$dept_id,$emp_desg,$ulbid);
		   $query->execute();
		   $rs=$query->get_result();
		   
		   
	       
	      $list1.=" <option value='0'>---Select----</option>";
	      
	       
	       if($rs->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		      
		      $list1.=" <option value=".$row['emp_id'].">". $row['emp_name']."-".$row['emp_mobile']."</option>";
		      
		       }
		}
		$query->close();
		
		$sql ="select emp_id,emp_name,emp_mobile from emp_mst where emp_dept=? and ulbid=?";
		$dept_id = htmlspecialchars(strip_tags($_REQUEST['dept_id']));
		$ulbid =htmlspecialchars(strip_tags( $_SESSION['ulbid']));
		   $query=$conn->prepare($sql);
		   $query->bind_param("is",$dept_id,$ulbid);
		   $query->execute();
		   $rs=$query->get_result();
		
		 $list2.=" <option value='0'>---Select----</option>";
	      
	       
	       if($rs->num_rows > 0)
	       {
		       while($row = $rs->fetch_assoc())
		       {
		      
		      $list2.=" <option value=".$row['emp_id'].">". $row['emp_name']."-".$row['emp_mobile']."</option>";
		      
		       }
		}
		
		echo $list1;
		echo "::";
		echo $list2;
		
		$query->close();
	}
?>