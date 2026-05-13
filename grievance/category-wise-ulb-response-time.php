<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		$current_category_name='';$cat_id=0;
		if(isset($_REQUEST['cat_id']))
		{
		    
		$cat_id=$_REQUEST['cat_id'];
		$sql="SELECT * FROM `standard_services` where cs_id=".$cat_id;
		$rs=mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($rs);
		$current_category_name=$row['cs_desc'];
		
		}
		
		$sql ="SELECT * FROM `grievances` g, category3_mst c WHERE  g.cat3_id=c.cs_id and g.ulbid=".$_REQUEST['ulbid']." and grievance_status_id IN('3','9','8','4','6','10','12')  and g.app_type_id='2' and merg_cs_id=".$_REQUEST['cat_id'];
		if($rs=mysqli_query($conn,$sql))
        		{
        			$field_info = mysqli_fetch_fields($rs);
        			while($row = mysqli_fetch_assoc($rs))
        			{
        			
        				
                			
                				
                					foreach($field_info as $fi => $f) 
                					$data[$row['grievance_id']][$f->name]=$row[$f->name];
        					 
        			}
        		}
		
		
		
		/*$sql="SELECT * FROM `ulbmst` where ulbid='".$_REQUEST['ulbid']."'";
		$rs=mysqli_query($conn,$sql);
	
		$grand_total_services=0;
		$grand_total_s_days=0;
		$total_resolved=0;
		while($row = mysqli_fetch_assoc($rs))
		{
		    $count1='';$count2='';$days_from_hours='';
		 $total_hours='';$hours_from_minutes='';$total_minutes=''; $total_seconds='';$minutes_from_seconds='';
		 $s_hours_from_minutes='';
	      $s_total_hours='';$s_hours_from_minutes='';
	       $s_days_from_hours='';
	       $total_days_services='';
		 
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		    
		    	//$sql="SELECT count(grievance_id) as count FROM grievances WHERE `ulbid`=".$row['ulbid']." and `status_id`=9 and response_time!='' and merg_cs_id=".$cat_id;
		    	$sql="SELECT count(grievance_id) as count FROM `grievances` g, category3_mst c WHERE  g.cat3_id=c.cs_id and g.ulbid=".$row['ulbid']." and grievance_status_id IN('3','9','8','4','6','10','12')  and g.app_type_id='2' and merg_cs_id=".$cat_id;
		    //	echo $sql;
	        $rs2=mysqli_query($conn,$sql);
	       $row2= mysqli_fetch_assoc($rs2);
	       $count2=$row2['count'];
	      
		    $response_time[$row['ulbid']]['services']['count']=$count2;
		    $total_resolved+=$count2;
		   
		  
	       
	        //$sql4="SELECT response_time FROM grievances WHERE `ulbid`=".$row['ulbid']." and response_time!='' and status_id=9 and merg_cs_id=".$cat_id;
	        $sql4="SELECT response_time FROM `grievances` g, category3_mst c WHERE  g.cat3_id=c.cs_id  and g.ulbid=".$row['ulbid']." and grievance_status_id IN('3','9','8','4','6','10','12')  and app_type_id='2'  and response_time!='' and merg_cs_id=".$cat_id;
		   // echo $sql4;exit;
	        $rs4=mysqli_query($conn,$sql4);
	      //  $total_days=0;
	       while($row4= mysqli_fetch_assoc($rs4))
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
	       $grand_total_s_days+= $total_days_services;
	       $total_servicess_avg_time=$total_days_services/$count2;
	       if($row['ulbid']!=211)
	       {
	       $response_time[$row['ulbid']]['services']['avg_res_time']=number_format($total_servicess_avg_time,2);
	       }
	       
		    
		}
	
	        $sql6="SELECT count(grievance_id) as total_services_count FROM `services_map_info` WHERE response_time!='' 
	        and status_id=9 and merg_cs_id=".$cat_id;
		    //	echo $sql6;
	        $rs6=mysqli_query($conn,$sql6);
	       $row6= mysqli_fetch_assoc($rs6);
	       $grand_total_services=$row6['total_services_count'];
	      
	       
	       
	       
	  
	    $grand_s_avg_res_time=number_format($grand_total_s_days/$total_resolved,2);
	   
    
    	$response_time['grand_total_services']=$grand_total_services;
    
    	$response_time['grand_s_avg_res_time']=$grand_s_avg_res_time;*/
    	
    	
    	$sql ="select * from category3_mst";
    	$rs = mysqli_query($conn,$sql);
    	while($row = mysqli_fetch_assoc($rs))
    	{
    	    $cs_list[$row['cs_id']] = $row['comp_desc'];
    	}
    	$sql ="SELECT * FROM `grievance_status_mst`";
    	$rs = mysqli_query($conn,$sql);
    	while($row = mysqli_fetch_assoc($rs))
    	{
    	    $grievance_status_list[$row['grievance_status_id']] = $row['grievance_status_desc'];
    	}
	mysqli_close($conn);
	$tpl->assign('cs_list',$cs_list);
	$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('grand_s_avg_res_time',$grand_s_avg_res_time);
		$tpl->assign('total_resolved',$total_resolved);
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
		$tpl->display('showall.tpl');
	}
	else
	{
		$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');
	}
?>