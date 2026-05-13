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
	
		
		$aptid1=$_REQUEST['aptid'];
		$status1=$_REQUEST['status'];
        $user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		
		
	      
	      $sql="SELECT count(grievance_id) as grievance_id, cat3_id,ulbid FROM grievances 
	      where  app_type_id=? and cat3_id !=? group by cat3_id,ulbid";
	      
	      $app_type_id = 1;
	      $cat3_id = 0;
	      
	      
	      $query=$conn->prepare($sql);
	       
	       $query->bind_param("ii",htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
	       if(!$query->execute())
            {
                echo "Query not executed 1";
            }
           $rs=$query->get_result();
	      
	      
	       
			while($row = $rs->fetch_assoc())
		    {
				  $data[$row['ulbid']][$row['cat3_id']]['total_received']=$row['grievance_id'];
				  $tot[$row['cat3_id']]['total_received']+=$row['grievance_id'];
			}
			
			
        $sql="select count(grievance_id) as resolved_within_sla,cat3_id,ulbid from grievances  where (
        grievance_status_id = ? OR
        grievance_status_id = ? OR
        grievance_status_id = ? OR
        grievance_status_id = ? OR
        grievance_status_id = ? OR
        grievance_status_id = ? OR
        grievance_status_id = ?
        )  and app_type_id=? and cat3_id !=?  group by cat3_id,ulbid";
        
            $app_type_id = 1;
	        $cat3_id = 0;
	        $id3 = 3;
	        $id9 = 9;
	        $id8 = 8;
	        $id4 = 4;
	        $id6 = 6;
	        $id10 = 10;
	        $id12 = 12;
	        $sla_status =1 ;
	        
	        $query=$conn->prepare($sql);
	       
	       $query->bind_param("iiiiiiiii",htmlspecialchars(strip_tags($id3)),htmlspecialchars(strip_tags($id9)),htmlspecialchars(strip_tags($id8)),htmlspecialchars(strip_tags($id4)),htmlspecialchars(strip_tags($id6)),htmlspecialchars(strip_tags($id10)),htmlspecialchars(strip_tags($id12)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
	       if(!$query->execute())
            {
                echo "Query not executed 2";
            }
           $rs=$query->get_result();
	        
        
      
					
			while($row = $rs->fetch_assoc())
			{
			$data[$row['ulbid']][$row['cat3_id']]['resolved_within_sla']=$row['resolved_within_sla'];
        	$tot[$row['cat3_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
			}
		
        
        $sql="select count(grievance_id) as resolved_beyond_sla,cat3_id from grievances  where (
        grievance_status_id =? OR grievance_status_id =? OR grievance_status_id =?)  and app_type_id=? and cat3_id !=? group by cat3_id";
        
            $app_type_id = 1;
            $sla_status = 2;
	        $cat3_id = 0;
	        $id3 = 3;
	        $id9 = 9;
	        $id8 = 8;
	        
	        
	        $query=$conn->prepare($sql);
	       
	       $query->bind_param("iiiii",htmlspecialchars(strip_tags($id3)),htmlspecialchars(strip_tags($id9)),htmlspecialchars(strip_tags($id8)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
	       if(!$query->execute())
            {
                echo "Query not executed 3";
            }
           $rs=$query->get_result();
           
           while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
        	$tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
		
        $sql="select count(grievance_id) as pending_within_sla,cat3_id,ulbid from grievances  where (
        grievance_status_id = ? OR grievance_status_id = ? OR grievance_status_id = ?)  and app_type_id=? and cat3_id !=? group by cat3_id,ulbid";
        
        
            $app_type_id = 1;
            $sla_status = 1;
	        $cat3_id = 0;
	        $id2 = 2;
	        $id11 = 11;
	        $id13 = 13;
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iiiii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($id11)),htmlspecialchars(strip_tags($id13)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 4";
                }
               $rs=$query->get_result();
                while($row = $rs->fetch_assoc())
        			{
        			$data[$row['ulbid']][$row['cat3_id']]['pending_within_sla']=$row['pending_within_sla'];
                	$tot[$row['cat3_id']]['pending_within_sla']+=$row['pending_within_sla'];
        			}
		
        
        $sql="select count(grievance_id) as pending_beyond_sla,cat3_id from grievances  where 
        grievance_status_id IN(?) and app_type_id=? and cat3_id !=? group by cat3_id";
        
            $app_type_id = 1;
            $sla_status = 2;
	        $cat3_id = 0;
	        $id2 = 2;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 5";
                }
               $rs=$query->get_result();
              while($row = $rs->fetch_assoc())
    			{
    			$data[$row['cat3_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
            	$tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
    			}
    			
		
        
        $sql="select count(grievance_id) as fin_implication,cat3_id from grievances  where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id";
        
        
            $app_type_id = 1;
            $cat3_id = 0;
	        $id2 = 6;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 6";
                }
               $rs=$query->get_result();
        			
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['fin_implication']+=$row['fin_implication'];
        	$tot['fin_implication']+=$row['fin_implication'];
			}
			
		
        
        $sql="select count(grievance_id) as unresolved,cat3_id from grievances  where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id";
        
            $app_type_id = 1;
            $cat3_id = 0;
	        $id2 = 4;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 7";
                }
               $rs=$query->get_result();			
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['unresolved']+=$row['unresolved'];
        	$tot['unresolved']+=$row['unresolved'];;
			}
			
		
        
        $sql="select count(grievance_id) as rejected,cat3_id from grievances where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id";
        
            $app_type_id = 1;
            $cat3_id = 0;
	        $id2 = 10;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 8";
                }
               $rs=$query->get_result();			
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['rejected']+=$row['rejected'];
        	$tot['rejected']+=$row['rejected'];
			}
			
        
        
            $app_type_id = 1;
            $cat3_id = 0;
	        $id2 = 11;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 8";
                }
               $rs=$query->get_result();
        
        while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen']+=$row['reopen'];
        	$tot['reopen']+=$row['reopen'];
			}	
				
	   
			
        
        $sql="select count(grievance_id) as reopen_comp,cat3_id from grievances  where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id";
        
      
            $app_type_id = 1;
            $cat3_id = 0;
	        $id2 = 12;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 9";
                }
               $rs=$query->get_result();
            while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['reopen_comp']+=$row['reopen_comp'];
        	$tot['reopen_comp']+=$row['reopen_comp'];
			}
		
      $sql="select count(grievance_id) as pendigforapproval,cat3_id from grievances where 
        grievance_status_id IN(?)  and app_type_id=? and cat3_id !=? group by cat3_id";
        
            $app_type_id = 1;
            $cat3_id = 0;
	        $id2 = 1;
	        
	        
	        $query=$conn->prepare($sql);
	        $query->bind_param("iii",htmlspecialchars(strip_tags($id2)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
	       
    	       if(!$query->execute())
                {
                    echo "Query not executed 10";
                }
               $rs=$query->get_result();
        	 
						
			while($row = $rs->fetch_assoc())
			{
			$data[$row['cat3_id']]['pendigforapproval']+=$row['pendigforapproval'];
        	$tot['pendigforapproval']+=$row['pendigforapproval'];;
			}
	                    
	      
				
				$sql ="select * from ulbmst";
				$query=$conn->prepare($sql);
				 if(!$query->execute())
                {
                    echo "Query not executed 11";
                }
               $rs=$query->get_result();
			
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
				    
	        $sql ="select * from cs_mst";
	        $query=$conn->prepare($sql);
	        if(!$query->execute())
                {
                    echo "Query not executed 11";
                }
               $rs=$query->get_result();
	        
    		while($row = $rs->fetch_assoc())
    		{
    		            $cat_id[$row['cs_id']]=$row['cat_id'];
    			        $cs_list[$row['cs_id']]=$row['cs_desc'];
    				    
    		}
    		$cs_list[0]="Others";
    		
    	
    				
    			$sql ="select ulbid,ulbname from ulbmst";
    			$query=$conn->prepare($sql);
    			 $query=$conn->prepare($sql);
	        if(!$query->execute())
                {
                    echo "Query not executed 12";
                }
               $rs=$query->get_result();
			
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				  		
        		
        $query->close();
        
        $tpl->assign('cat_id',$cat_id);
        $tpl->assign('ulb_list',$ulb_list);
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
		$tpl->display('ulbcat_comp_rep.tpl');
	}
	else
	{
		
		echo "<script>window.location='index.php';</script>";
		
	}
?>