<?php
	session_start();
	    ini_set('display_errors',0);
		require_once('../connection.php');
	    $conn=getconnection();
		$uid=mysqli_real_escape_string($conn,strip_tags($_POST['user_id']));
	    $pwd=sha1(md5($_POST['password']));
		
		
		$sql1="select * from users where user_id='".$uid."' and user_pwd=PASSWORD('".$pwd."')";
		$rs = mysqli_query($conn,$sql1);
		$row = mysqli_fetch_assoc($rs);
		
		if(count($row) > 0)
		{
		    
			
			
			$sql ="select emp_desg from emp_mst where emp_mobile ='".$_POST['user_id']."'";
			$rs = mysqli_query($conn,$sql);
			$emp_det = mysqli_fetch_assoc($rs);
		    $emp_desg = $emp_det['emp_desg'];
		    
		    $sql ="select h.dept_id,d.dept_desc from hod_mst h,dept_mst d where h.dept_id=d.dept_id and h.desg_id='".$emp_desg."'";
			
			$rs = mysqli_query($conn,$sql);
			$emp_desg_det = mysqli_fetch_assoc($rs);
			$dept_id = $emp_desg_det['dept_id'];
			
			
			if($dept_id =='')
			{
			    $response['status_code'] = 100;
			    $response['emp_id'] = 0;
		      	$response['message'] = 'Incorrect Password';
			}
			else
			{
			    
			    $response['status_code'] = 200;
		      	$response['message'] = 'Valid details';
		      	$response['emp_dept_id'] = $dept_id;;
		      	$response['dept_name'] = $emp_desg_det['dept_desc'];
			}
			
		
		}
		else
		{
		    
		   
			
		        $response['status_code'] = 100;
			    $response['emp_id'] = 0;
		      	$response['message'] = 'Incorrect Password';
			
		
		}
		
		echo json_encode($response); 
		
		$conn->close();
			
	
?>
                            