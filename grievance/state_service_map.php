<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    echo $_SESSIOIN['uid'];
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		
		if(isset($_POST['save']))
		{
		    
                    		if(!empty($_POST['check_list'])) {
                    		     $sql ="update category3_mst set merg_cs_id='0' where ulbid='".$_SESSION['ulbid']."'";
                    		     mysqli_query($conn,$sql);
                        foreach($_POST['check_list'] as $val) {
                                
                               $arr=explode('-',$val);
                               $standard_cs_id=$arr[0];
                               $cat3_id=$arr[1];
                               
                               
                             $sql ="update category3_mst set merg_cs_id='".$standard_cs_id."' where cs_id='".$cat3_id."'";
                              
                              if(mysqli_query($conn,$sql))
                              {
                                 $sql2 ="update grievances set mcat3_id='".$standard_cs_id."' where cat3_id='".$cat3_id."' and ulbid='".$_SESSION['ulbid']."' and app_type_id='2'";
                                 mysqli_query($conn,$sql2); 
                              }
                        }
                        $tpl->assign('msg',"<div alert alert-success'>Updated successfully</div>");
                    }
                    else
                    {
                        $tpl->assign('msg','Please check any checkbox');
                    }
        }
		
		
		$sql ="select cs_id,comp_desc,ulbid from category3_mst where merg_cs_id=0";
		if($_SESSION['user_type']=='U')
		{
		    $sql ="select cs_id,comp_desc,ulbid from category3_mst where ulbid='".$_SESSION['ulbid']."' and merg_cs_id=0";
		}
		
		$rs= mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $ulb_services_list[$row['ulbid']][$row['cs_id']]=$row['comp_desc'];
		}
		
		$sql="select * from  standard_services";
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $standard_service_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$sql ="select ulbid, ulbname from ulbmst where ulbid NOT IN('500')";
		if($_SESSION['user_type']=='U')
		{
		    $sql ="select ulbid, ulbname from ulbmst where ulbid ='".$_SESSION['ulbid']."'";
		}
		
		
		$rs=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		}
		
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('ulb_services_list',$ulb_services_list);
		$tpl->assign('standard_service_list',$standard_service_list);
				
				
				$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql ="SELECT * FROM `standard_services`";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $standard_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$sql ="select cs_id,comp_desc,merg_cs_id from category3_mst where cs_type_id='2' and ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $standard_list_mapped[$row['cs_id']]=$row['comp_desc'];
		    $checked_values[$row['cs_id']][$row['merg_cs_id']]="checked";
		}
		
		
		
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like '%".$_SESSION['ulbid']."%'"; 
	      $rs = mysqli_query($conn,$sql);
	      $row = mysqli_fetch_assoc($rs);
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('checked_values',$checked_values);
		$tpl->assign('standard_list_mapped',$standard_list_mapped);
		$tpl->assign('standard_list',$standard_list);
		$tpl->assign('online_applications',$online_applications);
		mysqli_close($conn);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('ulb_standard_service_map.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>