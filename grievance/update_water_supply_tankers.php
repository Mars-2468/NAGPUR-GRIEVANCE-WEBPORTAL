<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();		
		if(isset($_POST['save']))
		{
		        
		    $sql ="update water_tanker_emp_map set emp_id1='".$_POST['emp_id1']."',emp_id2='".$_POST['emp_id2']."',dept_id='".$_POST['dept_id']."' where water_tank_id='".$_POST['tid']."' ";
				
				if(mysqli_query($conn,$sql))
				{
				    $tpl->assign('msg','Employees mapped successfully');
				}
				else
				{
				    $tpl->assign('msg','Unable to insert , try again');
				}
				
				
			}
			
			
		
		
		
		
		$sql ="SELECT w.*,wt.water_tank_desc FROM water_tanker_emp_map w,water_tank_det_mst wt where wt.water_tank_id=w.water_tank_id and w.ulbid='".$_SESSION['ulbid']."'";
		$rs= mysqli_query($conn,$sql);
		
		if(mysqli_num_rows($rs)>0)
			{ $i=1;
				$field_info = mysqli_fetch_fields($rs);
				while($row = mysqli_fetch_assoc($rs))
				{
				    
				        $water_tanker_list2[$row['water_tank_id']]=$row['water_tank_desc'];
						foreach($field_info as $fi => $f) 
							$data[$row['water_tank_id']][$f->name]=$row[$f->name];
							 
				}
				       
					
			}else
			{  // $msg="No records available";
			   $tpl->assign('fail',$msg);
			}	

		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		// water tanker list
		
		$sql ="SELECT * FROM `water_tank_det_mst`  where ulbid='".$_SESSION['ulbid']."' and water_tank_id NOT IN(select water_tank_id from water_tanker_emp_map)";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $water_tanker_list[$row['water_tank_id']]=$row['water_tank_desc'];
		    
		}
		
			$sql ="SELECT * FROM `dept_mst` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $dept_list[$row['dept_id']]=$row['dept_desc'];
		    
		}
		
		$sql ="SELECT * FROM `emp_mst` where ulbid='".$_SESSION['ulbid']."'";
		$rs =mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $emp_list[$row['emp_id']]=$row['emp_name'];
		    
		}
		
		mysqli_close($conn);
		
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
	
	
	    $tpl->assign('tanker_id',$_REQUEST['tid']);
		$tpl->assign('dept_id_sel',$_REQUEST['dept_id']);
		$tpl->assign('eid1',$_REQUEST['eid1']);
		$tpl->assign('eid2',$_REQUEST['eid2']);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('data',$data);
		$tpl->assign('water_tanker_list2',$water_tanker_list2);
		$tpl->assign('water_tanker_list',$water_tanker_list);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('num_emp',$num_emp);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('desg_list',$desg_list);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('update_water_supply_tankers.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>