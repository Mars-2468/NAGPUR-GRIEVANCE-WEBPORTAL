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
		
			//echo "<pre>";print_r(base_url_link());echo "</pre>";die('dddd');
        mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET names=utf8');
    	mysqli_query($conn,'SET character_set_client=utf8');
    	mysqli_query($conn,'SET character_set_connection=utf8');
    	mysqli_query($conn,'SET character_set_results=utf8');
    	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
				
           $sql="select comm_tab.*, wing_department_mst.title as dept, wing_department_mst.marathi_title as dept_marathi FROM comm_tab LEFT JOIN wing_department_mst ON comm_tab.user_type = wing_department_mst.id  where ulbid='".$_SESSION['ulbid']."' order by comm_tab.sortorder asc";
		   $i=1;
		   $rs=mysqli_query($conn,$sql);
		   $tot_row=mysqli_num_rows($rs);
		    if(mysqli_num_rows($rs)>0)
			{
			$key = 0;
				while($row = mysqli_fetch_assoc($rs))
				{
					$data[$key]['comm_name']=$row['comm_name'];
					$data[$key]['user_type']=$row['user_type'];
					$data[$key]['comm_name_marathi']=$row['comm_name_marathi'];
					$data[$key]['designation']=$row['designation'];
					$data[$key]['dept']=$row['dept'];
					$data[$key]['designation_marathi']=$row['desig_marathi'];
					$data[$key]['mobile']=$row['mobile'];
					$data[$key]['file_url']=$row['file_url'];
					$data[$key]['email']=$row['email'];
					$data[$key]['land_line']=$row['land_line'];
					$data[$key]['fax']=$row['fax'];
					$data[$key]['address']=$row['address'];
					$data[$key]['address_marathi']=$row['address_marathi'];
					$data[$key]['link']=$row['link'];
					$data[$key]['officebuilding']=$row['officebuilding'];
					$data[$key]['id']=$row['id'];
					$data[$key]['sortorder']=$row['sortorder'];
					$key++;
				}
				$tpl->assign('data',$data);
				$tpl->assign('comm_data',$rs);
				
		 }
			
			
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
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
	     
		 
		   // returns null or array 
		 
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
		$tpl->display('comm_contact.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
	
