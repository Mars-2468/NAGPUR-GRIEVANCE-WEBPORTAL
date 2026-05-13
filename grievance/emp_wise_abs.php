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
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
		
	      $sql="SELECT count(grievance_id) as grievance_id,app_type_id,cat3_id,g.ulbid,c.comp_desc as cs_desc FROM grievances g,category3_mst c 
	      where g.cat3_id=c.cs_id and g.ulbid='".$ulbid1."' and app_type_id='2' group by cat3_id";
	 
	        $rs=mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($rs))
		    {
				  $data[$row['cat3_id']]['total_received']+=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
				 
		 
        echo $sql2="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd) AS target,
        gt.disposal_status,cat3_id from grievances g , grievances_transactions gt,category3_mst c,ulbmst u  where g.grievance_id=gt.grievance_id and 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id IN('3','9','10','4')  and gt.disposal_status !=5 and g.ulbid='".$ulbid1."' and g.app_type_id='2'";
        	 
			$rs2=mysqli_query($conn,$sql2);				
			while($row = mysqli_fetch_assoc($rs2))
			{
			    
				 if($row['target'] <= $row['target_days'])
        		 {
        			
        			 $data[$row['cat3_id']]['resolved_within_sla']+=1;
        			$tot['resolved_within_sla']+=1;
        		 }
        		 else
        		 {
        		    $data[$row['cat3_id']]['resolved_beyond_sla']+=1;
        			$tot['resolved_beyond_sla']+=1;
        		 }
	 		            
			}	
			
			
	 		$sql2="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(NOW(),date_regd) AS target,cat3_id 
	 		from grievances g , grievances_transactions gt,category3_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid=u.ulbid and 
	 		g.grievance_status_id NOT IN('3','6','9','10','4')  and  gt.disposal_status !=5 and g.ulbid='".$ulbid1."' and app_type_id='2'";
	 		
	 		$rs2=mysqli_query($conn,$sql2);				
			while($row = mysqli_fetch_assoc($rs2))
			{
			    
    			    if($row['target'] <= $row['target_days'])
                    {
                    	$data[$row['cat3_id']]['pending_within_sla']+=1;
                    	$tot['pending_within_sla']+=1;
                    }
                    else
                    {
                    	$data[$row['cat3_id']]['pending_beyond_sla']+=1;
                    	$tot['pending_beyond_sla']+=1;
                    }
	 		}
				
				
	        $sql="select g.grievance_id,app_type_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,cat3_id from grievances g ,
	        grievances_transactions gt where g.grievance_id=gt.grievance_id and g.grievance_status_id IN('6')  and  gt.disposal_status !=5 and 
	        g.ulbid='".$ulbid1."' and g.app_type_id='2'";
	                    
	        $rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 $data[$row['cat3_id']]['fin_implication']+=1;
				 $tot['fin_implication']+=1;
			}
			
			
	                    
	       $sql="select g.grievance_id,app_type_id,date_regd,DATEDIFF(NOW(),date_regd) AS target,cat3_id,c.cutt_of_time+holidays_added as target_days from 
	       grievances g,category3_mst c,ulbmst u where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id IN('1') and 
	       g.ulbid='".$ulbid1."' and g.app_type_id='2'";
	                
			$rs=mysqli_query($conn,$sql);				
			while($row = mysqli_fetch_assoc($rs))
			{
				 
				if($row['target'] <= $row['target_days'])
                {
                	$data[$row['cat3_id']]['pending_within_sla']+=1;
                	$tot['pending_within_sla']+=1;
                }
                else
                {
                	$data[$row['cat3_id']]['pending_beyond_sla']+=1;
                	$tot['pending_beyond_sla']+=1;
                }
	 		        
			}
				
				$sql ="select * from ulbmst";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				    
	        $sql ="select cs_id,comp_desc as cs_desc from category3_mst where ulbid='".$ulbid1."'";
	        $rs = mysqli_query($conn,$sql);
    		while($row = mysqli_fetch_assoc($rs))
    		{
    			$cs_list[$row['cs_id']]=$row['cs_desc'];
    				    
    				    
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				
    				
    			$sql ="select cat_id,description from category_mst";
				$rs = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($rs))
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
				  		
        		
        	mysqli_close($conn);	
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
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
		$tpl->display('emp_wise_abs.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		echo "<script>window.location='index.php';</script>";
	}
?>