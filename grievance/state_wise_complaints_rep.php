<?php
require "config.php";
	ini_set('display_errors',0);
	require_once('Smarty.class.php');
	$tpl=new Smarty();

	if(isset($_SESSION['uid']))
	{
	    
	    
	   // session_regenerate_id();
		require_once('get_services.php');
		$obj=new get_services($_SESSION['uid']);
		require_once('prepare_connection.php');
		/*require_once('connection.php');
		$conn=getconnection();*/
		
		/// In case of service 
		
		$aptid1=$_REQUEST['aptid'];
		$status1=$_REQUEST['status'];
	
		$user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		
		
	      $sql="SELECT count(grievance_id) as grievance_id, cat3_id FROM grievances 
	      where  app_type_id=? and cat3_id !=? group by cat3_id";
	      
	      
	      $app_type_id = 1;
	      $cat3_id = 0;
	      
	      $query=$conn->prepare($sql);
          $query->bind_param("ii",$app_type_id,$cat3_id);
	     if(!$query->execute())
    		        {
    		            echo "Query not executed 1";
    		        }
    		$rs=$query->get_result();
			while($row = $rs->fetch_assoc())
		    {
				  $data[$row['cat3_id']]['total_received']=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
			
			$query->close();
			
			
			// resolved within sla	 
		 
        $sql="select count(grievance_id) as resolved_within_sla,cat3_id from grievances  where 
        (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?)  and sla_status=?  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=1;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iiiiii",$id1,$id2,$id3,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 2";
            		        }
            		        
    	                $rs=$query->get_result();
        
        
      
					
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
        	$tot['resolved_within_sla']+=$row['resolved_within_sla'];
			}
			$query->close();
			// end
			
			// Resolved beyond sla
			$sql="select count(grievance_id) as resolved_beyond_sla,cat3_id from grievances  where 
        (grievance_status_id =? or grievance_status_id =? or grievance_status_id =?)  and sla_status=?  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iiiiii",$id1,$id2,$id3,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 3";
            		        }
            		        
    	                $rs=$query->get_result();
        
        
        	 
							
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
        	$tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
			$query->close();
			// end
			
			// under progress with in sla
			
			 $sql="select count(grievance_id) as pending_within_sla,cat3_id from grievances  where 
        grievance_status_id IN(?)  and sla_status=?  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=1;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 2;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iiii",$grievance_status_id,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 4";
            		        }
            		        
    	                $rs=$query->get_result();
        while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pending_within_sla']+=$row['pending_within_sla'];
        	$tot['pending_within_sla']+=$row['pending_within_sla'];
			}
			$query->close();
			// under progress beyond sla
			
			 $sql="select count(grievance_id) as pending_beyond_sla,cat3_id from grievances  where 
        grievance_status_id IN(?)  and sla_status=?  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 2;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iiii",$grievance_status_id,$sla_status,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 6";
            		        }
            		        
    	                $rs=$query->get_result();
        		
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
        	$tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			}
			$query->close();
			
			// Financial implications
			
				
			
			 $sql="select count(grievance_id) as fin_implication,cat3_id from grievances  where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 6;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 7";
            		        }
            		        
    	                $rs=$query->get_result();
        
        
        	 
							
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['fin_implication']+=$row['fin_implication'];
        	$tot['fin_implication']+=$row['fin_implication'];
			}
			$query->close();
			// Un resolved
			
			 $sql="select count(grievance_id) as unresolved,cat3_id from grievances  where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
      
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 4;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 8";
            		        }
            		        
    	                $rs=$query->get_result();
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['unresolved']+=$row['unresolved'];
        	$tot['unresolved']+=$row['unresolved'];;
			}
			$query->close();
			// Rejected
			
			
			
			 $sql="select count(grievance_id) as rejected,cat3_id from grievances where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 10;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 8";
            		        }
            		        
    	                $rs=$query->get_result();
        
        
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['rejected']+=$row['rejected'];
        	$tot['rejected']+=$row['rejected'];
			}
			
        		 
			$query->close();
			
	 	// Reopen 
	 	
			
			 $sql="select count(grievance_id) as reopen,cat3_id from grievances where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 11;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 9";
            		        }
            		        
    	                $rs=$query->get_result();
        while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen']+=$row['reopen'];
        	$tot['reopen']+=$row['reopen'];
			}
			$query->close();
				// Reopen under progress
	 	
			
			 $sql="select count(grievance_id) as reopen_underprogress,cat3_id from grievances where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 13;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 10";
            		        }
            		        
    	                $rs=$query->get_result();
        
     				
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen_underprogress']+=$row['reopen_underprogress'];
        	$tot['reopen_underprogress']+=$row['reopen_underprogress'];
			}
				
	       $query->close();
		// Reopen Completed
		
		
				
			 $sql="select count(grievance_id) as reopen_comp,cat3_id from grievances  where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
        
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 12;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 11";
            		        }
            		        
    	                $rs=$query->get_result();
        
      
        
        
        	 
					
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen_comp']+=$row['reopen_comp'];
        	$tot['reopen_comp']+=$row['reopen_comp'];
			}
			
			$query->close();
			
			// Pending for approval
			
			$sql="select count(grievance_id) as pendigforapproval,cat3_id from grievances where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id"; 
        
                        $app_type_id==1;
        	            $disposal_status = 5;
        	            $ulbid = $_REQUEST['ulbid'];
        	            $cat3_id = 0;
        	            $sla_status=2;
        	            $id1=9;
        	            $id2=8;
        	            $id3=3;
        	            $grievance_status_id = 1;
        	            $rdma = $_SESSION['uid'];
        	            $status_ids = array(9,8,3);
			            $inclause = implode(',', $status_ids);
			            $dept_id=$_REQUEST['dept_id'];
			            $query=$conn->prepare($sql);
        	            $query->bind_param("iii",$grievance_status_id,$app_type_id,$cat3_id);
        
                         if(!$query->execute())
            		        {
            		            echo $query->error."Query not executed 12";
            		        }
            		        
    	                $rs=$query->get_result();
        
        
        	 
					
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pendigforapproval']+=$row['pendigforapproval'];
        	$tot['pendigforapproval']+=$row['pendigforapproval'];;
			}
			$query->close();
	        $sql ="select * from cs_mst";
	       
	        $query=$conn->prepare($sql);
	            if(!$query->execute())
		        {
		            echo $query->error."Query not executed 13";
		        }
            		        
    	       $rs=$query->get_result();
			
				while($row = $rs->fetch_assoc())
				{
    		            $cat_id[$row['cs_id']]=$row['cat_id'];
    			        $cs_list[$row['cs_id']]=$row['cs_desc'];
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		$cs_list[0]="Others";
    		
    
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				$query->close();
    				
    			$sql ="select cat_id,description from category_mst";
    			$query=$conn->prepare($sql);
    			if(!$query->execute())
		        {
		            echo $query->error."Query not executed 14";
		        }
				 $rs=$query->get_result();
				while($row = $rs->fetch_assoc())
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
				
				$query->close();
				  		
        		
       	
        $tpl->assign('cat_id',$cat_id);
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
		$tpl->display('state_wise_complaints_rep.tpl');
	}
	else
	{
		/*$msg="You have not logged in, Please Login";
		$tpl->assign('msg',$msg);
		$tpl->display('user_login.tpl');*/
		
		
		echo "<script>window.location='index.php';</script>";
		
		
	}
?>