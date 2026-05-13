<?php
require "config.php";
	if(isset($_POST['dept_id']))
	{
		
		require_once('connection.php');
		$conn=getconnection();
		
		$nodata=0;
		
		$sql="select desg_id,desg_desc from desg_mst where ulbid='".$_SESSION['ulbid']."'";
		if($rs=mysqli_query($conn,$sql))
		{
			while($row = mysqli_fetch_assoc($rs))
				$desg_list[$row['desg_id']]=$row['desg_desc'];
		}
		
		 $sql ="select emp_id,emp_name,emp_mobile,emp_desg from emp_mst where emp_dept='".$_REQUEST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0'";
		 $list2.=" <option value='0'>---Select----</option>";
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	           $nodata=1;
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $list2.=" <option value=".$row['emp_id'].">". $row['emp_name']."(".$desg_list[$row['emp_desg']].")"."-".$row['emp_mobile']."</option>";
		      
		       }
		   }
		
		$sql ="select emp_id,emp_name,emp_mobile,emp_desg from emp_mst_od where emp_dept='".$_REQUEST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and delete_status='0'";
		 
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	           $nodata=1;
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $list2.=" <option value=".$row['emp_id'].">". $row['emp_name']."(".$desg_list[$row['emp_desg']].")"."-".$row['emp_mobile']."</option>";
		      
		       }
		   }
		
		
		$sql ="select e.emp_id,emp_name,emp_mobile,desg_id from emp_mst e,emp_desg_map em where em.emp_id=e.emp_id and em.dept_id='".$_REQUEST['dept_id']."' and ulbid='".$_SESSION['ulbid']."' and e.delete_status='0' and em.delete_status='0' group by e.emp_id";
		 
	      $rs = mysqli_query($conn,$sql);
	       
	       if(mysqli_num_rows($rs) > 0)
	       {
	           $nodata=1;
		       while($row = mysqli_fetch_assoc($rs))
		       {
		      
		      $list2.=" <option value=".$row['emp_id'].">". $row['emp_name']."(".$desg_list[$row['desg_id']].")"."-".$row['emp_mobile']."</option>";
		      
		       }
		}
		
		if($nodata == 0)
		{
		   $list2="<option value='0'>---No Employees Found----</option>";
		}
		
		
		
		echo $list2;
		
		mysqli_close($conn);
		
	}
?>