<?php
session_start();
ini_set('display_errors',0);
	require_once('../connection.php');
	$conn=getconnection();
	
  	if(isset($_REQUEST['emp_id']))
  	{
  	    /** splitting empid as empid and user type, here we get empid and user type seperated with - **/
  	    
  	     $arr=explode("-",$_REQUEST['emp_id']);
  	  
  	    /*** setting emp id after spit the stirng **/
  	    $_REQUEST['emp_id']=$arr[0];
  	    $_SESSION['emp_id']=$arr[0];
  	    
  	    /** assign user type **/
  	    $user_type=$arr[1];
  	    /** setting ulbid **/
  	    $ulbid=$arr[2];
  	    /** setting user id **/
  	    $user_id=$arr[3];
  	    
  	    
  	    /** select user details in case of login ulb or commissioner **/
  	    
  	    if($user_type== 'U')
  	    {
  	        $sql ="select user_id as emp_name,user_mobile as emp_mobile, user_dept as dept_desc, ulbname,usr.ulbid  from users usr, ulbmst u where usr.ulbid=u.ulbid and 
  	        usr.ulbid='".$ulbid."' and usr.user_id='".$user_id."'";
  	    }
  	    else
  	    {
  	         $sql = "SELECT e.emp_name, e.emp_mobile, d.dept_desc, de.desg_desc, u.ulbname from emp_mst e, dept_mst d, desg_mst de, ulbmst u  where e.emp_id = '".$_REQUEST['emp_id']."' 
  	        and e.emp_dept = d.dept_id and e.emp_desg = de.desg_id and e.ulbid = u.ulbid";
  	        
  	        $sql3 = "SELECT e.emp_name, e.emp_mobile, d.dept_desc, de.desg_desc, u.ulbname from emp_mst_od e, dept_mst d, desg_mst de, ulbmst u  where e.emp_id = '".$_REQUEST['emp_id']."' 
  	        and e.emp_dept = d.dept_id and e.emp_desg = de.desg_id and e.ulbid = u.ulbid";
  	    }
  	    
  	    
  	    
  		
  		$res = mysqli_query($conn,$sql);
		$nr = mysqli_num_rows($res);
		while($row = mysqli_fetch_array($res))
		{
		     	$response['emp_name'] = $row['emp_name'];
		     	$response['Mobile'] = $row['emp_mobile'];
		     	$response['Section'] = $row['dept_desc'];
		     	$response['designation'] = $row['desg_desc'];
		     	$response['Ulbname'] = $row['ulbname'];
		}
		
		$res3 = mysqli_query($conn,$sql3);
		$nr3 = mysqli_num_rows($res3);
		if($nr3 > 0)
		{
    		while($row = mysqli_fetch_array($res3))
    		{
    		     	$response['emp_name'] = $row['emp_name'];
    		     	$response['Mobile'] = $row['emp_mobile'];
    		     	$response['Section'] = $row['dept_desc'];
    		     	$response['designation'] = $row['desg_desc'];
    		     	$response['Ulbname'] = $row['ulbname'];
    		}
		}
  		
  		
		
		echo json_encode($response); 
 	}
	mysqli_close($conn);
?>
  