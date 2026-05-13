<?php
require "config.php";
//include('responsible_sms.php');

	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	

	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('prepare_connection.php');
		
		
		
		/** counting total services **/
		
		$sql ="select count(cs_id) total_services,cs_type_id from category3_mst where ulbid=? group by cs_type_id";
		$ulbid = $_SESSION['ulbid'];
		$query=$conn->prepare($sql);
    			$query->bind_param("s",$ulbid);
    			if(!$query->execute())
    	        {
    	            echo "Query not executed 4";
    	        }
		
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		$map[$row['cs_type_id']]['total_services']=$row['total_services'];
		}
		
		$query->close();
		
		/** assigned services **/
		
		$sql ="select count(cs_id) total_services_mapped,cs_type_id from category3_mst where ulbid=? and cs_id IN(select cs_id from emp_map where ulbid=? and flag=? and cs_type_id=? group by cs_id) group by cs_type_id";
		$ulbid = $_SESSION['ulbid'];
		$flag = 1;
		$cs_type_id = 2;
		
		$query=$conn->prepare($sql);
		$query->bind_param("ssii",$ulbid,$ulbid,$flag,$cs_type_id);
		if(!$query->execute())
        {
            echo "Query not executed 5";
        }
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		$map[$row['cs_type_id']]['total_services_mapped']=$row['total_services_mapped'];
		}
		$query->close();
		
		/**/
		
		/** services not assigned **/
		$sql ="select count(cs_id) total_services_not_mapped,cs_type_id from category3_mst where ulbid=? and cs_id NOT IN(select cs_id from emp_map where ulbid=? and flag=? group by cs_id) group by cs_type_id";
		$query=$conn->prepare($sql);
		$query->bind_param("ssi",$ulbid,$ulbid,$flag);
		if(!$query->execute())
        {
            echo "Query not executed 6";
        }
		$rs=$query->get_result();
		while($row = $rs->fetch_assoc())
		{
		$map[$row['cs_type_id']]['total_services_not_mapped']=$row['total_services_not_mapped'];
		}
		$query->close();
		/**/
	
	      $sql ="select COUNT(id) as user_count from login_details where type=? and ulbid like ?"; 
	      $ulbid = "%".$_SESSION['ulbid']."%";
	      $type = 1;
	      $query=$conn->prepare($sql);
	      $query->bind_param("is",$type,$ulbid);
	      
		if(!$query->execute())
        {
            echo "Query not executed 7";
        }
    	$rs=$query->get_result();
	      
	     
	      $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	      $query->close();
	      
	      
	      
	      
	      
	      
	      
	      
	   $tpl->assign('users_count',$users_count);
	   
	    $tpl->assign('ulb',$_SESSION['ulbid']);
        $tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('feedback_count',$feedback_count);
		$tpl->assign('online_applications',$online_applications);
		$tpl->assign('tot_complaints',$tot_complaints);
		$tpl->assign('res_complaints',$res_complaints);
		$tpl->assign('res_services',$res_services);
		$tpl->assign('datalist',$datalist);
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('origin_rep',$origin_rep);
		$tpl->assign('origin_list',$origin_list);

		$tpl->assign('tanker_enable_status',$tanker_enable_status);
		$tpl->assign('map',$map);
		$tpl->assign('pic',$pic);
		$tpl->assign('data',$data);
		$tpl->assign('data1',$data1);
		
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ulbwiseStreetVendorsReport.tpl');
	}
	else
	{
	
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
	
	
?>
                            
                            
                            
                            
                            
                            