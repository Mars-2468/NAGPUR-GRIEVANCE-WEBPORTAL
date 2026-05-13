<?php
require "config.php";
	date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	ini_set('include_path',ini_get('include_path').':/home/vmaxsdmg/php');	
	require_once('Smarty.class.php');
	
	$tpl=new Smarty();
	 
	
	if(isset($_SESSION['uid']))
	{
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		$cat3_id=0; $app_type_id=1;
	    if($_REQUEST['status']==0 )
        	    {
        	        
                  $sql=$conn->prepare("select grievance_id,person_name,email,hno,address,ward_id,street_id,mobile,comp_desc from grievances  where app_type_id=? and ulbid=? and cat3_id !=?");
        	      $sql->bind_param("isi",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($cat3_id)));
        	      
        	      $query=$conn->prepare("select count(grievance_id) as num from grievances  where app_type_id=? and ulbid=? and cat3_id !=?");
        	      $query->bind_param("isi",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($_SESSION['ulbid'])),htmlspecialchars(strip_tags($cat3_id)));
	      
        	           
        	    }
        	    
        	    
        	    $query->execute();
        	    $result = $query->get_result();
        	   
        		
        		while($row=$result->fetch_assoc())
        		{
        	         $total_pages = $row['num'];
        	         
        		}
        	    
        	    
       
        	    
                 $sql->execute();
        	    $rs = $sql->get_result();
        	   
				 while($row = $rs->fetch_assoc())
				 {
				
				    $data[$row['dept_id']]['count']+=$row['count'];
					 $tot+=$row['count'];
					 
				}	
			
		$conn->close();
		
		$tpl->assign('pagination',$pagination);
	     $tpl->assign('ulbid_sel',$_REQUEST['ulbid']);
		$tpl->assign('apptypes',array('1'=>'Complaints','2'=>'Services'));
	    $tpl->assign('status_desc',array('0'=>'Total Received','2'=>'Completed Within SLA','3'=>'Completed Beyond SLA','4'=>'Pending Within SLA','5'=>'Pending Beyond SLA','6'=>'Financial Implication'));
	    $tpl->assign('app_type_id',$_REQUEST['app_type_id']);
	    $tpl->assign('status',$_REQUEST['status']);
	    $tpl->assign('ulb_list',$ulb_list);
	    $tpl->assign('ulb_list1',$ulb_list1);
		$tpl->assign('preg',$_POST['regionid']);
		$tpl->assign('pulb',$_POST['ulbid']);
		$tpl->assign('pdist',$_POST['distid']);
		$tpl->assign('region_list',$region_list);
		$tpl->assign('dist_list',$dist_list);
		$tpl->assign('dept_list',$dept_list);

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
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('services',$obj->services);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ulb_originwise.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>
                            
                            
                            
                            
                            
                            