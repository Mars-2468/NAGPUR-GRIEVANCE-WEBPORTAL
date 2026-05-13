<?php
   require "config.php";
    date_default_timezone_set('Asia/Calcutta');
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
		$errors = [];
		
		
		
           $sql="select * from comm_tab where ulbid='".$_SESSION['ulbid']."' and id='".$_GET['id']."' ";
		   $i=1;
		   $rs=mysqli_query($conn,$sql);
		   $tot_row=mysqli_num_rows($rs);
		   if(mysqli_num_rows($rs)>0)
			{
			$key = 0;
				
				while($row = mysqli_fetch_assoc($rs))
				{
				
					
					 $data['comm_name']=$row['comm_name'];
					 $data['user_type']=$row['user_type'];
					$data['comm_name_marathi']=$row['comm_name_marathi'];
					$data['designation']=$row['designation'];
					$data['designation_marathi']=$row['designation_marathi'];
					$data['mobile']=$row['mobile'];
					$data['file_url']=$row['file_url'];
					$data['email']=$row['email'];
					$data['land_line']=$row['land_line'];
					$data['fax']=$row['fax'];
					$data['address']=$row['address'];
					$data['address_marathi']=$row['address_marathi'];
					$data['link']=$row['link'];
					$data['officebuilding']=$row['officebuilding'];
					$data['id']=$row['id'];
					$data['sortorder']=$row['sortorder'];
					$key++;
				}
				$tpl->assign('data',$data);
				$tpl->assign('comm_data',$rs);
				
		 }
			
			$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."' ";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
        $sql ="SELECT * FROM `wing_department_mst` ";
		$rs =mysqli_query($conn,$sql);
		$des_key = 0;
		while($row = mysqli_fetch_assoc($rs))
		{
			
		    $departments[$des_key]['id']=$row['id'];
		    $departments[$des_key]['title']=$row['title'];
		    $departments[$des_key]['marathi_title']=$row['marathi_title'];
			$des_key++;
		}
		$tpl->assign('departments',$departments);
		
		  $sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	     
		mysqli_close($conn);
		
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
			
		$tpl->assign('villages',array('208'=>'Jillelguda','210'=>'Meerpet'));
        $tpl->assign('ulbid',$_SESSION['ulbid']);	
		$tpl->assign('data',$data);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$flash = get_flash();		
		$tpl->assign("flash", $flash);
		$tpl->display('edit_comm_contact.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>