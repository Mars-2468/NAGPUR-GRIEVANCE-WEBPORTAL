<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');

	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		include('user_defined_functions.php');
        $csrf_token=generateToken($csrf_prefix_token);
        $tpl->assign('csrf_token',$csrf_token);
                    
		function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


        $captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code=mysqli_real_escape_string($conn,$_SESSION['code']);

		
		
		if(isset($_POST['save']))
		{
		    $password = sha1(md5($_POST['password']));
		    $sql ="insert into users(
		        user_id,
		        user_pwd,
		        user_name,
		        user_mobile,
		        user_email,
		        user_type,
		        ulbid,
		        created_by
		        )values(
		            '".htmlspecialchars(strip_tags($_POST['username']))."',
		            PASSWORD('".$password."'),
		            '".htmlspecialchars(strip_tags($_POST['emp_name']))."',
		            '".htmlspecialchars(strip_tags($_POST['emp_mobile']))."',
		            '".htmlspecialchars(strip_tags($_POST['emp_email']))."',
		            'AG',
		            '600',
		            '".$_POST['supervisorId']."'
		            )";
		            if(mysqli_query($conn,$sql))
		            {
		                
		                require_once('send_sms.php');
	                    require_once('sms_conf.php');
	                    $sms="Dear ".$_POST['emp_name']." Account is created in you on Citizen Servie Monitoring System www.municipalservices.in, your Username is ".mysqli_real_escape_string($conn,strip_tags($_POST['username']))." and password is ".$_POST['password']." -Grievance Monitoring Cell";
	                    send_sms($sms,$_POST['emp_mobile']);
	                    
	                    
		                $tpl->assign('msg',"User created successfully");
		            }
		            else
		            {
		                $tpl->assign('msg','Unable to create user , Please try again');
		            }
		}
		
		$sql ="select * from users where user_type='AG'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $data[$row['user_id']]['user_id'] =$row['user_id'];
		    $data[$row['user_id']]['emp_name'] =$row['user_name'];
		    $data[$row['user_id']]['emp_mobile'] =$row['user_mobile'];
		    $data[$row['user_id']]['user_email'] =$row['user_email'];
		    $data[$row['user_id']]['updated_by'] =$row['created_by'];
		    
		    
		    
		}
		
		
		
		$sql ="select * from users where user_type='CS'";
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $supervisorsList[$row['user_id']]=$row['user_id'];
		    
		    $supervisorsnames[$row['user_id']]=$row['user_name'];
		    
		}
		
		

		
		mysqli_close($conn);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
		$tpl->assign('ulbid',$_SESSION['ulbid']);
        $tpl->assign('supervisorsList',$supervisorsList);
        $tpl->assign('supervisorsnames',$supervisorsnames);
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('ids',$ids);
		$tpl->assign('mobile',$_POST['mobile']);
		$tpl->assign('emp_name',$_POST['emp_name']);
		$tpl->assign('desg_list2',$desg_list2);
		$tpl->assign('multi_desg_list',$multi_desg_list);
		$tpl->assign('data',$data);
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		$tpl->display('createagent.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>