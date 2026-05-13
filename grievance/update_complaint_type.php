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
		
		if(!isset($_POST['update'])){
			echo "<script>window.location.href='add_complaint_type.php'</script>";
		}
		
		 	$sqlOfCS ="select * from cs_mst where cs_id='".$_POST['cs_id']."'";
			$rsOfCS  = mysqli_query($conn,$sqlOfCS);
			while($row =mysqli_fetch_assoc($rsOfCS))
			{
			     
			    $data['cs_id']=$row['cs_id'];
			    $data['cat_id']=$row['cat_id'];
			    $data['sub_cat_id']=$row['sub_cat_id'];
			    $data['cs_desc']=$row['cs_desc'];
			    $data['telugu_description']=$row['telugu_description'];			  
			}
			
			
		 	$sqlOfCompCutOfDaysMap ="select * from comp_cutofdays_map where cs_id='".$_POST['cs_id']."'";
			$rsOfCompCutOfDaysMap = mysqli_query($conn,$sqlOfCompCutOfDaysMap);
			while($row =mysqli_fetch_assoc($rsOfCompCutOfDaysMap))
			{
			  
			    $cdata['cs_id']=$row['cs_id'];
			    $cdata['cutt_off_time']=$row['cutt_off_time'];			  
			}
			
		
			    $sqlOfLevelDisposabledaysMap ="select * from level_disposabledays_map where cs_id='".$_POST['cs_id']."'";
				$rsOfLevelDisposabledaysMap = mysqli_query($conn,$sqlOfLevelDisposabledaysMap);
				while($row= mysqli_fetch_assoc($rsOfLevelDisposabledaysMap))
				{
					$levelOfdata['cs_id']=$row['cs_id'];
					$levelOfdata['L1']=$row['L1'];	
					$levelOfdata['L2']=$row['L2'];	
					$levelOfdata['L3']=$row['L3'];	
				}
			

		$sqlOfCategoriesQuery =$conn->prepare("select cat_id, description,telugu_description from category_mst where ulbid=?");
		$sqlOfCategoriesQuery->bind_param("s",$_SESSION['ulbid']);
		$sqlOfCategoriesQuery->execute();
	    $rsOfCategoriesQuery=$sqlOfCategoriesQuery->get_result();
		while($row = $rsOfCategoriesQuery->fetch_assoc()){
		    $category_list[$row['cat_id']]=$row['description'];	
		}
		$sqlOfCategoriesQuery->close();


		$sqlOfCategoriesQuery1 ="select * from subcategory_mst";
		$sqlOfCategoriesQuery2 = mysqli_query($conn,$sqlOfCategoriesQuery1);
		while($row= mysqli_fetch_assoc($sqlOfCategoriesQuery2))
		{
			$sub_category_list[$row['sub_cat_id']]=$row['description'];	
		}

		

		//  print_r($levelOfdata);exit();
		
		$tpl->assign('online_applications',$online_applications);
			
		$tpl->assign('msg',$msg);
		//mysqli_free_result($rs);
		
		// print_r($data);exit();
		mysqli_close($conn);	
		$tpl->assign('ids',$ids);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('multi_desg_list',$multi_desg_list);
		$tpl->assign('data',$data);
		$tpl->assign('cdata',$cdata);
		$tpl->assign('levelOfdata',$levelOfdata);		
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('category_list',$category_list);
		$tpl->assign('sub_category_list',$sub_category_list);
		
		$tpl->display('update_complaint_type.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
	
	
function sanitize_input($data) {

	//PHP
    // Remove unnecessary spaces
    $data = trim($data);

    // Strip tags to prevent HTML and PHP code injection
    $data = strip_tags($data);

    // Convert special characters to HTML entities (e.g., < to &lt;)
    $data = htmlspecialchars($data);
	
	//$data = preg_replace('/[^a-zA-Z0-9\s]/', '', $data);
	
    return $data;
}

?>