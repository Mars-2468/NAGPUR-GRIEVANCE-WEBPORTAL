<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	error_reporting(0);
	require_once('Smarty.class.php');
	$tpl = new Smarty();
	
//	echo '<pre>';print_r($_SESSION);die();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		include('user_defined_functions.php');
		include('prepare_connection.php');
        $csrf_token=generateToken($csrf_prefix_token);
        $tpl->assign('csrf_token',$csrf_token);
		
		
		$captcha=mysqli_real_escape_string($conn,$_POST['captcha']);
	    $code=mysqli_real_escape_string($conn,$_SESSION['code']);
		
		$ulbid = $_SESSION['ulbid'];
		
		if(isset($_POST['search']))
		{
		    $ulbid = $_POST['searchulbid'];
		}
		
		
		
		if(isset($_POST['save']))
		{
		   $ulbid = $_POST['ulbid'];
           $error = 0;
           
           $sql =mysqli_query($conn,"UPDATE `desg_mst` SET `std_dept_id` = 0,`std_desg_id` = 0 WHERE  ulbid = $ulbid");
           
		   foreach($_POST['checkbox'] as $dept_id => $standardDepartments)
		   {
		       foreach($standardDepartments as $std_desg_id => $designations)
		       {
    		       foreach($designations as $desg_id => $chekBoxValue)
    		       {
    		           $sqlQuery = "UPDATE `desg_mst` SET `std_dept_id` = $dept_id,`std_desg_id` = $std_desg_id WHERE desg_id = $desg_id AND ulbid = $ulbid";
    		           $sql =mysqli_query($conn,$sqlQuery);
    		           if($sql)
    		           {
    		               $error++;
    		           }
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
		
		$sql =$conn->prepare("select dept_id,dept_desc from departments_mst");
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		$sql->close();	
		
		$sql =$conn->prepare("select id,dept_id,designation from standard_designations");
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$standard_des_list[$row['dept_id']][$row['id']]=$row['designation'];
		}
		$sql->close();	
		
		
		
		$sql =$conn->prepare("SELECT desg_id,desg_desc,merge_dept_id FROM `desg_mst` d,dept_mst d2 WHERE d.dept_id=d2.dept_id and merge_dept_id in(SELECT dept_id FROM `departments_mst`) and d.ulbid=?");
		
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$designations[$row['merge_dept_id']][$row['desg_id']]=$row['desg_desc'];
		
		}
		$sql->close();
		
		
		$sql =$conn->prepare("SELECT * FROM `desg_mst` WHERE  std_dept_id !=0 AND std_desg_id !=0  AND `ulbid`=?  ");
		
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$checkedDesgns[$row['desg_id']][$row['std_desg_id']][$row['std_dept_id']]=$row['desg_id'];
		
		}
		$sql->close();	
		   


		
		
		$sql =$conn->prepare("select dept_id,dept_desc,merge_dept_id from dept_mst where ulbid=?");
		
		$sql->bind_param("s",$ulbid);
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$ulb_dept_list[$row['dept_id']]=$row['dept_desc'];
			$dept_id_checked[$row['dept_id']]=$row['merge_dept_id'];
		}
		$sql->close();	
		
	//	echo '<pre>';print_r($dept_id_checked);die();
		
			
		$sql =$conn->prepare("SELECT * FROM `ulbmst`");
		$sql->execute();
	    $rs=$sql->get_result();
		while($row = $rs->fetch_assoc())
		{
			$ulbList[$row['ulbid']]  =$row['ulbname'];
		}
		$sql->close();	
		
	
		
		/** captcha generation ****/
		$code=rand(1000,9999);
		$_SESSION['code']=$code;	
		
		
		$arr1 = $dept_list;
		$arr2 = $ulb_dept_list;
    	
		/** close **/
		
		
		
		$users_count=$row['user_count'];
		$tpl->assign('users_count',$users_count);
		
		
	    $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$ulbid);
		$tpl->assign('online_applications',$online_applications);
		$conn->close();		
		
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
		
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('standard_des_list',$standard_des_list);
		$tpl->assign('designations',$designations);
		$tpl->assign('checkedDesgns',$checkedDesgns);
		$tpl->assign('ulbList',$ulbList);
		$tpl->display('mergeDesignations.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
	}
?>