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
		$conn=getconnection();
		
		/// In case of service 
		
		$aptid1=htmlspecialchars(strip_tags($_REQUEST['aptid']));
		$status1=htmlspecialchars(strip_tags($_REQUEST['status']));
		$ulbid1=htmlspecialchars(strip_tags($_SESSION['ulbid']));
		$user_type1=htmlspecialchars(strip_tags($_SESSION['user_type']));
		$sla1=htmlspecialchars(strip_tags($_REQUEST['sla']));
		
	     
	     	/**** Total received ****/
	     	
		   
	      
	      $app_type_id=2;$cat3_id=0;
	      $sql=$conn->prepare("SELECT count(grievance_id) as grievance_id,ward_id  FROM grievances  
	      where ulbid=? and app_type_id=? and cat3_id !=? group by ward_id");
	      $sql->bind_param("sii",$ulbid1,$app_type_id,$cat3_id);
	      
	      
	      $sql->execute();
	      $rs=$sql->get_result();
	 
	        
			while($row = $rs->fetch_assoc())
		    {
				   $data[$row['ward_id']]['total_received']+=$row['grievance_id'];
				  $tot['total_received']+=$row['grievance_id'];
			}
				 
		 
			
				/**** resolved with in sla ****/
				$sla_status_1 = 1;
	
	            $in1 = 8; $in2 = 9;	$in3 = 3;
			 $sql=$conn->prepare("SELECT COUNT(grievance_id) as resolved_within_sla,ward_id  from grievances where (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?) and 
			ulbid=? and app_type_id=? and cat3_id !=? and sla_status=? group by ward_id");
	        $sql->bind_param("iiisiii",htmlspecialchars(strip_tags($in1)),htmlspecialchars(strip_tags($in2)),htmlspecialchars(strip_tags($in3)),htmlspecialchars(strip_tags($ulbid1)),htmlspecialchars(strip_tags($app_type_id)),htmlspecialchars(strip_tags($cat3_id)),htmlspecialchars(strip_tags($sla_status_1)));
	      
	        $sql->execute();
	        $rs=$sql->get_result();
	        			
			while($row = $rs->fetch_assoc())
			{
			    $data[$row['ward_id']]['resolved_within_sla']+=$row['resolved_within_sla'];
			    $tot['resolved_within_sla']+=$row['resolved_within_sla'];
			}
			
			/*** resolved beyond sla ****/
			$sla_status_2 =2;
			
			$sql=$conn->prepare("SELECT COUNT(grievance_id) as resolved_beyond_sla,ward_id from grievances where (grievance_status_id=? or grievance_status_id=? or grievance_status_id=?)  and ulbid=? 
			and app_type_id=? and cat3_id !=? and sla_status=? group by ward_id");
	        $sql->bind_param("iiisiii",$in1,$in2,$in3,$ulbid1,$app_type_id,$cat3_id,$sla_status_2);
	        
			
			$sql->execute();
			$rs = $sql->get_result();
				
			while($row = $rs->fetch_assoc())
			{
			    $data[$row['ward_id']]['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			    $tot['resolved_beyond_sla']+=$row['resolved_beyond_sla'];
			}
			
			
			
			
			
	 			/**** pending with in sla ***/
			
			$in4 = 2;
			$sql=$conn->prepare("SELECT COUNT(grievance_id) as pending_within_sla,ward_id  from grievances where grievance_status_id IN(?) and ulbid=? and 
			app_type_id=? and cat3_id !=? and sla_status=? group by ward_id");
	        $sql->bind_param("isiii",$in4,$ulbid1,$app_type_id,$cat3_id,$sla_status_1);
	        
	        
			
			$sql->execute();
			$rs = $sql->get_result();
			while($row = $rs->fetch_assoc())
			{
			    $data[$row['ward_id']]['pending_within_sla']+=$row['pending_within_sla'];
			    $tot['pending_within_sla']+=$row['pending_within_sla'];
			}
			
			
				/**** pending with beyond sla ***/
			
			
			$sql = $conn->prepare("SELECT COUNT(grievance_id) as pending_beyond_sla,ward_id from grievances where grievance_status_id IN(?) and ulbid=? and 
			app_type_id=? and cat3_id !=? and sla_status=? group by ward_id");
			$sql->bind_param("isiii",$in4,$ulbid1,$app_type_id,$cat3_id,$sla_status_2);
			
		
			$sql->execute();
			$rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc())
			{
			    $data[$row['ward_id']]['pending_beyond_sla']+=$row['pending_beyond_sla'];
			    $tot['pending_beyond_sla']+=$row['pending_beyond_sla'];
			}
				
	        $grievance_status_id_6 =6;
			
		    $sql = $conn->prepare("SELECT COUNT(grievance_id) as fin_implication,ward_id from grievances where grievance_status_id =? and ulbid=? and app_type_id=? and cat3_id !=? group by ward_id");
			$sql->bind_param("isii",$grievance_status_id_6,$ulbid1,$app_type_id,$cat3_id);
			       
	        $sql->execute();
			$rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc())
			{
				 $data[$row['ward_id']]['fin_implication']+=$row['fin_implication'];
				 $tot['fin_implication']+=$row['fin_implication'];
			}
			
			
			
			
		  	$grievance_status_id_1 =1;
			
		   $sql = $conn->prepare("SELECT COUNT(grievance_id) as pending_apprvl,ward_id from grievances where grievance_status_id =? and ulbid=? and 
	         app_type_id=? and cat3_id !=? group by ward_id");
			$sql->bind_param("isii",$grievance_status_id_1,$ulbid1,$app_type_id,$cat3_id);
			
	         
	        $sql->execute();
			$rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc())           
	       
			{
				 $data[$row['ward_id']]['pending_apprvl']+=$row['pending_apprvl'];
				 $tot['pending_apprvl']+=$row['pending_apprvl'];
			}
			
			
				$grievance_status_id_10 =10;
			
		   $sql = $conn->prepare("SELECT COUNT(grievance_id) as rejected,ward_id from grievances where grievance_status_id =? and ulbid=? and app_type_id=? and 
			 cat3_id !=? group by ward_id");
			$sql->bind_param("isii",$grievance_status_id_10,$ulbid1,$app_type_id,$cat3_id);
			
			$sql->execute();
			$rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc()) 
			{
				 $data[$row['ward_id']]['rejected']+=$row['rejected'];
				 $tot['rejected']+=$row['rejected'];
			}
			
			
			
			
				$grievance_status_id_4 =4;
			
		   $sql = $conn->prepare("SELECT COUNT(grievance_id) as unresolved,ward_id  from grievances where grievance_status_id =? and ulbid=? and app_type_id=? 
			and cat3_id !=? group by ward_id");
			$sql->bind_param("isii",$grievance_status_id_4,$ulbid1,$app_type_id,$cat3_id);
			
			$sql->execute();
			$rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc()) 
			{
				 $data[$row['ward_id']]['unresolved']+=$row['unresolved'];
				 $tot['unresolved']+=$row['unresolved'];
			}
			
			
			 $sql = $conn->prepare("select * from ulbmst");
					$sql->execute();
			    $rs=$sql->get_result();
				
				while($row = $rs->fetch_assoc())
				{
				    $ulb_list[$row['ulbid']]=$row['ulbname'];
				}
				
		         $sql = $conn->prepare("select * from ward_mst where ulbid=? order by ward_id");
			     $sql->bind_param("s",$ulbid1);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc()) 
				
				{
				    $ward_list[$row['ward_id']]=$row['ward_desc'];
				}
				
			
    		$sql = $conn->prepare("select cs_id,comp_desc as cs_desc from category3_mst where ulbid=?");
			     $sql->bind_param("s",$ulbid1);
		    	
				$sql->execute();
			    $rs=$sql->get_result();
			
			while($row = $rs->fetch_assoc()) 
    		{
    		
    				    
    				    
    				    $total[$row['cs_id']]['tot_resolved']=$data[$row['cs_id']]['resolved_within_sla']+$data[$row['cs_id']]['resolved_beyond_sla'];
    				    $data[$row['cs_id']]['percent']=number_format(($total[$row['cs_id']]['tot_resolved']/$data[$row['cs_id']]['total_received'])*100,2);
    		}
    		
    				$tot['resolved']=$tot['resolved_within_sla']+$tot['resolved_beyond_sla'];
    				$tot['percent']=number_format(($tot['resolved']/$tot['total_received'])*100,2);
    				
    				
    				
    			
    			$sql = $conn->prepare("select cat_id,description from category_mst");
    				$sql->execute();
			    $rs=$sql->get_result();
			
				while($row = $rs->fetch_assoc())
				{
				    $cat_list[$row['cat_id']]=$row['description'];
				}
		
				
		
				 
				 
				$sql->close();
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
		$tpl->display('ward_wise_service_rep.tpl');
	}
	else
	{
		
		
		
		echo "<script>window.location='index.php';</script>";
		
		
	}
?>