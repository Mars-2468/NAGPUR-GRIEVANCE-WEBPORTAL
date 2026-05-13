<?php
    require "config.php";
    ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new smarty();
	$indexpage="http://egovmars.in/csms";
		
	if(isset($_SESSION['uid']))
	{
		
	    	
		require_once('connection.php');
		$conn=getconnection();	
	
		$sql1="update login_details set session_active=? where user_id=? and session_active=?";
		$session_active = 0;
		$user_id = $_SESSION['uid'];
		$session_active=1;
		$query = $conn->prepare($sql1);
		//$query->bind_param("isi",$session_active,$user_id,$session_active);
		
	    //$query->execute();
		//$query->close();
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$sql ="insert into login_details(ip,ulbid,user_id,type,login_throug_type)values(?,?,?,?,?)";
		$type = 2;
		$login_throug_type=1;
		$sql = $conn->prepare($sql);
		//$sql->bind_param("sssii",$ipAddress,htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($_SESSION['uid'])),$type,$login_throug_type);
		//$sql->execute();
		
		user_logout_audits($conn, $user_id,$_SESSION['log_id'],'Logout: Manual Logout');
		
		$sql ="update users set login_status=? where user_id=?";
		$login_status=0;
		
		$sql = $conn->prepare($sql);
		$sql->bind_param("is",$login_status,$user_id);
		$sql->execute();
			
/************************************ set user is inactive **************************************/
$is_active = 0; // true

$sql = $conn->prepare("UPDATE users SET is_active=? WHERE user_id=?");
$sql->bind_param("is", $is_active, $user_id);

$sql->execute();
/************************************ start session_users **************************************/

		$sql = "delete from session_users where user_id=? and session_id=?";
		$query = $conn->prepare($sql);
		

		if ($query) {
		   $query->bind_param("ss", $_SESSION['user_id'], $_SESSION['session_id']);
			$query->execute();
			$query->close();
		} else {
			die("Prepare failed: " . $conn->error);
		}
		

		//echo "<pre>";print_r($session_count);echo "</pre>";die();

		/************************************ start session_users end **************************************/

		
		session_unset(); // Unset all session variables
		session_destroy(); // Destroy the session
		//unset($_COOKIE["PHPSESSID"]);
		session_start();	
		// log audit
				
		log_audit_trail($conn,$user_id, $action='logout', $details='User logged out',$model='users',$record_id=$user_id,$old='login',$new='Manual logout');

	

		$_SESSION['msg']="You have Successfully Logged out.";
		
		header("Location:".$link."index.php");
			
		//$tpl->assign('msg',$msg);
		//echo "<script>window.location.href='index.php';</script>";		
		
	}
	else
	{
		$_SESSION['msg']="You have Successfully Logged out.";
		echo "<script>window.location='index.php';</script>";
	}
	
	
	
	
	
	
?>