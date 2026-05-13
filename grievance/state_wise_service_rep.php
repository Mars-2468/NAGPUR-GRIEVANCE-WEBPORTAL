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
		
		$aptid1=$_REQUEST['aptid'];
		$status1=$_REQUEST['status'];
	
		$user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		
		
	      $sql="SELECT count(grievance_id) as grievance_id, merg_cs_id FROM grievances g,category3_mst c 
	      where g.cat3_id=c.cs_id  and app_type_id= ? group by merg_cs_id";
	      
	      
	             $app_type_id = 2;     
	             $query->bind_param("i",$app_type_id);
        		 $query = $conn->prepare($sql);
        		 
        		 $query->execute();
        		 $rs = $query->get_result();
	      
	         
			while($row = $rs->fetch_assoc())
		    {
				  $data[$row['merg_cs_id']]['total_received']=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
				 
		 
        $sql2="select g.grievance_id,app_type_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(disposed_date,date_regd) AS target,
        gt.disposal_status,cat3_id,merg_cs_id from grievances g , grievances_transactions gt,category3_mst c,ulbmst u  where g.grievance_id=gt.grievance_id and 
        g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id IN('3','9','10','4')  and gt.disposal_status !=?  and g.app_type_id=?"; 
        
        
                 $disposal_status = 5;
        		 $app_type_id = 2;
        		 $query = $conn->prepare($sql2);
        		 $query->bind_param("ii",$app_type_id,$disposal_status);
        		 $query->execute();
        		 $rs = $query->get_result();
        
        
       
			 			
			while($row = $rs->fetch_assoc())
			{
			    
				 if($row['target'] <= $row['target_days'])
        		 {
        			
        			 $data[$row['merg_cs_id']]['resolved_within_sla']+=1;
        			$tot['resolved_within_sla']+=1;
        		 }
        		 else
        		 {
        		    $data[$row['merg_cs_id']]['resolved_beyond_sla']+=1;
        			$tot['resolved_beyond_sla']+=1;
        		 }
	 		            
			}	
			
			
	 		$sql2="select g.grievance_id,app_type_id,merg_cs_id,date_regd,disposed_date,c.cutt_of_time+holidays_added as target_days,DATEDIFF(NOW(),date_regd) AS target,cat3_id 
	 		from grievances g , grievances_transactions gt,category3_mst c,ulbmst u where g.grievance_id=gt.grievance_id and g.cat3_id=c.cs_id and g.ulbid=u.ulbid and 
	 		g.grievance_status_id NOT IN('3','6','9','10','4')  and  gt.disposal_status !=?  and app_type_id=?";
	 		
	 		
	 		     $disposal_status = 5;
	 		     $app_type_id = 2;
        		 $query = $conn->prepare($sql2);
        		 $query->bind_param("ii",$app_type_id,$disposal_status);
        		 $query->execute();
        		 $rs = $query->get_result();
        
	 		
	 		
	 		
	 			
	 					
			while($row = $rs->fetch_assoc())
			{
			    
    			    if($row['target'] <= $row['target_days'])
                    {
                    	$data[$row['merg_cs_id']]['pending_within_sla']+=1;
                    	$tot['pending_within_sla']+=1;
                    }
                    else
                    {
                    	$data[$row['merg_cs_id']]['pending_beyond_sla']+=1;
                    	$tot['pending_beyond_sla']+=1;
                    }
	 		}
	 		
	 		
				
				
	        $sql="select g.grievance_id,app_type_id,merg_cs_id,date_regd,disposed_date,DATEDIFF(disposed_date,date_regd) AS target,cat3_id from grievances g ,
	        grievances_transactions gt,ulbmst u, category3_mst c where g.grievance_id=gt.grievance_id and g.ulbid=u.ulbid and g.cat3_id=c.cs_id and g.grievance_status_id IN('6')  and g.app_type_id=?";
	        
	        
	             $app_type_id = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$app_type_id);
        		 $query->execute();
        		 $rs = $query->get_result();
	                
	         			
			while($row = $rs->fetch_assoc())
			{
				 $data[$row['merg_cs_id']]['fin_implication']+=1;
				 $tot['fin_implication']+=1;
			}
			
			
	                    
	       $sql="select g.grievance_id,app_type_id,merg_cs_id,date_regd,DATEDIFF(NOW(),date_regd) AS target,cat3_id,c.cutt_of_time+holidays_added as target_days from 
	       grievances g,category3_mst c,ulbmst u where g.cat3_id=c.cs_id and g.ulbid=u.ulbid and g.grievance_status_id IN('1')  and g.app_type_id=?";
	                
	                
	                
	             $app_type_id = 2;
        		 $query = $conn->prepare($sql);
        		 $query->bind_param("i",$app_type_id);
        		 $query->execute();
        		 $rs = $query->get_result();
	             
			 			
			while($row = $rs->fetch_assoc())
			{
				 
				if($row['target'] <= $row['target_days'])
                {
                	$data[$row['merg_cs_id']]['pending_within_sla']+=1;
                	$tot['pending_within_sla']+=1;
                }
                else
                {
                	$data[$row['merg_cs_id']]['pending_beyond_sla']+=1;
                	$tot['pending_beyond_sla']+=1;
                }
	 		        
			}
				
				$sql ="select * from ulbmst";
				
				 
        		 $query = $conn->prepare($sql);
        		  
        		 $query->execute();
        		 $rs = $query->get_result();
				
				
				
				 
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				    
	        $sql ="select section_id,cs_desc,cs_id from standard_services";
	        
	              
        		 $query = $conn->prepare($sql);
        		  
        		 $query->execute();
        		 $rs = $query->get_result();
	        
	        
	        
	        
    		while($row = $rs->fetch_assoc())
    		{
    			$cs_list[$row['cs_id']]=$row['cs_desc'];
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		$cs_list[0]="Others";
    		
    	
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				
    				
    			$sql ="select cat_id,description from category_mst";
    			
    			
    			
        		 
        		 $query = $conn->prepare($sql);
        		 
        		 $query->execute();
        		 $rs = $query->get_result();
    			
    			
    			
			 
				while($row = $rs->fetch_assoc())
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
				  		
        		
        $conn->close();		
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
		$tpl->display('state_wise_service_rep.tpl');
	}
	else
	{
	/*	$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/

        echo "<script>window.location='index.php';</script>";

	}
?>