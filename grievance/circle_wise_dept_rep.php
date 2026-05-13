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
	
		$circle_id = '1' ;
		
		    
		     $sql = $conn->prepare("select e.emp_id,e.emp_name from emp_mst e , emp_map em , circle_ward_map cw where em.emp_id = e.emp_id and cw.ward = em.ward_id and 
		              cw.circle_id =?");
		     $sql->bind_param("i",$circle_id);
	         $sql->execute();
             $rs=$sql->get_result();
	        
    		while($row = $rs->fetch_assoc())
    		{
    			$emp_list[$row['emp_id']]=$row['emp_name'];
    		}
    		
    		foreach($emp_list as $emp_id=>$emp_name)
    		{
		               $wards=array();
		                  
		               $sql = $conn->prepare("select cw.* from emp_mst e , emp_map em , circle_ward_map cw where em.emp_id = e.emp_id and cw.ward = em.ward_id and 
		                                cw.circle_id =?");
        		        $sql->bind_param("i",$circle_id);
        	        	$sql->execute();
                        $rs1=$sql->get_result();
		                
		                while($row = $rs1->fetch_assoc())
                		{
                		  $wards[$row['ward']]=$row['ward'];
                		}
                		
    		
                		
                    	        $sql = $conn->prepare("SELECT count(g.grievance_id) as totalreceived FROM grievances g,grievances_transactions gt
                    	        where g.grievance_id = gt.grievance_id and gt.emp_id =? and app_type_id=? and cat3_id !=? and 
                    	        g.ward_id IN ('".implode("', '",$wards)."')");
                    	        
                    	        $app_type_id=1;
                    	        $cat3_id=0;
                    	        
                		        $sql->bind_param("sii",$emp_id,$app_type_id,$cat3_id);
                	        	$sql->execute();
                                $rs=$sql->get_result();
		                
                    	       
                    	        
                    			while($rows = $rs->fetch_assoc())
                    		    {
                    				  $data[$emp_id]['total_received']+=$rows['totalreceived'];
                    				  $tot['total_received']+=$rows['totalreceived'];
                    			}
                    			
                    		
                			/**** resolved with in sla ****/
                			
                		
                			
                			$sql =$conn->prepare("select COUNT(g.grievance_id) as resolved_within_sla,cat3_id from grievances g ,grievances_transactions gt where g.grievance_id = gt.grievance_id
                			 and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and gt.emp_id =? and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                		    
                		    $grievance_status_id_3=3;
                		    $grievance_status_id_8=8;
                		    $grievance_status_id_9=9;
                	        $app_type_id=1; $cat3_id=0; $sla_status_1 =1;
                	        
                	        $sql->bind_param("iiissiii",$grievance_status_id_3,$grievance_status_id_8,$grievance_status_id_9,$emp_id,$ulbid1,$app_type_id,$cat3_id,$sla_status_1);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                    	    
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$emp_id]['resolved_within_sla']+=$row['resolved_within_sla'];
                			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
                			}
                			
                			
                			/*** resolved beyond sla ****/
                			
                			
                			$sql =$conn->prepare("select COUNT(g.grievance_id) as resolved_within_sla,cat3_id from grievances g ,grievances_transactions gt where g.grievance_id = gt.grievance_id
                			 and (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and gt.emp_id =? and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                		    
                		    $grievance_status_id_3=3;
                		    $grievance_status_id_8=8;
                		    $grievance_status_id_9=9;
                	        $app_type_id=1; $cat3_id=0; $sla_status_2 =2;
                	        
                	        $sql->bind_param("iiissiii",$grievance_status_id_3,$grievance_status_id_8,$grievance_status_id_9,$emp_id,$ulbid1,$app_type_id,$cat3_id,$sla_status_2);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                    	    
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$emp_id]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
                			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
                			}
                			
                			
                			/**** pending with in sla ***/
                			
                		
                			
                			$sql =$conn->prepare("select COUNT(g.grievance_id) as pending_within_sla,cat3_id from grievances g,grievances_transactions gt where g.grievance_id = gt.grievance_id
                			and grievance_status_id IN(?) and gt.emp_id =? and ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                		    
                		    $grievance_status_id_2=2;
                	        $app_type_id=1; $cat3_id=0; $sla_status_1 =1;
                	        $sql->bind_param("issiii",$grievance_status_id_2,$emp_id,$ulbid1,$app_type_id,$cat3_id,$sla_status_1);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$emp_id]['pending_within_sla']+=$row['pending_within_sla'];
                			    $tot['pending_within_sla']+=$row['pending_within_sla'];
                			}
                			
	
                				/**** pending with beyond sla ***/
                			
                			$grievance_status_id_2=2;
                	        $app_type_id=1; $cat3_id=0; $sla_status_2 =2;
                	        
                	        $sql =$conn->prepare("select COUNT(g.grievance_id) as pending_within_sla,cat3_id from grievances g,grievances_transactions gt where g.grievance_id = gt.grievance_id
                			and grievance_status_id IN(?) and gt.emp_id =? and g.ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                	        
                    		$sql->bind_param("issiii",$grievance_status_id_2,$emp_id,$ulbid1,$app_type_id,$cat3_id,$sla_status_2);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                	        
                			while($row = $rs->fetch_assoc())
                			{
                			    $data[$emp_id]['pending_beyond_sla']+=$row['pending_beyond_sla'];
                			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
                			}
                			
	  	
                	        
                	        $grievance_status_id_6=6;
                	        $app_type_id=1; $cat3_id=0;
                	        $sql =$conn->prepare("select COUNT(g.grievance_id) as fin_implication,cat3_id from grievances g,grievances_transactions gt where 
                	        g.grievance_id = gt.grievance_id and g.grievance_status_id =? and gt.emp_id =? and g.ulbid=?
                	        and app_type_id=? and cat3_id !=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                	        
                    		$sql->bind_param("issii",$grievance_status_id_6,$emp_id,$ulbid1,$app_type_id,$cat3_id);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                	        
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$emp_id]['fin_implication']+=$row['fin_implication'];
                				 $tot['fin_implication']+=$row['fin_implication'];
                			}
                		
                		  	
                	          
                	        $grievance_status_id_1=1;
                	        $app_type_id=1; $cat3_id=0;
                	        $sql =$conn->prepare("select COUNT(g.grievance_id) as pending_apprvl,cat3_id from grievances g,grievances_transactions gt where 
                	           g.grievance_id = gt.grievance_id and g.grievance_status_id =? and gt.emp_id =? and g.ulbid=? and 
                	         app_type_id=? and cat3_id !=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                	         
                    		$sql->bind_param("issii",$grievance_status_id_1,$emp_id,$ulbid1,$app_type_id,$cat3_id);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$emp_id]['pending_apprvl']+=$row['pending_apprvl'];
                				 $tot['pending_apprvl']+=$row['pending_apprvl'];
                			}
                			
    	          
                	        
                	        $grievance_status_id_10=10;
                	        $app_type_id=1; $cat3_id=0;
                	        $sql =$conn->prepare("select COUNT(g.grievance_id) as rejected,cat3_id from grievances g,grievances_transactions gt where 
                			   g.grievance_id = gt.grievance_id and g.grievance_status_id =? and gt.emp_id =?  and ulbid=? and 
                			 app_type_id=? and cat3_id !=? and ward_id IN ('".implode("', '",$wards)."') group by cat3_id");
                    		$sql->bind_param("issii",$grievance_status_id_10,$emp_id,$ulbid1,$app_type_id,$cat3_id);
                    		$sql->execute();
                    	    $rs=$sql->get_result();
                	        
                			while($row = $rs->fetch_assoc())
                			{
                				 $data[$emp_id]['rejected']+=$row['rejected'];
                				 $tot['rejected']+=$row['rejected'];
                			}
                			
    		}
                			
            
				
			
				 $sql =$conn->prepare("select * from ulbmst");
                    		
                    		$sql->execute();
                    	    $rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				
        		
        	$conn->close();
        	
        $tpl->assign('reopened_completed_tot',$reopened_completed_tot);	
        $tpl->assign('user_type',$_SESSION['user_type']);
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('cat_id',$cat_id);
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
		$tpl->display('circle_wise_dept_rep.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
	}
?>