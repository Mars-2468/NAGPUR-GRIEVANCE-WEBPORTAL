<?php
require "config.php";
	ini_set('display_errors',1);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		
		if($_REQUEST['app_type_id']=='1' && $_REQUEST['id']=='1')
			{
			
			$sql="select * from grievances where ulbid=? and app_type_id=? order by date_regd DESC";
				$query=$conn->prepare($sql);
				$ulbid=strip_tags($_REQUEST['ulbid']);
				$app_type_id=strip_tags($_REQUEST['app_type_id']);
				$query->bind_param("si",$ulbid,$app_type_id);
			
			} 
		 
		
		if($_REQUEST['app_type_id']=='1' && $_REQUEST['id']=='2')
			{
	                $sql="select * from grievances where ulbid=? and app_type_id=? and (grievance_status_id =? or grievance_status_id =?) order by date_regd DESC";
			$query=$conn->prepare($sql);
			$ulbid=strip_tags($_REQUEST['ulbid']);
				$app_type_id=strip_tags($_REQUEST['app_type_id']);
				$id3=3;
				$id8=8;
					$query->bind_param("siii",$ulbid,$app_type_id,$id3,$id8);
			} 
			 
			 
		 if($_REQUEST['app_type_id']=='2' && $_REQUEST['id']=='1')
			{
		        $sql="select * from grievances where ulbid=? and app_type_id=? order by date_regd DESC";	
			$query=$conn->prepare($sql);
			$ulbid=strip_tags($_REQUEST['ulbid']);
				$app_type_id=strip_tags($_REQUEST['app_type_id']);
					$query->bind_param("si",$ulbid,$app_type_id);
			}
		 
		 
		 if($_REQUEST['app_type_id']=='2' && $_REQUEST['id']=='2')
			{
			$sql="select * from grievances where ulbid=? and app_type_id=? and (grievance_status_id =? or grievance_status_id =?) order by date_regd DESC";		
		
			$query=$conn->prepare($sql);
			$ulbid=strip_tags($_REQUEST['ulbid']);
				$app_type_id=strip_tags($_REQUEST['app_type_id']);
					$id3=3;
				$id8=8;
					$query->bind_param("siii",$ulbid,$app_type_id,htmlspecialchars(strip_tags($id3)),htmlspecialchars(strip_tags($id8)));
			}
			
		
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				foreach($field_info as $fi => $f) 
				$data[$row['grievance_id']][$f->name]=$row[$f->name];	
			}	
			$query->close();
		}
		
						
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		$query=$conn->prepare($sql);
					
	   
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
				
		}
	
	
	$query->close();
		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id!=?";
		$query=$conn->prepare($sql);
		$grievance_status_id=5;
		 $query->bind_param("i", htmlspecialchars(strip_tags($grievance_status_id)));
		if($query->execute())
		{
		 $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
	
			
	$query->close();
		$sql="select dept_id,dept_desc from dept_mst";
		$query=$conn->prepare($sql);
		if($rs=$query->execute())
		{
			 $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
	
	
				$query->close();		
		$tpl->assign('dept_list',$dept_list);
		
		
		
		$sql="select cs_id,comp_desc from category3_mst where ulbid=?";
			$query=$conn->prepare($sql);
		$ulbid=strip_tags($_REQUEST['ulbid']);
		 $query->bind_param("s", $ulbid);
		if($_REQUEST['app_type_id']=='1')
		{
		$sql="select cs_id,cs_desc as comp_desc from cs_mst";
		$query=$conn->prepare($sql);
		
		}
		
		if($rs=$query->execute())
		{
			$rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		} 
		
					
			$query->close();	
		
		$conn->close();
		
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_REQUEST['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['app_type_id']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ulb_wise_report.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>