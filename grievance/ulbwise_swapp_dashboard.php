<?php
require "config.php";
    date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	
	if(isset($_SESSION['uid']))
	{
	    
	    
	    //session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('prepare_connection.php'); 
		

		
			

	
		
		
		if($_SESSION['user_type'] == 'A')
		{
		    
		    if(isset($_POST['search']))
		    {
		        $fromdate=date('Y-m-d',strtotime($_POST['fromDate']));
		        $todate=date('Y-m-d',strtotime($_POST['toDate']));
		        
		        $tpl->assign('fromdate',date('d-m-Y',strtotime($_POST['fromDate'])));
		        $tpl->assign('todate',date('d-m-Y',strtotime($_POST['toDate'])));
		        
		        $sql.=" and date_regd between '".$fromdate."' and '".$todate."'";
		    }
		    
		    $sql = "select count(c.cs_id) as count,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = 1";
		     
		      if(isset($_POST['search']))
		    {
		        $fromdate=date('Y-m-d',strtotime($_POST['fromDate']));
		        $todate=date('Y-m-d',strtotime($_POST['toDate']));
		        $sql.=" and date_regd >= '".$fromdate."' and date_regd <= '".$todate."'";
		    }
		     
		     $sql.=' group by ulbid ';
		     
		     
		     $rs=mysqli_query($conn,$sql);
		     while($row=mysqli_fetch_assoc($rs))
		     {
		         $received_ulb[$row['ulbid']]['count']=$row['count'];
		         $received_ulbtotal+=$row['count'];
		     }
		     
		     $sql2 = "select count(c.cs_id) as count,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = 1 and g.http_code= 201  ";
		     
		      if(isset($_POST['search']))
		    {
		        $fromdate=date('Y-m-d',strtotime($_POST['fromDate']));
		        $todate=date('Y-m-d',strtotime($_POST['toDate']));
		        $sql2.=" and date_regd >= '".$fromdate."' and date_regd <= '".$todate."'";
		    }
		    
		    $sql2.=' group by ulbid ';
		     
		     $rs=mysqli_query($conn,$sql2);
		     while($row=mysqli_fetch_assoc($rs))
		     {
		         $received[$row['ulbid']]['count']=$row['count'];
		         $tot1+=$row['count'];
		     }
		     
		     $sql3="select count(c.cs_id) as count,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = 1 and g.http_code= 201 and (swatchta_app_status= 0 or swatchta_app_status= 1 or swatchta_app_status= 3)";
		     
		     if(isset($_POST['search']))
		    {
		        $fromdate=date('Y-m-d',strtotime($_POST['fromDate']));
		        $todate=date('Y-m-d',strtotime($_POST['toDate']));
		        $sql3.=" and date_regd >= '".$fromdate."' and date_regd <= '".$todate."'";
		    }
		    $sql3.=' group by ulbid ';
		     
		     $rs=mysqli_query($conn,$sql3);
		     while($row=mysqli_fetch_assoc($rs))
		     {
		         $pending[$row['ulbid']]['count']=$row['count'];
		         $tot2+=$row['count'];
		     }
		     
		     $sql4 = "select count(c.cs_id) as count,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = 1 and g.http_code=201 and swatchta_app_status = 4 ";
		     if(isset($_POST['search']))
		    {
		        $fromdate=date('Y-m-d',strtotime($_POST['fromDate']));
		        $todate=date('Y-m-d',strtotime($_POST['toDate']));
		        $sql4.=" and date_regd >= '".$fromdate."' and date_regd <= '".$todate."'";
		    }
		    $sql4.=' group by ulbid ';
		     $rs=mysqli_query($conn,$sql4);
		     while($row=mysqli_fetch_assoc($rs))
		     {
		         $resolved[$row['ulbid']]['count']=$row['count'];
		         $tot3+=$row['count'];;
		     }
		     
		      $sql5 = "select count(c.cs_id) as count,ulbid from cs_mst c , grievances g where c.cs_id = g.cat3_id and 
		     c.swatchta_app_status_yn = 1 and g.http_code=201 and swatchta_app_status = 6 ";
		     if(isset($_POST['search']))
		    {
		        $fromdate=date('Y-m-d',strtotime($_POST['fromDate']));
		        $todate=date('Y-m-d',strtotime($_POST['toDate']));
		        $sql5.=" and date_regd >= '".$fromdate."' and date_regd <= '".$todate."'";
		    }
		    $sql5.=' group by ulbid ';
		     
		      $rs=mysqli_query($conn,$sql5);
		     while($row=mysqli_fetch_assoc($rs))
		     {
		         $rejected[$row['ulbid']]['count']=$row['count'];
		         $tot4+=$row['count'];
		     }
		     
		     
		    
		}
		
		
		
		
		
		
	
           
	
		
		
	
	    
	
	
		
		
		
		
		
		
	
		
		
		
		     
		     
		                      
		
		 $sql = "select * from ulbmst " ;
		 
		 $swatchta_app_status_yn='1';
		 $query=$conn->prepare($sql);
		 //$query->bind_param("i",$swatchta_app_status_yn);
		
		if($query->execute())
		{
		    $rs=$query->get_result();
			while($row = $rs->fetch_assoc())
				$cs_list[$row['ulbid']]=$row['ulbname'];
				
		}
	
			
		
	      
	      $row = $rs->fetch_assoc();
	      
	      $users_count=$row['user_count'];
	       $tpl->assign('users_count',$users_count);
    
		$tpl->assign('received_ulbtotal',$received_ulbtotal);
		$tpl->assign('received_ulb',$received_ulb);
		$tpl->assign('sec_level',$_SESSION['sec_level']);			
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('update_code',$update_code);
		$tpl->assign('code',$_REQUEST['code']);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('cs_type_id',$_REQUEST['cs_type_id']);
		$tpl->assign('cs_list',$cs_list);	
		$tpl->assign('received',$received);
		$tpl->assign('resolved',$resolved);
		$tpl->assign('tot1',$tot1);
		$tpl->assign('tot2',$tot2);
		$tpl->assign('tot3',$tot3);
		$tpl->assign('tot4',$tot4);
		$tpl->assign('rejected',$rejected);
		$tpl->assign('pending',$pending);
		$tpl->assign('ward_list',$ward_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('ulbwise_swapp_dashboard.tpl');
	}
	else
	{
		
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>