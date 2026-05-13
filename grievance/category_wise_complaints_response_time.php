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
		include('prepare_connection.php');
		
	
		
		$sql="SELECT * FROM `cs_mst`";
		$query=$conn->prepare($sql);
		$query->execute();
        $rs = $query->get_result();
       
		
		
		$grand_total_complaints=0;
		$grand_total_services=0;
		$grand_total_c_days=0;
		$grand_total_s_days=0;
		while($row = $rs->fetch_assoc())
		{
		    
		    
		    
		    $cat_list[$row['cs_id']]=$row['cs_desc'];
		    
		    
		    $count1='';$count2='';$days_from_hours='';
		 $total_hours='';$hours_from_minutes='';$total_minutes=''; $total_seconds='';$minutes_from_seconds='';
		 $s_hours_from_minutes='';
	      $s_total_hours='';$s_hours_from_minutes='';
	       $s_days_from_hours='';
	       $total_days_services='';
		 
		    
		    // getting total resolved complaints
		    
	            
	            	$sql="SELECT count(grievance_id) as count FROM complaints_map_info WHERE cat3_id=? and
		    	(status_id=?  or status_id=? or status_id=? or status_id=?)";
		    	$query = $conn->prepare($sql);
		    	$cat3_id=$row['cs_id'];
		    	$status_id_9=9;
		    	$status_id_4=4;
		    	$status_id_6=6;
		    	$status_id_12=12;
	            $query->bind_param("iiiii",$cat3_id,$status_id_9,$status_id_4,$status_id_6,$status_id_12);
	            $query->execute();
	            $rs2 =$query->get_result();
	            $row2= $rs2->fetch_assoc();
	            $count1=$row2['count'];
	            $response_time[$row['cs_id']]['complaints']['count']=$count1;
		        $grand_total_complaints+=$count1;
		     
		   
		     
		     $sql3="SELECT response_time FROM complaints_map_info WHERE cat3_id=? and 
		     response_time!=? and (status_id=?  or status_id=? or status_id=? or status_id=?)";
		     $query = $conn->prepare($sql3);
		    	$cat3_id=$row['cs_id'];
		    	$response_time1='';
		    	$status_id_9=9;
		    	$status_id_4=4;
		    	$status_id_6=6;
		    	$status_id_12=12;
	            $query->bind_param("isiiii",$cat3_id,$response_time1,$status_id_9,$status_id_4,$status_id_6,$status_id_12);
		        $query->execute();
	            $rs3 =$query->get_result();
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
	        if($count1>0){
	            $total_complaints_avg_time=$total_days/$count1;
	        }
	       
	       $response_time[$row['cs_id']]['complaints']['avg_res_time']=round($total_complaints_avg_time,2);
		}
		 
	       
	        
	       
	       
	       
	   $grand_c_avg_res_time=round($grand_total_c_days/$grand_total_complaints,2);
	   
    	$conn->close();
		$tpl->assign('grand_c_avg_res_time',$grand_c_avg_res_time);
	    $tpl->assign('grand_total_complaints',$grand_total_complaints);
		$tpl->assign('response_time',$response_time);			  		
        $tpl->assign('cat_list',$cat_list);		
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
		$tpl->display('category_wise_complaints_response_time.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>