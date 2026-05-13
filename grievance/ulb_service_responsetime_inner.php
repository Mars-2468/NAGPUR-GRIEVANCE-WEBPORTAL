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
		
		
		$grand_total_complaints=0;
		$grand_total_services=0;
		$grand_total_c_days=0;
		$grand_total_s_days=0;
		
		
		$sql="SELECT * FROM `standard_services`";
		$query=$conn->prepare($sql);
		$query->execute();
		$rs=$query->get_result();
		
		while($row = $rs->fetch_assoc())
		{
		    
		    $cat_list[$row['cs_id']]=$row['cs_desc'];
		    $timefrmaelist[$row['cs_id']]['timeframe']=$row['cutt_off_time'];
		    
		    
		    $count1='';$count2='';$days_from_hours='';
		 $total_hours='';$hours_from_minutes='';$total_minutes=''; $total_seconds='';$minutes_from_seconds='';
		 $s_hours_from_minutes='';
	      $s_total_hours='';$s_hours_from_minutes='';
	       $s_days_from_hours='';
	       $total_days_services='';
		 
		    
		
	       
	      
	       $sql3="SELECT count(grievance_id) as count FROM `grievances` g, category3_mst c WHERE  g.cat3_id=c.cs_id and `merg_cs_id`=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? )  and g.app_type_id=? and cat3_id !=? and g.ulbid=?";
	       
	       
	       
	       $merge_cs_id = $row['cs_id'];
	       $id3 = 3;
	       $id9 = 9;
	       $id8 = 8;
	       $id4 = 4;
	       $id6 = 6;
	       $id10 = 10;
	       $id12 = 12;
	       $app_type_id =2;
	       $cat3_id = 0;
	       $ulbid = htmlspecialchars(strip_tags($_REQUEST['ulbid']));
	       
	       $query3=$conn->prepare($sql3);
	       $query3->bind_param("iiiiiiiiiis",htmlspecialchars(strip_tags($merge_cs_id)),$id3,$id9,$id8,$id4,$id6,$id10,$id12,$app_type_id,$cat3_id,$ulbid);
		   $query3->execute();
		   $rs3=$query3->get_result();
	       
	       $row3= $rs3->fetch_assoc();
	       $count2=$row3['count'];
		   
		    $response_time[$row['cs_id']]['services']['count']=$count2;
		    $grand_total_services+=$count2;
	
		   
	       
	       $sql4="SELECT response_time FROM `grievances` g, category3_mst c WHERE  g.cat3_id=c.cs_id  and `merg_cs_id`=? and (grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? or grievance_status_id =? ) and app_type_id=? and cat3_id !=? and response_time !=? and g.ulbid=?";
	       
	       $merge_cs_id = htmlspecialchars(strip_tags($row['cs_id']));
	       $id3 = 3;
	       $id9 = 9;
	       $id8 = 8;
	       $id4 = 4;
	       $id6 = 6;
	       $id10 = 10;
	       $id12 = 12;
	       $response_time1='';
	       
	       
	       $query4=$conn->prepare($sql4);
	       $query4->bind_param("iiiiiiiiiiss",$merge_cs_id,$id3,$id9,$id8,$id4,$id6,$id10,$id12,$app_type_id,$cat3_id,$response_time1,$ulbid);
		   $query4->execute();
		   $rs4=$query4->get_result();
	       
	     
	     
	      $total_days_services=0;
	      $s_total_hours=0;
	      $s_total_minutes=0;
	       while($row4= $rs4->fetch_assoc())
	       {
	         
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
	       
	       $s_hours_from_minutes=$s_total_minutes/60;
	       $s_total_hours=$s_total_hours+$s_hours_from_minutes;
	       $s_days_from_hours=$s_total_hours/24;
	       $total_days_services=$total_days_services+$s_days_from_hours;
	       $grand_total_s_days+=$total_days_services;
	    
	          $total_servicess_avg_time=$total_days_services/$count2;  
	      
	      
	      
	       $response_time[$row['cs_id']]['services']['avg_res_time']=number_format($total_servicess_avg_time,2);
	  
		    
		}
		 
	     
	  
	    $grand_s_avg_res_time=number_format($grand_total_s_days/$grand_total_services,2);
	   
    
    	$conn->close();
	
		$tpl->assign('ulbid',$_REQUEST['ulbid']);
		$tpl->assign('grand_s_avg_res_time',$grand_s_avg_res_time);
	    $tpl->assign('grand_total_services',$grand_total_services);
	    $tpl->assign('timefrmaelist',$timefrmaelist);
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
		$tpl->display('ulb_service_responsetime_inner.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
		
	}
?>