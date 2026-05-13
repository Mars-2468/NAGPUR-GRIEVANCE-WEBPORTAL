<?php
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	require_once('sms_conf.php');
	require_once('send_sms.php');	
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
	
		
			if(isset($_REQUEST['gid']))
			{
			$gid=$_REQUEST['gid'];
			}
			else
			{
			$gid=$_SESSION['gid'];
			}
			
			if($_REQUEST['aptid']=='1')
			{
			  $sql ="select c.cs_desc as comp_desc ,g.grievance_id as file_no,g.date_regd,DATE_ADD(date_regd, INTERVAL 1 DAY) AS cutt_of_time from cs_mst c, grievances g where c.cs_id=g.cat3_id and g.ulbid=? and g.grievance_id=?";
			  
			  
			     $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $gid = $gid;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$gid);
        		 
			}
			else
			{
	            
	              $sql ="select c.comp_desc ,c.fine_per_day,g.file_no,c.cutt_of_time,g.date_regd,g.cat3_id,g.app_type_id from category3_mst c, grievances g where c.cs_id=g.cat3_id and g.ulbid=? and g.grievance_id=?";
	              
			    
			     $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $gid = $gid;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("si",$ulbid,$gid);
			    
			    
			    
			}
	              
	              $query->execute();
        		 $rs = $query->get_result();
	           
	            $row=$rs->fetch_assoc();
	            $data2['comp_desc']=$row['comp_desc'];
	            $data2['fine_per_day']=$row['fine_per_day'];
	            $data2['ref_no']=$row['file_no'];
	            $data2['date']=date('d-m-Y',strtotime($row['date_regd']));
	            $data2['cutt_of_time']=$row['cutt_of_time'];
	            $data2['comp_desc_substr']=substr($row['comp_desc'],15);
	            
	        
	            
	            
	           
	            
	            $sql ="select u.ulbnametelugu ,u.pincode,ut.ulb_type_desctelugu,d.distnametelugu from ulbmst u , ulb_type ut,Districtmst d where u.distid=d.distid and u.ulb_type=ut.ulb_type_id and u.ulbid=?";
	            
	            
	             $ulbid = htmlspecialchars(strip_tags($_SESSION['ulbid']));
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("s",$ulbid);
        		 $query->execute();
        		 $rs = $query->get_result();
	            
	            
	            
	            
	            
	            
	            $row=$rs->fetch_assoc();
	            $ulb_det['ulbnametelugu']=$row['ulbnametelugu'];
	            $ulb_det['ulb_type_desctelugu']=$row['ulb_type_desctelugu'];
	            $ulb_det['distnametelugu']=$row['distnametelugu'];
	            $ulb_det['pincode']=$row['pincode'];
	            
	            
	            
		
		 $sql ="select * from grievances where grievance_id=?";
		
		         $gid = $gid;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$gid);
        		 $query->execute();
        		 $rs = $query->get_result();
		
		
		
	
		$data = $rs->fetch_assoc();
		
		
		if(strtotime($data['cutt_of_time']) < strtotime('today'))
			{
			$data['cutt_of_time']='';
			}
			else{
				$data['cutt_of_time']=date('d-m-Y',strtotime($data['cutt_of_time']));
			}
			
			if($_REQUEST['aptid']=='1')
			{
			$data['cutt_of_time']=date('d-m-Y',strtotime($data2['cutt_of_time']));
			$data2['cutt_of_time']=1;
			}
			

	        $conn->close();
        $tpl->assign('logo',$_SESSION['logo']); 
        $tpl->assign('ulb_det',$ulb_det); 
        $tpl->assign('data2',$data2);
		$tpl->assign('data',$data);
        $tpl->assign('service_sel',$_POST['service_id']);
        $tpl->assign('section_sel',$_POST['section_id']);
        $tpl->assign('subject_list',$subject_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('receive_print_boduppal.tpl');
	}
	else
	{
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                            
                            
                            
                            
                            
                            