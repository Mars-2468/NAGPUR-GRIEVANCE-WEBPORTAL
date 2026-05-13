<?php
	error_reporting(0);
	require_once('../connection.php');
	$conn=getconnection();
	
  	if(isset($_REQUEST['user_id']))
  	{
  		$uid= $_REQUEST['user_id'];
  		$password= $_REQUEST['password'];
  		
  		$pwd=sha1(md5($password));
		$sql = "select emp_id,user_type,ulbid,user_id,geotagging_status from users where user_id='".$uid."' and user_pwd=PASSWORD('".$pwd."')";
	  	$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		if($nr > 0 )
		{
		    
		    
		    $sql ="update users set login_status='1' where user_id='".$uid."'";
			mysqli_query($conn,$sql);
			
			
			
		    
		    
		    
			while($row = mysqli_fetch_array($res))
			{
			    
			        $sql ="insert into login_details(ulbid,user_id,type,login_throug_type)values('".$row['ulbid']."','".$uid."','1','2')";
			        mysqli_query($conn,$sql);
			        $sql1 ="SELECT emp_mst_od.emp_id,emp_mst_od.emp_name,emp_mst_od.emp_dept,emp_mst_od.emp_desg, hod_mst.desg_id FROM emp_mst_od INNER JOIN hod_mst ON hod_mst.desg_id=emp_mst_od.emp_desg and emp_mst_od.emp_mobile = '".$uid."' and delete_status=0";
			        $rs123 = mysqli_query($conn,$sql1);
			        $nr = mysqli_num_rows($rs123);
			        
			        if($nr <=0)
			        {
			        
			        //$sql1 ="SELECT emp_mst.emp_id,emp_mst.emp_name,emp_mst.emp_dept,emp_mst.emp_desg, hod_mst.desg_id FROM emp_mst INNER JOIN hod_mst ON hod_mst.desg_id=emp_mst.emp_desg and emp_mst.emp_mobile = '".$uid."' and delete_status=0";
			       $sql1 ="SELECT emp_mst.emp_id,emp_mst.emp_name,emp_mst.emp_dept,emp_mst.emp_desg FROM emp_mst where emp_mst.emp_mobile = '".$uid."' and delete_status=0";
			        	$res1 = mysqli_query($conn,$sql1);
			        	$row2=mysqli_fetch_assoc($res1);
                		$nr1 = mysqli_num_rows($res1);
                		if($nr1 > 0 )
                		{
                		    
                		    $response['emp_type'] = 'emp';
                		     
                		}
                		else
                		{
                		    $response['emp_type'] = 'emp';
                		}
			        }
			        else
			        {
			            $row2=mysqli_fetch_assoc($rs123);
			            $response['emp_type'] = 'emp';
			        }
			        
			     	$response['status_code'] = 200;
			      	$response['message'] = 'Valid details';
			      	$response['emp_id'] = $row2['emp_id']."-".$row[1]."-".$row[2]."-".$row[3];
			      	$response['ulbid'] = $row[2];
			      	$response['geotagging_status'] = $row[4];
			      	if(is_null($row2['emp_dept']))
			      	{
			      	    $row2['emp_dept']="";
			      	}
			      	if(is_null($row2['emp_desg']))
			      	{
			      	    $row2['emp_desg']="";
			      	}
			      	$response['emp_dept'] = $row2['emp_dept'];
			      	$response['emp_desg'] = $row2['emp_desg'];
			}
		}
		else
		{
			$response['status_code'] = 100;
			$response['emp_id'] = 0;
		      	$response['message'] = 'Incorrect Password';
		}
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  