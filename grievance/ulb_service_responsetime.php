<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']) )
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
	
		require_once('prepare_connection.php');
	
		$current_category_name='';$cat_id=0;
		if(isset($_REQUEST['cat_id']))
		{
		    
		$cat_id=$_REQUEST['cat_id'];
		
		$sql="SELECT * FROM `cs_mst` where cs_id=".$cat_id;
		$cs_id = htmlspecialchars(strip_tags($cat_id));
		$query=$conn->prepare($sql);
		$query->bind_param("i",$cs_id);
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        $rs = $query->get_result();
        $row =$rs->fetch_assoc();
		$current_category_name=$row['cs_desc'];
		}
		
		
		 $sql="SELECT count(grievance_id) as count,ulbid FROM `grievances` WHERE  (grievance_status_id =? OR grievance_status_id =? OR grievance_status_id =? OR grievance_status_id =? OR grievance_status_id =? or grievance_status_id =? or grievance_status_id =? ) and cat3_id !=? and app_type_id=? group by ulbid";
		 
		 $app_type_id = 2;
		 $id1=3;
		 $id2=9;
		 $id3=8;
		 $id4=0;
		 $id5=6;
		 $id6=10;
		 $id7=12;
		 $cat3_id = 0;
		 
		 $query=$conn->prepare($sql);
		$query->bind_param("iiiiiiiii",$id1,$id2,$id3,$id4,$id5,$id6,$id7,$cat3_id,$app_type_id);
	
		 
		 
		
			if(!$query->execute())
            {
                echo "Query not executed 4";
            }
			$rs = $query->get_result();
			
			
		   
		 while($row = $rs->fetch_assoc())
    		{
    		    $ulbtotalcomplaints[$row['ulbid']]['complaints']['count']=$row['count'];
    		    $grand_total_complaints+=$row['count'];
    		}
    		
    		$tpl->assign('ulbtotalcomplaints',$ulbtotalcomplaints);
		
		
		$sql="SELECT * FROM `ulbmst`";
		$query=$conn->prepare($sql);
			if(!$query->execute())
            {
                echo "Query not executed 5";
            }
			$rs = $query->get_result();
		
		
	
		$grand_total_services=0;
		$grand_total_c_days=0;
		$grand_total_s_days=0;
		
		while($row = $rs->fetch_assoc())
		{
		 $count1='';$count2='';$days_from_hours='';
		 $total_hours='';$hours_from_minutes='';$total_minutes='';
		 $total_seconds='';$minutes_from_seconds='';
		 $s_hours_from_minutes='';
	     $s_total_hours='';$s_hours_from_minutes='';
	     $s_days_from_hours='';
	     $total_days_services='';
		 
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		    
		    
		    $sql3="SELECT response_time FROM `grievances` WHERE `ulbid`=? and response_time!=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =?) and cat3_id !=? and app_type_id=? ";
		    
		    $query=$conn->prepare($sql3);
		    $ulbid2 = htmlspecialchars(strip_tags($row['ulbid']));
		    $response_time1='';
		    $id3=3;
		    $id9=9;
		    $id8=8;
		    $id4=4;
		    $id6=6;
		    $id10=10;
		    $id12=12;
		    $cat3_id=0;
		    $app_type_id = 2;
		    
		    
		    $query->bind_param("ssiiiiiiiii",$ulbid2,$response_time1,$id3,$id9,$id8,$id4,$id6,$id10,$id12,$cat3_id,$app_type_id);
		    
		    if(!$query->execute())
            {
                echo "Query not executed 5";
            }
			$rs2 = $query->get_result();
	        $total_days=0;
	       while($row3= $rs2->fetch_assoc())
	       {
	          
	           $current_response_time=$row3['response_time'];
	           $temp=explode(":",$current_response_time);
	           if($temp[0]>0)
	           {
	               $total_days+=$temp[0];
	               
	           }
	         if($temp[1]>0)
	           {
	               $total_hours+=$temp[1];
	           }
	           if($temp[2]>0)
	           {
	               $total_minutes+=$temp[2];
	           }
	           if($temp[3]>0)
	           {
	               $total_seconds+=$temp[3];
	           }
	       }
	       $minutes_from_seconds=$total_seconds/60;
	       $total_minutes=$total_minutes+$minutes_from_seconds;
	       $hours_from_minutes=$total_minutes/60;
	       $total_hours=$total_hours+$hours_from_minutes;
	       $days_from_hours=$total_hours/24;
	       $total_days=$total_days+$days_from_hours;
	       $response_time[$row['ulbid']]['complaints']['count']=$total_days;
	       $grand_total_c_days+=$total_days;
	       
	       if ($row['ulbid']!=214)
	       {
	          
	           
	           $total_complaints_avg_time=$total_days/$ulbtotalcomplaints[$row['ulbid']]['complaints']['count'];
	           $response_time[$row['ulbid']]['complaints']['avg_res_time']=number_format($total_complaints_avg_time,2);
	       }
	      
	      
	       
		}
		
		
		$grand_c_avg_res_time=round($grand_total_c_days/$grand_total_complaints,2);
		 
    
	    $query->close();
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
		$tpl->display('ulb_service_responsetime.tpl');
	}
	else
	{
	
		
		echo "<script>window.location='index,php';</script>";
		
		
	}
?>