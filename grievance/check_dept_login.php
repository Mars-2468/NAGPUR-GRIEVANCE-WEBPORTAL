<?php
  require "config.php";
	    ini_set('display_errors',0);
		include('connection.php');
		$conn=getconnection();
		$uid=mysqli_real_escape_string($conn,strip_tags($_POST['username']));
	     $pwd=sha1($_POST['fk']);

		
		$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
		$code=mysqli_real_escape_string($conn,$_SESSION['code']);
		
		$path=mysqli_real_escape_string($conn,$_POST['login_path']);
		
		
		
		
		
	$sql1="select * from users where user_id=? and user_pwd=PASSWORD(?)";
		
		
		$query=$conn->prepare($sql1);
		$query->bind_param("ss",$uid,$pwd);
		 
		$query->execute();
		$rs=$query->get_result();
		$row=$rs->fetch_assoc();
		
		
		
		
		
		
		
		
		//echo $sql1="select * from users where user_id='".$uid."' and user_pwd=PASSWORD('".$pwd."')";
		
		//print_r($row);
		if(count($row) > 0)
		{
		    
		 /*if(isset($_SESSION['code']))   
		   { 
		if($captcha === $code)
		{
		     unset($_SESSION['code']);*/
		     
		     
		    
		    if($row['is_blocked']=='1')
		    {
		        $_SESSION['message'] = "<div class='alert alert-danger'>Dear $uid , Your login is blocked by admin, Please contact site admin. </div>";
		        echo "<script>window.location.href='index.php';</script>";
		    }
		    setcookie("PHPSESSID", "", time()-3600);
		    session_regenerate_id(true);
		    $sessid = md5(rand(0,10000));
			setcookie("PHPSESSID", session_id(), time() + (60*60*24*10),NULL, NULL, NULL, 
			TRUE  // this is the httpOnly flag you need to set
		  );
		   
			$ipAddress = $_SERVER['REMOTE_ADDR'];
		    $_SESSION['ip_address']=$_SERVER['REMOTE_ADDR'];
			$_SESSION['user_agent']=$_SERVER['HTTP_USER_AGENT'];
			$_SESSION['uid']=$uid;
			$_SESSION['user_name']=$row['user_name'];
			$_SESSION['ulbid']=$row['ulbid'];
			$_SESSION['user_type']='D';
			$_SESSION['sec_level']=$row['sec_level'];
			$_SESSION['emp_id']=$row['emp_id'];
			$_SESSION['mc_yn']=$row['mc_yn'];
			$_SESSION['session_id']=session_id();
			$_SESSION['is_hod']=1;
			$_SESSION['is_level4_emp']=$row['is_level4_emp'];
			$_SESSION['update_previlize']=$row['update_previlize'];
			
			$sql ="select emp_desg from emp_mst where emp_code ='".$_POST['username']."'";
			$rs = mysqli_query($conn,$sql);
			$emp_det = mysqli_fetch_assoc($rs);
		    $emp_desg = $emp_det['emp_desg'];
		    
		 $sql ="select h.dept_id,d.dept_desc from hod_mst h,dept_mst d where h.dept_id=d.dept_id and h.desg_id='".$emp_desg."'";
		
			
			$rs = mysqli_query($conn,$sql);
			$emp_desg_det = mysqli_fetch_assoc($rs);
			$dept_id = $emp_desg_det['dept_id'];
			
			
			if($dept_id =='')
			{
		
				$sql ="SELECT dept_id FROM `emp_map` WHERE `emp_id2` LIKE '".$row['emp_id']."' group by dept_id";
				$sql2 ="SELECT dept_id FROM `emp_map` WHERE `emp_id3` LIKE '".$row['emp_id']."' group by dept_id";
				$sql3 ="SELECT dept_id FROM `emp_map` WHERE `emp_id4` LIKE '".$row['emp_id']."' group by dept_id";
		
		
			
			    //echo "<script>window.location.href='dept_login.php';</script>";
			}
			
			
			
			$_SESSION['emp_dept_id']=$dept_id;
			$_SESSION['dept_name']=$emp_desg_det['dept_desc'];
			
			//echo "<script>window.location.href='department_dashboard.php';</script>";
			echo "<script>window.location.href='ward_wise_abstract.php';</script>";
			
			
			
			
		}
		else
		{
		    
		   
			
		echo "<script>window.location.href='dept_login.php';</script>";
			
		
		}
		
		$conn->close();
			
	
?>
                            