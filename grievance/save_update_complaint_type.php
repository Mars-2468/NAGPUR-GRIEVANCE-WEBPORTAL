<?php
	require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	 
	
	if(isset($_SESSION['uid']))
	{
		
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET names=utf8');
        mysqli_query($conn,'SET character_set_client=utf8');
        mysqli_query($conn,'SET character_set_connection=utf8');
        mysqli_query($conn,'SET character_set_results=utf8');
        mysqli_query($conn,'SET collation_connection=utf8_general_ci');
		// print_r($_POST);exit();
		// print_r($_POST['cs_id']);exit();
		// $csId=$_POST['cs_id'];
		
		// print_r($_POST);exit();
		// print_r($_SESSION['cs_id']);exit();
		if(isset($_POST['updatefrom']))
		{
			if(!validateField($_POST['cs_desc'], 'text')['valid'] || !validateField($_POST['telugu_description'], 'text')['valid'] || !validateField($_POST['level_1'], 'text')['valid'] || !validateField($_POST['level_2'], 'text')['valid'] || !validateField($_POST['level_3'], 'text')['valid']){
				$_SESSION['msg']  = "Enter Valid complaint description or level1/level2/level3..!";
				$_SESSION['class'] = "alert alert-danger display-hide";

				header('Location:update_complaint_type.php');
				exit;
			}else{
			
			
				$_SESSION['cs_id']=$_POST['cs_id'];

				$catId=$_POST['cat_id'];
				$subCatId=$_POST['sub_cat_id'];	 
				$complaintType = $_POST['cs_desc']; //preg_replace('/[^A-Za-z0-9]/', ' ', $_POST['cs_desc']);
				$complaintTypeMarathi =  $_POST['telugu_description']; //$_POST['telugu_description'];
				$level1 = $_POST['level_1'];
				$level2 = $_POST['level_2'];
				$level3 = $_POST['level_3'];

						
				$csId=$_POST['cs_id'];   
						   
				$sql ="update cs_mst set cat_id=?,sub_cat_id=?,cs_desc=?,telugu_description=? where cs_id=?";			
				$query=$conn->prepare($sql);			
				$query->bind_param("iissi",$catId,$subCatId,$complaintType,$complaintTypeMarathi,$csId);   		
				$query->execute();

				
				
				$queryOfCompCutOfDaysMap ="insert into comp_cutofdays_map(cs_id,cutt_off_time)values(?,?) ON DUPLICATE KEY UPDATE  cutt_off_time=?";
				$stmtOfCompCutOfDaysMap=$conn->prepare($queryOfCompCutOfDaysMap);
				$stmtOfCompCutOfDaysMap->bind_param("iss",$csId,$level1,$level1);
				$resultOfCompCutOfDaysMap=$stmtOfCompCutOfDaysMap->execute();

				$queryOfLevelDisposabledaysMap ="insert into level_disposabledays_map(cs_id,L1,L2,L3)values(?,?,?,?) ON DUPLICATE KEY UPDATE L1=?,L2=?,L3=?";
				$stmtOfLevelDisposabledaysMap =$conn->prepare($queryOfLevelDisposabledaysMap);
				$stmtOfLevelDisposabledaysMap->bind_param("issssss",$csId,$level1,$level2,$level3,$level1,$level2,$level3);
				$resultOfstmtOfLevelDisposabledaysMap=$stmtOfLevelDisposabledaysMap->execute();	
			   
				$msg='Updated successfully';	
				$_SESSION['msg']  = $msg;
				$_SESSION['class'] = "alert alert-success display-hide";

			}
		}
		header('Location: update_complaint_type.php');
		exit;
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
	

?>