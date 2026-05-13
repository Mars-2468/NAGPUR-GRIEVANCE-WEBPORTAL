<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
	    
	     $_SESSIOIN['uid'];
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();	
		
		if(isset($_POST['save']))
		{
                    		if(!empty($_POST['check_list'])) {
                        foreach($_POST['check_list'] as $cs_id) {
                                
                                $sql="update category3_mst set merg_cs_id=? where cs_id=?";
                                
                                 $merg_cs_id = $_POST['merg_cs_id'];
                                 $cs_id = $cs_id;
                        		 
                        		 $query = $conn->prepare($sql);
                        		 $query->bind_param("ii",$merg_cs_id,$cs_id);
                                
                                
                                $tpl->assign('msg','Services mapped successfully');
                        }
                    }
                    else
                    {
                        $tpl->assign('msg','Please check any checkbox');
                    }
        }
		
		
		$sql ="select cs_id,comp_desc,ulbid from category3_mst where merg_cs_id=?";
		
		         $merg_cs_id = 0;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$merg_cs_id);
		
		if($_SESSION['user_type']=='U')
		{
		    $sql ="select cs_id,comp_desc,ulbid from category3_mst where ulbid=? and merg_cs_id=?";
		    
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $merg_cs_id = 0;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$merg_cs_id);
		    
		}
		
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
		
		
		
		if($_SESSION['user_type']=='U')
		{
		    $sql ="select ulbid, ulbname from ulbmst where ulbid =?";
		    
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
		    
		    
		}
		
		$query->execute();
        $rs = $query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		}
		
		$tpl->assign('ulb_list',$ulb_list);
		$tpl->assign('ulb_services_list',$ulb_services_list);
		$tpl->assign('standard_service_list',$standard_service_list);
				
				
		$sql ="SELECT * FROM `ulb_online_application_map` where ulbid=?";
		
		         $ulbid = $_SESSION['ulbid'];
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
		
		
		$query->execute();
        $rs = $query->get_result();
	
		while($row = $rs->fetch_assoc())
		{
		    $online_applications['trade_application']=$row['trade_application'];
		    $online_applications['water_tap_application']=$row['water_tap_application'];
		}
		
		$sql ="SELECT * FROM `standard_departments`";
		$query = $conn->prepare($sql);
		$query->execute();
        $rs = $query->get_result();
		
		
		while($row = $rs->fetch_assoc())
		{
		    $standard_dept_list[$row['dept_id']]=$row['dept_desc'];
		}
		
		
		
		
		 $sql ="SELECT sp.dept_id FROM category3_mst c , standard_services s ,standard_departments sp where c.merg_cs_id = s.cs_id and 
		s.section_id = sp.dept_id and c.ulbid = ?";
		
		
		         $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
	
		while($row = $rs->fetch_assoc())
		{
		    $data['section_id'] = $row['section_id'];
		}
		
		
		
		
		
		
		$sql ="select COUNT(id) as user_count from login_details where type='1' and ulbid like ? ";
		
		
		
		         $ulbid = "%".$_SESSION['ulbid']."%";
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
	      $row = $rs->fetch_assoc();
	      $users_count=$row['user_count'];
	     $tpl->assign('users_count',$users_count);
	//	print_r($online_applications);
	$tpl->assign('user_type',$_SESSION['user_type']);
		
		$tpl->assign('standard_dept_list',$standard_dept_list);
		$tpl->assign('online_applications',$online_applications);
		$conn->close();			
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('data',$data);
		$tpl->assign('ward_list1',$ward_list1);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->display('services_mapped.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>