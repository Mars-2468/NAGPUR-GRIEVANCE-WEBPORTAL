<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
	    
	    echo $_SESSIOIN['uid'];
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		
		if(isset($_POST['save']))
		{
                    		if(!empty($_POST['check_list'])) {
                        foreach($_POST['check_list'] as $cs_id) {
                                
                                $sql="update category3_mst set disable_status_yn = ? where cs_id=?";
                                
                                
                                 $disable_status_yn = 1;
                        		 $cs_id = $cs_id;
                        		 $query = $conn->prepare($sql);
                        		 $query->bind_param("si",$ulbid,$cs_id);
                        		 $query->execute();
                        		 
                                
                                $tpl->assign('msg','Services Disabled successfully');
                        }
                    }
                    else
                    {
                        $tpl->assign('msg','Please check any checkbox');
                    }
        }
		
		
		$sql ="select cs_id,comp_desc,ulbid from category3_mst where disable_status_yn NOT IN ('1')";
		
		   
                        		 $query = $conn->prepare($sql);
                        		 $query->execute();
                        		 $rs = $query->get_result();
		 
	  
		while($row = $rs->fetch_assoc())
		{
		    $ulb_services_list[$row['ulbid']][$row['cs_id']]=$row['comp_desc'];
		}
		
		$sql="select * from  standard_services";
		
		                         $query = $conn->prepare($sql);
                        		 $query->execute();
                        		 $rs = $query->get_result();
		
		
		
		
		 
		while($row = $rs->fetch_assoc())
		{
		    $standard_service_list[$row['cs_id']]=$row['cs_desc'];
		}
		
		$sql ="select ulbid, ulbname from ulbmst where ulbid NOT IN('500')";
		
		   $query = $conn->prepare($sql);
           $query->execute();
           $rs = $query->get_result();
		
		
		
		
	 
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		}
		
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('ulb_services_list',$ulb_services_list);
		$tpl->assign('standard_service_list',$standard_service_list);
				
				
	    $sql ="SELECT * FROM `ulb_online_application_map` where ulbid= ? ";
	    
	             $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
	    
		 
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like ? "; 
		
		
		         $ulbid = "%".$_SESSION['ulbid']."%";
        		 $type = 1;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$type);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
	      
	      $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);

	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('online_applications',$online_applications);
				$conn->close();	
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('services_disable.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>