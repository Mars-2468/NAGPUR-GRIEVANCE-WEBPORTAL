<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		
		    if($_SESSION['user_type']=='U' && $_REQUEST['grievance_status_id']=='1' && $_REQUEST['aptid']=='1')
				
				{
				$sql="select * from grievances where ulbid=? and grievance_status_id=? and app_type_id=?";
				$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$status_id = 1;
				$app_type_id = htmlspecialchars(strip_tags($_REQUEST['aptid']));
				
				$query = $conn->prepare($sql);
		        $query->bind_param(sii,$ulbid,$status_id,$app_type_id);
				
				}else	
		    
		    if($_SESSION['user_type']=='U' && $_REQUEST['grievance_status_id']=='1' && $_REQUEST['aptid']=='2')
				
				{
				$sql="select g.*,c.* from grievances g,category3_mst c where g.ulbid=? and g.grievance_status_id=? and g.app_type_id=?";
				
				$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
				$status_id = 1;
				$app_type_id = htmlspecialchars(strip_tags($_REQUEST['aptid']));
				
				$query = $conn->prepare($sql);
		        $query->bind_param(sii,$ulbid,$status_id,$app_type_id);
				
				}
		
	
		
		
		if($query->execute())
		{
		    $rs=$query->get_result();
		    
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
				
				 if($_REQUEST['aptid']==1)
				{
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
				}
				else if($_REQUEST['aptid']==2)
				{
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
				}
			}
			
		}
		
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		$query = $conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		

		$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id !=?";
		$status_id = 5;
		$query = $conn->prepare($sql);
		$query->bind_param(i,$status_id);
		
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
		
			

		$sql="select dept_id,dept_desc from dept_mst";
		$query = $conn->prepare($sql);
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
			
					
		$tpl->assign('dept_list',$dept_list);
		
		
		
		
		
		 $sql="select cs_id,cs_desc as comp_desc from cs_mst";
		 $query = $conn->prepare($sql);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		
		$sql="select * from grievance_origin_mst where grievance_origin_id='".$_REQUEST['originid']."'";
		$grienvance_origin_id = htmlspecialchars(strip_tags($_REQUEST['originid']));
		$query = $conn->prepare($sql);
		
		$query->bind_param(i,$grienvance_origin_id);
		
		$query->execute();
		$rs=$query->get_result();
		while($row=$rs->fetch_assoc())
		{
		
		$origin_list[$row['grievance_origin_id']]=$row['grievance_origin_desc'];
		
		}	
				
					
		
		$query->close();
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('origin_list',$origin_list);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('pending_approval.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>