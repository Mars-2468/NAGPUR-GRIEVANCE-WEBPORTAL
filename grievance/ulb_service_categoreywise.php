<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	date_default_timezone_set('Asia/Calcutta');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']) )
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		
		
		require_once('prepare_connection.php');
	    $sql="SELECT * FROM `ulbmst` order by ulbid asc";
		$query=$conn->prepare($sql);
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs = $query->get_result();
        
		while($row = $rs->fetch_assoc())
		{
		
		 $ulb_list['600']='Web Service Data';
		 $ulb_list[$row['ulbid']]=$row['ulbname'];
		 
		 
		}
		$sql ="SELECT * FROM `standard_services` ";
		$query=$conn->prepare($sql);
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs = $query->get_result();
		
	
		while($row = $rs->fetch_assoc())
		{
		    $service_list[$row['cs_id']]=$row['cs_desc'];
		}
		$recieved['received']=0;
		
		
		
		$sql ="select COUNT(grievance_id) as reveived,g.ulbid,g.mcat3_id as merg_cs_id from grievances g where  app_type_id=? and cat3_id !=? group by g.mcat3_id,g.ulbid ";
		$app_type_id = 2;
		$cat3_id = 0;
		$query=$conn->prepare($sql);
		$query->bind_param("ii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
		
		
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs = $query->get_result();
        
		while($row = $rs->fetch_assoc())
		{
		    $recieved[$row['ulbid']][$row['merg_cs_id']]['received']=$row['reveived'];
		    $recieved[$row['merg_cs_id']]['total']+=$row['reveived'];
		    $ulbcattotal[$row['ulbid']]['total']+=$row['reveived'];
		    $ulbcattotal['total']+=$row['reveived'];
		    $recieved[$row['ulbid']]['received']+=$row['reveived'];
		    $recieved['received']+=$row['reveived'];
		}
		
		
		// web service total received , resolved, pending 
		
		 $sql = "select SUM(total_applications) as received,SUM(approved+rejected) as resolved, SUM(under_rori_login+under_ae_me_login+beyond_15_days+under_comm_login+under_chairperson_login+under_progress ) as pending, cs_id from external_service_statistics group by cs_id" ;
		 $query=$conn->prepare($sql);
		 	if(!$query->execute())
            {
                echo "Query not executed 1";
            }
             $rs = $query->get_result();
		 
		
		while($row = $rs->fetch_assoc())
		{
		   $recieved['600'][$row['cs_id']]['received']=$row['received']; 
		   $resolved['600'][$row['cs_id']]['resolved']=$row['resolved']; 
		   $pending['600'][$row['cs_id']]['pending']=$row['pending'];
		   
		}
		
		// web service data service wise received
		
		$sql = "select SUM(total_applications) as received,SUM(approved+rejected) as resolved, SUM(under_rori_login+under_ae_me_login+beyond_15_days+under_comm_login+under_chairperson_login+under_progress ) as pending, cs_id from external_service_statistics" ;
		
		$query=$conn->prepare($sql);
		 	if(!$query->execute())
            {
                echo "Query not executed 1";
            }
             $rs = $query->get_result();
		 
		
		while($row = $rs->fetch_assoc())
		{
		
		   $recieved['600']['received']=$row['received']; 
		   $resolved['600']['resolved']=$row['resolved']; 
		   $pending['600']['pending']=$row['pending'];
		  
		}
		
		
		
		//$sql ="select COUNT(grievance_id) as resolved,g.ulbid,g.mcat3_id as merg_cs_id from grievances g where cat3_id !='0'  and app_type_id='2' and grievance_status_id IN ('3','8','9','12','4','6','10') group by g.mcat3_id,g.ulbid ";
		$sql ="select COUNT(grievance_id) as resolved,g.ulbid,g.mcat3_id as merg_cs_id from grievances g where cat3_id !=? and app_type_id=? and (grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? ) group by g.mcat3_id,g.ulbid ";
		$id3=3;
		$id8=8;
		$id9=9;
		$id12=12;
		$id4=4;
		$id6=6;
		$id10=10;
		$cat3_id = 0;
		$app_type_id = 2;
		
		
		$query=$conn->prepare($sql);
		$query->bind_param("iiiiiiiii",$cat3_id,$app_type_id,$id9,$id8,$id3,$id12,$id4,$id6,$id10);
		
		 	if(!$query->execute())
            {
                echo "Query not executed 1";
            }
             $rs = $query->get_result();
		 
		
		while($row = $rs->fetch_assoc())
		{
		    $resolved[$row['ulbid']][$row['merg_cs_id']]['resolved']=$row['resolved'];
		    $resolved[$row['merg_cs_id']]['total']+=$row['resolved'];
		    $resolved[$row['ulbid']]['resolved']+=$row['resolved'];
		    $resolved['resolved']+=$row['resolved'];
		}
		
	
		$sql ="select COUNT(grievance_id) as pending,g.ulbid,g.mcat3_id as merg_cs_id from grievances g where  cat3_id !=?  and app_type_id=? and (grievance_status_id =? or grievance_status_id =?) group by g.mcat3_id,g.ulbid ";
		
		$cat3_id = 0;
		$app_type_id = 2;
		$id1=1;
		$id2=2;
		
		
		$query=$conn->prepare($sql);
		$query->bind_param("iiii",$cat3_id,$app_type_id,$id1,$id2);
		
		 	if(!$query->execute())
            {
                echo "Query not executed 1";
            }
             $rs = $query->get_result();
		 
		
		while($row = $rs->fetch_assoc())
		{
		    $pending[$row['ulbid']][$row['merg_cs_id']]['pending']=$row['pending'];
		    $pending[$row['merg_cs_id']]['total']+=$row['pending'];
		    $pending[$row['ulbid']]['pending']+=$row['pending'];
		    $pending['pending']+=$row['pending'];
		}
		    
		    
		    
		    
		    
		 
    
	    $query->close();
	    $tpl->assign('ulbcattotal',$ulbcattotal);
	    $tpl->assign('pending',$pending);
	    $tpl->assign('resolved',$resolved);
	    $tpl->assign('recieved',$recieved);
	    $tpl->assign('service_list',$service_list);
		$tpl->assign('grand_total_complaints',$grand_total_complaints);
		$tpl->assign('grand_c_avg_res_time',$grand_c_avg_res_time);
	    $tpl->assign('current_category_name',$current_category_name);
		$tpl->assign('response_time',$response_time);			  		
        $tpl->assign('ulb_list',$ulb_list);		
        $tpl->assign('feedback_sub_options',$feedback_sub_options);		
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
	//	$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('cs_list',$cs_list);
		$tpl->assign('cat_list',$cat_list);
		$tpl->assign('data',$data);
		$tpl->assign('tot',$tot);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ulb_service_categoreywise.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>