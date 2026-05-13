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
		require_once('prepare_connection.php');
		
		
		$grand_total_complaints=0;
		$grand_total_services=0;
		$grand_total_c_days=0;
		$grand_total_s_days=0;
		
		$sql="SELECT * FROM `standard_services`";
		$query=$conn->prepare($sql);
		if(!$query->execute())
        {
            echo "Query not executed 1";
        }
        
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
		 
		    
		
	       
	       $sql3="SELECT count(grievance_id) as count FROM `grievances` g, standard_services c WHERE  g.mcat3_id=c.cs_id and g.mcat3_id = ? and (grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ?)  and g.app_type_id = ? and cat3_id != ? ";
		   
		   $cs_id=$row['cs_id'];
		   $grievance_status_id1='3';
		   $grievance_status_id2='9';
		   $grievance_status_id3='8';
		   $grievance_status_id4='4';
		   $grievance_status_id5='6';
		   $grievance_status_id6='10';
		   $grievance_status_id7='12';
		   $app_type_id='2';
		   $cat3_id='0';
		   
	       $query=$conn->prepare($sql3);
	       
	       $query->bind_param("iiiiiiiiii",$cs_id,$grievance_status_id1,$grievance_status_id2,$grievance_status_id3,$grievance_status_id4,$grievance_status_id5,$grievance_status_id6,$grievance_status_id7,$app_type_id,$cat3_id);
	       
	       if(!$query->execute())
            {
            echo "Query not executed 2";
            }
           $rs2=$query->get_result();
	       $row3= $rs2->fetch_assoc();
	       
	        
	       
	         $count2=$row3['count'];
		   
		    $response_time[$row['cs_id']]['services']['count']=$count2;
		    $grand_total_services+=$count2;
	
		     
		   
		 
	       
	       $sql4="SELECT response_time FROM `grievances` g, standard_services c WHERE  g.mcat3_id=c.cs_id  and g.mcat3_id= ? and (grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ? or grievance_status_id = ?)  and app_type_id= ? and cat3_id != ? and response_time!= ? ";
	       
	       $cs_id1=$row['cs_id'];
		   $grievance_status_id11='3';
		   $grievance_status_id21='9';
		   $grievance_status_id31='8';
		   $grievance_status_id41='4';
		   $grievance_status_id51='6';
		   $grievance_status_id61='10';
		   $grievance_status_id71='12';
		   $app_type_id1='2';
		   $cat3_id1='0';
	       $response_time1='';
	       
	       
	      
	       
	       $query=$conn->prepare($sql4);
	       
	       $query->bind_param("iiiiiiiiiii",$cs_id1,$grievance_status_id11,$grievance_status_id21,$grievance_status_id31,$grievance_status_id41,$grievance_status_id51,$grievance_status_id61,$grievance_status_id71,$app_type_id1,$cat3_id1,$response_time1);
	       
	       if(!$query->execute())
            {
            echo "Query not executed 3";
            }
           $rs3=$query->get_result();
	     
	       $total_days_services=0;
	       $s_total_hours=0;
	       $s_total_minutes=0;
	       
	       
	      
	       while($row4= $rs3->fetch_assoc())
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
	   
    
    	
	
		$query->close();
		
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
		$tpl->display('category_wise_services_response_time.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
	}
?>