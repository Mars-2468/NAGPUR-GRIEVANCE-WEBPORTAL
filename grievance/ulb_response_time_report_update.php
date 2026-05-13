<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
		
		$sql = $conn->prepare("SELECT * FROM `feedback_sub_options`");
		
		$sql->execute();
		$rs = $sql->get_result();
		while($row = $rs->fetch_assoc())
		{
		    $feedback_sub_options[$row['sub_option_id']]=$row['description'];
		}
		
		$sql =$conn->prepare("SELECT * FROM `ulbmst`");
		$sql->execute();
		$rs = $sql->get_result();
		
		$grand_total_complaints=0;
		$grand_total_services=0;
		$grand_total_c_days=0;
		$grand_total_s_days=0;
		while($row = $rs->fetch_assoc())
		{
		    $count1='';$count2='';$days_from_hours='';
		 $total_hours='';$hours_from_minutes='';$total_minutes=''; $total_seconds='';$minutes_from_seconds='';
		 $s_hours_from_minutes='';
	      $s_total_hours='';$s_hours_from_minutes='';
	       $s_days_from_hours='';
	       $total_days_services='';
		 
		    $ulb_list[$row['ulbid']]=$row['ulbname']; 
		    
		    $app_type_id_1 = 1; $cat3_id =0;
		     $in1 = 8; $in2 = 9;	$in3 = 3;
		    
		        $ulbid = htmlspecialchars(strip_tags($row['ulbid']));
		        
		      $sql=$conn->prepare("SELECT count(grievance_id) as count FROM `grievances` WHERE `ulbid`=? and  (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and app_type_id= ? and cat3_id!=?");
		      $sql->bind_param("siiiii",$ulbid,$in1,$in2,$in3,$app_type_id_1,$cat3_id);     
		      
	       
	       $sql->execute();
	       $rs2=$sql->get_result();
	       $row2= $rs2->fetch_assoc();
	       
	       $count1=$row2['count'];
	       $app_type_id_2=2;
	       $ulbid = $row['ulbid'];
	       $sql3=$conn->prepare("SELECT count(grievance_id) as count FROM `grievances` WHERE `ulbid`= ? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and app_type_id= ? and cat3_id!=?");
		   
		   $sql3->bind_param("siiiii",htmlspecialchars(strip_tags($row['ulbid'])),$in1,$in2,$in3,$app_type_id_2,$cat3_id);    
	      
		    $sql3->execute();
		    $rs3 = $sql3->get_result();
		    $row3= $rs3->fetch_assoc();
	       
	       $count2=$row3['count'];
		    $response_time[$row['ulbid']]['complaints']['count']=$count1;
		    $grand_total_complaints+=$count1;
		    
		    
		     if($row['ulbid']!=211)
	       {
		    $response_time[$row['ulbid']]['services']['count']=$count2;
	       }
		     $grand_total_services+=$count2;
		    if($row['ulbid']==211)
	       {
	           
	        $response_time[$row['ulbid']]['services']['count']='--';	      
	         }
	          $in6 = 6; $in2 = 9;	$in4 = 4;
	           $ulbid = $row['ulbid'];
		     $sql3 = $conn->prepare("SELECT response_time FROM `grievances` WHERE `ulbid`=? and response_time!='' and  (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and app_type_id= ? and cat3_id!=?");
		     
		     $sql3->bind_param("siiiii",$ulbid,$in6,$in2,$in4,$app_type_id_1,$cat3_id);
		    
		    $sql3->execute();
		    $rs3 = $sql3->get_result();
		    
		    
	        $total_days=0;
	       while($row3= $rs3->fetch_assoc())
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
	       $minutes_from_seconds=floor($total_seconds/60);
	       $total_minutes=$total_minutes+$minutes_from_seconds;
	       $hours_from_minutes=floor($total_minutes/60);
	       $total_hours=$total_hours+$hours_from_minutes;
	       $days_from_hours=floor($total_hours/24);
	       $total_days=$total_days+$days_from_hours;
	       $grand_total_c_days+=$total_days;
	      
	       $total_complaints_avg_time=$total_days/$count1;
	       $response_time[$row['ulbid']]['complaints']['avg_res_time']=round($total_complaints_avg_time,2);
	       
	       $ulbid = $row['ulbid'];
	       $sql4 = $conn->prepare("SELECT response_time FROM `grievances` WHERE `ulbid`=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?)  and app_type_id= ? and cat3_id!=?");
		   $sql4->bind_param("siiiii",$ulbid,$in6,$in2,$in4,$app_type_id_2,$cat3_id);
		    
		    $sql4->execute();
		    $rs4 = $sql4->get_result();
	       
	       while($row4= $rs4->fetch_assoc())
	       {
	            if($row4['ulbid']!=211)
	       {
	           
	       }
	           $current_services_response_time=$row4['response_time'];
	           $temp1=explode(":",$current_services_response_time);
	           if($temp1[0]>0)
	           {
	               $total_days_services+=$temp1[0];
	               
	           }
	           
	            if($temp1[1]>0)
	           {
	               $s_total_hours+=$temp1[1];
	           }
	           if($temp1[2]>0)
	           {
	               $s_total_minutes+=$temp1[2];
	           }
	           
	       }
	       
	       $s_hours_from_minutes=floor($s_total_minutes/60);
	       $s_total_hours=$s_total_hours+$s_hours_from_minutes;
	       $s_days_from_hours=floor($s_total_hours/24);
	       $total_days_services=$total_days_services+$s_days_from_hours;
	       $grand_total_s_days+=$total_days_services;
	       $total_servicess_avg_time=$total_days_services/$count2;
	       if($row['ulbid']!=211)
	       {
	       $response_time[$row['ulbid']]['services']['avg_res_time']=round($total_servicess_avg_time,2);
	       }
	       if($row['ulbid']==211)
	       {
	           
	         $response_time[$row['ulbid']]['services']['avg_res_time']='--';	      
	         }
		    
		}
		 $grievance_status_id_6 =6;$app_type_id_1=1;
	     $app_type_id_2 =2; $cat3_id =0;
	     $grievance_status_id_9=9;
	     $grievance_status_id_4=4;
		   
		    
		$sql5 = $conn->prepare("SELECT count(grievance_id) as total_service_count FROM `grievances` where app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and cat3_id!=? ");
		$sql5->bind_param("iiiii",$app_type_id_2,$grievance_status_id_9,$grievance_status_id_4,$grievance_status_id_6,$cat3_id);
		    
		     $sql5->execute();
		     $rs5 = $sql5->get_result();
		     $row5= $rs5->fetch_assoc();
	
	    $sql6 =$conn->prepare("SELECT count(grievance_id) as total_complaints_count FROM `grievances` where app_type_id=? and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?)  and cat3_id!=?");
	    $sql6->bind_param("iiiii",$app_type_id_1,$grievance_status_id_9,$grievance_status_id_4,$grievance_status_id_6,$cat3_id);    
        		$sql6->execute();
        		$rs6 = $sql6->get_result();
        		$row6= $rs6->fetch_assoc();
		    
	  
	   $grand_c_avg_res_time=round($grand_total_c_days/$grand_total_complaints,2);
	    $grand_s_avg_res_time=round($grand_total_s_days/$grand_total_services,2);
	  
    	$response_time['grand_total_complaints']=$grand_total_complaints;
    	$response_time['grand_total_services']=$grand_total_services;
    	$response_time['grand_c_avg_res_time']=$grand_c_avg_res_time;
    	$response_time['grand_s_avg_res_time']=$grand_s_avg_res_time;
	
		
		
	   
	    $sql6->close();
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
		$tpl->display('ulb_response_time_report.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>