<?php
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();
	session_start();
	if(isset($_SESSION['uid']))
	{
	    
	    
	    session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('connection.php');
		$conn=getconnection();
		
	$sql1="select g.* from grievances g,ulbmst u,Districtmst d,rdma_mst r,cs_mst c where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and 
	u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like '%".$_REQUEST['ulbid']."%' and d.distid like '%".$_REQUEST['distid']."%' and 
	r.rdma_id like '%".$_REQUEST['regionid']."%' and  app_type_id='1' and u.ulbid!='500'";
	
	$sql2="select g.* from grievances g,ulbmst u,Districtmst d,rdma_mst r,category3_mst c where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and 
	u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like '%".$_REQUEST['ulbid']."%' and d.distid like '%".$_REQUEST['distid']."%' and 
	r.rdma_id like '%".$_REQUEST['regionid']."%' and  app_type_id='2' and u.ulbid!='500'";
	
	if($_SESSION['user_type']=='R')
	{
	     $sql1="select g.* from grievances g,ulbmst u,Districtmst d,rdma_mst r,cs_mst c where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like '%".$_REQUEST['ulbid']."%' and d.distid like '%".$_REQUEST['distid']."%' and d.rdma like '%".$_SESSSION['uid']."%' and  app_type_id='1'";
	
	$sql2="select g.* from grievances g,ulbmst u,Districtmst d,rdma_mst r,category3_mst c where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like '%".$_REQUEST['ulbid']."%' and d.distid like '%".$_REQUEST['distid']."%' and r.rdma_id like '%".$_SESSSION['uid']."%' and  app_type_id='2'";
	}
	
	
		
	if(isset($_REQUEST['days_3']))
	{
	    $sql1.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) ";
	    $sql2.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) ";
	    
	}
	else if(isset($_REQUEST['days_7']))
	{
	    $sql1.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ";
	    $sql2.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ";
	}
	else if(isset($_REQUEST['days_30']))
	{
	    $sql1.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -1 MONTH) ";
	    $sql2.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -1 MONTH) ";
	}
		else if(isset($_REQUEST['days_60']))
	{
	    $sql1.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -2 MONTH) ";
	    $sql2.=" and date_regd >= DATE_ADD(CURDATE(), INTERVAL -2 MONTH) ";
	}
	
	
		   $sql1.=" ORDER BY date_regd , u.ulbname";
		   $sql2.=" ORDER BY date_regd , u.ulbname";

	 
	
		
		$rs = mysqli_query($conn,$sql1);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $complaints[$row['ulbid']]['received']+=1;
		    //$data['comp_tot_received']+=1;
		    if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='8' || $row['grievance_status_id']=='10' || $row['grievance_status_id']=='4' || $row['grievance_status_id']=='6' || $row['grievance_status_id']=='9')
		    {
		        $complaints[$row['ulbid']]['resolved']+=1;
		        $total_r+=1;
		        
		        
		         $sql3="select g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status,ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('3','8','10','4','6','9')  and gt.disposal_status !=5 and g.grievance_id='".$row['grievance_id']."' and g.app_type_id='1'";
		        $rs3= mysqli_query($conn,$sql3);
		        while($row3= mysqli_fetch_assoc($rs3))
		        {
		            if($row3['target'] <= $row3['target_days'])
		            {
		                $comp_resolved[$row['ulbid']]['withinsla']+=1;
		                //$data['comp_redressed_withinsla']+=1;
		            }
		            else
		            {
		                $comp_resolved[$row['ulbid']]['beyondinsla']+=1;
		                //$data['comp_redressed_beyondinsla']+=1;
		            }
		        }
		    }
		    else
		    {
		        
		        $complaints[$row['ulbid']]['pending']+=1;
		        
		         $sql3="select g.ulbid,g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(NOW(),date_regd) AS target,gt.disposal_status,ccm.cutt_off_time as target_days from grievances g , grievances_transactions gt,comp_cutofdays_map ccm where g.grievance_id=gt.grievance_id and g.cat3_id=ccm.cs_id and g.grievance_status_id IN('2','1','13')  and gt.disposal_status !=5 and g.grievance_id='".$row['grievance_id']."' and g.app_type_id='1'";
		        
		        $rs3= mysqli_query($conn,$sql3);
		        $nr= mysqli_num_rows($rs3);
		        if($nr > 0)
		        {
            		        while($row3= mysqli_fetch_assoc($rs3))
            		        {
            		            
            		            if($row3['target'] <= $row3['target_days'])
            		            {
            		                $comp_pending[$row['ulbid']]['withinsla']+=1;
            		                //$data['comp_pending_withinsla']+=1;
            		            }
            		            else
            		            {
            		                $comp_pending[$row['ulbid']]['beyondinsla']+=1;
            		                //$data['comp_pending_beyondsla']+=1;
            		            }
            		        }
		        }
		        else
		        {
		            
		            $sql4="select g.ulbid,g.grievance_id,app_type_id,date_regd,DATEDIFF(NOW(),date_regd) AS target,ccm.cutt_off_time as target_days from grievances g , comp_cutofdays_map ccm where  g.cat3_id=ccm.cs_id and g.grievance_status_id IN('1','0')  and g.grievance_id='".$row['grievance_id']."' and g.app_type_id='1'";
		            
		            $rs4= mysqli_query($conn,$sql4);
		             while($row4= mysqli_fetch_assoc($rs4))
            		        {
            		            
            		            if($row4['target'] <= $row3['target_days'])
            		            {
            		                
		                                    $comp_pending[$row['ulbid']]['withinsla']+=1;
		                               
            		                //$data['comp_pending_withinsla']+=1;
            		            }
            		            else
            		            {
            		                $comp_pending[$row['ulbid']]['beyondinsla']+=1;
            		                //$data['comp_pending_beyondsla']+=1;
            		            }
            		        }
		        }
		        
		        
		    }
		    
		    
		}
		
		
		$tpl->assign('comp_resolved',$comp_resolved);
		$tpl->assign('comp_pending',$comp_pending);
		//$sql2="select g.* from grievances g,ulbmst u,Districtmst d,rdma_mst r where g.ulbid=u.ulbid and u.distid=d.distid and d.rdma=r.rdma_id and u.ulbid like '%".$_REQUEST['ulbid']."%' and d.distid like '%".$_REQUEST['distid']."%' and r.rdma_id like '%".$_REQUEST['regionid']."%' and  app_type_id='2' and date_regd >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)  ORDER BY date_regd , u.ulbname";
		
		//echo $sql2;
		$rs = mysqli_query($conn,$sql2);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $services2[$row['ulbid']]['received']+=1;
		    //$data['services_tot_reived']+=1;
		    if($row['grievance_status_id']=='3' || $row['grievance_status_id']=='9' || $row['grievance_status_id']=='10' || $row['grievance_status_id']=='4' || $row['grievance_status_id']=='6')
		    {
		        $services2[$row['ulbid']]['resolved']+=1;
		        
		        
		        $sql3="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd) AS target,gt.disposal_status from grievances g , grievances_transactions gt,category3_mst c where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('3','9','10','4')  and gt.disposal_status !=5 and g.grievance_id='".$row['grievance_id']."' and g.app_type_id='2'";
		        
		        $rs3= mysqli_query($conn,$sql3);
		        while($row3= mysqli_fetch_assoc($rs3))
		        {
		            
					 
		            if($row3['target'] <= $row3['target_days'])
		            {
		                $service_resolved[$row['ulbid']]['withinsla']+=1;
		                //$data['ser_redressed_resolvedsla']+=1;
		            }
		            else
		            {
		                $service_resolved[$row['ulbid']]['beyondinsla']+=1;
		                //$data['ser_redressed_beyondsla']+=1;
		            }
		        }
		    }
		    else
		    {
		        $services2[$row['ulbid']]['pending']+=1;
		        
		         $sql3="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(NOW(),date_regd) AS target,gt.disposal_status from grievances g , grievances_transactions gt,category3_mst c where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.grievance_status_id IN('2','1','0')  and gt.disposal_status !=5 and g.grievance_id='".$row['grievance_id']."' and g.app_type_id='2'";
		        
		        $rs3= mysqli_query($conn,$sql3);
		        $nr= mysqli_num_rows($rs3);
		        if($nr > 0)
		        {
        		        while($row3= mysqli_fetch_assoc($rs3))
        		        {
        		             
        					 
        		            if($row3['target'] <= $row3['target_days'])
        		            {
        		                $service_pending[$row['ulbid']]['withinsla']+=1;
        		                //$data['ser_pending_withinsla']+=1;
        		            }
        		            else
        		            {
        		                $service_pending[$row['ulbid']]['beyondinsla']+=1;
        		                //$data['ser_pending_beyondsla']+=1;
        		            }
        		        }
		        }
		        else
		        {
		            $sql4="select g.ulbid,g.grievance_id,app_type_id,date_regd,DATEDIFF(NOW(),date_regd) AS target,ccm.cutt_of_time+holidays_added as target_days from grievances g , category3_mst ccm where  g.cat3_id=ccm.cs_id and g.grievance_status_id IN('1','0')  and g.grievance_id='".$row['grievance_id']."' and g.app_type_id='2'";
		            $rs4= mysqli_query($conn,$sql4);
		             while($row4= mysqli_fetch_assoc($rs4))
            		        {
            		            
            		            if($row4['target'] <= $row4['target_days'])
            		            {
            		                $service_pending[$row['ulbid']]['withinsla']+=1;
            		               // $data['ser_pending_withinsla']+=1;
            		            }
            		            else
            		            {
            		               
            		                $service_pending[$row['ulbid']]['beyondinsla']+=1;
            		                //$data['ser_pending_beyondsla']+=1;
            		            }
            		        }
		        }
		    }
		    
		    
		}
		$tpl->assign('service_resolved',$service_resolved);
		$tpl->assign('service_pending',$service_pending);
	
		
		//$sql ="select * from ulbmst";
	  $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid and u.ulbid like '%".$_REQUEST['ulbid']."%' and
	  u.ulbid !='500' and d.distid like '%".$_REQUEST['distid']."%' and r.rdma_id like '%".$_REQUEST['regionid']."%' order by u.ulbname";
	  if($_SESSION['user_type']=='R')
	  {
	       $sql="select d.*,u.* from ulbmst u,Districtmst d,rdma_mst r where d.rdma=r.rdma_id and u.distid=d.distid and u.ulbid like '%".$_REQUEST['ulbid']."%' and 
	       u.ulbid !='500' and d.distid like '%".$_REQUEST['distid']."%' and d.rdma like '%".$_SESSION['uid']."%' order by u.ulbname";
	  }
		$rs = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($rs))
		{
		    $ulb_list[$row['ulbid']]=$row['ulbname'];
		    $data['services_tot_reived']+=$services2[$row['ulbid']]['received'];
		    $data['comp_tot_received']+=$complaints[$row['ulbid']]['received'];
		    $data['comp_redressed_withinsla']+=$comp_resolved[$row['ulbid']]['withinsla'];
		    $data['comp_redressed_beyondinsla']+=$comp_resolved[$row['ulbid']]['beyondinsla'];
		    $data['comp_pending_withinsla']+=$comp_pending[$row['ulbid']]['withinsla'];
		    $data['comp_pending_beyondsla']+=$comp_pending[$row['ulbid']]['beyondinsla'];
		    $data['ser_redressed_resolvedsla']+=$service_resolved[$row['ulbid']]['withinsla'];
		    $data['ser_redressed_beyondsla']+=$service_resolved[$row['ulbid']]['beyondinsla'];
		    $data['ser_pending_withinsla']+=$service_pending[$row['ulbid']]['withinsla'];
		    $data['ser_pending_beyondsla']+=$service_pending[$row['ulbid']]['beyondinsla'];
		    
		    
		    
		    
		    
		    
		}
			$sql="SELECT * FROM  rdma_mst";
		$rs = mysqli_query($conn,$sql);
		while($row= mysqli_fetch_assoc($rs))
		{
		$region_list[$row['rdma_id']]=$row['rdma_desc'];
		}
		
		$sql="SELECT * FROM  Districtmst";
		$rs = mysqli_query($conn,$sql);
		while($row= mysqli_fetch_assoc($rs))
		{
		$dist_list[$row['distid']]=$row['distname'];
		}
		
		mysqli_close($conn);
		$tpl->assign('services2',$services2);
		$tpl->assign('complaints',$complaints);
		$tpl->assign('region_id_sel',$_REQUEST['regionid']);
		$tpl->assign('dist_id_sel',$_REQUEST['distid']);
		$tpl->assign('ulbid_id_sel',$_REQUEST['ulbid']);
		
        $tpl->assign('region_list',$region_list);	
        $tpl->assign('dist_list',$dist_list);	
		$tpl->assign('data',$data);			
		$tpl->assign('ulb_list',$ulb_list);	
		$tpl->assign('services',$obj->services);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('past3report.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>