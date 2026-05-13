<?php
    require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	

	
	if(isset($_SESSION['uid']))
	{
	    
	   
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		
		/// In case of service 
		
		$cs_id = $_REQUEST['cs_id'];
		
		
	
		
		
		
		$sql = "select * from grievances where cat3_id = '".$_REQUEST['cs_id']."' and ulbid like ? and http_code = ? " ;
		
		$ulbid = "%".$_SESSION['ulbid']."%";
		$http_code = 201;
		    $query=$conn->prepare($sql);
			$query->bind_param("si",$ulbid,$http_code);
		
		
	
		    
		     
		if($query->execute())
		{
		    $rs = $query->get_result();
			$field_info = $rs->fetch_fields();
			while($row = $rs->fetch_assoc())
			{
			
					foreach($field_info as $fi => $f) 
					$data[$row['grievance_id']][$f->name]=$row[$f->name];
			}
		
		}
		
		
		$tpl->assign('data',$data);



		$sql="select ward_id,ward_desc from ward_mst";
		$query=$conn->prepare($sql);
			
		if($query->execute())
		{$rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$ward_list[$row['ward_id']]=$row['ward_desc'];
		}
		
					
	

	$sql="select grievance_status_id,grievance_status_desc from grievance_status_mst where grievance_status_id !=?";
	
	    $grievance_status_id = 5;
	    
	    $query=$conn->prepare($sql);
		$query->bind_param("i",$grievance_status_id);
	    
		if($query->execute())
		{$rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$grievance_status_list[$row['grievance_status_id']]=$row['grievance_status_desc'];
		}
	
			
			$app_status_list=array('1'=>'Open complaint','3'=>'Assign to engineer','4'=>'Resolved','6'=>'Rejected');
			$tpl->assign('app_status_list',$app_status_list);
				
		
		$sql="select dept_id,dept_desc from dept_mst";
		$query=$conn->prepare($sql);
		if($query->execute())
		{
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		$tpl->assign('dept_list',$dept_list);
		
		
	
		
		 $sql="select c.*,cm.* from cs_mst c ,category_mst cm where  c.cat_id = cm.cat_id";
		 $query=$conn->prepare($sql);
		 
		if($query->execute())
		{
		    
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
			{
				$cm_list[$row['cat3_id']]=$row['description'];
			}
		}
		
		
		
			
					
		$tpl->assign('cm_list',$cm_list);
		
		
		 $sql="select * from cs_mst ";
		 $query=$conn->prepare($sql);
		 
		if($query->execute())
		{
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$com_list[$row['cs_id']]=$row['cs_desc'];
		}
		
	
					
		$tpl->assign('com_list',$com_list);
		
		
		
		
		
		
		$sql="select cs_id,comp_desc from category3_mst where ulbid=?";
		
		$ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		
		
		if($_REQUEST['aptid']=='1')
		{
		    $sql="select cs_id,cs_desc as comp_desc from cs_mst";
		    $query=$conn->prepare($sql);
		}
		
		
		if($query->execute())
		{
		    $rs = $query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['cs_id']]=$row['comp_desc'];
		}
		
			
			
		$sql ="select user_id,user_name from users where ulbid=?";	
		$query=$conn->prepare($sql);
		$query->bind_param("s",$ulbid);
		if($query->execute())
        {
            $rs = $query->get_result();
        		while($row = $rs->fetch_assoc())
        		$users_list[$row['user_id']]=$row['user_name'];
        }
        		
        	
        	
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('swapp_details.tpl');
	}
	else
	{
		
		
		
		//echo "<script>window.location='index.php';</script>";
		
		
	}
?>