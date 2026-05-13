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
		include('prepare_connection.php');
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=$_REQUEST['aptid'];
		$status1=$_REQUEST['status'];
		$ulbid1=$_SESSION['ulbid'];
		$user_type1=$_SESSION['user_type'];
		$sla1=$_REQUEST['sla'];
		
	     
	     	/**** Total received ****/
	      
	     
			
		 $sql=$conn->prepare("SELECT count(grievance_id) as grievance_id,ward_id  FROM grievances  
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
		 
		
		
			
		$sql ="select COUNT(g.grievance_id) as resolve,g.user_id,u.user_id  from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and 
			(g.grievance_status_id =? or g.grievance_status_id=? or g.grievance_status_id=?) and g.ulbid=? and app_type_id=? and 
			(g.grievance_origin_id=? or g.grievance_origin_id=? or g.grievance_origin_id=?) and cat3_id !=?  group by g.user_id";
			$query=$conn->prepare($sql);
    	    $grievance_status_id = [3,8,9];
            $grievance_status_id1 = 3;
            $grievance_status_id2 =8;
            $grievance_status_id3 =9;
            $ulbid=$ulbid1;
		    $app_type_id=1;
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
            $cat3_id=0;
            $query->bind_param("iiisiiiii",htmlspecialchars(strip_tags($grievance_status_id1)),htmlspecialchars(strip_tags($grievance_status_id2)),htmlspecialchars(strip_tags($grievance_status_id3)),htmlspecialchars(strip_tags($ulbid)),
            htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)),htmlspecialchars(strip_tags($cat3_id)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['user_id']]['resolve']+=$row['resolve'];
			    $data[$row['user_id']]['total']+=$row['resolve'];
			    $data['total']+=$row['resolve'];
			    $tot['resolve']+=$row['resolve'];
			    }
			
			
	 			/**** pending ****/
			
		
			
			$sql ="select COUNT(g.grievance_id) as pendings,g.user_id,u.user_id  from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and 
			g.grievance_status_id IN(?) and g.ulbid=? and app_type_id=?
			and (g.grievance_origin_id =? or g.grievance_origin_id =? or g.grievance_origin_id=?) and cat3_id !=?  group by g.user_id";
			$query=$conn->prepare($sql);
    	    $grievance_status_id =2;
            
            $ulbid=$ulbid1;
		    $app_type_id=1;
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
            $cat3_id=0;
            $query->bind_param("isiiiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),
            htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)),htmlspecialchars(strip_tags($cat3_id)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['user_id']]['pendings']+=$row['pendings'];
			    $data[$row['user_id']]['total']+=$row['pendings'];
			    $data['total']+=$row['pendings'];
			    $tot['pendings']+=$row['pendings'];
			    }
			
		
			/**** fin implication ****/
	
			
	      
			
			$sql ="select COUNT(g.grievance_id) as fin_impli,g.user_id,u.user_id  from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and 
			g.grievance_status_id IN(?) and g.ulbid=? and app_type_id=? and 
			(g.grievance_origin_id =? or g.grievance_origin_id =? or g.grievance_origin_id =?) and cat3_id !=?  group by g.user_id";
			$query=$conn->prepare($sql);
    	    $grievance_status_id =6;
            
            $ulbid=$ulbid1;
		    $app_type_id=1;
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
            $cat3_id=0;
            $query->bind_param("isiiiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),
            htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)),htmlspecialchars(strip_tags($cat3_id)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['user_id']]['fin_impli']+=$row['fin_impli'];
				 $data[$row['user_id']]['total']+=$row['fin_impli'];
				 $data['total']+=$row['fin_impli'];
				 $tot['fin_impli']+=$row['fin_impli'];
			    }
			
		
		  	
	        
		$sql ="select COUNT(g.grievance_id) as pending_apprvl,g.user_id,u.user_id  from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and 
			g.grievance_status_id IN(?) and g.ulbid=? and app_type_id=? and 
			(g.grievance_origin_id =? or g.grievance_origin_id =? or g.grievance_origin_id =?) and cat3_id !=?  group by g.user_id";
			$query=$conn->prepare($sql);
    	    $grievance_status_id =1;
            
            $ulbid=$ulbid1;
		    $app_type_id=1;
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
            $cat3_id=0;
            $query->bind_param("isiiiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),
            htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)),htmlspecialchars(strip_tags($cat3_id)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['user_id']]['pending_apprvl']+=$row['pending_apprvl'];
				 $data[$row['user_id']]['total']+=$row['pending_apprvl'];
				 $data['total']+=$row['pending_apprvl'];
				 $tot['pending_apprvl']+=$row['pending_apprvl'];
			    }
			
			
		
				$sql ="select COUNT(g.grievance_id) as rejected,g.user_id,u.user_id  from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and 
			g.grievance_status_id IN(?) and g.ulbid=? and app_type_id=? and 
			(g.grievance_origin_id =? or g.grievance_origin_id =? or g.grievance_origin_id =?) and cat3_id !=?  group by g.user_id";
			$query=$conn->prepare($sql);
    	    $grievance_status_id =10;
            
            $ulbid=$ulbid1;
		    $app_type_id=1;
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
            $cat3_id=0;
            $query->bind_param("isiiiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),
            htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)),htmlspecialchars(strip_tags($cat3_id)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['user_id']]['rejected']+=$row['rejected'];
				 $data[$row['user_id']]['total']+=$row['rejected'];
				 $data['total']+=$row['rejected'];
				 $tot['rejected']+=$row['rejected'];
			    }
			

			
			
		
			
			
				$sql ="select COUNT(g.grievance_id) as unresolved,g.user_id,u.user_id  from grievances g , users u where u.user_id = g.user_id and u.user_type= 'E' and 
			g.grievance_status_id IN(?) and g.ulbid=? and app_type_id=? and 
				(g.grievance_origin_id =? or g.grievance_origin_id =? or g.grievance_origin_id =?) and cat3_id !=?  group by g.user_id";
			$query=$conn->prepare($sql);
    	    $grievance_status_id =4;
            
            $ulbid=$ulbid1;
		    $app_type_id=1;
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
            $cat3_id=0;
            $query->bind_param("isiiiii",htmlspecialchars(strip_tags($grievance_status_id)),htmlspecialchars(strip_tags($ulbid)),
            htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)),htmlspecialchars(strip_tags($cat3_id)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    $data[$row['user_id']]['unresolved']+=$row['unresolved'];
				 $data[$row['user_id']]['total']+=$row['unresolved'];
				 $data['total']+=$row['unresolved'];
				 $tot['unresolved']+=$row['unresolved'];
			    }
			    
			  
				
			
				$sql=$conn->prepare("select * from ulbmst");
				$sql->execute();
				$rs=$sql->get_result();
				while($row = $rs->fetch_assoc())
			    {
			     $ulb_list[$row['ulbid']]=$row['ulbname'];
			    }
		    	
		
			
		$sql ="select g.user_id,u.* from grievances g , users u where u.user_id = g.user_id and u.user_type =? and 
		u.ulbid =? and (g.grievance_origin_id =? or g.grievance_origin_id =? or g.grievance_origin_id =?) group by g.user_id";
			$query=$conn->prepare($sql);
    	   
            $ulbid=$_SESSION['ulbid'];
		    $user_type='E';
		    $grievance_origin_id=[2,3,7];
		    $grievance_origin_id1 = 2;
            $grievance_origin_id2 =3;
            $grievance_origin_id3 =7;
           
            $query->bind_param("ssiii",htmlspecialchars(strip_tags($user_type)),htmlspecialchars(strip_tags($ulbid)),htmlspecialchars(strip_tags($grievance_origin_id1)),htmlspecialchars(strip_tags($grievance_origin_id2)),htmlspecialchars(strip_tags($grievance_origin_id3)));
            $query->execute();
		    $rs=$query->get_result();	
			
		
			  while($row = $rs->fetch_assoc())
			    {
			    	$emp_list[$row['user_id']]=$row['user_name'];
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
		$tpl->assign('emp_list',$emp_list);
		$tpl->assign('banner',$_SESSION['banner']);
		$tpl->assign('logo',$_SESSION['logo']);
		$tpl->assign('main_icons',$obj->main_icons);
		$tpl->assign('grievance_status_list',$grievance_status_list);
		$tpl->assign('services',$obj->services);
		$tpl->assign('uname',$_SESSION['user_name']);
		$tpl->assign('uid',$_SESSION['uid']);
		$tpl->display('users_rep.tpl');
	}
	else
	{

		echo "<script>window.location='index.php';</script>";
		
	}
?>