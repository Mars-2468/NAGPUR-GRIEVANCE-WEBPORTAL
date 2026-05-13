<?php
	require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
    //echo '<pre>';print_r($_SESSION);die();
	if(isset($_SESSION['uid']))
	{
	    //session_regenerate_id();
	    require_once('connection.php');
		require_once('get_services.php');
		include('user_defined_functions.php');
		include('prepare_connection.php');
		
		$obj  = new get_services($_SESSION['uid']);
		$conn = getconnection();
        $csrf_token=generateToken($csrf_prefix_token);
        $tpl->assign('csrf_token',$csrf_token);
		
		
		$captcha = mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code    = mysqli_real_escape_string($conn,$_SESSION['code']);
		
		
		$ulbid = $_SESSION['ulbid'];
		
		if(isset($_POST['search']))
		{
		    $ulbid = $_POST['searchulbid'];
		}
		
		if(isset($_POST['save']))
		{
		  //echo '<pre>'; print_r($_POST);die();
		   $ulbid = $_POST['ulbid'];
           $sql   = mysqli_query($conn,"UPDATE `dept_mst` SET `merge_dept_id` = 0 WHERE  ulbid = $ulbid");
           $error = 0;
		   foreach($_POST['checkbox'] as $debtId => $value)
		   {
		       foreach($value as $ulbDebtId => $chekBoxValue)
		       {
		           $sql =mysqli_query($conn,"UPDATE `dept_mst` SET `merge_dept_id` = $debtId WHERE dept_id = $ulbDebtId AND ulbid = $ulbid");
		           if($sql)
		           {
		               $error++;
		           }
		       }
		   }
		    
		   if($error > 0)
           {
               $tpl->assign('msg','Updated Successfully');
           }
           else
           {
               $tpl->assign('msg','Not Updated');
           }
		}
		
		$sql = $conn->prepare("select dept_id,dept_desc from departments_mst");
		$sql->execute();
	    $rs  = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		$sql->close();	
		
		
		
		
		$sql =$conn->prepare("select dept_id,dept_desc,merge_dept_id from dept_mst where ulbid=?");
		
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$ulb_dept_list[$row['dept_id']]  =$row['dept_desc'];
			$dept_id_checked[$row['dept_id']]=$row['merge_dept_id'];
		}
		$sql->close();	
		
		
		$sql =$conn->prepare("SELECT * FROM `ulbmst`");
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$ulbList[$row['ulbid']]  =$row['ulbname'];
		}
		$sql->close();	
		
	//	echo '<pre>';print_r($ulbList);die();
		
		
		
	
		
		/** captcha generation ****/
		$code=rand(1000,9999);
		$_SESSION['code']=$code;	
		
		
		$arr1 = $dept_list;
		$arr2 = $ulb_dept_list;
		
	
        $array1Count = count($arr1);
        $tpl->assign('array1Count',$array1Count);
        	
		/** close **/
		
		
		
		$users_count=$row['user_count'];
		$tpl->assign('users_count',$users_count);
		
		
	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$ulbid);
		$tpl->assign('online_applications',$online_applications);
		$conn->close();		
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('dept_list1',$dept_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('code',$code);
		
		$tpl->assign('array1',$arr1);
		$tpl->assign('array2',$arr2);
		$tpl->assign('dept_id_checked',$dept_id_checked);
		$tpl->assign('ulbList',$ulbList);
		
		$tpl->display('mergeDepartments.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
	}
?>