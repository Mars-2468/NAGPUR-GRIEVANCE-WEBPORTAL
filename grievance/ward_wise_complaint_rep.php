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
		require_once('connection.php');
		include('prepare_connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
	     
	     	/**** Total received ****/
	    
				 
		  $sql =$conn->prepare("SELECT count(grievance_id) as grievance_id,ward_id  FROM grievances  
	      where ulbid=? and app_type_id=? and cat3_id !=? group by ward_id");
	      $ulbid=$ulbid1;
	      $app_type_id=1;
	      $cat3_id=0;
	      $sql->bind_param("sii",htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));
		  $sql->execute();
		  $rs =$sql->get_result();
		  while($row = $rs->fetch_assoc())
		  {
		      $data[$row['ward_id']]['total_received']+=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
		  }
		
		
				/**** resolved with in sla ****/
			
		
		
			
		$sql ="select COUNT(grievance_id) as resolved_within_sla,ward_id  from grievances where 
			(grievance_status_id =? or grievance_status_id =? or grievance_status_id =?)
			and ulbid =? and app_type_id =? and cat3_id !=? and sla_status =? group by ward_id";
		$query=$conn->prepare($sql);
	    $grievance_status_id = [3,8,9];
        $grievance_status_id1 = 3;//implode(',', $grievance_status_id);
        $grievance_status_id2 =8;//implode(',', $grievance_status_id);
        $grievance_status_id3 =9;// implode(',', $grievance_status_id);
        
		$ulbid=$ulbid1;
		$app_type_id=1;
		$cat3_id=0;
		$sla_status=1;
		$query->bind_param("iiisiii",htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)),htmlspecialchars(strip_tags($sla_status)));     
		$query->execute();
		$rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['ward_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
			    }
		 
			
			/*** resolved beyond sla ****/
			
		
			$sql="select COUNT(grievance_id) as resolved_beyond_sla,ward_id from grievances where 
			(grievance_status_id =? or grievance_status_id =? or grievance_status_id =?)
			and ulbid =? and app_type_id =? and cat3_id !=? and sla_status =? group by ward_id";
			$query=$conn->prepare($sql);
	        $grievance_status_id = [3,8,9];
            $grievance_status_id1 = 3;//implode(',', $grievance_status_id);
            $grievance_status_id2 = 8;//implode(',', $grievance_status_id);
            $grievance_status_id3 = 9;//implode(',', $grievance_status_id);
        
		    $ulbid=$ulbid1;
		    $app_type_id=1;
		    $cat3_id=0;
		    $sla_status=2;
		    $query->bind_param("iiisiii",htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)),htmlspecialchars(strip_tags($sla_status)));     
		    $query->execute();
		    $rs=$query->get_result();	
				
				
			if($rs)
			{
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['ward_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    }
		 	}
		
			
			
	 			/**** pending with in sla ***/
			
		
			$sql ="select COUNT(grievance_id) as pending_within_sla,ward_id  from grievances where grievance_status_id IN(?) and ulbid=? and 
			app_type_id=? and cat3_id !=? and sla_status=? group by ward_id";
			$query=$conn->prepare($sql);
	        $grievance_status_id =2;
        
    		$ulbid=$ulbid1;
    		$app_type_id=1;
    		$cat3_id=0;
    		$sla_status=1;
    		$query->bind_param("isiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)),htmlspecialchars(strip_tags($sla_status)));     
    		$query->execute();
    		$rs=$query->get_result();	
				
			  
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['ward_id']]['pending_within_sla']+=$row['pending_within_sla'];
			    $tot['pending_within_sla']+=$row['pending_within_sla'];
			    }
		 	
			
			
				/**** pending with beyond sla ***/
			
		
			$sql ="select COUNT(grievance_id) as pending_within_sla,ward_id  from grievances where grievance_status_id IN(?) and ulbid=? and 
			app_type_id=? and cat3_id !=? and sla_status=? group by ward_id";
			$query=$conn->prepare($sql);
	        $grievance_status_id =2;
            $ulbid=$ulbid1;
    		$app_type_id=1;
    		$cat3_id=0;
    		$sla_status=2;
    		$query->bind_param("isiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)),htmlspecialchars(strip_tags($sla_status)));     
    		$query->execute();
    		$rs=$query->get_result();	
				
			  
			  while($row = $rs->fetch_assoc())
			    {
			   $data[$row['ward_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    }
				
	       
		
			$sql="select COUNT(grievance_id) as fin_implication,ward_id from grievances where grievance_status_id =? and ulbid=? and app_type_id=? and
	        cat3_id !=? group by ward_id";
	        $query=$conn->prepare($sql);
	        $grievance_status_id =6;
            $ulbid=$ulbid1;
    		$app_type_id=1;
    		$cat3_id=0;
    	
    		$query->bind_param("isii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));     
    		$query->execute();
    		$rs=$query->get_result();	
				
			  
			  while($row = $rs->fetch_assoc())
			    {
			     $data[$row['ward_id']]['fin_implication']+=$row['fin_implication'];
				 $tot['fin_implication']+=$row['fin_implication'];
			    }
			
		    $sql="select COUNT(grievance_id) as pending_apprvl,ward_id from grievances where grievance_status_id =? and ulbid=? and 
	         app_type_id=? and cat3_id !=? group by ward_id";
	        $query=$conn->prepare($sql);
	        $grievance_status_id =1;
            $ulbid=$ulbid1;
    		$app_type_id=1;
    		$cat3_id=0;
    	
    		$query->bind_param("isii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));     
    		$query->execute();
    		$rs=$query->get_result();	
				
			  
			  while($row = $rs->fetch_assoc())
			    {
			     $data[$row['ward_id']]['pending_apprvl']+=$row['pending_apprvl'];
				 $tot['pending_apprvl']+=$row['pending_apprvl'];
			    }

		$sql="select COUNT(grievance_id) as rejected,ward_id from grievances where grievance_status_id =? and ulbid=? and app_type_id=? and 
			 cat3_id !=? group by ward_id";
	        $query=$conn->prepare($sql);
	        $grievance_status_id =10;
            $ulbid=$ulbid1;
    		$app_type_id=1;
    		$cat3_id=0;
    	
    		$query->bind_param("isii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));     
    		$query->execute();
    		$rs=$query->get_result();	
				
			  
			  while($row = $rs->fetch_assoc())
			    {
			     $data[$row['ward_id']]['rejected']+=$row['rejected'];
				 $tot['rejected']+=$row['rejected'];
			    }	
			
			
		
			$sql="select COUNT(grievance_id) as unresolved,ward_id  from grievances where grievance_status_id =? and ulbid=? and app_type_id=? 
			and cat3_id !=? group by ward_id";
	        $query=$conn->prepare($sql);
	        $grievance_status_id =4;
            $ulbid=$ulbid1;
    		$app_type_id=1;
    		$cat3_id=0;
    	
    		$query->bind_param("isii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)));     
    		$query->execute();
    		$rs=$query->get_result();	
				
			  
			  while($row = $rs->fetch_assoc())
			    {
			     $data[$row['ward_id']]['unresolved']+=$row['unresolved'];
				 $tot['unresolved']+=$row['unresolved'];
			    }
			
				$sql=$conn->prepare("select * from ulbmst");
				$sql->execute();
				$rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
			    {
			     $ulb_list[$row['ulbid']]=$row['ulbname'];
			    }
			
		    
				$sql=$conn->prepare("select * from ward_mst where ulbid=? order by ward_id");
				$ulbid=$ulbid1;
				$sql->bind_param("s",htmlspecialchars(strip_tags($ulbid)));
				$sql->execute();
				$rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
			    {
			      $ward_list[$row['ward_id']]=$row['ward_desc'];
			    }
			
	      	
    			
    	$sql=$conn->prepare("select cs_id,comp_desc as cs_desc from category3_mst where ulbid=?");
				$ulbid=$ulbid1;
				$sql->bind_param("s",htmlspecialchars(strip_tags($ulbid)));
				$sql->execute();
				$rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
			    {
			     $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    			 $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
			    }		
    			
    			$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);	
    			
    					
    		
				$sql=$conn->prepare("select cat_id,description from category_mst");
				$sql->execute();
				$rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
			    {
			     $cat_list[$row['cat_id']]=$row['description'];
			    }
				
			
			
				 $conn->close();
				 
				
		$tpl->assign('users_list',$users_list);
		$tpl->assign('sla',$_REQUEST['sla']);
		$tpl->assign('pagination',$pagination);
		$tpl->assign('dept_list',$dept_list);
		$tpl->assign('ulbid',$_SESSION['ulbid']);
		$tpl->assign('app_type_id',$_REQUEST['aptid']);
		$tpl->assign('ward_list',$ward_list);
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
		$tpl->display('ward_wise_complaint_rep.tpl');
	}
	else
	{
	
		echo "<script>window.location='index.php';</script>";
		
	}
?>